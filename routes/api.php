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
    Route::post('login', 'LoginController@login')->name('api.login');
    Route::post('register', 'LoginController@register')->name('api.register');
    Route::post('login-refresh', 'LoginController@loginRefresh')->name('api.login.refresh');
});

Route::middleware('auth:api')->namespace('Api')->group(function () {
    Route::apiResource('users', 'UserController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('permissions', 'PermissionController');
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('accounts', 'AccountController');
    Route::apiResource('transactions', 'TransactionController');
    Route::get('user', function (Request $request) {
        return $request->user();
    })->name('user.show');
    Route::get('logout', 'LoginController@logout')->name('api.logout');
});
