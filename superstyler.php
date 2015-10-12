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
	// log
	watchdog('be.ctrl.superstyler', 'enabled superstyler');	
	// create variables
	$a = civicrm_api3('Setting', 'get', array('sequential' => 1, 'return' => "extensionsDir", ));
	$d = scandir($a['values'][0]['extensionsDir']."\be.ctrl.superstyler\css");
	$l = array('default');
	$c = 'default';
	// read files in css folder
	foreach($d as $f) {
			$i = pathinfo($f);
			if($f == '.' || $f == '..' || $i['extension'] != "css") { continue; } 
			$l[] = $f;
	}
	// assign 
	CRM_Core_BAO_Setting::setItem($c, 'superstyler', 'color');
	CRM_Core_BAO_Setting::setItem($l, 'superstyler', 'list');
	// continue
  _superstyler_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function superstyler_civicrm_disable() {
	// log
	watchdog('be.ctrl.superstyler', 'disabled superstyler');	
	// remove variables
	/* TODO */
  // continue
	_superstyler_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
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
function superstyler_setcss ($color) {
	// http://stackoverflow.com/questions/26805741/storing-civicrm-extension-specific-configuration-in-database
	$color 	= CRM_Core_BAO_Setting::getItem('superstyler', 'color');
	// check
	if(isset($color) && $color != 'default') { CRM_Core_Resources::singleton()->addStyleFile('be.ctrl.superstyler', 'css/'.$color); }
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
function superstyler_civicrm_pageRun( &$page ) {
	// set style
	superstyler_setcss();
}


 