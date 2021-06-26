<?php
/**
 * Created by PhpStorm.
 * User: WebForest
 * Date: 6/20/2018
 * Time: 3:56 PM
 */

namespace App\Http\Classes;


class Checkr
{
    private $api_key = '';

    public function __construct()
    {
        $this->api_key = '0a305c6479353ba682a58950137566bc7c53b95f';
    }

    public function createCandidate($candidate_params = array())
    {
        $response = array('status' => 'error', 'message' => 'Something Went Wrong');
        if ($candidate_params) {
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.checkr.io/v1/candidates');
                curl_setopt($curl, CURLOPT_USERPWD, $this->api_key . ":");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($candidate_params));
                $json = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                $hash = json_decode($json, true);
                if ($http_status == '201') {
                    $candidate_id = $hash['id'];
                    $response['status'] = 'success';
                    $response['message'] = 'success';
                    $response['candidate_id'] = $candidate_id;
                    $response['data'] = $hash;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = isset($hash['error']) ? $hash['error'] : 'Something Went Wrong';
                }
            } catch (\Exception $e) {
                $exception = 'Exception: Class = ' . get_class($e);
                $exception .= ($e->getMessage() != '') ? ' ==== Message = ' . $e->getMessage() : '';
                $exception .= ($e->getCode() != 0) ? ' ==== Code = ' . $e->getCode() : '';
                email_send('webforestteam@gmail.com', supportEmail(), 'Toma Exception Occured in Create Candidate on Checkr', $exception . '<br />==============================<br />' . print_r($candidate_params, true));
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Candidate Data is required');
        }
        return $response;
    }

    public function createReport($candidate_id, $package = 'driver_standard')
    {
        $response = array('status' => 'error', 'message' => 'Something Went Wrong');
        if ($candidate_id && $package) {
            $report_params = [
                "candidate_id" => $candidate_id,
                "package" => $package,
            ];
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.checkr.io/v1/reports');
                curl_setopt($curl, CURLOPT_USERPWD, $this->api_key . ":");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($report_params));
                $json = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                $hash = json_decode($json, true);
                if ($http_status == '201') {
                    $report_id = $hash['id'];
                    $response['status'] = 'success';
                    $response['message'] = 'success';
                    $response['report_id'] = $report_id;
                    $response['data'] = $hash;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = isset($hash['error']) ? $hash['error'] : 'Something Went Wrong';
                }
            } catch (\Exception $e) {
                $exception = 'Exception: Class = ' . get_class($e);
                $exception .= ($e->getMessage() != '') ? ' ==== Message = ' . $e->getMessage() : '';
                $exception .= ($e->getCode() != 0) ? ' ==== Code = ' . $e->getCode() : '';
                email_send('webforestteam@gmail.com', supportEmail(), 'Toma Exception Occured in Create Report on Checkr', $exception . '<br />==============================<br />' . print_r($report_params, true));
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Candidate Id and Package is required');
        }
        return $response;
    }

    public function createInvitation($report_params = array())
    {
        $response = array('status' => 'error', 'message' => 'Something Went Wrong');
        if ($report_params) {
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.checkr.io/v1/invitations');
                curl_setopt($curl, CURLOPT_USERPWD, $this->api_key . ":");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($report_params));
                $json = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                $hash = json_decode($json, true);
                if ($http_status == '201') {
                    $invitation_id = $hash['id'];
                    $response['status'] = 'success';
                    $response['message'] = 'success';
                    $response['invitation_id'] = $invitation_id;
                    $response['data'] = $hash;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = isset($hash['error']) ? $hash['error'] : 'Something Went Wrong';
                }
            } catch (\Exception $e) {
                $exception = 'Exception: Class = ' . get_class($e);
                $exception .= ($e->getMessage() != '') ? ' ==== Message = ' . $e->getMessage() : '';
                $exception .= ($e->getCode() != 0) ? ' ==== Code = ' . $e->getCode() : '';
                email_send('webforestteam@gmail.com', supportEmail(), 'Toma Exception Occured in Create Invite on Checkr', $exception . '<br />==============================<br />' . print_r($report_params, true));
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Candidate Id and Package is required');
        }
        return $response;
    }

    public function getReport($report_id)
    {
        $response = array('status' => 'error', 'message' => 'Something Went Wrong');
        if ($report_id) {
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.checkr.io/v1/reports/' . $report_id);
                curl_setopt($curl, CURLOPT_USERPWD, $this->api_key . ":");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, false);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);

                $json = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                curl_close($curl);
                $hash = json_decode($json, true);
                if (in_array($http_status,array('201','200'))) {
                    $response['status'] = 'success';
                    $response['message'] = 'success';
                    $response['data'] = $hash;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = isset($hash['error']) ? $hash['error'] : 'Something Went Wrong';
                }
            } catch (\Exception $e) {
                $exception = 'Exception: Class = ' . get_class($e);
                $exception .= ($e->getMessage() != '') ? ' ==== Message = ' . $e->getMessage() : '';
                $exception .= ($e->getCode() != 0) ? ' ==== Code = ' . $e->getCode() : '';
                email_send('webforestteam@gmail.com', supportEmail(), 'Toma Exception Occured in Get Report From Checkr', $exception . '<br />==============================<br />' . print_r($report_id, true));
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Report Id is required');
        }
        return $response;
    }

    public function getCandidate($candidate_id)
    {
        $response = array('status' => 'error', 'message' => 'Something Went Wrong');
        if ($candidate_id) {
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.checkr.io/v1/candidates/' . $candidate_id);
                curl_setopt($curl, CURLOPT_USERPWD, $this->api_key . ":");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, false);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
                $json = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                $hash = json_decode($json, true);
                if ($http_status == '201') {
                    $response['status'] = 'success';
                    $response['message'] = 'success';
                    $response['data'] = $hash;
                } else {
                    $response['status'] = 'error';
                    $response['message'] = isset($hash['error']) ? $hash['error'] : 'Something Went Wrong';
                }
            } catch (\Exception $e) {
                $exception = 'Exception: Class = ' . get_class($e);
                $exception .= ($e->getMessage() != '') ? ' ==== Message = ' . $e->getMessage() : '';
                $exception .= ($e->getCode() != 0) ? ' ==== Code = ' . $e->getCode() : '';
                email_send('webforestteam@gmail.com', supportEmail(), 'Toma Exception Occured in Get Candidate From Checkr', $exception . '<br />==============================<br />' . print_r($candidate_id, true));
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Candidate Id is required');
        }
        return $response;
    }
}