<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/tests/unit/questions.test.php $
	$Revision: 725 $

	Copyright (C) No Parking 2012 - 2013
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Blocks extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_blocks"
		);
	}

	function tearDown() {
		$this->truncateTables("devinfrance_blocks");
	}

	function test_delete() {
		$block = new Devinfrance_Block();
		$block->name = "Nom";
		$block->value = "Valeur";
		$block->insert();
						
		$block = new Devinfrance_Block();
		$block->name = "Nom2";
		$block->value = "Valeur";
		$block->insert();
		
		$blocks = new Devinfrance_Blocks();
		$blocks->id = $block->id;
		$blocks->delete();
		
		$blocks = new Devinfrance_Blocks();
		$blocks->select();
		$this->assertEqual(count($blocks), 1);

		$blocks = new Devinfrance_Blocks();
		$blocks->delete();
		
		$blocks = new Devinfrance_Blocks();
		$blocks->select();
		$this->assertEqual(count($blocks), 0);
	}
	
	function test_show() {
		$blocks = new Devinfrance_Blocks();
		$this->assertNoPattern("/blocks/", $blocks->show());
		
		$block = new Devinfrance_Block();
		$block->name = "Nom";
		$block->value = "Valeur";
		$block->insert();
		
		$blocks->select();
		
		$this->assertPattern("/Nom/", $blocks->show());
	}
	
	function test_found_rows() {
		$block_1 = new Devinfrance_Block();
		$block_1->name = "Nom1";
		$block->value = "Valeur";
		$block_1->insert();
		
		$block_2 = new Devinfrance_Block();
		$block_2->name = "Nom2";
		$block->value = "Valeur";
		$block_2->insert();

		$blocks = new Devinfrance_Blocks();
		$blocks->calc_found_rows(true);
		$blocks->set_limit(3, 0);
		$blocks->select();
		$this->assertEqual($blocks->found_rows(), 2);
		$this->assertEqual(count($blocks), 2);
	}

	function test_select__avec_order_by_date_insert() {
		$block_1 = new Devinfrance_Block();
		$block_1->name = "Nom";
		$block->value = "Valeur";
		$block_1->insert();
		
		sleep(2);
		
		$block_2 = new Devinfrance_Block();
		$block_2->name = "Nom2";
		$block->value = "Valeur";
		$block_2->insert();
		
		$blocks = new Devinfrance_Blocks();
		$blocks->select();
		$this->assertEqual($blocks[0]->id, $block_1->id);
		
		$blocks->set_order("date_insert", "DESC");
		$blocks->select();
		$this->assertEqual($blocks[0]->id, $block_2->id);
	}

	function test_select() {
		$block = new Devinfrance_Block();
		$block->name = "Nom";
		$block->value = "Valeur";
		$block->insert();

		$blocks = new Devinfrance_Blocks();
		$this->assertTrue($blocks->select());
		$this->assertEqual(count($blocks), 1);
	}
	
	function test_select__avec_limit() {
		for ($i = 1; $i <= 10; $i++) {
			$block = new Devinfrance_Block();
			$block->name = "Nom".$i;
			$block->value = "Valeur";
			$block->insert();
		}
		
		$blocks = new Devinfrance_Blocks();
		$blocks->set_limit(5, 0);
		$this->assertTrue($blocks->select());
		$this->assertEqual(count($blocks), 5);

		$blocks->set_limit(15, 0);
		$this->assertTrue($blocks->select());
		$this->assertEqual(count($blocks), 10);
	}
}
