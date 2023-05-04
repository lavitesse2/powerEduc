<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_powerschool\form;
use moodleform;
use stdClass;


require_once("$CFG->libdir/formslib.php");

class modepaiement extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'libmodepay', 'Libellé mode paiement'); // Add elements to your form
        $mform->setType('libmodepay', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('libmodepay', '');        //Default value


        $this->add_action_buttons();
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }

     /** Mise à jour de l'année academique 
     * @param int $id l'identifiant de l'année a à modifier
     * @param string $datedebut la date de debut de l'annee
     * @param string $datefin date de fin de l'annee 
     */
    public function update_modepaiement(int $id, string $libmodepay ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->libmodepay = $libmodepay ;

        return $DB->update_record('modepaiement', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_modepaiement(int $modepaiementid)
    {
        global $DB;
        return $DB->get_record('modepaiement', ['id' => $modepaiementid]);
    }

    public function selectmodepaiement (string $sql)
    {
        global $DB;


        return $DB->get_records_sql($sql);
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_modepaiement(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppmodepaiement = $DB->delete_records('modepaiement', ['id'=> $id]);
        if ($suppmodepaiement){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}