<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/tests/unit/questions.test.php $
	$Revision: 725 $

	Copyright (C) No Parking 2010 - 2011
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Votes extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_votes"
		);
	}

	function tearDown() {
		$this->truncateTables("devinfrance_votes");
	}

	function test_delete() {
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "Ip";
		$vote->propositions_id = "Proposition";
		$vote->value = 1;
		$vote->insert();
				
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "Ip";
		$vote->propositions_id = "Proposition";
		$vote->value = 1;
		$vote->insert();
				
		$votes = new Devinfrance_Votes();
		$votes->id = $vote->id;
		$votes->delete();
		
		$votes = new Devinfrance_Votes();
		$votes->select();
		$this->assertEqual(count($votes), 1);

		$votes = new Devinfrance_Votes();
		$votes->delete();
		
		$votes = new Devinfrance_Votes();
		$votes->select();
		$this->assertEqual(count($votes), 0);
	}
	
	function test_show() {
		$votes = new Devinfrance_Votes();
		$this->assertNoPattern("/votes/", $votes->show());
		
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "Ip";
		$vote->propositions_id = "Proposition";
		$vote->value = 1;
		$vote->insert();
		
		$votes->select();
		
		$this->assertPattern("/".$vote->value."/", $votes->show());
	}
	
	function test_found_rows() {
		$vote_1 = new Devinfrance_Vote();
		$vote_1->remote_address = "Ip1";
		$vote_1->propositions_id = "Proposition";
		$vote_1->value = 1;
		$vote_1->insert();
		
		$vote_2 = new Devinfrance_Vote();
		$vote_2->remote_address = "Ip2";
		$vote_2->propositions_id = "Proposition";
		$vote_2->value = 1;
		$vote_2->insert();

		$votes = new Devinfrance_Votes();
		$votes->calc_found_rows(true);
		$votes->set_limit(3, 0);
		$votes->select();
		$this->assertEqual($votes->found_rows(), 2);
		$this->assertEqual(count($votes), 2);
	}

	function test_select__avec_order_by_date_insert() {
		$vote_1 = new Devinfrance_Vote();
		$vote_1->remote_address = "Ip1";
		$vote_1->propositions_id = "Proposition";
		$vote_1->value = 1;
		$vote_1->insert();
		
		sleep(2);
		
		$vote_2 = new Devinfrance_Vote();
		$vote_2->remote_address = "Ip2";
		$vote_2->propositions_id = "Proposition";
		$vote_2->value = 1;
		$vote_2->insert();
		
		$votes = new Devinfrance_Votes();
		$votes->select();
		$this->assertEqual($votes[0]->id, $vote_1->id);
		
		$votes->set_order("date_insert", "DESC");
		$votes->select();
		$this->assertEqual($votes[0]->id, $vote_2->id);
	}

	function test_select() {
		$vote = new Devinfrance_Vote();
		$vote->remote_address = "Ip";
		$vote->propositions_id = "Proposition";
		$vote->value = 1;
		$vote->insert();

		$votes = new Devinfrance_Votes();
		$this->assertTrue($votes->select());
		$this->assertEqual(count($votes), 1);
	}
	
	function test_select__avec_limit() {
		for ($i = 1; $i <= 10; $i++) {
			$vote = new Devinfrance_Vote();
			$vote->remote_address = "Ip";
			$vote->propositions_id = $i;
			$vote->value = 1;
			$vote->insert();
		}
		
		$votes = new Devinfrance_Votes();
		$votes->set_limit(5, 0);
		$this->assertTrue($votes->select());
		$this->assertEqual(count($votes), 5);

		$votes->set_limit(15, 0);
		$this->assertTrue($votes->select());
		$this->assertEqual(count($votes), 10);
	}
}
