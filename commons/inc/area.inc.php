<?php
/*
	application commons
	$Author: david $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/area.inc.php $
	$Revision: 5559 $

        Copyright (C) No Parking 2012 - 2013
*/

abstract class Area {
	function __toString() {
		return $this->show();
	}
	abstract function show();
}