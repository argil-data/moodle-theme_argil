<?php
defined('MOODLE_INTERNAL') || die();

$functions = array(

    'theme_argil_switchdarkmode' => array(
        'classname'   => 'theme_argil\api\external',
		'classpath' => 'theme_argil/classes/api/external.php',
        'methodname'  => 'switchdarkmode',
        'description' => 'enable / disable dark mode',
        'type'        => 'write',
		'ajax' 		  => true,
		'loginrequired' => true
    ),
	'theme_argil_get_faq_question_list' => array(
        'classname'   => 'theme_argil\api\external',
		'classpath' => 'theme_argil/classes/api/external.php',
        'methodname'  => 'get_faq_question_list',
        'description' => 'Return questions',
        'type'        => 'read',
		'ajax' 		  => true,
		'loginrequired' => false
    )
);