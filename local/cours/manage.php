<?php
// This file is part of Moodle - http://moodle.org/
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
 * @package   plugintype_pluginname
 * @copyright 2020, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



require_once (__DIR__ . '/../../config.php');

global $DB;

$PAGE->set_url(new moodle_url('/local/cours/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Liste des cours');

$cours = $DB->get_records('cours');


echo $OUTPUT->header();


$templatecontext = (object)[
   'listedescours' =>array_values($cours),
   'editurl' =>new moodle_url('/local/cours/create.php')
];

echo  $OUTPUT->render_from_template('local_cours/manage', $templatecontext);

echo $OUTPUT->footer();