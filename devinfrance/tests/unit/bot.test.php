<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/tests/unit/attachment.test.php $
	$Revision: 18 $

	Copyright (C) No Parking 2012 - 2013
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Bot extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_files",
			"devinfrance_results",
			"devinfrance_sites",
                        "devinfrance_typeresult"
		);
	}
	
	function test_add_site() {
		$bot = new Devinfrance_Bot();
		$this->assertTrue($bot->add_site("http://devinfrance.fr"));
		
		$site = new Devinfrance_Site();
		$site->load(array('url' => "http://devinfrance.fr/"));
		$this->assertEqual($site->id, 1);
		
		$files = new Devinfrance_Files();
		$files->select();
		$this->assertEqual(count($files), 1);
		
		$results = new Devinfrance_Results();
		$results->select();
		$this->assertEqual(count($results), 8);
		
		$this->truncateTables("devinfrance_files", "devinfrance_results", "devinfrance_sites");
	}
}
