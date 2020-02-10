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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/enterprise/{id}', 'EnterpriseController@detail')->where('id', '[0-9]+')->name('enterprise.detail')->middleware('auth');
Route::get('/enterprise/my', 'EnterpriseController@my')->name('enterprise.my')->middleware('auth');
Route::get('/enterprise', 'EnterpriseController@index')->name('enterprise.index')->middleware('auth');
Route::get('/enterprise/list', 'EnterpriseController@list')->name('enterprise.index')->middleware('auth');
Route::post('/enterprise/my', 'EnterpriseController@apply')->name('enterprise.post')->middleware('auth');
