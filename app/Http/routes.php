<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function() {
    // Utenti
    Route::resource('users', 'UsersController', ['only' => ['store']]); //UC1
    Route::get('/users/criterion/{criterion}', ['uses' =>'UsersController@getUsersByCriterion']); //UC10
    Route::get('/users/timeRange/{timeRange}', ['uses' =>'UsersController@getUsersByTimeRange']); //UC6

    // Bottoni
    Route::resource('buttons', 'ButtonsController', ['only' => ['index', 'store']]); //UC2, UC8

    // Pagine
    Route::resource('pages', 'PagesController', ['only' => ['index', 'store']]); //UC3, UC9
    Route::get('/exitPages', 'PagesController@getExitPages'); //UC17
    Route::get('/pagesAverageLoadingTime', 'PagesController@getPagesAverageLoadingTime'); //UC13

    // Termini di ricerca
    Route::resource('searchTerms', 'SearchTermsController', ['only' => ['index', 'store']]); //UC5, UC15

    // Cammini
    Route::resource('paths', 'PathsController', ['only' => ['store']]); //UC17

    // Sessioni attive
    Route::resource('activeSessions', 'ActiveSessionsController', ['only' => ['index', 'store', 'update']]); //UC7, UC11
    Route::get('/createSession', 'ActiveSessionsController@createSession');

    // Statistiche
    Route::get('/averageSessionTime', 'StatisticsController@getAverageSessionTime'); //UC11
    Route::get('/bounceRate', 'StatisticsController@getBounceRate'); //UC12
    Route::get('/averageLoadingTime', 'StatisticsController@getAverageLoadingTime'); //UC14
    Route::get('/pagesPerSession', 'StatisticsController@getPagesPerSession'); //UC18
});
