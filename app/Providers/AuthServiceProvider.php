<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
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

        Passport::routes(function ($router) {
            $router->forAccessTokens();
            // $router->forPersonalAccessTokens();
            // $router->forTransientTokens();
        });
        // Passport::tokensExpireIn(now()->addDays(15));
        // Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::tokensExpireIn(Carbon::now()->addMinutes(3));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::tokensCan([
            'users-list' => 'Lista os usuários',
            'users-destroy' => 'Exclui os usuários',
        ]);
    }
}
