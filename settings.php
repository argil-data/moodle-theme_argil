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

if ($ADMIN->fulltree) {                                                                                                   
    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingargil', get_string('pluginname', 'theme_argil').' '.get_string('configsetting', 'theme_argil'));
 
    // Each page is a tab - the first is the "General" tab.
    $page = new admin_settingpage('theme_argil_general', get_string('settingsgeneral', 'theme_argil'));
	
	// Raw SCSS to include after the content.
    // $setting = new admin_setting_scsscode('theme_argil/scss', get_string('rawscss', 'theme_boost'),
    //     get_string('rawscss_desc', 'theme_boost'), '', PARAM_RAW);
    // $setting->set_updatedcallback('theme_reset_all_caches');
    // $page->add($setting);
	
	//link AI
	// $name = 'theme_argil/linkaienabled';
    // $title = get_string('aienabled', 'theme_argil');
    // $setting = new admin_setting_configcheckbox($name, $title, '', 0);
    // $page->add($setting);
	
	//menu archive
	// $name = 'theme_argil/archivesurl';
    // $title = get_string('archivesurl', 'theme_argil');
    // $description = get_string('archivesurldesc', 'theme_argil');
    // $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    // $page->add($setting);
	
	//Create and restore an course
	// $name = 'theme_argil/createcourseurl';
    // $title = get_string('url', 'theme_argil').': '.get_string('coursecreate', 'theme_argil');
    // $description = get_string('urldesc', 'theme_argil');
    // $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    // $page->add($setting);
	
	// $name = 'theme_argil/restorecourseurl';
    // $title = get_string('url', 'theme_argil').': '.get_string('courserestore', 'theme_argil');
    // $description = get_string('urldesc', 'theme_argil');
    // $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    // $page->add($setting);
	
	$settings->add($page); 
	
	// require('settings/slides_settings.php');
	// require('settings/prestations_settings.php');
	// require('settings/support_settings.php');
}
