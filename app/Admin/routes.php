<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    //文章可用价格
    $router->resource('article_prices', ArticlePriceController::class);

    //首页banner图
    $router->resource('home_banners', HomeBannerController::class);

    //标签管理
    $router->resource('tags', TagsController::class);

    //教师管理
    $router->resource('admin_teachers', TeachersController::class)->names('admin_teachers');

    //公司文章
    $router->resource('admin_posts', PostController::class);

    //公司文章类别
    $router->resource('admin_categories', CategoryController::class);

    //用户管理
    $router->resource('admin_users', UserController::class);

    //店铺管理
    $router->resource('admin_shops', ShopController::class);

    //用户作品管理
    $router->resource('admin_articles', ArticleController::class);

    //留言管理
    $router->resource('admin_guest_books', GuestBookController::class);

    //评论管理
    $router->resource('admin_comments', CommentController::class);

    //订单管理
    $router->resource('admin_orders', OrderController::class);

    //课程管理
    $router->resource('admin_courses', CourseController::class);

    //课程章节管理
    $router->resource('admin_chapters', ChapterController::class);

    //课程分类
    $router->resource('course_categories', CourseCategoryController::class);

    //提现管理
    $router->resource('admin_flow_outs', FlowController::class);

    //平台设置
    $router->get('settings', 'SettingsController@index');

});
