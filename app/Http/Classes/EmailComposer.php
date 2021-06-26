<?php
/**
 * Created by PhpStorm.
 * User: WebForest
 * Date: 1/2/2018
 * Time: 5:17 PM
 */

namespace App\Http\Classes;


use App\Http\Models\Packages;

class EmailComposer
{
    private $config = [];
    private $user_type=null;
    public function __construct($defaultConfig = [])
    {
        if (isset($defaultConfig['container_id'])) {
            //  echo $defaultConfig['container_id'];
            $this->setContainerId($defaultConfig['container_id']);
        }
        $this->setComposerConfig();
    }
    public function setUserType($user_type=null)
    {
       $this->user_type=$user_type;
    }
    public function getComposerConfig()
    {
        return $this->config;
    }

    /*## Ticket #1260 && #1215*/
    public function setComposerConfig($config = [])
    {
        $this->config = isset($config) && !empty($config) ? $config : $this->defaultConfig();
    }

    public function defaultConfig()
    {
        $config = [];
        $config['container_id'] = $this->getContainerId();
        /*## Email Hidden Fields*/
        $config['hidden_fields'] = ['container_id' => $this->getContainerId()];
        /*## Email To Section*/
        $config['to'] = $this->inputFieldConfig('to', ['text' => 'To', 'required' => true]);
        $config['name'] = $this->inputFieldConfig('name', ['text' => 'Name', 'required' => true]);
        $config['name']['section'] = false;
        $config['cc_bcc']['section'] = false;
        /*## Email From Section*/
        $config['from'] = $this->inputFieldConfig('from', ['text' => 'From', 'required' => true, 'value' => supportEmail()]);
        /*## Email Subject Section*/
        $config['subject'] = $this->inputFieldConfig('subject', ['text' => 'Subject', 'required' => true]);
        /*## Email Description Section*/
        $config['description'] = $this->inputFieldConfig('description', ['text' => 'Description', 'data' => ['main_div_class' => 'col-md-12']]);
        $config['description']['section'] = false;
        /*## Email Footer Section*/
        $config['enable_status'] = $this->inputFieldConfig('enable_status', ['text' => 'Enable']);
        $config['enable_status']['section'] = true;
        /*## Ticket #2105*/
        $config['unsubscribe_status'] = $this->inputFieldConfig('unsubscribe_status', ['text' => 'Unsubscribe']);
        $config['unsubscribe_status']['section'] = true;
        $config['footer_status'] = $this->inputFieldConfig('footer_status', ['text' => 'Footer']);
        /*## Email Send Section*/
        $config['send']['section'] = true;
        $config['send']['value'] = 'SEND';
        /*## Email Save Section*/
        $config['save']['section'] = false;
        $config['save']['value'] = 'SAVE';
        /*## Email Test Feature Section*/
        $config['is_test_email'] = true;
        $config['preview']['section'] = true;
        //  $this->config['selector'] = 'specific_textareas';
        //$this->config['editor_selector'] = 'email-body-cls';
        $config['cancel_btn_url'] = '';
        $config['preview_button'] = true;
        $config['words_drop_down'] = true;
        return $config;
    }

