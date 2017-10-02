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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getFormQuestions/{formId}', 'TriviaController@getQuestions');
Route::get('/getTopScoreAmount', function() {
  return config('trivia.top_scores_per_season');
});

Route::get('/reports/{seasonId}', 'AdminController@getReports');
Route::get('/seasons', 'AdminController@getSeasons');
