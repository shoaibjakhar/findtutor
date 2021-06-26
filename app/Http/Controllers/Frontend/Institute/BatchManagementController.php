<?php

namespace App\Http\Controllers\Frontend\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Batch;
use App\Models\User;

class BatchManagementController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
    {
    	$all_batches = Batch::all();
    	
    	return view('Frontend/Institute/BatchManagement/all_batch')->with('all_batches',$all_batches);
    }

    public function create()
    {
    	return view('Frontend/Institute/BatchManagement/add_batch');
    }

    public function store(Request $request)
    {
    	$user_id = Auth::user()->id;

        $thumbnail=$request->input("thumbnail");

        if($request->hasFile("thumbnail"))
        {
            // Upload thumbnail into server
             $thumbnail=$request->file("thumbnail");
             $thumbnail->move("public/images/thumbnail",$thumbnail->getClientOriginalName());
        }
        $add_batch=Batch::create([

    		'user_id' => $user_id,
            'thumbnail' => $thumbnail->getClientOriginalName(),
    		'batch_name' => $request->batch_name,
    		'teaching_method' => $request->teaching_method,
    		'price' => $request->price,
    		'address' => $request->address,
		]);

		return redirect('institute-all-batch');
    }
}
