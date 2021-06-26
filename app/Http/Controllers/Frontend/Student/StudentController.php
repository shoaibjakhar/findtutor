<?php

namespace App\Http\Controllers\Frontend\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
    	return view('Frontend/Student/dashboard/dashboard');
    }
}
