<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/tests/unit/account.test.php $
	$Revision: 650 $

	Copyright (C) No Parking 2012 - 2013
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Block extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_blocks"
		);
	}
	
	function tearDown() {
		$this->truncateTables(
			"devinfrance_blocks"
		);
	}
	
	function test_load() {
		$block = new Devinfrance_Block();
		$block->name = "Nom du block";
		$block->value = "valeur du block";
		$block->insert();
		$id = $block->id;
	
		$loaded_block = new Devinfrance_Block();
		$this->assertEqual($loaded_block->id, 0);
	
		$this->assertTrue($loaded_block->load(array('id' => $id)));
		$this->assertEqual($loaded_block->name, $block->name);
		$this->assertEqual($loaded_block->value, $block->value);
		$this->assertTrue($loaded_block->date_insert <= time());
		$this->assertTrue($loaded_block->date_insert > 0);
		$this->assertTrue($loaded_block->date_update >= 0);
	
		sleep(2);
	
		$block->update();
		$this->assertTrue($loaded_block->load(array('id' => $id)));
		$this->assertTrue($loaded_block->date_insert > 0);
		$this->assertTrue($loaded_block->date_update >= $loaded_block->date_insert);
	
		$this->assertFalse($loaded_block->load(array('id' => 42)));
	}
	
	function test_delete() {
		$block = new Devinfrance_Block();
		$block->name = "Nom du block";
		$block->value = "valeur du block";
		$block->insert();
	
		$block->delete();
	}
	
	function test_update() {
		$block = new Devinfrance_Block();
		$block->name = "Nom du block";
		$block->value = "valeur du block";
		$this->assertTrue($block->insert());
		$this->assertEqual($block->id, 1);
	
		$this->assertTrue($block->update());
		$this->assertEqual($block->id, 1);
	}
	
	function test_insert() {
		$block = new Devinfrance_Block();
		$block->name = "Nom du block";
		$block->value = "valeur du block";
		$this->assertTrue($block->insert());
		$this->assertEqual($block->id, 1);
	
		
		$block->name = "Nom 2";
		$this->assertTrue($block->insert());
		$this->assertEqual($block->id, 2);
	
		$block = new Devinfrance_Block();
		$block->name = "Nom3 du block";
		$block->value = "valeur du block";
		$this->assertTrue($block->insert());
		$this->assertEqual($block->id, 3);
	}
}
