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
use stdClass;
use moodleform;
use local_powerschool\form\campus;


require_once("$CFG->libdir/formslib.php");
require_once($CFG->dirroot.'/local/powerschool/classes/form/campus.php');

class salle extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $campus = new campus();
        $camp = array();
        $sql = "SELECT * FROM {campus} ";
        $camp = $campus->select($sql);
        

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','Salle', 'Salle');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'numerosalle', 'Numeros de Salle'); // Add elements to your form
        $mform->setType('numerosalle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('numerosalle', '');        //Default value
        $mform->addRule('numerosalle', 'Numeros de la Salle', 'required', null, 'client');
        $mform->addHelpButton('numerosalle', 'salle');
       
       
        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value


        foreach ($camp as $key => $val)
        {
            $selectcamp[$key] = $val->nomcampus;
        }
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idcampus', 'Campus', $selectcamp ); // Add elements to your form
        $mform->setType('idcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcampus', '');        //Default value
        $mform->addRule('idcampus', 'Choix du Campus', 'required', null, 'client');
        $mform->addHelpButton('idcampus', 'campus');

       

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
    public function update_salle(int $id, string $numerosalle,int $idcampus ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->numerosalle = $numerosalle ;
        $object->idcampus = $idcampus;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('salle', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_salle(int $salleid)
    {
        global $DB;
        return $DB->get_record('salle', ['id' => $salleid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_salle(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('salle', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}