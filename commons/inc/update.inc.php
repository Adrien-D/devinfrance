<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/update.inc.php $
	$Revision: 800 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_Update {
	public $config;
	public $param;
	
	function __construct(db $db = null) {
		if ($db === null) {
			$db = new db();
		}
		$this->db = $db;
		$this->config = new Config_File(dirname(__FILE__)."/../cfg/config.inc.php", "config");
		$this->param = new Config_File(dirname(__FILE__)."/../cfg/param.inc.php", "param");
		$this->dbconfig = new Config_File(dirname(__FILE__)."/../cfg/config.inc.php", "dbconfig");
	}

	function to_7() {
		$this->param->add("commons_opentime_medias_url", "");
	}
	
	function to_6() {
		$this->param->add("commons_racaptcha_active", "0");
		$this->param->add("commons_racaptcha_private_key", "");	
		$this->param->add("commons_racaptcha_public_key", "");	
	}
	
	function to_5() {
		$this->param->add("commons_password_salt", "faDER68sNuGs+rip98ern~leYscARe99slAM*");
		$this->param->add("commons_password_loop", "200");
		
		$GLOBALS['param']['commons_password_loop'] = 200;
		$GLOBALS['param']['commons_password_salt'] = "faDER68sNuGs+rip98ern~leYscARe99slAM*";
		
		$user = new Commons_User;
		list($records) = $this->db->query("SELECT id, password FROM ".$this->db->config['table_commons_users']);
		while ($record = $this->db->fetchArray($records)) {
			$hash = $user->secure_password($record['password']);
			$this->db->query("
				UPDATE ".$this->db->config['table_commons_users']."
				SET password = ".$this->db->quote($hash)."
				WHERE id = ".(int)$record['id']
			);
		};
	}
	
	function to_4() {
		$this->param->add("commons_app_name", "Application Commons");
		$this->param->add("commons_app_email", "contact@noparking.net");
	}

	function to_3() {
		$this->db->query("
			ALTER TABLE ".$this->db->config['table_commons_users']." ADD `activated` tinyint(4) NOT NULL DEFAULT '0' AFTER `password`;
		");
		$this->db->query("
			ALTER TABLE ".$this->db->config['table_commons_users']." ADD `date_insert` int(10) unsigned NOT NULL default '0' AFTER `activated`;
		");
		$this->db->query("
			ALTER TABLE ".$this->db->config['table_commons_users']." ADD `date_update` int(10) unsigned NOT NULL default '0' AFTER `date_insert`;
		");
	}

	function to_2() {
		$this->db->query("
			ALTER TABLE ".$this->db->config['table_commons_users']." DROP `twitter`;
		");
	}

	function to_1() {
		$this->config->add("commons_version", 0);
	}
	
	function current() {
		$values = $this->config->values();
		return $values['config']['commons_version'];
	}

	function last() {
		$last = 0;
		$methods = get_class_methods($this);
		foreach ($methods as $method) {
			if (preg_match("/^to_[0-9]*$/", $method)) {
				$last = max($last, (int)substr($method, 3));
			}
		}
		return $last;
	}

	function config($key, $value) {
		$values = array('config' => $this->config->values());
		$values['config']['config'][$key] = $value;
		
		return $this->config->update($values);
	}
}
