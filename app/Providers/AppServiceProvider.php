<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
		\App\Models\Comment::observe(\App\Observers\CommentObserver::class);
		\App\Models\Article::observe(\App\Observers\ArticleObserver::class);
		\App\Models\Chapter::observe(\App\Observers\ChapterObserver::class);
		\App\Models\Course::observe(\App\Observers\CourseObserver::class);
		\App\Models\Teacher::observe(\App\Observers\TeacherObserver::class);
		\App\Models\Material::observe(\App\Observers\MaterialObserver::class);
		\App\Models\CompanyPost::observe(\App\Observers\CompanyPostObserver::class);

        //
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
