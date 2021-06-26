<?php

namespace App\Http\Classes;


class Theteller
{
    public $mode = '';
    public $res = [];
    public $response = [];
    private $merchant_id;
    private $username_key;
    private $api_key;
    private $curl_api_url = "https://test.theteller.net/";
    private $currency;
    private $redirect_url = '';

    public function __construct($merchant_id,$username_key,$api_key,$currency)
    {
        $this->merchant_id=$merchant_id;
        $this->username_key=$username_key;
        $this->api_key=$api_key;
        $this->currency=$currency;
    }
    public function setReturnUrl($redirect_url)
    {
        $this->redirect_url=$redirect_url;
    }
    public function checkoutStart($transaction)
    {
        $curl = curl_init();
        $transaction['merchant_id']=$this->merchant_id;
        $transaction['redirect_url']=$this->redirect_url;
        $payload = json_encode($transaction);
       
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->curl_api_url."checkout/initiate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
               "Authorization: Basic ".base64_encode($this->username_key.':'.$this->api_key)."",
              "Cache-Control: no-cache",
              "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $transaction = json_decode($response);
        if($transaction->status=='success')
        {
            $transaction_response['redirect_to']=$transaction->checkout_url;
            $transaction_response['token']=$transaction->token;
            $transaction_response['message']=$transaction->status;
            return $transaction_response;
        }
        
        return false;
    }

    public function verify($transaction_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL =>  $this->curl_api_url."/v1.1/users/transactions/".$transaction_id."/status",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Merchant-Id: $this->merchant_id"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $transaction_response = json_decode($response);
        if($transaction_response['status']=='approved')
        return $transaction_response;
        return false;

    }
}
