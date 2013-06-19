<?php
/*
	application devinfrance
	$Author: MrRayures $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/messages.inc.php $
	$Revision: 792 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Authors extends Collector {
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
								'value' => __("Description"),
						),
						array(
								'type' => "th",
								'value' => __("URL"),
						),
				),
		);
	}
	
	function grid_body() {
		$grid = array();
	
		foreach ($this as $author) {
			$checkbox = new Html_Checkbox("author[".(int)$author->id."][check]", 1, true);
			$grid['author_'.$author->id] = array(
					'class' => "",
					'cells' => array(
						$checkbox->input(),
						"<div class=\"site-url\"><a href=\"admin.php?content=author.php&id_authors=".$author->id."\">".$author->name."</a></div>",
							"<div class=\"proposition-authors\">".$author->description."</div>",
							"<div class=\"site-url\"><a href=\"admin.php?content=author.php&id_authors=".$author->id."\">".$author->url."</a></div>",
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
	
	function show() {
		$html = "";
		foreach ($this as $author) {
			$html .= $author->show();
		}
		return $html;	
	}
	
	function exhibit() {
		if (count($this) > 0) {
			$html = "<ol start=\"".(($this->limit_offset > 0) ? (int)($this->limit_offset) : 1)."\">";
			foreach ($this as $author) {
				$html .= "<li>".$author->exhibit()."</li>";
			}
			$html .= "</ol>";
		} else {
			$html = __("Sorry, we didn't find any authors.");
		}
	
		return "<div class=\"authors\">".$html."</div>";
	}
	
	function delete() {
		$db = new db();
		$query = "DELETE FROM ".$db->config['table_devinfrance_authors'].
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
		$url = "content=authors.php";
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
	
	function name_filter() {
		$html = "";
		$list_authors = array();
		$last_author = "";
		foreach ($this as $author) {
			if ($last_author != $author->name) {
				$list_authors[$author->id] = $author->name;
			}
			$last_author = $author->name;
		}
		$selected = isset($_GET['author'])? $_GET['author'] : 0;
		$authors = new Html_Select("authors", $list_authors, $selected);
		$authors->options[0] = "<h4>Tous les auteurs</h4>";
		$confirm = new Html_Input("confirm", "ok", "submit");

		$list = array(
			'authors' => array(
				'class' => "date_filter",
				'value' => $authors->selectbox(),
			),
			'confirm' => array(
				'class' => "confirm_filterdate",
				'value' => $confirm->input(),
			)
		);

		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
		$html .= $items->show();

		return "
		<form id=\"propositions_filter\" method=\"post\" action=\"\">".$html."</form>";
	}
	
	function get_where() {
		$where = parent::get_where();
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$where[] = $this->db->config['table_devinfrance_authors'].".id IN ".array_2_list($this->id);
		}
		
		return $where;
	}
}
