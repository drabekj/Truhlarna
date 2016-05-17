<?php

namespace App\Http\Controllers;

use DB;

class RozcestiController extends Controller
{
  /**
   * Create a new controller instance.
   * Routes in this controlled are accessible only if user is authorized.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function rozcesti()
    {
        return view('rozcesti');
    }

    public function pracovniVykaz()
    {
        return view('pracovniVykaz');
    }
    public function ukolovaMzda()
    {
        return view('ukolovaMzda');
    }
    public function odvadeciVykaz()
    {
        return view('odvadeciVykaz');
    }

}
