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

class editfaq_form extends \moodleform {

    public function definition() {
		global $CFC, $DB;
		
		$table = 'theme_argil_faq_cat';
		
		$pagename = '';
		$type = '';
		$catid = 0;
		$id = 0;
		$btntxt = '';
		
		
		$name_fr = '';
		$name_en = '';
		$name_de = '';
		$icon = '';
		$visible = 0;
		
		$question_fr = '';
		$question_en = '';
		$question_de = '';
		$answer_fr = [];
		$answer_en = [];
		$answer_de = [];
		
		
		$data = $this->_customdata;

		
		$pagename = $data['pagename'];
		$type = $data['type'];
		$id = $data['id'];
		$catid = $data['catid'];
		$name_fr = $data['name_fr'];
		$name_en = $data['name_en'];
		$name_de = $data['name_de'];
		$icon = $data['icon'];
		$visible = $data['visible'];
		$question_fr = $data['question_fr'];
		$question_en = $data['question_en'];
		$question_de = $data['question_de'];
		$answer_fr['text'] = $data['answer_fr'];
		$answer_en['text'] = $data['answer_en'];
		$answer_de['text'] = $data['answer_de'];

		
		
		$mform = $this->_form;
		
		$mform->addElement('html', '<div id="editfaqform">');
		$mform->addElement('html', '<h3 class="mt-2 mb-6">'.$pagename.'</h3>');
		//$mform->addElement('header','general', get_string('general', 'form'));
		if($id > 0)
		{
			$mform->addElement('hidden', 'id', $id);
			$mform->setType('id', PARAM_INT);
		}
		$mform->addElement('hidden', 'catid', $catid);
		$mform->setType('catid', PARAM_INT);
		
		$mform->addElement('text', 'name_fr', get_string('name', 'moodle').' - Français', array('size' => '99'));
		$mform->setType('name_fr', PARAM_RAW);
		$mform->setDefault('name_fr',$name_fr);
		$mform->addRule('name_fr', null, 'required', null, 'client');
		$mform->addRule('name_fr', get_string('maximumchars', '', 90), 'maxlength', 90, 'client');
		
		$mform->addElement('text', 'name_en', get_string('name', 'moodle').' - English', array('size' => '99'));
		$mform->setType('name_en', PARAM_RAW);
		$mform->setDefault('name_en',$name_en);
		$mform->addRule('name_en', null, 'required', null, 'client');
		$mform->addRule('name_en', get_string('maximumchars', '', 90), 'maxlength', 90, 'client');
		
		$mform->addElement('text', 'name_de', get_string('name', 'moodle').' - Deutsch', array('size' => '99'));
		$mform->setType('name_de', PARAM_RAW);
		$mform->setDefault('name_de',$name_de);
		$mform->addRule('name_de', null, 'required', null, 'client');
		$mform->addRule('name_de', get_string('maximumchars', '', 90), 'maxlength', 90, 'client');
		
		$mform->addElement('textarea', 'icon','icône svg(code source)', 'wrap="virtual" rows="10" cols="50"');
		$mform->setType('icon', PARAM_RAW);
		$mform->setDefault('icon',$icon);
		
		if($type == 'cat')
		{
			$btntxt = 'rubric';
			
			
			$mform->addElement('hidden', 'question_fr', '');
			$mform->setType('question_fr', PARAM_RAW);
			$mform->addElement('hidden', 'question_en', '');
			$mform->setType('question_en', PARAM_RAW);
			$mform->addElement('hidden', 'question_de', '');
			$mform->setType('question_de', PARAM_RAW);
			
			$mform->addElement('hidden', 'answer_fr', '');
			$mform->setType('answer_fr', PARAM_RAW);
			$mform->addElement('hidden', 'answer_en', '');
			$mform->setType('answer_en', PARAM_RAW);
			$mform->addElement('hidden', 'answer_de', '');
			$mform->setType('answer_de', PARAM_RAW);
		}
		else
		{
			$btntxt = 'faqtopic';
			
			$mform->addElement('textarea', 'question_fr', get_string('title', 'theme_argil').' - Français', 'wrap="virtual" rows="2" cols="50"');
			$mform->setType('question_fr', PARAM_RAW);
			$mform->setDefault('question_fr',$question_fr);
			$mform->addRule('question_fr', null, 'required', null, 'client');
			$mform->addElement('textarea', 'question_en', get_string('title', 'theme_argil').' - English', 'wrap="virtual" rows="2" cols="50"');
			$mform->setType('question_en', PARAM_RAW);
			$mform->setDefault('question_en',$question_en);
			$mform->addRule('question_en', null, 'required', null, 'client');
			$mform->addElement('textarea', 'question_de', get_string('title', 'theme_argil').' - Deutsch', 'wrap="virtual" rows="2" cols="50"');
			$mform->setType('question_de', PARAM_RAW);
			$mform->setDefault('question_de',$question_de);
			$mform->addRule('question_de', null, 'required', null, 'client');
			
			$mform->addElement('editor', 'answer_fr',   get_string('content', 'theme_argil').' - Français');
			$mform->setType('answer_fr', PARAM_RAW);
			$mform->setDefault('answer_fr',$answer_fr);
			$mform->addRule('answer_fr', null, 'required', null, 'client');
			$mform->addElement('editor', 'answer_en',   get_string('content', 'theme_argil').' - English');
			$mform->setType('answer_en', PARAM_RAW);
			$mform->setDefault('answer_en',$answer_en);
			$mform->addRule('answer_en', null, 'required', null, 'client');
			$mform->addElement('editor', 'answer_de',   get_string('content', 'theme_argil').' - Deutsch');
			$mform->setType('answer_de', PARAM_RAW);
			$mform->setDefault('answer_de',$answer_de);
			$mform->addRule('answer_de', null, 'required', null, 'client');
		}	
		
		
		
		$mform->addElement('checkbox', 'visible', get_string('show', 'moodle'), ' ');
		$mform->setType('visible', PARAM_BOOL);
		$mform->setDefault('visible',$visible);
		
		$mform->addElement('submit','save',get_string('save').' '.get_string($btntxt, 'theme_argil'));
		
		$mform->addElement('cancel','cancel',get_string('cancel'));
		$mform->addElement('html', '</div>');
    }

}