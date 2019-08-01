<?php

namespace App\Providers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\ServiceProvider;
use Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		\App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Shop::observe(\App\Observers\ShopObserver::class);
		\App\Models\Comment::observe(\App\Observers\CommentObserver::class);
		\App\Models\Article::observe(\App\Observers\ArticleObserver::class);
		\App\Models\Chapter::observe(\App\Observers\ChapterObserver::class);
		\App\Models\Course::observe(\App\Observers\CourseObserver::class);
		\App\Models\Teacher::observe(\App\Observers\TeacherObserver::class);
		\App\Models\Material::observe(\App\Observers\MaterialObserver::class);
		\App\Models\CompanyPost::observe(\App\Observers\CompanyPostObserver::class);
        app('Dingo\Api\Exception\Handler')->register(function (\Dingo\Api\Exception\ResourceException $exception) {
            return \Illuminate\Support\Facades\Response::make([
                'message' => $exception->getErrors()->getMessageBag()->first(),
                'errors' => $exception->getErrors(),
                'status_code' => $exception->getStatusCode(),
            ], $exception->getStatusCode());
        });

        app('Dingo\Api\Exception\Handler')->register(function (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $exception) {
            return \Illuminate\Support\Facades\Response::make([
                'message' => '没有权限访问',
                'status_code' => $exception->getStatusCode(),
            ],$exception->getStatusCode());
        });


        app('Dingo\Api\Exception\Handler')->register(function (\Dingo\Api\Exception\RateLimitExceededException $exception) {
            return \Illuminate\Support\Facades\Response::make([
                'message' => '请求次数过多，请稍后再试',
                'status_code' => $exception->getStatusCode(),
            ],$exception->getStatusCode());
        });

        //policy 鉴权失败
        $this->app->make('api.exception')->register(function (AuthorizationException $e) {
            abort(400, "用户没有权限操作");
        });
	}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
