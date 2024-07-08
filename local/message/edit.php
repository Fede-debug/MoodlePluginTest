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

//namespace local_message;

/**
 * Hook callbacks for usertours.
 *
 * @package    local_message
 * @copyright  Federico Diana
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 $dirroot = $CFG->dirroot;

 require_once(__DIR__ . '/../../config.php');
 require_once($CFG->dirroot .'/local/message/classes/form/edit.php');

 $PAGE->set_url(new moodle_url(url: '/local/message/edit.php'));
 $PAGE->set_context(\core\context\system::instance());
 $PAGE->set_title(title: 'Edit');



 //echo '<h1>Hello World></h1>';
$mform = new edit();




// Form processing and displaying is done here.
if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot . '/local/message/manage.php', message: 'You cancelled the message form');
    
} else if ($fromform = $mform->get_data()) {
    // When the form is submitted, and the data is successfully validated,
    // the `get_data()` function will return the data posted in the form.
    $recordToInsert = new stdClass();
    $recordToInsert->messagetext = $fromform->messagetext;
    $recordToInsert->messagetype = $fromform->messagetype;

    $DB->insert_record('local_message', $recordToInsert);

    redirect($CFG->wwwroot . '/local/message/manage.php', message: 'you created this message: ' . $fromform->messagetext);

}


echo $OUTPUT->header();
$mform->display();
 echo $OUTPUT->footer();
