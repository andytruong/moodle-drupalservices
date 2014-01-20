<?php
/**
 * @file
 * at_moodle.features.user_role.inc
 */

/**
 * Implements hook_user_default_roles().
 */
function at_moodle_user_default_roles() {
  $roles = array();

  // Exported role: remote-service.
  $roles['remote-service'] = array(
    'name' => 'remote-service',
    'weight' => 3,
  );

  return $roles;
}
