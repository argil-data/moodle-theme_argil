<?php

defined('MOODLE_INTERNAL') || die();


function xmldb_theme_argil_upgrade($oldversion) {
    global $DB;
	$dbman = $DB->get_manager();

	if ($oldversion < 2023070700)
	{
		//add table theme_argil_faq_cat
		$table = new xmldb_table('theme_argil_faq_cat');
		$table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
		$table->add_field('name_fr', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
		$table->add_field('name_en', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
		$table->add_field('name_de', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
		$table->add_field('icon', XMLDB_TYPE_TEXT, null, null, null, null, null);
		$table->add_field('position', XMLDB_TYPE_INTEGER, '10', null, null, null, 0);
        $table->add_field('visible', XMLDB_TYPE_INTEGER, '1', null, null, null, 1);
		$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
		if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }
		$dbman->create_table($table);
		
		//add table theme_argil_faq	
		$table = new xmldb_table('theme_argil_faq');
		$table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
		$table->add_field('catid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
		$table->add_field('name_fr', XMLDB_TYPE_CHAR, '50', null, XMLDB_NOTNULL, null, null);
		$table->add_field('name_en', XMLDB_TYPE_CHAR, '50', null, XMLDB_NOTNULL, null, null);
		$table->add_field('name_de', XMLDB_TYPE_CHAR, '50', null, XMLDB_NOTNULL, null, null);
		$table->add_field('question_fr', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
		$table->add_field('question_en', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
		$table->add_field('question_de', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
		$table->add_field('answer_fr', XMLDB_TYPE_TEXT, null, null, null, null, null);
		$table->add_field('answer_en', XMLDB_TYPE_TEXT, null, null, null, null, null);
		$table->add_field('answer_de', XMLDB_TYPE_TEXT, null, null, null, null, null);
		$table->add_field('position', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);
        $table->add_field('visible', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, 1);
		$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
		if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }
		$dbman->create_table($table);
	
		upgrade_plugin_savepoint(true, 2023070700, 'theme', 'argil');	 
	}
	
	if ($oldversion < 2023071305)
	{
		$table = new xmldb_table('theme_argil_faq');
		
		$field = new xmldb_field('name_fr', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $dbman->change_field_precision($table, $field);
		
		$field = new xmldb_field('name_en', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $dbman->change_field_precision($table, $field);
		
		$field = new xmldb_field('name_de', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $dbman->change_field_precision($table, $field);


        upgrade_plugin_savepoint(true, 2023071305, 'theme', 'argil');	
	}
	
	
	if ($oldversion < 2023071701)
	{
		//add table theme_argil_faq	
		$table = new xmldb_table('theme_argil_faq');
		$table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
		$table->add_field('catid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
		$table->add_field('name_fr', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
		$table->add_field('name_en', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
		$table->add_field('name_de', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
		$table->add_field('icon', XMLDB_TYPE_TEXT, null, null, null, null, null);
		$table->add_field('question_fr', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
		$table->add_field('question_en', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
		$table->add_field('question_de', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
		$table->add_field('answer_fr', XMLDB_TYPE_TEXT, null, null, null, null, null);
		$table->add_field('answer_en', XMLDB_TYPE_TEXT, null, null, null, null, null);
		$table->add_field('answer_de', XMLDB_TYPE_TEXT, null, null, null, null, null);
		$table->add_field('position', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);
        $table->add_field('visible', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, 1);
		$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
		if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }
		$dbman->create_table($table);

        upgrade_plugin_savepoint(true, 2023071701, 'theme', 'argil');	
	}

	
	return true;

}