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

use core\progress\display;
use local_powerschool\form\anneescolaire;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/form/anneescolaire.php');

require_once($CFG->libdir.'/adminlib.php');



// include('/local/powerschool/templates/navbar.mustache');


$path = optional_param('path','',PARAM_PATH);
$pageparams = array();

global $DB;

require_login();
$context = context_system::instance();
require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/anneescolaire.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une Année Scolaire');
// $PAGE->headingmenu (new moodle_url('/local/powerschool/templates/navbar.mustache'));
$PAGE->set_heading('Enregistrer une Année Scolaire');
$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('Annee', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
$PAGE->requires->js_call_amd('local_powerschool/confirmsupp');



$mform=new anneescolaire();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

 
        $DB->insert_record('anneescolaire', $recordtoinsert);
}

if($_GET['id']) {


    $mform->supp_annee($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Bien supp');
        
}

$annee = $DB->get_records('anneescolaire', null, 'id');

$templatecontext = (object)[
    'annee' => array_values($annee),
    'anneeedit' => new moodle_url('/local/powerschool/anneescolaireedit.php'),
    'anneesupp'=> new moodle_url('/local/powerschool/anneescolaire.php'),
];
$menu = (object)[
    'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    'campus' => new moodle_url('/local/powerschool/campus.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
    'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
    'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' => new moodle_url('/local/powerschool/seance.php'),
    'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
    'paiement' => new moodle_url('/local/powerschool/paiement.php'),
];


echo $OUTPUT->header();


echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);

echo $OUTPUT->skip_link_target();
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/anneescolaire', $templatecontext);



echo $OUTPUT->footer();
