<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/tests/unit/attachment.test.php $
	$Revision: 18 $

	Copyright (C) No Parking 2012 - 2012
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_File extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_files",
			"devinfrance_results",
			"devinfrance_sites"
		);
	}
	
	function test_parse() {
		$file = new Devinfrance_File();
		$file->content = "
/* EQUIPE */
Nombre de personnes = 2
Métiers = 1 graphiste, 1 développeur
Ville = Lille
Code postal = 59000
Département = 59

/* SITE */
Dernière mise à jour = 29/02/2012
Standards = HTML5, CSS3
Outils = PHP, Drupal, MySQL, Photoshop
";
		$file->sites_id = 1;
		$file->save();

		$this->assertTrue($file->parse());
		
		$results = new Devinfrance_Results();
		$results->select();
		$this->assertEqual(count($results), 8);

		$this->truncateTables("devinfrance_files", "devinfrance_results");
	}
	
	function test_load() {
		$file = new Devinfrance_File();
		$file->content = "Mon contenu";
		$file->sites_id = 1;
		$file->day = mktime(0, 0, 0, 3, 9, 2012);
		$file->insert();
		
		$file_loaded = new Devinfrance_File();
		$file_loaded->load(array('id' => $file->id));
		$this->assertTrue($file_loaded->date_insert >= time());
		$this->assertTrue($file_loaded->date_update > 0);
		
		$file->update();

		$file_loaded = new Devinfrance_File();
		$file_loaded->load(array('id' => $file->id));
		$this->assertTrue($file_loaded->date_insert >= time());
		$this->assertTrue($file_loaded->date_update >= $file_loaded->date_insert);
		
		$this->truncateTables("devinfrance_files");
	}

	function test_update() {
		$file = new Devinfrance_File();
		$file->content = "Mon contenu";
		$file->sites_id = 1;
		$file->day = mktime(0, 0, 0, 3, 9, 2012);
		$file->insert();
		
		$file->url = "http://localhost/~perrick/opentime.fr/";
		$this->assertTrue($file->update());
		$this->assertEqual($file->id, 1);
		
		$this->truncateTables("devinfrance_files");
		
	}

	function test_insert() {
		$file = new Devinfrance_File();
		$file->content = "Mon contenu";
		$file->sites_id = 1;
		$file->day = mktime(0, 0, 0, 3, 9, 2012);
		$this->assertTrue($file->insert());
		$this->assertEqual($file->id, 1);
		
		$this->truncateTables("devinfrance_files");
	}
}
