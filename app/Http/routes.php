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

  $TruhlarID = 1;
  $rok = 2015;
  $mesic = 1;

  $Datum = (object) array(
    'mesic'    => $mesic,
    'rok'      => $rok,
    'numOfDays' => cal_days_in_month(CAL_GREGORIAN, $mesic, $rok)
  );

  $Truhlar = Zamestnanec::getTruhlar($TruhlarID);
  $data = Pracovni_den::getPracovniDnyTruhlare($Truhlar, $Datum, $Datum->numOfDays);

  // var_dump($data[1][1]);

  // echo $data[1][1][0]->Hodiny;

  return view("test", [
    'data' => $data
  ]);

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
if (Auth::guest())
  return redirect('rozcesti');
  return redirect('pracovniVykaz');
});

Route::post('pracovniVykaz/store', 'PracovniVykazController@store');

Route::auth();
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('register', 'HomeController@register');
Route::post('createUser', 'HomeController@createUser');

Route::get('deleteUser', 'HomeController@deleteUser');
Route::delete('/delete', 'HomeController@destroy');
