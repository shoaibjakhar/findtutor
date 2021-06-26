<?php
/**
 * Created by PhpStorm.
 * User: WebForest
 * Date: 11/7/2019
 * Time: 7:28 PM
 */

namespace App\Http\Classes;

use App\Http\Models\User;
use Validator;
use App\Http\Models\UserCCInfo;

class Strip
{
    public $secret_key = '';
    public $mode = '';
    public $res = [];
    public $response = [];

    public function __construct()
    {
        $this->res = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
        $this->response = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];

        $this->mode = env('APP_ENV', 'sandbox');

        if ($this->mode == 'production') {
            $this->secret_key = env('stripe_sandbox_live_key', '');
        } else {
            $this->secret_key = env('stripe_sandbox_secret_key', 'sk_test_KMhIii5V8W40QIRbPrN8oBvG00OiTXlF3R');
        }

        \Stripe\Stripe::setApiKey($this->secret_key);
    }

    public function createCustomerWithCard($data)
    {
        if ($data != null) {
            $response = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
            $token_response = $this->createCardToken($data);
            if (isset($token_response->id)) {
                $token_id = $token_response->id;
                $last4 = $token_response->card->last4;
                $card_type = $token_response->card->brand;
                $card_stripe_id = $token_response->card->id;
                $user_email = isset($data['email']) ? $data['email'] : '';
                $phone = isset($data['phone']) ? $data['phone'] : '';
                $name = (isset($data['first_name']) || isset($data['last_name'])) ? $data['first_name'] . ' ' . $data['last_name'] : '';
                try {
                    $customer_response = \Stripe\Customer::create(array(
                        "description" => "Add New Customer For " . $user_email,
                        'email' => $user_email,
                        'name' => $name,
                        'phone' => $phone,
                        "source" => $token_id // obtained with Stripe.js
                    ));

                    if ($customer_response != null && isset($customer_response->id)) {
                        $customer_id = $customer_response->id;
                        $res['status'] = 'success';
                        $res['customer_id'] = $customer_id;
                        $res['token'] = $card_stripe_id;
                        $res['response'] = $customer_response;
                    } else {
                        $res['status'] = 'error';
                        $res['error_code'] = 0;
                        $res['error_message'] = 'Something Went Wrong, Please Contact Support';
                    }
                } catch (\Exception $e) {
                    $body = $e->getJsonBody();
                    $err = $body["error"];
                    $res = [
                        "status" => $e->getHttpStatus(),
                        "type" => $err["type"],
                        "error_code" => $err["code"],
                        "param" => $err["param"],
                        "error_message" => $err["message"],
                    ];

                    //email_send('webforestteam@gmail.com', supportEmail(), 'Toma Error Occurred in stripe createCustomer', print_r($return_array, true) . '<br />==============================<br />' . print_r($data, true));

                }
            }

        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = 'Data is Required';
        }

        return $res;
    }

    public function createCustomer($data)
    {
        if ($data != null) {
            $user_email = isset($data['email']) ? $data['email'] : null;
            $phone = isset($data['phone']) ? $data['phone'] : '';
            $name = (isset($data['firstName']) || isset($data['lastName'])) ? $data['firstName'] . ' ' . $data['lastName'] : '';
            try {
                $customer_response = \Stripe\Customer::create(array(
                    "description" => "Add New Customer For " . $user_email,
                    'email' => $user_email,
                    'name' => $name,
                    'phone' => $phone,
                    //'balance'     => 100*500, //just for testing purpose
                ));

                if ($customer_response != null && isset($customer_response->id)) {
                    $customer_id = $customer_response->id;
                    $res['status'] = 'success';
                    $res['customer_id'] = $customer_id;
                    $res['response'] = $customer_response;
                } else {
                    $res['status'] = 'error';
                    $res['error_code'] = 0;
                    $res['error_message'] = 'Something Went Wrong, Please Contact Support';
                }
            } catch (\Exception $e) {
                $body = $e->getJsonBody();
                $err = $body["error"];
                $res = [
                    "status" => $e->getHttpStatus(),
                    "type" => $err["type"],
                    "error_code" => $err["code"],
                    "param" => $err["param"],
                    "error_message" => $err["message"],
                ];

                email_send('webforestteam@gmail.com', supportEmail(), 'Toma Error Occurred in stripe createCustomer', print_r($res, true) . '<br />==============================<br />' . print_r($data, true));

            }

        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
        }

        return $res;
    }

    public function updateCustomer($customer_id = '', $data)
    {
        if ($customer_id != '' && $data) {
            $update_customer_id = $customer_id;
            $user_email = isset($data['email']) ? $data['email'] : null;
            $phone = isset($data['phone']) ? $data['phone'] : '';
            $name = (isset($data['firstName']) || isset($data['lastName'])) ? $data['firstName'] . ' ' . $data['lastName'] : '';
            $cu = \Stripe\Customer::retrieve($update_customer_id);
            $cu->description = "Update Customer Data For testing" . $user_email;
            $cu->email = $user_email;
            $cu->name = $name;
            $cu->phone = $phone;
            $customer_response = $cu->save();
            if ($customer_response != null && isset($customer_response->id)) {
                $customer_id = $customer_response->id;
                $res['status'] = 'success';
                $res['customer_id'] = $customer_id;
                $res['response'] = $customer_response;
            } else {
                $res['status'] = 'error';
                $res['error_code'] = 0;
                $res['error_message'] = 'Something Went Wrong, Please Contact Support';
            }

        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = 'Customer ID and Data is Required';
        }
        return $res;
    }

    public function createMerchantAccount($data)
    {
        $validator = Validator::make($data, [
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required',
            "date_of_birth" => 'required',
            "address" => 'required',
            "state" => 'required',
            "city" => 'required',
            "postal_code" => 'required|integer',
            "account_number" => 'required',
            "routing_number" => 'required',
            'social_security' => 'required',
        ]);
        if (!$validator->fails()) {
            $dob = explode('/', $data['date_of_birth']);
            $account_no = (!empty($data) && isset($data['account_number'])) ? $data['account_number'] : '';
            $routing_no = (!empty($data) && isset($data['routing_number'])) ? $data['routing_number'] : '';
            $country = (!empty($data) && isset($data['country'])) ? $data['country'] : 'US';
            $name = (!empty($data) && isset($data['first_name'])) ? $data['first_name'] : 'Test';

            try {
                $account_create = \Stripe\Account::create(
                    array(
                        "type" => "custom",
                        'business_type' => 'individual',
                        "email" => $data['email'],
                        "country" => "US",
                        "requested_capabilities" => ["transfers"],
                        'business_type' => 'individual',
                        'individual' => [
                            'dob' => ['day' => isset($dob[1]) ? $dob[1] : '16', 'month' => isset($dob[0]) ? $dob[0] : '1', 'year' => isset($dob[2]) ? $dob[2] : '1990'],
                            'first_name' => $data['first_name'],
                            'last_name' => $data['last_name'],
                            'ssn_last_4' => substr($data['social_security'], -4),
                            'email' => $data['email'],
                            'phone' => $data['phone'],
                            //'industry'=>'automobile',
                            'address' => ['city' => $data['city'], 'line1' => $data['address'], 'postal_code' => $data['postal_code'], 'state' => $data['state']],
                        ],
                        'business_profile' => [
                            'product_description' => 'payment will be tranferred at user account once the passengers will be drop off.'
                        ],
                        'external_account'=>[
                            "object" => "bank_account",
                            "country" => $country,
                            "currency" => "usd",
                            "account_holder_name" => $name,
                            "account_holder_type" => "individual",
                            "routing_number" => $routing_no,
                            "account_number" => $account_no
                        ],
                        'tos_acceptance' => [
                            'date' => time(),
                            'ip' => $_SERVER['REMOTE_ADDR'] // Assumes you're not using a proxy
                        ],
                    )
                );
                    $account_response=$account_create;
               //     $account = \Stripe\Account::retrieve($account_id);
              //      $account_response = $account->external_accounts->create(array("external_account" => $token_id));
                    if ($account_response != null && isset($account_response->id)) {
                        $last4 = (isset($account_response->last4) && $account_response->last4 > 0) ? $account_response->last4 : 0;
                        $bank_name = (isset($account_response->bank_name)) ? $account_response->bank_name : "";
                        $routing_number = (isset($account_response->routing_number)) ? $account_response->routing_number : "";
                        $status = (isset($account_response->status)) ? $account_response->status : "success";

                        $res['status'] = 'success';
                     //   $res['merchant_account_id'] = $account_id;
                        $res['merchant_account_id'] = $account_create->id;
                        $res['merchant_account_status'] = $status;
                        $res['response'] = $account_response;
                        $res['bank_name'] = $bank_name;
                    }
                } catch (\Exception $e) {
                    $body = $e->getJsonBody();
                    dd($body);
                    $err = $body["error"];
                    $res = [
                        "status" => $e->getHttpStatus(),
                        "type" => isset($err["type"]) ? $err["type"] : "",
                        "error_code" => isset($err["code"]) ? $err["code"] : "",
                        "param" => isset($err["param"]) ? $err["param"] : "",
                        "error_message" => isset($err["message"]) ? $err["message"] : "",

                    ];

                    email_send('webforestteam@gmail.com', supportEmail(), 'Toma Error Occurred in stripe createMerchantAccount', print_r($res, true) . '<br />==============================<br />' . print_r($data, true));

                }
//            } else {
//              //  return $token_response;
//            }

        } else {
            $res = array();
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = validationErrorsToString($validator->messages());
        }
        return $res;
    }

    public function updateMerchantAccount($merchant_id = '', $data)
    {
        $res = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
        if ($merchant_id != '') {
            $validator = Validator::make($data, [
                "first_name" => 'required',
                "last_name" => 'required',
                "email" => 'required',
                "date_of_birth" => 'required',
                "address" => 'required',
                "state" => 'required',
                "city" => 'required',
                "postal_code" => 'required|integer',
                "phone" => 'required',
                "account_number" => 'required',
                "routing_number" => 'required',
            ]);
            if (!$validator->fails()) {
                $response = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
                try {
                    $dob = explode('/', $data['date_of_birth']);
                    $account_no = (!empty($data) && isset($data['account_number'])) ? $data['account_number'] : '';
                    $routing_no = (!empty($data) && isset($data['routing_number'])) ? $data['routing_number'] : '';
                    $country = (!empty($data) && isset($data['country'])) ? $data['country'] : 'US';
                    $name = (!empty($data) && isset($data['first_name'])) ? $data['first_name'] : 'Test';
                  //  $token_response = $this->createAccountToken($data);
                   // if (isset($token_response->id)) {
                     //   $token_id = $token_response->id;

                        $account_response = \Stripe\Account::update(
                            $merchant_id,
                            [
                                "email" => $data['email'],
                                "requested_capabilities" => ["transfers"],
                                'business_type' => 'individual',
                                'individual' => [
                                    'dob' => ['day' => isset($dob[1]) ? $dob[1] : '16', 'month' => isset($dob[0]) ? $dob[0] : '1', 'year' => isset($dob[2]) ? $dob[2] : '1990'],
                                    'first_name' => $data['first_name'],
                                    'last_name' => $data['last_name'],
                                    'ssn_last_4' => substr($data['social_security'], -4),
                                    'email' => $data['email'],
                                    'phone' => $data['phone'],
                                    //'industry'=>'automobile',
                                    'address' => ['city' => $data['city'], 'line1' => $data['address'], 'postal_code' => $data['postal_code'], 'state' => $data['state']],
                                ],
                                'business_profile' => [
                                    'product_description' => 'payment will be tranferred at user account once the passengers will be drop off.'
                                ],
                                'external_account'=>[
                                    "object" => "bank_account",
                                    "country" => $country,
                                    "currency" => "usd",
                                    "account_holder_name" => $name,
                                    "account_holder_type" => "individual",
                                    "routing_number" => $routing_no,
                                    "account_number" => $account_no
                                ],
                                'business_profile' => [
                                    'product_description' => 'payment will be tranferred at user account once the passengers will be drop off.'
                                ],
                                'tos_acceptance' => [
                                    'date' => time(),
                                    'ip' => $_SERVER['REMOTE_ADDR'] // Assumes you're not using a proxy
                                ],
                            ]
                        );
//dd($account_response);
                    //    print_r($account_response);die('okkk');
                        if ($account_response != null && isset($account_response['id'])) {
                            $last4 = (isset($account_response->external_accounts->data->last4) && $account_response->external_accounts->data->last4 > 0) ? $account_response->external_accounts->data->last4 : 0;
                            $bank_name = (isset($account_response->external_accounts->data->bank_name)) ? $account_response->external_accounts->data->bank_name : "";
                            $routing_number = (isset($account_response->external_accounts->data->routing_number)) ? $account_response->external_accounts->data->routing_number : "";
                            $status = (isset($account_response->status)) ? $account_response->status : "success";

                            $res['status'] = 'success';
                            $res['bank_name'] = $bank_name;
                            $res['merchant_account_status'] = $status;
                            $res['response'] = $account_response;
                        }
                  //  }

                } catch (\Exception $e) {
                    $body = $e->getJsonBody();
                    $err = $body["error"];
                    $res = [
                        "status" => $e->getHttpStatus(),
                        "type" => isset($err["type"]) ? $err["type"] : "",
                        "error_code" => isset($err["code"]) ? $err["code"] : "",
                        "param" => isset($err["param"]) ? $err["param"] : "",
                        "error_message" => isset($err["message"]) ? $err["message"] : "",
                    ];

                    email_send('webforestteam@gmail.com', supportEmail(), 'Toma Error Occurred in stripe updateMerchantAccount', print_r($res, true) . '<br />==============================<br />' . print_r($data, true));

                }
            } else {
                $res['status'] = 'error';
                $res['error_code'] = 0;
                $res['error_message'] = validationErrorsToString($validator->messages());
            }
        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = 'Merchant ID is Required';
        }
        return $res;
    }

