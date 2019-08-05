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
Route::resource('umat', 'Api\UmatController');
Route::get('dashboard', 'Api\DashboardController@index');
Route::get('wilayah', 'Api\DashboardController@getWilayah');
Route::get('ekonomi', 'Api\UmatController@ajax');
Route::get('current-ekonomi', 'Api\UmatController@currentEconomyGraph');

Route::get('perkawinan', 'Api\StatusPerkawinanController@ajax');
Route::get('current-perkawinan', 'Api\StatusPerkawinanController@currentPerkawinanGraph');



Route::get('current-card', 'Api\UmatController@card');