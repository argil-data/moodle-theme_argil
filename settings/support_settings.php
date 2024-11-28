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

 // contact support.  
	$description = '';
    $default = '';
	
	$pageSupport = new admin_settingpage('theme_argil_support', get_string('settingssupport', 'theme_argil'));  

	$name = 'theme_argil/show_menu_support';
    $title = get_string('show_menu', 'theme_argil'). ' ' .get_string('support', 'theme_argil');
    $setting = new admin_setting_configcheckbox($name, $title, $description, true, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $pageSupport->add($setting);
	
	
	$name = 'theme_argil/support_intro';
    $title = get_string('intro', 'theme_argil');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $pageSupport->add($setting);
	
	$pageSupport->add(new admin_setting_heading('theme_argil_support_more_heading',
        get_string('support_more', 'theme_argil'),''));	
		
		
	$name = 'theme_argil/support_more';
    $title = get_string('support_more', 'theme_argil');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $pageSupport->add($setting);
	
	
	$pageSupport->add(new admin_setting_heading(
	'theme_argil_helpdesk_heading',
	get_string('helpdesk', 'theme_argil'),
	'ces infomations seront affichées dans footer et aussi sur plusieurs pages.'
	));		
	
	
	$name = 'theme_argil/helpdesktel';
	$title = get_string('tel', 'theme_argil');
	$setting = new admin_setting_configtext($name, $title, '', '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$pageSupport->add($setting);
	
	$name = 'theme_argil/helpdeskhoraire';
	$title = get_string('openingtime', 'theme_argil');
	$setting = new admin_setting_configtext($name, $title, '', '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$pageSupport->add($setting);
	
	$name = 'theme_argil/helpdeskemail';
	$title = get_string('email');
	$setting = new admin_setting_configtext($name, $title, '', '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$pageSupport->add($setting);


	$settings->add($pageSupport);   