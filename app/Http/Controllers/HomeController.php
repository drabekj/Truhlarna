<?php

namespace App\Http\Controllers;

use App\User;
use App\Zamestnanec;
use Hash;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Vytvoří novou instanci HomeController
     *
     * Do rout v tomto controleru ma pristup pouze prihlaseny uzivatel.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Presmeruje na rozcesti aplikace.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rozcesti');
    }

    public function register(){
      return view('auth/register');
    }

    /**
     * Vytvori noveho uzivatele a ulozi do databaze
     *
     * @return RozcestiController@rozcesti
     */
    public function createUser(Request $request){

      $this->validate($request, [
        'username' => 'required|max:255|unique:Login',
        'role' => 'required',
        'password' => 'required|min:6|confirmed',
      ]);

      $user = new User;

      $user->id = $request->id;
      $user->username = $request->username;
      $user->role = $request->role;
      $user->password = Hash::make($request->password);

      $user->save();

      //return redirect()->action('RozcestiController@rozcesti');
      return \Redirect::to('/rozcesti')->with('success', true)->with('message','Uživatel úspěšně přidán.');
    }

    /*public function deleteUser(){
      $zamestnanci = Zamestnanec::select(\DB::raw('CONCAT(ID_ZAM , " ", jmeno, " ", prijmeni) AS fulljmeno, ID_ZAM'))->lists('fulljmeno', 'ID_ZAM');
      return view('auth/deleteUser')->with( 'zamestnanci', $zamestnanci);
    }*/

    /**
     * Smaze uzivatele z databaze
     *
     * @return view deleteUser with var zamestnanci
     */
    public function deleteUser(){
      $zamestnanci = User::select(\DB::raw('CONCAT(id , " ", username, " (", role, ")") AS fulljmeno, id'))
      ->where('id', '<>', \Auth::user()->id)->pluck('fulljmeno', 'id');
      //dd($test);
      //$zamestnanci = User::select(\DB::raw('CONCAT(id , " ", username, " (", role, ")") AS fulljmeno, id'))->lists('fulljmeno', 'id');
      return view('auth/deleteUser')->with( 'zamestnanci', $zamestnanci);
    }


     /**
     * Smaze uzivatele z databaze
     *
     * @return view deleteUser with var zamestnanci
     */
    public function destroy(Request $request){

      if (Hash::check($request->password, \Auth::user()->password))
      {
         User::deleteLogin($request->ids);
         //return redirect()->action('RozcestiController@rozcesti');
         return \Redirect::to('/rozcesti')->with('success', true)->with('message','Uživatel úspěšně smazán.');
      }
      else {
        return \Redirect::back()->withErrors('password');
      }

    }

}
