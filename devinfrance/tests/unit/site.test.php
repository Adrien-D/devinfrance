<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/tests/unit/attachment.test.php $
	$Revision: 18 $

	Copyright (C) No Parking 2012 - 2012
*/

require_once dirname(__FILE__)."/../../../commons/tests/inc/require.inc.php";

class tests_Devinfrance_Site extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"devinfrance_sites"
		);
	}
        
        function test_is_visitable() {
                $site = new Devinfrance_site();
                $site->url = "https://devinfrance.fr";
                $this->assertTrue($site->is_visitable($site->url));
                $site->url = "http://asemus.museum/";
                $this->assertTrue($site->is_visitable($site->url));
                $site->url = "http://fr.www.devinfrance.com/";
                $this->assertTrue($site->is_visitable($site->url));
                $site->url = "http://www.devinfrance.fr/";
                $this->assertTrue($site->is_visitable($site->url));
                $site->url = "http://devinfrance.fr/";
                $this->assertTrue($site->is_visitable($site->url));
                $site->url = "http://devinfrance.fr";
                $this->assertTrue($site->is_visitable($site->url));
                $site->url = "http://devinfrance";
                $this->assertFalse($site->is_visitable($site->url));
                $site->url = "devinfrance";
                $this->assertFalse($site->is_visitable($site->url));
                $site->url = "devinfrance.fr";
                $this->assertFalse($site->is_visitable($site->url));
        }
	
	function test_load() {
		$site = new Devinfrance_Site();
		$site->url = "http://devinfrance.fr/";
		$site->name = "devinfrance.fr";
		$site->email = "email@devinfrance.fr";
		$site->visited = time();
		$site->insert();
		
		$site_loaded = new Devinfrance_Site();
		$site_loaded->load(array('id' => $site->id));
		$this->assertTrue($site_loaded->date_insert >= time());
		$this->assertEqual($site_loaded->date_update, $site_loaded->date_insert);
		
		$site->update();

		$site_loaded = new Devinfrance_Site();
		$site_loaded->load(array('id' => $site->id));
		$this->assertTrue($site_loaded->visited >= time());
		$this->assertTrue($site_loaded->date_insert >= time());
		$this->assertTrue($site_loaded->date_update >= $site_loaded->date_insert);
		$this->assertEqual($site_loaded->url, $site->url);
		$this->assertEqual($site_loaded->name, $site->name);
		$this->assertEqual($site_loaded->email, $site->email);
		
		$this->truncateTables("devinfrance_sites");
	}

	function test_update() {
		$site = new Devinfrance_Site();
		$site->url = "http://localhost/~perrick/devinfrance.fr/";
		$site->insert();
		
		$site->url = "http://localhost/~perrick/opentime.fr/";
		$this->assertTrue($site->update());
		$this->assertEqual($site->id, 1);
		
		$this->truncateTables("devinfrance_sites");
		
	}

	function test_insert() {
		$site = new Devinfrance_Site();
		$site->url = "http://localhost/~perrick/devinfrance.fr/";
		$site->visited = time();
		$this->assertTrue($site->insert());
		$this->assertEqual($site->id, 1);
		
		$this->truncateTables("devinfrance_sites");
	}
}
