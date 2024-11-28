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
 * A two column layout for the boost theme.
 *
 * @package   theme_argil
 * @copyright 2017 Argillearn
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Prestations settings.                                 
	$pagePrestations = new admin_settingpage('theme_argil_prestations', get_string('settingsprestations', 'theme_argil'));  
	
	$name = 'theme_argil/show_menu_prestations';
    $title = get_string('show_menu', 'theme_argil'). ' ' .get_string('prestations', 'theme_argil');
    $description = '';
	$default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, true, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $pagePrestations->add($setting);
	
	$name = 'theme_argil/prestations_intro';
    $title = get_string('intro', 'theme_argil');
    $description = '';
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $pagePrestations->add($setting);
	

	for ($i = 1; $i <= 15; $i++) {
		$pagePrestations->add(new admin_setting_heading(
			'theme_argil_team' . $i . '_heading',
			get_string('team', 'theme_argil') . ' ' . $i,
			''
			));
		
		$name = 'theme_argil/teamorder' . $i;
		$title = get_string('order', 'theme_argil');
		$description = '0 = hidden';
		$setting = new admin_setting_configtext($name, $title, $description , '');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$pagePrestations->add($setting);
		
		$name = 'theme_argil/teamname' . $i;
		$title = get_string('name');
		$description = '';
		$default = '';
		$setting = new admin_setting_configtext($name, $title, $description, $default);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$pagePrestations->add($setting);
		
		$name = 'theme_argil/teamposte' . $i;
		$title = get_string('poste', 'theme_argil');
		$description = '';
		$default = '';
		$setting = new admin_setting_configtext($name, $title, $description, $default);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$pagePrestations->add($setting);
		
		$name = 'theme_argil/teamtel' . $i;
		$title = get_string('tel', 'theme_argil');
		$setting = new admin_setting_configtext($name, $title, '', '');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$pagePrestations->add($setting);
		
		$name = 'theme_argil/teamemail' . $i;
		$title = get_string('email');
		$setting = new admin_setting_configtext($name, $title, '', '');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$pagePrestations->add($setting);

		$imgsection = 'teamphoto'.$i;
		$name = 'theme_argil/'.$imgsection;
		$title = get_string('photo', 'theme_argil');
		$description = '';
		$setting = new admin_setting_configstoredfile($name, $title, $description, $imgsection);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$pagePrestations->add($setting);
	}
	

	$settings->add($pagePrestations);   