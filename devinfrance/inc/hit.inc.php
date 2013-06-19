<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://o2.noparking.net:85/var/repos/projets/nostopping.net/applications/ofr/inc/block.inc.php $
	$Revision: 535 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Hit extends Record {
	public $id = 0;
	public $unique_id = "";
	public $cookie = "";
	public $http_user_agent = "";
	public $referer = "";
	public $remote_address = "";
	public $uri = "";
	public $delay = 0;
	public $date_insert = 0;
	public $date_update = 0;
	
	protected $start = 0;
	protected $stop = 0;
	
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = $id;
	}
	
	function start($start = null) {
		if ($start === null) {
			$start = microtime(true);
		}
		$this->start = $start;
	}

	function stop($stop = null) {
		if ($stop === null) {
			$stop = microtime(true);
		}
		$this->stop = $stop;
		$this->delay = $this->stop - $this->start;
	}
	
	function add($values = array()) {
		if (isset($values['id'])) {
			$this->id = $values['id'];
		} else {
			$this->id = 0;
		}

		if (isset($values['unique_id'])) {
			$this->unique_id = $values['unique_id'];
		} else {
			$this->unique_id = isset($_SERVER['UNIQUE_ID']) ? $_SERVER['UNIQUE_ID'] : "";
		}

		if (isset($values['cookie'])) {
			$this->cookie = $values['cookie'];
		} else {
			$this->cookie = session_id();
		}

		if (isset($values['http_user_agent'])) {
			$this->http_user_agent = $values['http_user_agent'];
		} else {
			$this->http_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
		}

		if (isset($values['referer'])) {
			$this->referer = $values['referer'];
		} else {
			$this->referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
		}

		if (isset($values['remote_address'])) {
			$this->remote_address = $values['remote_address'];
		} else {
			$this->remote_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";
		}

		if (isset($values['uri'])) {
			$this->uri = $values['uri'];
		} else {
			$this->uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
		}
		
		if (isset($values['delay'])) {
			$this->delay = $values['delay'];
		}
		
		return $this->insert();
	}

	function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load($this->db->config['table_devinfrance_hits'], $properties);
		} else {
			return false;			
		}
	}
		
	function is_updatable() {
		switch (true) {
			case !($this->is_insertable()):
			case empty($this->id):
				return false;
			default:
				return true;
		}
	}

	function is_insertable() {
		switch (true) {
			case empty($this->cookie):
				return false;
			default:
				return true;
		}
	}
	
	function delete() {
		return false;
	}
	
	function save() {
		if ($this->update()) {
			return true;
		} else {
			return $this->insert();
		}
	}
	
	function insert() {
		if ($this->is_insertable()) {
			$result = $this->db->getID("
				INSERT INTO ".$this->db->config['table_devinfrance_hits']."
				SET unique_id = ".$this->db->quote($this->unique_id).",
				cookie = ".$this->db->quote($this->cookie).",
				http_user_agent = ".$this->db->quote($this->http_user_agent).",
				referer = ".$this->db->quote($this->referer).",
				remote_address = ".$this->db->quote($this->remote_address).",
				uri = ".$this->db->quote($this->uri).",
				delay = ".(float)$this->delay.",
				date_insert = ".time().",
				date_update = ".time()
			);
			$this->id = $result[2];
			return (bool)$result[1];
		}

		return false;
	}
	
	function update() {
		if ($this->is_updatable()) {
			$result = $this->db->query("
				UPDATE ".$this->db->config['table_devinfrance_hits']."
				SET unique_id = ".$this->db->quote($this->unique_id).",
				cookie = ".$this->db->quote($this->cookie).",
				http_user_agent = ".$this->db->quote($this->http_user_agent).",
				referer = ".$this->db->quote($this->referer).",
				remote_address = ".$this->db->quote($this->remote_address).",
				uri = ".$this->db->quote($this->uri).",
				delay = ".(float)$this->delay.",
				date_update = ".time()."
				WHERE id = ".(int)$this->id
			);
			return (bool)$result[1];
		}

		return false;
	}
}
