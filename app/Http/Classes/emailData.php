<?php
/**
 * Created by PhpStorm.
 * User: WebForest
 * Date: 1/3/2018
 * Time: 3:49 PM
 */

namespace App\Http\Classes;


use Exception;
use App\Http\Controllers\TemplateController;
use App\Http\Models\GeoLocations;
use App\Http\Models\User;

class emailData
{
    public $fields = [];
    private $userData = [];
    private $extrasFields = [];
    private $variablesData = [];
    private $data = [];
    private $footerHtml = '';
    private $response = '';
    private $pdf_download=false;
    private $redirect_to='';

    public function __construct($requestData = [])
    {
        $this->setFields($requestData);
    }
    public function setRedrictUrl($redirctUrl='')
    {
        $this->redirect_to=$redirctUrl;
    }
    public function setTo($emailTo = '')
    {
        $emailTo = $this->clearInputData($emailTo);
        if ($this->isValidEmailFormat($emailTo)) {
            $this->fields['to'] = trim($emailTo, ",");
        }
    }
    public function isPdfDownload($pdf_download=false)
    {
        $this->pdf_download=$pdf_download;
    }
    public function setCC($emailCC = '')
    {
        $emailCC = $this->clearInputData($emailCC);
        if ($this->isValidEmailFormat($emailCC)) {
            $this->extrasFields['cc'] = trim($emailCC, ",");
        }
    }

    public function getCC()
    {
        return isset($this->extrasFields['cc']) ? $this->extrasFields['cc'] : '';
    }

    public function setBCC($emailBCC = '')
    {
        $emailBCC = $this->clearInputData($emailBCC);
        if ($this->isValidEmailFormat($emailBCC)) {
            $this->extrasFields['bcc'] = trim($emailBCC, ",");
        }
    }

    public function getBCC()
    {
        return isset($this->extrasFields['bcc']) ? $this->extrasFields['bcc'] : '';
    }

    public function setContainerId($container_id = 'container_id')
    {
        $this->fields['container_id'] = $container_id;
    }

    public function getContainerId()
    {
        return isset($this->fields['container_id']) ? $this->fields['container_id'] : 'container_id';
    }

    public function getTo()
    {
        return isset($this->fields['to']) ? $this->fields['to'] : '';

    }

    public function setTestTo($emailTestTo = '')
    {
        $emailTestTo = $this->clearInputData($emailTestTo);
        if ($this->isValidEmailFormat($emailTestTo)) {
            $this->fields['test_to'] = trim($emailTestTo, ",");
        }
    }

    public function getTestTo()
    {
        return isset($this->fields['test_to']) ? $this->fields['test_to'] : '';

    }

    public function setFrom($emailFrom = '')
    {
        $emailFrom = $this->clearInputData($emailFrom);
        if ($this->isValidEmailFormat($emailFrom)) {
            $this->fields['from'] = trim($emailFrom, ",");
        }
    }

    public function getFrom()
    {
        return isset($this->fields['from']) ? $this->fields['from'] : supportEmail();

    }

    public function getHeaderImg()
    {
        return isset($this->fields['header_img']) ? $this->fields['header_img'] :'';
    }

    public function getTitleImg()
    {
        return isset($this->fields['title_img']) ? $this->fields['title_img'] :'';
    }

    public function getSignImg()
    {
        return isset($this->fields['sign_img']) ? $this->fields['sign_img'] :'';
    }

    public function getSocial()
    {
        return isset($this->fields['show_social']) ? $this->fields['show_social'] :0;
    }

    public function setHeaderImg($img = '')
    {
        $img = $this->clearInputData($img);
        $this->fields['header_img'] = $img;
    }

    public function setTitleImg($img = '')
    {
        $img = $this->clearInputData($img);
        $this->fields['title_img'] = $img;
    }

    public function setSocial($show_social = 0)
    {
        $this->fields['show_social'] = $show_social;
    }

    public function setSignImg($img = '')
    {
        $img = $this->clearInputData($img);
        $this->fields['sign_img'] = $img;
    }

    public function setSubject($emailSubject = '')
    {
       // $emailSubject = $this->clearInputData($emailSubject);
        $emailSubject = $emailSubject;
        $this->fields['subject'] = $emailSubject;
    }

    public function getSubject()
    {
        $templates = array(33,44,53,59,60);
        $templateID = isset($this->fields['template_id']) ? intval($this->fields['template_id']) : 0;
        if(in_array($templateID,$templates)){
            $variableData = $this->getVariablesData();
          
            $subject = isset($this->fields['subject']) ? $this->fields['subject'] : '';
            // if(in_array($templateID,[33,44])) {
            //     $subject = str_replace('{RIDE_DATE}', $variableData['{RIDE_DATE}'], $subject);
            // }else if(in_array($templateID,[53,59,60])) {
            //     $subject = str_replace('{COMPANY_NAME}', $variableData['{COMPANY_NAME}'], $subject);
            // }
            foreach($variableData AS $key=>$placeholder)
            {
                $subject = str_replace($key,$placeholder, $subject);
            }
            return $subject;
        }
        return isset($this->fields['subject']) ? $this->fields['subject'] : '';

    }

    public function setBody($body = '')
    {
        $this->fields['body'] = $this->cleanHtml($body);
    }

    public function getBody()
    {
        return isset($this->fields['body']) ? $this->fields['body'] : '';
    }

    public function setTemplateId($id = 0)
    {
        $this->fields['template_id'] = intval($this->clearInputData($id));
    }

    public function getTemplateId()
    {
        return isset($this->fields['template_id']) ? intval($this->fields['template_id']) : 0;
    }

    public function setName($name = '')
    {
        $this->fields['name'] = $this->clearInputData($name);
    }

    public function getName()
    {
        return isset($this->fields['name']) ? trim($this->fields['name']) : '';
    }

    public function setUserId($id = 0)
    {
        $this->fields['user_id'] = $this->clearInputData($id);
    }

