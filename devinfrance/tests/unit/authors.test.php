<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/tests/unit/questions.test.php $
	$Revision: 725 $

	Copyright (C) No Parking 2012 - 2013
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Authors extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_authors"
		);
	}

	function tearDown() {
		$this->truncateTables("devinfrance_authors");
	}

	function test_delete() {
		$author = new Devinfrance_Author();
		$author->name = "Nom";
		$author->description = "Description";
		$author->url = "http://url.author.fr";
		$author->insert();
						
		$author = new Devinfrance_Author();
		$author->name = "Nom";
		$author->description = "Description";
		$author->url = "http://url.author.fr";
		$author->insert();
		
		$authors = new Devinfrance_Authors();
		$authors->id = $author->id;
		$authors->delete();
		
		$authors = new Devinfrance_Authors();
		$authors->select();
		$this->assertEqual(count($authors), 1);

		$authors = new Devinfrance_Authors();
		$authors->delete();
		
		$authors = new Devinfrance_Authors();
		$authors->select();
		$this->assertEqual(count($authors), 0);
	}
	
	function test_show() {
		$authors = new Devinfrance_Authors();
		$this->assertNoPattern("/authors/", $authors->show());
		
		$author = new Devinfrance_Author();
		$author->name = "Nom";
		$author->description = "Description";
		$author->insert();
		
		$authors->select();
		
		$this->assertPattern("/Nom/", $authors->show());
	}
	
	function test_found_rows() {
		$author_1 = new Devinfrance_Author();
		$author_1->name = "Nom1";
		$author_1->description = "Description";
		$author_1->insert();
		
		$author_2 = new Devinfrance_Author();
		$author_2->name = "Nom2";
		$author_2->description = "Description";
		$author_2->insert();

		$authors = new Devinfrance_Authors();
		$authors->calc_found_rows(true);
		$authors->set_limit(3, 0);
		$authors->select();
		$this->assertEqual($authors->found_rows(), 2);
		$this->assertEqual(count($authors), 2);
	}

	function test_select__avec_order_by_date_insert() {
		$author_1 = new Devinfrance_Author();
		$author_1->name = "Nom";
		$author_1->description = "Description";
		$author_1->insert();
		
		sleep(2);
		
		$author_2 = new Devinfrance_Author();
		$author_2->name = "Nom";
		$author_2->description = "Description";
		$author_2->insert();
		
		$authors = new Devinfrance_Authors();
		$authors->select();
		$this->assertEqual($authors[0]->id, $author_1->id);
		
		$authors->set_order("date_insert", "DESC");
		$authors->select();
		$this->assertEqual($authors[0]->id, $author_2->id);
	}

	function test_select() {
		$author = new Devinfrance_Author();
		$author->name = "Nom";
		$author->description = "Description";
		$author->insert();

		$authors = new Devinfrance_Authors();
		$this->assertTrue($authors->select());
		$this->assertEqual(count($authors), 1);
	}
	
	function test_select__avec_limit() {
		for ($i = 1; $i <= 10; $i++) {
			$author = new Devinfrance_Author();
			$author->name = "Nom";
			$author->description = "Description";
			$author->insert();
		}
		
		$authors = new Devinfrance_Authors();
		$authors->set_limit(5, 0);
		$this->assertTrue($authors->select());
		$this->assertEqual(count($authors), 5);

		$authors->set_limit(15, 0);
		$this->assertTrue($authors->select());
		$this->assertEqual(count($authors), 10);
	}
}
