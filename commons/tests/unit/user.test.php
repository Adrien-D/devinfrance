<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/tests/unit/absence_credit.test.php $
	$Revision: 5265 $

	Copyright (C) No Parking 2012 - 2013
*/

require_once dirname(__FILE__)."/../inc/require.inc.php";

class tests_Commons_User extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"commons_users"
		);
	}
	
	function test_clean() {
		$user = new Commons_User();
		
		$post = array(
			'email' => "perrick@NOparking.net",
		);
		$cleaned_post = $user->clean($post);
		$this->assertEqual($cleaned_post['email'], "perrick@noparking.net");

		$post = array(
			'firstname' => "PERRICK",
			'lastname' => "penet-avez"
		);
		$cleaned_post = $user->clean($post);
		$this->assertEqual($cleaned_post['firstname'], "Perrick");
		$this->assertEqual($cleaned_post['lastname'], "Penet-Avez");
	}

	function test_confirm_with_token() {
		$user = new Commons_User();
		$user->email = "perrick@noparking.net";
		$user->firstname = "Perrick";
		$user->lastname = "Penet-Avez";
		$user->save();
		
		$user_confirmation = new Commons_User();
		$this->assertFalse($user_confirmation->confirm_with_token(uniqid()));
		$this->assertEqual($user_confirmation->id, 0);
		$this->assertTrue($user_confirmation->confirm_with_token($user->token()));
		$this->assertEqual($user_confirmation->id, $user->id);
		
		$this->truncateTables("commons_users");
	}

	function test_load() {
		$user = new Commons_User();
		$user->email = "perrick@noparking.net";
		$user->save();
		
		$user_loaded = new Commons_User();
		$user_loaded->load(array('id' => $user->id));
		$this->assertTrue($user_loaded->date_insert > 0);
		$this->assertTrue($user_loaded->date_update >= $user_loaded->date_insert);
		
		sleep(1);
		
		$user->firstname = "perrick";
		$user->lastname = "penet-avez";
		$user->save();
		
		$user_loaded = new Commons_User();
		$user_loaded->load(array('id' => $user->id));
		$this->assertTrue($user_loaded->date_insert > 0);
		$this->assertTrue($user_loaded->date_update > $user_loaded->date_insert);
		
		$this->truncateTables("commons_users");
	}

	function test_is_ok_to_be_saved() {
		$user = new Commons_User();
		$user->email = "perrick@noparking.net";
		$user->save();
		$this->assertTrue($user->is_ok_to_be_saved());
		
		$user_new = new Commons_User();
		$user_new->email = "perrick@noparking.net";
		$this->assertFalse($user_new->is_ok_to_be_saved());
		
		$this->truncateTables("commons_users");
	}
	
	function test_form() {
		$user = new Commons_User();
		
		$this->assertPattern("/user\[email\].*type=\"email\"/", $user->form());
		$this->assertPattern("/user\[firstname\]/", $user->form());
		$this->assertPattern("/user\[lastname\]/", $user->form());
		$this->assertPattern("/user\[password\].*type=\"password\"/", $user->form());
		$this->assertPattern("/user\[password_again\].*type=\"password\"/", $user->form());
	}

	function test_save() {
		$user = new Commons_User();
		$user->email = "perrick@noparking.net";
		$this->assertEqual($user->id, 0);
		$this->assertTrue($user->save());
		$this->assertEqual($user->id, 1);
		
		$user->firstname = "Perrick";
		$this->assertTrue($user->save());
		
		$this->truncateTables("commons_users");
	}
	
	function test_update() {
		$user = new Commons_User();
		$user->email = "perrick@noparking.net";
		$user->insert();
		
		sleep(1);
		
		$user->firstname = "Perrick";
		$this->assertTrue($user->update());
		
		$user->load(array('id' => $user->id));
		
		$this->truncateTables("commons_users");
		
	}
	
	function test_insert() {
		$user = new Commons_User();
		$user->email = "perrick@noparking.net";
		$this->assertEqual($user->id, 0);
		$this->assertTrue($user->is_insertable());
		$this->assertTrue($user->insert());
		$this->assertEqual($user->id, 1);
		
		$this->truncateTables("commons_users");
	}
	
	function test_valid_password() {
		$user = new Commons_User();
		$secure = $user->secure_password('monmotdepass');
		$this->assertTrue($user->valid_password('monmotdepass', $secure));
		$this->assertFalse($user->valid_password('monmotdepas	', $secure));
		$this->assertFalse($user->valid_password('monmotdepass', 'badHash'));
	}
	
	function test_generate_password() {
		$user = new Commons_User;
		$this->assertEqual(mb_strlen($user->generate_password()), 8);
		$this->assertEqual(mb_strlen($user->generate_password(12)), 12);
	}
}
