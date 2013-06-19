<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Author extends Record {
	public $id = 0;
        public $name = "";
        public $description = "";
        public $url = "";
        public $date_insert = "";
	public $date_update = "";
 
	protected $errors = array();
	protected $alert_errors = false;
	
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = (int)$id;
	}
	
	function url_local() {
		return "index.php?content=author.php&id=".$this->id;
	}
	
	function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load($this->db->config['table_devinfrance_authors'], $properties);
		} else {
			return false;
		}
	}
	
	function show() {
		return "<div class=\"author\">
					<div class=\"left_author\">
						<p class=\"proposition_date\">".Format::date_day($this->date_insert)."</p>
						<p class=\"name_author\">$this->name</p>
						<a href=\"$this->url\"><img src=\"http://www.apercite.fr/api/apercite/320x240/oui/oui/".$this->url."\" alt=\"$this->url\"/></a>
					</div>
					<div class=\"right_author\">
						<p class=\"author_description\">$this->description</p>
						<a href=\"$this->url\" target=\"_blank\" >$this->url</a>
					</div>
				</div>";
	}
	
	function body() {
		$body = "";
		foreach (array_keys($this->get_public_properties()) as $property) {
			$body .= $property." : \n";
			$body .= $this->{$property}."\n\n";
		}
		return $body;
	}
	
	function delete() {
		return false;
	}
	
	function check() {
		return count($this->errors("*")) === 0;
	}
    
	function errors($property = "*") {
		$this->errors = array();

		if ($property == "name" or $property == "*" or (is_array($property) and in_array("name", $property))) {
			if ($this->name == "") {
				$this->errors[] = __("Firstname must not be empty");
			}
		}

		return $this->errors;
	}

	function alert_errors($bool = null) {
		if (isset($bool)) {
			$this->alert_errors = (bool)$bool;
		}
		return $this->alert_errors;
	}
	
	function show_errors($property = "*") {
		if ($this->alert_errors()) {
			$errors = $this->errors($property);
			if (count($errors) > 0) {
				return "<ul class=\"errors\"><li>".join("</li><li>", $this->errors($property))."</li></ul>";
			}
		}
		
		return "";
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
    		case !$this->errors()==null:
    			return false;
    		default:
    			return true;
    	}
    }
    
    function update() {
		if ($this->is_updatable()) {
			list($result, $num) = $this->db->query("
				UPDATE ".$this->db->config['table_devinfrance_authors']."
				SET name = ".$this->db->quote($this->name).",
					description = ".$this->db->quote($this->description).",
					url = ".$this->db->quote($this->url).",
					date_update = ".time()."
				WHERE id = ".(int)$this->id
			);
			$this->db->status($num, "u", __("author"));
			return $result;

		} else {
			$this->db->status(-1, "u", __("author"));
			return false;
		}
    }
    
    function is_insertable() {
    	switch (true) {
    		case empty($this->name):
    			return false;
    		default:
    			return true;
    	}
    }

    function insert() {
		if ($this->is_insertable()) {
			list($result, $num, $this->id) = $this->db->getID("
				INSERT INTO ".$this->db->config['table_devinfrance_authors']."
				SET name = ".$this->db->quote($this->name).",
					description = ".$this->db->quote($this->description).",
					url = ".$this->db->quote($this->url).",
					date_update = ".time().",
					date_insert = ".time()
			);
			$this->db->status($num, "i", __("author"));
			return $result;

		} else {
			$this->db->status(-1, "i", __("author"));
			return false;
		}
    }
    
    function edit() {
    	$id = new Html_Input("author[id]", (int)$this->id, "hidden");
    	$html = $id->input();
    	
    	$name = new Html_Input("author[name]", $this->name);  
    	$description = new Html_Textarea("author[description]", $this->description);
    	$url = new Html_Input("author[url]", $this->url);
    	$save = new Html_Input("save", __("Send"), "submit");
    
    	$list = array(
    			'name' => array(
    					'class' => "clearfix",
    					'value' => $name->item(__("Name")),
    			),
    			'description' => array(
    					'class' => "clearfix",
    					'value' => $description->item(__("Description")),
    			),
    			'url' => array(
    					'class' => "clearfix",
    					'value' => $url->item(__("URL")),
    			),
    			'save' => array(
    					'class' => "itemsform-submit",
    					'value' => $save->input(),
    			),
    	);
    
    	$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
    	$html .= $id->input().$items->show();
    
    	return "
    	<form id=\"author-".$this->id."\" method=\"post\" action=\"\">".$html."</form>
    	";
    }
}
