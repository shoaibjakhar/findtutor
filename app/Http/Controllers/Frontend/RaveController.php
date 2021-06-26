<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Flutterwave;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RaveController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
    * Initialize Rave payment process
    * @return void
    */
    public function initialize($transection)
    {
        $flutterwave_payment=new Flutterwave();
       return $flutterwave_payment->initialized($transection);
    }
    /**
   * Obtain Rave callback information
   * @return void
   */
    public function callback(Request $request){
        
        $flutterwave_payment=new Flutterwave();
        $flutterwave_payment->callBackVarify($request->txref);
        
    }
    public function create_transection(Request $request)
    {
        
        $user =Auth::user();
        $cust_transection=[
            'amount'=>12,
            'txref'=>$this->transectionToken(),
            'customer_email'=>$user->email,
            'customer_phone'=>$user->phone,
            'customer_firstname'=>$user->name,
            'customer_lastname'=>$user->last_name,
           
           
                'title'=>'Course Payment',
                'description'=>'Buying course from Findatutor360',
                "logo"=>"https://assets.piedpiper.com/logo.png",
            
        ];
        $message=$this->initialize($cust_transection);
     
        return redirect($message['redirect_to']);

    }
    public function transectionToken()
    {
        $string_random=rand(100000,1000000);
        return "Trans_".Crypt::encryptString($string_random);
    }
}
