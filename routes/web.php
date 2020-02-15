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
Route::get('/enterprise/revision', 'EnterpriseController@revisions')->name('enterprise.revisions')->middleware('auth');
Route::get('/enterprise', 'EnterpriseController@index')->name('enterprise.index')->middleware('auth');
Route::get('/enterprise/list', 'EnterpriseController@list')->name('enterprise.list')->middleware('auth');
Route::get('/report/list', 'ReportController@list')->name('report.list')->middleware('auth');
Route::get('/report/export', 'ReportController@export')->name('report.export')->middleware('auth');
Route::post('/enterprise/my', 'EnterpriseController@apply')->name('enterprise.post')->middleware('auth');
Route::post('/enterprise/{id}', 'EnterpriseController@audit')->where('id', '[0-9]+')->name('enterprise.audit')->middleware('auth');
Route::post('/password/change', 'UserController@changePassword')->name('user.changePassword')->middleware('auth');
Route::get('/password/change', 'UserController@change')->name('user.change')->middleware('auth');
Route::get('/employee/export', 'EmployeeController@export')->name('employee.export')->middleware('auth');

Route::group(['prefix'=> 'company', 'middleware' => 'auth'], function(){
    Route::get('/index', 'CompanyController@index')->name('company');
    Route::get('/edit', 'CompanyController@edit')->name('company.edit');
    Route::put('/update', 'CompanyController@update')->name('company.update');
});

Route::group(['prefix'=>'statistical', 'middleware'=> 'auth'], function(){
    Route::get('/', 'StatisticalController@index')->name('statistical');
    Route::get('/data', 'StatisticalController@statisticalData');
    Route::get('/register', 'StatisticalController@register');
    Route::get('/company', 'StatisticalController@company');
    Route::get('/fetchIndustry', 'StatisticalController@industry');
});