    public function getUserId()
    {
        $userId = isset($this->fields['user_id']) ? intval($this->fields['user_id']) : 0;
        if ($userId == 0) {
            $userId = $this->getUserIdFromData();
        }
        return $userId;
    }

    public function getUserIdFromData()
    {
        $userId = isset($this->userData['user_id']) ? intval($this->userData['user_id']) : 0;
        $userId = ($userId > 0) ? $userId : (isset($this->userData['id']) ? intval($this->userData['id']) : 0);
        $userId = ($userId > 0) ? $userId : (isset($this->data['user_id']) ? intval($this->data['user_id']) : 0);
        if ($userId > 0) {
            $this->setUserId($userId);
        }
        return $userId;
    }

    public function setUserData($data = [])
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->userData[$key] = $value;
                /*## Set User ID*/
                if (in_array($key, ['id', 'user_id']) && intval($value) > 0) {
                    $this->setUserId($value);
                }
            }
        }
    }

    public function getUserData()
    {
        $userData = isset($this->userData) ? $this->userData : [];
        return $userData;
    }

    public function setData($data = [])
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
            }
        }
    }

    public function getData()
    {
        $data = isset($this->data) ? $this->data : [];
        return $data;
    }

    public function setLogId($id = 0)
    {
        $this->fields['log_id'] = $this->clearInputData($id);
    }

    public function getLogId()
    {
        return isset($this->fields['log_id']) ? intval($this->fields['log_id']) : 0;
    }

    /*## For Group Emails*/
    public function setEmailBodyId($id = 0)
    {
        $this->fields['email_body_id'] = $this->clearInputData($id);
    }

    public function getEmailBodyId()
    {
        return isset($this->fields['email_body_id']) ? intval($this->fields['email_body_id']) : 0;
    }

    public function setReplyEmailLogId($id = 0)
    {
        $this->fields['reply_email_log_id'] = $this->clearInputData($id);
    }

    public function getReplyEmailLogId()
    {
        return isset($this->fields['reply_email_log_id']) ? intval($this->fields['reply_email_log_id']) : 0;
    }

    public function setParentLogId($id = 0)
    {
        $this->fields['parent_log_id'] = $this->clearInputData($id);
    }

    public function getParentLogId()
    {
        return isset($this->fields['parent_log_id']) ? intval($this->fields['parent_log_id']) : 0;
    }

    public function setResponse($data = [])
    {
        $response = $data;
        $response['status'] = isset($data['status']) ? $data['status'] : 'error';
        $response['message'] = isset($data['message']) ? $data['message'] : '';
        $response['html'] = isset($data['html']) ? $data['html'] : '';
        $this->response = $response;
    }

    public function getResponse()
    {
        return isset($this->response) ? $this->response : [];
    }

    public function setEnableStatus($enable = 0)
    {
        $this->fields['enable_status'] = $enable;
    }

    public function getEnableStatus()
    {
        return isset($this->fields['enable_status']) ? intval($this->fields['enable_status']) : 0;

    }

    public function setGroupLogoStatus($is_group_logo = 0)
    {
        $this->fields['is_group_logo'] = $is_group_logo;
    }

    public function setFooterStatus($footer = 0)
    {
        $this->fields['footer_status'] = $footer;
    }

    public function setHeaderStatus($header = 0)
    {
        $this->fields['is_header'] = $header;
    }

    /*## Ticket #2105*/
    public function setUnsubscribeStatus($unsubscribe = 0)
    {
        $this->fields['unsubscribe_status'] = $unsubscribe;
    }

    /*## Ticket #2137*/
    public function setDescription($description = '')
    {
        $this->fields['description'] = $description;
    }

    /*## Ticket #2105*/
    public function setEmailTypeId($email_type_id = 0)
    {
        $this->fields['email_type_id'] = $email_type_id;
    }

    public function getGroupLogoStatus()
    {
        return isset($this->fields['is_group_logo']) ? trim($this->fields['is_group_logo']) : '';
    }

    public function getFooterStatus()
    {
        return isset($this->fields['footer_status']) ? intval($this->fields['footer_status']) : 0;
    }

    public function getHeaderStatus()
    {
        return isset($this->fields['is_header']) ? intval($this->fields['is_header']) : 0;
    }

    /*## Ticket #2105*/
    public function getUnsubscribeStatus()
    {
        return isset($this->fields['unsubscribe_status']) ? intval($this->fields['unsubscribe_status']) : 0;
    }

    /*## Ticket #2137*/
    public function getDescription()
    {
        return isset($this->fields['description']) ? trim($this->fields['description']) : '';
    }

    /*## Ticket #2105*/
    public function getEmailTypeId()
    {
        return isset($this->fields['email_type_id']) ? intval($this->fields['email_type_id']) : 1;
    }

    public function isValidEmailFormat($email = '')
    {
        $flag = false;
        $email = $this->clearInputData($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $flag = true;
        }
        return $flag;
    }

    public function setFields($requestData = array())
    {
        if (isset($requestData['from'])) {
            $this->setFrom($requestData['from']);
        }
        if (isset($requestData['to'])) {
            $this->setTo($requestData['to']);
        }
        if (isset($requestData['cc_email'])) {
            $this->setCC($requestData['cc_email']);
        }
        if (isset($requestData['bcc_email'])) {
            $this->setBCC($requestData['bcc_email']);
        }
        if (isset($requestData['test_to'])) {
            $this->setTestTo($requestData['test_to']);
        }
        if (isset($requestData['name'])) {
            $this->setName($requestData['name']);
        }
        if (isset($requestData['header_img'])) {
            $this->setHeaderImg($requestData['header_img']);
        }
        if (isset($requestData['title_img'])) {
            $this->setTitleImg($requestData['title_img']);
        }
        if (isset($requestData['show_social'])) {
            $this->setSocial(isset($requestData['show_social'])?$requestData['show_social']:0);
        }
        if (isset($requestData['sign_img'])) {
            $this->setSignImg($requestData['sign_img']);
        }
        if (isset($requestData['subject'])) {
            $this->setSubject($requestData['subject']);
        }
        if (isset($requestData['is_group_logo'])) {
            $this->setGroupLogoStatus($requestData['is_group_logo']);
        }
        if (isset($requestData['description'])) {
            $this->setDescription($requestData['description']);
        }
        if (isset($requestData['body'])) {
            $this->setBody($requestData['body']);
        }
        if (isset($requestData['footer_status'])) {
            $this->setFooterStatus($requestData['footer_status']);
        }

        if (isset($requestData['is_header'])) {
            $this->setHeaderStatus(isset($requestData['is_header'])?$requestData['is_header']:0);
        }

        if (isset($requestData['unsubscribe_status'])) {
            $this->setUnsubscribeStatus($requestData['unsubscribe_status']);
        }
        if (isset($requestData['email_type_id'])) {
            $this->setEmailTypeId($requestData['email_type_id']);
        }
        if (isset($requestData['enable_status'])) {
            $this->setEnableStatus($requestData['enable_status']);
        }
        if (isset($requestData['container_id'])) {
            $this->setContainerId($requestData['container_id']);
        }
        if (isset($requestData['reply_email_log_id'])) {
            $this->setReplyEmailLogId($requestData['reply_email_log_id']);
        }
        if (isset($requestData['parent_log_id'])) {
            $this->setParentLogId($requestData['parent_log_id']);
        }
        /*## Template Id*/
        if (isset($requestData['template_id'])) {
            $this->setTemplateId($requestData['template_id']);
        }
        /*## Trigger Day*/
        if (isset($requestData['trigger_day'])) {
            $this->setTriggerDay($requestData['trigger_day']);
        }
        /*## Package Id*/
        if (isset($requestData['package_id'])) {
            $this->setPackageId($requestData['package_id']);
        }
        /*## Drip Type*/
        if (isset($requestData['drip_type'])) {
            $this->setDripType($requestData['drip_type']);
        }
        /*## Check For attachments*/
        if (isset($requestData['file_data']) && !empty($requestData['file_data'])) {
            $filesData = json_decode(stripslashes($requestData['file_data']));
            if ($filesData) {
                foreach ($filesData as $file) {
                    $file_path = isset($file->url) ? $file->url : '';
                    $file_name = isset($file->name) ? $file->name : '';
                    if ($file_path != '' && $file_name != '') {
                        $this->extrasFields['file_path'] = $file_path;
                        $this->extrasFields['file_name'] = $file_name;
                        $this->extrasFields['file_data'][] = array('file_path' => $file_path, 'file_name' => $file_name);
                    }
                }
            }
        }
    }

    public function getFields()
    {
        return isset($this->fields) ? $this->fields : [];
    }

    public function setExtrasFields($requestData = [])
    {
        $this->extrasFields['from_name'] = isset($requestData['from']) ? trim($requestData['from']) : supportEmail();
    }

    public function getExtrasFields()
    {
        return isset($this->extrasFields) ? $this->extrasFields : [];
    }

    public function clearInputData($data = '')
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function getEmailBody()
    {
        $emailBody = $this->getBody();
        if ($this->getGroupLogoStatus() != '') {
            $logoHtml = $this->getGroupLogoHtml();
            $emailBody = str_replace('{BODY_HTML}', $emailBody, $logoHtml);
        }
        if ($this->getUnsubscribeStatus()) {
            $emailBody = $emailBody . '{UNSUBSCRIBE_LINK}';
        }
        if ($this->getFooterStatus()) {
            $footerHtml = $this->getFooterHtml();
            $emailBody = $emailBody . $footerHtml;
        }
        $emailBody = $this->cleanBodyVariables($emailBody);
        return $emailBody;
    }

    public function preview()
    {
        $this->setVariablesData($this->defaultVariablesData());
        $data = [];
        $body = $this->getEmailBody();
        $unsubscribeText = ($this->getUnsubscribeStatus()) ? $this->unsubscribeHTMl() : '';
        $body = str_replace('{UNSUBSCRIBE_LINK}', $unsubscribeText, $body);
        $data['status'] = 'success';
        $data['html'] = create_modal(['heading' => 'Email Preview', 'inner_html' => $body, 'id' => $this->getContainerId() . 'Preview', 'class' => 'xl']);;
        $this->setResponse($data);
    }

    public function save()
    {
        $response = [];
        $templateId = intval($this->getTemplateId());
        $record = array();
        $body = $this->getBody();
        $record['name'] = $this->getName();
        $record['email_from'] = $this->getFrom();
        $record['subject'] = $this->getSubject();
        $record['description'] = $this->getDescription();
        $record['is_footer'] = $this->getFooterStatus();
        $record['show_social'] = $this->getSocial();
        $record['is_header'] = $this->getHeaderStatus();
        $record['is_unsubscribe'] = $this->getUnsubscribeStatus();
        $record['is_active'] = $this->getEnableStatus();
        $record['header_img'] = $this->getHeaderImg();
        $record['title_img'] = $this->getTitleImg();
        $record['sign_img'] = $this->getSignImg();
        $record['body'] = $body;
        if ($templateId > 0) {
            $record['updated_at'] = date('Y-m-d H:i:s');
            $emailData = \App\Http\Models\EmailTemplates::findOrFail($templateId);
            if ($emailData) {
                $emailData->update($record);
                $response['status'] = 'success';
                $response['message'] = ' Email Template Updated.';
                // if ($this->getEmailTypeId() == 2) {
                //     $response['redirect_to'] = '/rider_email_templates';
                // } elseif ($this->getEmailTypeId() == 3) {
                //     $response['redirect_to'] = '/driver_email_templates';
                // } else {
                //     $response['redirect_to'] = '/email_templates';
                // }
            }
        } else {
            $record['email_type_id'] = $this->getEmailTypeId();// By default it's 1=> admin emails
            $record['created_at'] = date('Y-m-d H:i:s');
            $emailData = \App\Http\Models\EmailTemplates::create($record);
            $templateId=$emailDataId = isset($emailData->id) ? intval($emailData->id) : 0;
            if ($emailDataId > 0) {
                $this->setTemplateId($emailDataId);
                $response['status'] = 'success';
                $response['message'] = ' Email Template Created.';
                // if ($this->getEmailTypeId() == 2) {
                //     $response['redirect_to'] = '/rider_email_templates';
                // } elseif ($this->getEmailTypeId() == 3) {
                //     $response['redirect_to'] = '/driver_email_templates';
                // } else {
                //     $response['redirect_to'] = '/email_templates';
                // }
            }
        }

        $response['redirect_to'] = "/email_template/".encode($templateId);
        $this->setResponse($response);
    }

    public function testSend()
    {
        $response = [];
        if ($this->getTestTo() != '' && $this->getSubject() != '') {
            $this->setVariablesData($this->defaultVariablesData());
            try {
                $body = $this->getEmailBody();
                $unsubscribeText = ($this->getUnsubscribeStatus()) ? $this->unsubscribeHTMl() : '';
                $body = str_replace('{UNSUBSCRIBE_LINK}', $unsubscribeText, $body);
                $response['send_response'] = email_send($this->getTestTo(), $this->getFrom(), $this->getSubject(), $body, $this->getExtrasFields());
                $response['message'] = 'Email sent at: ' . $this->getTestTo();
                $response['status'] = 'success';
            } catch (Exception $e) {
                email_send(devTeamEmail(), $this->getSubject(), $this->getSubject() . ' Exception Generated', $this->getEmailBody(), $this->getExtrasFields());
                $response['send_response'] = $e;
                $response['message'] = 'Exception generated';
                $response['status'] = 'error';
            }
        } else {
            $errorMsgArr = [];
            if ($this->getTestTo() == '') {
                $errorMsgArr[] = "Test To email can't be empty.";
            }
            if ($this->getSubject() == '') {
                $errorMsgArr[] = "Subject can't be empty.";
            }
            $response['message'] = implode('<br> ', $errorMsgArr);
        }
        $this->setResponse($response);
    }

    public function  send()
    {
        $response = ['status' => 'error'];
        if ($this->getTo() != '' && $this->getSubject() != '') {
            try {
                $this->setVariablesData($this->getVariablesData());
                $body = $this->saveLog();
                if($this->pdf_download)
                {
                    $pdf_template=new TemplateController();
                    $pdf_template->emailTemplateDownloadInPdf($body);

                    return true;
                }   
                $response['send_response'] = email_send($this->getTo(), $this->getFrom(), $this->getSubject(), $body, $this->getExtrasFields());
                $response['message'] = 'Email sent at: ' . $this->getTo();
                if($this->redirect_to!='')
                $response['redirect_to'] = $this->redirect_to;
                else
                $response['redirect_to'] = "/email_reply/".encode($this->getReplyEmailLogId());
                $response['status'] = 'success';
                $response['data'][] = $this->getFrom();
                $response['data'][] = $this->getSubject();
                $response['data'][] = $body;
                $response['status'] = 'success';
            } catch (Exception $e) {
                email_send(devTeamEmail(), $this->getFrom(), $this->getSubject() . ' Exception Generated', $this->getEmailBody(), $this->getExtrasFields());
                $response['send_response'] = $e;
                $response['message'] = 'Exception generated';
            }
        } else {
            $errorMsgArr = [];
            if ($this->getTo() == '') {
                $errorMsgArr[] = "To email can't be empty.";
            }
            if ($this->getSubject() == '') {
                $errorMsgArr[] = "Subject can't be empty.";
            }
            $response['message'] = implode('<br> ', $errorMsgArr);
        }
        $this->setResponse($response);
    }

    public function saveLog()
    {
        $record = array();
        $body = $this->getEmailBody();
        $record['to'] = $this->getTo();
        $record['from'] = $this->getFrom();
        $record['subject'] = $this->getSubject();
        $record['template_id'] = intval($this->getTemplateId());
        $record['user_id'] = intval($this->getUserId());
        $record['actor_id'] = intval(loggedinId());
        $record['actor_type_id'] = intval(userRoleId());
        $record['email_body_id'] = intval($this->getEmailBodyId());
        $emailLog = \App\Http\Models\EmailLog::create($record);
        ## FOR EMAIL OPEN TRACKING AND Email-Opens-Alert-Feature
        $emailLogId = isset($emailLog->id) ? intval($emailLog->id) : 0;
        $this->setLogId($emailLogId);
        //this is update due to pdf functionality add in template 
        if ($emailLogId > 0 && !in_array($this->getTemplateId(),[64])) {
            /*## Ticket #2105*/
            $unsubscribeText = ($this->getUnsubscribeStatus()) ? $this->unsubscribeHTMl($emailLogId) : '';
            $body = str_replace('{UNSUBSCRIBE_LINK}', $unsubscribeText, $body);
            $link = base_url('email_log/' . $emailLogId);
            $imgTrackTag = '<img src="' . $link . '">';
            $body = $body . ' ' . $imgTrackTag;
        }else{
            $body = str_replace('{UNSUBSCRIBE_LINK}','', $body);
        }
        return $body;
    }

    public function saveBody()
    {
        $record = array();
        $record['body'] = $this->getEmailBody();
        $record['email_log_id'] = intval($this->getLogId());
        $record['is_replied'] = intval(0);// bt default It's 1 for admin generated emails
        $emailParentLogId = intval($this->getParentLogId());
        $replyEmailLogId = intval($this->getReplyEmailLogId());
        if ($emailParentLogId > 0) {
            $record['parent_log_id'] = $emailParentLogId;
            $emailBodyUpdateLog = \App\Http\Models\EmailThreading::where('parent_log_id', $emailParentLogId)->update(['is_replied' => 1]);
        } elseif ($replyEmailLogId > 0) {
            /*## As per discussion with Team (We will Reference child email to
             it's Top Parent email Thread so if there are more than one child emails then parent email id will be same for all)*/
            $emailParentLogId = intval($this->getParentLogId());
            $record['parent_log_id'] = ($emailParentLogId > 0) ? $emailParentLogId : $replyEmailLogId;
            $emailBodyUpdateLog = \App\Http\Models\EmailThreading::where('email_log_id', $replyEmailLogId)->update(['is_replied' => 1]);
        }
        $emailBodyLog = \App\Http\Models\EmailThreading::create($record);
        return $emailBodyLog;
    }

    public function saveGroupEmailBody()
    {
        $record = array();
        $record['body'] = $this->getEmailBody();
        $record['user_account_status'] = $this->getUserAccountStatus();
        $insertData = \App\Http\Models\EmailBody::create($record);
        $inserted_id = isset($insertData->id) ? intval($insertData->id) : 0;
        $this->setEmailBodyId($inserted_id);
    }

    public function defaultVariablesData()
    {
        $userId = $this->getUserId();
        $userData = $this->getUserData();

        $names = cleanUserNames($userData);
        $number_of_hour = "";
        if(isset($userData['ride_data']['type']) && $userData['ride_data']['type'] == "hourly"){
            $to_hour_key = "Number of Hour";
            $to_hour_val = isset($userData['ride_type_data']['hourly_duration']) ? $userData['ride_type_data']['hourly_duration'] : '';
            $number_of_hour = $to_hour_val;
        }else{
            $to_hour_key = "To";
            $to_hour_val = isset($userData['ride_data']['to']) ? $userData['ride_data']['to'] : 'Ride To';
        }

//        $sub_total="";
////        $payment_method = "Cash";
////        if(isset($userData["ride_schedule"])){
////            $sub_total = round((($userData['ride_schedule']['base_price'] + $userData['ride_schedule']['tip']) - $userData['ride_schedule']['discount']),2);
////            if(isset($userData["ride_trans"])){
////                if(isset($userData["ride_trans"]["source"]) && $userData["ride_trans"]["source"] == "card"){
////                    $payment_method = "CC ";
////                    if(isset($userData["ride_trans_card"]["card_number"])){
////                        $payment_method .=  $userData["ride_trans_card"]["card_number"];
////                    }
////                }
////            }
////        }
        $userData['county']=$this->getLocationCounty($userData);
        $variable = array(
            '{USER_PROFILE_LINK}' => (isset($userData['user_profile_link'])) ? $userData['user_profile_link'] : '',
            '{EMAIL_BODY}' => (isset($userData['email_body'])) ? $userData['email_body'] : '',
            '{USER_ID}' => (isset($names['id']) && $names['id'] > 0) ? $names['id'] : 'User ID',
            '{USER_EMAIL}' => (isset($userData['email'])) ? $userData['email'] : '',
            '{USER_PHONE}' => (isset($names['phone']) && $names['phone'] > 0) ? formatPhone($names['phone']) : '',
            '{EMAIL}' => (isset($names['email']) && $names['email']!= '') ? $names['email'] : 'Email',
            '{USER_FIRST_NAME}' => (isset($userData['first_name']) && $userData['first_name'] != '') ? $userData['first_name'] : 'User First Name',
            '{USER_LAST_NAME}' => (isset($userData['last_name']) && $userData['last_name'] != '') ? $userData['last_name'] : 'User Last Name',
            '{CITY}' => (isset($userData['city']) && $userData['city'] != '') ? $userData['city'] : 'User’s City',
            '{STATE}' => (isset($userData['state']) && $userData['state'] != '') ? $userData['state'] : 'User’s State',
            '{ADDRESS}' => (isset($userData['address']) && $userData['address'] != '') ? $userData['address'] : 'User’s Adress',
            '{ZIP}' => (isset($userData['postal_code']) && $userData['postal_code'] != '') ? $userData['postal_code'] : 'User’s Zip',
            '{COUNTY}'=>(isset($userData['county']) && $userData['county'] != '') ? $userData['county'] : 'County',
            '{PROFILE_ID}' => (isset($userData['profile_id']) && $userData['profile_id'] != '') ? $userData['profile_id'] : 'Profile id',
            '{DRIVER_ID}' => (isset($names['driver_id']) && $names['driver_id'] > 0) ? $names['driver_id'] : '',
            '{RIDER_ID}' => (isset($names['rider_id']) && $names['rider_id'] > 0) ? $names['rider_id'] : '',
            '{DRIVER_FIRST_NAME}' => (isset($names['driver_first_name']) && $names['driver_first_name'] != '') ? $names['driver_first_name'] : 'Driver First Name',
            '{DRIVER_LAST_NAME}' => (isset($names['driver_last_name']) && $names['driver_last_name'] != '') ? $names['driver_last_name'] : 'Driver Last Name',
            '{RIDER_FIRST_NAME}' => (isset($names['rider_first_name']) && $names['rider_first_name'] != '') ? $names['rider_first_name'] : 'Rider First Name',
            '{RIDER_LAST_NAME}' => (isset($names['rider_last_name']) && $names['rider_last_name'] != '') ? $names['rider_last_name'] : 'Rider Last Name',
            '{RIDER_NAME}' => (isset($userData['rider_name']) && $userData['rider_name'] != '') ? $userData['rider_name'] : 'Rider Name',
            '{AGREED_PRICE}' => isset($userData["ride_schedule"]['base_price']) ? $userData["ride_schedule"]['base_price'] : 'Agreed Price',
            '{RIDE_TIP}' => isset($userData['ride_schedule']['tip']) ? $userData['ride_schedule']['tip'] : 'Ride Tip',
            '{RIDE_DISCOUNT}' => isset($userData['ride_schedule']['discount']) ? $userData['ride_schedule']['discount'] : 'Ride Discount',
            '{TOTAL_PRICE}' => isset($userData['ride_schedule']['base_price']) ? $userData['ride_schedule']['base_price'] : 'Total Price',
            '{PAID_BY_SOURCE}' => isset($userData['paid_by_source']) ? $userData['paid_by_source'] : 'Paid By Source',
            '{RIDE_PAYMEMT_AT}' => isset($userData['ride_payment_at']) ? $userData['ride_payment_at'] : 'Ride Payment At',
            '{RIDE_START_TIME}' => isset($userData['ride_data']['ride_time']) ?  rideTimeFormat("RIDE_START_TIME",$userData['ride_data']['ride_time']) : 'Ride Start Time',
            '{RIDE_DATE_ONLY}' => isset($userData['ride_data']['ride_time']) ?  rideTimeFormat("RIDE_DATE_ONLY",$userData['ride_data']['ride_time']) : 'Ride Date Only',
            '{RIDE_DATE_TIME}' => isset($userData['ride_data']['ride_time']) ?  rideTimeFormat("RIDE_DATE_TIME",$userData['ride_data']['ride_time']) : 'Ride Date Time',
            '{RIDE_FULL_DATE}' => isset($userData['ride_data']['ride_time']) ?  rideTimeFormat("RIDE_FULL_DATE",$userData['ride_data']['ride_time']) : 'Ride Full Date',
            '{RIDE_DAY_DATE_ONLY}' => isset($userData['ride_data']['ride_time']) ?  rideTimeFormat("RIDE_DAY_DATE_ONLY",$userData['ride_data']['ride_time']) : 'Ride Day Date Only',
            '{RIDE_DATE_SHORT}' => isset($userData['ride_data']['ride_time']) ?  rideTimeFormat("RIDE_DATE_SHORT",$userData['ride_data']['ride_time']) : 'Ride Date Short',
            '{RIDE_FROM}' => isset($userData['ride_data']['from']) ? $userData['ride_data']['from'] : 'Ride From',
            '{RIDE_TO}' => isset($userData['ride_data']['to']) ? $userData['ride_data']['to'] : 'Ride To',
            '{SUB_TOTAL}' => isset($userData['sub_total']) ? $userData['sub_total'] : '',
            '{TO_HOUR_KEY}' =>$to_hour_key,
            '{NUMBER_OF_HOURS}' =>$number_of_hour,
            '{TO_HOUR_VAL}'=>$to_hour_val,
            '{NEW_EMAIL}' => isset($userData['new_email']) ? $userData['new_email'] : 'New Email',
            '{STATUS}'    => isset($userData['status']) ? $userData['status'] : 'Status',
            '{TOTAL_AMOUNT}'    => isset($userData['total_amount']) ? $userData['total_amount'] : 'TOTAL AMOUNT',
            '{COMMENT_LINK}' => (intval($userId) > 0) ? '<a href="' . base_url('contact_us/' . encode($userId)) . '" target="_BLANK" />Give FeedBack</a>' : 'Comment Link',
            '{SUBSCRIPTION_CHARGED_AT}' => isset($userData['subscription_charged_at']) ? $userData['subscription_charged_at'] : 'Subscription Charged At',
            '{SUBSCRIPTION_AMOUNT}' => isset($userData['subscription_amount']) ? $userData['subscription_amount'] : 'Subscription Amount',
            '{DISCOUNT_DISCRIPTION}' => isset($userData['discount_description']) ? $userData['discount_description'] : '',
            '{RIDE_SHARE_TABLE}' => isset($userData['ride_share_table']) ? rideShareInsuranceTableHtml($userData['ride_share_table']) : 'Ride Share Table',
            '{VERIFY_EMAIL}' => isset($userData['activation_link']) ? '<div style="text-align: center;">
            <a href="' . $userData['activation_link'] . '" style="background:#354fb7;width:160px;border-radius:8px;font-size:16px; text-transform: uppercase;color: #fff;text-decoration: none;display: inline-block;vertical-align: middle;padding:15px 10px;"> VERIFY EMAIL</a></div>' : 'Verify Email',
            '{VERIFY_EMAIL_URL}' => isset($userData['activation_link']) ?  isset($userData['activation_link']): 'Verify Email Url', 
            '{RIDE_DATE}' => isset($userData['ride_data']['ride_time']) ? date('F jS',$userData['ride_data']['ride_time']) : '{RIDE_DATE}',
           
            '{CHECKR_LINK}' => isset($userData['checkr_invitation_link']) ? '<a href="' . $userData['checkr_invitation_link'] . '" target="_BLANK" />Background Check Link</a>' : 'Background Check Link',
           
            '{BILLING_DATE}' => isset($userData['billing_date']) ? $userData['billing_date'] : date('m-d-Y h:i A'),
           
            '{COMPANY_FIRST_NAME}' => (isset($userData['company_first_name']) && $userData['company_first_name'] != '') ? $userData['company_first_name'] : 'Company First Name',
            '{CHECKOUT_LINK}' => (isset($userData['delivery_checkout_link']) && $userData['delivery_checkout_link'] != '') ? $userData['delivery_checkout_link'] : 'delivery',
            //this is new add
            '{PDF_GUIDE_LINK}' => (isset($names['pdf_guide_link']) && $names['pdf_guide_link']!= '') ?$names['pdf_guide_link'] : '',
            '{CUSTOMER_FIRST_NAME}' => (isset($userData['customer_first_name']) && $userData['customer_first_name']!= '') ?$userData['customer_first_name'] : 'Customer Name',
            '{COMPANY_NAME}' => (isset($userData['company_name']) && $userData['company_name']!= '') ?$userData['company_name'] : '{COMPANY_NAME}',
            '{COMPANY_TYPE}' => (isset($userData['company_type']) && $userData['company_type']!= '') ?$userData['company_type'] : 'Company Type',
            '{COMPANY_ID}' => (isset($names['company_id']) && $names['company_id']!= '') ?$names['company_id'] : 'Company ID#',
            '{COMMENTS}' => (isset($names['comments']) && $names['comments']!= '') ?$names['comments'] : 'Comments...',
            '{FIRST_NAME}' => (isset($names['first_name']) && $names['first_name']!= '') ?$names['first_name'] : '',
            '{LAST_NAME}' => (isset($names['last_name']) && $names['last_name']!= '') ?$names['last_name'] : '',
            '{DELIVERY_TYPE}' => (isset($names['delivery_type']) && $names['delivery_type']!= '') ?$names['delivery_type'] : '',
            '{DELIVERY_DETAILS}' => (isset($names['delivery_details']) && $names['delivery_details']!= '') ?$names['delivery_details'] : '',
            '{DELIVERY_TIME}' => (isset($names['delivery_time']) && $names['delivery_time']!= '') ?$names['delivery_time'] : '',
            '{DELIVERY_DATE}' => (isset($names['delivery_date']) && $names['delivery_date']!= '') ?$names['delivery_date'] : '',
            '{ZIP_CODE}' =>  (isset($userData['zip_code']) && $userData['zip_code'] != '') ? $userData['zip_code'] : 'Zip Code',
           

        );
         return array_merge(default_placeholder(false),article_placeholder(false),$variable);
    }
    public function getLocationCounty($user)
    {
        $county=new GeoLocations();
        $filterAdd=false;
        if(isset($userData['city']) && $userData['city'] != '')
        {
            $county->where('city',$userData['city'] );
            $filterAdd=true;
        }            
        if(isset($userData['state']) && $userData['state'] != '')
        {
            $county->where('state',$userData['state'] );
            $filterAdd=true;
        } 
       

        if(isset($userData['postal_code']) && $userData['postal_code'] != '')
        {
            $county->where('zipcode',$userData['postal_code']);
            $filterAdd=true;
        }
        if($filterAdd)
        {
            $county=$county->first();
            if($county)
            {
                return $county->county;
            }
        }
        
        if($this->getUserId()>0)
        {
           $user= User::with('location')->find($this->getUserId());
           if($user->location->count()>0)
           return  $user->location->county;
          
        }
        return '';
    }

    public function setVariablesData($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->variablesData[$key] = $value;
            }
        }
    }

    public function getVariablesData()
    {
        $variablesData = (isset($this->variablesData) && !empty($this->variablesData) && is_array($this->variablesData)) ? $this->variablesData : $this->defaultVariablesData();
        return $variablesData;
    }

    public function setFooterHtml($html = '')
    {
        $this->footerHtml = $this->cleanHtml($html);
    }

    public function getFooterHtml()
    {
        $footerHtml = isset($this->footerHtml) ? $this->footerHtml : '';
        if ($footerHtml == '') {
            $footerHtml = $this->defaultFooterHtml();
            $this->setFooterHtml($footerHtml);
        }
        //return $footerHtml;
        return '';
    }

    public function getGroupLogoHtml()
    {
        return $this->group_email_logo();
    }

    public function defaultFooterHtml()
    {
        $html = '<div style="height:40px;line-height:40px;">&nbsp;</div>';
        $html .= '<div style="font-size:12px;text-align:center;">';
        $html .= '<p><a href = "' . base_url() . '" > www.GoToma.com</a>  |  <a href = "mailto:' . supportEmail() . '" > ' . supportEmail() . '</a></p></div> ';
        $html .= '</div>';
        return $html;
    }

    public function unsubscribeHTMl($emailLogId = 0)
    {
        $html = '';
       
        if ($emailLogId > 0) {
            /*## Unsubscribe Link for Users*/
            $uLink = base_url('unsubscribe/' . encode($emailLogId));
        } else {
            $uLink = 'javascript:void(0)';
        }
        /*## Ticket #2105*/
        $html .= '<div style = "text-align: center;">';
        $html .= '<p>To unsubscribe from future emails, <a href="' . $uLink . '">CLICK HERE</a>.</p>';
        $html .= '</div>';
        return $html;
    }

    public function group_email_logo()
    {
        $html = '<div style="font-family:arial;font-size:12px;max-width:600px;width:100%;margin: 0 auto;">';
        $type = $this->getGroupLogoStatus();
        if ($type == 'tlogo') {
            
            $html .= '<div style="text-align:center;">';
            $html .= '<img src = "' . imgUrl(asset('images/toma-black.png')) . '" alt = ""/>';
            $html .= '</div>';
            $html .= '<div style="height:40px;line-height:40px;">&nbsp;</div>';
            $html .= '<div style="font-size:21px;font-weight:bold;color:#354fb7;text-align:center;font-family:arial;">Welcome to Toma!</div>';
            $html .= '</div>';
            $html .= '{BODY_HTML}';
        } elseif ($type == 'newsletter') {
            $html .= '<div style="text-align:center;">';
            $html .= '<img src = "' . imgUrl(asset('images/toma-black.png')) . '" alt = ""/>';
            $html .= '</div>';
            $html .= '<div style="height:40px;line-height:40px;">&nbsp;</div>';
            $html .= '<div style="font-size:21px;font-weight:bold;color:#354fb7;text-align:center;font-family:arial;">Welcome to Toma!</div>';
            $html .= '</div>';
            $html .= '{BODY_HTML}';
        } else {
            $html .= '<div style="text-align:center;">';
            $html .= '<img src = "' . imgUrl(asset('images/toma-black.png')) . '" alt = ""/>';
            $html .= '</div>';
            $html .= '<div style="height:40px;line-height:40px;">&nbsp;</div>';
            $html .= '{BODY_HTML}';
        }
        $html .= '</div>';
        return $html;
    }

    public function cleanBodyVariables($body = '')
    {
        $cln_variables = $this->getVariablesData();
        $body = ($body != '') ? $body : $this->getBody();
        $body = str_replace(array_keys($cln_variables), $cln_variables, trim($body));
        return $body;
    }

    public function cleanHtml($html = '')
    {
        $html = preg_replace(' / ' . preg_quote('[') . ' .*?' . preg_quote(']') . ' / ', '', $html);
        // Clean up things like &amp;
        $html = html_entity_decode($html);
        // Strip out any url-encoded stuff
        $html = urldecode($html);
        // Replace Multiple spaces with single space
        $html = preg_replace(' / +/', ' ', $html);
        $html = quoted_printable_decode($html);
        $html = str_replace(array("&gt;", "&lt;"), "", $html);
        $html = html_entity_decode($html);
        $html = htmlspecialchars_decode($html);
        $html = html_entity_decode($html);
        // Trim the string of leading/trailing space
        $html = trim($html);
        return $html;
    }

    /*## Ticket #1963*/
    public function saveDripPackageTemplate()
    {
        $response = [];
        $templateId = intval($this->getTemplateId());
        $record = array();
        $body = $this->getBody();
        $record['name'] = $this->getName();
        $record['email_from'] = $this->getFrom();
        $record['subject'] = $this->getSubject();
        $record['trigger_day'] = $this->getTriggerDay();
        $record['package_id'] = $this->getPackageId();
        $record['is_footer'] = $this->getFooterStatus();
        $record['is_unsubscribe'] = $this->getUnsubscribeStatus();
        $record['is_active'] = $this->getEnableStatus();
        $record['body'] = $body;
        $record['email_type_id'] = 1;// By default it's 1=> admin emails
        if ($templateId > 0) {
            $record['updated_at'] = date('Y-m-d H:i:s');
            $emailData = \App\Http\Models\EmailDripPackageTemplates::findOrFail($templateId);
            if ($emailData) {
                $emailData->update($record);
                $response['status'] = 'success';
                $response['message'] = ' Email Drip Template Updated.';
                $response['redirect_to'] = '/email_drip_package_templates';
            }
        } else {
            $record['created_at'] = date('Y-m-d H:i:s');
            $emailData = \App\Http\Models\EmailDripPackageTemplates::create($record);
            $emailDataId = isset($emailData->id) ? intval($emailData->id) : 0;
            if ($emailDataId > 0) {
                $this->setTemplateId($emailDataId);
                $response['status'] = 'success';
                $response['message'] = ' Email Drip Template Created.';
                $response['redirect_to'] = '/email_drip_package_templates';
            }
        }
        $this->setResponse($response);
    }

    /*## Ticket #2105*/
    public function saveDripTemplate()
    {
        $response = [];
        $templateId = intval($this->getTemplateId());
        $record = array();
        $body = $this->getBody();
        $record['name'] = $this->getName();
        $record['email_from'] = $this->getFrom();
        $record['subject'] = $this->getSubject();
        $record['trigger_day'] = $this->getTriggerDay();
        $record['type'] = $this->getDripType();
        $record['is_footer'] = $this->getFooterStatus();
        $record['show_social'] = $this->getSocial();
        $record['is_header'] = $this->getHeaderStatus();
        $record['header_img'] = $this->getHeaderImg();
        $record['title_img'] = $this->getTitleImg();
        $record['sign_img'] = $this->getSignImg();
        $record['is_unsubscribe'] = $this->getUnsubscribeStatus();
        $record['is_active'] = $this->getEnableStatus();
        $record['body'] = $body;
        if ($templateId > 0) {
            $record['updated_at'] = date('Y-m-d H:i:s');
            $emailData = \App\Http\Models\EmailDripTemplates::findOrFail($templateId);
            if ($emailData) {
                $emailData->update($record);
                $response['status'] = 'success';
                $response['message'] = ' Email Drip Template Updated.';
                $response['redirect_to'] = '/driver_email_templates';
            }
        } else {
            $record['created_at'] = date('Y-m-d H:i:s');
            $emailData = \App\Http\Models\EmailDripTemplates::create($record);
            $emailDataId = isset($emailData->id) ? intval($emailData->id) : 0;
            if ($emailDataId > 0) {
                $this->setTemplateId($emailDataId);
                $response['status'] = 'success';
                $response['message'] = ' Email Drip Template Created.';
                $response['redirect_to'] = '/driver_email_templates';
            }
        }

        if($emailData->email_type_id == 2){
            $response['redirect_to'] = '/rider_email_templates';
        }
        $this->setResponse($response);
    }

    /*## Ticket #1963*/
    public function setTriggerDay($trigger_day = 0)
    {
        $this->fields['trigger_day'] = intval($this->clearInputData($trigger_day));
    }

    /*## Ticket #1963*/
    public function getTriggerDay()
    {
        return isset($this->fields['trigger_day']) ? intval($this->fields['trigger_day']) : 0;
    }

    /*## Ticket #1963*/
    public function setPackageId($id = 0)
    {
        $this->fields['package_id'] = intval($this->clearInputData($id));
    }

    /*## Ticket #2105*/
    public function setDripType($type = '')
    {
        $this->fields['drip_type'] = trim($this->clearInputData($type));
    }

    /*## Ticket #1963*/
    public function getPackageId()
    {
        return isset($this->fields['package_id']) ? intval($this->fields['package_id']) : 0;
    } /*## Ticket #2105*/
    public function getDripType()
    {
        return isset($this->fields['drip_type']) ? trim($this->fields['drip_type']) : '';
    }

    /*## Ticket #2134*/
    public function setUserAccountStatus($user_account_status = '')
    {
        $this->fields['user_account_status'] = $this->clearInputData($user_account_status);
    }

    public function getUserAccountStatus()
    {
        return isset($this->fields['user_account_status']) ? $this->fields['user_account_status'] : '';
    }
}