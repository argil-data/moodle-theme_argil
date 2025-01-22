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

namespace theme_argil\output;

use coding_exception;
use html_writer;
use tabobject;
use tabtree;
use custom_menu_item;
use custom_menu;
use block_contents;
use navigation_node;
use action_link;
use stdClass;
use moodle_url;
use preferences_groups;
use action_menu;
use help_icon;
use single_button;
use single_select;
use paging_bar;
use url_select;
use context_course;
use pix_icon;
use theme_config;

defined('MOODLE_INTERNAL') || die;

require_once ($CFG->dirroot . "/course/renderer.php");



/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_argil
 * @copyright  2023 argillearn hes-so
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class core_renderer extends \theme_boost\output\core_renderer {
	
	public function course_title()
	{
		global $PAGE;
		//$html = html_writer::start_div('region-main-header');
        //$html .= $this->context_header();
        //$html .= html_writer::end_div();
		$html = $this->context_header();
		return $html;
	}
	
	public function page_title_html()
	{
		global $PAGE;

        $html = '<div class="page-context-header"><div class="page-header-headings"><h1>';
        $html .= $this->page_title();
        $html .= '</h1>';
		
		return $html;
	}
	
	public function get_logo_url_theme()
	{
		$imgurl =  $this->image_url('logo_W', 'theme_argil');
		return $imgurl;
	}

	public function get_compact_logo_url_theme()
	{
		$imgurl =  $this->image_url('logo_W_compact', 'theme_argil');
		return $imgurl;
	}
	
	public function topmenu($menu, $optionpage = '') 
	{
		global $PAGE;
		$iscontact = false;
		$issupport = false;
		$isargillearn = false;
		

		if($optionpage == 'support')
		{
			$issupport = true;
			$menu[0]['isactive'] = '';
		}
		else if($optionpage == 'argillearn')
		{
			$isargillearn = true;
			$menu[0]['isactive'] = '';
		}
		else if($optionpage == 'contact')
		{
			$iscontact = true;
			$menu[0]['isactive'] = '';
		}
		
		$found_key = array_search('siteadminnode', array_column($menu, 'key'));
		if($found_key)
		{
			$out = array_splice($menu, $found_key, 1);
			array_splice($menu, 0, 0, $out);
			$menu[0]['text'] = get_string('administration', 'core');
			$menu[0]['classes'] = 'nav-icon nav-'.$menu[0]['key'];
			$menu[0]['actionattributes'][] = [
				'name' => 'title',
				'value' => get_string('administration', 'core')
				];
		}
		
		foreach($menu as $key=>$mitem)
		{
			
			if($mitem['key'] == 'home')
			{
				$menu[$key]['actionattributes'][] = [
				'name' => 'title',
				'value' => get_string('home', 'core')
				];
			}
			else if($mitem['key'] == 'myhome')
			{
				$menu[$key]['actionattributes'][] = [
				'name' => 'title',
				'value' => get_string('myhome', 'core')
				];
			}
			else if($mitem['key'] == 'courses')
			{
				$menu[$key]['actionattributes'][] = [
				'name' => 'title',
				'value' => get_string('mycourses', 'core')
				];
			}
		}

		if($PAGE->theme->settings->show_menu_support)
		{
			$menuitem = [];
			$menuicon = '<svg class="icon" title="'.get_string('support', 'theme_argil').'" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="100px"><path fill="#ffffff" d="M256 504c136.967 0 248-111.033 248-248S392.967 8 256 8 8 119.033 8 256s111.033 248 248 248zm-103.398-76.72l53.411-53.411c31.806 13.506 68.128 13.522 99.974 0l53.411 53.411c-63.217 38.319-143.579 38.319-206.796 0zM336 256c0 44.112-35.888 80-80 80s-80-35.888-80-80 35.888-80 80-80 80 35.888 80 80zm91.28 103.398l-53.411-53.411c13.505-31.806 13.522-68.128 0-99.974l53.411-53.411c38.319 63.217 38.319 143.579 0 206.796zM359.397 84.72l-53.411 53.411c-31.806-13.505-68.128-13.522-99.973 0L152.602 84.72c63.217-38.319 143.579-38.319 206.795 0zM84.72 152.602l53.411 53.411c-13.506 31.806-13.522 68.128 0 99.974L84.72 359.398c-38.319-63.217-38.319-143.579 0-206.796z"></path></svg>';
			
			$menuitem['title']=get_string('support', 'theme_argil');
			$menuitem['actionattributes'][] = [
				'name' => 'title',
				'value' => get_string('support', 'theme_argil')
				];
			$menuitem['classes']='nav-support';
			$menuitem['text']='' .get_string('support', 'theme_argil') . '';
			$menuitem['url'] = new moodle_url('/', array('redirect' => '0', 'op' => 'support'));
			$menuitem['key']='linksp';
			$menuitem['isactive']=$issupport;
			$menu[]  = $menuitem;
		}
	
		if($PAGE->theme->settings->show_menu_prestations)
		{
			
			$menuitem = [];
			$menuicon = '<svg class="icon" title="Argillearn" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100px" " viewBox="0 0 300 180"  xml:space="preserve">
				<path  d="M85.9,179.6c-22.7,0-41.3-8.2-55.9-24.8C15.5,138.4,8.2,116.6,8.2,89.4c0-27,7.4-48.5,22.1-64.5c14.9-16,33.6-24,56.1-24 	c20.3,0,36.8,5.4,49.3,16.1c12.5,10.7,19.6,25.3,21.1,43.9h-33.1c-1.4-9.4-5.2-16.6-11.4-21.8C106.1,34,98,31.4,88,31.4 	c-14.1,0-25.1,5.2-33.1,15.7c-8,10.5-12,24.6-12,42.4c0,18.4,4,33,12,43.7s19,16.1,33.1,16.1c10.2,0,18.3-2.8,24.4-8.3 	c6.1-5.6,9.9-12.9,11.3-22.1h32.9c-1.4,19-8.4,34-20.9,44.7C123.2,174.3,106.6,179.6,85.9,179.6z"/>
				<path d="M212.5,0.9v145.6h86.1v33.1H175.8V0.9H212.5z"/>
			</svg>';
			
			$menuitem['title']='ArgilLearn';
			$menuitem['actionattributes'][] = [
				'name' => 'title',
				'value' => 'ArgilLearn'
				];
			$menuitem['classes']='nav-cl nav-svg';
			$menuitem['text']=$menuicon. '<span class="menutxt">ArgilLearn</span>';
			$menuitem['url'] = new moodle_url('/', array('redirect' => '0', 'op' => 'argillearn'));
			$menuitem['key']='linkcl';
			$menuitem['isactive']=$isargillearn;
			
			$menu[]  = $menuitem;
		}	
		
		$archurl = ''.$PAGE->theme->settings->archivesurl;
		if(strlen($archurl) > 4)
		{
			$menuitem = [];
			$menuicon = '<svg class="icon" title="'.get_string('archives', 'theme_argil').'" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M32 32H480c17.7 0 32 14.3 32 32V96c0 17.7-14.3 32-32 32H32C14.3 128 0 113.7 0 96V64C0 46.3 14.3 32 32 32zm0 128H480V416c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V160zm128 80c0 8.8 7.2 16 16 16H336c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16z"/></svg>';
			$menuitem['title']=get_string('archives', 'theme_argil');
			$menuitem['actionattributes'][] = [
				'name' => 'title',
				'value' => get_string('archives', 'theme_argil')
				];
			$menuitem['actionattributes'][] = [
				'name' => 'target',
				'value' => '_blank'
				];
			$menuitem['classes']='nav-archives nav-svg';
			$menuitem['text']=$menuicon. '<span class="menutxt">' .get_string('archives', 'theme_argil') . '</span>';
			$menuitem['url'] = $archurl;
			$menuitem['key']='linkarch';
			$menuitem['isactive']='';
			$menu[]  = $menuitem;
		}
		
		$menuitem = [];
		$menuicon ='<svg class="icon" version="1.1" id="Logos" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 177.7 78.9" xml:space="preserve" style="width: 56px; height: auto;">
		<path class="st0" d="M168.7,27.2c-0.1-3.4-0.8-6.9-3.2-9.5c-2.3-2.5-5.8-3.5-9.4-3.5c-5.2,0-8.3,2-9.7,3.4c-3.5,3.3-3.6,8.1-3.6,10 	c0,1.6,0.1,6.6,3.6,10c1.7,1.6,4.7,3.3,9.4,3.3c3.7,0,6.7-0.8,9-3c1.7-1.6,2.8-3.5,3.4-6C168.6,30.5,168.7,28.9,168.7,27.2 	 M163,27.4c0.1,1,0,4.3-1.2,6.6c-1.5,2.7-4,3.3-6,3.3c-1,0-2.1-0.2-3.1-0.6c-4.1-2-4.2-6.9-4.2-8.9c0-2.1,0.2-4.9,1.6-6.9 	c1.8-2.8,4.8-2.9,5.8-2.9c2.9,0,4.6,1.3,5.6,2.8C162.8,22.9,163,26.2,163,27.4"/>
		<path class="st0" d="M131.6,25.4c2.1,0.6,6.8,2.2,6.8,7.4c0,2-0.8,4.2-2.9,5.8c-2.8,2.2-6.5,2.4-8.4,2.4c-2.8,0-5.2-0.5-7.2-1.2 	c-0.3-0.1-0.5-0.2-0.8-0.3l-0.3-0.4c0.2-1.9,0.2-2.2,0.3-4.1l0.5-0.1c0.9,0.7,3.2,2.4,7.3,2.4c4.1,0,5.6-2.2,5.6-3.7 	c0-2.3-2.2-3-5.4-4l-1.7-0.5c-2.1-0.6-6.8-2.1-6.8-7.1c0-5.1,4.7-7.6,10.6-7.6c3.9,0,6.6,1,7.5,1.4l0.3,0.3c-0.2,1.8-0.3,2-0.4,3.9 	l-0.5,0.2c-1.3-0.8-3.3-2-6.7-2c-0.7,0-1.5,0-2.2,0.2c-1.6,0.4-2.9,1.4-2.9,3c0,2.1,2.1,2.8,5.4,3.7L131.6,25.4z"/>
		<path class="st0" d="M112.8,27.6c0,1.7-1.4,3.1-3.1,3.1s-3.1-1.4-3.1-3.1s1.4-3.1,3.1-3.1S112.8,25.9,112.8,27.6"/>
		<path class="st0" d="M93.5,24.5c2.9,1,6.9,2.5,6.9,7.9c0,0.3,0,0.7-0.1,1.1c-0.9,7-8.8,7.7-12.8,7.7c-3.8,0-6-0.8-8.6-1.7L78.8,39 	c0.2-2.5,0.3-3,0.4-5.6l0.5-0.2c0.8,0.6,1.2,0.9,2.1,1.4c1.9,0.9,4.1,1.4,5.5,1.4c2.9,0,4.1-1.3,4.1-2.6c0-1.8-2.3-2.5-3.7-3l-2-0.7 	c-2.5-0.9-6.8-2.5-6.8-7.7c0-2,0.7-3.4,1.4-4.3c2.7-3.7,7.8-3.9,10.4-3.9c3.4,0,5.5,0.6,8,1.2l0.3,0.3l-0.5,5.4L98,20.9 	c-1.3-0.8-3.3-2.1-6.5-2.1s-3.7,1.6-3.7,2.2c0,1.4,1.4,1.9,3.2,2.5L93.5,24.5z"/>
		<path class="st0" d="M71.4,33.3c-2,1-4.3,2.1-8.2,2.1c-3.1,0-5.3-0.9-6.5-2.7c-0.8-1-0.9-2-1.1-3l16.9-0.3l0.3-0.3 	c-0.1-2.4-0.1-4.9-0.8-7.3c-1.8-5.8-5.9-7-7.6-7.4c-1.3-0.3-2.5-0.4-3.7-0.4C52.4,13.9,47,19,47,27.5c0,2.3,0.4,4.7,1.3,6.5 	c3,6.6,10.1,7.2,13.9,7.2c4.3,0,6.2-0.7,9-1.8l0.3-0.4l0.4-5.6L71.4,33.3z M55.6,24.5c0.2-1.5,0.5-3.6,2.5-4.8 	c0.6-0.4,1.4-0.5,2.1-0.5c1.7,0,2.8,0.8,3.3,1.7c0.7,1.1,0.8,2.3,0.8,3.4L55.6,24.5z"/>
		<path class="st0" d="M41.1,6C41,9.8,41,12.1,41,15.6c0,8.3,0.2,16.5,0.6,24.8l-0.3,0.3c-4.4,0-5.5,0-9.4,0.1l-0.3-0.3 	c0.3-6.9,0.3-8.6,0.2-15.2c-2.1,0-4.2-0.1-6.3-0.1c-2,0-4,0-6.3,0.1c0.1,7.1,0.1,8.9,0.4,15l-0.3,0.3c-4.6,0-5.5,0-9.4,0.1l-0.3-0.3 	c0.1-4.1,0.2-6.5,0.2-11c0-12.2-0.3-18.3-0.6-23.3l0.3-0.3c4.5,0,5.3,0,9.4-0.1L19.4,6l-0.1,13c1.8,0,3.7,0,5.5,0c2.4,0,4.7,0,7-0.1 	c-0.1-5.8-0.1-7.2-0.4-12.8l0.3-0.3c4.4,0,5.1,0,9.3-0.1L41.1,6z"/>
		<g>
			<path class="stG" d="M12.5,53.6h2l6,14v-14H23v21.1h-1.9L15,60.2v14.4h-2.5V53.6z"/>
			<path class="stG" d="M31.3,67.5v-14h2.8v14.1c0,2.7,0.3,4.9,2.8,4.9s2.8-2.2,2.8-4.9v-14h2.8v14c0,4.4-1,7.3-5.6,7.3 S31.3,71.9,31.3,67.5z"/>
			<path class="stG" d="M51.1,53.6H54l3.7,17.1l3.7-17.1h2.9l0.4,21.1h-2.4l-0.2-15.3l-3.6,15.3h-1.7l-3.5-15.3l-0.2,15.3h-2.4 L51.1,53.6z"/>
			<path class="stG" d="M73.1,53.6h8.2v2.2h-5.2v7h4.2v2.1h-4.2v7.7h5.3v2.1h-8.2V53.6H73.1z M78.1,47.2h2.8L78,52.3h-1.4L78.1,47.2z"/>
			<path class="stG" d="M88.9,53.6h4.2c4.2,0,6.2,1.6,6.2,5.6c0,2.5-0.7,4.3-2.6,4.9l3,10.6h-2.8l-2.8-9.9h-2.3v9.9h-2.9L88.9,53.6 L88.9,53.6z M93,62.6c2.5,0,3.5-0.8,3.5-3.5c0-2.5-0.7-3.5-3.4-3.5h-1.3v7H93z"/>
			<path class="stG" d="M107.8,53.6h2.9v21.1h-2.9V53.6z"/>
			<path class="stG" d="M125.1,74.8c-0.2,0-0.3,0-0.5,0c-4.3,0-5.8-2.7-5.8-6.8v-8c0-4.2,1.5-6.7,5.8-6.7c4.2,0,5.8,2.5,5.8,6.7v8 c0,3.1-0.9,5.4-3.1,6.3c0.6,0.8,1.4,1.8,2.1,2.2l-0.5,2.3C127.5,78.2,126.1,76.3,125.1,74.8z M127.4,68.7v-9.2 		c0-2.3-0.4-3.8-2.8-3.8s-2.8,1.4-2.8,3.8v9.2c0,2.3,0.4,3.9,2.8,3.9C127,72.5,127.4,71,127.4,68.7z"/>
			<path class="stG" d="M138.3,67.5v-14h2.8v14.1c0,2.7,0.3,4.9,2.8,4.9s2.8-2.2,2.8-4.9v-14h2.8v14c0,4.4-1,7.3-5.6,7.3 C139.4,74.9,138.3,71.9,138.3,67.5z"/>
			<path class="stG" d="M157.8,53.6h8.2v2.2h-5.2v7h4.2v2.1h-4.2v7.7h5.3v2.1h-8.2V53.6H157.8z"/>
		</g>
		</svg>';
		
		$menuitem['title']='X Numérique';
		$menuitem['actionattributes'][] = [
				'name' => 'title',
				'value' => 'X Numérique'
				];
		$menuitem['actionattributes'][] = [
				'name' => 'target',
				'value' => '_blank'
				];
		$menuitem['classes']='nav-hesso-digital nav-svg nav-svg-1440';
		$menuitem['text']=$menuicon. '<span class="menutxt">X Numérique</span>';
		$menuitem['url'] = 'https://numerique.hes-so.ch/';
		$menuitem['key']='linknumerique';
		$menuitem['isactive']='';

		$menu[] = $menuitem;
		
		
		return $menu;
	}
	
	public function should_display_ai_logo(){
		global $PAGE;
		
		if (!empty($PAGE->theme->settings->linkaienabled)) {
			return true;
		}
		return false;
	
	}

	public function custom_menu_language()
	{
		global $CFG;
		$langmenu = new custom_menu();
		
		$langs = get_string_manager()->get_list_of_translations();
        $haslangmenu = $this->lang_menu() != '';

        if (!$haslangmenu) {
            return '';
        }
		else{
            $strlang = get_string('language');
            $currentlang = current_language();
            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $strlang;
            }
            
            $start  = strpos($currentlang,"(" );
            $end = strpos($currentlang,")");
            $langcode = substr($currentlang, $start+1, $end-$start-1);

            $this->language = $langmenu->add($langcode, new moodle_url('#'), $strlang, 10000);
            foreach ($langs as $langtype => $langname) {
				if($langtype != $langcode){
					$this->language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
				}
                
            }
		}
		$content = '';
        foreach ($langmenu->get_children() as $item) {
            $context = $item->export_for_template($this);
            $content .= $this->render_from_template('theme_argil/custom_langmenu_item', $context);
        }

        return $content;
	}
	
	
	public function custom_menu_account()
	{
		$cMenuHeader='';
		if(isloggedin() && !isguestuser())
		{
			$cMenuHeader .= '<div id="usermenu-warp">';
			if (isguestuser()) 
			{
				$cMenuHeader .= '<div class="usermenu"><span class="login">';
				$cMenuHeader .= get_string('guestUser');
				$cMenuHeader .= html_writer::link(new moodle_url('/login/index.php'), get_string('login'));
				$cMenuHeader .= '</span></div>';
				
			}
			else
			{
				$cMenuHeader .=  $this->navbar_plugin_output();
				$cMenuHeader .= \core_renderer::user_menu();
				
			}
			$cMenuHeader .= '</div>';
			//$cMenuHeader .= '<div id="loginblock">aaa</div>';
		}

		return $cMenuHeader;
	}

	public function costom_loginBox() {
		
		$loginurl = get_login_url();
		
		$returnstr = "";
		$usermenulist = "";
		$usertxtlogin = '<span class="usertext">';
		$userpiclogin = '';
		$usertxtlogintmp = '';
		
		if (during_initial_install()) {return $returnstr;}
		
		
	
		$usertxtlogintmp = get_string('loggedinnot');
		if (isguestuser()) 
		{
			$usertxtlogintmp = get_string('loggedinasguest');
		}
		$userpiclogin = html_writer::tag('img', '',
			array(
				'src'=>$this->image_url('i/user'),
				'class'=>'userpicture',
				'alt'=>get_string('login'),
				'title'=>$usertxtlogintmp
			)
		);
		$returnstr = '';


		if (strpos($_SERVER['REQUEST_URI'], "login") == false && !isloggedin())
		{
			$logintoken = \core\session\manager::get_login_token();
			$returnstr .= '<div class="rowbloc moodle">
							<div class="boxheader fontoswald">compte externe</div>';

			$returnstr .= '<div class="loginpanel">';
			
			$returnstr .= '<form action="'.new moodle_url('/login/index.php').'" method="post" id="login">';
			$returnstr .= '<input type="hidden" name="logintoken" value="'.				$logintoken.'">';
									
			$returnstr .= '<div class="loginform">
							<div class="input-group input-group-username">
								<span class="input-group-addon">
									<i class="fa fa-user-circle"></i>
								</span>
								<input type="text" placeholder="'.get_string('username').'" name="username" id="username" class="form-control" size="15" value="">
							</div>
							<div class="input-group input-group-password">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								<input type="password" placeholder="'.get_string('password').'" name="password" id="password" class="form-control" size="15" value="">
							</div>
							<button type="submit" id="loginsubmitbtn" class="btn btn-primary btn-block" form="login" value="'.get_string('login').'">'.get_string('login').'</button>
							</div>
							
							<div class="clearer"><!-- --></div>';
			$returnstr .= '</form>';
			

			$returnstr .= '<div class="signup">
								<div class="forgetpass">
									<a href="'.new moodle_url('/login/forgot_password.php').'" class="linkLostPass">'.get_string('forgotaccount').'</a>
									<a href="'.new moodle_url('/login/signup.php').'" class="linkInscription">'.get_string('startsignup').'</a>
								</div>
							</div>';
			$returnstr .= '</div>';
			
			$returnstr .= '</div>';
		}
		
		return $returnstr;
	}
	
	
	public function getdarkmode() 
	{
		global $DB, $USER;

		if($dm_field = $DB->get_field('theme_clhes_darkmode', 'darkmode', array('userid' => $USER->id)))
		{
			if($dm_field == 'y')
			{
				return 'dark';
			}
			else
			{
				return 'light';
			}
		}
		return 'light';
		
	}
	
	public function show_switch_darkmode()
	{
		$btnmode = '';
		if(isloggedin() && !isguestuser())
		{
			//$btnmode .=  '<div class="divider border-left h-75 align-self-center ml-1 mr-1"></div>';
			
			$btnmode .=  '<div id="switchdarkmode" class="d-flex switchmode">';
			$btnmode .=  '<div class="switchmodeicon';
			if($this->getdarkmode() == 'dark')
			{
				$btnmode .=  ' checked ';
			}
			$btnmode .=  '" title="'.get_string('darkmodeswitch', 'theme_clhes').'" data-darkmode="'.$this->getdarkmode().'">';
			$btnmode .=  '<div class="smon fontoswald">on</div>';
			$btnmode .=  '<div class="smicon">';
			$btnmode .=  '<svg aria-hidden="true" focusable="false"  role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="16" class="icon-moon"><circle class="moonfond" cx="50" cy="50" r="44"/><path d="M50,1C22.9,1,1,22.9,1,50s21.9,49,49,49s49-21.9,49-49S77.1,1,50,1z M70.7,45.5c0,0-1-0.9-1.1-1c-0.2,0-1.4,0.3-1.4,0.3 s0.9-0.9,1-1.1c0-0.2-0.3-1.4-0.3-1.4s0.9,0.9,1.1,1c0.2,0.1,1.4-0.3,1.4-0.3s-1,0.9-1,1.1S70.7,45.5,70.7,45.5z M63,26.5 c0.5-0.6,1.5-4.5,1.5-4.5s1.1,4,1.5,4.5c0.4,0.5,4.5,1.5,4.5,1.5s-4.1,1-4.5,1.5C65.7,30,64.5,34,64.5,34s-1.1-4.1-1.5-4.5 c-0.4-0.3-4.5-1.5-4.5-1.5S62.5,27.1,63,26.5z M50.6,35.3c0.3-0.1,1.8-1.3,1.8-1.3s-0.6,1.8-0.6,2.1c0,0.3,1.3,1.8,1.3,1.8s-1.9-0.7-2.1-0.6s-1.8,1.3-1.8,1.3s0.7-1.9,0.6-2.1s-1.3-1.8-1.3-1.8S50.3,35.4,50.6,35.3z M50,88c-21,0-38-17-38-38 c0-17.2,11.5-31.7,27.1-36.4c-6.1,6.7-9.8,15.6-9.8,25.4c0,21,17,38,38,38c3.8,0,7.4-0.6,10.9-1.6C71.3,83.1,61.2,88,50,88z"/></svg>';
			$btnmode .=  '</div>';
			$btnmode .=  '<div class="smoff fontoswald">off</div>';
			$btnmode .=  '</div>';
			$btnmode .=  '<div class="switchmodetxt fontoswald">'.get_string('darkmodel1', 'theme_clhes').'<br>'.get_string('darkmodel2', 'theme_clhes').'</div>';
			$btnmode .=  '</div>';
			
		}
		else
		{
			$btnmode = '';
		}
		return $btnmode;
	}
	
	
	public function helpdeskFooter() 
	{
		$bhdtel = $this->page->theme->settings->helpdesktel;
		$bhdhoraire = $this->page->theme->settings->helpdeskhoraire;
		$bhdemail = $this->page->theme->settings->helpdeskemail;

		if($bhdtel != null && $bhdemail != null )
		{
			
			
			$htmlBHd = '<div id="helpdesk_footer">';
			$htmlBHd .= '<div class="contact">';

				$htmlBHd .= '<i class="fa fa-phone" aria-hidden="true"></i>'.$bhdtel;
				if($bhdhoraire != null )
				{
					$htmlBHd .= '<span id="support_hours">'.$bhdhoraire.'</span>';
				}
										
				$htmlBHd .= '<div id="footer-email"><i class="fa fa-envelope-o" aria-hidden="true"></i>
								<a class="" href="mailto:'.$bhdemail.'">'.$bhdemail.'</a>';
				$htmlBHd .= '</div>';

			$htmlBHd .= '</div>';
			$htmlBHd .= '</div>';
			
			
			$htmlBHd = '<div class="footer_mail">';
				$htmlBHd .= '<a class="" href="mailto:'.$bhdemail.'">'.$bhdemail.'</a>';
			$htmlBHd .= '</div>';
			
			$htmlBHd .= '<div class="footer_phone">';
				$htmlBHd .= $bhdtel;
				if($bhdhoraire != null )
				{
					$htmlBHd .= '<span class="support_hours">'.$bhdhoraire.'</span>';
				}
			$htmlBHd .= '</div>';	
			
			return $htmlBHd;
	
		}
		else
		{
			return null;
		}	
	}
	
	
	public function get_frontpage_slider() 
	{
		$noslides = $this->page->theme->settings->slidercount;
		$retval = '';
		
		// Will we have any slides?
        $haveslides = false;
		$slidesContent = '';
		$slidelist = [];

		for ($i = 1; $i <= $noslides; $i++) {
            $sliderimage = 'sld' . $i;
            $sliderorder = 'order' . $i;
            $sliderorder = $this->page->theme->settings->$sliderorder-1;
            if ($sliderorder > 0 && !empty($this->page->theme->settings->$sliderimage)) {
                $haveslides = true;
				$hascap = false;
				$sliderimagedark = 'sld' . $i . 'dark';
				$sliderurl = 'sld' . $i . 'url';
				$slidertitle = 'sld' . $i .'title';
				$slidercaption = 'sld' . $i .'cap';
				$slidercaptionmob = 'sld' . $i .'capmob';
				$closelink = '';
				$sldtitle = '';
				$sldcap = '';
				$sldcapmob = '';
				
				$sldc = '<li>';
				
				if (!empty($this->page->theme->settings->$sliderurl)) {
                    $sldc .= '<a href="' . $this->page->theme->settings->$sliderurl . '">';
                    $closelink = '</a>';
                }
				
				$sldimg = $this->page->theme->setting_file_url($sliderimage, $sliderimage);
				$sldc .= '<img class="slideimg " src="' . $sldimg . '" alt="' . $sliderimage . '"/>';
				
				//darkmode image
				if(!empty($this->page->theme->settings->$sliderimagedark))
				{
					$sldimg = $this->page->theme->setting_file_url($sliderimagedark, $sliderimagedark);
				}
				$sldc .= '<img class="slideimg dark" src="' . $sldimg . '" alt="' . $sliderimage . '"/>';
				
				
				if (!empty($this->page->theme->settings->$slidertitle)) {
					$sldtitle = '<h3 class="caption-title">' . $this->get_setting($slidertitle, 'FORMAT_PLAIN') . '</h3>';
					$hascap = true;
				}
				if (!empty($this->page->theme->settings->$slidercaption)) {
                    $sldcap = '<div class="caption-content">' . $this->get_setting($slidercaption, 'format_html') . '</div>';
					$hascap = true;
				}
				if (!empty($this->page->theme->settings->$slidercaptionmob)) {
                    $sldcapmob = '<div class="caption-content-mob">' . $this->get_setting($slidercaptionmob, 'format_html') . '</div>';
					$hascap = true;
				}
				
				if($hascap)
				{
					$sldc .= '<div class="flex-caption">';
					$sldc .= $sldtitle;
					$sldc .= $sldcap;
					$sldc .= $sldcapmob;
					$sldc .= '</div>';
				}

                $sldc .= $closelink . '</li>';
				$sld = [];
				$sld['order'] = $sliderorder;
				$sld['content'] = $sldc;
				$slidelist[] = $sld;
            }
        }
		asort($slidelist);
		
		foreach($slidelist as $slideobj)
		{
			
			$slidesContent .= $slideobj['content'];
		}
		
		if (!$haveslides) {
            return '';
        }
		
		$retval .= '
		<div class="container slidewrap d-lg-block">
            <div id="main-slider" class="flexslider">
				<ul class="slides">';
		$retval .= $slidesContent;
		$retval .= '</ul></div></div>';
		
		return $retval;
	}
	
	/**
     * Returns settings as formatted text
     *
     * @param string $setting
     * @param string $format = false
     * @param string $theme = null
     * @return string
     */
    public function get_setting($setting, $format = false, $theme = null) {
        static $themeconfig = null;
        if (empty($theme)) {
            if (empty($themeconfig)) {
                $themeconfig = \theme_config::load('argil');
            }
            $theme = $themeconfig;
        }

        if (empty($theme->settings->$setting)) {
            return false;
        } else if (!$format) {
            return $theme->settings->$setting;
        } else if ($format === 'format_text') {
            return format_text($theme->settings->$setting, FORMAT_PLAIN);
        } else if ($format === 'format_moodle') {
            return format_text($theme->settings->$setting, FORMAT_MOODLE);
        } else if ($format === 'format_html') {
            return format_text($theme->settings->$setting, FORMAT_HTML);
        } else {
            return format_string($theme->settings->$setting);
        }
    }
	

	public function get_faq_cat($cid = 0,$tid = 0) 
	{
		global $DB, $PAGE;
		$faq = [];
		$list = [];
		$nbfcatshow = 0;
		$tmplate = 'obj_faqlist';
		$faq['faq_name'] = 'faq_c';
		$faq['faq_type'] = 'c';
		$faq['faq_url'] = new moodle_url('?redirect=0&amp;op=support');
		
		$c_lang = current_language();

		$editingmode= false;
		if(is_siteadmin() && $PAGE->user_is_editing())
		{
			$editingmode= true;
			$tmplate = 'obj_faqlist_edit';
		}

		$content = '';

		if($faqcat = $DB->get_records('theme_argil_faq_cat', [], 'position') )
		{
			$nbfcat = count($faqcat);
			$nbfcatshow = 0;
			$index = 1;
			$currantvisible = 0;
			
			foreach($faqcat as $item)
			{
				$tmp = [];
				$itemname = $item->name_fr;
				switch ($c_lang)
				{
					case 'en':
						$itemname = $item->name_en;
						break;
					case 'de':
						$itemname = $item->name_de;
						break;
				}
				
				if($cid == $item->id)
				{
					$tmp['select'] = true;
					$currantvisible = $item->visible;
				}
				
				$tmp['data'] = ' data-faq_c="'.$item->id.'" ';
				$tmp['id'] = $item->id;
				if($item->icon !== null && $item->icon != '')
				{
					//print_r('<br>icon not null<br>');
					$tmp['icon'] = $item->icon;
				}
				else
				{
					$tmp['icon'] = '<svg class="fc_icon_question" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="30"><path class="color" d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/></svg>';
				}

				
				$tmp['txt'] = format_text($itemname, FORMAT_PLAIN);
				$tmp['order'] = $item->position;
				$tmp['question'] = '';
				$tmp['answer'] = '';
					
				if($editingmode)
				{
					$tmp['url'] = new moodle_url('?redirect=0&amp;op=support&amp;cat='.$item->id.'');
					if($item->visible == 1)
					{
						$tmp['visible'] = 'show';
					}
					else
					{
						$tmp['visible'] = '';
					}
					
					
					if($index == 1)
					{
						$tmp['up'] = '';
					}
					else if($index > 1)
					{
						$tmp['up'] = 'up';
					}
					if($index < $nbfcat)
					{
						$tmp['down'] = 'down';
					}
					else if($index == $nbfcat)
					{
						$tmp['down'] = '';
					}

					
					
					$faq['list'][] = $tmp;
					$index++;
					$nbfcatshow++;
				}
				else if($item->visible)
				{
					$faq['list'][] = $tmp;
					$nbfcatshow++;
				}
				
			}
			$faq['nbr'] = $nbfcatshow;
			

			$subject = '';
			if($cid > 0)
			{
				if($editingmode || $currantvisible)
				{
					$subject .= $this->get_faq_questions_ajax($cid, $tid) ;
				}		
			}

			
			$faq['subject'] = $subject;
		}
		else
		{
			$faq['emptymsg'] = get_string('nofaq', 'theme_argil');
		}
		
		if(!$editingmode && $nbfcatshow ==0)
		{
			return '';
		}
		
		$content = $this->render_from_template('theme_argil/'.$tmplate, $faq);
		return $content;
	}
	
	public function get_faq_questions_ajax($cid, $tid=0) 
	{
		global $DB, $CFG, $PAGE;
		$faq = [];
		$list = [];
		$tmplate = 'obj_faqlist';
		$c_lang = current_language();
		
		$editingmode= false;
		if(is_siteadmin() && $PAGE->user_is_editing())
		{
			$editingmode= true;
			$tmplate = 'obj_faqlist_edit';
		}

		
		$p_icon = $DB->get_field('theme_argil_faq_cat', 'icon', array('id' => $cid));

		if($p_icon == null || $p_icon == '')
		{
			$p_icon = '<svg class="fc_icon_question" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="30"><path class="color" d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/></svg>';
		}

		
		$content = '';
		$nbrquestionshow = 0;
		$faq['faq_name'] = 'faq_q';
		$faq['faq_type'] = 'q';
		$faq['faq_cid'] = $cid;
		$faq['faq_url'] = new moodle_url('?redirect=0&amp;op=support&amp;cat='.$cid);
		
		
		if($faqs = $DB->get_records('theme_argil_faq', array('catid'=>$cid), 'position') )
		{
			$nbfaq = count($faqs);
			$index = 1;

				
			foreach($faqs as $item)
			{
				$tmp = [];
				$itemname = $item->name_fr;
				$itemquestion = $item->question_fr;
				$itemanswer = $item->answer_fr;
				switch ($c_lang)
				{
					case 'en':
						$itemname = $item->name_en;
						$itemquestion = $item->question_en;
						$itemanswer = $item->answer_en;
						break;
					case 'de':
						$itemname = $item->name_de;
						$itemquestion = $item->question_de;
						$itemanswer = $item->answer_de;
						break;
				}
				
				
				$tmp['data'] = 'data-faq_c="'.$cid.'" data-faq_q="'.$item->id.'"';
				$tmp['cat'] = $item->catid;
				
				if($tid == $item->id)
				{
					$tmp['select'] = true;
				}
				
				$tmp['id'] = $item->id;
				$tmp['txt'] = format_text($itemname, FORMAT_PLAIN);
				$tmp['question'] = format_text($itemquestion, FORMAT_PLAIN);
				$tmp['answer'] = $itemanswer;
				$tmp['order'] = $item->position;
				
				if($item->icon !== null && $item->icon != '')
				{
					$tmp['icon'] = $item->icon;
				}
				else
				{
					$tmp['icon'] = $p_icon;
				}
				
				
				if($editingmode)
				{
					
					$tmp['url'] = new moodle_url('?redirect=0&amp;op=support&amp;cat='.$item->catid.'&amp;topic='.$item->id.'');
					
					if($item->visible == 1)
					{
						$tmp['visible'] = 'show';
					}
					else
					{
						$tmp['visible'] = '';
					}

					if($index == 1)
					{
						$tmp['up'] = '';
					}
					else if($index > 1)
					{
						$tmp['up'] = 'up';
					}
					if($index < $nbfaq)
					{
						$tmp['down'] = 'down';
					}
					else if($index == $nbfaq)
					{
						$tmp['down'] = '';
					}

					$faq['list'][] = $tmp;
					$index++;
					$nbrquestionshow++;
				}
				else if($item->visible)
				{

					
					$faq['list'][] = $tmp;
					$nbrquestionshow++;
				}
			}
		}

		
		if($nbrquestionshow < 1)
		{
			$faq['emptymsg'] = get_string('nofaqtopic', 'theme_argil');
		}
		$faq['nbr'] = $nbrquestionshow;
		$faq['isquestion'] = 1;

		$content = $this->render_from_template('theme_argil/'.$tmplate, $faq);
		return $content;
	}
	
	
	public function set_faq_field($table, $id, $champ, $value) 
	{
		global $DB;
		$record = new stdClass();
        $record->id = $id;
        $record->$champ = $value;
       
        return $DB->update_record($table, $record);	
	}
	
	
	public function set_faq_position($type, $cid, $tid=0, $up=0) 
	{
		global $DB;
		
		
		$table = 'theme_argil_faq_cat';
		$cond = [];
		$currantid = $cid; 
		if($cid <= 0)
		{
			return 'Parameter error! ';
		}
		
		if($type == 'topic')
		{
			if($cid > 0 && $tid > 0)
			{
				$table = 'theme_argil_faq';
				$cond = array('catid'=>$cid);
				$currantid = $tid; 
			}
			else
			{
				return 'Parameter error! ';
			}
		}
		/*
		print_r('$type: '.$type.'<br>');
		print_r('$table: '.$table.'<br>');
		print_r('$cid: '.$cid.'<br>');
		print_r('$tid: '.$tid.'<br>');
		*/
		$this->init_faq_position($table, $cond);
		
		
		
		
		
		if($faqs = $DB->get_records($table, $cond, 'position') )
		{
			$nbr = count($faqs);
			if (!array_key_exists($currantid, $faqs) || $nbr < 2) 
			{
				return '';
			}
			$position = $faqs[$currantid]->position; 
			
			if($up)
			{
				$newposition = $position-1;
			}
			else
			{
				$newposition = $position+1;
			}
			
			if ($newposition < 0 || $newposition >= $nbr) 
			{
				return '';
			}

				
			
			
			foreach($faqs as $item)
			{
				//print_object($item);
				if($item->position == $newposition)
				{
					$this->set_faq_field($table, $item->id, 'position', $position);
				}
			}
			$this->set_faq_field($table, $currantid, 'position', $newposition);
		}
		
		
	}
	
	public function init_faq_position($table, $cond=[]) 
	{
		global $DB;
		
		$index = 0;

		if($faqs = $DB->get_records($table, $cond, 'position') )
		{
			foreach($faqs as $item)
			{
				$this->set_faq_field($table, $item->id, 'position', $index++);
			}
		}
	}
	public function get_faq_last_position($table, $idc = 0) 
	{
		global $DB;
		
		$rowSQL = '';
		//$pos = 0;
		if($idc == 0)
		{
			$rowSQL = 'SELECT MAX( position ) as max ' .
                'FROM {'.$table.'} ';
			$params = [];
		}
		else
		{
			$rowSQL = 'SELECT MAX( position ) as max ' .
                'FROM {'.$table.'} ';
			$params['catid'] = $idc;	
		}
		/*
		print_r($rowSQL);
		print_object($params);
		$aaa = $DB->get_record_sql($rowSQL, $params);
		print_object($aaa);
		*/
		if($pos = $DB->get_record_sql($rowSQL, $params))
		{
			if($pos->max > 0)
			{
				return $pos->max;
			}	
			
		}

		return 0;
	}
	
	public function get_faq($type, $id) 
	{
		global $DB;
		$table = 'theme_argil_faq_cat';
		$cond = array('id'=>$id);
		$resultat = [];
		
		if($type == 'topic')
		{
			$table = 'theme_argil_faq';	
		}
		
		if($faq = $DB->get_record($table, $cond) )
		{
			//print_object($faq);
			return (array)$faq;
		}
		
	}
	
	
	public function set_faq($type, $faqdata) 
	{
		global $DB;

		$table = 'theme_clhes_faq_cat';
		$faq_idc = $faqdata->catid;
		if($type == 'topic')
		{
			$table = 'theme_clhes_faq';
			$faqdata->answer_fr = $faqdata->answer_fr['text'];
			$faqdata->answer_en = $faqdata->answer_en['text'];
			$faqdata->answer_de = $faqdata->answer_de['text'];
		}
		
		$faqdata->name_fr = format_text($faqdata->name_fr, FORMAT_PLAIN);
		$faqdata->name_de = format_text($faqdata->name_de, FORMAT_PLAIN);
		$faqdata->name_en = format_text($faqdata->name_en, FORMAT_PLAIN);

		
		if(!isset($faqdata->visible))
		{
			$faqdata->visible = 0;
		}
		
		if(isset($faqdata->id))
		{
			$DB->update_record($table, $faqdata);
			return $faqdata->id;
		}
		else
		{
			$newpos = $this->get_faq_last_position($table, $faq_idc)+1;
			$faqdata->position = $newpos;
			return $DB->insert_record($table, $faqdata);
		}	
		
		return '';
	}
	

	public function del_faq($type, $cid, $tid=0 ) 
	{
		global $DB;
		
		$del = false;
		$delchild = false;
		
		$table = 'theme_argil_faq_cat';
		$cond = array('id'=>$cid);
		$condChild = array('catid'=>$cid);
		if($type == 'topic')
		{
			$table = 'theme_argil_faq';
			$cond = array('id'=>$tid);
		}
		else
		{
			$delchild = $DB->delete_records('theme_argil_faq', $condChild);
			if(!$delchild )
			{
				return 'cant delete child';
			}
		}
		
		$del = $DB->delete_records($table, $cond);
		if(!$delchild )
		{
			return 'cant delete rubric';
		}
	}
	
	
	
	protected function render_thiscourse_menu(custom_menu $menu) {
        global $CFG;

        $content = '';
        foreach ($menu->get_children() as $item) {
            $context = $item->export_for_template($this);
            $content .= $this->render_from_template('theme_argil/activitygroups', $context);
        }

        return $content;
    }

	public function thiscourse_menu() {
        global $PAGE, $COURSE, $OUTPUT, $CFG;
        $menu = new custom_menu();
        $context = $this->page->context;
        
		if (isset($COURSE->id) && $COURSE->id > 1) {
			$branchtitle = get_string('thiscourse', 'theme_argil');
			$branchlabel = $branchtitle;
			$branchurl = new moodle_url('#');
			$branch = $menu->add($branchlabel, $branchurl, $branchtitle, 10002);

			$data = theme_argil_get_course_activities();

			foreach ($data as $modname => $modfullname) {
				if ($modname === 'resources') {
					
					$branch->add($modfullname, new moodle_url('/course/resources.php', array('id' => $PAGE->course->id)));
				} else {

					$branch->add($modfullname, new moodle_url('/mod/'.$modname.'/index.php',
							array('id' => $PAGE->course->id)));
				}
			}
                
        }

        return $this->render_thiscourse_menu($menu);
    }
	
	public function teacherdash() {
        global $PAGE, $COURSE, $USER, $CFG, $DB, $OUTPUT;


        require_once($CFG->dirroot.'/completion/classes/progress.php');
        $togglebutton = '';
        $hasteacherdash = '';
        $hasstudentdash = '';
		
		$showincourseonly = isset($COURSE->id) && ($PAGE->pagelayout == 'course' || $PAGE->pagelayout == 'incourse') && isloggedin() && !isguestuser(); 
		$dashlinks = ['showincourseonly' =>$showincourseonly];
		$course = $this->page->course;
        $context = context_course::instance($course->id);
		
		if ($showincourseonly) 
		{
			if (has_capability('moodle/course:viewhiddenactivities', $context)) 
			{
				$hasteacherdash = true;
				$hasstudentdash = false;
				$togglebutton = get_string('coursemanagementbutton', 'theme_argil');
			}
			else
			{
				$hasteacherdash = false;
				$hasstudentdash = true;
				$togglebutton = get_string('studentdashbutton', 'theme_argil');
				if(!is_enrolled($context))
				{
					$hasstudentdash = false;
					return $this->render_from_template('theme_argil/teacherdash', $dashlinks );
				}
			}
        }
		else
		{
			return $this->render_from_template('theme_argil/teacherdash', $dashlinks );
		}


        
        
        $thiscourse = $this->thiscourse_menu();
       

        
        //link catagories
        $haspermission = has_capability('enrol/category:config', $context) && isset($COURSE->id) && $COURSE->id > 1;
        $userlinks = get_string('userlinks', 'theme_argil');
        $userlinksdesc = get_string('userlinks_desc', 'theme_argil');
        $qbank = get_string('qbank', 'theme_argil');
        $qbankdesc = get_string('qbank_desc', 'theme_argil');
        $badges = get_string('badges', 'theme_argil');
        $badgesdesc = get_string('badges_desc', 'theme_argil');
        $coursemanage = get_string('coursemanage', 'theme_argil');
        $coursemanagedesc = get_string('coursemanage_desc', 'theme_argil');

        //user links
        
        $gradestitle = get_string('gradesoverview', 'gradereport_overview');
        $gradeslink = new moodle_url('/grade/report/grader/index.php', array('id' => $PAGE->course->id));
        $enroltitle = get_string('enrolledusers', 'enrol');
        $enrollink = new moodle_url('/user/index.php', array('id' => $PAGE->course->id));
        $grouptitle = get_string('groups', 'group');
        $grouplink = new moodle_url('/group/index.php', array('id' => $PAGE->course->id));
        $enrolmethodtitle = get_string('enrolmentinstances', 'enrol');
        $enrolmethodlink = new moodle_url('/enrol/instances.php', array('id' => $PAGE->course->id));
        
        //user reports
        $logstitle = get_string('logs', 'moodle');
        $logslink = new moodle_url('/report/log/index.php', array('id' => $PAGE->course->id));
        $livelogstitle = get_string('loglive:view', 'report_loglive');
        $livelogslink = new moodle_url('/report/loglive/index.php', array('id' => $PAGE->course->id));
        $participationtitle = get_string('participation:view', 'report_participation');
        $participationlink = new moodle_url('/report/participation/index.php', array('id' => $PAGE->course->id));

        //questionbank
        $qbanktitle = get_string('questionbank', 'question');
        $qbanklink = new moodle_url('/question/edit.php', array('courseid' => $PAGE->course->id));
        $qcattitle = get_string('questioncategory', 'question');
        $qcatlink = new moodle_url('/question/bank/managecategories/category.php', array('courseid' => $PAGE->course->id));
		$qimporttitle = get_string('import', 'question');
        $qimportlink = new moodle_url('/question/bank/importquestions/import.php', array('courseid' => $PAGE->course->id));
		$qexporttitle = get_string('export', 'question');
		$qexportlink = new moodle_url('/question/bank/exportquestions/export.php', array('courseid' => $PAGE->course->id));
        
        //manage course
        $courseadmintitle = get_string('courseadministration', 'moodle');
        $courseadminlink = new moodle_url('/course/admin.php', array('courseid' => $PAGE->course->id));
        $coursecompletiontitle = get_string('coursecompletion', 'moodle');
        $coursecompletionlink = new moodle_url('/course/completion.php', array('id' => $PAGE->course->id));
        $courseresettitle = get_string('reset', 'moodle');
        $courseresetlink = new moodle_url('/course/reset.php', array('id' => $PAGE->course->id));
        $coursebackuptitle = get_string('backup', 'moodle');
        $coursebackuplink = new moodle_url('/backup/backup.php', array('id' => $PAGE->course->id));
        $courserestorelink = new moodle_url('/backup/restorefile.php', array('contextid' => $PAGE->context->id));
        $courseimporttitle = get_string('import', 'moodle');
        $courseimportlink = new moodle_url('/backup/import.php', array('id' => $PAGE->course->id));
        $courseedittitle = get_string('editcoursesettings', 'moodle');
        $courseeditlink = new moodle_url('/course/edit.php', array('id' => $PAGE->course->id));
        
        //badges
        $badgemanagetitle = get_string('managebadges', 'badges');
        $badgemanagelink = new moodle_url('/badges/index.php?type=2', array('id' => $PAGE->course->id));
        $badgeaddtitle = get_string('newbadge', 'badges');
        $badgeaddlink = new moodle_url('/badges/newbadge.php?type=2', array('id' => $PAGE->course->id));
        
        //misc
        $recyclebintitle = get_string('pluginname', 'tool_recyclebin');
        $recyclebinlink = new moodle_url('/admin/tool/recyclebin/index.php', array('contextid' => $PAGE->context->id));


        //Student Dash
            if (\core_completion\progress::get_course_progress_percentage($PAGE->course)) {
                $comppc = \core_completion\progress::get_course_progress_percentage($PAGE->course);
                $comppercent = number_format($comppc, 0);
                $hasprogress = true;
            } else {
                $comppercent = 0;
                $hasprogress = false;
            }
			
			$coursecontext = context_course::instance($COURSE->id);
			$instances = enrol_get_instances($course->id, true);
			$plugins   = enrol_get_plugins(true);
			$btnunenroltitle = '';
			$btnunenrollink = '';
			$btnunenrolicon = '';

			foreach ($instances as $instance) 
			{
				if (!isset($plugins[$instance->enrol])) {
					continue;
				}
				$plugin = $plugins[$instance->enrol];
				if ($unenrollink = $plugin->get_unenrolself_link($instance)) 
				{
					$btnunenroltitle = get_string('unenrolme', 'core_enrol', get_string('studentdashbutton', 'theme_argil'));
					$btnunenrollink = $unenrollink;
					$btnunenrolicon = '<i class="fas fa-user"></i>';
				}
			}					
			//}
			
			$progresschartcontext = ['progress' => $comppercent];
			$progresschart = $this->render_from_template('theme_argil/progress-bar', $progresschartcontext);
			
			
			
            $gradeslink = new moodle_url('/grade/report/user/index.php', array('id' => $PAGE->course->id));
            

            $hascourseinfogroup = array (
                'title' => get_string('courseinfo', 'theme_argil'),
                'icon' => 'map'
            );
            $summary = theme_argil_strip_html_tags($COURSE->summary);
            $summarytrim = theme_argil_course_trim_char($summary, 300);
            $courseinfo = array (
                array(
                    'content' => format_text($summarytrim),
                )
            );
            $hascoursestaff = array (
                'title' => get_string('coursestaff', 'theme_argil'),
                'icon' => 'users'
            );
			
			$courseteachers = array();
			$user_capability = 'moodle/course:viewhiddenactivities';
			$context = context_course::instance($PAGE->course->id);
			$teachers = get_users_by_capability($context, 'moodle/course:viewhiddenactivities', 
				'u.id, u.firstname, u.middlename, u.lastname, u.alternatename,
                u.firstnamephonetic, u.lastnamephonetic, u.email, u.picture,
                u.imagealt, u.deleted, u.suspended');
			
			foreach ($teachers as $staff) {
				if(!$staff->deleted && !$staff->suspended)
				{
					$picture = $OUTPUT->user_picture($staff, array('size' => 40));
					$messaging = new moodle_url('/message/index.php', array('id' => $staff->id));
					$hasmessaging = $CFG->messaging==1;
					$courseteachers[] = array (
						'name' => $staff->firstname . ' ' . $staff->lastname . ' ' . $staff->alternatename,
						'email' => $staff->email,
						'picture' => $picture,
						'messaging' => $messaging,
						'hasmessaging' => $hasmessaging
					);
				}
            }			


            $activitylinkstitle = get_string('activitylinkstitle', 'theme_argil');

            $mygradestext = get_string('mygradestext', 'theme_argil');
            $myprogresstext = get_string('myprogresstext', 'theme_argil');
            $studentcoursemanage = get_string('courseadministration', 'moodle');

            //permissionchecks for teacher access
            $hasquestionpermission = has_capability('moodle/question:add', $context);
            $hasbadgepermission = has_capability('moodle/badges:awardbadge', $context);
            $hascoursepermission = has_capability('moodle/backup:backupcourse', $context);
            $hasuserpermission = has_capability('moodle/course:viewhiddenactivities', $context);
            $hasgradebookshow = $PAGE->course->showgrades == 1;
            $hascompletionshow = $PAGE->course->enablecompletion == 1;
        
		$btnMoretitle = get_string('morenavigationlinks');
		$btnMorelink = new moodle_url('/course/admin.php', array('courseid' => $PAGE->course->id));    


        //send to template
        $dashlinks = [
        'showincourseonly' =>$showincourseonly,
        'thiscourse' => $thiscourse,
        'togglebutton' => $togglebutton,
        'userlinkstitle' => $userlinks,
        'userlinksdesc' => $userlinksdesc,
        'qbanktitle' => $qbank,
        'activitylinkstitle' => $activitylinkstitle,
        'qbankdesc' => $qbankdesc,
        'badgestitle' => $badges,
        'badgesdesc' => $badgesdesc,
        'coursemanagetitle' => $coursemanage,
        'coursemanagedesc' => $coursemanagedesc,
        'progresschart' => $progresschart,
        'gradeslink' => $gradeslink,
        'hascourseinfogroup' => $hascourseinfogroup,
        'courseinfo' => $courseinfo,
        'hascoursestaffgroup' => $hascoursestaff,
        'courseteachers' => $courseteachers,
        'myprogresstext' => $myprogresstext,
        'mygradestext' => $mygradestext,
        'hasteacherdash' => $hasteacherdash,
        'teacherdash' =>array('hasquestionpermission' => $hasquestionpermission, 'hasbadgepermission' => $hasbadgepermission, 'hascoursepermission' => $hascoursepermission, 'hasuserpermission' => $hasuserpermission),
        'hasstudentdash' => $hasstudentdash,
        'hasgradebookshow' => $hasgradebookshow,
        'hascompletionshow' => $hascompletionshow,
		'btnunenrol' => array(
					'btnunenroltitle' => $btnunenroltitle,		
					'btnunenrollink' => $btnunenrollink,		
					'btnunenrolicon' => $btnunenrolicon,		
		
		),				

        'dashlinks' => array(
                array('hasuserlinks' => $gradestitle, 'title' => $gradestitle, 'url' => $gradeslink),
                array('hasuserlinks' => $enroltitle, 'title' => $enroltitle, 'url' => $enrollink),
                array('hasuserlinks' => $grouptitle, 'title' => $grouptitle, 'url' => $grouplink),
                array('hasuserlinks' => $enrolmethodtitle, 'title' => $enrolmethodtitle, 'url' => $enrolmethodlink),
                array('hasuserlinks' => $logstitle, 'title' => $logstitle, 'url' => $logslink),
                array('hasuserlinks' => $livelogstitle, 'title' => $livelogstitle, 'url' => $livelogslink),
                array('hasuserlinks' => $participationtitle, 'title' => $participationtitle, 'url' => $participationlink),
                array('hasqbanklinks' => $qbanktitle, 'title' => $qbanktitle, 'url' => $qbanklink),
                array('hasqbanklinks' => $qcattitle, 'title' => $qcattitle, 'url' => $qcatlink),
                array('hasqbanklinks' => $qimporttitle, 'title' => $qimporttitle, 'url' => $qimportlink),
                array('hasqbanklinks' => $qexporttitle, 'title' => $qexporttitle, 'url' => $qexportlink),
                array('hascoursemanagelinks' => $courseedittitle, 'title' => $courseedittitle, 'url' => $courseeditlink),
                array('hascoursemanagelinks' => $coursecompletiontitle, 'title' => $coursecompletiontitle, 'url' => $coursecompletionlink),
                array('hascoursemanagelinks' => $courseadmintitle, 'title' => $courseadmintitle, 'url' => $courseadminlink),
                array('hascoursemanagelinks' => $courseresettitle, 'title' => $courseresettitle, 'url' => $courseresetlink),
                array('hascoursemanagelinks' => $coursebackuptitle, 'title' => $coursebackuptitle, 'url' => $coursebackuplink),
                array('hascoursemanagelinks' => $courseimporttitle, 'title' => $courseimporttitle, 'url' => $courseimportlink),
                array('hascoursemanagelinks' => $recyclebintitle, 'title' => $recyclebintitle, 'url' => $recyclebinlink),
                array('hasbadgelinks' => $badgemanagetitle, 'title' => $badgemanagetitle, 'url' => $badgemanagelink),
                array('hasbadgelinks' => $badgeaddtitle, 'title' => $badgeaddtitle, 'url' => $badgeaddlink),
				array('hascoursemanagemorelinks' => $btnMoretitle, 'title' => $btnMoretitle, 'url' => $btnMorelink),
            ),
        ];


        return $this->render_from_template('theme_argil/teacherdash', $dashlinks );
        
    }
	
	
	public function gestion_course() 
	{
        global $PAGE;
		
		$showgeationcoursebtn = false;

		$createurl = ''.$PAGE->theme->settings->createcourseurl;
		$restoreurl = ''.$PAGE->theme->settings->restorecourseurl;
		
		if(strlen($createurl) > 4 || strlen($restoreurl) > 4 )
		{
			$showgeationcoursebtn = true;
		}
			
		$gclinks = [
        'showgeationcoursebtn' =>$showgeationcoursebtn,
        'createurl' => $createurl,
        'restoreurl' => $restoreurl,
        'togglebutton' => get_string('coursegestion', 'theme_argil')
		];
		return $this->render_from_template('theme_argil/obj_gestion_course', $gclinks );
	}
	
	public function search_box_top() {
		global $PAGE, $CFG;

		if($PAGE->pagetype == 'mod-moodecgrpmanagement-mod')
		{
			return '';
		}
		$action = new moodle_url('/course/search.php');

		$data = [
		'action' => $action,
		'hiddenfields' => '',
		'inputname' => 'q',
		'searchstring' => get_string('searchcourse','theme_argil'),
		];
		return $this->render_from_template('core/search_input', $data);

	}
	
	
	protected function checkStatut($isteacher) 
	{
		global $DB, $USER;
		$condition = '';
		$roleteacher="'manager', 'coursecreator', 'editingteacher', 'teacher'";
		$rolestudent="'student'";


		if($isteacher){
			$condition = '  archetype IN ('.$roleteacher.') ';
		}
		else{
			$condition = '  archetype = '.$rolestudent.' ';
		}
		
		$sql = 'SELECT count(raid) FROM 
			((select id as raid, roleid from `mdl_role_assignments` ra where userid = '.$USER->id.') ras LEFT JOIN `mdl_role` r ON r.id = ras.roleid)
			where '.$condition.' ';
		$result = $DB->count_records_sql($sql);

		//print_r($result);
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function get_hesnews() {
		global $DB, $USER;
		$content = '';
		$isProf = false;
		$isStud = false;
		
		$isteacher = true;
		$isProf = $this->checkStatut($isteacher);
		$isStud = $this->checkStatut(!$isteacher);

		$newsdata = [];
		$totaldisplay = 0;
		if($newstmp = $this->get_hesnews_data('all'))
		{
			$newsdata['news'][] = $newstmp;
			if($newstmp->display)
				$totaldisplay++;
		}

		if($isProf)
		{
			if($newstmp = $this->get_hesnews_data('teacher'))
			{
					$newsdata['news'][] = $newstmp;
					if($newstmp->display)
						$totaldisplay++;
			}
		}
		if($isStud)
		{
			if($newstmp = $this->get_hesnews_data('student'))
			{
					$newsdata['news'][] = $newstmp;
					if($newstmp->display)
						$totaldisplay++;
			}
		}
		
		

		$newsdata['total'] =  $totaldisplay;
		
		//print_object($newsdata);
		return $this->render_from_template('theme_argil/obj_hesnews', $newsdata);
	}
	
	public function get_hesnews_data($type) {
		global $DB;
		
		if($news = $DB->get_record('theme_argil_news', array('type' => $type)))
		{
			//!is_null  !== null
			if($news->name !== null && $news->content !== null )
			{
				if(strlen($news->name) > 5 && strlen($news->content) > 5 )
				{
					return $news;
				}
			}
			
		}
		return '';
	}
	
	public function set_hesnews($news) {
		global $DB;
		$table = "theme_argil_news";
		$newsrecord = new \stdClass();
		
		$news_all_name = $news->news_all_name;
		$news_all_content = $news->news_all_content['text'];
		
		$news_t_name = $news->news_teacher_name;
		$news_t_content = $news->news_teacher_content['text'];
		
		$news_s_name = $news->news_student_name;
		$news_s_content = $news->news_student_content['text'];
		
		$news_all_display = 0;
		$news_s_display = 0;
		$news_t_display = 0;
		if(isset($news->news_all_display))
			$news_all_display = 1;
		if(isset($news->news_teacher_display))
			$news_t_display = 1;		
		if(isset($news->news_student_display))
			$news_s_display = 1;


		if(strlen($news_all_name) > 1 && strlen($news_all_content) > 1 )
		{
			if($newid1 = $DB->get_field('theme_argil_news', 'id', array('type' => 'all')))
			{
				$newsrecord->id = $newid1;
				$newsrecord->name = $news_all_name;
				$newsrecord->display = $news_all_display;
				$newsrecord->content = $news_all_content;
				$DB->update_record($table, $newsrecord);
			}
			
		}
		
		if(strlen($news_t_name) > 1 && strlen($news_t_content) > 1 )
		{
			if($newid2 = $DB->get_field('theme_argil_news', 'id', array('type' => 'teacher')))
			{
				$newsrecord->id = $newid2;
				$newsrecord->name = $news_t_name;
				$newsrecord->display = $news_t_display;
				$newsrecord->content = $news_t_content;
				$DB->update_record($table, $newsrecord);
			}
		}
		
		if(strlen($news_s_name) > 1 && strlen($news_s_content) > 1 )
		{
			if($newid3 = $DB->get_field('theme_argil_news', 'id', array('type' => 'student')))
			{
				$newsrecord->id = $newid3;
				$newsrecord->name = $news_s_name;
				$newsrecord->display = $news_s_display;
				$newsrecord->content = $news_s_content;
				$DB->update_record($table, $newsrecord);
			}
		}
	}

}