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
 *
 *
 * @package   theme_argil
 * @copyright 2023 Argillearn
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


	$page = new admin_settingpage('theme_argil_frontpage_slider', get_string('settingsslides', 'theme_argil'));

    $page->add(new admin_setting_heading('theme_argil_slideshow', get_string('slideshowsettingsheading', 'theme_argil'),
        format_text(get_string('slideshowdesc', 'theme_argil'), FORMAT_MARKDOWN)));

    $name = 'theme_argil/sliderenabled';
    $title = get_string('sliderenabled', 'theme_argil');
    $description = get_string('sliderenableddesc', 'theme_argil');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);


	// Number of Sliders.
	$choices1to6 = array();
	$order0to5 = array();
    for ($i = 1; $i < 7; $i++) {
        $choices1to6[$i] = $i;
        $order0to5[$i] = $i-1;
    }
    $name = 'theme_argil/slidercount';
    $title = get_string('slidercount', 'theme_argil');
    $description = get_string('slidercountdesc', 'theme_argil');
    $default = 1;
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices1to6);
    $page->add($setting);
	
	$slidercount = get_config('theme_argil', 'slidercount');
	if (!$slidercount) {
        $slidercount = 1;
    }
	
	$listcarousels = [];
	foreach ($choices1to6 as $choice){
		$carouselimg = get_config('theme_argil', 'sld'. $choice);
		$carouselorder = get_config('theme_argil', 'order'. $choice);
		if($carouselorder == 1){
			$carouselorder = 7;
		}
		if(!empty($carouselimg)){
			$carousel = [];
			$carousel['order'] = $carouselorder;
			$carousel['id'] = $choice;
			$listcarousels[] = $carousel;
		}	
	}
	
	asort($listcarousels);
	if(count($listcarousels) > $slidercount){
		$listcarousels = array_slice($listcarousels, 0, $slidercount);
	}
	$nbrslideorder = count($listcarousels);
	
	foreach($listcarousels as $cobj){
		$sliderindex = $cobj['id'];
		$page->add(new admin_setting_heading('theme_argil_slideshowcontent'.$sliderindex, 'carousel-item-'.$sliderindex,'<br>'));
		
		$name = 'theme_argil/order'. $sliderindex;
		$title = get_string('order', 'theme_argil');
		$description = get_string('orderdesc', 'theme_argil');
		$default = 6;
		$setting = new admin_setting_configselect($name, $title, $description, $default, $order0to5);
		$page->add($setting);
	
		$fileid = 'sld' . $sliderindex;
        $name = 'theme_argil/sld' . $sliderindex;
        $title = get_string('sliderimage', 'theme_argil');
        $description = get_string('sliderimagedesc', 'theme_argil');
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid);
        $page->add($setting);
		/**/
		$fileid = 'sld' . $sliderindex . 'dark';
        $name = 'theme_argil/sld' . $sliderindex . 'dark';
        $title = get_string('sliderimage', 'theme_argil').'<br>Dark Mode';
        $description = get_string('sliderimagedescdark', 'theme_argil');
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid);
        $page->add($setting);
		
		$name = 'theme_argil/sld' . $sliderindex . 'url';
        $title = get_string('sliderurl', 'theme_argil');
        $description = get_string('sliderurldesc', 'theme_argil');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $page->add($setting);
		
		$name = 'theme_argil/sld' . $sliderindex . 'title';
        $title = get_string('title', 'theme_argil');
        $setting = new admin_setting_configtext($name, $title, '', '');
        $page->add($setting);
		
		
		$name = 'theme_argil/sld' . $sliderindex . 'cap';
        $title = get_string('slidercaption', 'theme_argil');
        $description = get_string('slidercaptiondesc', 'theme_argil');
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $page->add($setting);
		/**/
		$name = 'theme_argil/sld' . $sliderindex . 'capmob';
        $title = get_string('slidercaption', 'theme_argil').' mobile';
        $description = get_string('slidercaptiondescmob', 'theme_argil');
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $page->add($setting);
	}
	
	
	for ($sliderindex = $nbrslideorder+1; $sliderindex <= $slidercount; $sliderindex++) {
		$page->add(new admin_setting_heading('theme_argil_slideshowcontent'.$sliderindex, 'carousel-item-'.$sliderindex,'<br>'));
		
		$name = 'theme_argil/order'. $sliderindex;
		$title = get_string('order', 'theme_argil');
		$description = get_string('orderdesc', 'theme_argil');
		$default = 6;
		$setting = new admin_setting_configselect($name, $title, $description, $default, $order0to5);
		$page->add($setting);
	
		$fileid = 'sld' . $sliderindex;
        $name = 'theme_argil/sld' . $sliderindex;
        $title = get_string('sliderimage', 'theme_argil');
        $description = get_string('sliderimagedesc', 'theme_argil');
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid);
        $page->add($setting);
		
		$fileid = 'sld' . $sliderindex . 'dark';
        $name = 'theme_argil/sld' . $sliderindex . 'dark';
        $title = get_string('sliderimage', 'theme_argil').'<br>Dark Mode';
        $description = get_string('sliderimagedescdark', 'theme_argil');
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid);
        $page->add($setting);
		
		$name = 'theme_argil/sld' . $sliderindex . 'url';
        $title = get_string('sliderurl', 'theme_argil');
        $description = get_string('sliderurldesc', 'theme_argil');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $page->add($setting);
		
		$name = 'theme_argil/sld' . $sliderindex . 'title';
        $title = get_string('title', 'theme_argil');
        $setting = new admin_setting_configtext($name, $title, '', '');
        $page->add($setting);
		
		
		$name = 'theme_argil/sld' . $sliderindex . 'cap';
        $title = get_string('slidercaption', 'theme_argil');
        $description = get_string('slidercaptiondesc', 'theme_argil');
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $page->add($setting);
		
		$name = 'theme_argil/sld' . $sliderindex . 'capmob';
        $title = get_string('slidercaption', 'theme_argil').' mobile';
        $description = get_string('slidercaptiondescmob', 'theme_argil');
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $page->add($setting);
		
	}
	
	
$settings->add($page); 	