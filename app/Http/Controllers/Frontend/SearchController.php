<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Batch;
use App\Models\User;
use DB;
class SearchController extends Controller
{
	public function search_detail(Request $request)
    {
        $all_courses = Course::all();
        $all_batch = Batch::all();
        $all_user = User::all();
        
        return view('Frontend/App/SearchResultPages/search_result_page',['all_courses' => $all_courses,'all_batch' => $all_batch, 'all_user' => $all_user])->with('all_courses',$all_courses);
    }

    public function course_detail($id)
    {
    	$search_course = Course::find($id);
    	return view('Frontend/App/SearchResultPages/view_course_detail',["search_course" => $search_course]);
    }

    public function batch_detail($id)
    {
    	$search_batch = Batch::find($id);
    	
    	return view('Frontend/App/SearchResultPages/view_batch_detail',["search_batch" => $search_batch]);
    }

    public function tutor_detail($id)
    {
    	$search_tutor = User::find($id);
    	
    	return view('Frontend/App/SearchResultPages/view_tutor_detail',["search_tutor" => $search_tutor]);
    }

    public function institute_detail($id)
    {
    	$search_institute = User::find($id);
    	
    	return view('Frontend/App/SearchResultPages/view_institute_detail',["search_institute" => $search_institute]);
    }
    
    public function search_book(Request $request)
    {
        $search = DB::select("select * from sell_book where title_of_book LIKE '%$request->search%' or author Like '%$request->search%'");

        return view("Frontend/App/buy_book",["searched_book" => $search]);
    }
}
