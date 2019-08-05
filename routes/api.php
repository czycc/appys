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
    'middleware' => ['bindings']
], function ($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 2,
        'expires' => 1
    ], function ($api) {
        //发送验证码
        $api->post('verification_codes/{type}', 'VerificationCodesController@store');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 100,
        'expires' => 2
    ], function ($api) {
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
        $api->get('home', 'ConfigureController@home');

        //阿里支付通知
        $api->post('pay/alipay/notify', 'PayController@alipayNotify');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 100,
        'expires' => 1
    ], function ($api) {
        //返回分类列表
        $api->get('company_categories', 'CompanyCategoryController@index')->name('company_categories.index');
        //返回标签列表
        $api->resource('tags', 'TagController', ['only' => ['index', 'show']]);
        //返回公司简介列表
        $api->resource('company_posts', 'CompanyPostsController', ['only' => ['index', 'show']]);
        //最新资讯
        $api->resource('news', 'NewsController', ['only' => ['index', 'show']]);
        //平台素材库分类
        $api->get('material_categories', 'MaterialCategoryController@index')->name('material_categories.index');
        //平台素材库
        $api->resource('materials', 'MaterialsController', ['only' => ['index', 'show']]);

        /* 首页配置 */
        //banner轮播图
        $api->get('banners', 'BannerController@index');
        //首页菜单栏名称
        $api->get('menu', 'ConfigureController@menu');
        //用户发布文章可选价格
        $api->get('price/article', 'ConfigureController@articlePrice');



    });

    $api->group([
        'middleware' => 'api.auth',
        'limit' => 100,
        'expires' => 1,
    ], function ($api) {
        //讲师相关
        $api->resource('teachers', 'TeachersController', ['only' => ['show']]);
        //返回课程分类列表
        $api->get('course_categories', 'CourseCategoryController@index');
        //课程列表
        $api->resource('courses', 'CoursesController', ['only' => ['index', 'show']]);
        $api->resource('chapters', 'ChaptersController', ['only' => ['show']]);

        //当前用户数据
        $api->get('user', 'UsersController@me');
        //按id查询用户信息
        $api->get('user/{user}', 'UsersController@show');
        //修改用户信息
        $api->patch('user', 'UsersController@update');
        //返回我的团队
        $api->get('team', 'UsersController@team');
        //上传媒体文件
        $api->post('media/{type}', 'MediaController@store');
        //当前用户会员价格
        $api->get('vip/price', 'VipController@price');
        //用户文章
        $api->resource('articles', 'ArticlesController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        //用户评论
        $api->resource('comments', 'CommentsController', ['only' => ['index', 'store']]);
        //回复评论
        $api->post('reply/comment', 'CommentsController@reply');

        //店铺相关
        $api->resource('shops', 'ShopsController', ['only' => ['index','store', 'update']]);
        //用户关注
        $api->post('follow', 'FollowController@store');
        $api->get('follow/{user}/type/{type}', 'FollowController@show');

        //用户点赞
        $api->post('zan', 'ZanController@store');

        //用户扫码绑定上级id
        $api->post('user/bound/scan', 'UsersController@boundFormScan');
        $api->post('user/bound/confirm/{notify}', 'UsersController@ScanConfirm');

        //用户留言功能
        $api->post('guest_book', 'GuestBookController@store');
        $api->get('guest_book/{user}', 'GuestBookController@show');

        //后台铜币比例
        $api->get('configure/copper', 'PayController@copper');

        /* 支付相关 */
        //下订单
        $api->post('orders', 'OrderController@store');
        //查询订单
        $api->get('orders', 'OrderController@index');

        //通知列表
        $api->get('notifications', 'NotificationController@index');

        //流水
        $api->get('flows', 'FlowController@index');
        $api->get('out/flows', 'FlowController@flowOutList');
        $api->post('out/flows', 'FlowController@flowOutStore');

    });});

