<?php
/**
 * @file
 * at_moodle.features.inc
 */

/**
 * Implements hook_views_api().
 */
function at_moodle_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}
