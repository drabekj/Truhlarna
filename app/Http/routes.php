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
// testing
use App\Pracovni_den;
use App\Zamestnanec;
Route::get('/test', function(){

  // $den = new Pracovni_den(['datum' => "1999-11-12", 'Cislo_VP' => '7778', 'Hodiny' => '20', 'Zamestnanec_id' => '3']);
  // $den->save();

  // $zam = new Zamestnanec(['Jmeno' => "Jonas", 'Prijmeni' => 'Metodej']);
  // $zam->save();



  // $TruhlarID = 1;

  // $den = Pracovni_den::where('ID_Zam', $TruhlarID);

  $zam = Zamestnanec::find(1);
  echo $zam->hasPracovniDny;

  // return view('test', compact('den'));
});

Route::get('rozcesti'     , 'RozcestiController@rozcesti');
Route::get('pracovniVykaz', 'RozcestiController@pracovniVykaz');
Route::get('ukolovaMzda'  , 'RozcestiController@ukolovaMzda');
Route::get('odvadeciVykaz', 'RozcestiController@odvadeciVykaz');

Route::auth();
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('register', 'HomeController@register');
Route::post('createUser', 'HomeController@createUser');
