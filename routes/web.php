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


Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/codes/{area_code?}/{page?}', 'HomeController@AreaCode');
Route::get('/code/{area_code?}/{sub_code?}/{page?}', 'HomeController@Code');
Route::get('/number/{number?}', 'HomeController@SinglePhone');
Route::post('/number/{number?}', 'HomeController@SinglePhone');
Route::get('/city/{city?}/{page?}', 'HomeController@City')->where( 'city', '[a-zA-Z0-9_\']+' );
Route::get('/citys/{page?}', 'HomeController@Citys');
Route::get('/province/{province?}', 'HomeController@province')->where( 'province', '[a-zA-Z0-9_\']+' );
Route::get('/privacy', 'HomeController@privacy');
//Route::get('/test', 'HomeController@test');

Route::group( [ 'prefix' => 'admin', 'middleware' => 'auth' ], function () {
	Route::get( '/', 'AdminController@index' );
	Route::get( '/confirmed/{id}', 'AdminController@confirmed' )->where( 'id', '[0-9]+' );
	Route::get( '/delated/{id}', 'AdminController@delated' )->where( 'id', '[0-9]+' );

	//  Settings
	Route::get( '/settings', 'SettingsController@index' );
	Route::post( '/settings', 'SettingsController@Save' );
	Route::get( '/settings/ResetPassword', 'SettingsController@ResetPassword' );
});

// TODO Сделать допустимые значения переменных