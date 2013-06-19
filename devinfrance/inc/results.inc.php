<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Results extends Collector_Dated {
	protected $group_by_dated = array("files_id", "name");
	
	function __construct(db $db = null) {
		parent::__construct("Devinfrance_Result", "devinfrance_results", $db);
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
								'value' => __("URL"),
						),
						array(
								'type' => "th",
								'value' => __("Result's name"),
						),
						array(
								'type' => "th",
								'value' => __("Content"),
						),
						array(
								'type' => "th",
								'value' => __("Add"),
						),
				),
		);
	}
	
	function grid_body() {
		$grid = array();
	
		foreach ($this as $result) {
			$file = new Devinfrance_Files();
			$file->id = $result->files_id;
			$file->select();
			
			if(isset($file[0])) {
				$site = new Devinfrance_Sites();
				$site->id = $file[0]->sites_id;
				$site->select();
			}
			$checkbox = new Html_Checkbox("result[".(int)$result->id."][check]", 1, true);
			$last = "";
			if (isset($_GET['last'])) {
				$last = "&last=true";
			}
			$grid['result_'.$result->id] = array(
					'class' => "",
					'cells' => array(
							$checkbox->input(),
							"<div class=\"results-content\"><a href = \"admin.php?content=results.php".$last."&type=url&filter=".$site[0]->url."\">".$site[0]->url."</a></div>",
							"<div class=\"results-content\"><a href = \"admin.php?content=results.php".$last."&type=name&filter=".$result->name."\">".$result->name."</a></div>",
							"<div class=\"results-content\"><a href = \"admin.php?content=results.php".$last."&type=value&filter=".$result->value."\">".$result->value."</a></div>",
							"<div class=\"results-content\"><a href = \"admin.php?content=results.php".$last."&type=date_insert&filter=".$result->date_insert."\">".Format::date_time($result->date_insert)."</a></div>",
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
			foreach ($this as $site) {
				$html .= "<li>".$site->exhibit()."</li>";
			}
			$html .= "</ol>";
		} else {
			$html = __("Sorry, we didn't find any results.");
		}
		return "<div class=\"sites\">".$html."</div>";
	}

	function show() {
		$list = array();
		if(isset($this->files_id)){
			foreach ($this as $result) {
				$list['result-'.$result->id] = "
				<div class=\"result-name\">".$result->name."</div>
				<div class=\"result-content\">".$result->value."</div>
				<div class=\"result-date_update\">".Format::date_time($result->date_insert)."</div>
				";
			}
		}
		return "<ul class=\"results\"><li>".join("</li><li>", $list)."</li></ul>";
	}
	
	function query_string() {
		$url = "content=results.php";
		if (isset($this->order_col_name) and !empty($this->order_col_name)) {
			$url .= "&order=".$this->order_col_name;
		}
		if (isset($this->order_direction) and !empty($this->order_direction)) {
			$url .= "&direction=".$this->order_direction;
		}
		return $url;
	}
	
	function delete() {
		$db = new db();
		$query = "DELETE FROM ".$db->config['table_devinfrance_results'].
		" WHERE 1 ";
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$query .= " AND id IN ".array_2_list($this->id);
		}
		$db->query($query);
	}
	
	function pagination() {
		$control = new Form_Page_Control($this->query_string(), $this->found_rows());
		return $control->show($this->limit_offset);
	}
	
	function get_where() {
		$where = parent::get_where();
		if (isset($this->type_filter) && isset($this->filter)) {
			if (!($this->type_filter == "url")) {
				$where[] = $this->db->config['table_devinfrance_results'].".".$this->type_filter." = '".$this->filter."'";
			} else {
				$sites = new Devinfrance_Sites();
				$sites->url = $this->filter;
				$sites->select();
				$files_id[] = "";
				if (isset($sites[0])) {
					foreach ($sites as $site) {
						$files = new Devinfrance_Files();
						$files->sites_id = $site->id;
						$files->select();
						foreach ($files as $file) {
							$files_id[] = $file->id;
						}
					}
					$where[] = $this->db->config['table_devinfrance_results'].".files_id IN " .array_2_list($files_id);
				} else {
					$sites = new Devinfrance_Sites();
					$sites->select();
					foreach ($sites as $site) {
						$files = new Devinfrance_Files();
						$files->sites_id = $site->id;
						$files->select();
						foreach ($files as $file) {
							$files_id[] = $file->id;
						}
					}
					$where[] = $this->db->config['table_devinfrance_results'].".files_id NOT IN " .array_2_list($files_id);
				}
			}
		}
		if (isset($this->files_id)) {
			if (!is_array($this->files_id)) {
				$this->files_id = array((int)$this->files_id);
			}
			$where[] = $this->db->config['table_devinfrance_results'].".files_id IN ".array_2_list($this->files_id);
		}
		if (isset($this->date_insert)) {
			$where[] = $this->db->config['table_devinfrance_results'].".date_insert < ".((int)$this->date_insert+2);
			$where[] = $this->db->config['table_devinfrance_results'].".date_insert > ".((int)$this->date_insert-2);
		}
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$where[] = $this->db->config['table_devinfrance_results'].".id IN ".array_2_list($this->id);
		}
		if (isset($this->name)) {
			$where[] = $this->db->config['table_devinfrance_results'].".name = '".$this->name."'";
		}
		return $where;
	}
}