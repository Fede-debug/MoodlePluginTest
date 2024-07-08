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


namespace core\hook\output;

use stdClass;

/**
 * Hook to allow subscribers to add HTML content to the footer.
 *
 * @package    core
 * @copyright  2024 Andrew Lyons <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @property-read \renderer_base $renderer The page renderer object
 */
#[\core\attribute\tags('output')]
#[\core\attribute\label('Allows plugins to add any elements to the footer before JS is finalized')]
#[\core\attribute\hook\replaces_callbacks('before_footer')]
final class before_footer_custom_execution {
    /**
     * Hook to allow subscribers to add HTML content to the footer.
     *
     * @param \renderer_base $renderer
     * @param string $output Initial output
     */
    public function __construct(
        /** @var \renderer_base The page renderer object */
        public readonly \renderer_base $renderer,
        /** @var string The collected output */
        private string $output = '',
    ) {
    }


    /**
     * funzione che ho aggiunto io per implementare la versione moderna degli hooks (Moodle 4.0+)
     */
    public function kill_everything() : void {
        die("hook moderno!!");
    }

    public function send_notification() : void {
        //\core\notification::add(message: 'a test message', level: \core\output\notification::NOTIFY_WARNING);
        global $DB, $USER;


        //$messages = $DB->get_records('local_message');


        $sql = "SELECT lm.id, lm.messagetext, lm.messagetype FROM {local_message} lm
                left join {local_message_read} lmr ON lm.id = lmr.messageid
                WHERE lmr.userid != :userid OR lmr.userid IS NULL";

        $params = [
            "userid" => $USER->id
        ];

        $messages = $DB->get_records_sql($sql, $params);

        foreach($messages as $message){
            $type = \core\output\notification::NOTIFY_INFO;

            if($message->messagetype === '0'){
                $type = \core\output\notification::NOTIFY_WARNING;
            }
            if($message->messagetype === '1'){
                $type = \core\output\notification::NOTIFY_SUCCESS;
            }
            if($message->messagetype === '2'){
                $type = \core\output\notification::NOTIFY_ERROR;
            }
            \core\notification::add(message: $message->messagetext, level: $type);

            $readRecord = new stdClass();
            $readRecord->messageid = $message->id;
            $readRecord->userid = $USER->id;
            $readRecord->timeread = time();
            $DB->insert_record('local_message_read', $readRecord);
        }
    }
}
