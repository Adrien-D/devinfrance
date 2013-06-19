<?php
/*
	application devinfrance
	$Author: MrRayures $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/inc/sites.inc.php $
	$Revision: 792 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Sites extends Collector {
	function __construct() {
		parent::__construct(substr(__CLASS__, 0, -1), strtolower(__CLASS__));
	}
	
	function get_count() {
		$sites = new Devinfrance_Sites();
		$sites->is_visited = true;
		$sites->select();
		return $sites->count();
	}
	
	function operations() {
		return array(
				"refresh" => __("Refresh"),
				"delete" => __("Delete"),
				"mail" => __("Email"),
				"visit" => __("Visit"),
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
								'value' => __("Name"),
						),
						array(
								'type' => "th",
								'value' => __("Email"),
						),
						array(
								'type' => "th",
								'value' => __("Last visit"),
						),
				),
		);
	}
	
	function grid_body() {
		$grid = array();
	
		foreach ($this as $site) {
			$checkbox = new Html_Checkbox("site[".(int)$site->id."][check]", 1, true);
			$grid['site_'.$site->id] = array(
					'class' => "",
					'cells' => array(
						$checkbox->input(),
						"<div class=\"site-url\"><a href=\"admin.php?content=site.php&id_sites=".$site->id."\">".$site->url."</a></div>",
						"<div class=\"site-url\"><a href=\"admin.php?content=site.php&id_sites=".$site->id."\">".$site->name."</a></div>",
						"<div class=\"site-url\"><a href=\"admin.php?content=site.php&id_sites=".$site->id."\">".$site->email."</a></div>",
						"<div class=\"site-url\"><a href=\"admin.php?content=site.php&id_sites=".$site->id."\">".Format::date_time($site->visited)."</a></div>",
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
			$html = __("Sorry, we didn't find any sites.");
		}
	
		return "<div class=\"sites\">".$html."</div>";
	}
	
	function visit() {
		foreach ($this as $site) {
			$site->visit();
		}
	}
	
	function add_image($destination_image) {
		foreach ($this as $site) {
			$site->add_image("", $destination_image);
		}
	}
	
	function show($directory_propositions, $url_propositions) {
		$html = "";
		
		if (count($this) > 0) {
			$html .= "<div class=\"list_sites\">";
			foreach ($this as $key => $site) {
				$html .= $site->show($directory_propositions, $url_propositions,1, $key);
			}
			$html .= "</div>";
		}
		
		$html .= $this->paginationpar5($this->found_rows(), $this->limit_offset);
		
		return $html;
	}
	
	function show_thumbnails($url_medias, $directory_medias) {
		$html = "";
		$passage = 0;
		foreach ($this as $site) {
			if (isset($site->visited) && $site->visited != 0) {
				$passage++;
				$result = new Devinfrance_Typeresult();
				if ($result->load(array('sites_id'=> $site->id, 'value'=>"Développeur"))) {
					$result = $result->count;
				} else {
					$result = "";
				}
				
				if (file_exists($directory_medias.$site->format($site->name)."_min.jpeg")) {
					$class = "image_site";
					if (($passage % 5) == 0) {
						$class .= " image_site_last";
					}
					$html .= "<div id=\"image_".$site->format($site->name).$site->id."\" class=\"".$class."\">
								<a href=\"index.php?content=site.php&route=get&id=".$site->id."\"><img id=\"link_".$site->format($site->name).$site->id."\"
									class=\"image_home\"
									src=\"".$url_medias.$site->format($site->name)."_min.jpeg\"
									onmouseover=\"show_dev('".$site->format($site->name)."','".$result."', '".$site->id."')\" 
									onmouseout=\"hide_dev('".$site->format($site->name)."', '".$site->id."')\"/></a>
							</div>
					";
				}
			}
		}
		return $html;
	}
	
	function delete() {
		$db = new db();
		$query = "DELETE FROM ".$db->config['table_devinfrance_sites'].
		" WHERE 1 ";
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$query .= " AND id IN ".array_2_list($this->id);
		}
		$db->query($query);
	}
	
	function send() {
		$html = "";
		foreach ($this as $site) {
			$html .= "<script type=\"text/javascript\">alert('il manque fichier a ".$site->name." Envoie du mail a : ".$site->email."');</script>";
			$site->send_appologize($site->email);
		}
		return $html;
	}
	
	function query_string() {
		$url = "content=sites.php";
		if (isset($this->order_col_name) and !empty($this->order_col_name)) {
			$url .= "&order=".$this->order_col_name;
		}
		if (isset($this->order_direction) and !empty($this->order_direction)) {
			$url .= "&direction=".$this->order_direction;
		}
	
		return $url;
	
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
					$html .= "<li class=\"left_arrow\"><a href=\"".link_content("content=sites.php&init=".($init-$GLOBALS['param']['devinfrance_nb_records'])).$get_authors_id.$get_date."\">&#8592;</a></li>";
				}
				if (is_numeric($init) and $init >= 4 * $GLOBALS['param']['devinfrance_nb_records'] ) {
					$html .= "<li><a href=\"".link_content("content=sites.php&init=0").$get_authors_id.$get_date."\">1 ...</a></li>";
				}
				for ($i = 1; $i <= $nbpages; $i++) {
					$current_init = ($i-1) * $GLOBALS['param']['devinfrance_nb_records'];
	
					if (is_numeric($init) and $init == $current_init) {
						$html .= "<li class=\"currentpage\">".$i."</li>";
					} else if (is_numeric($init) && ($current_init == $init+$GLOBALS['param']['devinfrance_nb_records'])) {
						$html .= "<li><a href=\"".link_content("content=sites.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init+(2*$GLOBALS['param']['devinfrance_nb_records']))) {
						$html .= "<li><a href=\"".link_content("content=sites.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init-$GLOBALS['param']['devinfrance_nb_records'])) {
						$html .= "<li><a href=\"".link_content("content=sites.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init-(2*$GLOBALS['param']['devinfrance_nb_records']))) {
						$html .= "<li><a href=\"".link_content("content=sites.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init-(3*$GLOBALS['param']['devinfrance_nb_records']))) {
						$html .= "<li><a href=\"".link_content("content=sites.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					} else if (is_numeric($init) && ($current_init == $init+(3*$GLOBALS['param']['devinfrance_nb_records']))) {
						$html .= "<li><a href=\"".link_content("content=sites.php&init=".$current_init).$get_authors_id.$get_date."\">".$i."</a></li>";
					}
				}
				if (is_numeric($init) and $init < ($nbpages-4) * $GLOBALS['param']['devinfrance_nb_records'] ) {
					$html .= "<li><a href=\"".link_content("content=sites.php&init=".(($nbpages-1) * $GLOBALS['param']['devinfrance_nb_records'])).$get_authors_id.$get_date."\">... ".$nbpages."</a></li>";
				}
				if (is_numeric($init) and $init != ($nbpages-1) * $GLOBALS['param']['devinfrance_nb_records'] ) {
					$html .= "<li class=\"right_arrow\"><a href=\"".link_content("content=sites.php&init=".($init+$GLOBALS['param']['devinfrance_nb_records'])).$get_authors_id.$get_date."\">&#8594;</a></li>";
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
			
		if (isset($this->visited)) {
			$where[] = $this->db->config['table_devinfrance_sites'].".visited = ".(int)$this->visited;
		}
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$where[] = $this->db->config['table_devinfrance_sites'].".id IN ".array_2_list($this->id);
		}
		if (isset($this->url)) {
			$where[] = $this->db->config['table_devinfrance_sites'].".url = '".$this->url."'";
		}
		
		if (isset($this->is_visited) && $this->is_visited == true) {
			$where[] = $this->db->config['table_devinfrance_sites'].".visited > 0";
		}
			
		return $where;
	}
}
