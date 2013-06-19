<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/devinfrance/tests/unit/hit.test.php $
	$Revision: 650 $

	Copyright (C) No Parking 2011 - 2011
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Hit extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_hits"
		);
	}

	function test_is_updatable() {
		$hit = new Devinfrance_Hit();
		$this->assertFalse($hit->is_insertable());
		
		$hit->cookie = uniqid();
		$this->assertTrue($hit->is_insertable());
		$this->assertFalse($hit->is_updatable());
		
		$hit->id = rand(1, 10);
		$this->assertTrue($hit->is_insertable());
		$this->assertTrue($hit->is_updatable());
	}
	
	function test_is_insertable() {
		$hit = new Devinfrance_Hit();
		$this->assertFalse($hit->is_insertable());
		
		$hit->cookie = uniqid();
		$this->assertTrue($hit->is_insertable());
	}

	function test_load() {
		$hit = new Devinfrance_Hit();
		$hit->cookie = uniqid();
		$hit->insert();
		$id = $hit->id;

		$loaded_hit = new Devinfrance_Hit();
		$this->assertEqual($loaded_hit->id, 0);

		$this->assertTrue($loaded_hit->load(array('id' => $id)));
		$this->assertEqual($loaded_hit->cookie, $hit->cookie);
		$this->assertTrue($loaded_hit->date_insert <= time());
		$this->assertTrue($loaded_hit->date_insert > 0);
		$this->assertTrue($loaded_hit->date_update > 0);
		$this->assertTrue($loaded_hit->date_update <= time());
		
		sleep(2);
		
		$hit->update();
		$this->assertTrue($loaded_hit->load(array('id' => $id)));
		$this->assertTrue($loaded_hit->date_insert > 0);
		$this->assertTrue($loaded_hit->date_update > $loaded_hit->date_insert);
		
		$this->assertFalse($loaded_hit->load(array('id' => 42)));

		$this->truncateTables("devinfrance_hits");
	}

	function test_delete() {
		$hit = new Devinfrance_Hit();
		$hit->cookie = uniqid();
		$hit->insert();

		$hit->delete();
		
		$this->truncateTables("devinfrance_hits");
	}
		
	function test_update() {
		$hit = new Devinfrance_Hit();
		$hit->cookie = uniqid();
		$this->assertTrue($hit->insert());
		$this->assertEqual($hit->id, 1);

		$hit->cookie = uniqid();
		$this->assertTrue($hit->update());
		$this->assertEqual($hit->id, 1);

		$this->truncateTables("devinfrance_hits");
	}
	
	function test_insert() {
		$hit = new Devinfrance_Hit();
		$this->assertFalse($hit->insert());
		
		$hit = new Devinfrance_Hit();
		$hit->cookie = uniqid();
		$this->assertTrue($hit->insert());
		$this->assertEqual($hit->id, 1);

		$this->truncateTables("devinfrance_hits");
	}
}
