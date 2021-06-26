<?php

namespace App\Http\Controllers\Frontend\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
    	return view('Frontend/Tutor/dashboard/dashboard');
    }
}
