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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::namespace('Api')->group(function () {
    Route::post('login', 'AuthController@login')->name('api.login');
    Route::post('register', 'AuthController@register')->name('api.register');
    Route::get('activation-user/{token}', 'AuthController@activationUser')->name('api.activationUser');
    Route::post('login-refresh', 'AuthController@loginRefresh')->name('api.login.refresh');
});

Route::middleware('auth:api')->namespace('Api')->group(function () {
    Route::apiResource('users', 'UserController')->middleware('scopes:Administrador');
    Route::apiResource('roles', 'RoleController')->middleware('scopes:Administrador');
    Route::apiResource('permissions', 'PermissionController')->middleware('scopes:Administrador');
    Route::apiResource('categories', 'CategoryController')->middleware('scopes:Usuário');
    Route::apiResource('accounts', 'AccountController')->middleware('scopes:Usuário');
    Route::apiResource('transactions', 'TransactionController')->middleware('scopes:Usuário');
    Route::get('user', function (Request $request) {
        return $request->user();
    })->name('user.show');
    Route::get('logout', 'AuthController@logout')->name('api.logout');
});
