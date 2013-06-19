<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Typeresult extends Record {
	public $id = 0;
	public $sites_id = 0;
	public $family = "";
        public $value = "";
        public $count = 0;
        public $date_insert = "";
        public $date_update = "";
    
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = (int)$id;	
	}
	
    function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load($this->db->config['table_devinfrance_typeresult'], $properties);
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
				UPDATE ".$this->db->config['table_devinfrance_typeresult']."
				SET sites_id = ".(int)$this->sites_id.",
				family = ".$this->db->quote($this->family).",
				value = ".$this->db->quote($this->value).",
				count = ".(int)$this->count.",
				date_update = ".time()."
				WHERE sites_id = ".(int)$this->sites_id." AND value = '".$this->value."'"
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
    		case empty($this->sites_id):
    			return false;
    		default:
    			return true;
    	}
    }

    function insert() {
    	if ($this->is_insertable()) {
			list($result, $num, $this->id) = $this->db->getID("
				INSERT INTO ".$this->db->config['table_devinfrance_typeresult']."
				SET sites_id = ".(int)$this->sites_id.",
				family = ".$this->db->quote($this->family).",
				value = ".$this->db->quote($this->value).",
				count = ".(int)$this->count.",
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
