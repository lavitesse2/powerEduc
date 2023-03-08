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

class campus extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'nomcampus', 'Nom du Campus'); // Add elements to your form
        $mform->setType('nomcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('nomcampus', '');        //Default value
        
        $mform->addElement('text', 'villecampus', 'Ville'); // Add elements to your form
        $mform->setType('villcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('villcampus', '');        //Default value

        $mform->addElement('text', 'adressecampus', 'Adresse'); // Add elements to your form
        $mform->setType('adressecampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('adressecampus', '');        //Default value

        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value

        $mform->addElement('text', 'telcampus', 'Telephone Campus'); // Add elements to your form
        $mform->setType('telcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('telcampus', '');        //Default value


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
    public function update_campus(int $id, string $nomcampus, string $adressecampus, string $villecampus,int $telcampus ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->nomcampus = $nomcampus ;
        $object->adressecampus = $adressecampus ;
        $object->telcampus = $telcampus;
        $object->villecampus = $villecampus;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('campus', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_campus(int $campusid)
    {
        global $DB;
        return $DB->get_record('campus', ['id' => $campusid]);
    }

    /** retourne le resultat de la requête mis en parametre
     * @param string $sql c'est la requête que vous voulez
     */
    public function select (string $sql)
    {
        global $DB;


        return $DB->get_records_sql($sql);
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_campus(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('campus', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}