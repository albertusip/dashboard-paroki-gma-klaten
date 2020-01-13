<?php

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

/**
 * Authentication Routes.
 */
Route::group(['middleware' => 'api', 'prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');

//    Route::patch('/update-password', 'JWTAuthController@updatePassword');
});

Route::resource('umat', 'Api\StatusEkonomiController');
Route::get('wilayah', 'Api\DashboardController@getWilayah');
Route::get('dateUpdated', 'Api\RecapDateInfoController@dateUpdated');
Route::get('ekonomi', 'Api\StatusEkonomiController@ajax');

Route::get('perkawinan', 'Api\StatusPerkawinanController@ajax');
Route::get('current-perkawinan', 'Api\StatusPerkawinanController@currentPerkawinanGraph');

Route::get('kesehatan', 'Api\StatusKesehatanController@ajax');

Route::get('baptis', 'Api\StatusBaptisController@ajax');

Route::get('card-total-info', 'Api\DashboardController@card');
Route::get('recap', 'Api\RecapController@index');

Route::get('yearly-data', 'Api\AllYearlyDataController@ajax');
