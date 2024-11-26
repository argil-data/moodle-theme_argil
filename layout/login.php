<?php
/**
 * Version details.
 *
 * @package    theme_argil
 * @copyright  2024 Vincent Delaleu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 
defined('MOODLE_INTERNAL') || die();

/**
 * A login page layout for the boost theme.
 *
 * @package   theme_argil
 * @copyright 20236 cyberlearn
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$extraclasses = [];
$bodyattributes = $OUTPUT->body_attributes($extraclasses);

$templatecontext = [
	'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'logo' => $OUTPUT->image_url('logo_C', 'theme_argil'),
    'hes-so' => $OUTPUT->image_url('hes-so', 'theme_argil'),
    'coursesearchaction' => $CFG->wwwroot . '/course/search.php',
	'isloggedin' => isloggedin(),
	'isguest' => isguestuser()
];

$PAGE->requires->jquery();

echo $OUTPUT->render_from_template('theme_argil/login', $templatecontext);

