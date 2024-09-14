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
 * @package     local_message
 * @author      Federico
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 defined('MOODLE_INTERNAL') || die();


use local_message\message_manager;
 use core_external\external_api;
 use core_external\external_value;
 use core_external\external_function_parameters;


 class local_message_external extends external_api {

    public static function delete_message_parameters() {
        return new external_function_parameters(
            ['messageid' => new external_value(type: PARAM_INT, desc: 'id of message')] 
        );
    }

    public static function delete_message($messageid) {
        $params = self::validate_parameters(self::delete_message_parameters(), ['messageid' => $messageid]);
        
        $context = \context_system::instance();
    require_capability('local/message:managemessages', $context);

        $manager = new message_manager();
        $manager->delete_message($messageid);
    }

    public static function delete_message_returns() {
        return new external_value(type: PARAM_BOOL, desc: 'True if the message was successfully deleted') ;
    }


 }