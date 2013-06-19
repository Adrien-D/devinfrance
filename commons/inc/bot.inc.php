<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/bot.inc.php $
	$Revision: 816 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_Bot {
	public $directory_cfg = "";
	
	function __construct(db $db = null) {
		if ($db === null) {
			$db = new db();
		}
		$this->db = $db;
		$this->directory_cfg = dirname(__FILE__)."/../../cfg";
	}
	
	function help() {
		$help = __("Methods available with Commons_Bot:")."\n";
		$ReflectionClass = new ReflectionClass("Commons_Bot");
		foreach ($ReflectionClass->getMethods() as $method) {
			if (!in_array($method->getName(), array("help", "__construct"))) {
				$help .= "--".$method->getName()."\n";
			}
		}

		return $help;
	}
	
	function reinstall_database() {
		$this->uninstall_database();
		return $this->install_database();
	}

	function install_database() {
		$queries = array();
		$db = new db();
		require dirname(__FILE__)."/../../../devinfrance/sql/content.sql.php";
		require dirname(__FILE__)."/../sql/content.sql.php";
		$this->db->initialize($queries);
		return true;
	}
	
	function uninstall_database() {
		$db = new db();
                $tables = array();
                foreach ($GLOBALS['dbconfig'] as $parameter => $table) {
                        if (substr($parameter, 0, 6) == 'table_') {
                                $tables[] = $table;
                        }
                }
                $db->query("DROP TABLE IF EXISTS ".join(", ", $tables));
		return true;
	}
	
	function update() {
		$this->update_svn();
		$this->update_application();
		return true;
	}
	
	function update_svn() {
		return exec("svn up ".realpath(dirname(__FILE__)."/../../../"));
	}
	
	function update_application() {
		$update = new Commons_Update();
		$current = $update->current() + 1;
		$last = $update->last();

		for ($i = $current; $i <= $last; $i++) {
			if (method_exists($update, "to_".$i)) {
				$update->{"to_".$i}();
				$update->config("commons_version", $i);
			}
		}
	}
}
