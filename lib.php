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
 * Version details.
 *
 * @package    theme_argil
 * @copyright  2024 Vincent Delaleu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

// require('lib/argil_lib.php');
// require('lib/filesettings_lib.php');


function theme_argil_get_main_scss_content($theme) {
    global $CFG;

    static $boosttheme = null;
    if (empty($boosttheme)) {
        $boosttheme = theme_config::load('boost'); // Needs to be the Boost theme so that we get its settings.
    }

    $scss = '$enable-rounded: false !default;'; // TODO: A setting?

    $scss .= theme_boost_get_main_scss_content($boosttheme);

    $basedir = (!empty($CFG->themedir)) ? $CFG->themedir : $CFG->dirroot.'/theme/argil/scss';
    
	$clhvariables = file_get_contents($basedir. '/argil/_variables.scss');
	$color_base = file_get_contents($basedir. '/argil/_color_base.scss');
	$color = file_get_contents($basedir. '/argil/_color.scss');
	$fonts .= file_get_contents($basedir. '/argil/_fonts.scss');
	
	$scss .= $clhvariables . "\n" . $color_base  . "\n" . $color. "\n" . $fonts . "\n";
	$scss .= file_get_contents($basedir.'/argil.scss');
    return $scss;
}

/**
 * Parses SCSS before it is parsed by the SCSS compiler.
 *
 * This function can make alterations and replace patterns within the SCSS.
 *
 * @param string $scss The SCSS.
 * @param theme_config $theme The theme config object.
 * @return string The parsed SCSS.
 */
function theme_argil_process_scss($scss, $theme) {
	// Get all the defined settings for the theme and replace defaults.
    foreach ($theme->settings as $key => $val) {
        if (((!empty($val)) || (strlen($val) > 0)) && (array_key_exists('[[setting:'.$key.']]', $defaults))) {
            $defaults['[[setting:'.$key.']]'] = $val;
        }
    }
	
	// Replace the CSS with values from the $defaults array.
    $scss = strtr($scss, $defaults);
	return $scss;
}

function theme_argil_get_extra_scss($theme) {
	return !empty($theme->settings->scss) ? $theme->settings->scss . ' '  : '';	
}

/**
 * Initialize page
 * @param moodle_page $page
 */
function theme_argil_page_init(moodle_page $page) {
    global $CFG;
	$page->requires->jquery_plugin('pace', 'theme_argil');
    $page->requires->jquery_plugin('flexslider', 'theme_argil');
    $page->requires->jquery_plugin('ticker', 'theme_argil');
    $page->requires->jquery_plugin('easing', 'theme_argil');
	$page->requires->jquery_plugin('argil', 'theme_argil');
}