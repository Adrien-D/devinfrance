<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/inc/proposition.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Propositions extends Collector {
	function __construct(db $db = null) {
		parent::__construct("Devinfrance_Proposition", "devinfrance_propositions", $db);
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
								'value' => __("Title"),
						),
						array(
								'type' => "th",
								'value' => __("Author"),
						),
						array(
								'type' => "th",
								'value' => __("Content"),
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
	
		foreach ($this as $proposition) {
			$authors = new Devinfrance_Authors();
			$authors->id = $proposition->authors_id;
			$authors->select();
			if (isset($authors[0])) {
				$author = $authors[0]->name;
			} else {
				$author = "";
			}
			$checkbox = new Html_Checkbox("proposition[".(int)$proposition->id."][check]", 1, true);
				
			$grid['proposition_'.$proposition->id] = array(
					$checkbox->input(),
					"<div class=\"proposition-title\"><a href=\"admin.php?content=proposition.php&id_propositions=".$proposition->id."\">".$proposition->title."</a></div>",
					"<div class=\"proposition-author\"><a href=\"admin.php?content=proposition.php&id_propositions=".$proposition->id."\">".$author."</a></div>",
					"<div class=\"proposition-content\">".$proposition->content."</div>",
					"<div class=\"proposition-URL\"><a href=\"admin.php?content=proposition.php&id_propositions=".$proposition->id."\">".$proposition->url."</a></div>",
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
			foreach ($this as $proposition) {
				$html .= "<li>".$proposition->exhibit()."</li>";
			}
			$html .= "</ol>";
		} else {
			$html = __("Sorry, we didn't find any propositions.");
		}
	
		return "<div class=\"propositions\">".$html."</div>";
	}
	
	function show_short() {
		$html = "";
		if (count($this) > 0) {
			$html .= "<div class=\"propositions\">";
			foreach ($this as $key => $proposition) {
				$html .= "	<div class=\"proposition_short\">
								<div class=\"title\"><a href=\"".$proposition->url_local()."\">".$proposition->title."</a></div>
								<div class=\"content\">".$proposition->format_short($proposition->content)."</div>
							</div>";
			}
			$html .= "</div>";
		}
		return $html;
	}
	
	function delete() {
		$db = new db();

		$query = "DELETE FROM ".$db->config['table_devinfrance_propositions'].
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
		$url = "content=propositions.php";
		if (isset($this->order_col_name) and !empty($this->order_col_name)) {
			$url .= "&order=".$this->order_col_name;
		}
		if (isset($this->order_direction) and !empty($this->order_direction)) {
			$url .= "&direction=".$this->order_direction;
		}
		return $url;
	}
	
	function show($directory_propositions, $url_propositions) {
		$html = "";
		
		if (count($this) > 0) {
			$html .= "<div class=\"list_propositions\">";
			foreach ($this as $key => $proposition) {
				
				$html .= $proposition->show($directory_propositions, $url_propositions,1, $key);
				$html .= "<div class=\"line\"></div>";
			}
			$html .= "</div>";
		}
		
		$html .= $this->paginationpar5($this->found_rows(), $this->limit_offset);
		
		return $html;
	}
	
	function show_count($count) {
		$add_s = ($count>1)? "s": "";
		return "Il y a ".$count." résultat".$add_s;
	}
	
	function paginationpar5($total, $init=null) {
		$html = "";
		
		if ($total) {
			if (!(isset( $GLOBALS['param']['devinfrance_nb_records']))) {
				trigger_error("\$GLOBALS['param']['devinfrance_nb_records']) is undefined", E_USER_ERROR);
			} else if ($GLOBALS['param']['devinfrance_nb_records'] <= 0) {
				trigger_error("\$GLOBALS['param']['devinfrance_nb_records']) must be greater than 0", E_USER_ERROR);
			} else {
				$nbpages = ceil($total / $GLOBALS['param']['devinfrance_nb_records']);
		
				$html .= "<ul class=\"pager clearfix\" id=\"front_office\">";
				
				$get_authors_id = isset($_GET['author'])? "&author=".$_GET['author'] : "";
				$get_date = isset($_GET['date'])? "&date=".$_GET['date'] : "";
				if (is_numeric($init) and $init != 0) {
					$html .= "<li class=\"left_arrow\"><a href=\"".link_content("content=propositions.php&init=".($init-$GLOBALS['param']['devinfrance_nb_records'])).$get_authors_id.$get_date."\">&#8592;</a></li>";
				}
				if (is_numeric($init) and $init >= 4 * $GLOBALS['param']['devinfrance_nb_records'] ) {
					$html .= "<li><a href=\"".link_content("content=propositions.php&init=0").$get_authors_id.$get_date."\">1 ...</a></li>";
				}
				for ($i = 1; $i <= $nbpages; $i++) {
					$current_init = ($i-1) * $GLOBALS['param']['devinfrance_nb_records'];
		
					if (is_numeric($init) and $init == $current_init) {
						$html .= "<li class=\"currentpage\">".$i."</li>";
					} else if (is_numeric($init) && ($current_init == $init+$GLOBALS['param']['devinfrance_nb_records'])) {
						$html .= "<li><a href=\"".link_content("content=propositions.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init+(2*$GLOBALS['param']['devinfrance_nb_records']))) {
						$html .= "<li><a href=\"".link_content("content=propositions.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init-$GLOBALS['param']['devinfrance_nb_records'])) {
						$html .= "<li><a href=\"".link_content("content=propositions.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init-(2*$GLOBALS['param']['devinfrance_nb_records']))) {
						$html .= "<li><a href=\"".link_content("content=propositions.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init-(3*$GLOBALS['param']['devinfrance_nb_records']))) {
						$html .= "<li><a href=\"".link_content("content=propositions.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init+(3*$GLOBALS['param']['devinfrance_nb_records']))) {
						$html .= "<li><a href=\"".link_content("content=propositions.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					}
				}
				if (is_numeric($init) and $init < ($nbpages-4) * $GLOBALS['param']['devinfrance_nb_records'] ) {
					$html .= "<li><a href=\"".link_content("content=propositions.php&init=".(($nbpages-1) * $GLOBALS['param']['devinfrance_nb_records'])).$get_authors_id.$get_date."\">... ".$nbpages."</a></li>";
				}
				if (is_numeric($init) and $init != ($nbpages-1) * $GLOBALS['param']['devinfrance_nb_records'] ) {
					$html .= "<li class=\"right_arrow\"><a href=\"".link_content("content=propositions.php&init=".($init+$GLOBALS['param']['devinfrance_nb_records'])).$get_authors_id.$get_date."\">&#8594;</a></li>";
				}
				
				$html .= "</ul>";
			}
			return $html;
		}
	}
	
	function pagination() {
		$control = new Form_Page_Control($this->query_string(), $this->found_rows());
		return $control->show($this->limit_offset);
	}
	
	function get_where() {
		$where = parent::get_where();
			
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array($this->id);
			}
			$where[] = $this->db->config['table_devinfrance_propositions'].".id IN ".array_2_list($this->id);
		}
		if (isset($this->pattern) and !empty($this->pattern)) {
			$where[] = "MATCH (title, content) AGAINST (".$this->db->quote($this->pattern).")";
		}
		if (isset($this->language)) {
			$where[] = $this->db->config['table_devinfrance_propositions'].".language = ".$this->db->quote($this->language);
		}
		if (isset($this->start)) {
			$where[] = $this->db->config['table_devinfrance_propositions'].".date_insert >= ".(int)$this->start;
		}
		if (isset($this->stop)) {
			$where[] = $this->db->config['table_devinfrance_propositions'].".date_insert <= ".(int)$this->stop;
		}
		if (isset($this->authors_id) && $this->authors_id != 0) {
			$where[] = $this->db->config['table_devinfrance_propositions'].".authors_id = ".$this->authors_id;
		}
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$where[] = $this->db->config['table_devinfrance_propositions'].".id IN ".array_2_list($this->id);
		}
		return $where;
	}
}
