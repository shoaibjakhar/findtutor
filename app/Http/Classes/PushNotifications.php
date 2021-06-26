<?php

/**
 * Created by PhpStorm.
 * User: WebForest
 * Date: 8/1/2018
 * Time: 8:02 PM
 */

namespace App\Http\Classes;

use Illuminate\Support\Facades\Log;

class PushNotifications {

    private $cert = "";
    private $host_live = 'gateway.push.apple.com';
    //private $host = 'gateway.sandbox.push.apple.com';
    private $pass_phrase = 123;
    private $device = NULL;
    private $device_type = NULL;
    private $device_token = NULL;
    private $app = 'rider';
    private $environment = 'production';
    //private $environment = 'development';
    private $message = "";
    private $sound = "default";
    private $badge = NULL;
    private $port = 2195;
    private $content_available = 1;
    private $sender_name = "";
    private $fcm_url = 'https://fcm.googleapis.com/fcm/send';
    private static $API_ACCESS_KEY_DRIVER = 'AAAAYKWJShI:APA91bEvJhy0UCWGlicpOoQ8qZUWeEX9y-T8glEhH-U-IoTGU2U74Hx-3-OqRirDcVTzTOGY_sMGeI_I5Hlr7YFaljYVyGxQXN9Tn2hXDSkvyqld6t6njGhq5cQGifgSos_e-u45uwlG';
    private static $API_ACCESS_KEY_RIDER = 'AAAAYKWJShI:APA91bEvJhy0UCWGlicpOoQ8qZUWeEX9y-T8glEhH-U-IoTGU2U74Hx-3-OqRirDcVTzTOGY_sMGeI_I5Hlr7YFaljYVyGxQXN9Tn2hXDSkvyqld6t6njGhq5cQGifgSos_e-u45uwlG';

    public function __construct($device) {
        $this->app = ($device['send_to'] == driverRoleId()) ? 'driver' : 'rider';
        $this->device_type = $device['device_type'];
        $this->device_token = $device['device_token'];
        $this->badge = $device['badge'];


        // $this->host = env('notification_host');
    }

//    public function setEnvironment($environment) {
//        $this->environment = $environment;
//    }

    public function send($data) {
        if ($this->device_type == 'android') {
            return $this->sendAndroid($data);
        } elseif ($this->device_type == 'ios') {
            return $this->sendToIOS($data);
        }
    }

