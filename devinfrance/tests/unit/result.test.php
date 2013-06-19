<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/tests/unit/attachment.test.php $
	$Revision: 18 $

	Copyright (C) No Parking 2012 - 2012
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Result extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_results",
			"devinfrance_sites"
		);
	}
	
	function test_load() {
		$result = new Devinfrance_Result();
		$result->files_id = 1;
		$result->name = "Mon contenu";
		$result->value = "Mes valeurs";
		$result->day = mktime(0, 0, 0, 3, 9, 2012);
		$result->insert();
		
		$result_loaded = new Devinfrance_Result();
		$result_loaded->load(array('id' => $result->id));
		$this->assertTrue($result_loaded->date_insert >= time());
		$this->assertEqual($result_loaded->date_update, $result_loaded->date_insert);
		
		$result->update();

		$result_loaded = new Devinfrance_Result();
		$result_loaded->load(array('id' => $result->id));
		$this->assertTrue($result_loaded->date_insert >= time());
		$this->assertTrue($result_loaded->date_update >= $result_loaded->date_insert);
		
		$this->truncateTables("devinfrance_results");
	}

	function test_update() {
		$result = new Devinfrance_Result();
		$result->files_id = 1;
		$result->name = "Mon contenu";
		$result->value = "Mes valeurs";
		$result->day = mktime(0, 0, 0, 3, 9, 2012);
		$result->insert();
		
		$result->value = "Mes valeurs corrigées";
		$this->assertTrue($result->update());
		$this->assertEqual($result->id, 1);
		
		$this->truncateTables("devinfrance_results");
		
	}

	function test_insert() {
		$result = new Devinfrance_Result();
		$result->files_id = 1;
		$result->name = "Mon contenu";
		$result->value = "Mes valeurs";
		$result->day = mktime(0, 0, 0, 3, 9, 2012);
		$this->assertTrue($result->insert());
		$this->assertEqual($result->id, 1);
		
		$this->truncateTables("devinfrance_results");
	}
}
