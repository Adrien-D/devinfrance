<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/tests/unit/account.test.php $
	$Revision: 650 $

	Copyright (C) No Parking 2012 - 2012
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Proposition extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_propositions"
		);
	}
	
	function tearDown() {
		$this->truncateTables(
			"devinfrance_propositions"
		);
	}
	
	function test_load() {
		$proposition = new Devinfrance_Proposition();
		$proposition->title = "Titre de la proposition";
		$proposition->content = "Contenu de la proposition";
		$proposition->url = "http://url.de.la.proposition/";
		$proposition->authors_id = 0;
		$proposition->insert();
		$id = $proposition->id;

		$loaded_proposition = new Devinfrance_Proposition();
		$this->assertEqual($loaded_proposition->id, 0);

		$this->assertTrue($loaded_proposition->load(array('id' => $id)));
		$this->assertEqual($loaded_proposition->title, $proposition->title);
		$this->assertEqual($loaded_proposition->content, $proposition->content);
		$this->assertEqual($loaded_proposition->authors_id, $proposition->authors_id);
		$this->assertTrue($loaded_proposition->date_insert <= time());
		$this->assertTrue($loaded_proposition->date_insert > 0);
		$this->assertTrue($loaded_proposition->date_update >= 0);
		
		sleep(2);
		
		$proposition->update();
		$this->assertTrue($loaded_proposition->load(array('id' => $id)));
		$this->assertTrue($loaded_proposition->date_insert > 0);
		$this->assertTrue($loaded_proposition->date_update > $loaded_proposition->date_insert);
		
		$this->assertFalse($loaded_proposition->load(array('id' => 42)));
	}

	function test_delete() {
		$proposition = new Devinfrance_Proposition();
		$proposition->title = "Titre";
		$proposition->content = "Contentu";
		$proposition->url = "htt://url.noparking.net/";
		$proposition->insert();

		$proposition->delete();
	}
		
	function test_update() {
		$proposition = new Devinfrance_Proposition();
		$proposition->title = "noparking";
		$proposition->content = "perrick";
		$proposition->url = "http://url.noparking.net/";
		$this->assertTrue($proposition->insert());
		$this->assertEqual($proposition->id, 1);

		$proposition->content = "voici mon message bis";
		$this->assertTrue($proposition->update());
		$this->assertEqual($proposition->id, 1);
	}
	
	function test_insert() {
		$proposition = new Devinfrance_Proposition();
		$proposition->title = "noparking";
		$proposition->content = "perrick";
		$proposition->url = "http://url.noparking.net/";
		$this->assertTrue($proposition->insert());
		$this->assertEqual($proposition->id, 1);

		$proposition->content = "03 20 06 51 26";
		$this->assertTrue($proposition->insert());
		$this->assertEqual($proposition->id, 2);
		
		$proposition = new Devinfrance_Proposition();
		$proposition->title = "noparking";
		$proposition->content = "perrick";
		$proposition->url = "http://url.noparking.net/";
		$this->assertTrue($proposition->insert());
		$this->assertEqual($proposition->id, 3);
	}
}
