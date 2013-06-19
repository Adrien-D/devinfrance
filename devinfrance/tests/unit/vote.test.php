<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/tests/unit/account.test.php $
	$Revision: 650 $

	Copyright (C) No Parking 2012 - 2012
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Vote extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_votes"
		);
	}
	
	function tearDown() {
		$this->truncateTables(
			"devinfrance_votes"
		);
	}
	
	function test_load() {
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "127.0.0.1";
		$vote->propositions_id = 1;
		$vote->value = 1;
		$vote->insert();

		$loaded_vote = new Devinfrance_Vote();
		$this->assertEqual($loaded_vote->id, 0);

		$this->assertTrue($loaded_vote->load(array('id' => $vote->id)));
		$this->assertEqual($loaded_vote->remote_address ,$vote->remote_address);
		$this->assertEqual($loaded_vote->propositions_id, $vote->propositions_id);
		$this->assertEqual($loaded_vote->value, $vote->value);
		$this->assertTrue($loaded_vote->date_insert <= time());
		$this->assertTrue($loaded_vote->date_insert > 0);
		$this->assertTrue($loaded_vote->date_update >= 0);
		
		sleep(2);
		
		$vote->update();
		$this->assertTrue($loaded_vote->load(array('id' => $vote->id)));
		$this->assertTrue($loaded_vote->date_insert > 0);
		$this->assertTrue($loaded_vote->date_update > $loaded_vote->date_insert);
		
		$this->assertFalse($loaded_vote->load(array('id' => 42)));
	}

	function test_delete() {
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "Ip";
		$vote->propositions_id = "Proposition";
		$vote->value = "Valeur";
		$vote->insert();

		$vote->delete();
	}
		
	function test_update() {
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "127.0.0.1";
		$vote->propositions_id = 1;
		$vote->value = 1;
		$this->assertTrue($vote->insert());
		$this->assertEqual($vote->id, 1);

		$vote->value = "voici mon message bis";
		$this->assertTrue($vote->update());
		$this->assertEqual($vote->id, 1);
	}
	
	function test_insert() {
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "127.0.1.1";
		$vote->propositions_id = 1;
		$vote->value = 1;
		$this->assertTrue($vote->insert());
		$this->assertEqual($vote->id, 1);
		
		$this->assertTrue($vote->insert());
		$this->assertEqual($vote->id, 2);
		
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "127.0.2.1";
		$vote->propositions_id = 1;
		$vote->value = 1;
		$this->assertTrue($vote->insert());
		$this->assertEqual($vote->id, 3);
	}
}
