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

class anneescolaire extends moodleform {

    const idannee =0;
    //Add elements to form
    public function definition() {

        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','Annee Scolaire', 'Annee Scolaire');
      
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('text', 'datedebut', 'Année Scolaire de debut'); // Add elements to your form
        $mform->setType('datedebut', PARAM_INT);                   //Set type of element
        $mform->setDefault('datedebut', '');        //Default value
        $mform->addRule('datedebut', 'Date de debut annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('datedebut', 'date');
        
        $mform->addElement('text', 'datefin', 'Année Scolaire de fin'); // Add elements to your form
        $mform->setType('datefin', PARAM_INT);                   //Set type of element
        $mform->setDefault('datefin', '');        //Default value
        $mform->addRule('datefin', 'Date de fin annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('datefin', 'date');

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
    public function update_annee(int $id, string $datedebut, string $datefin): bool
    {
        global $DB;
        $object = new stdClass();
        $object->id = $id;
        $object->datedebut = $datedebut;
        $object->datefin = $datefin;

        return $DB->update_record('anneescolaire', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_annee(int $anneeid)
    {
        global $DB;
        return $DB->get_record('anneescolaire', ['id' => $anneeid]);
    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_annee(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppannee = $DB->delete_records('anneescolaire', ['id'=> $id]);
        if ($suppannee){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}

