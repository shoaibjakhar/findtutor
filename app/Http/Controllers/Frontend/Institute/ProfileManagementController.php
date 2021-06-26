<?php

namespace App\Http\Controllers\Frontend\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileManagementController extends Controller
{
    // Login Institute Profile
    public function my_profile()
    {

        $id = Auth::user()->id;

        return view('Frontend/Institute/ProfileManagement/my_profile');

    }

// Update Institute Profile
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

        return redirect('institute-my-profile');
    
    }
}
