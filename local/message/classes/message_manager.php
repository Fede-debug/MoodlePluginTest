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
 * Hook callbacks for usertours.
 *
 * @package    local_message
 * @copyright  Federico Diana
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_message;

class message_manager
{

    public function create_message(string $messagetext, string $messagetype): bool
    {

        global $DB;

        $recordToInsert = new \stdClass();
        $recordToInsert->messagetext = $messagetext;
        $recordToInsert->messagetype = $messagetype;

        try {
            return $DB->insert_record('local_message', $recordToInsert);
        } catch (\dml_exception $e) {
            return false;
        }
    }

    public function update_message(int $id, string $message_text, string $message_type) : bool{
        global $DB;

        $recordToUpdate= new \stdClass();
        $recordToUpdate->id = $id;
        $recordToUpdate->messagetext = $message_text;
        $recordToUpdate->messagetype = $message_type;

        try {
            return $DB->update_record('local_message', $recordToUpdate);
        } catch (\dml_exception $e) {
            return false;
        }
    }

    public function get_messages($userid): array
    {
        global $DB, $USER;


        //$messages = $DB->get_records('local_message');


        $sql = "SELECT lm.id, lm.messagetext, lm.messagetype FROM {local_message} lm
                
                WHERE lm.id NOT IN (
                  SELECT messageid FROM {local_message_read} lmr WHERE lm.id = lmr.messageid AND lmr.userid = :userid
                  )";

        $params = [
            "userid" => $USER->id
        ];

        try {

            return $messages = $DB->get_records_sql($sql, $params);
        } catch (\dml_exception $e) {
            return [];
        }
    }

    public function mark_message_read($messageid, $userid) : bool
    {
        global $DB;

        try{
            $readRecord = new \stdClass();
        $readRecord->messageid = $messageid;
        $readRecord->userid = $userid;
        $readRecord->timeread = time();
        return $DB->insert_record('local_message_read', $readRecord, false);    
        }
        catch (\dml_exception $e)
        {
            return false;
        }       
    }

    public function get_message(int $messageid): object
    {
        global $DB;
        $message=$DB->get_record('local_message', ['id' => $messageid]);

        try {

            return $message=$DB->get_record('local_message', ['id' => $messageid]);
        } catch (\dml_exception $e) {
            return false;
        }
    }

    public function delete_message($messageid) : bool{
        global $DB;

        try {
            $transaction = $DB->start_delegated_transaction();

            $deletedMessage = $DB->delete_records('local_message', ['id' => $messageid]);
            $deletedRead = $DB->delete_records('local_message_read', ['messageid' => $messageid]);

            if($deletedMessage && $deletedRead) {
                $DB->commit_delegated_transaction($transaction);
            }

            return true;
        } catch (\dml_exception $e) {
            return false;
        }
    }
}
