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
use local_powerschool\form\modepaiement;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/form/modepaiement.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/modepaiement.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer un mode paiement');
$PAGE->set_heading('Enregistrer un mode paiement');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('Modepaiement', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new modepaiement();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
 
        $DB->insert_record('modepaiement', $recordtoinsert);
}

if($_GET['id']) {

    $mform->supp_modepaiement($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/modepaiement.php', 'Bien supp');
        
}



// var_dump($mform->selectmodepaiement());
// die;
$modepaiement = $DB->get_records('modepaiement', null, 'id');

$templatecontext = (object)[
    'modepaiement' => array_values($modepaiement),
    'modepaiementedit' => new moodle_url('/local/powerschool/modepaiementedit.php'),
    'modepaiementsupp'=> new moodle_url('/local/powerschool/modepaiement.php'),
];

echo $OUTPUT->header();
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/modepaiement', $templatecontext);


echo $OUTPUT->footer();