<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'InstanciaController@index');
Route::get('/home', 'InstanciaController@index');

//INSTÂNCIA CRUD
Route::post('/instancias/excluir_instancia', 'InstanciaController@excluir_instancia');
Route::get('/instancias/listar_instancias', 'InstanciaController@listar_instancias');
Route::resources([
	'/instancias' => 'InstanciaController',
	'/admin'	 => 'AdminController'
]);
