<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //Auth Import

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role=Auth::user()->role;

        if($role=="student")
        {
            return redirect('student-dashboard');
        }
        else if($role=="institute")
        {
            return redirect('institute-dashboard');
        }
        else if($role=="tutor")
        {
            return redirect('tutor-dashboard');
        }

        // return view('home');
    }


    
}
