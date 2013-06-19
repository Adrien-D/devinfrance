<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/tests/unit/questions.test.php $
	$Revision: 725 $

	Copyright (C) No Parking 2010 - 2011
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Propositions extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_propositions"
		);
	}

	function tearDown() {
		$this->truncateTables("devinfrance_propositions");
	}

	function test_delete() {
		$proposition = new Devinfrance_Proposition();
		$proposition->content = "Nom";
		$proposition->title = "Titre";
		$proposition->insert();
				
		$proposition = new Devinfrance_Proposition();
		$proposition->content = "Nom";
		$proposition->title = "Titre";
		$proposition->insert();
				
		$propositions = new Devinfrance_Propositions();
		$propositions->id = $proposition->id;
		$propositions->delete();
		
		$propositions = new Devinfrance_Propositions();
		$propositions->select();
		$this->assertEqual(count($propositions), 1);

		$propositions = new Devinfrance_Propositions();
		$propositions->delete();
		
		$propositions = new Devinfrance_Propositions();
		$propositions->select();
		$this->assertEqual(count($propositions), 0);
	}
	
	function test_show() {
		$propositions = new Devinfrance_Propositions();
		$this->assertNoPattern("/propositions/", $propositions->show(null,null));
		
		$proposition = new Devinfrance_Proposition();
		$proposition->content = "Nom";
		$proposition->title = "Titre";
		$proposition->insert();
		
		$propositions->select();
		
		$this->assertPattern("/id=".$proposition->id."/", $propositions->show(null,null));
	}
	
	function test_found_rows() {
		$proposition_1 = new Devinfrance_Proposition();
		$proposition_1->content = "Nom1";
		$proposition_1->title = "Titre";
		$proposition_1->insert();
		
		$proposition_2 = new Devinfrance_Proposition();
		$proposition_2->content = "Nom2";
		$proposition_2->title = "Titre";
		$proposition_2->insert();

		$propositions = new Devinfrance_Propositions();
		$propositions->calc_found_rows(true);
		$propositions->set_limit(3, 0);
		$propositions->select();
		$this->assertEqual($propositions->found_rows(), 2);
		$this->assertEqual(count($propositions), 2);
	}

	function test_select__avec_order_by_date_insert() {
		$proposition_1 = new Devinfrance_Proposition();
		$proposition_1->content = "Nom";
		$proposition_1->title = "Titre";
		$proposition_1->insert();
		
		sleep(2);
		
		$proposition_2 = new Devinfrance_Proposition();
		$proposition_2->content = "Nom";
		$proposition_2->title = "Titre";
		$proposition_2->insert();
		
		$propositions = new Devinfrance_Propositions();
		$propositions->select();
		$this->assertEqual($propositions[0]->id, $proposition_1->id);
		
		$propositions->set_order("date_insert", "DESC");
		$propositions->select();
		$this->assertEqual($propositions[0]->id, $proposition_2->id);
	}

	function test_select() {
		$proposition = new Devinfrance_Proposition();
		$proposition->content = "Nom";
		$proposition->title = "Titre";
		$proposition->insert();

		$propositions = new Devinfrance_Propositions();
		$this->assertTrue($propositions->select());
		$this->assertEqual(count($propositions), 1);
	}
	
	function test_select__avec_limit() {
		for ($i = 1; $i <= 10; $i++) {
			$proposition = new Devinfrance_Proposition();
			$proposition->content = "Nom";
			$proposition->title = "Titre";
			$proposition->insert();
		}
		
		$propositions = new Devinfrance_Propositions();
		$propositions->set_limit(5, 0);
		$this->assertTrue($propositions->select());
		$this->assertEqual(count($propositions), 5);

		$propositions->set_limit(15, 0);
		$this->assertTrue($propositions->select());
		$this->assertEqual(count($propositions), 10);
	}
}
