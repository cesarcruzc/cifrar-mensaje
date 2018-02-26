<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->prefix('mensaje')->group(function () {
    Route::post('cifrar', 'MensajeController@cifrar')->name('mensaje.cifrar');
    Route::get('descargar/{archivo}', 'MensajeController@descargarArchivo')->name('mensaje.descargar');
    Route::post('desifrar', 'MensajeController@descifrar')->name('mensaje.descifrar');
});




