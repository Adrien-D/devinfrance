<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Result extends Record {
	public $id = 0;
	public $files_id = 0;
        public $name = "";
        public $value = "";
        public $day = 0;
        public $date_insert = "";
        public $date_update = "";
    
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = (int)$id;
		
	}
	
	function get_developers($value) {
		$Developers = "";
		$Numbers = "";
		$Numbers = explode (" ", $value);
		foreach ($Numbers as $key => $value) {
			if (preg_match("/développeur|developpeur|developer/", $value)) {
				$Developers .= $Numbers[$key-1];
			}
		}
		return $Developers;
	}
	
	function parse() {
		if (empty($this->value)) {
			return false;
		}
		$metier_type = array (
			"/développeur|developpeur|developer/" => "Développeur",
			"/gérant|gerant|Gerant|Gérant/" => "Gérant",
			"/marketing|marketeux/" => "Web-marketing",
			"/projet/" => "Chef de projet",
			"/community-manager/" => "Community-manager",
			"/integrateur|intégrateur/" => "Intégrateur"
		);
		$outils_type = array (
			"/PHP/" => "PHP",
			"/Mysql|MYSQL|MySQL|mysql/" => "MySQL",
			"/Ruby/" => "Ruby on Rails",
			"/Java|java/" => "Java",
			"/Jsp/" => "Jsp",
			"/Framework Struts2|framework struts2/" => "Framework Struts2",
			"/jQuery/" => "jQuery"
		);
		$standards_type = array (
			"/HTML5|html5/" => "HTML5",
			"/XHTML|xhtml/" => "XHTML",
			"/CSS3|css3/" => "CSS3"		
		);
		
		$value = "";
		$count = 0;
		$family = "";
		
		$elements = explode(",", $this->value);
		foreach ($elements as $key => $element) {
			if (preg_match("/Métier|Metier|metier|métier/", $this->name)) {
				$family = "Métiers";
				foreach ($metier_type as $regex => $name) {
					if (preg_match($regex, $element)) {
						$value = trim($name);
						$count = preg_replace("/[^0-9]/","",$element);
					} 
				}
			} else if (preg_match("/Outil|outil/", $this->name)) {
				$family = "Outils";
				$count = 0;
				foreach ($outils_type as $regex => $name) {
					if (preg_match($regex, $element)) {
						$value = trim($name);
						$count ++;
					}
				}
			} else if (preg_match("/Standard|standard/", $this->name)) {
				$family = "Standards";
				$count = 0;
				foreach ($standards_type as $regex => $name) {
					if (preg_match($regex, $element)) {
						$value = trim($name);
						$count ++;
					}
				}
			} else if (preg_match("/ville|Ville/", $this->name)) {
				$family = "Ville";
				$value = trim($this->value);
				$value = strtolower($value);
				$value = ucfirst($value);
				$count = 1;
			} else if (preg_match("/Nombre.*personne|nombre.*personne|Nombre.*Personne|nombre.*Personne/", $this->name)) {
				$family = "Nombre de personnes";
				$value = " ";
				$count = preg_replace("/[^0-9]/","",$element);
			}
			$family == "" ? $family= $this->name : $family ;
			($value == "" && $count == 0)? $count = 1 : $count;
			$value == "" ? $value =  $element :$value;

			if (($value != "") && ($count != 0)) {
				$file = new Devinfrance_Files();
				$file->id = $this->files_id;
				$file->select();
				if (isset($file[0])) {
					$site = new Devinfrance_Sites();
					$site->id = $file[0]->sites_id;
					$site->select();
					if (isset($site[0])) {
						$detail = new Devinfrance_Typeresult();
						if ($detail->load(array('sites_id' => (int)$site[0]->id, 'value' => $value))) {
							$detail->family = $family;
							$detail->count = (int)$count;
						} else {
							$detail->sites_id = (int)$site[0]->id;
							$detail->family = $family;
							$detail->value = $value;
							$detail->count = (int)$count;
						}
						$detail->save();
					}
				}
			}
		}
		return true;
	}
	
    function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load($this->db->config['table_devinfrance_results'], $properties);
		} else {
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
    	switch (true) {
    		case $this->id <= 0:
    		case !is_numeric($this->id):
    		case !$this->is_insertable():
    			return false;
    		default:
    			return true;
    	}
    }
    
    function update() {
		if ($this->is_updatable()) {
			list($result, $num) = $this->db->query("
				UPDATE ".$this->db->config['table_devinfrance_results']."
				SET files_id = ".(int)$this->files_id.",
				name = ".$this->db->quote($this->name).",
				value = ".$this->db->quote($this->value).",
				day = ".(int)$this->day.",
				date_update = ".time()."
				WHERE id = ".(int)$this->id
			);
			$this->db->status($num, "u", __("result"));
			return $result;

		} else {
			$this->db->status(-1, "u", __("result"));
			return false;
		}
	}
    
    function is_insertable() {
    	switch (true) {
    		case empty($this->files_id):
    			return false;
    		default:
    			return true;
    	}
    }

    function insert() {
    	if ($this->is_insertable()) {
			list($result, $num, $this->id) = $this->db->getID("
				INSERT INTO ".$this->db->config['table_devinfrance_results']."
				SET files_id = ".(int)$this->files_id.",
				name = ".$this->db->quote($this->name).",
				value = ".$this->db->quote($this->value).",
				day = ".(int)$this->day.",
				date_update = ".time().",
				date_insert = ".time()
			);
			$this->db->status($num, "i", __("result"));
			return $result;

		} else {
			$this->db->status(-1, "i", __("result"));
			return false;
		}
    }
}
