<?php
/*
	application devinfrance
	$Author: MrRayures $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/messages.inc.php $
	$Revision: 792 $

	Copyright (C) No Parking 2012 - 2012
*/

class Devinfrance_Votes extends Collector {
	function __construct() {
		parent::__construct(substr(__CLASS__, 0, -1), strtolower(__CLASS__));
	}
	
	function calc_result() {
		$result = 0;
		foreach ($this as $vote) {
			$result += $vote->value;
		}
		if ($result > 0) {
			$result = "+".$result;
		}
		return $result;
	}
	
	function show() {
		return $this->calc_result();
	}
	
	function delete() {
		$db = new db();
		$query = "DELETE FROM ".$db->config['table_devinfrance_votes'].
		" WHERE 1 ";
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$query .= " AND id IN ".array_2_list($this->id);
		}
		$db->query($query);
	}
	
	function get_where() {
		$where = parent::get_where();
		if (isset($this->id)) {
			if (!is_array($this->id)) {
				$this->id = array((int)$this->id);
			}
			$where[] = $this->db->config['table_devinfrance_votes'].".id IN ".array_2_list($this->id);
		}
		if (isset($this->propositions_id)) {
			if (!is_array($this->propositions_id)) {
				$this->propositions_id = array((int)$this->propositions_id);
			}
			$where[] = $this->db->config['table_devinfrance_votes'].".propositions_id IN ".array_2_list($this->propositions_id);
		}
		if (isset($this->remote_address)) {
			$where[] = $this->db->config['table_devinfrance_votes'].".remote_address = '".$this->remote_address."'";
		}
		
		return $where;
	}
}
