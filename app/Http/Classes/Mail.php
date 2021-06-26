<?php
/**
 * Created by PhpStorm.
 * User: WebForest
 * Date: 8/4/2017
 * Time: 12:12 PM
 */

namespace App\Http\Classes;

class Mail extends \SendGrid\Mail
{
    public function __construct($from = null, $subject = null, $to = null, $content = null)
    {
        if (!empty($from) &&  !empty($subject) && !empty($to) && !empty($content)) {
            $this->setFrom($from);
            $this->setSubject($subject);
            $personalization = new Personalization();
            $personalization->addTo($to);
            $this->addPersonalization($personalization);
            $this->addContent($content);
        }
    }
}