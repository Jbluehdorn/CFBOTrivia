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

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index');
    Route::get('/newForm', 'AdminController@newForm');
    Route::get('/edit/{id}', 'AdminController@editForm');

    Route::post('/newForm', 'AdminController@createForm');
    Route::post('/setActiveForm', 'AdminController@setActiveForm');
});

Auth::routes();

