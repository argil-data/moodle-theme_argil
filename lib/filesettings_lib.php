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
 * argil backgrounds callbacks.
 *
 * @package    theme_argil
 * @copyright  2017 Argillearn X
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */

defined('MOODLE_INTERNAL') || die();

function theme_argil_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('argil');
    }
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === '')) {
        $theme = theme_config::load('argil');
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } 
	else if (preg_match("/^sld[1-9][0-9]?$/", $filearea)) {
		return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
	else if (preg_match("/^sld\d+dark$/", $filearea)) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
	else if (preg_match("/^prestationtestimonialimg[1-9][0-9]?$/", $filearea)) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
	else if (preg_match("/^teamphoto[1-9][0-9]?$/", $filearea)) {
		return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
	else {
		send_file_not_found();
    }
}


/**
 * This function creates the dynamic HTML needed for some
 * settings and then passes it back in an object so it can
 * be echo'd to the page.
 *
 * This keeps the logic out of the layout files.
 *
 * @param string $setting bring the required setting into the function
 * @param bool $format
 * @param string $setting
 * @param array $theme
 * @param stdclass $CFG
 * @return string
 */
function theme_argil_get_setting($setting, $format = false) {
    global $CFG;
    require_once($CFG->dirroot . '/lib/weblib.php');
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('argil');
    }
    if (empty($theme->settings->$setting)) {
        return false;
    } else if (!$format) {
        return $theme->settings->$setting;
    } else if ($format === 'format_text') {
        return format_text($theme->settings->$setting, FORMAT_PLAIN);
    } else if ($format === 'format_html') {
        return format_text($theme->settings->$setting, FORMAT_HTML, array('trusted' => true, 'noclean' => true));
    } else {
        return format_string($theme->settings->$setting);
    }
}
