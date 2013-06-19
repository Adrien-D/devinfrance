<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/devinfrance/inc/update.inc.php $
	$Revision: 800 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Update {
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
	
	function to_19() {
		$this->param->free("nb_records_home");
		$this->param->add("devinfrance_nb_records", 5);
	}
	
	function to_18() {
		$this->param->add("devinfrance_goal", 50);
	}
	
	function to_17() {
		$this->param->add("devinfrance_goal", "50");
	}
	
	function to_16() {
		$this->param("devinfrance_uri", "http://devinfrance.fr/");
	}
	
	function to_15() {
		$this->db->query("ALTER TABLE `devinfrance_votes` CHANGE `value` `value` INT(11) NULL DEFAULT '0';");
	}
	
	function to_14() {
		$this->db->query("ALTER TABLE `devinfrance_votes` CHANGE `ip` `remote_address` varchar(255) NOT NULL DEFAULT '';");
	}
	
	function to_13() {
		$this->param->add("nb_records_home", 5);
	}
	
	function to_12() {
		$this->db->query("CREATE TABLE devinfrance_votes (
				id int(11) NOT NULL AUTO_INCREMENT,
				ip int(11) NOT NULL,
				propositions_id varchar(255) NOT NULL DEFAULT '',
				value varchar(255) NOT NULL DEFAULT '',
				date_insert int(10) unsigned NOT NULL default '0',
				date_update int(10) unsigned NOT NULL default '0',
				PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->dbconfig->add("table_devinfrance_votes", "devinfrance_votes");
	}
	
	function to_11() {
		$this->db->query("CREATE TABLE devinfrance_typeresult (
				id int(11) NOT NULL AUTO_INCREMENT,
				sites_id int(11) NOT NULL,
				family varchar(255) NOT NULL DEFAULT '',
				value varchar(255) NOT NULL DEFAULT '',
				count int(11) DEFAULT 0,
				date_insert int(10) unsigned NOT NULL default '0',
				date_update int(10) unsigned NOT NULL default '0',
				PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->dbconfig->add("table_devinfrance_typeresult", "devinfrance_typeresult");
	}
	
	function to_10() {
		$this->param->add("devinfrance_uri", "http://devinfrance.local/");
	}
	
	function to_9() {
		$this->db->query("ALTER TABLE `devinfrance_files` CHANGE `date_updated` `date_update` int(10) unsigned NOT NULL default '0';");
		$this->db->query("ALTER TABLE `devinfrance_files` CHANGE `date_inserted` `date_insert` int(10) unsigned NOT NULL default '0';");
		
		$this->db->query("ALTER TABLE `devinfrance_propositions` CHANGE `date_updated` `date_update` int(10) unsigned NOT NULL default '0';");
		$this->db->query("ALTER TABLE `devinfrance_propositions` CHANGE `date_inserted` `date_insert` int(10) unsigned NOT NULL default '0';");
		
		$this->db->query("ALTER TABLE `devinfrance_results` CHANGE `date_updated` `date_update` int(10) unsigned NOT NULL default '0';");
		$this->db->query("ALTER TABLE `devinfrance_results` CHANGE `date_inserted` `date_insert` int(10) unsigned NOT NULL default '0';");
		
		$this->db->query("ALTER TABLE `devinfrance_sites` CHANGE `date_updated` `date_update` int(10) unsigned NOT NULL default '0';");
		$this->db->query("ALTER TABLE `devinfrance_sites` CHANGE `date_inserted` `date_insert` int(10) unsigned NOT NULL default '0';");
		
		$this->db->query("ALTER TABLE `devinfrance_propositions` CHANGE `author` `authors_id` int(11) NOT NULL;");
	}
	
	function to_8() {
		$this->db->query("ALTER TABLE `devinfrance_authors` CHANGE `author` `name` varchar(255) NOT NULL DEFAULT '';");
		$this->db->query("ALTER TABLE `devinfrance_authors` ADD `description` mediumtext NOT NULL DEFAULT '' AFTER `name`;");
		$this->db->query("ALTER TABLE `devinfrance_authors` ADD `url` varchar(255) NOT NULL  AFTER `description`;");
	}
	
	function to_7() {
		$this->db->query("ALTER TABLE `devinfrance_authors` ADD `description` mediumtext NOT NULL DEFAULT '' AFTER `name`;");
		$this->db->query("ALTER TABLE `devinfrance_authors` ADD `url` varchar(255) NOT NULL  AFTER `description`;");
	}
	
	function to_6() {
		$this->param->add("devinfrance_noparking_ip", "188.165.109.102");
	}
	
	function to_5() {
		$this->db->query("CREATE TABLE devinfrance_authors (
				id int(21) NOT NULL AUTO_INCREMENT,
				author varchar(255) NOT NULL DEFAULT '',
				date_insert int(10) unsigned NOT NULL default '0',
				date_update int(10) unsigned NOT NULL default '0',
				PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->dbconfig->add("table_devinfrance_authors", "devinfrance_authors");
	}
	
	function to_4() {
		$this->param->add("devinfrance_opentime_medias_url", "http://medias.opentime.fr/");
	}
	
	function to_3() {
		$this->db->query("CREATE TABLE devinfrance_hits (
		  `id` int(21) NOT NULL AUTO_INCREMENT,
		  `unique_id` varchar(255) NOT NULL,
		  `cookie` varchar(255) NOT NULL,
		  `http_user_agent` varchar(255) NOT NULL,
		  `referer` varchar(255) NOT NULL,
		  `remote_address` varchar(255) NOT NULL,
		  `uri` varchar(255) NOT NULL,
		  `date_insert` int(10) unsigned NOT NULL default '0',
		  `date_update` int(10) unsigned NOT NULL default '0',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$this->dbconfig->add("table_devinfrance_hits", "devinfrance_hits");
		$this->db->query("ALTER TABLE `devinfrance_hits` ADD `delay` float(9,4) NULL DEFAULT NULL  AFTER `uri`;");
	}
	
	function to_2() {
		$this->db->query("CREATE TABLE devinfrance_propositions (
		  id INT(11) NOT NULL AUTO_INCREMENT,
		  title mediumtext NOT NULL DEFAULT '',
		  content mediumtext NOT NULL DEFAULT '',
		  author varchar(255) NOT NULL DEFAULT '',
		  url varchar(255) NOT NULL DEFAULT '',
		  date_inserted INT(10) NOT NULL DEFAULT '0',
		  date_updated INT(10) NOT NULL DEFAULT '0',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;");
		$this->dbconfig->add("table_devinfrance_propositions", "devinfrance_propositions");
	}

	function to_1() {
		$this->config->add("version", 0);
	}
	
	function current() {
		$values = $this->config->values();
		return $values['config']['version'];
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
	
	function param($key, $value) {
		$values = array('param' => $this->param->values());
		$values['param']['param'][$key] = $value;
	
		return $this->param->update($values);
	}
}
