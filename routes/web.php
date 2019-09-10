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
    return view('welcome');
});

Auth::routes();

//Route::middleware(['auth', 'request'])->group(function () {   
Route::middleware(['auth'])->group(function () {    
    Route::get('/home', 'HomeController@index')->name('home');    

    //Rutas de servicios
    Route::get('/servicios/administrador', 'ServicioController@index_administrador');
    Route::post('/servicio/crear/actualizar', 'ServicioController@crearOactualizar');
    Route::post('/servicio/activar/desactivar', 'ServicioController@activarOdesactivar');

    //Rutas de productos
    Route::get('/servicio/{id}', 'ProductoController@index_administrador');
    Route::post('/producto/crear/actualizar', 'ProductoController@crearOactualizar');
    Route::post('/producto/eliminar', 'ProductoController@eliminar');
});