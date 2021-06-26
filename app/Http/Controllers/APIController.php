<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;

class APIController extends Controller
{
    public function api(Request $request)
    {
    	// $data = Http::get("https://fakestoreapi.com/products")->json();

    	// return view("ajax",["data" => $data]);

    	/////////////////////////////////////////////////////////////

    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/");
    	curl_exec($ch);
    	curl_close($ch);

    	die();


////////////////////////////////////////////////////////////


    	// $data = Http::post("https://api.flutterwave.com/v3/transactions/123456/verify");

    	// dd($data);


    	/////////////////////////////////////////////////////////////////

   //  	$request= [
   //          'tx_ref' =>time(),
   //          'amount' => 100,
   //          'currency'=>'PKR',
   //          'redirect_url'=>route('home'),
   //          'payments_options'=>'card',
   //          'customer'=>[
   //            'email'=> "janujakhar2370@gmail.com",
   //            'name'=> "Zahid",
   //                   ],
   //          ' customizations,'=>[
   //        'title'=> "Remedy plus",
   //        'description'=> "Payment for items in cart",
   //        'logo' => asset('img/logo.png'),
   //          ],
   //          'meta'=>[
   //            'price'=> 100,
   //             'email'=> "janujakhar2370@gmail.com"
   //          ],
   //        ];

   // $curl = curl_init();

   //  	curl_setopt_array($curl, array(
	  //   CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/123456/verify",
	  //   CURLOPT_RETURNTRANSFER => true,
	  //   CURLOPT_ENCODING => "",
	  //   CURLOPT_MAXREDIRS => 10,
	  //   CURLOPT_TIMEOUT => 0,
	  //   CURLOPT_FOLLOWLOCATION => true,
	  //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  //   CURLOPT_CUSTOMREQUEST => "GET",
	  //   CURLOPT_POSTFIELDS => json_encode($request),
	  //   CURLOPT_HTTPHEADER => array(
	  //     "Content-Type: application/json",
	  //     "Authorization: Bearer FLWSECK_TEST-1090b4e5393b92f0887e4ff3b7978a94-X"
	  //   ),
	  // ));
	 
	  // $response = curl_exec($curl);
	  
	  // curl_close($curl);
  	//   dd(json_decode($response));



//////////////////////////////////////////////////////////////////

    	$url = 'https://api.flutterwave.com/v3/transactions/123456/verify';
// $parameters = [
 
//   'convert' => 'USD'
// ];

	$headers = [
	  'Accepts: application/json',
	  'X-CMC_PRO_API_KEY: FLWPUBK-c0bb14db2154b5cd2e5072b777c584d4-X'
	];
	// $qs = http_build_query($parameters); // query string encode the parameters
	$request = "{$url}"; // create the request URL


	$curl = curl_init(); // Get cURL resource
	// Set cURL options
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $request,            // set the request URL
	  CURLOPT_HTTPHEADER => $headers,     // set the headers 
	  CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
	));

	$response = curl_exec($curl); // Send the request, save the response

	

	
	curl_close($curl); // Close request
	dd(json_decode($response));

/////////////////////////////////////////////////////////////////////


	       $request= [
          	"card_number" => "5531886652142950",
   "cvv"=>"564",
   "expiry_month"=>"09",
   "expiry_year"=>"22",
   "currency"=>"NGN",
   "amount"=>"1000",
   "email"=>"janujakhar2370@gmail.com",
   "fullname"=>"yemi desola",
   "tx_ref"=>"MC-3243e",
   "redirect_url"=>route('home')
            
          ];
    	$curl = curl_init();

    	curl_setopt_array($curl, array(
	    CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/123456/verify",
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_ENCODING => "",
	    CURLOPT_MAXREDIRS => 10,
	    CURLOPT_TIMEOUT => 0,
	    CURLOPT_FOLLOWLOCATION => true,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    CURLOPT_CUSTOMREQUEST => "GET",
	    CURLOPT_POSTFIELDS => json_encode($request),
	    CURLOPT_HTTPHEADER => array(
	      "Content-Type: application/json",
	      "Authorization: Bearer FLWSECK_TEST-1090b4e5393b92f0887e4ff3b7978a94-X"
	    ),
	  ));
	 
	  $response = curl_exec($curl);
	  
	  curl_close($curl);
  	  dd(json_decode($response));
  
    }
}
