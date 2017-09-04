<?php

namespace Lar\Providers;

//use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Gate;
use Lar\Policies\ArticlePolicy;
use Lar\Article;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'Lar\Model' => 'Lar\Policies\ModelPolicy',
        Article::class => ArticlePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW_ADMIN', function ($user) {
            return $user->canDo('VIEW_ADMIN', FALSE);
        });

        Gate::define('VIEW_ADMIN_ARTICLES', function ($user) {
            return $user->canDo('VIEW_ADMIN_ARTICLES', FALSE);
        });

        //
    }
}
