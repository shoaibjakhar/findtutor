<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellBook;
use Illuminate\Support\Facades\Auth;

class SellBookController extends Controller
{
    public function sell_book(Request $request)
    {
        $upload_picture=$request->input("upload_picture");
        // dd($request->hasFile("upload_picture"));
        if($request->hasFile("upload_picture"))
        {
            // Upload upload_picture into server
             $upload_picture=$request->file("upload_picture");
             $upload_picture->move("public/images/thumbnail/",$upload_picture->getClientOriginalName());

        }

        $insert = SellBook::create([

            'user_id' => Auth::user()->id,
            'title_of_book' => $request->title_of_book,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'year_published' => $request->year_published,
            'category' => $request->category,
            'condition_of_book' => $request->condition_of_book,
            'picture' => $request->upload_picture->getClientOriginalName(),
        ]);

        return redirect("buy-book");
    }
}
