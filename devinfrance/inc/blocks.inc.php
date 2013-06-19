<?php
/*
	application devinfrance
	$Author: MrRayures $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/inc/blocks.inc.php $
	$Revision: 792 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Blocks extends Collector {
	function __construct() {
		parent::__construct(substr(__CLASS__, 0, -1), strtolower(__CLASS__));
	}
	
	function operations() {
		return array(
			"delete" => __("Delete"),
		);
	}
	
	function grid_header() {
		return array(
				'header' => array(
						array(
								'type' => "th",
								'value' => "",
						),
						array(
								'type' => "th",
								'value' => __("Name"),
						),
						array(
								'type' => "th",
								'value' => __("Display")." ".__("Content"),
						),
						array(
								'type' => "th",
								'value' => __("Last modification"),
						),
				),
		);
	}
	
	function grid_body() {
		$grid = array();
	
		foreach ($this as $block) {
			$checkbox = new Html_Checkbox("block[".(int)$block->id."][check]", 1, true);
			$grid['block_'.$block->id] = array(
					'class' => "",
					'cells' => array(
						$checkbox->input(),
						"<div class=\"site-url\"><a href=\"admin.php?content=block.php&id_blocks=".$block->id."\">".$block->name."</a></div>",
						"<div class=\"block-value\">".$block->value."</div>",
						"<div class=\"site-url\"><a href=\"admin.php?content=block.php&id_blocks=".$block->id."\">".Format::date_time($block->date_update)."</a></div>",
					),
			);
		}
		return $grid;
	}
	
	function grid_footer() {
		return array();
	}
	
	function grid() {
		return $this->grid_header() + $this->grid_body() + $this->grid_footer();
	}
	
	function manage() {
		return show_table(array('lines' => $this->grid()));
	}
	
	function exhibit() {
		if (count($this) > 0) {
			$html = "<ol start=\"".(($this->limit_offset > 0) ? (int)($this->limit_offset) : 1)."\">";
			foreach ($this as $block) {
				$html .= "<li>".$block->exhibit()."</li>";
			}
			$html .= "</ol>";
		} else {
			$html = __("Sorry, we didn't find any blocks.");
		}
		return "<div class=\"blocks\">".$html."</div>";
	}
	
	function format($text) {
		$text = preg_replace(array("/</", "/>/"), array("&lt;", "&gt;"), $text);
		$text = preg_replace(array("/\n/", "/\t/"),array("<br />", "&nbsp;&nbsp;&nbsp;&nbsp;"), $text);
		return $text;
	}
	
	function show() {
		$html = "";
	
		if (count($this) > 0) {
			$html .= "<ul class=\"blocks\">";
			foreach ($this as $block) {
				$html .= "<li class=\"block\">";
				$html .= "<blockquote>".$block->name."</blockquote>";
				$html .= "<blockquote>".$block->value."</blockquote>";
				$html .= "</li>";
			}
			$html .= "</ul>";
		}
		return $html;
	}
	
	function delete() {
		$db = new db();
		$query = "DELETE FROM ".$db->config['table_devinfrance_blocks'].
		" WHERE 1 ";
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$query .= " AND id IN ".array_2_list($this->id);
		}
		$db->query($query);
	}
	
	function query_string() {
		$url = "content=blocks.php";
		if (isset($this->order_col_name) and !empty($this->order_col_name)) {
			$url .= "&order=".$this->order_col_name;
		}
		if (isset($this->order_direction) and !empty($this->order_direction)) {
			$url .= "&direction=".$this->order_direction;
		}
		return $url;
	}
	
	function pagination() {
		$control = new Form_Page_Control($this->query_string(), $this->found_rows());
		return $control->show($this->limit_offset);
	}
}
