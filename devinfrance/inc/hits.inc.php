<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/questions.inc.php $
	$Revision: 769 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Hits extends Collector {
	function __construct() {
		parent::__construct(substr(__CLASS__, 0, -1), strtolower(__CLASS__));
	}
	
	function show() {
		$list = array();
		
		foreach ($this as $hit) {
			$list['hit-'.$hit->id] = "
				<div class=\"hit-date_insert\">".Format::date_time($hit->date_insert)."</div>
				<div class=\"hit-uri\">".$hit->uri."</div>
				<div class=\"hit-referer\">".$hit->referer."</div>
				<div class=\"hit-remote_address\">".$hit->remote_address."</div>
				<div class=\"hit-http_user_agent\">".$hit->http_user_agent."</div>
			";
		}
		
		return "<ul class=\"hits\"><li>".join("</li><li>", $list)."</li></ul>";
	}
	
	function get_where() {
		$where = parent::get_where();
			
		if (isset($this->start)) {
			$where[] = $this->db->config['table_devinfrance_hits'].".date_insert >= ".(int)$this->start;
		}
		if (isset($this->stop)) {
			$where[] = $this->db->config['table_devinfrance_hits'].".date_insert <= ".(int)$this->stop;
		}
		if (isset($this->cookie)) {
			$where[] = $this->db->config['table_devinfrance_hits'].".cookie = '".$this->cookie."'";
		}
		if (isset($this->noparking)) {
			$where[] = $this->db->config['table_devinfrance_hits'].".remote_address != '".$this->noparking."'";
		}
		return $where;
	}
}
