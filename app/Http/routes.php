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


Route::get('rozcesti'     , 'RozcestiController@rozcesti');
Route::post('pracovniVykaz', 'RozcestiController@pracovniVykaz');
Route::get('ukolovaMzda'  , 'RozcestiController@ukolovaMzda');
Route::get('odvadeciVykaz', 'RozcestiController@odvadeciVykaz');

Route::auth();
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('register', 'HomeController@register');
Route::post('createUser', 'HomeController@createUser');
