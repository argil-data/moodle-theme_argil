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

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');


$PAGE->set_context(context_course::instance(SITEID));

$courseindexopen = false;
$blockdraweropen = false;
$hasblocks = false;
$blockshtml = '';
$courseindex = core_course_drawer();

$extraclasses = ['uses-drawers'];
$extraclasses[] = ' '.$OUTPUT->getdarkmode().'mode ';


$showSupport = false;
$showContact = false;
$showPrestation = false;
$optionpage = '';

if (isset($_GET['op'])) 
{
	if($_GET['op'] == 'support')
	{
		if($PAGE->theme->settings->show_menu_support)
		{
			$showSupport = true;
			$extraclasses[] .= 'pagelayout-frontpage-support';
			$optionpage = 'support';
		}
	}
	else if($_GET['op'] == 'cyberlearn')
	{
		if($PAGE->theme->settings->show_menu_prestations)
		{
			$showPrestation = true;
			$extraclasses[] .= 'pagelayout-frontpage-cyberlearn';
			$optionpage = 'cyberlearn';
		}
	}
	
}

$bodyattributes = $OUTPUT->body_attributes($extraclasses);


$secondarynavigation = false;
$overflow = '';

if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $overflow = $overflowdata->export_for_template($OUTPUT);
    }
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);
$buildregionmainsettings = !$PAGE->include_region_main_settings_in_header_actions() && !$PAGE->has_secondary_navigation();
// If the settings menu will be included in the header then don't add it here.
$regionmainsettingsmenu = $buildregionmainsettings ? $OUTPUT->region_main_settings_menu() : false;

$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);


$topmenu = $OUTPUT->topmenu($primarymenu['moremenu']['nodearray'],$optionpage);
$primarymenu['moremenu']['nodearray'] = $topmenu;
$primarymenu['mobileprimarynav'] = $topmenu;
/**/