//    private function tryAllCards($stripe_charge, $cards){
//        for
//    }

    public function createTransaction($data, $exception_data = [], $try_all = true)
    {

        $validator = Validator::make($data, [
            "amount" => 'required',
            "rider_customer_id" => 'required',
            "rider_card" => 'required',
            "application_fee" => 'required',
            "connect_account_id" => 'required',
        ]);
        if (!$validator->fails()) {
            $response = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
            $charge_request = array(
                "amount" => (($data['amount'] * 100) + (int)($data['application_fee'] * 100)),
                "currency" => "usd",
                "customer" => $data['rider_customer_id'],
                'source' => $data['rider_card'],
                "transfer_data" => [
                    "destination" => $data['connect_account_id'],
                ],
                'application_fee_amount' => $data['application_fee'] * 100,
                "description" => "Charging for ride #" . (isset($data['ride_id']) ? $data['ride_id'] : '') . "."
            );
            try {
                $stripe_charge = \Stripe\Charge::create($charge_request);

                if (!empty($stripe_charge) && isset($stripe_charge->id)) {
                    if ($stripe_charge->paid && $stripe_charge->status == "succeeded" && empty($stripe_charge->failure_code)) {
                        $res['status'] = 'success';
                        $res['transaction_id'] = isset($stripe_charge->id) ? $stripe_charge->id : '';
                        /*## Ticket #2176*/
                        $res['stripe_transaction_status'] = isset($stripe_charge->status) ? trim($stripe_charge->status) : '';
                        $res['payment_gateway_transaction_status'] = isset($stripe_charge->status) ? trim($stripe_charge->status) : '';
                        $res['response'] = $stripe_charge;
                    } else {
                        if ($try_all) {
                            $user = User::with('allCreditCard')->where(['gateway_customer_id' => $data['rider_customer_id']])->first();
                            if ($user && $user->allCreditCard->count() > 1) {
                                $cards = UserCCInfo::where(['user_id' => $user->id])->where('card_token', '!=', $data['rider_card'])->where(['is_delete' => 0, "is_active" => 1])->get();
                                //  $this->tryAllCards($stripe_charge, $cards);
                                foreach ($cards as $card) {
                                    if ($card && $card->card_token != "") {
                                        $charge_request['source'] = $card->card_token;
                                        $stripe_response = \Stripe\Charge::create($charge_request);
                                        if ($stripe_response->paid && $stripe_response->status == "succeeded" && empty($stripe_response->failure_code)) {
                                            $res['status'] = 'success';
                                            $res['transaction_id'] = isset($stripe_response->id) ? $stripe_response->id : '';
                                            /*## Ticket #2176*/
                                            $res['stripe_transaction_status'] = isset($stripe_response->status) ? trim($stripe_response->status) : '';
                                            $res['payment_gateway_transaction_status'] = isset($stripe_response->status) ? trim($stripe_response->status) : '';
                                            $res['response'] = $stripe_response;
                                            return  $res;
                                        }
                                    }
                                }
                            }
                        }
                        if (!isset($res['status'])) {
                            $res['status'] = 'failed';
                            $res['transaction_id'] = isset($stripe_charge->id) ? $stripe_charge->id : '';
                            /*## Ticket #2176*/
                            $res['stripe_transaction_status'] = isset($stripe_charge->failure_code) ? trim($stripe_charge->failure_code->code) : '';
                            $res['payment_gateway_transaction_status'] = isset($stripe_charge->failure_code) ? trim($stripe_charge->failure_code->code) : '';
                            $res['response'] = $stripe_charge;
                        }
                    }
                }
            } catch (\Exception $e) {
                $body = $e->getJsonBody();
                $err = $body["error"];
                if (isset($err['type']) && $err['type'] == 'card_error' && $try_all) {
                    $user = User::with('allCreditCard')->where(['gateway_customer_id' => $data['rider_customer_id']])->first();
                    if ($user && $user->allCreditCard->count() > 1) {
                        $cards = UserCCInfo::where(['user_id' => $user->id])->where('card_token', '!=', $data['rider_card'])->where(['is_delete' => 0, "is_active" => 1])->get();
                        //  $this->tryAllCards($stripe_charge, $cards);
                        foreach ($cards as $card) {
                            if ($card && $card->card_token != "") {
                                $charge_request['source'] = $card->card_token;
                                $stripe_response = \Stripe\Charge::create($charge_request);
                                if ($stripe_response->paid && $stripe_response->status == "succeeded" && empty($stripe_response->failure_code)) {
                                    $res['status'] = 'success';
                                    $res['transaction_id'] = isset($stripe_response->id) ? $stripe_response->id : '';
                                    /*## Ticket #2176*/
                                    $res['stripe_transaction_status'] = isset($stripe_response->status) ? trim($stripe_response->status) : '';
                                    $res['payment_gateway_transaction_status'] = isset($stripe_response->status) ? trim($stripe_response->status) : '';
                                    $res['response'] = $stripe_response;
                                    return $res;
                                }
                            }
                        }
                    }
                }

                $res = [
                    "status_code" => $e->getHttpStatus(),
                    "status" => 'failed',
                    "type" => $err["type"],
                    "error_code" => $err["code"],
                    "param" => isset($err["param"]) ? $err["param"] : "",
                    "decline_code" => isset($err["decline_code"]) ? $err["decline_code"] : "",
                    "error_message" => $err["message"],
                ];
                email_send(appEmail(), supportEmail(), 'Toma Error Occurred in stripe createTransaction', print_r($res, true) . '<br />==============================<br />' . print_r($data, true));
                addExceptionLog(["type" => "other", "to" => isset($to[0]) ? $to[0] : null, "from" => 'support@gotoma.com', "subject" => $err, "exception" => $body, "exception_type" => isset($exception_data["record_type"]) ? $exception_data["record_type"] : "", "record_id" => isset($exception_data["record_id"]) ? $exception_data["record_id"] : ""]);
            }
        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = validationErrorsToString($validator->messages());
        }
        return $res;
    }

    public function transferFunds($account_id, $amount)
    {
        try {
            $stripe_transfer = \Stripe\Transfer::create(array(
                "amount" => $amount * 100,
                "currency" => "usd",
                "destination" => $account_id,
                "transfer_group" => "Transfer Test Payment"
            ));
        } catch (\Exception $e) {
            $body = $e->getJsonBody();
            $err = $body["error"];
            $return_array = [
                "status" => $e->getHttpStatus(),
                "type" => $err["type"],
                "code" => $err["code"],
                "param" => $err["param"],
                "message" => $err["message"],
            ];

            return $return_array;
        }

        if (isset($stripe_transfer->id)) {
            $stripe_transfer_id = $stripe_transfer->id;
            return $stripe_transfer;
        }
    }

    public function getTransactionDetails($transaction_id = '')
    {
        if (isset($transaction_id) && trim($transaction_id) != '') {
            return $transaction = \Stripe\Charge::retrieve($transaction_id);
        }
    }

    public function createCardToken($data = array())
    {
        //for balance top up
        //$card_no = "4000000000000077";
        $expiryDate = (!empty($data) && isset($data['expirationDate'])) ? $data['expirationDate'] : '';
        $expiryDate = explode('/', $expiryDate);
        $card_no = (!empty($data) && isset($data['number'])) ? $data['number'] : '';
        $cardholderName = (!empty($data) && isset($data['cardholderName'])) ? $data['cardholderName'] : '';
        $cvc = (!empty($data) && isset($data['cvv'])) ? $data['cvv'] : '';
        $expiry_month = (!empty($expiryDate) && isset($expiryDate[0])) ? $expiryDate[0] : '';;
        $expiry_year = (!empty($expiryDate) && isset($expiryDate[1])) ? $expiryDate[1] : '';;
        $expiry_date = $expiry_month . '-' . $expiry_year;
        try {
            $token_response = \Stripe\Token::create(array(
                "card" => array(
                    "number" => $card_no,
                    "exp_month" => $expiry_month,
                    "exp_year" => $expiry_year,
                    "cvc" => $cvc,
                    "name" => $cardholderName
                )
            ));

            return $token_response;
        } catch (\Exception $e) {
            $body = $e->getJsonBody();
            $err = $body["error"];
            $return_array = [
                "status" => $e->getHttpStatus(),
                "type" => $err["type"],
                "code" => $err["code"],
                "param" => $err["param"],
                "error_message" => $err["message"],
            ];

            return $return_array;
        }
    }

    public function createAccountToken($data = array())
    {
        $account_no = (!empty($data) && isset($data['account_number'])) ? $data['account_number'] : '';
        $routing_no = (!empty($data) && isset($data['routing_number'])) ? $data['routing_number'] : '';
        $country = (!empty($data) && isset($data['country'])) ? $data['country'] : 'US';
        $name = (!empty($data) && isset($data['first_name'])) ? $data['first_name'] : 'Test';

        try {
            $token_response = \Stripe\Token::create(array(
                "bank_account" => array(
                    "country" => $country,
                    "currency" => "usd",
                    "account_holder_name" => $name,
                    "account_holder_type" => "individual",
                    "routing_number" => $routing_no,
                    "account_number" => $account_no
                )
            ));

            return $token_response;
        } catch (\Exception $e) {
            $body = $e->getJsonBody();
            $err = $body["error"];
            $return_array = [
                "status" => $e->getHttpStatus(),
                "type" => $err["type"],
                "code" => $err["code"],
                "param" => $err["param"],
                "error_message" => $err["message"],
            ];

            return $return_array;
        }
    }

    public function balanceTopUp($data)
    {
        $token_response = $this->createCardToken($data);
        $token = '';
        if (isset($token_response->id)) {
            $token = $token_response->id;
        }
        try {
            $stripe_charge = \Stripe\Charge::create(array(
                'currency' => 'USD',
                'amount' => 10000,
                'description' => 'Example charge',
                'source' => $token,
            ));
            return $stripe_charge;
        } catch (\Exception $e) {
            $body = $e->getJsonBody();
            $err = $body["error"];
            $return_array = [
                "status" => $e->getHttpStatus(),
                "type" => $err["type"],
                "code" => $err["code"],
                "param" => $err["param"],
                "error_message" => $err["message"],
            ];

            return $return_array;
        }
    }

    public function updateCreditCard($card_id = null, $customer_id = null, $data = array())
    {
        $response = $res = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
        $card_response = null;
        if (!empty($data) && !is_null($customer_id) && !is_null($card_id)) {
            $expiryDate = (!empty($data) && isset($data['expirationDate'])) ? $data['expirationDate'] : '';
            $expiryDate = explode('/', $expiryDate);
            $card_no = (!empty($data) && isset($data['number'])) ? $data['number'] : '';
            $cardholderName = (!empty($data) && isset($data['cardholderName'])) ? $data['cardholderName'] : '';
            $cvc = (!empty($data) && isset($data['cvv'])) ? $data['cvv'] : '';
            $expiry_month = (!empty($expiryDate) && isset($expiryDate[0])) ? $expiryDate[0] : '';;
            $expiry_year = (!empty($expiryDate) && isset($expiryDate[1])) ? $expiryDate[1] : '';;
            $expiry_date = $expiry_month . '-' . $expiry_year;
            try {
                $get_last_4 = substr($card_no, -4);
                $getCardInfo = UserCCInfo::where(['card_token' => $card_id])->first();
                if (!is_null($getCardInfo) && isset($getCardInfo->card_number)) {
                    if ($getCardInfo->card_number == $get_last_4) {
                        $card_response = \Stripe\Customer::updateSource(
                            $customer_id,
                            $card_id,
                            array(
                                "exp_month" => $expiry_month,
                                "exp_year" => $expiry_year,
                                "name" => $cardholderName
                            )
                        );

                    } else {
                        $getCard = $this->getCreditCard($card_id, $customer_id);
                        if (!is_null($getCard) && $getCard['status'] == 'success') {
                            $delete_response = $this->deleteCreditCard($card_id, $customer_id);
                        }
                        $card_response = $this->createCreditCard($customer_id, $data);
                    }

                    if ($card_response != null && isset($card_response['token'])) {
                        $card_stripe_id = $card_response['token'];
                        $res['status'] = 'success';
                        $res['token'] = $card_stripe_id;
                        $res['response'] = $card_response;
                    } elseif ($card_response != null && isset($card_response->id)) {
                        $card_stripe_id = $card_response->id;
                        $res['status'] = 'success';
                        $res['token'] = $card_stripe_id;
                        $res['response'] = $card_response;
                    } else {
                        $res['status'] = 'error';
                        $res['error_code'] = 0;
                        $res['error_message'] = 'Something Went Wrong, Please Contact Support';
                    }

                    return $res;
                } else {
                    return ['status' => 'error'];
                }

            } catch (\Exception $e) {
                $body = $e->getJsonBody();
                $err = $body["error"];
                $res = [
                    "status" => $e->getHttpStatus(),
                    "type" => $err["type"],
                    "error_code" => $err["code"],
                    "param" => $err["param"],
                    "error_message" => $err["message"],
                ];
            }
        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = 'Data is Required';
        }

        return $res;
    }

    public function createCreditCard($customer_id = null, $data = array())
    {
        $response = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
        if (!empty($data) && !is_null($customer_id)) {
            $token_response = $this->createCardToken($data);
            $token_id = '';
            if (!empty($token_response->id) && isset($token_response->id)) {
                $token_id = $token_response->id;
            } else {
                return $token_response;
            }
            try {
                $card_response = \Stripe\Customer::createSource(
                    $customer_id,
                    array(
                        'source' => $token_id
                    )
                );

                if ($card_response != null && isset($card_response->id)) {
                    $card_stripe_id = $card_response->id;
                    $res['status'] = 'success';
                    $res['token'] = $card_stripe_id;
                    $res['response'] = $card_response;
                } else {
                    $res['status'] = 'error';
                    $res['error_code'] = 0;
                    $res['error_message'] = 'Something Went Wrong, Please Contact Support';
                }

            } catch (\Exception $e) {
                $body = $e->getJsonBody();
                $err = $body["error"];
                $res = [
                    "status" => $e->getHttpStatus(),
                    "type" => $err["type"],
                    "error_code" => $err["code"],
                    "param" => $err["param"],
                    "error_message" => $err["message"],
                ];
            }
        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = 'Data is Required';
        }

        return $res;
    }

    public function getCreditCard($card_id = null, $customer_id = null)
    {
        $res = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
        if (!is_null($customer_id) && !is_null($card_id)) {
            try {
                $card_response = \Stripe\Customer::retrieveSource(
                    $customer_id,
                    $card_id
                );

                if ($card_response != null && isset($card_response->id)) {
                    $card_stripe_id = $card_response->id;
                    $res['status'] = 'success';
                    $res['token'] = $card_stripe_id;
                    $res['response'] = $card_response;
                } else {
                    $res['status'] = 'error';
                    $res['error_code'] = 0;
                    $res['error_message'] = 'Something Went Wrong, Please Contact Support';
                }

            } catch (\Exception $e) {
                $body = $e->getJsonBody();
                $err = $body["error"];
                $res = [
                    "status" => $e->getHttpStatus(),
                    "type" => $err["type"],
                    "error_code" => $err["code"],
                    "param" => $err["param"],
                    "error_message" => $err["message"],
                ];
            }
        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = 'Data is Required';
        }

        return $res;
    }

    public function deleteCreditCard($card_id = null, $customer_id = null)
    {
        $res = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
        if (!is_null($customer_id) && !is_null($card_id)) {
            try {
                $card_response = \Stripe\Customer::deleteSource(
                    $customer_id,
                    $card_id
                );

                if ($card_response != null && isset($card_response->id)) {
                    $card_stripe_id = $card_response->id;
                    $res['status'] = 'success';
                    $res['token'] = $card_stripe_id;
                    $res['response'] = $card_response;
                } else {
                    $res['status'] = 'error';
                    $res['error_code'] = 0;
                    $res['error_message'] = 'Something Went Wrong, Please Contact Support';
                }

            } catch (\Exception $e) {
                $body = $e->getJsonBody();
                $err = $body["error"];
                $res = [
                    "status" => $e->getHttpStatus(),
                    "type" => $err["type"],
                    "error_code" => $err["code"],
                    "param" => $err["param"],
                    "error_message" => $err["message"],
                ];
            }
        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = 'Data is Required';
        }

        return $res;
    }

    public function chargeCustomer($data)
    {
        $validator = Validator::make($data, [
            "amount" => 'required',
            "customer_id" => 'required',
            "card" => 'required',
            'type' => 'required'
        ]);
        if (!$validator->fails()) {
            $res = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
            try {
                $stripe_charge = \Stripe\Charge::create(array(
                    "amount" => $data['amount'] * 100,
                    "currency" => "usd",
                    "customer" => $data['customer_id'],
                    'source' => $data['card'],
                    "description" => "Charging customer for " . $data['type']
                ));

                if (!empty($stripe_charge) && isset($stripe_charge->id)) {
                    if ($stripe_charge->paid && $stripe_charge->status == "succeeded" && empty($stripe_charge->failure_code)) {
                        $res['status'] = 'success';
                        $res['transaction_id'] = isset($stripe_charge->id) ? $stripe_charge->id : '';
                        $res['stripe_transaction_status'] = isset($stripe_charge->status) ? trim($stripe_charge->status) : '';
                        $res['payment_gateway_transaction_status'] = isset($stripe_charge->status) ? trim($stripe_charge->status) : '';
                        $res['response'] = $stripe_charge;
                    } else {
                        $res['status'] = 'failed';
                        $res['transaction_id'] = isset($stripe_charge->id) ? $stripe_charge->id : '';
                        $res['stripe_transaction_status'] = isset($stripe_charge->failure_code) ? trim($stripe_charge->failure_code->code) : '';
                        $res['payment_gateway_transaction_status'] = isset($stripe_charge->failure_code) ? trim($stripe_charge->failure_code->code) : '';
                        $res['response'] = $stripe_charge;
                    }
                }
            } catch (\Exception $e) {
                $body = $e->getJsonBody();
                $err = $body["error"];
                $res = [
                    "status" => $e->getHttpStatus(),
                    "type" => $err["type"],
                    "error_code" => $err["code"],
                    "param" => $err["param"],
                    "error_message" => $err["message"],
                ];
            }
        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = validationErrorsToString($validator->messages());
        }
        return $res;
    }

    public function updateCharge($transId = '', $card = '')
    {
        $res = array();
        if (!empty($transId) && !empty($card)) {
            try {
                $stripe_charge = \Stripe\Charge::update(
                    $transId,
                    ['source' => $card]
                );

                if (!empty($stripe_charge) && isset($stripe_charge->id)) {
                    if ($stripe_charge->paid && $stripe_charge->status == "succeeded" && empty($stripe_charge->failure_code)) {
                        $res['status'] = 'success';
                        $res['transaction_id'] = isset($stripe_charge->id) ? $stripe_charge->id : '';
                        $res['stripe_transaction_status'] = isset($stripe_charge->status) ? trim($stripe_charge->status) : '';
                        $res['payment_gateway_transaction_status'] = isset($stripe_charge->status) ? trim($stripe_charge->status) : '';
                        $res['response'] = $stripe_charge;
                    } else {
                        $res['status'] = 'failed';
                        $res['transaction_id'] = isset($stripe_charge->id) ? $stripe_charge->id : '';
                        $res['stripe_transaction_status'] = isset($stripe_charge->failure_code) ? trim($stripe_charge->failure_code->code) : '';
                        $res['payment_gateway_transaction_status'] = isset($stripe_charge->failure_code) ? trim($stripe_charge->failure_code->code) : '';
                        $res['response'] = $stripe_charge;
                    }
                }
            } catch (\Exception $e) {
                $body = $e->getJsonBody();
                $err = $body["error"];
                $res = [
                    "status" => $e->getHttpStatus(),
                    "type" => $err["type"],
                    "error_code" => $err["code"],
                    "param" => $err["param"],
                    "error_message" => $err["message"],
                ];
            }

        }
        return $res;
    }

    public function changeDefaultSource($customer_id = '', $card_id)
    {
        if ($customer_id != '' && $card_id) {
            $response = ['status' => 'error', 'error_message' => 'Something went wrong! Contact Support.'];
            $cu = \Stripe\Customer::retrieve($customer_id);
            $cu->default_source = $card_id;
            $cu->save();
            $customer_response = $cu->save();
            if ($customer_response != null && isset($customer_response->id)) {
                $customer_id = $customer_response->id;
                $res['status'] = 'success';
                $res['customer_id'] = $customer_id;
                $res['response'] = $customer_response;
            } else {
                $res['status'] = 'error';
                $res['error_code'] = 0;
                $res['error_message'] = 'Something Went Wrong, Please Contact Support';
            }

        } else {
            $res['status'] = 'error';
            $res['error_code'] = 0;
            $res['error_message'] = 'Customer ID and Data is Required';
        }
        return $res;
    }

}
