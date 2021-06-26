<?php



namespace App\Http\Classes;





class Flutterwave

{

    public $mode = '';

    public $res = [];

    public $response = [];

    private $public_key="FLWPUBK_TEST-f5ee3d7ae43255807e6a2c4559f00b79-X";

    private $secret_key="FLWSECK_TEST-8dc38ca5f049053dbbe4ed0436aa4a6d-X";

    private $curl_api_url = "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2";

    private $currency ='GHS';

    private $redirect_url = '';



    public function __construct()

    {

       //do nothing 

    }

    public function initialized($transaction)

    {

        $curl = curl_init();

        $transaction['currency']=$this->currency;

        $transaction['PBFPubKey']=$this->public_key;

        $transaction['redirect_url']=route('callback');

        curl_setopt_array($curl, array(

        CURLOPT_URL => $this->curl_api_url."/hosted/pay",

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_CUSTOMREQUEST => "POST",

        CURLOPT_POSTFIELDS => json_encode($transaction),

        CURLOPT_HTTPHEADER => [

            "content-type: application/json",

            "cache-control: no-cache"

        ],

        ));



        $response = curl_exec($curl);

        $transaction = json_decode($response);
        

        if(!$transaction->data && !$transaction->data->link){

        return ['message'=>$transaction->message,'redirect_to'=>''];

        }

        return ['message'=>'success','redirect_to'=>$transaction->data->link];

    }

    public function callBackVarify($transaction_id)

    {

        $transaction['SECKEY']=$this->secret_key;

        $transaction['txref']=$transaction_id;



       

        $data_string = json_encode($transaction);

                

        $ch = curl_init($this->curl_api_url.'/verify');                                                                      

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));



        $response = curl_exec($ch);



       curl_getinfo($ch, CURLINFO_HEADER_SIZE);



        curl_close($ch);



        return json_decode($response, true);

    }

}