$templatecontext = [
	'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
	'showbacktotop' => true,
	'bodyattributes' => $bodyattributes,
    'primarymoremenu' => $primarymenu['moremenu'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => true,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'overflow' => $overflow,
	'headercontent' => $headercontent,
    'coursesearchaction' => $CFG->wwwroot . '/course/search.php',
	'contactaction' => $CFG->wwwroot . '/course/search.php',
	'isloggedin' => isloggedin(),
	'isguest' => isguestuser(), 
	'darkmode' => $OUTPUT->getdarkmode(),
	'logodigital' => $OUTPUT->image_url('logo_mooc_w', 'theme_argil')
];


$PAGE->requires->jquery();
$PAGE->requires->js_call_amd('theme_argil/main', 'init');


if($showPrestation)
{
	$templatecontext['cyberlearnpage'] = true;
	
	$htmlPrestationIntro = $PAGE->theme->settings->prestations_intro;
	$templatecontext['intro'] = $htmlPrestationIntro;
	
	$teams = [];
	$nbrMembre = 0;
	
	for ($i = 1; $i <= 15; $i++) 
	{
		$tmporder = $PAGE->theme->settings->{'teamorder'.$i};

		if($tmporder > 0)
		{
			$team['order'] = $tmporder;
			$team['name'] = $PAGE->theme->settings->{'teamname'.$i};
			$team['poste'] = $postes = explode(",", $PAGE->theme->settings->{'teamposte'.$i});
			$team['tel'] = $PAGE->theme->settings->{'teamtel'.$i};
			$team['email'] = $PAGE->theme->settings->{'teamemail'.$i};
			
			$imgsection = 'teamphoto'.$i;
			$team['photo'] = $PAGE->theme->setting_file_url($imgsection, $imgsection);

			if(strlen($team['name']) > 0 && strlen($team['email']) > 0 )
			{
				$teams[] = $team;
				$nbrMembre++;
			}
		}
	}
	if($nbrMembre > 0)
	{
		$templatecontext['teamHeader'] = get_string('team', 'theme_argil');
	}
	$templatecontext['teams'] = $teams;
}
else if($showSupport)
{
	$PAGE->set_url('/?', array('redirect'=>'0','op' => 'support'));
	$PAGE->set_title(get_string('support', 'theme_argil').' - Cyberlearn');
	
	$templatecontext['supportpage'] = true;
	//print_r('<br><br><br><br>----------------------------<br>');
	$catid = 0;
	if (isset($_GET['cat'])) 
	{
		$catid = $_GET['cat'];	
	}
	$topicid = 0;
	if (isset($_GET['topic'])) 
	{
		$topicid = $_GET['topic'];	
	}
	$supaction = '';
	if (isset($_GET['action'])) 
	{
		$supaction = $_GET['action'];	
	}
	

	$errormsg = '';
	$faq_form = '';
	$faqdata = array();
	$isform = false;
	
	$editingmode= false;
	if(is_siteadmin() && $PAGE->user_is_editing())
	{
		$editingmode= true;
	}
	
	if($editingmode)
	{
		$templatecontext['is_faq_admin'] = true;
		
		$faqdata['type'] = '';
		$faqdata['catid'] = 0;
		$faqdata['id'] = 0;
		$faqdata['name_fr'] = '';
		$faqdata['name_en'] = '';
		$faqdata['name_de'] = '';
		$faqdata['icon'] = '';
		$faqdata['visible'] = 1;
		$faqdata['question_fr'] = '';
		$faqdata['question_en'] = '';
		$faqdata['question_de'] = '';
		$faqdata['answer_fr'] = '';
		$faqdata['answer_en'] = '';
		$faqdata['answer_de'] = '';
		$actionurl = $CFG->wwwroot . '/?redirect=0&op=support';
		
		if($supaction == 'addc')
		{
			$actionurl .= '&action='.$supaction;
			$faqdata['pagename'] = get_string('add') . ' - ' . get_string('rubric', 'theme_argil');
			$faqdata['type'] = 'cat';
			
			require_once('editfaq_form.php');
			$mform = new editfaq_form($actionurl, $faqdata);
			
			if($mform->is_cancelled())
			{
				$faq_form = 'edit form - cancel ';
			}
			else if($formform = $mform->get_data())
			{	
				$catid = $OUTPUT->set_faq('cat', $formform);
			}
			else
			{
				$faq_form = $mform->render();
				$isform = true;
			}
		}
		else if($catid > 0)
		{
			if($supaction == 'hidec')
			{
				$OUTPUT->set_faq_field('theme_argil_faq_cat', $catid,'visible',0);
			}
			else if($supaction == 'showc')
			{
				$OUTPUT->set_faq_field('theme_argil_faq_cat', $catid,'visible',1);
			}
			else if($supaction == 'downc')
			{
				$errormsg .= $OUTPUT->set_faq_position('cat', $catid,0,0);
			}
			else if($supaction == 'upc')
			{
				$errormsg .= $OUTPUT->set_faq_position('cat', $catid,0,1);
			}
			else if($supaction == 'delc')
			{
				$errormsg .= $OUTPUT->del_faq('cat', $catid);
			}
			else if($supaction == 'editc')
			{
				$actionurl .= '&cat='.$catid;
				$actionurl .= '&action='.$supaction;
				$faqdata['pagename'] = get_string('edit') . ' - ' . get_string('rubric', 'theme_argil');
				$faqdata['type'] = 'cat';
				$faqdata['catid'] = $catid;
				$faqdata = array_merge($faqdata, $OUTPUT->get_faq('cat', $catid));

				require_once('editfaq_form.php');
				$mform = new editfaq_form($actionurl, $faqdata);

				if($mform->is_cancelled())
				{
					$faq_form = 'edit form - cancel ';
				}
				else if($formform = $mform->get_data())
				{	
					$catid = $OUTPUT->set_faq('cat', $formform);
				}
				else
				{
					$faq_form = $mform->render();
					$isform = true;
				}
			}
			else if($supaction == 'addq')
			{
				$actionurl .= '&cat='.$catid;
				$actionurl .= '&action='.$supaction;
				$faqdata['pagename'] = get_string('add') . ' - ' . get_string('faqtopic', 'theme_argil');
				$faqdata['type'] = 'question';
				$faqdata['catid'] = $catid;
				
				require_once('editfaq_form.php');
				$mform = new editfaq_form($actionurl, $faqdata);
				
				if($mform->is_cancelled())
				{
					$faq_form = 'edit form - cancel ';
				}
				else if($formform = $mform->get_data())
				{	
					$topicid = $OUTPUT->set_faq('topic', $formform);
				}
				else
				{
					$faq_form = $mform->render();
					$isform = true;
				}
				
			}
			else if($topicid > 0)
			{
				if($supaction == 'hideq')
				{
					$OUTPUT->set_faq_field('theme_argil_faq', $topicid,'visible',0);
				}
				else if($supaction == 'showq')
				{
					$OUTPUT->set_faq_field('theme_argil_faq', $topicid,'visible',1);
				}
				else if($supaction == 'downq')
				{
					$errormsg .= $OUTPUT->set_faq_position('topic', $catid, $topicid, 0);
				}
				else if($supaction == 'upq')
				{
					$errormsg .= $OUTPUT->set_faq_position('topic', $catid, $topicid, 1);
				}
				else if($supaction == 'delq')
				{
					$errormsg .= $OUTPUT->del_faq('topic', $catid, $topicid);
				}
				else if($supaction == 'editq')
				{
					$actionurl .= '&cat='.$catid;
					$actionurl .= '&topic='.$topicid;
					$actionurl .= '&action='.$supaction;
					$faqdata['pagename'] = get_string('edit') . ' - ' . get_string('faqtopic', 'theme_argil');
					$faqdata['type'] = 'question';
					$faqdata = array_merge($faqdata, $OUTPUT->get_faq('topic', $topicid));
					
					require_once('editfaq_form.php');
					$mform = new editfaq_form($actionurl, $faqdata);
					if($mform->is_cancelled())
					{
						$faq_form = 'edit form - cancel ';
					}
					else if($formform = $mform->get_data())
					{	
						$topicid = $OUTPUT->set_faq('topic', $formform);
					}
					else
					{
						$faq_form = $mform->render();
						$isform = true;
					}
				}
			}
		}

		
	}
	
	if($isform)
	{
		$templatecontext['is_faq_form'] = true;
		$templatecontext['faq_form'] = $faq_form;
	}
	else
	{
		$catcontent = '';
		$supportform = '';
		$supportemail = '';
		$supporttel = '';
		$hascontact = false;
		$catcontent = $OUTPUT->get_faq_cat($catid,$topicid);
		//print_object($catcontent);
		
		if (!empty($CFG->supportpage)) 
		{
			$supportform = $CFG->supportpage;
		}
		else
		{
			$supportform = $CFG->wwwroot . '/user/contactsitesupport.php';
		}
		
		$hdtel = $this->page->theme->settings->helpdesktel;
		$hdhoraire = $this->page->theme->settings->helpdeskhoraire;
		$hdemail = $this->page->theme->settings->helpdeskemail;
		if($hdemail)
		{
			$supportemail = $hdemail;
		}
		if($hdtel)
		{
			$supporttel = $hdtel;
		}
		

		if($supportform != '' || $supportemail != '' || $supporttel != '')
		{
			$hascontact = true;
		}
		
		$hdopening = get_string('openingmsg', 'theme_argil');
		if($hdhoraire)
		{
			$hdopening .= ', '.$hdhoraire;
		}
		$hdopening .= '. ';
		
		

		$templatecontext['supportintro'] = ''.format_text($PAGE->theme->settings->support_intro).'';
		$templatecontext['supportmore'] = ''.format_text($PAGE->theme->settings->support_more).'';
		
		$templatecontext['catcontent'] = $catcontent;
		$templatecontext['hascontact'] = $hascontact;
		$templatecontext['supportform'] = $supportform;
		$templatecontext['supportemail'] = $supportemail;
		$templatecontext['supporttel'] = $supporttel;
		$templatecontext['supportopening'] = $hdopening;

		$PAGE->requires->js_call_amd('theme_argil/main', 'faq');
	}
	
	$templatecontext['errormsg'] = $errormsg;
	

	

	
	
}
else
{
	
	if (!isloggedin() || is_siteadmin()) 
	{
		$forceblockdraweropen = $OUTPUT->firstview_fakeblocks();

		$hasblocks = true;
		$blockdraweropen = true;

		$blockshtml = $OUTPUT->blocks('side-pre');
		if (is_siteadmin()) {
			$courseindexopen = (get_user_preferences('drawer-open-index', true) == true);
			$blockdraweropen = (get_user_preferences('drawer-open-block') == true);
			$addblockbutton = $OUTPUT->addblockbutton();
		} else {
			$courseindexopen = false;
			$blockdraweropen = true;
			$addblockbutton = '';
		}
		
		$templatecontext['courseindexopen'] = $courseindexopen;
		$templatecontext['courseindex'] = $courseindex;
		$templatecontext['hasblocks'] = $hasblocks;
		$templatecontext['sidepreblocks'] = $blockshtml;
		$templatecontext['addblockbutton'] = $addblockbutton;
		$templatecontext['blockdraweropen'] = $blockdraweropen;
		$templatecontext['forceblockdraweropen'] = $forceblockdraweropen;
		$templatecontext['welcomlogin'] = '<h2>'.get_string('welcom', 'theme_argil').'</h2>'.get_string('welcomlogin', 'theme_argil');

	}
	
	

	// Let's include the images slider if enabled.
	$frontpage_slider = '';
	if (!empty($PAGE->theme->settings->sliderenabled)) {
		$frontpage_slider = $OUTPUT->get_frontpage_slider();
	}
	$templatecontext['homepage'] = true;
	$templatecontext['fp_slider'] = $frontpage_slider;
	
}

echo $OUTPUT->render_from_template('theme_argil/frontpage', $templatecontext);