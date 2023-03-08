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

class enseigner extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $req = new campus();

        $prof = $cours = array();
        $sql1 = "SELECT * FROM {user} ";
        $sql2 = "SELECT * FROM {matiere}";

        $prof = $req->select($sql1);
        $cours = $req->select($sql2);
        

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
       
       
        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value

        foreach ($prof as $key => $val)
        {
            $select1[$key] = $val->firstname;

        }
        foreach ($cours as $key => $val)
        {
            $select2[$key] = $val->libellematiere;

        }
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idprof', 'choisir le professeur', $select1); // Add elements to your form
        $mform->setType('idprof', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idprof', '');        //Default value

        $mform->addElement('select', 'idmatiere', 'choisir le cours', $select2); // Add elements to your form
        $mform->setType('idmatiere', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idmatiere', '');        //Default value

       

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
    public function update_enseigner(int $id,int $idprof,int $idmatiere ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idprof = $idprof;
        $object->idmatiere = $idmatiere;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('enseigner', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_enseigner(int $enseignerid)
    {
        global $DB;
        return $DB->get_record('enseigner', ['id' => $enseignerid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_enseigner(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('enseigner', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}