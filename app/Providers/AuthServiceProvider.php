<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use App\Models\Role;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
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
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(60));

        if (Schema::hasTable('roles')) {
            $roles = array_pluck(Role::all(), 'description', 'name');

            Passport::tokensCan($roles);
        } else {
            Passport::tokensCan(
                [
                    'Super Usuário' => 'Gerência usuários com papel Administrador',
                    'Administrador' => 'Gerência usuários com papel Gerente',
                    'Gerente' => 'Acessa relatórios gerenciais da aplicação',
                    'Usuário' => 'Usuário do serviço'
                ]
            );
        }
    }
}
