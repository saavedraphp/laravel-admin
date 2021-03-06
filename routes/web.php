<?php

//use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//Route::get('/usuarios', 'UsuarioController@index');
Route::resource('usuarios', 'UsuarioController');

Route::get('estados/pais/', 'UsuarioController@getEstadosByPais');
Route::get('ciudades/estado/', 'UsuarioController@getCiudadesByEstado');