<?php
/*
	application commons
	$Author: frank $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/area.inc.php $
	$Revision: 5513 $

	Copyright (C) No Parking 2012 - 2013
*/

class Working_Area extends Area {
	public $data;

	function __construct($data = "") {
		$this->data = $data;
	}

	function show() {
		return "<div class=\"content_working\">".$this->data."</div>";
	}
}