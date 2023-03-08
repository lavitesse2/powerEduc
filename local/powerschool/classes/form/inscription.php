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

class inscription extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $req = new campus();

        $annee = $campus = $user = $filiere = $cycle= array();
        $sqlannee = "SELECT * FROM {anneescolaire} ";
        $sqlcampus = "SELECT * FROM {campus}";
        $sqluser = "SELECT * FROM {user} ";
        $sqlfiliere = "SELECT * FROM {filiere}";
        $sqlcycle = "SELECT * FROM {cycle} ";

        $annee = $req->select($sqlannee);
        $campus = $req->select($sqlcampus);
        $user = $req->select($sqluser);
        $filiere = $req->select($sqlfiliere);
        $cycle = $req->select($sqlcycle);

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'numeroinscription', 'Numero d\'inscription'); // Add elements to your form
        $mform->setType('numeroinscription', PARAM_INT);                   //Set type of element
        $mform->setDefault('numeroinscription', '');        //Default value

        foreach ($annee as $key => $val)
        {
            $selectannee[$key] = $val->datedebut." - ".$val->datefin;

        }
        foreach ($campus as $key => $val)
        {
            $selectcampus[$key] = $val->nomcampus;

        }
        
        foreach ($user as $key => $val)
        {
            $selectuser[$key] = $val->firstname." ".$val->lastname;

        }
        foreach ($filiere as $key => $val)
        {
            $selectfiliere[$key] = $val->libellefiliere;

        }
        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle;

        }
       
        $mform->addElement('select', 'idanneescolaire', 'Année Scolaire',$selectannee); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_INT);                   //Set type of element
        $mform->setDefault('idanneescolaire','');        //Default value

        $mform->addElement('select', 'idcampus', 'Campus', $selectcampus); // Add elements to your form
        $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcampus','');        //Default value

        $mform->addElement('select', 'iduser', 'Etudiant', $selectuser); // Add elements to your form
        $mform->setType('iduser', PARAM_INT);                   //Set type of element
        $mform->setDefault('iduser','');        //Default value

        $mform->addElement('select', 'idfiliere', 'Filiere ',$selectfiliere); // Add elements to your form
        $mform->setType('idfiliere', PARAM_INT);                   //Set type of element
        $mform->setDefault('idfiliere','');        //Default value

        $mform->addElement('select', 'idcycle', 'Cycle', $selectcycle); // Add elements to your form
        $mform->setType('idcycle', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcycle','');        //Default value

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
    public function update_inscription(int $id, int $numeroinscription, int $anneescolaire, int $idcampus, int $iduser, int $idfiliere, int $idcycle): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->numeroinscription = $numeroinscription ;
        $object->idanneescolaire = $anneescolaire;
        $object->idcampus = $idcampus;
        $object->iduser = $iduser;
        $object->idfiliere = $idfiliere;
        $object->idcycle = $idcycle;
        $object->usermodified = $USER->id;
        $object->timemodified = time();


        return $DB->update_record('inscription', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_inscription(int $inscriptionid)
    {
        global $DB;
        return $DB->get_record('inscription', ['id' => $inscriptionid]);
    }

    public function foreingkey (int $idannee, int $idcampus, int $iduser, int $idfiliere, int $cycle)
    {
        global $DB;

        $sql = "SELECT * FROM 
        {inscription} i, {anneescolaire} a, {campus} c, {user} u, {filiere} f, {cycle} cy
        WHERE i.idanneescolaire = a.id
        AND i.idcampus = c.id
        AND i.iduser = u.id
        AND i.idfiliere = f.id
        AND i.idcycle = cy.id";


        return $DB->get_records_sql($sql);

        // var_dump($sql);
        // die;
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_inscription(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppinscription = $DB->delete_records('inscription', ['id'=> $id]);
        if ($suppinscription){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}