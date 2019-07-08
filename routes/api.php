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

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\v1'], function ($api) {
    //返回分类列表
    $api->get('categories', 'CategoryController@index')->name('api.categories.index');
    //返回标签列表
    $api->get('tags', 'TagController@index')->name('api.tags.index');
    //返回公司简介列表
    $api->resource('company_posts', 'CompanyPostsController', ['only' => ['index', 'show']]);
});
