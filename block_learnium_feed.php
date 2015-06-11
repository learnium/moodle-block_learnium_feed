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
 * Learnium feed block
 *
 * @package   block_learnium_feed
 * @copyright Becca Hughes <rebecca@learnium.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
if(!class_exists('JWT')){
    require_once(dirname(__FILE__).'/JWT.php');
}

class block_learnium_feed extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_learnium_feed');
    }

    function get_content() {
        global $CFG, $OUTPUT, $DB;

        // Get the config
        $config = get_config('learnium_feed');

        // If the content has already been set, use that
        if ($this->content !== null) {
            return $this->content;
        }

        // If we don't have an instance, use blank
        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        // Bad configuration
        if(empty($config->bridge_id) || empty($config->bridge_secret) || empty($config->environment)){
            $this->content = '';
            return $this->content;
        }

        // Setup the output
        $this->content = new stdClass();

        // Generate the JWT
        $payload = array(
            "course_id" => $this->page->course->id,
        );

        // Add the graph id if we need it
        if(!empty($this->config->graphid)) {
            $payload['course_gbid'] = $this->config->graphid;
        }

        // Find out if we have any Learnium bridges installed
        try {
            $r = $DB->get_record('learnium', array('course' => $this->page->course->id), '*');

            // Build the full url for the page
            $url = new moodle_url("/mod/learnium/view.php", array(
                "n" => $r->id,
            ));
            $payload['bridge_url'] = $url->out();
        } catch (Exception $e) {}

        // Generate the iFrame code
        $qs = http_build_query(array(
            "payload" => JWT::encode($payload, $config->bridge_secret),
            "bridge_id" => $config->bridge_id,
        ));
        $url = $config->environment . "embed/plugin/course/?" . $qs;
        $iframe = '<iframe style="width: 290px;height: 530px;border: none;" src="' . $url . '"></iframe>';
        $this->content->text = $iframe;
        return $this->content;
    }

    public function applicable_formats() {
        return array('all' => false,
                     'site' => false,
                     'site-index' => false,
                     'course-view' => true,
                     'course-view-social' => false,
                     'mod' => false,
                     'mod-quiz' => false);
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function has_config() {
        return true;
    }

    public function cron() {
        return true;
    }
}
