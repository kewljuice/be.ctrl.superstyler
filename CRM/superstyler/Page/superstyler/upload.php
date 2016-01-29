<?php

require_once 'CRM/Core/Page.php';

class CRM_superstyler_Page_superstyler_upload extends CRM_Core_Page {
  function run() {

    // Declare JSON object.
    $json = array('is_error' => 1);

    // Handle file upload.
    $url = CRM_Utils_System::baseURL();
    $json['url'] = $url;

    // Dump JSON.
    print json_encode($json, JSON_PRETTY_PRINT);

    // Exit CRM_Core_Page flow.
    CRM_Utils_System::civiExit();
  }
}
