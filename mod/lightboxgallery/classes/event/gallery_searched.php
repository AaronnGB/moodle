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
 * The mod_lightboxgallery course searched event.
 *
 * @package    mod_lightboxgallery
 * @copyright  Copyright (c) 2021 Open LMS (https://www.openlms.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_lightboxgallery\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The mod_lightboxgallery gallery searched event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string searchterm: The searchterm used on lightboxgallery search.
 *      - int lightboxgalleryid: The lbg instance id.
 * }
 *
 * @package    mod_lightboxgallery
 * @since      Moodle 2.7
 * @copyright  Copyright (c) 2021 Open LMS (https://www.openlms.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gallery_searched extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        $searchterm = s($this->other['searchterm']);
        return "The user with id '$this->userid' has searched the lightboxgallery with id '{$this->other['lightboxgalleryid']}'".
            " for lightboxgallery images containing \"{$searchterm}\".";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgallerysearched', 'mod_lightboxgallery');
    }

    /**
     * Get URL related to the action
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/lightboxgallery/search.php',
            array('id' => $this->courseid, 'gallery' => $this->other['lightboxgalleryid'], 'search' => $this->other['searchterm']));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['searchterm'])) {
            throw new \coding_exception('The \'searchterm\' value must be set in other.');
        }

        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }
    }

    public static function get_other_mapping() {
        return [];
    }

}

