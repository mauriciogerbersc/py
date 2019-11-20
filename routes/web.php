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

Route::get('/', function () {
    return view('index');
});


Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin.dashboard');

Route::get('/admin/login', 'Auth\AdminLoginController@index')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

Route::get('/propostas', 'PropostasController@index');
Route::get('/propostas/nova/{id}', 'PropostasController@create');
Route::post('/propostas/nova/{id}', 'PropostasController@store');
Route::get('/propostas/visualizar/{id}', 'PropostasController@show');

Route::get('/clientes', 'ClienteController@index')->name('clientes');
Route::get('/clientes/cadastro', 'ClienteController@create');
Route::post('/clientes/cadastro', 'ClienteController@store');


Route::get('/variaveis', 'VariaveisController@index');
Route::get('/variaveis/nova', 'VariaveisController@create');
Route::post('/variaveis/nova', 'VariaveisController@store');
Route::get('/variaveis/editar/{id}', 'VariaveisController@edit');
Route::post('/variaveis/editar/{id}', 'VariaveisController@update');
Route::get('/variaveis/remover/{id}', 'VariaveisController@destroy');

Route::get('/variaveis/categorias', 'VariaveisCategoriasController@index');
Route::get('/variaveis/categorias/nova', 'VariaveisCategoriasController@create');
Route::post('/variaveis/categorias/nova', 'VariaveisCategoriasController@store');
Route::get('/variaveis/categorias/editar/{id}', 'VariaveisCategoriasController@edit');
Route::post('/variaveis/categorias/editar/{id}', 'VariaveisCategoriasController@update');
Route::get('/variaveis/categorias/remover/{id}', 'VariaveisCategoriasController@destroy');

/*categoria de vaga */
Route::get('/vagas/nova', 'VagasController@create');

/*Sub categoria de vaga */
Route::post('/vagas/nova_subcategoria', 'VagasController@storeSub');
Route::get('/vagas/subcategorias', 'VagasController@indexSubCategorias');
Route::get('/vagas/subcategorias/editar/{id}', 'VagasController@editarSubCategoria');
Route::post('/vagas/subcategorias/editar/{id}', 'VagasController@updateSubCategoria');
Route::get('/vagas/subcategorias/remover/{id}', 'VagasController@removerSubCategoria');

Route::get('/home', 'HomeController@index')->name('home');
