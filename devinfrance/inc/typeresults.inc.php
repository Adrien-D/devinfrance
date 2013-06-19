<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Typeresults extends Collector {
	
	function __construct(db $db = null) {
		parent::__construct(substr(__CLASS__, 0, -1), "devinfrance_typeresult");
	}
	
	function grid_header() {
		return array(
				'header' => array(
						array(
								'type' => "th",
								'value' => __("Result's type"),
						),
						array(
								'type' => "th",
								'value' => __("Result's name"),
						),
						array(
								'type' => "th",
								'value' => __("Last figures"),
						),
				),
		);
	}
	
	function grid_body() {
		$grid = array();
		$families = new Devinfrance_Typeresults();
		$families->set_group_by("family");
		$families->select();
		
		$elements = array();
		foreach ($families as $family) {
			if (!(preg_match("/mise.*jour|Mise.*jour|mis.*jour/", $family->family))) {
				$element[0] = "<div class=\"site-url\">".$family->family."</div>";
				
				$values = new Devinfrance_Typeresults();
				$values->family = $family->family;
				$values->set_group_by("value");
				$values->set_order("value", "ASC");
				$values->select();
				foreach ($values as $key => $value) {
					$sum = new Devinfrance_Typeresults();
					$sum->family = $family->family;
					$sum->value = $value->value;
					$sum->select();
					$count = 0;
					foreach ($sum as $num) {
						$count += $num->count;
					}
					
					if ($key == 0) {
						$grid['result_'.$value->id] = array(
							'class' => "",
							'cells' => array(
								"<div class=\"site-url\">".$family->family."</div>",
								"<div class=\"site-url\">".$value->value."</div>",
								"<div class=\"site-url\">".$count."</div>",
							),
						);
					} else {
						$grid['result_'.$value->id] = array(
							'class' => "",
							'cells' => array(
								"",
								"<div class=\"site-url\">".$value->value."</div>",
								"<div class=\"site-url\">".$count."</div>",
							),
						);
					}
				}
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
	
	function get_where() {
		$where = parent::get_where();
		
		if (isset($this->results_id)) {
			if (!is_array($this->results_id)) {
				$this->results_id = array((int)$this->results_id);
			}
			$where[] = $this->db->config['table_devinfrance_typeresult'].".results_id IN ".array_2_list($this->results_id);
		}
		if (isset($this->family)) {
			$where[] = $this->db->config['table_devinfrance_typeresult'].".family = '".$this->family."'";
		}
		if (isset($this->value)) {
			$where[] = $this->db->config['table_devinfrance_typeresult'].".value = '".$this->value."'";
		}
		return $where;
	}
}