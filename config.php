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

require_once(__DIR__ . '/lib.php');

$THEME->name = 'argil';
$THEME->doctype = 'html5';
$THEME->sheets = [''];
$THEME->editor_sheets = [''];

// $THEME->editor_scss = ['editor'];
// $THEME->usefallback = true;
// $THEME->scss = function($theme) {
//     return theme_argil_get_main_scss_content($theme);
// };

$THEME->layouts = [
    
    'base' => array(
        'file' => 'drawers.php',
        'regions' => array()
    ),
	'standard' => array(
        'file' => 'drawers.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
    // Main course page.
    'course' => array(
        'file' => 'drawers.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true)
    ),
    'coursecategory' => array(
        'file' => 'drawers.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
	// Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'drawers.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
	'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true)
    ),
	'login' => array(
        'file' => 'login.php',
        'regions' => array(),
        'options' => array('langmenu' => true)
    ),
	'mydashboard' => array(
        'file' => 'dashboard.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true)
    ),
    'mycourses' => array(
        'file' => 'mycourses.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    )
];


// $THEME->layouts = [
//     // Most backwards compatible layout without the blocks.
//     'base' => array(
//         'file' => 'drawers.php',
//         'regions' => array(),
//     ),
//     // Standard layout with blocks.
//     'standard' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//     ),
//     // Main course page.
//     'course' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//         'options' => array('langmenu' => true),
//     ),
//     'coursecategory' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//     ),
//     // Part of course, typical for modules - default page layout if $cm specified in require_login().
//     'incourse' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//     ),
//     // The site home page.
//     'frontpage' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//         'options' => array('nonavbar' => true),
//     ),
//     // Server administration scripts.
//     'admin' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//     ),
//     // My courses page.
//     'mycourses' => array(
//         'file' => 'drawers.php',
//         'regions' => ['side-pre'],
//         'defaultregion' => 'side-pre',
//         'options' => array('nonavbar' => true),
//     ),
//     // My dashboard page.
//     'mydashboard' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//         'options' => array('nonavbar' => true, 'langmenu' => true),
//     ),
//     // My public page.
//     'mypublic' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//     ),
//     'login' => array(
//         'file' => 'login.php',
//         'regions' => array(),
//         'options' => array('langmenu' => true),
//     ),

//     // Pages that appear in pop-up windows - no navigation, no blocks, no header and bare activity header.
//     'popup' => array(
//         'file' => 'columns1.php',
//         'regions' => array(),
//         'options' => array(
//             'nofooter' => true,
//             'nonavbar' => true,
//             'activityheader' => [
//                 'notitle' => true,
//                 'nocompletion' => true,
//                 'nodescription' => true
//             ]
//         )
//     ),
//     // No blocks and minimal footer - used for legacy frame layouts only!
//     'frametop' => array(
//         'file' => 'columns1.php',
//         'regions' => array(),
//         'options' => array(
//             'nofooter' => true,
//             'nocoursefooter' => true,
//             'activityheader' => [
//                 'nocompletion' => true
//             ]
//         ),
//     ),
//     // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible.
//     'embedded' => array(
//         'file' => 'embedded.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//     ),
//     // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
//     // This must not have any blocks, links, or API calls that would lead to database or cache interaction.
//     // Please be extremely careful if you are modifying this layout.
//     'maintenance' => array(
//         'file' => 'maintenance.php',
//         'regions' => array(),
//     ),
//     // Should display the content and basic headers only.
//     'print' => array(
//         'file' => 'columns1.php',
//         'regions' => array(),
//         'options' => array('nofooter' => true, 'nonavbar' => false, 'noactivityheader' => true),
//     ),
//     // The pagelayout used when a redirection is occuring.
//     'redirect' => array(
//         'file' => 'embedded.php',
//         'regions' => array(),
//     ),
//     // The pagelayout used for reports.
//     'report' => array(
//         'file' => 'drawers.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre',
//     ),
//     // The pagelayout used for safebrowser and securewindow.
//     'secure' => array(
//         'file' => 'secure.php',
//         'regions' => array('side-pre'),
//         'defaultregion' => 'side-pre'
//     )
// ];

$THEME->parents = ['boost'];
$THEME->enable_dock = false;
$THEME->extrascsscallback = 'theme_argil_get_extra_scss';
$THEME->prescsscallback = 'theme_argil_get_pre_scss';
// $THEME->precompiledcsscallback = 'theme_boost_get_precompiled_css';
$THEME->yuicssmodules = [];
// Most themes will use this rendererfactory as this is the one that allows the theme to override any other renderer.
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$THEME->scss = function($theme) {
    return theme_argil_get_main_scss_content($theme);
};

// Additional theme options.
$THEME->supportscssoptimisation = false;
$THEME->csstreepostprocessor = 'theme_argil_css_tree_post_processor';

$THEME->haseditswitch = true;
// $THEME->iconsystem = \core\output\icon_system::FONTAWESOME;
// Defines where to put the "Add a block"
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;
// $THEME->usescourseindex = true;
$THEME->requiredblocks = '';
// By default, all boost theme do not need their titles displayed.
$THEME->activityheaderconfig = [
    'notitle' => true
];
