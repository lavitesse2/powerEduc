<?php

/**
 * local_message external file
 *
 * @package    component
 * @category   external
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use local_powerschool\form\anneescolaire;
require_once($CFG->libdir . "/externallib.php");

class local_annee_external extends external_api  {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_annee_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of message')],
        );
    }

    /**
     * The function itself
     * @return string welcome message
     */
    public static function supp_annee($anneeid): string {
        $params = self::validate_parameters(self::delete_annee_parameters(), array('id'=>$anneeid));

        // require_capability('local/message:managemessages', context_system::instance());

        $annee = new anneescolaire();
        return $annee->supp_annee($anneeid);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_message_returns() {
        return new external_value(PARAM_BOOL, 'True if the message was successfully deleted.');
    }
}
