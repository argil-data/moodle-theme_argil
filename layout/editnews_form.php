<?php

/**
 * Version details.
 *
 * @package    theme_argil
 * @copyright  2024 Vincent Delaleu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

class editnews_form extends \moodleform {

    public function definition() {
		global $CFC, $DB;
		
		$newsall_name = '';
		$newsall_dispaly = 0;
		$newsall_content = '';
		$newst_name = '';
		$newst_dispaly = 0;
		$newst_content = '';
		$newss_name = '';
		$newss_dispaly = 0;
		$newss_content = '';
		

		if($newsall = $DB->get_record('theme_argil_news', array('type'=>'all')) )
		{
			$newsall_name = $newsall->name;
			$newsall_dispaly = $newsall->display;
			$newsall_content = ['text'=>$newsall->content,'format'=>1];
		}
		
		if($newst = $DB->get_record('theme_argil_news', array('type' => 'teacher')) )
		{
			$newst_name = $newst->name;
			$newst_dispaly = $newst->display;
			$newst_content = ['text'=>$newst->content,'format'=>1];
		}
		
		if($newss = $DB->get_record('theme_argil_news', array('type' => 'student')) )
		{
			$newss_name = $newss->name;
			$newss_dispaly = $newss->display;
			$newss_content = ['text'=>$newss->content,'format'=>1];
		}
		$mform = $this->_form;
		$mform->addElement('html', '<div class="hesnews">');
		
		$mform->addElement('html', '<div class="col-lg-4 col-md-6 col-12 mb-1 hesnewsitem"><div class="newsbody">');
		
		$mform->addElement('html','<h3 class="newsheader">'.get_string('showforall', 'theme_argil').'</h3>');
		
		$mform->addElement('text', 'news_all_name', get_string('bloc_news_hes_name', 'theme_argil'), array('size' => '64'));
		$mform->setType('news_all_name', PARAM_TEXT);
		$mform->setDefault('news_all_name',$newsall_name);
		
		$mform->addElement('html', '<div class="fitem_checkbox">');
		$mform->addElement('checkbox', 'news_all_display', get_string('show', 'moodle'), ' ');
		$mform->setDefault('news_all_display',$newsall_dispaly);
		$mform->addElement('html', '</div>');
		
		$mform->addElement('editor', 'news_all_content',  get_string('content', 'theme_argil'));
		$mform->setType('news_all_content', PARAM_RAW);
		$mform->setDefault('news_all_content',$newsall_content);

		

		
		
		$mform->addElement('html', '</div></div>');
		
		
		
		
		
		
		$mform->addElement('html', '<div class="col-lg-4 col-md-6  col-12 mb-1 hesnewsitem">
		<div class="newsbody">');
		
		$mform->addElement('html','<h3 class="newsheader">'.get_string('showforteacher', 'theme_argil').'</h3>');
		
		$mform->addElement('text', 'news_teacher_name', get_string('bloc_news_hes_name', 'theme_argil'), array('size' => '64'));
		$mform->setType('news_teacher_name', PARAM_TEXT);
		$mform->setDefault('news_teacher_name',$newst_name);
		
		$mform->addElement('html', '<div class="fitem_checkbox">');
		$mform->addElement('checkbox', 'news_teacher_display', get_string('show', 'moodle'), ' ');
		$mform->setDefault('news_teacher_display',$newst_dispaly);
		$mform->addElement('html', '</div>');
		
		$mform->addElement('editor', 'news_teacher_content',  get_string('content', 'theme_argil'));
		$mform->setType('news_teacher_content', PARAM_RAW);	
		$mform->setDefault('news_teacher_content',$newst_content);
		
		$mform->addElement('html', '</div></div>');
		

		
		
		
		
		$mform->addElement('html', '<div class="col-lg-4 col-md-6  col-12 mb-1 hesnewsitem"><div class="newsbody">');
		
		$mform->addElement('html','<h3 class="newsheader">'.get_string('showforstudent', 'theme_argil').'</h3>');
		
		$mform->addElement('text', 'news_student_name', get_string('bloc_news_hes_name', 'theme_argil'), array('size' => '64'));
		$mform->setType('news_student_name', PARAM_TEXT);
		$mform->setDefault('news_student_name',$newss_name);
		
		$mform->addElement('html', '<div class="fitem_checkbox">');
		$mform->addElement('checkbox', 'news_student_display', get_string('show', 'moodle'), ' ');
		$mform->setDefault('news_student_display',$newss_dispaly);
		$mform->addElement('html', '</div>');
		
		$mform->addElement('editor', 'news_student_content',  get_string('content', 'theme_argil'));
		$mform->setType('news_student_content', PARAM_RAW);
		$mform->setDefault('news_student_content',$newss_content);
		
		$mform->addElement('html', '</div></div>');
		
		
		

		$mform->addElement('html', '</div>');
		
		$mform->addElement('html', '<div class="hesnewssave">');
		$mform->addElement('submit','save',get_string('save').' '.get_string('settingshesnews', 'theme_argil'));
		$mform->addElement('html', '</div>');
    }

}