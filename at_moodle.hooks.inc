<?php

/**
 * Implements hook_user_logout()
 */
function at_moodle_user_logout() {
    if ($msname = variable_get('moodle_session_name', 'MoodleSession')
      && $msid = at_moodle_session_id()
    ) {
        AT_Moodle::getServiceUser()->deleteMoodleSession($msname, $msid);
    }
}

/**
 * Implements hook_init()
 */
function at_moodle_init() {
    $auth = user_is_anonymous();
    $auth = $auth && !filter_has_var(INPUT_GET, 'reload');
    $auth = $auth && ('user/logout' !== request_path());
    $auth = $auth && ($msid = at_moodle_session_id());

    if ($auth) {
        $s_user = AT_Moodle::getServiceUser();

        if ($muser = $s_user->getMoodleUser($msid)) {
            $duser = $s_user->createDrupalUser($muser);

            $field_mapping = variable_get('moodule_user_fields', array());

            $s_user->syncToDrupal($muser, $duser, $field_mapping);

            if (FALSE !== $s_user->createDrupalSession($duser)) {
                drupal_goto(request_path(), array('reload' => 1));
            }
        }
    }
}
