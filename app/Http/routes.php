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

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
Route::get('/login', ['uses' => 'Auth\\EveSsoController@login', 'as' => 'auth.login']);
Route::get('/logout', ['uses' => 'Auth\\EveSsoController@logout', 'as' => 'auth.logout']);
Route::get('/auth/sso', ['uses' => 'Auth\\EveSsoController@callback', 'as' => 'auth.callback']);


Route::group(['middleware' => ['auth']], function () {
    Route::post('/signatures/update', ['uses' => 'SignatureController@updateSigs', 'as' => 'sig.update']);

    Route::get('/signatures/getLastUpdateTime', ['uses' => 'SignatureController@getLastUpdateTime', 'as' => 'sig.lastUpdate']);
    Route::get('/signatures/getUpdatedTables', ['uses' => 'SignatureController@getUpdatedTables', 'as' => 'sig.getUpdatedTables']);

});