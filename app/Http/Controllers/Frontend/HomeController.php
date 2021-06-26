<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use DB;
use App\Models\SellBook;
class HomeController extends Controller
{
    public function buy_book()
    {
        $all_books = SellBook::all();

        return view("Frontend/App/buy_book",["all_books" => $all_books]);
    }
    public function create_search(Request $request)
    {
        $all_courses = Course::all();
        $all_batch = Batch::all();
        $all_user = User::all();
        
        return view('Frontend/App/SearchResultPages/search_result_page')->with('all_courses',$all_courses)->with('all_batch',$all_batch)->with('all_user',$all_user);
        // return view('Frontend/App/search_result_page');
    }

    public function search(Request $request)
    {

        $data = DB::select("select * from courses  where teaching_method ='$request->learning_mode'
            union select * from courses where course_name='$request->want_to_learn'
            union select * from courses where address='$request->location'
            union select * from batches where address='$request->location'
            union select * from batches where teaching_method='$request->learning_mode' 
            union select * from batches where batch_name='$request->want_to_learn'");

        // echo "<pre>";
        // print_r($data);
        // die();
        return view('Frontend/App/SearchResultPages/search_result_page')->with('all_search',$data);
        
        // $all_courses = Course::all();
        // $all_batch = Batch::all();
        // $all_user = User::all();
        
        // return view('Frontend/App/search_result_page')->with('all_courses',$all_courses)->with('all_batch',$all_batch)->with('all_user',$all_user);






        // $users = DB::table('courses')
        //     ->join('courses', 'courses.teaching_method','=','batches.teaching_method')
        //     ->select('courses.*', 'batches.*')
        //     ->get();

        //     dd($users);


        // $all_courses=Courses::query()

        //     ->where('course_name', 'LIKE', '%'.$request->want_to_learn.'%')
        //     ->where('teaching_method', 'LIKE', '%' . $request->learning_mode . '%')
        //     ->where('address', 'LIKE', '%' . $request->location . '%')
        //     ->get();

        //     dd($all_courses);



        // $all_courses=Courses::query()

        //     ->orwhere('course_name', 'LIKE', "%$request->want_to_learn%")
        //     ->orwhere('teaching_method', 'LIKE', '%' . $request->learning_mode . '%')
        //     ->orwhere('address', 'LIKE', '%' . $request->location . '%')
        //     ->get();

        // $all_courses.=Batch::query()

        //     ->where('batch_name', 'LIKE', "%$request->want_to_learn%")
        //     ->orwhere('teaching_method', 'LIKE', '%' . $request->learning_mode . '%')
        //     ->orwhere('address', 'LIKE', '%' . $request->location . '%')
        //     ->get();

        //     dd($all_courses);    






        // if($request->want_to_learn=="" || $request->learning_mode=="" || $request->location=="" )
        // {
        //      $all_courses=Courses::query()

        //     ->where('course_name', 'LIKE', "%$request->want_to_learn%")
        //     ->where('teaching_method', 'LIKE', '%' . $request->learning_mode . '%')
        //     ->where('address', 'LIKE', '%' . $request->location . '%')
        //     ->get();

        //     return view('Frontend/App/search_result_page')->with('all_courses',$all_courses);
        // }
        // else
        // {
        //     $all_courses=Courses::query()

        //     ->where('course_name', 'LIKE', "%$request->want_to_learn%")
        //     ->orWhere('teaching_method', 'LIKE', '%' . $request->learning_mode . '%')
        //     ->orWhere('address', 'LIKE', '%' . $request->location . '%')
        //     ->get();

        //     return view('Frontend/App/search_result_page')->with('all_courses',$all_courses);
        // }
    	

    	


    	// $all_users=User::query();

    	// ->where('name', 'LIKE', "%$request->want_to_learn%")
    	// ->orwhere('last_name', 'LIKE', "%$request->want_to_learn%")
    	// ->get();
    	
    }
}