    /*## Ticket #1260 && #1215 ## Email Composer for All over the System Ticket*/
    public function emailComposer()
    {
        $containerId = $this->getContainerId();
        $html = '';
        /*## Js Scripts Section ###*/
        $html .= $this->composerTinyMCEScript();
        /*## Email Form Section ###*/
        $html .= '<form name="' . $containerId . 'Frm" id="' . $containerId . 'Frm" action="" method="post" class="form-modal">';
        /*## Group Email Extra Section ###*/
        $userType=$this->user_type;
        if (isset($this->config['group_emails_extra_section']) && $this->config['group_emails_extra_section']) {
            $html .= view('emails.group._extra_section',compact('userType'))->render();
        }
        $html .= '<div class="row">';
        /*## Hidden Fields Section ###*/
        $html .= $this->composerHiddenFieldsHtml();
        /*## Email To Section ###*/
        if (isset($this->config['to']['section']) && $this->config['to']['section']) {
            $html .= $this->composerInputFieldHtml($this->config['to']);
        }
        /*## Email Name Section ###*/
        if (isset($this->config['name']['section']) && $this->config['name']['section']) {
            $html .= $this->composerInputFieldHtml($this->config['name']);
        }
        /*## Email From Section ###*/
        if (isset($this->config['from']['section']) && $this->config['from']['section']) {
            $html .= $this->composerInputFieldHtml($this->config['from']);
        }
        /*## Email Trigger Day Section Ticket #1963###*/
        if (isset($this->config['trigger_day']['section']) && $this->config['trigger_day']['section']) {
            $html .= $this->composerInputFieldHtml($this->config['trigger_day']);
        }
        /*## Email drip_package_id Section Ticket #1963###*/
        if (isset($this->config['package_id']['section']) && $this->config['package_id']['section']) {
            $html .= $this->composerDropDownFieldHtml($this->config['package_id']);
        }
        /*## Email drip_type Section Ticket #2105###*/
        if (isset($this->config['drip_type']['section']) && $this->config['drip_type']['section']) {
            $html .= $this->composerDropDownFieldHtml($this->config['drip_type']);
        }
        /*## Email Subject Section ###*/
        if (isset($this->config['subject']['section']) && $this->config['subject']['section']) {
          //  dd( $this->composerInputFieldHtml($this->config['subject']));
            $html .= $this->composerInputFieldHtml($this->config['subject']);
        }
        /*## Email CC BCC Section ###*/
        if (isset($this->config['cc_bcc']['section']) && $this->config['cc_bcc']['section']) {
            $html .= $this->cc_bcc_html();
        }
        /*## Email variables Drop Down and Additional settings Section ###*/
        $html .= $this->wordsDropDownHtml();
        $html .= $this->datePopup();
        /*## Email Description Section ###*/
        if (isset($this->config['description']['section']) && $this->config['description']['section']) {
            $html .= $this->composerInputFieldHtml($this->config['description']);
        }

        /*## Email Threading Section ###*/
        $html .= $this->threadingHtml();

        /*## Email Body Section ###*/
        $html .= $this->bodyHtml();
        /*## Email Footer Section ###*/
        $html .= $this->footerHtml();
        /*## Email Attachments Section ###*/
        if (isset($this->config['is_attachment']) && $this->config['is_attachment']) {
            include_helper('upload');
            $fileConfig = upload_default_config();
            $fileConfig['is_return_html'] = 1;
            $fileConfig['is_multiple'] = 1;
            $fileConfig['button_text'] = 'Attachments...';
            $fileConfig['file_action'] = 'drip_image';
            $fileConfig['is_multiple_file'] = 1;
            $html .= upload_css(true);
            $html .= upload_js(true);
            $html .= '<div class="col-md-12 selct-file-cls">'; //text-right selct-file
            $html .= '<div>' . upload_fileField($fileConfig);
            $html .= '<div class="clearfix"></div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        /*## Email Errors Alert*/
        $html .= '<div class="col-md-12">';
        $html .= alert_placeholder(true, $containerId . '_alert');
        $html .= '</div>';
        /*## Email Buttons Section*/
        $html .= $this->buttonsHtml();
        $html .= '<div class="clearfix"></div>';
        $html .= '</div>';
        $html .= '</form>';
        return $html;
    }

    public function setContainerId($container_id = 'container_id')
    {
        $this->config['container_id'] = $container_id;
    }

    public function getContainerId()
    {
        return isset($this->config['container_id']) ? $this->config['container_id'] : 'container_id';
    }

    public function threadingHtml()
    {
        $threadingHtml = (isset($this->config['email_threading']) ? trim($this->removeImageTags($this->config['email_threading'])) : '');
        $html = '';
        if ($threadingHtml != '') {
            $html .= '<div class="col-md-12 email_threading_section" id="email_threading_section">';
            $html .= $threadingHtml;
            $html .= '</div>';
        }
        return $html;
    }

    public function bodyHtml()
    {
        $html = '';
        $config = isset($this->config) ? $this->config : [];
        //show is header checkbox
        if (isset($config['is_header']['section']) && $config['is_header']['section']) {
            $html .= $this->composerCheckBoxFieldHtml(['field_name'=>'is_header','text'=>'Header','value'=>$config['is_header']['value']]);
        }
        //$html .= $this->headerImages(isset($this->config['header_img'])?$this->config['header_img']:'none');
        $html .= $this->titleImages(isset($this->config['title_img'])?$this->config['title_img']:'none');
        $html .= $this->signImages(isset($this->config['sign_img'])?$this->config['sign_img']:'none');
        $html .= '<div class="col-md-12">';
        $html .= '<textarea class="form-control email-body-cls" rows="20" cols="90" name="body" id="body">' . (isset($this->config['body']) ? $this->removeImageTags($this->config['body']) : '');
        $html .= '</textarea>';
        $html .= '</div>';
        return $html;
    }

    public function footerHtml()
    {
        $html = '';
        $config = isset($this->config) ? $this->config : [];
        if (isset($config['footer_status']['section']) || isset($config['enable_status']['section']) || isset($config['unsubscribe_status']['section'])) {
            $html .= '<div class="col-md-12">';
            $html .= '<div class="row">';
            if (isset($config['enable_status']['section']) && $config['enable_status']['section']) {
                $html .= $this->composerCheckBoxFieldHtml($config['enable_status']);
            }
            if (isset($config['footer_status']['section']) && $config['footer_status']['section']) {
                $html .= $this->composerCheckBoxFieldHtml($config['footer_status']);
            }
            if (isset($config['show_social']['section']) && $config['show_social']['section']) {
                $html .= $this->composerCheckBoxFieldHtml(['field_name'=>'show_social','text'=>'Social Media','value'=>$config['show_social']['value']]);
            }
            if (isset($config['unsubscribe_status']['section']) && $config['unsubscribe_status']['section']) {
                $html .= $this->composerCheckBoxFieldHtml($config['unsubscribe_status']);
            }
            $html .= '<span>Enter + Shift for 1 Carriage return</span>';
            $html .= '</div>';
            $html .= '<div class="clearfix"></div>';
            $html .= '</div>';
        }
        return $html;
    }

    public function buttonsHtml()
    {
        $config = isset($this->config) ? $this->config : [];
        $containerId = $this->getContainerId();
        $html = '<div class="col-md-12">';
        $html .= '<div class="main-bx">';
        if (isset($config['save']['section']) && $config['save']['section'])
            $html .= '<span id="' . $containerId . 'Save_btn-span"><a href="javascript:void(0);" id="' . $containerId . 'Submit_btn" class="btn-prime" onclick="saveEmail(\'' . $containerId . '\')" data-original-title="" title="">' . ((isset($config['btn_text']) && $config['btn_text'] != '') ? $config['btn_text'] : 'Save') . '</a></span>&nbsp;';
        if (isset($config['send']['section']) && $config['send']['section'])
            $html .= '<span id="' . $containerId . 'Submit_btn-span"><a href="javascript:void(0);" id="' . $containerId . 'Submit_btn" class="btn-prime" onclick="sendEmail(\'' . $containerId . '\')" data-original-title="" title="">' . ((isset($config['btn_text']) && $config['btn_text'] != '') ? $config['btn_text'] : 'Send') . '</a></span>&nbsp;';
        if (isset($config['preview']['section']) && $config['preview']['section'])
            $html .= '<span id="' . $containerId . 'Preview_btn-span"><a href="javascript:void(0);" id="' . $containerId . 'Preview_btn" class="btn-prime" onclick="previewEmail(\'' . $containerId . '\')" data-original-title="" title=" Preview Template">Preview</a></span>';
        $cancelBtnURL = isset($config['cancel_btn_url']) ? $config['cancel_btn_url'] : '';
        $html .= '<a href="' . (($cancelBtnURL != '') ? $cancelBtnURL : 'javascript:void(0);') . '"  ' . (($cancelBtnURL == '') ? 'onclick="closeModal()"' : '') . '  class="btn-blue">CANCEL</a>';
        if (isset($config['is_test_email']) && $config['is_test_email']) {
            $html .= '<span class="email-test-clsss"><input class="input-email-test form-control" type="text" id="test_to" name="test_to"></span>';
            $html .= '<span id="' . $containerId . 'Test_btn-span"><a href="javascript:void(0);" id="composer_test_btn" onclick="testEmail(\'' . $containerId . '\')" class="btn-prime">Test Email</a></span>';
        }
        $html .= '<div class="clearfix"></div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    public function composerHiddenFieldsHtml()
    {
        $html = '';
        $config = isset($this->config) ? $this->config : [];
        $hiddenFileds = isset($config['hidden_fields']) ? $config['hidden_fields'] : [];
        if ($hiddenFileds) {
            foreach ($hiddenFileds as $key => $value) {
                $html .= '<input type="hidden" id="hidden_' . $key . '" name="' . $key . '" value="' . (isset($value) ? trim($value) : '') . '">';
            }
        }
        return $html;
    }

    public function composerTinyMCEScript()
    {
        $tinymceConfig = theme_tinyMCE_default_config();
        $config = isset($this->config) ? $this->config : [];
        if ($config) {
            if (isset($config['selector']) && $config['selector'] != '')
                $tinymceConfig['selector'] = $config['selector'];
            if (isset($config['is_tiny_mce_modal']) && $config['is_tiny_mce_modal'] != '')
                $tinymceConfig['is_tiny_mce_modal'] = $config['is_tiny_mce_modal'];
            if (isset($config['tiny_mce_height']) && $config['tiny_mce_height'] != '')
                $tinymceConfig['height'] = $config['tiny_mce_height'];
            if (isset($config['editor_selector']) && $config['editor_selector'] != '') {
                $tinymceConfig['editor_selector'] = $config['editor_selector'];
                // $tinymceConfig['selector'] = '';
            }
        }
        $html = theme_tinyMCE_script($tinymceConfig);
        return $html;
    }

    public function composerInputFieldHtml($dataArr = [])
    {
        $isRequired = (isset($dataArr['required']) && intval($dataArr['required']) > 0) ? true : false;
        $text = isset($dataArr['text']) ? trim($dataArr['text']) : '';
        $fieldName = isset($dataArr['field_name']) ? trim($dataArr['field_name']) : '';
        $value = isset($dataArr['value']) ? trim($dataArr['value']) : '';
        $main_class = isset($dataArr['data']['main_div_class']) ? trim($dataArr['data']['main_div_class']) : 'col-md-6';
        $html = '<div class="' . $main_class . '"><div class="col-md-2 heading3">' . $text . (($isRequired) ? '*' : '') . '</div>';
        $html .= '<div class="col-md-10">';
        $html .= '<input class="form-control" type="text" name="' . $fieldName . '" id="' . $fieldName . '" value="' . $value . '">';
        $html .= '</div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '</div>';
        return $html;
    }

    public function datePopup()
    {
        $html = '<div class="col-md-12"><a class="link-font pull-right" href="javascript:void(0)" onclick="commonAjaxModel(\'date_format_popup\')">Dates</a></div>';
        return $html;
    }

    public function composerCheckBoxFieldHtml($dataArr = [])
    {
        $isRequired = (isset($dataArr['required']) && intval($dataArr['required']) > 0) ? true : false;
        $text = isset($dataArr['text']) ? trim($dataArr['text']) : '';
        $fieldName = isset($dataArr['field_name']) ? trim($dataArr['field_name']) : '';
        $checked = (isset($dataArr['value']) && $dataArr['value'] == 1) ? 'checked="checked"' : '';
        $html = '<div class="col-md-3">';
        $html .= '<div class="check-small  "><input type="checkbox" class="form-control" name="' . $fieldName . '" id="' . $fieldName . '" value="1" ' . $checked . '></div>';
        $html .= '<div class="check-logo">';
        $html .= '<b>' . $text . (($isRequired) ? '*' : '') . '</b>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    public function composerDropDownFieldHtml($dataArr = [])
    {
        $isRequired = (isset($dataArr['required']) && intval($dataArr['required']) > 0) ? true : false;
        $text = isset($dataArr['text']) ? trim($dataArr['text']) : '';
        $fieldName = isset($dataArr['field_name']) ? trim($dataArr['field_name']) : '';
        $selectValue = isset($dataArr['value']) ? trim($dataArr['value']) : '';
        $dropDown_data = isset($dataArr['data']) ? $dataArr['data'] : array();
        $html = '<div class="col-md-6"><div class="col-md-2 heading3">' . $text . (($isRequired) ? '*' : '') . '</div>';
        $html .= '<div class="col-md-10">';
        $html .= '<select name="' . $fieldName . '" id="' . $fieldName . '">';
        $html .= '<option value="">Select</option>';
        if ($dropDown_data) {
            foreach ($dropDown_data as $key => $data) {
                $sel = '';
                if ((isset($data['id']) && !empty($data['id']) && $data['id'] == $selectValue) || $key == $selectValue) {
                    $sel = 'selected="selected"';
                }
                $html .= '<option value="' . (isset($data['id']) ? $data['id'] : (isset($key) ? $key : '')) . '" ' . $sel . '>' . (isset($data['value']) ? $data['value'] : (isset($data) ? $data : '')) . '</option>';
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    public function inputFieldConfig($fieldName = '', $config = [])
    {
        $inputFieldConfig = [];
        if ($fieldName != '') {
            $inputFieldConfig['section'] = true;
            $inputFieldConfig['field_name'] = $fieldName;
            $inputFieldConfig['text'] = isset($config['text']) ? trim($config['text']) : '';
            $inputFieldConfig['value'] = isset($config['value']) ? trim($config['value']) : '';
            $inputFieldConfig['required'] = (isset($config['required']) && intval($config['required']) > 0) ? true : false;
            $inputFieldConfig['data'] = (isset($config['data'])) ? $config['data'] : array();
        }
        return $inputFieldConfig;
    }

    public function cc_bcc_html()
    {
        $html = '';
        if (isset($this->config['cc_bcc']['section']) && $this->config['cc_bcc']['section']) {
            $html .= '<div class="col-md-6">';
            $html .= '<div class="col-md-2 heading3">CC & BCC</div>';
            $html .= '<div class="col-md-10">';
            $html .= '<div class="chk-bx"><input type="checkbox" class="form-control" id="is_cc" value="1" name="is_cc" onchange="cc_bcc_toggle()">';
            $html .= '<span>CC</span>';
            $html .= '</div>';
            $html .= '<div class="chk-bx"><input type="checkbox" class="form-control" id="is_bcc" value="1" name="is_bcc" onchange="cc_bcc_toggle()" ' . ((isset($emailData['bcc_email']) && $emailData['bcc_email'] != '') ? 'checked' : '') . '>';
            $html .= '<span>BCC</span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="clearfix">';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div id="cc_section" class="dis-none col-md-6">';
            $html .= '<div class="col-md-2 heading3">CC</div>';
            $html .= '<div class="col-md-10">';
            $html .= '<input class="form-control" type="text" name="cc_email" id="cc_email"
                 value="' . (isset($emailData['cc_email']) ? $emailData['cc_email'] : (isset($this->config['cc_email']) ? $this->config['cc_email'] : '')) . '">';
            $html .= '</div>';
            $html .= '<div class="clearfix">';
            $html .= '</div>';
            $html .= '</div>';

            /**********************************************************************************************
             **###################################### BCC Email From section ################################**
             **********************************************************************************************/
            $html .= '<div id="bcc_section" class="' . ((isset($emailData['bcc_email']) && $emailData['bcc_email'] != '') ? '' : 'dis-none') . ' col-md-6">';
            $html .= '<div class="col-md-2 heading3">BCC</div>';
            $html .= '<div class="col-md-10"><input class="form-control" type="text" name="bcc_email" id="bcc_email"
                     value="' . (isset($emailData['bcc_email']) ? $emailData['bcc_email'] : (isset($this->config['bcc_email']) ? $this->config['bcc_email'] : '')) . '"></div><div class="clearfix"></div>';
            $html .= '</div>';
        }
        return $html;
    }

    public function wordsDropDownHtml()
    {
        $html = '';
        if (isset($this->config['words_drop_down']) && $this->config['words_drop_down']) {
            $html .= '<div class="col-md-6">';
            $key_words = cleanVariablesFun();
            $html .= '<div class="col-md-2 heading3"> Words: </div>';
            $html .= '<div class="col-md-10 insert-wrords">';

            $html .= '<select name="words_dropDown" id="words_dropDown" class="form-control">';
            foreach ($key_words as $key => $val) {
                $html .= '<option  value="' . $key . '">' . $val . '</option>';
            }
            $html .= '</select>';

            $html .= '<a href="javascript://" class="btn-prime" onclick="insertIntoTinyMceEditor();">Insert</a>';
            $html .= '<div class="clearfix">&nbsp;</div>';

            $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    }

    public function removeImageTags($clear = '')
    {
        $clear = preg_replace('/' . preg_quote('[') .
            '.*?' .
            preg_quote(']') . '/', '', $clear);
        return $clear;
    }

    public function emailThreadingHtml($email_body = '', $email_data = [])
    {
        $email_body = trim($this->removeImageTags($email_body));
        $emailThreadingHtml = '';
        if ($email_body != '') {
            $emailThreadingHtml .= '<div class="email-threads">';
            $emailThreadingHtml .= view('emails._email_threads', compact('email_body', 'email_data'))->render();
            $emailThreadingHtml .= '</div>';
        }
        return $emailThreadingHtml;
    }

    public function headerImages($checked = 'none'){
        $emailFolder = public_path().'/email/';
        $title = 'Header';
        $field_name = 'header_img';
        exec ("find ".$emailFolder." -type d -exec chmod 0777 {} +");
        $headerFolder = 'header';
        $images = glob( $emailFolder.$headerFolder. "/*");
        $html = view('email_images',compact('title','images','field_name','checked'))->render();
        return $html;
    }

    public function titleImages($checked = 'none'){
        $field_name = 'title_img';
        $emailFolder = public_path().'/email/';
        $title = 'Title';
        exec ("find ".$emailFolder." -type d -exec chmod 0777 {} +");
        $titleFolder  = 'title';
        $images = glob( $emailFolder.$titleFolder. "/*");
        $html = view('email_images',compact('title','images','field_name','checked'))->render();
        return $html;
    }

    public function signImages($checked = 'none'){
        $field_name = 'sign_img';
        $title = 'Signature';
        $emailFolder = public_path().'/email/';
        exec ("find ".$emailFolder." -type d -exec chmod 0777 {} +");
        $signFolder   = 'signature';
        $images = glob( $emailFolder.$signFolder. "/*");
        $html = view('email_images',compact('title','images','field_name','checked'))->render();
        return $html;
    }
}