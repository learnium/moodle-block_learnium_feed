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
 * Learnium Feed block
 *
 * @package   block_learnium_feed
 * @copyright Becca Hughes <rebecca@learnium.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_learnium_feed_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        // Header
        $mform->addElement('header', 'configheader', get_string('headerconfig', 'block_learnium_feed'));

        // Custom Learnium GBID
        $mform->addElement('text', 'config_graphid', get_string('graphid', 'block_learnium_feed'));
        $mform->setType('config_graphid', PARAM_TEXT);
    }
}
