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

 require_once(__DIR__ . '/../../config.php');

 global $DB;

 //require_admin();

 require_login();
 $context = \context_system::instance();
 require_capability('local/message:managemessages', $context);

 $PAGE->set_url(new moodle_url(url: '/local/message/manage.php'));
 $PAGE->set_context(\core\context\system::instance());
 $PAGE->set_title(title: get_string('manage_messages', 'local_message'));
 $PAGE->set_heading(get_string('manage_messages', 'local_message'));

 $PAGE->requires->js_call_amd('local_message/confirm');

 
 $PAGE->requires->css('/local/message/styles.css');

 $messages = $DB->get_records('local_message', null, 'id');

 echo $OUTPUT->header();

 //echo '<h1>Hello World></h1>';

$templateContext = (object)[
    'messages' => array_values($messages),
    'editurl' => new moodle_url('/local/message/edit.php'),
    'bulkediturl' => new moodle_url('/local/message/bulkedit.php'),
];

echo $OUTPUT->render_from_template('local_message/manage', $templateContext);

 echo $OUTPUT->footer();