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

use core_h5p\core;

require_once (__DIR__ . '/../../config.php');
require_once ($CFG->dirroot . ' /local/test/classes/form/edit.php');


global $DB;

$PAGE->set_url(new moodle_url('/local/test/edit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('edit');

$mform = new edit();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/test/manage.php','vous avez annulé');
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
  //insert into db


  $recordtoinsert = new stdClass();

  $recordtoinsert->test = $fromform->messagetext;
  $recordtoinsert->testtype = $fromform->messagetype;

//   var_dump($fromform);
//   die;

  $DB->insert_record('test', $recordtoinsert);
  
//   \core\notification::add('Message bien enregisté', \core\output\notification::NOTIFY_SUCCESS);
  redirect($CFG->wwwroot . '/local/test/manage.php','Message bien enregisté');



} 

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();