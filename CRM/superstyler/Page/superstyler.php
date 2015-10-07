<?php

require_once 'CRM/Core/Page.php';

class CRM_superstyler_Page_superstyler extends CRM_Core_Page {
  function run() {
    // title
    CRM_Utils_System::setTitle(ts('SuperStyler'));
		// on form action
		if(isset($_REQUEST['color'])) {
			// override
			CRM_Core_BAO_Setting::setItem($_REQUEST['color'], 'superstyler', 'color');
		}
		// variables
		$url = CRM_Utils_System::url() . "civicrm/ctrl/superstyler";
		$this->assign('url', $url);		
		$color 	= CRM_Core_BAO_Setting::getItem('superstyler', 'color');
		$list 	= CRM_Core_BAO_Setting::getItem('superstyler', 'list');
		// form
		$form .= "<form action=". $url ." method='post'>";
		$form .= "<label>Select stylesheet</label>";
		$form .= "<div class='listing-box'>";
		foreach ($list as &$value) {
			if($value == $color) { $form .= "<input type='radio' id='css_$value' name='color' value='$value' checked><label for='css_$value' >$value</label><br>"; }
			else { $form .= "<input type='radio' id='css_$value' name='color' value='$value'><label for='css_$value' >$value</label><br>"; }
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
