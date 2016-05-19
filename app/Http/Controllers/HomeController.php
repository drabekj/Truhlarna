<?php

namespace App\Http\Controllers;

use App\User;
use Hash;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
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
    /*public function register(){
      return view('auth/delete');
    }*/

    /**
     * Creates new user and saves to database.
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

      return redirect()->action('RozcestiController@rozcesti');
    }
}
