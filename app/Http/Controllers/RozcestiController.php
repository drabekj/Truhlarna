<?php

namespace App\Http\Controllers;

class RozcestiController extends Controller
{
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