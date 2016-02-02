<?php

require_once 'CRM/Core/Page.php';

class CRM_superstyler_Page_superstyler_upload extends CRM_Core_Page {
  function run() {

    // Variables
    $upload = TRUE;
    $folder = CRM_Core_Resources::singleton()
        ->getUrl('be.ctrl.superstyler') . "css/";

    // Declare JSON object.
    $json = array('is_error' => 1, 'status' => '');
    $json['filename'] = str_replace(' ', '_', basename($_FILES['fileToUpload']['name']));
    $json['tmp_name'] = $_FILES['fileToUpload']['tmp_name'];

    // Target (css folder url in extension directory).
    $json['target'] = $folder . str_replace(' ', '_', basename($_FILES["fileToUpload"]["name"]));

    // Extension.
    $json['type'] = pathinfo($json['target'], PATHINFO_EXTENSION);

    // Check if file already exists.
    if (file_exists($json['target'])) {
      $json['status'] .= "<p translate>File already exists</p>";
      $upload = FALSE;
    }

    // Check file size.
    if ($_FILES["fileToUpload"]["size"] > 20971520) {
      $json['status'] .= "<p translate>File is too large</p>";
      $upload = FALSE;
    }

    // Allow certain file formats.
    if ($json['type'] != "css") {
      $json['status'] .= "<p translate>File type not supported</p>";
      $upload = FALSE;
    }

    // Check if $upload isn't FALSE by an error.
    if ($upload) {
      // if everything is ok, try to upload file
      // TODO: fix this
      if (move_uploaded_file($json['tmp_name'], $_SERVER['DOCUMENT_ROOT']."file.css")) {
        // succes
        $json['status'] = "<p translate>File upload successful</p>";
        $json['is_error'] = 0;
      }
      else {
        // failed
        $json['status'] = "<p translate>File upload failed</p>";
        $json['is_error'] = 1;
      }
    }

    // Return JSON.
    print json_encode($json, JSON_PRETTY_PRINT);

    // Exit CRM_Core_Page flow.
    CRM_Utils_System::civiExit();
  }
}
