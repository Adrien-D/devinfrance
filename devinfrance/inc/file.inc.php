<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_File extends Record {
	public $id = 0;
	public $sites_id = 0;
        public $content = "";
        public $day = 0;
        public $date_insert = "";
        public $date_update = "";
    
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = (int)$id;
	}
	
	function parse() {
		if (empty($this->content)) {
			return false;
		}
		$html = "";
		$day = time();
		$lines = explode("\n", $this->content);
		foreach ($lines as $line) {
			if (strpos($line, "=") !== false) {
				list($name, $value) = explode("=", $line, 2);
				$name = trim($name);
				$value = trim($value);
				
				$result = new Devinfrance_Result();
				$result->files_id = $this->id;
				$result->name = $name;
				$result->value = $value;
				$result->day = $day;
				$result->save();
				$result->parse();
			}
		}
		return true;
	}

	function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load($this->db->config['table_devinfrance_files'], $properties);
		} else {
			return false;
		}
	}
	
	function body() {
		$body = "";
		foreach (array_keys($this->get_public_properties()) as $property) {
			$body .= $property." : \n";
			$body .= $this->{$property}."\n\n";
		}
		return $body;
	}
	
	function url_local() {
		return "index.php?content=file.php&route=get&id=".$this->id;
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
					UPDATE ".$this->db->config['table_devinfrance_files']."
					SET content = ".$this->db->quote($this->content).",
					day = ".$this->db->quote($this->day)."
					WHERE id = ".(int)$this->id
			);
			$this->db->status($num, "u", __("file"));
			return $result;
	
		} else {
			$this->db->status(-1, "u", __("file"));
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
				INSERT INTO ".$this->db->config['table_devinfrance_files']."
				SET sites_id = ".(int)$this->sites_id.",
				content = ".$this->db->quote($this->content).",
				day = ".(int)$this->day.",
				date_update = ".time().",
				date_insert = ".time()
			);
			$this->db->status($num, "i", __("file"));
			return $result;

		} else {
			$this->db->status(-1, "i", __("file"));
			return false;
		}
    }
	

	function edit() {		
		$site = new Devinfrance_Sites();
		$site->id = $this->sites_id;
		$site->select();
		
		$id = new Html_Input("file[id]", (int)$this->id, "hidden");
		$html = $id->input();
		
		if (isset($site[0])) {
			$url = new Html_Input("file[url]", $site[0]->url);
			$name = new Html_Input("file[name]", $site[0]->name);
		} else {
			$url = new Html_Input("file[url]", "-");
			$name = new Html_Input("file[name]", "-");
		}
		
		$content = new Html_Textarea("file[content]", $this->content);
		
		$date = new Html_Input("file[date]", Format::date_time($this->date_insert) );
		
		$date->disabled = "disabled";
		$url->disabled = "disabled";
		$name->disabled = "disabled";
		$content->readonly = "readonly";
	
		$list = array(
				'url' => array(
						'class' => "clearfix",
						'value' => $url->item(__("Site")),
				),
				'name' => array(
						'class' => "clearfix",
						'value' => $name->item(__("Name")),
				),
				'content' => array(
						'class' => "clearfix",
						'value' => $content->item(__("Content")),
				),
				'date' => array(
						'class' => "clearfix",
						'value' => $date->item(__("Date")),
				),
		);
		
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
    	$html .= $id->input().$items->show();
    
    	return "
    	<form id=\"file-".$this->id."\" method=\"post\" action=\"\">".$html."</form>
    	";
		
	}
}
