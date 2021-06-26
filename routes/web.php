<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("api","APIController@api");






Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');




						//Student Panel
//Dashboard
Route::get('student-dashboard',"Frontend\Student\StudentController@index");
// Profile Management
Route::get('student-my-profile',"Frontend\Student\ProfileManagementController@my_profile");
Route::post('student-update-profile',"Frontend\Student\ProfileManagementController@update_profile")->name('student-update-profile');


						//Tutor Panel
//Dashboard
Route::get('tutor-dashboard',"Frontend\Tutor\TutorController@index");

// Profile Management
Route::get('tutor-all-courses',"Frontend\Tutor\ProfileManagementController@index");
Route::get('tutor-add-course',"Frontend\Tutor\ProfileManagementController@create");
Route::post('tutor-save-course',"Frontend\Tutor\ProfileManagementController@store");
Route::get('tutor-my-profile',"Frontend\Tutor\ProfileManagementController@my_profile");
Route::post('tutor-update-profile',"Frontend\Tutor\ProfileManagementController@update_profile")->name('tutor-update-profile');


						//Institute Panel
//Dashboard
Route::get('institute-dashboard',"Frontend\Institute\InstituteController@index");
// Profile Management
Route::get('institute-my-profile',"Frontend\Institute\ProfileManagementController@my_profile");
Route::post('institute-update-profile',"Frontend\Institute\ProfileManagementController@update_profile")->name('institute-update-profile');
// Batch Management
Route::get('institute-add-batch',"Frontend\Institute\BatchManagementController@create");
Route::post('institute-save-batch',"Frontend\Institute\BatchManagementController@store");
Route::get('institute-all-batch',"Frontend\Institute\BatchManagementController@index");

                        // App (User Layout)

Route::get('search-result-page',"Frontend\SearchController@search_detail");
Route::post('srp',"Frontend\HomeController@search");
// Route::get('srp',"Frontend\SearchController@search");
Route::get('view-course-detail/{id}',"Frontend\SearchController@course_detail");
Route::post('course/buy',"Frontend\RaveController@create_transection")->name('course.buy');
Route::get('callback',"Frontend\RaveController@callback")->name('callback');
Route::get('view-batch-detail/{id}',"Frontend\SearchController@batch_detail");
Route::get('view-tutor-detail/{id}',"Frontend\SearchController@tutor_detail");
Route::get('view-institute-detail/{id}',"Frontend\SearchController@institute_detail");



                        //Admin Panel

Route::get('/admin', function () {
    return view('Admin/layout');
});

//User Visit Links   (App,Frontend)

Route::get('/srp', function () {
    return view('Frontend/App/search_result_page');
});

Route::get('/index', function () {
    return view('Frontend/App/home');
});

Route::get('/', function () {
    return view('Frontend/App/home');
});

Route::get('/student', function () {
    return view('Frontend/App/student');
});

Route::get('/tutor', function () {
    return view('Frontend/App/tutor');
});

Route::get('/institution', function () {
    return view('Frontend/App/institution');
});

Route::get('/sell-book', function () {
    return view('Frontend/App/sell_books');
});

Route::post("save-sell-book","Frontend\SellBookController@sell_book");

Route::get('buy-book',"Frontend\HomeController@buy_book");
// Route::get('/buy-book', function () {
//     return view('Frontend/App/buy_book');
// });
Route::post("search-book","Frontend\SearchController@search_book");
Route::get('/ajax', function () {
    return view('ajax');
});