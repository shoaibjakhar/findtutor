<?php

namespace App\Http\Controllers\Frontend\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
    	return view('Frontend/Institute/dashboard/dashboard');
    }
}
