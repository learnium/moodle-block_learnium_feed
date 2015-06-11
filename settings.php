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
 * Learnium feed block global configuration.
 *
 * @package   block_learnium_feed
 * @copyright Becca Hughes <rebecca@learnium.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$settings->add(new admin_setting_heading('header',
    get_string('headerconfig', 'block_learnium_feed'),
    get_string('descconfig', 'block_learnium_feed')));

$settings->add(new admin_setting_configtext('learnium_feed/bridge_id',
    get_string('bridge_id_label', 'block_learnium_feed'),
    get_string('bridge_id_description', 'block_learnium_feed'),
    "", PARAM_TEXT));

$settings->add(new admin_setting_configtext('learnium_feed/bridge_secret',
    get_string('bridge_secret_label', 'block_learnium_feed'),
    get_string('bridge_secret_description', 'block_learnium_feed'),
    "", PARAM_TEXT));

$options = array(
    "https://www.latest.learnium.net/" => get_string('env_uat', 'block_learnium_feed'),
    "http://www.mysandbox.learnium.net:8000/" => get_string('env_sandbox', 'block_learnium_feed'),
    "https://www.learnium.net/" => get_string('env_production', 'block_learnium_feed')
);

$settings->add(new admin_setting_configselect('learnium_feed/environment',
    get_string('environment_label', 'block_learnium_feed'),
    get_string('environment_description', 'block_learnium_feed'),
    0, $options));
