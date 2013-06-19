<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://o2.noparking.net:85/var/repos/projets/nostopping.net/applications/ofr/inc/block.inc.php $
	$Revision: 535 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Block extends Record {
	const table = "devinfrance_blocks";

	public $id = 0;
	public $name = "";
	public $value = "";
	public $language = "";
	public $date_insert = 0;
	public $date_update = 0;
	
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = (int)$id;
	}

	function clean($name) {
		return preg_replace("/[^a-z]/", "", strtolower($name));	
	}
	
	function show($name) {
		if ($this->load(array('name' => $name, 'language' => $GLOBALS['param']['locale_lang']))) {
			return "<div class=\"".$this->clean($name)."\">".$this->value."</div>";
		} else {
			return "<div class=\"missing\">".__("Block missing : %s", array($name))."</div>";
		}
	}
	
	function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load(self::table, $properties);
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
			case empty($this->name):
			case !isset($this->value):
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
				INSERT INTO ".$this->db->config['table_devinfrance_blocks']."
				SET name = ".$this->db->quote($this->name).",
				value = ".$this->db->quote($this->value).",
				language = ".$this->db->quote($this->language).",
				date_insert = ".time().",
				date_update = ".time()
			);
			$this->id = $result[2];
			$this->db->status($result[1], "i", $GLOBALS['txt_block']);
			return (bool)$result[0];
		}
		return false;
	}
	
	function update() {
		if ($this->is_updatable()) {
			$result = $this->db->query("
				UPDATE ".$this->db->config['table_devinfrance_blocks']."
				SET name = ".$this->db->quote($this->name).",
				value = ".$this->db->quote($this->value).",
				language = ".$this->db->quote($this->language).",
				date_update = ".time()."
				WHERE id = ".(int)$this->id
			);
			$this->db->status($result[1], "u", $GLOBALS['txt_block']);
			return (bool)$result[0];
		}

		return false;
	}
	
	function format($text) {
		$text = preg_replace(array("/</", "/>/"), array("&lt;", "&gt;"), $text);
		$text = preg_replace(array("/\n/", "/\t/"),array("<br />", "&nbsp;&nbsp;&nbsp;&nbsp;"), $text);
		return $text;
	}
	
	function display() {
		$html = "<div id=\"display\" class=\"display-block\">";
		$html .= $this->value;
		$html .= "</div>";
		return $html;
	}

	function edit() {
		$id = new Html_Input("block[id]", (int)$this->id, "hidden");
		$html = $id->input();

		$name = new Html_Input("block[name]", $this->name);
		$value = new Html_Textarea("block[value]", $this->value);
		$languages = new Devinfrance_Languages();
		$language = new Html_Select("block[language]", array(0 => "--") + $languages->names(), $this->language);
		$date = new Html_Input("block[date]", Format::date_time($this->date_update) );
		$save = new Html_Input("save", __("Send"), "submit");
		
		$value->onchange = "refresh_display();";
		$date->disabled = "disabled";
	
		$list = array(
				'name' => array(
						'class' => "clearfix",
						'value' => $name->item(__("Name")),
				),
				'value' => array(
						'class' => "clearfix",
						'value' => $value->item(__("Content")),
				),
					'language' => array(
						'class' => "clearfix",
						'value' => $language->item(__("Language")),
					),
				'date' => array(
						'class' => "clearfix",
						'value' => $date->item(__("Last modification")),
				),
				'save' => array(
						'class' => "itemsform-submit",
						'value' => $save->input(),
				),
				'display' => array(
						'class' => "itemsform-submit",
						'value' => $this->display(),
				),
		);
	
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
		$html .= $id->input().$items->show();
	
		return "
		<form id=\"block-".$this->id."\" method=\"post\" action=\"\">".$html."</form>
		";
	
	}
}
