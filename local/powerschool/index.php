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
// require_once($CFG->libdir.'/adminlib.php');

// $path = optional_param('path','',PARAM_PATH);
// $pageparams = array();

// if($path){
//     $pageparams['path'] = $path;
// }

// $previewnode = $PAGE->navigation->add('annee scolaire', new moodle_url('/local/anneescolaire.php'), navigation_node::override_active_url(new moodle_url('/powerschool/index.php')));
// $thingnode = $previewnode->add('campus', new moodle_url('/local/campus.php'));
// $thingnode->make_active();

// $settingnode = $PAGE->settingsnav->add('annee scolaire', new moodle_url('/local/anneescolaire.php'), navigation_node::TYPE_CONTAINER);
// $thingnode = $settingnode->add('campus', new moodle_url('/local/campus.php'));
// $thingnode->make_active();

$PAGE->navbar->ignore_active(true);
$PAGE->navbar->add('Administration du Site',  $PAGE->url->out_omit_querystring());
// $PAGE->navbar->add('campus', new moodle_url('/local/campus.php'));

// navigation_node::override_active_url(new moodle_url('/powerschool/index.php'), true);
// $PAGE->set_primary_active_tab('home');
// $PAGE->navbar->add(get_string('coursemgmt', 'admin'), $managementurl);
// admin_externalpage_setup('powerschool','',$pageparams);

// $PAGE->navbar->ignore_active(); 

// navigation_node::override_active_url(new moodle_url('/powerschool/index.php'), true);
$PAGE->settingsnav->add(get_string('reglagess'),  new moodle_url('/powerschool/index.php'),  navigation_node::TYPE_CONTAINER);
// $PAGE->set_primary_active_tab('home');
// $PAGE->secondarynav->children->find('powerschool');
$PAGE->navbar->add(get_string('reglages', 'local_powerschool'), $managementurl);
// admin_externalpage_setup('powerschool','',$pageparams);



global $DB;

require_login();
$context = context_system::instance();
require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/index.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('index');
// $title = 'Accueil';
// $PAGE->navbar->add($title);

$PAGE->set_title('Accueil');
// $PAGE->set_heading('Accueil');


echo $OUTPUT->header();

$templatecontext = (object)[
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


echo $OUTPUT->render_from_template('local_powerschool/index', $templatecontext);


echo $OUTPUT->footer();
