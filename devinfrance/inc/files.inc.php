<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Files extends Collector_Dated {
	protected $group_by_dated = array("sites_id");
	
	function __construct(db $db = null) {
		parent::__construct("Devinfrance_File", "devinfrance_files", $db);
	}
	
	function operations() {
		return array(
				"delete" => __("Delete"),
		);
	}
	
	function grid_header() {
		if (!(isset($this->developers))) {
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
									'value' => __("Name"),
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
		} else {
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
									'value' => __("Name"),
							),
							array(
									'type' => "th",
									'value' => __("Number of developers"),
							),
							array(
									'type' => "th",
									'value' => __("Last visit"),
							),
					),
			);
		}
	}
	
	function grid_body() {
		$grid = array();
	
		foreach ($this as $file) {
			$site = new Devinfrance_Sites();
			$site->id = $file->sites_id;
			$site->select();
			$checkbox = new Html_Checkbox("file[".(int)$file->id."][check]", 1, true);
			if (isset($site[0])) {
				$site_url = $site[0]->url;
				$site_name = $site[0]->name;
			} else {
				$site_url = " - ";
				$site_name = " - ";
			}
			if (!(isset($this->developers))) {
				$grid['file_'.$file->id] = array(
						'class' => "",
						'cells' => array(
								$checkbox->input(),
								"<div class=\"site-url\"><a href=\"admin.php?content=file.php&id_files=".$file->id."\">".$site_url."</a></div>",
								"<div class=\"site-url\"><a href=\"admin.php?content=file.php&id_files=".$file->id."\">".$site_name."</a></div>",
								"<div class=\"files-content\">".$file->content."</div>",
								"<div class=\"site-url\"><a href=\"admin.php?content=file.php&id_files=".$file->id."\">".Format::date_time($file->date_insert)."</a></div>",
						),
				);
			} else {
				$last_results = new Devinfrance_Results();
				$last_results->files_id = $file->id;
				$last_results->date_insert = $file->date_insert;
				$last_results->select();
				$metiers[$site[0]->id] = $last_results[1]->get_developers($last_results[1]->value);
				
				$grid['file_'.$file->id] = array(
						'class' => "",
						'cells' => array(
								$checkbox->input(),
								"<div class=\"site-url\"><a href=\"admin.php?content=file.php&id_files=".$file->id."\">".$site_url."</a></div>",
								"<div class=\"site-url\"><a href=\"admin.php?content=file.php&id_files=".$file->id."\">".$site_name."</a></div>",
								"<div class=\"files-number\">".$metiers[$site[0]->id]."</div>",
								"<div class=\"site-url\"><a href=\"admin.php?content=file.php&id_files=".$file->id."\">".Format::date_time($file->date_insert)."</a></div>",
						),
				);
			}
			
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
			$html = __("Sorry, we didn't find any files.");
		}
	
		return "<div class=\"sites\">".$html."</div>";
	}
	
	function format($text) {
		$text = preg_replace("/\n/", "<br />", $text);
		return $text;
	}

	function show() {
		$list = array();
		if(isset($this->sites_id)){
			foreach ($this as $file) {
				$list['file-'.$file->id] = "
				<div class=\"file-content\">".$this->format($file->content)."</div>
				<div class=\"result-date_update\">".Format::date_time($file->date_insert)."</div>
				";
			}
		}
		return "<ul class=\"files\"><li>".join("</li><li>", $list)."</li></ul>";
	}
	
	function query_string() {
		$url = "content=files.php";
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
		$query = "DELETE FROM ".$db->config['table_devinfrance_files'].
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
		if (isset($this->start)) {
			$where[] = $this->db->config['table_devinfrance_files'].".date_insert >= ".(int)$this->start;
		}
		if (isset($this->stop)) {
			$where[] = $this->db->config['table_devinfrance_files'].".date_insert <= ".(int)$this->stop;
		}
		if (isset($this->sites_id)) {
			$where[] = $this->db->config['table_devinfrance_files'].".sites_id = ".(int)$this->sites_id;
		}
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$where[] = $this->db->config['table_devinfrance_files'].".id IN ".array_2_list($this->id);
		}
		if (isset($this->last)) {
			if (!is_array($this->last)) {
				$this->last = array((int)$this->last);
			}
			$where[] = $this->db->config['table_devinfrance_files'].".date_insert IN ".array_2_list($this->last);
		}
			
		return $where;
	}
}
