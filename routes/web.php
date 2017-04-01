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
Route::get('/logout', 'HomeController@logout');
Route::get('/newAccount', function() {
   return view('auth/register');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'CheckAdmin']], function() {
    Route::get('/', 'AdminController@index');
    Route::get('/newForm', 'AdminController@newForm');
    Route::get('/edit/{id}', 'AdminController@editForm');

    Route::post('/newForm', 'AdminController@createForm');
    Route::post('/setActiveForm', 'AdminController@setActiveForm');
    Route::post('/saveFormChanges', 'AdminController@saveFormChanges');

    /*
     * Grading routes
     */
    Route::get('/grading', 'GradingController@home');
    Route::get('/grading/{id}', 'GradingController@gradeForm');

    Route::post('/markCorrect', 'GradingController@markCorrect');
    Route::post('/markWrong', 'GradingController@markWrong');
    Route::post('/markNotable', 'GradingController@markNotable');
});

Route::group(['prefix' => 'trivia', 'middleware' => ['auth']], function() {
    Route::get('/current', 'TriviaController@getCurrentForm');
    Route::post('/submitAnswer', 'TriviaController@submitAnswer');
});

/*
 * Errors
 */
Route::get('/unauthorized', function() {
    return view('errors/unauthorized');
});

Auth::routes();

