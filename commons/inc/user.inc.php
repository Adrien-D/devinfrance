<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/contact_function.inc.php $
	$Revision: 4947 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_User extends Record {
	public $id;
	public $email = "";
	public $firstname = "";
	public $lastname = "";
	public $password = "";
	public $activated = 0;
	public $date_insert = 0;
	public $date_update = 0;

	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = $id;
	}
	
	function clean($post) {
		$cleaned = array();
		
		if (isset($post['id'])) {
			$cleaned['id'] = (int)$post['id'];
		}
		if (isset($post['email'])) {
			$cleaned['email'] = strtolower(strip_tags($post['email']));
		}
		if (isset($post['firstname'])) {
			$cleaned['firstname'] = ucfirst(strtolower(strip_tags($post['firstname'])));
		}
		if (isset($post['lastname'])) {
			$cleaned['lastname'] = ucfirst(strtolower(strip_tags($post['lastname'])));
		}
		if (isset($post['password'])) {
			$cleaned['password'] = $post['password'];
		}
		if (isset($post['activated'])) {
			$cleaned['activated'] = (int)$post['activated'];
		}
				
		return $cleaned;
	}

	function work_on_page(Commons_Page $page) {
		$this->page = $page;
	}
	
	function change_password() {
		$password = new Html_Input("user[password]", "", "password");
		$password_again = new Html_Input("user[password_again]", "", "password");
		$save = new Html_Input_Save("return");
		
		$list = array(
			'password' => array(
					'value' => $password->item(__("Password")),
			),
			'password_again' => array(
					'value' => $password_again->item(__("Password (again)")),
			),
			'save' => array(
					'class' => "itemsform-submit",
					'value' => $save->input(),
			),
		);
		
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
		
		return "<form method=\"post\" name=\"commons_user_change_password\" id=\"commons_user_change_password\" action=\"\" enctype=\"multipart/form-data\">"
			.$items->show()
			."</form>";
		
	}

	function show_captcha() {
		require_once('recaptcha/recaptchalib.php');
		$publickey = $GLOBALS['param']['commons_racaptcha_public_key'];
		return recaptcha_get_html($publickey);
	}
	
	function sign_in() {
		$email = new Html_Input("user[email]", $this->email, "email");
		$firstname = new Html_Input("user[firstname]", $this->firstname);
		$lastname = new Html_Input("user[lastname]", $this->lastname);
		$password = new Html_Input("user[password]", "", "password");
		$password_again = new Html_Input("user[password_again]", "", "password");
		$save = new Html_Input_Save("return", __("Sign in"));
		
		$list = array(
			'email' => array(
				'class' => "itemsform-head-bottom itemsform-bold clearfix",
				'value' => $email->item(__("Email")),
			),
			'firstname' => array(
				'value' => $firstname->item(__("Firstname")),
			),
			'lastname' => array(
				'value' => $lastname->item(__("Lastname")),
			),
			'password' => array(
				'value' => $password->item(__("Password")),
			),
			'password_again' => array(
				'value' => $password_again->item(__("Password (again)")),
			),
		);
		
		if ($GLOBALS['param']['commons_racaptcha_active'] == 1) {
			$list['captcha'] = array(
				'value' => $this->show_captcha(),
			);		
		} 
		
		$list['save'] = array(
			'class' => "itemsform-submit",
			'value' => $save->input(),
		);
		
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
		
		return "<form method=\"post\" name=\"commons_user_sign_in\" id=\"commons_user_sign_in\" action=\"\" enctype=\"multipart/form-data\">"
			.$items->show()
			."</form>";
	}

	function form() {
		$email = new Html_Input("user[email]", $this->email, "email");
		$firstname = new Html_Input("user[firstname]", $this->firstname);
		$lastname = new Html_Input("user[lastname]", $this->lastname);
		$password = new Html_Input("user[password]", "", "password");
		$password_again = new Html_Input("user[password_again]", "", "password");
		$save = new Html_Input_Save("return");

		$list = array(
			'email' => array(
				'class' => "itemsform-head-bottom itemsform-bold clearfix",
				'value' => $email->item(__("Email")),
			),
			'firstname' => array(
				'value' => $firstname->item(__("Firstname")),
			),
			'lastname' => array(
				'value' => $lastname->item(__("Lastname")),
			),
			'password' => array(
				'value' => $password->item(__("Password")),
			),
			'password_again' => array(
				'value' => $password_again->item(__("Password (again)")),
			),
			'save' => array(
				'class' => "itemsform-submit",
				'value' => $save->input(),
			), 
		);
		
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
		
		return "<form method=\"post\" name=\"commons_user_form\" id=\"commons_user_form\" action=\"\" enctype=\"multipart/form-data\">"
			.$items->show()
			."</form>";
	}
	
	function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			$parent = parent::load($this->db->config['table_commons_users'], $properties);
			$this->password = "";
			return $parent;
		} else {
			return false;			
		}
	}

	function thank() {
		return "<p class=\"success\">".
				__("A confirmtaion email was sent successfully. Don't forget to click on the link inside to activate your account. Thanks!").
				"</p>";
	}
	
	function apologize() {
		return "<p class=\"error\">".
				__("Sorry, something went wrong while sending your confirmation. We'll try to fix this as soon as possible...").
				"</p>";
	}
	
	function confirm_with_token($token) {
		$this->id = $this->db->getValue("
			SELECT ".$this->db->config['table_commons_users'].".id
			FROM ".$this->db->config['table_commons_users']."
			WHERE SHA1(CONCAT(".$this->db->config['table_commons_users'].".email, ".$this->db->config['table_commons_users'].".firstname, ".$this->db->config['table_commons_users'].".lastname)) = ".$this->db->quote($token)."
			LIMIT 0, 1"
		);
		
		if ($this->id > 0) {
			success_status(__("user")." -> ".__("confirmation OK"));
			return true;
		} else {
			error_status(__("user")." -> ".__("confirmation KO"));
			return false;
		}
	}

	function activate() {
		$this->load(array('id' => (int)$this->id));
		$this->activated = 1;
		return $this->save();
	}

	function send_email($subject, $body, $bcc = true, $html = false) {
		require_once dirname(__FILE__)."/../../../opentime/inc/phpmailer/class.phpmailer.php";
		
		$mail = new PHPMailer();
		if (!empty($GLOBALS['config']['email_smtp'])) {
			$mail->IsSMTP();
			$mail->Host = $GLOBALS['config']['email_smtp'];
			$mail->SMTPAuth = false;
		}
		$mail->CharSet = "utf-8";
		$mail->From = $GLOBALS['param']['commons_app_email'];
		$mail->FromName = $GLOBALS['param']['commons_app_name'];
		$mail->AddAddress($this->email);
		if($bcc == true) {
			$mail->AddBCC($GLOBALS['param']['commons_app_email']);		
		}
		$mail->AddBCC($GLOBALS['param']['commons_app_email']);
		$mail->WordWrap = $GLOBALS['param']['email_wrap'];
		$mail->IsHTML($html);
		$mail->Subject = $subject;
		$mail->Body = $body;
		return $mail->send();		
	}
	
	function send_new_password() {
		if($this->id > 0) {
			$password = $this->generate_password();
			$subject = __("Your new password %s", array($GLOBALS['param']['commons_app_name']));
			$body = __("Hello %s", array($this->firstname))."\n\n".
				__("Your new password is : %s", array($password))."\n\n".
				__("To connect you to % follow this link :", array($GLOBALS['param']['commons_app_name'])).
				$GLOBALS['param']['commons_web_url']."/".Commons_Page::url("login.php")."\n\n".
				__("The %s team", array($GLOBALS['param']['commons_app_name']))."\n".
				$GLOBALS['param']['commons_web_url'];
			$send = $this->send_email($subject, $body, false);
			if($send) {
				$this->password = $password;
				$this->save();	
				return true;
			}
		}
		return false;
	}
	
	function send_confirmation() {
		$subject = __("Confirmation email %s | %s", array($GLOBALS['param']['commons_app_name'], date("d/m/Y H:i")));
		$body = $this->body_confirmation();
		return $this->send_email($subject, $body);
	}
	
	function body_confirmation() {
		return __("Hello %s", array($this->firstname))."\n\n".
			__("Click below to confirm your email address.")."\n\n".
			$this->url_confirmation()."\n\n".
			__("And once you're logged in, you'll be able to edit your profile.")."\n\n".
			__("Thanks for using %s", array($GLOBALS['param']['commons_app_name']))."\n\n".
			__("The %s team", array($GLOBALS['param']['commons_app_name']))."\n".
			$GLOBALS['param']['commons_web_url'];
	}
	
	function generate_password($length = 8) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);

		for ($i = 0, $password = ""; $i < $length; $i++) {
			$index = rand(0, $count - 1);
			$password .= mb_substr($chars, $index, 1);
		}

		return $password;
	}

	
	function token() {
		return sha1($this->email.$this->firstname.$this->lastname); 
	}
	
	function url_confirmation() {
		return $GLOBALS['param']['commons_web_url'].$this->page->url("confirmation.php&token=".$this->token());
	}

	function is_ok_to_be_saved($with_captcha = true) {
		if ($this->email == "") {
			   error_status(__("email")." -> ".__("this field can not be empty"));
			   return false;			
		}
		
		if (!is_email($this->email)) {
				error_status(__("email")." -> ".__("format is invalid"));
				return false;
		}
		
		if ($this->firstname == "") {
			   error_status(__("firstname")." -> ".__("this field can not be empty"));
			   return false;			
		}
		
		if ($this->lastname == "") {
			   error_status(__("lastname")." -> ".__("this field can not be empty"));
			   return false;			
		}
		
		if ($GLOBALS['param']['commons_racaptcha_active'] == 1 and $with_captcha == true) {
			require_once('recaptcha/recaptchalib.php');
			
			$resp = recaptcha_check_answer(
				$GLOBALS['param']['commons_racaptcha_private_key'],
				$_SERVER["REMOTE_ADDR"],
				$_POST["recaptcha_challenge_field"],
				$_POST["recaptcha_response_field"]
			);
			if (!$resp->is_valid) {
			   error_status(__("captcha")." -> ".__("the captcha wasn't entered correctly"));
			   return false;
			}
		} 

		if (isset($this->password_again)) {
			if ($this->password != $this->password_again) {
				error_status(__("password")." -> ".__("differences exist"));
				return false;
			}
		}
		
		if ((int)$this->id == 0) {
			$user = new Commons_User();
			if ($user->load(array('email' => $this->email))) {
				error_status(__("email")." -> ".__("'%s' already taken", array($this->email)));
				return false;
			}
		}
		
		return true;
	}
	
	function delete() {
		if ((int)$this->id > 0) {
			list($result, $num) = $this->db->query("
				DELETE FROM ".$this->db->config['table_commons_users']."
				WHERE id = ".(int)$this->id
			);
			$this->db->status($num, "d", __("user"));
			return $result;

		} else {
			$this->db->status(-1, "d", __("user"));
			return false;
		}
	}

	function save() {
		if ($this->is_updatable()) {
			return $this->update();
		} else {
			return $this->insert();
		}
	}

	function is_updatable() {
		if ($this->id > 0 and $this->is_insertable()) {
			return true;
		} else {
			return false;
		}
	}

	function update() {
		if ($this->is_updatable()) {
			$query = "
				UPDATE ".$this->db->config['table_commons_users']."
				SET email = ".$this->db->quote($this->email).",
				firstname = ".$this->db->quote($this->firstname).",
				lastname = ".$this->db->quote($this->lastname).",
				activated = ".(int)$this->activated.",
				date_update = ".time();
			if (isset($this->password) and !empty($this->password)) {
				$query .= ", password = ".$this->db->quote($this->secure_password($this->password));
			}
			$query .= " WHERE id = ".(int)$this->id;
			list($result, $num) = $this->db->query($query);
			$this->db->status($num, "u", __("user"));
			return $result;

		} else {
			$this->db->status(-1, "u", __("user"));
			return false;
		}
	}
	
	function is_insertable() {
		if (empty($this->email)) {
			return false;
		} else {
			return true;
		}
	}

	function insert() {
		if ($this->is_insertable()) {
			$query = "
				INSERT INTO ".$this->db->config['table_commons_users']."
				SET email = ".$this->db->quote($this->email).",
				firstname = ".$this->db->quote($this->firstname).",
				lastname = ".$this->db->quote($this->lastname).",
				activated = ".(int)$this->activated.",
				date_update = ".time().",
				date_insert = ".time();
			if (isset($this->password) and !empty($this->password)) {
				$query .= ", password = ".$this->db->quote($this->secure_password($this->password));
			}
			
			list($result, $num, $this->id) = $this->db->getID($query);
			$this->db->status($num, "i", __("user"));
			return $result;

		} else {
			$this->db->status(-1, "i", __("user"));
			return false;
		}
	}
	
	function secure_password($password, $salt = null) {
		if (!$salt) {
			$salt = $GLOBALS['param']['commons_password_salt'];
		}
		$hash = "";
		for ($i = 0; $i < $GLOBALS['param']['commons_password_loop']; $i++) {
			$hash = hash("sha256", $hash.$salt.$password);
		}
		return base64_encode($salt)."$".$hash;
	}
	
	function valid_password($password, $hash) {
		$delimiter = strpos($hash, "$");
		if ($delimiter === false) {
			return false;
		}
		$salt = base64_decode(substr($hash, 0, $delimiter));
		$hash_recalculated = "";
		for ($i = 0; $i < $GLOBALS['param']['commons_password_loop']; $i++) {
			$hash_recalculated = hash("sha256", $hash_recalculated.$salt.$password);
		}	
		return (base64_encode($salt)."$".$hash_recalculated == $hash);
	}
}
