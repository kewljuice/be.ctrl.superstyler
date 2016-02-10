<?php
/**
 * CiviCRM hooks
 */
function superstyler_civicrm_navigationMenu(&$params) {

  // Get the maximum key of $params.
  $NextKey = (max(array_keys($params)));
  // Get Next available item.
  $NextKey++;

  // Check for Administer navID.
  $AdministerKey = 0;
  foreach ($params as $k => $v) {
    if ($v['attributes']['name'] == 'Administer') {
      $AdministerKey = $k;
    }
  }

  // Check for Parent navID.
  $ParentKey = 0;
  foreach ($params[$AdministerKey]['child'] as $k => $v) {
    if ($v['attributes']['name'] == 'CTRL') {
      $ParentKey = $v['attributes']['navID'];
    }
  }

  // If Parent navID doesn't exist create.
  if ($ParentKey == 0) {
    // Create parent array.
    $parent = array(
      'attributes' => array(
        'label' => 'CTRL',
        'name' => 'CTRL',
        'url' => NULL,
        'permission' => 'access CiviCRM',
        'operator' => NULL,
        'separator' => 0,
        'parentID' => $AdministerKey,
        'navID' => $NextKey,
        'active' => 1
      ),
      'child' => NULL
    );
    // Add parent to Administer.
    $params[$AdministerKey]['child'][$NextKey] = $parent;
    // Define parentKey & nextKey.
    $ParentKey = $NextKey;
  }

  // Create child array.
  $child = array(
    'attributes' => array(
      'label' => 'SuperStyler',
      'name' => 'ctrl_superstyler',
      'url' => 'civicrm/ctrl/superstyler',
      'permission' => 'access CiviCRM',
      'operator' => NULL,
      'separator' => 0,
      'parentID' => $parentKey,
      'navID' => $nextKey,
      'active' => 1
    ),
    'child' => NULL
  );

  // Add child(s) for this extension.
  $params[$AdministerKey]['child'][$ParentKey]['child']['ctrl_superstyler'] = $child;
}

?>
