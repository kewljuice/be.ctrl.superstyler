<?php

require_once 'superstyler.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function superstyler_civicrm_config(&$config) {
  _superstyler_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function superstyler_civicrm_xmlMenu(&$files) {
  _superstyler_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function superstyler_civicrm_install() {
  _superstyler_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function superstyler_civicrm_uninstall() {
  _superstyler_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function superstyler_civicrm_enable() {
  // http://wiki.civicrm.org/confluence/display/CRMDOC/Extensions%3A+Referencing+Files
  // $url =CRM_Core_Resources::singleton()->getUrl('be.ctrl.superstyler');
  $u = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'css';
  // read css folder
  $d = scandir($u);
  // json object
  $json = [];
  $arr = [];
  // default
  $default = new stdClass();
  $default->name = 'default';
  $default->active = 1;
  $arr[] = $default;
  // read files in css folder
  foreach ($d as $f) {
    // check for css
    $i = pathinfo($f);
    if ($f == '.' || $f == '..' || $i['extension'] != 'css') {
      continue;
    }
    // create object
    $ob = new stdClass();
    $ob->name = $f;
    $ob->active = 0;
    $arr[] = $ob;
  }
  $json['superstyler'] = $arr;
  $encode = json_encode($json);
  // assign
  CRM_Core_BAO_Setting::setItem($encode, 'superstyler', 'superstyler-settings');
  // continue
  _superstyler_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function superstyler_civicrm_disable() {
  // remove variable(s)
  CRM_Core_BAO_Setting::setItem('', 'superstyler', 'superstyler-settings');
  // continue
  _superstyler_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or
 *   'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of
 *   pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if
 *   upgrades are pending) for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function superstyler_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _superstyler_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function superstyler_civicrm_managed(&$entities) {
  _superstyler_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function superstyler_civicrm_caseTypes(&$caseTypes) {
  _superstyler_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function superstyler_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _superstyler_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * function set CSS
 */
function superstyler_setcss() {
  // http://stackoverflow.com/questions/26805741/storing-civicrm-extension-specific-configuration-in-database
  $settings = CRM_Core_BAO_Setting::getItem('superstyler', 'superstyler-settings');
  $decode = json_decode(utf8_decode($settings), TRUE);
  foreach ($decode['superstyler'] as $key => $value) {
    // set active
    if ($value['active'] == 1 && $value['name'] != 'default') {
      CRM_Core_Resources::singleton()
        ->addStyleFile('be.ctrl.superstyler', 'css/' . $value['name']);
    }
  }
}

/**
 * buildform
 */
function superstyler_civicrm_buildForm($formName, &$form) {
  // set style
  superstyler_setcss();
}

/**
 * pagerun
 */
function superstyler_civicrm_pageRun(&$page) {
  // set style
  superstyler_setcss();
}

/**
 * CiviCRM hooks
 */
function superstyler_civicrm_navigationMenu(&$params) {
  // Check for Administer navID.
  $AdministerKey = '';
  foreach ($params as $k => $v) {
    if ($v['attributes']['name'] == 'Administer') {
      $AdministerKey = $k;
    }
  }
  // Check for Parent navID.
  foreach ($params[$AdministerKey]['child'] as $k => $v) {
    if ($k == 'CTRL') {
      $parentKey = $v['attributes']['navID'];
    }
  }
  // If Parent navID doesn't exist create.
  if (!isset($parentKey)) {
    // Create parent array
    $parent = [
      'attributes' => [
        'label' => 'CTRL',
        'name' => 'CTRL',
        'url' => NULL,
        'permission' => 'access CiviCRM',
        'operator' => NULL,
        'separator' => 0,
        'parentID' => $AdministerKey,
        'navID' => 'CTRL',
        'active' => 1,
      ],
      'child' => NULL,
    ];
    // Add parent to Administer
    $params[$AdministerKey]['child']['CTRL'] = $parent;
  }
  // Create child(s) array
  $child = [
    'attributes' => [
      'label' => 'SuperStyler',
      'name' => 'ctrl_superstyler',
      'url' => 'civicrm/ctrl/superstyler',
      'permission' => 'access CiviCRM',
      'operator' => NULL,
      'separator' => 0,
      'parentID' => 'CTRL',
      'navID' => 'superstyler',
      'active' => 1,
    ],
    'child' => NULL,
  ];
  // Add child(s) for this extension
  $params[$AdministerKey]['child']['CTRL']['child']['superstyler'] = $child;
}
 
