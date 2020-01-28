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

Route::get('/propostas/{id?}', 'PropostasController@index');
Route::get('/propostas/gerarProposta/{id}', 'PropostasController@gerarProposta');

Route::post('/propostas/nova/{id}', 'PropostasController@store');


Route::get('/propostas/nova/{id}', 'PropostasController@create');
Route::get('/propostas/old/{id}', 'PropostasController@createOld');
Route::get('/propostas/visualizar/{id}', 'PropostasController@show');
Route::get('/propostas/visualizarBasic/{id}', 'PropostasController@showBasic');
Route::get('/propostas/editar/{id}', 'PropostasController@edit');
Route::get('/propostas/atualizaStatus', 'PropostasController@atualizaStatus');
Route::post('/propostas/atualizaStatus', 'PropostasController@atualizaStatusPost');
Route::get('/propostas/saveServerSide', 'PropostasController@saveServerSide');
Route::post('/propostas/saveServerSide', 'PropostasController@saveServerSidePost');

Route::get('/clientes', 'ClienteController@index')->name('clientes');
Route::get('/clientes/cadastro', 'ClienteController@create');
Route::post('/clientes/cadastro', 'ClienteController@store');
Route::get('/clientes/editar/{id}', 'ClienteController@edit');
Route::post('/clientes/editar/{id}', 'ClienteController@update');


Route::get('/variaveis/listar/{id?}', 'VariaveisController@index');
Route::get('/variaveis/salvaOrdem', 'VariaveisController@salvaOrdem');
Route::post('/variaveis/salvaOrdem', 'VariaveisController@salvaOrdemPost');
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

Route::get('/variaveis/subcategorias', 'VariaveisCategoriasController@subcategoriaIndex');
Route::get('/variaveis/subcategorias/nova/{tipo}', 'VariaveisCategoriasController@subCategoriaNova');
Route::get('/variaveis/subcategorias/editar/{id}', 'VariaveisCategoriasController@editCategoriaNova');
Route::get('/variaveis/subcategorias/visualizar/{id}', 'VariaveisCategoriasController@visualizar');
Route::get('/variaveis/subcategorias/remover/{id}', 'VariaveisCategoriasController@removeCategoriaNova');
Route::post('/variaveis/subcategorias/nova', 'VariaveisCategoriasController@storeSubCategoriaNova');
Route::post('/variaveis/subcategorias/editar/{id}', 'VariaveisCategoriasController@saveCategoriaNova');
/*categoria de vaga */
Route::get('/vagas/nova', 'VagasController@create');

/*Sub categoria de vaga */
Route::post('/vagas/nova_subcategoria', 'VagasController@storeSub');
Route::get('/vagas/subcategorias', 'VagasController@indexSubCategorias');
Route::get('/vagas/subcategorias/editar/{id}', 'VagasController@editarSubCategoria');
Route::post('/vagas/subcategorias/editar/{id}', 'VagasController@updateSubCategoria');
Route::get('/vagas/subcategorias/remover/{id}', 'VagasController@removerSubCategoria');

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/provisao/produtos', 'ProvisaoController@index');
Route::get('/provisao/novoProduto', 'ProvisaoController@create');
Route::post('/provisao/novoProduto', 'ProvisaoController@store');
Route::get('/provisao/editar/{id}', 'ProvisaoController@edit');
Route::post('/provisao/editar/{id}', 'ProvisaoController@update');



Route::get('/configuracao', 'ConfiguracaoController@index');
Route::get('/configuracao/nova', 'ConfiguracaoController@create');
Route::get('/configuracao/editar/{id}', 'ConfiguracaoController@edit');
Route::post('/configuracao/nova', 'ConfiguracaoController@store');
Route::post('/configuracao/editar/{id}', 'ConfiguracaoController@update');

Route::get('/configuracao/remover/{id}', 'ConfiguracaoController@destroy');

Route::get('/configuracao/regras', 'ConfiguracaoController@regras');
Route::get('/configuracao/regras/criar', 'ConfiguracaoController@criarRegra');
Route::get('/configuracao/regras/editar/{id}', 'ConfiguracaoController@editarRegra');

Route::post('/configuracao/regras/criar', 'ConfiguracaoController@storeRegra');
Route::post('/configuracao/regras/editar/{id}', 'ConfiguracaoController@salvarRegra');