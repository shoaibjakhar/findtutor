<?php

namespace App\Http\Controllers\Frontend\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileManagementController extends Controller
{

// ALl Courses
	public function index()
    {

    	$all_courses = Course::all();

    	return view('Frontend/Tutor/ProfileManagement/all_courses',)->with('all_courses',$all_courses);
    }

// Open Add Course Form
    public function create()
    {
    	return view('Frontend/Tutor/ProfileManagement/add_course');
    }

// Add New Course
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
        $add_course=Course::create([

    		'user_id' => $user_id,
            'thumbnail' => $thumbnail->getClientOriginalName(),
    		'course_name' => $request->course_name,
    		'teaching_method' => $request->teaching_method,
    		'price' => $request->price,
    		'address' => $request->address,
		]);

		return redirect('tutor-all-courses');

    }


// Login Tutor Profile
    public function my_profile()
    {

        $id = Auth::user()->id;

        return view('Frontend/Tutor/ProfileManagement/my_profile');

    }

// Update Tutor Profile
    public function update_profile(Request $request)
    {
        $image=$request->input("images");

        
        if($request->hasFile('images'))
        {
            // Upload Image into server
             $image=$request->file("images");
             $image->move("public/images",$image->getClientOriginalName());
        }

        $id = Auth::user()->id;

        $update_profile = User::find($id);

        $update_profile->name = $request->first_name;
        $update_profile->last_name = $request->last_name;
        $update_profile->country_code = $request->country_code;
        $update_profile->phone_no = $request->phone_no;
        $update_profile->email = $request->email;
        $update_profile->image = $image->getClientOriginalName();
        // $update_profile->password = Hash::make($request->password);

        $update_profile->update();

        return redirect('tutor-my-profile');
    
    }


}
