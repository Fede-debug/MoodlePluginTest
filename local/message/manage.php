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
 $PAGE->set_url(new moodle_url(url: '/local/message/manage.php'));
 $PAGE->set_context(\core\context\system::instance());
 $PAGE->set_title(title: 'Manage messages');

 $messages = $DB->get_records('local_message');

 echo $OUTPUT->header();

 //echo '<h1>Hello World></h1>';

$templateContext = (object)[
    'messages' => array_values($messages),
    'editurl' => new moodle_url('/local/message/edit.php')
];

echo $OUTPUT->render_from_template('local_message/manage', $templateContext);

 echo $OUTPUT->footer();