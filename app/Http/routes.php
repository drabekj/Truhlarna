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
  // $den = Pracovni_den::find(1)->ofZamestnanec;
  // $mesic = 1;
  // $rok = 2015;
  // $Datum = (object) array(
  //   'mesic'    => $mesic,
  //   'rok'      => $rok,
  //   'numOfDays' => cal_days_in_month(CAL_GREGORIAN, $mesic, $rok),
  // );
  //
  // $Truhlar = Zamestnanec::getTruhlar(1);
  // $VPs     = Zamestnanec::getVPs($Truhlar->id, $Datum);

});

Route::get('rozcesti'      , 'RozcestiController@rozcesti');
Route::post('pracovniVykaz', 'RozcestiController@pracovniVykaz');
Route::post('ukolovaMzda'   , 'RozcestiController@ukolovaMzda');
Route::post('odvadeciVykaz' , 'RozcestiController@odvadeciVykaz');
Route::get('ukolovaMzda', function(){
  return redirect('rozcesti');
});
Route::get('odvadeciVykaz', function(){
  return redirect('rozcesti');
});
Route::get('pracovniVykaz', function(){
  return redirect('rozcesti');
});

Route::post('pracovniVykaz/store', 'PracovniVykazController@store');

Route::auth();
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('register', 'HomeController@register');
Route::post('createUser', 'HomeController@createUser');

Route::get('deleteUser', 'HomeController@deleteUser');
Route::delete('/delete', 'HomeController@destroy');

