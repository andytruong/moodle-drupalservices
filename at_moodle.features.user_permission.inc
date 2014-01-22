<?php
/**
 * @file
 * at_moodle.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function at_moodle_user_default_permissions() {
  $permissions = array();

  // Exported permission: 'execute php code'.
  $permissions['execute php code'] = array(
    'name' => 'execute php code',
    'roles' => array(
      'administrator' => 'administrator',
    ),
    'module' => 'devel',
  );

  return $permissions;
}
