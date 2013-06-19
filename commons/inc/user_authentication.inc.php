<?php
/*
	application commons
	$Author: frank $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/user_authentication.inc.php $
	$Revision: 5425 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_User_Authentication {
	public $user_id;

	protected $errors = array();
	protected $show_errors = false;
	
	function __construct(db $db = null) {
		if ($db === null) {
			$db = new db();
		}

		$this->db = $db;
	}
	
	function show_errors($bool) {
		$this->show_errors = $bool;
	}

	function add_error($key, $value) {
		$this->errors[$key][] = $value;
	}
	
	function display_errors() {
		if (count($this->errors) > 0) {
			$display = "";
			foreach ($this->errors as $errors) {
				$display .= join("</li><li>", $errors);
			}
			return "<div class=\"errors\"><ul><li>".$display."</li></ul></div>";
		} else {
			return "";
		}
	}
	
	function form() {
		$email = new Html_Input("authentication[email]", "", "email");
		$password = new Html_Input("authentication[password]", "", "password");
		$login = new Html_Input_Save("return", __("Log in"));
		
		$list = array(
			'email' => array(
				'class' => "itemsform-head itemsform-bold clearfix",
				'value' => $email->item(__("Email")),
			),
			'password' => array(
				'class' => "itemsform-head-bottom itemsform-bold clearfix",
				'value' => $password->item(__("Password")),
			),
			'login' => array(
				'class' => "itemsform-submit clearfix",
				'value' => $login->input(),
			),
			'lost_password' => array(
				'class' => "clearfix",
				'value' => $this->lost_password_link(),
			),
		);
		
		if ($this->show_errors) {
			foreach ($this->errors as $key => $values) {
				if (isset($list[$key])) {
					$list[$key]['class'] .= " error";
				}
			}
		}
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
		
		return "<form method=\"post\" name=\"commons_user_login\" id=\"commons_user_login\" action=\"\" enctype=\"multipart/form-data\">"
			.$this->display_errors().$items->show()
			."</form>";
	}

	function is_authorized($email, $password) {
		$result = $this->db->query("
			SELECT id, email, password	
			FROM ".$this->db->config['table_commons_users']."
			WHERE email = ".$this->db->quote($email)."
			AND activated = 1
			LIMIT 0, 1"
		);
	
		if ($result[1] == 1) {
			$row = $this->db->fetchArray($result[0]);
			
			$this->user_id = $row['id'];
			$user = new Commons_User();
			if ($user->valid_password($password, $row['password'])) {
				return true;
			}
		} 
		error_status(__("authentication")." -> ".__("email and password don't match"));
		return false;
	}
	
	function is_signed_in($session) {
		if (isset($session['commons_users']['id'])) {
			$this->user_id = (int)$session['commons_users']['id'];
			return true;
		} else {
			return false;
		}
	}

	function session_headers() {
		$session = false;
		if ($this->user_id > 0) {
			$user = new Commons_User();
			if ($user->load(array('id' => $this->user_id))) {
				$session = array(
					'commons_users' => array(
						'id' => $user->id,
						'email' => $user->email,
						'firstname' => $user->firstname,
						'lastname' => $user->lastname,
					),		
				);
			}
		}

		return $session;
	}

	function login_link($string = null) {
		if (!isset($string)) {
			$string = __("authentication");
		}
		return Html_Tag::a(Commons_Page::url("login.php"), $string);
	}	
	
	function lost_password_link($string = null) {
		if (!isset($string)) {
			$string = __("Forgot your password ?");
		}
		return Html_Tag::a(Commons_Page::url("lost_password.php"), $string);
	}

	function lost_password_form() {
		$email = new Html_Input("password[email]", "", "email");
		$login = new Html_Input_Save("return", __("Send"));
		
		$list = array(
			'email' => array(
				'class' => "itemsform-head itemsform-bold clearfix",
				'value' => $email->item(__("Email")),
			),
			'login' => array(
				'class' => "itemsform-submit",
				'value' => $login->input(),
			),
		);
		
		if ($this->show_errors) {
			foreach ($this->errors as $key => $values) {
				if (isset($list[$key])) {
					$list[$key]['class'] .= " error";
				}
			}
		}
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
		
		return "<form method=\"post\" name=\"commons_lost_password\" id=\"commons_lost_password\" action=\"\" enctype=\"multipart/form-data\">"
			.$this->display_errors().$items->show()
			."</form>";		
	}
}
