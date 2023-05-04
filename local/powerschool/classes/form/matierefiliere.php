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

class matierefiliere extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $req = new campus();

        $matiere = $filiere = $cycle = array();

        $sql1 = "SELECT * FROM {course}";
        $sql2 = "SELECT * FROM {filiere}";
        $sql3 = "SELECT * FROM {cycle}";

        $matiere = $req->select($sql1);
        $filiere = $req->select($sql2);
        $cycle =  $req->select($sql3);

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','matierefiliere','Attribuer Les Matieres');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        foreach($matiere as $key => $val)
        {
            $select1[$key]= $val->fullname;
        }
        foreach($filiere as $key => $val )
        {
            $select2[$key]= $val->libellefiliere." (".$val->abbreviation.")";
        }
        foreach($cycle as $key => $val)
        {
            $select3[$key]= $val->libellecycle;
        }


        $mform->addElement('select', 'idfiliere', 'Filiere',$select2); // Add elements to your form
        $mform->setType('idfiliere', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idfiliere', '');        //Default value
        $mform->addRule('idfiliere', 'libelle de la Filiere', 'required', null, 'client');
        $mform->addHelpButton('idfiliere', 'filiere');

        $mform->addElement('select', 'idmatiere', 'Matiere',$select1); // Add elements to your form
        $mform->setType('idmatiere', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idmatiere', '');        //Default value
        $mform->addRule('idmatiere', 'libelle de la matiere', 'required', null, 'client');
        $mform->addHelpButton('idmatiere', 'matiere');

        $mform->addElement('select', 'idcycle', 'Cycle', $select3); // Add elements to your form
        $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('idcycle', 'libelle du cycle', 'required', null, 'client');
        $mform->addHelpButton('idcycle', 'cycle');
       
       
        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value
       

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
    public function update_matierefiliere(int $id, string $idmatiere,string $idfiliere,string $idcycle ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idmatiere = $idmatiere ;
        $object->idfiliere = $idfiliere ;
        $object->idcycle = $idcycle ;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('matierefiliere', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_matierefiliere(int $matierefiliereid)
    {
        global $DB;
        return $DB->get_record('matierefiliere', ['id' => $matierefiliereid]);
    }


    public function foreingkey (int $idmatiere, int $idfiliere, int $cycle)
    {
        global $DB;

        $sql = "SELECT * FROM 
        {matierefiliere} m,  {course} c, {filiere} f, {cycle} cy
        WHERE m.idcycle = cy.id
        AND m.idfiliere = f.id
        AND m.idmatiere = c.id";


        return $DB->get_records_sql($sql);

        var_dump($sql);
        die;
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_matierefiliere(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('matierefiliere', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}