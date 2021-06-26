<?php
/**
 * Created by PhpStorm.
 * User: WebForest
 * Date: 6/20/2018
 * Time: 3:56 PM
 */

namespace App\Http\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Routific
{
    private $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1ZjE5YmYyN2FlNmRkMjAwMThkZTY4YmQiLCJpYXQiOjE2MDA5NzAwNDF9.nRHMCpmzVJbsy-usk1HsEZ2GSDsJHXhrpOzNtybYPgQ';
    private $base_url = "https://api.routific.com/v1/";

    public function __construct()
    {

    }

    public function getOptimalRoute($end_point = 'vrp', $payload)
    {
        try {
            $client = new Client([
                'base_uri' => $this->base_url,
            ]);
            $response = $client->post($end_point, [
                'json' => $payload,
                'headers' => [
                    "Content-type" => "application/json",
                    "Authorization" => "bearer " . $this->token
                ]
            ]);
            $result = $response->getBody();
            return json_decode($result);
        } catch (\Exception $ex) {
          //  die($ex->getMessage());
        }
    }

}