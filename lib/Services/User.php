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
        $sql .= " INNER JOIN {sessions} s ON u.id = s.uid";
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
     */
    public function createDrupalUser($muser) {
        throw new \RuntimeException('To be implemented.');
    }

    /**
     * Create moodle session by User ID.
     */
    public function createMoodleSession($muid) {
        throw new \RuntimeException('To be implemented.');
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
}
