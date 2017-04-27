<?php

require_once 'CRM/Core/Page.php';

class CRM_superstyler_Page_superstyler extends CRM_Core_Page
{
    function run()
    {
        // title
        CRM_Utils_System::setTitle(ts('SuperStyler'));
        // variables
        $url = CRM_Utils_System::baseURL() . 'civicrm/ctrl/superstyler';
        $this->assign('url', $url);
        // get settings
        $settings = CRM_Core_BAO_Setting::getItem('superstyler', 'superstyler-settings');
        $decode = json_decode(utf8_decode($settings), true);
        // on form action
        if (isset($_REQUEST['color'])) {
            // clear
            foreach ($decode['superstyler'] as $key => $value) {
                if ($value['name'] == $_REQUEST['color']) {
                    $decode['superstyler'][$key]['active'] = 1;
                } else {
                    $decode['superstyler'][$key]['active'] = 0;
                }
            }
            // set
            $encode = json_encode($decode);
            CRM_Core_BAO_Setting::setItem($encode, 'superstyler', 'superstyler-settings');
            // notice
            CRM_Core_Session::setStatus(ts('Superstyler settings changed'), ts('Saved'), 'success');
        }
        // form
        $form = "";
        $form .= "<form action=" . $url . " method='post'>";
        $form .= "<label>Select stylesheet</label>";
        $form .= "<div class='listing-box'>";
        // loop
        foreach ($decode['superstyler'] as $key => $value) {
            $v = $value['name'];
            if ($value['active'] == 1) {
                $form .= "<input type='radio' id='css_$v' name='color' value='$v' checked><label for='css_$v' >$v</label><br>";
            } else {
                $form .= "<input type='radio' id='css_$v' name='color' value='$v'><label for='css_$v' >$v</label><br>";
            }
        }
        $form .= "</div>";
        $form .= "<div class='crm-submit-buttons'><span class='crm-button'><input class='crm-form-submit default' type='submit' value='Submit'></span></div>";
        $form .= "</form>";
        // assign form
        $this->assign('content', $form);
        // render
        parent::run();
    }
}
