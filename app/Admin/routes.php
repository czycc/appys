<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    //平台配置
    $router->resource('configures', ConfigureController::class, ['only' => ['index', 'show', 'edit', 'update']]);

    //文章可用价格
    $router->resource('article_prices', ArticlePriceController::class);

    $router->resource('home_banners', HomeBannerController::class);

});
