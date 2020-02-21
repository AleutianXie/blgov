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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/summary', 'GovController@summary');
Route::get('/back', 'GovController@back');
Route::get('/touch', 'GovController@touch');
//Route::get('/quarantine', 'GovController@quarantine');
Route::get('/medical', 'GovController@medical');
Route::get('/industry', 'StatisticalController@industry');
Route::get('/cockpit', 'StatisticalController@cockpit');
