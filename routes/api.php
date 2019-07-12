<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\v1',
    'middleware' => ['bindings', 'serializer:array']
], function ($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 10,
        'expires' => 2
    ], function ($api) {
        //发送验证码
        $api->post('verification_codes', 'VerificationCodesController@store');
        //用户注册
        $api->resource('users', 'UsersController', ['only' => ['store']]);
        //第三方授权登陆
        $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore');
        //手机号密码登陆
        $api->post('authorizations', 'AuthorizationsController@store');
        //刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update');
        //删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destory');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 100,
        'expires' => 1
    ], function ($api) {
        //返回分类列表
        $api->get('company_categories', 'CompanyCategoryController@index')->name('company_categories.index');
        //返回标签列表
        $api->get('tags', 'TagController@index')->name('tags.index');
        //返回公司简介列表
        $api->resource('company_posts', 'CompanyPostsController', ['only' => ['index', 'show']]);
        //最新资讯
        $api->resource('news', 'NewsController', ['only' => ['index', 'show']]);
        //平台素材库分类
        $api->get('material_categories', 'MaterialCategoryController@index')->name('material_categories.index');
        //平台素材库
        $api->resource('materials', 'MaterialsController', ['only' => ['index', 'show']]);
        //banner轮播图
        $api->get('banners', 'BannerController@index');
        //讲师相关
        $api->resource('teachers', 'TeachersController', ['only' => ['show']]);
        //返回课程分类列表
        $api->get('course_categories', 'CourseCategoryController@index');
        //课程列表
        $api->resource('courses', 'CoursesController', ['only' => ['index', 'show']]);
        $api->resource('chapters', 'ChaptersController', ['only' => ['show']]);
    });

    $api->group([
        'middleware' => 'api.auth',
        'limit' => 100,
        'expires' => 1,
    ], function ($api) {
        //当前用户数据
        $api->get('user', 'UsersController@me');
        //修改用户信息
        $api->patch('user', 'UsersController@update');
        //上传媒体文件
        $api->post('media/{type}', 'MediaController@store');

    });
});
