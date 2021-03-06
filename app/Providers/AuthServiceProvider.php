<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		 \App\Models\Shop::class => \App\Policies\ShopPolicy::class,
		 \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
		 \App\Models\Article::class => \App\Policies\ArticlePolicy::class,
		 \App\Models\Chapter::class => \App\Policies\ChapterPolicy::class,
		 \App\Models\Course::class => \App\Policies\CoursePolicy::class,
		 \App\Models\Teacher::class => \App\Policies\TeacherPolicy::class,
		 \App\Models\Material::class => \App\Policies\MaterialPolicy::class,
		 \App\Models\CompanyPost::class => \App\Policies\CompanyPostPolicy::class,
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
