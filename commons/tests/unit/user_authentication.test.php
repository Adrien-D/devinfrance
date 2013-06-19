<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/tests/unit/absence_credit.test.php $
	$Revision: 5265 $

	Copyright (C) No Parking 2012 - 2013
*/

require_once dirname(__FILE__)."/../inc/require.inc.php";

class tests_Commons_User_Authentication extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"commons_users"
		);
	}
	
	function test_session_headers() {
		$user = new Commons_User();
		$user->email = "perrick@noparking.net";
		$user->password = "password";
		$user->save();
		$user->activate();
		
		$authentication = new Commons_User_Authentication();
		$this->assertTrue($authentication->is_authorized("perrick@noparking.net", "password"));
		$this->assertTrue(is_array($authentication->session_headers()));

		$this->truncateTables("commons_users");
	}
	
	function test_is_authorized() {
		$authentication = new Commons_User_Authentication();
		$this->assertFalse($authentication->is_authorized("email", "mot de passe"));
		
		$user = new Commons_User();
		$user->email = "perrick@noparking.net";
		$user->password = "password";
		$user->save();
		$user->activate();
		
		$this->assertTrue($authentication->is_authorized("perrick@noparking.net", "password"));
		
		$this->truncateTables("commons_users");
	}

	function test_form() {
		$authentication = new Commons_User_Authentication();
		$this->assertPattern("/authentication\[email\].*type=\"email\"/", $authentication->form());
		$this->assertPattern("/authentication\[password\].*type=\"password\"/", $authentication->form());
	}

		function test_login_link() {
		$authentication = new Commons_User_Authentication();
		$this->assertPattern("/".__("authentication")."/", $authentication->login_link());
		$this->assertPattern("/autre nom/", $authentication->login_link("autre nom"));
	}
	
	function test_lost_password_link() {
		$authentication = new Commons_User_Authentication();
		$this->assertPattern("/".__('Forgot your password ?')."/", $authentication->lost_password_link());
		$this->assertPattern("/autre nom/", $authentication->lost_password_link("autre nom"));
	}
	
	function test_lost_password_form() {
		$authentication = new Commons_User_Authentication();
		$this->assertPattern("/password\[email\].*type=\"email\"/", $authentication->lost_password_form());
	}
}
