<?php
namespace Drupal\at_moodle\Services;

/**
 * Class for at_moodle.user service
 */
class User {
    /**
     * Moodle session's name.
     *
     * @var string
     */
    private $msname;

    /**
     * Moodle session ID.
     *
     * @var string
     */
    private $msid;

    /**
     * @var string
     */
    private $db_target = 'moodle';

    /**
     * Get Moodle user from session ID.
     *
     * @param string $msid Moodle session ID
     */
    public function getMoodleUser($msid) {
        $sql  = "SELECT u.* FROM {user} u";
        $sql .= " INNER JOIN {sessions} s ON u.id = s.userid";
        $sql .= " WHERE s.sid = :sid AND u.deleted = 0 AND u.suspended = 0";
        $sql .= " LIMIT 1";

        return db_query($sql, array(':sid' => $msid), array('target' => $this->db_target))
                ->fetchObject();
    }

    /**
     * Get Drupal user from Moodle's user ID.
     *
     * @param int $muid
     */
    public function getDrupalUser($muid) {
        throw new \RuntimeException('To be implemented.');
    }

    /**
     * Create Drupal user from Moodle user.
     *
     * @see user_external_login_register($name, $module)
     */
    public function createDrupalUser($muser) {
        $name = "{$muser->username}@moodle";
        $module = 'at_moodle';
        $account = user_external_load($name);

        if (!$account) {
            $userinfo = array('name' => $name,
              'pass' => user_password(),
              'init' => $name,
              'status' => 1,
              'access' => REQUEST_TIME,
            );

            $account = user_save(drupal_anonymous_user(), $userinfo);
            if (!$account) {
                throw new \RuntimeException('Can not create account for Moodle user.');
            }

            user_set_authmaps($account, array("authname_{$module}" => $name));
        }

        return $account;
    }

    /**
     * Create moodle session by User ID.
     */
    public function createMoodleSession($muid) {
        throw new \RuntimeException('To be implemented.');
    }

    /**
     * Delete user session in Moodle system.
     *
     * @param string $msname
     * @param string $msid
     */
    public function deleteMoodleSession($msname, $msid) {
        db_query("DELECT FROM {sessions} s WHERE s.sid = :sid",
          $msid,
          array('target' => $this->db_target)
        );

        _drupal_session_delete_cookie($msname);
    }

    /**
     * Create session for Drupal session.
     *
     * @see user_login_submit()
     * @see hook_user_login()
     */
    public function createDrupalSession($duser) {
        $form_state['uid'] = $duser->uid;
        user_login_submit(array(), $form_state);
    }

    /**
     * Sync user's properties from Moodle to Drupal.
     *
     * @param stdClass $muser
     * @param stdClass $duser
     */
    public function syncToDrupal($muser, $duser) {
        throw new \RuntimeException('To be implemented.');
    }

    /**
     * Sync user's properties from Drupal to Moodle.
     *
     * @param stdClass $duser
     * @param stdClass $muser
     */
    public function syncToMoodle($duser, $muser) {
        throw new \RuntimeException('To be implemented.');
    }
}
