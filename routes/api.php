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

/**
 * Retorna o usuário
 */
Route::middleware('auth:api')
	->get('/user', function (Request $request) {
		return $request->user();
	});

/**
 * Registra um usuário
 */
Route::namespace('Api')->group(function () {
	Route::post('/usuarios/registrar', 'UserController@register')
		->name('api.usuarios.register');
});

/**
 * CRUD - Veiculos
 */
Route::middleware('auth:api')->namespace('Api')->group(function () {
	Route::get('/veiculos', 'VeiculoController@index')
		->name('api.veiculo.list')
		->middleware('scope:administrador,usuario');
	Route::get('/veiculos?page(page)&qtd(qtd)', 'VeiculoController@index')
		->name('api.veiculo.list-page')
		->middleware('scope:administrador,usuario');
	Route::get('/veiculos/{id}', 'VeiculoController@show')
		->name('api.veiculo.show')
		->middleware('scope:administrador,usuario');
	Route::post('/veiculos', 'VeiculoController@store')
		->name('api.veiculo.store')
		->middleware('scope:administrador');
	Route::put('/veiculos/{id}', 'VeiculoController@update')
		->name('api.veiculo.update')
		->middleware('scope:administrador');
	Route::delete('/veiculos/{id}', 'VeiculoController@destroy')
		->name('api.veiculo.destroy')
		->middleware('scope:administrador');
});
