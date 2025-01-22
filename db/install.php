<?php
defined('MOODLE_INTERNAL') || die();

function xmldb_theme_argil_install() {
    global $DB;
	
	$news = new stdClass();
    $news->type = 'all';
    $news->display = 0;
    $news->name = null;
    $news->content = null;
    $id = $DB->insert_record('theme_argil_news', $news);
	
	$news = new stdClass();
    $news->type = 'teacher';
    $news->display = 0;
    $news->name = null;
    $news->content = null;
    $id = $DB->insert_record('theme_argil_news', $news);
	
	$news = new stdClass();
    $news->type = 'student';
    $news->display = 0;
    $news->name = null;
    $news->content = null;
    $id = $DB->insert_record('theme_argil_news', $news);
}