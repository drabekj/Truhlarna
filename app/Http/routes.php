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

// Tytou routy jsou pouze pro testovani, pak nutno osdtranit
// a presmerovavat pres controller (tam se implmentuje middleware)
Route::get('rozcesti', function () {
    return view('rozcesti');
});
Route::get('pracovniVykaz', function () {
    return view('pracovniVykaz');
});
Route::get('ukolovaMzda', function () {
    return view('ukolovaMzda');
});
Route::get('register', function () {
    return view('auth/register');
});

Route::get('pracovniVykaz', 'RozcestiController@pracovniVykaz');
Route::get('ukolovaMzda', 'RozcestiController@ukolovaMzda');
Route::get('odvadeciVykaz', 'RozcestiController@odvadeciVykaz');

/* Honza D - autentizace */
Route::auth();

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
