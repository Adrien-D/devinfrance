<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/tests/unit/account.test.php $
	$Revision: 650 $

	Copyright (C) No Parking 2012 - 2013
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Author extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_authors"
		);
	}
	
	function tearDown() {
		$this->truncateTables(
			"devinfrance_authors"
		);
	}
	
	function test_load() {
		$author = new Devinfrance_Author();
		$author->name = "Nom de l'auteur";
		$author->description = "Description de l'auteur";
		$author->url = "http://url.de.auteur/";
		$author->insert();
		$id = $author->id;

		$loaded_author = new Devinfrance_Author();
		$this->assertEqual($loaded_author->id, 0);

		$this->assertTrue($loaded_author->load(array('id' => $id)));
		$this->assertEqual($loaded_author->name, $author->name);
		$this->assertEqual($loaded_author->description, $author->description);
		$this->assertEqual($loaded_author->url, $author->url);
		$this->assertTrue($loaded_author->date_insert <= time());
		$this->assertTrue($loaded_author->date_insert > 0);
		$this->assertTrue($loaded_author->date_update >= 0);
		
		sleep(2);
		
		$author->update();
		$this->assertTrue($loaded_author->load(array('id' => $id)));
		$this->assertTrue($loaded_author->date_insert > 0);
		$this->assertTrue($loaded_author->date_update > $loaded_author->date_insert);
		
		$this->assertFalse($loaded_author->load(array('id' => 42)));
	}

	function test_delete() {
		$author = new Devinfrance_Author();
		$author->name = "Nom";
		$author->description = "Description";
		$author->url = "htt://url.noparking.net/";
		$author->insert();

		$author->delete();
	}
		
	function test_update() {
		$author = new Devinfrance_Author();
		$author->name = "noparking";
		$author->description = "perrick";
		$author->url = "http://url.noparking.net/";
		$this->assertTrue($author->insert());
		$this->assertEqual($author->id, 1);

		$this->assertTrue($author->update());
		$this->assertEqual($author->id, 1);
	}
	
	function test_insert() {
		$author = new Devinfrance_Author();
		$author->name = "noparking";
		$author->description = "perrick";
		$author->url = "http://url.noparking.net/";
		$this->assertTrue($author->insert());
		$this->assertEqual($author->id, 1);

		$this->assertTrue($author->insert());
		$this->assertEqual($author->id, 2);
		
		$author = new Devinfrance_Author();
		$author->name = "noparking";
		$author->description = "perrick";
		$author->url = "http://url.noparking.net/";
		$this->assertTrue($author->insert());
		$this->assertEqual($author->id, 3);
	}
}
