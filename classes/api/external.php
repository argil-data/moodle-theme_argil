<?php

namespace theme_argil\api;
defined('MOODLE_INTERNAL') || die;

use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;
use invalid_parameter_exception;

require_once($CFG->libdir."/externallib.php");
/*
require_once($CFG->dirroot."/webservice/externallib.php");

use external_api;
use external_function_parameters;
use external_value;
use external_format_value;
use external_single_structure;
use invalid_parameter_exception;

*/
/**
 * This is the external API for this plugin.
 *
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external extends external_api {

	
	public static function switchdarkmode_parameters() {
        return new external_function_parameters([]);
    }
	
	public static function switchdarkmode_returns() {
		return new external_single_structure([
            'dmid' => new external_value(PARAM_INT, 'record id'),
            'darkmode' => new external_value(PARAM_BOOL, 'Operation response')
        ]);
    }

    public static function switchdarkmode() 
	{
        global $DB, $OUTPUT, $USER;

		$dmrecord = new \stdClass();
		$dmrecord->userid = $USER->id;
		$dmrecord->darkmode = 'n';
		
		$table = "theme_argil_darkmode";
		if($dm = $DB->get_record($table, array('userid' => $USER->id)))
		{
			$dmrecord->id = $dm->id;
			
			$dmmode = false;
			if($dm->darkmode == 'y')
			{
				//$dm->darkmode == 'n';
				$dmrecord->darkmode = 'n';
			}
			else
			{
				//$dm->darkmode == 'y';
				$dmrecord->darkmode = 'y';
				$dmmode = true;
			}
			
			$DB->update_record($table, $dmrecord);
			return ['dmid' => $dm->id, 'darkmode' => $dmmode];
		}
		else
		{
			$dmrecord->darkmode = 'y';
			$dmid = $DB->insert_record($table, $dmrecord);
			return ['dmid' => $dmid, 'darkmode' => true];
		}
    }
	
	
	public static function get_faq_question_list_parameters() {
		return new external_function_parameters(
            array(
                'catid' => new external_value(PARAM_INT, 'The category id to operate on'),
            )    
        );
    }
	
	public static function get_faq_question_list_returns() {
		return new external_single_structure(
                array(
                    'content' => new external_value(PARAM_RAW, ''),
                )
        );
    }

    public static function get_faq_question_list($cid) 
	{
		global $OUTPUT, $PAGE;
		$params = self::validate_parameters(
            self::get_faq_question_list_parameters(),
            array(
                'catid' => $cid,
            )
        );
		$context = '' ;
		$PAGE->set_context($context);
		
		$questionlist = $OUTPUT->get_faq_questions_ajax($cid);
		$db_result['content'] = $questionlist;
		
		return $db_result;
	}
}
