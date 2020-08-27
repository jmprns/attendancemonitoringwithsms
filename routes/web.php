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
    return redirect('/dashboard');
});

Auth::routes();

Route::get('/home', function () {
    return redirect('/dashboard');
});


Route::get('/dashboard', 'DashboardController@index');

Route::prefix('student')->group(function (){
	Route::get('/', 'StudentController@index');
	Route::get('/register', 'StudentController@create');
	Route::get('/edit/{id}', 'StudentController@edit');
	Route::post('/store', 'StudentController@store');
	Route::post('/update', 'StudentController@update');
	Route::get('/delete/{id}', 'StudentController@destroy');
	Route::post('/delete', 'StudentController@delete');
});

Route::prefix('attendance')->group(function() {
	Route::get('/', 'AttendanceController@index');

	Route::prefix('events')->group(function(){
		Route::get('/', 'EventController@index');
		Route::post('/store', 'EventController@store');
		Route::post('/update', 'EventController@update');
		Route::get('/show/{id}', 'EventController@show');
		Route::get('/delete/{id}', 'EventController@destroy');
	});
	

});

Route::prefix('settings')->group(function(){
	Route::get('/profile', 'SettingsController@profile');
	Route::post('/profile', 'SettingsController@update');
	Route::post('/profile/password', 'SettingsController@password');

	Route::get('/add-admin', 'SettingsController@add');
	Route::post('/store', 'SettingsController@store');
});


Route::prefix('scan')->group(function(){
	Route::post('/', 'ScanController@scan');
	Route::get('/regular', 'ScanController@regular');
	Route::get('/event/{id}', 'ScanController@event');
});

Route::prefix('sms')->group(function(){
	Route::get('/server', 'SMSController@server');
	Route::get('/count', 'SMSController@count');
});
