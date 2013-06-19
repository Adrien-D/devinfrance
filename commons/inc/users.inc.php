<?php
/*
	application bootinlille
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/contact_function.inc.php $
	$Revision: 4947 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_Users extends Collector {
	function __construct() {
		parent::__construct(substr(__CLASS__, 0, -1), strtolower(__CLASS__));
	}
	
	function names() {
		$fullnames = array();
		foreach ($this as $commons_user) {
			$fullnames[$commons_user->id] = $commons_user->firstname." ".$commons_user->lastname;
		}
		return $fullnames;
	}
	
	function get_where() {
		$where = parent::get_where();
		
		if (isset($this->approuved)) {
			$where[] = $this->db->config['table_commons_users'].".activated = ".(int)$this->activated; 
		}
		
		return $where;
	}
}