    public function sendToIOS($data) {
        try {
//            $body["aps"] = array('title' => $data['title'],'alert' => $data['message'], "badge" => $this->badge, 'sound' => 'default');
//            (isset($data["body"]["custom1"]) AND !empty($data["body"]["custom1"]) AND $data["body"]["custom1"] != "")?$body["aps"]['custom1'] = $data["body"]["custom1"]:"";
//            (isset($data["type"]) AND !empty($data["type"]) AND $data["type"] != "")?$body["status_type"] = $data["type"]:"";
//            (isset($data["body"]["ride_id"]) AND !empty($data["body"]["ride_id"]) AND $data["body"]["ride_id"] != "")?$body["ride_id"] = $data["body"]["ride_id"]:"";
//            (isset($data["body"]["invite_id"]) AND !empty($data["body"]["invite_id"]) AND $data["body"]["invite_id"] != "")?$body["invite_id"] = $data["body"]["invite_id"]:"";
//            (isset($data["body"]["contact_id"]) AND !empty($data["body"]["contact_id"]) AND $data["body"]["contact_id"] != "")?$body["contact_id"] = $data["body"]["contact_id"]:"";
//            (isset($data["body"]["ride_type"]) AND !empty($data["body"]["ride_type"]) AND $data["body"]["ride_type"] != "")?$body["ride_type"] = $data["body"]["ride_type"]:"";
//            (isset($data["body"]["notifiction_log_id"]) AND !empty($data["body"]["notifiction_log_id"]) AND $data["body"]["notifiction_log_id"] != "")?$body["nlog_id"] = $data["body"]["notifiction_log_id"]:"";
//            (isset($data["body"]["driver_id"]) AND !empty($data["body"]["driver_id"]) AND $data["body"]["driver_id"] != 0)?$body["driver_id"] = $data["body"]["driver_id"]:0;
//            $body["btn_action"] = ($data["body"]["btn_action"]);
//            $body["btn_link"] = $data["body"]["btn_link"];

            $title=$data["title"];
            if(isset($data['title']) AND !empty($data["title"]) AND $data["title"] != ""){
                if(strlen($data["title"]) > 20){
                    $title= substr($data["title"],0,20)."...";
                }
            }

            $body["aps"] = array('title' => $title, "badge" => $this->badge, 'sound' => 'default');
           // $body["aps"] = array( "badge" => $this->badge, 'sound' => 'default');
            (isset($data["body"]["cu"]) AND !empty($data["body"]["cu"]) AND $data["body"]["cu"] != "")?$body["aps"]['cu'] = $data["body"]["cu"]:"";
            (isset($data["nt"]) AND !empty($data["nt"]) AND $data["nt"] != "")?$body["nt"] = $data["nt"]:"";
            (isset($data["body"]["ri"]) AND !empty($data["body"]["ri"]) AND $data["body"]["ri"] != "")?$body["ri"] = $data["body"]["ri"]:"";
            (isset($data["body"]["ii"]) AND !empty($data["body"]["ii"]) AND $data["body"]["ii"] != "")?$body["ii"] = $data["body"]["ii"]:"";
            (isset($data["body"]["ci"]) AND !empty($data["body"]["ci"]) AND $data["body"]["ci"] != "")?$body["ci"] = $data["body"]["ci"]:"";
            (isset($data["body"]["rt"]) AND !empty($data["body"]["rt"]) AND $data["body"]["rt"] != "")?$body["rt"] = $data["body"]["rt"]:"";
            (isset($data["body"]["li"]) AND !empty($data["body"]["li"]) AND $data["body"]["li"] != "")?$body["li"] = $data["body"]["li"]:"";
            (isset($data["body"]["di"]) AND !empty($data["body"]["di"]) AND $data["body"]["di"] != 0 )?$body["di"] = $data["body"]["di"]:0;
            (isset($data["body"]["dl"]) AND !empty($data["body"]["dl"]) AND $data["body"]["dl"] != 0 )?$body["dl"] = $data["body"]["dl"]:0;
            $body["ba"] = $data["body"]["ba"];
            $body["bl"] = $data["body"]["bl"];

            $payload_size = mb_strlen(json_encode($body, JSON_NUMERIC_CHECK), '8bit');

            $remaing_space = 235 - $payload_size;
            $message = substr($data['message'], 0, $remaing_space);
            if(strlen($message) < strlen($data['message'])){
                $body["aps"]["alert"] = $message."...";
            }else {
                $body["aps"]["alert"] = $message;
            }

            $payload = json_encode($body);

        //   die("-----".$size);
            $result = NULL;

            $stream_context = stream_context_create();
            if ($this->environment == "production") {
                $this->host = 'gateway.push.apple.com';
                if ($this->app == "driver") {
                    stream_context_set_option($stream_context, 'ssl', 'local_cert', public_path('ios_certificate/driver_aps.pem'));
                } else {
                    stream_context_set_option($stream_context, 'ssl', 'local_cert', public_path('ios_certificate/rider_aps.pem'));
                }
            } else {
                $this->host = 'gateway.sandbox.push.apple.com';
                if ($this->app == "driver") {
                    stream_context_set_option($stream_context, 'ssl', 'local_cert', public_path('ios_certificate/driver_aps.pem'));
                } else {
                    stream_context_set_option($stream_context, 'ssl', 'local_cert', public_path('ios_certificate/rider_aps.pem'));
                }
            }
            stream_context_set_option($stream_context, 'ssl', 'passphrase', $this->pass_phrase);
            $apns = stream_socket_client('ssl://' . $this->host . ':' . $this->port, $error, $error_string, 30, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $stream_context);

            $message = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $this->device_token)) . chr(0) . chr(strlen($payload)) . $payload;

            $result = fwrite($apns, $message, strlen($message));

            //socket_close($apns);
            fclose($apns);
         //   die("-----".$size);
            if (!$result) {
                return FALSE;
            } else {
                return TRUE;
            }
        } catch (\Exception $e) {
            echo "Exception :" . $e->getMessage();
            // Log::info("Exception :" . $e->getMessage());
        }
    }

    public function sendAndroid($data) {
        $data["body"]["badge"] = $this->badge;
        $payload = array(
            'title' => $data['title'],
            'message' => $data['message'],
            'nt' => $data['nt'],
            'body' => $data["body"],
        );

        $fields = array(
            'to' => $this->device_token,
            'data' => $payload,
        );

        $server_key = "";
        if ($this->app == "driver") {
            $server_key = self::$API_ACCESS_KEY_DRIVER;
        } else {
            $server_key = self::$API_ACCESS_KEY_RIDER;
        } 

        $headers = array(
            'Authorization: key=' . $server_key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->fcm_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($fields) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        }

        // Execute post
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        //print_r($result);
        if ($result->success == 1) {
            return true;
        } else {
            return false;
        }
    }

}
