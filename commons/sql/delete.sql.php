<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/sql/delete.sql.php $
	$Revision: 4715 $

	Copyright (C) No Parking 2012 - 2013
*/

$db = new db();
$tables = array();
foreach ($GLOBALS['dbconfig'] as $parameter => $table) {
	if (substr($parameter, 0, 6) == 'table_') {
		$tables[] = $table;
	}
}
$db->query("DROP TABLE IF EXISTS ".join(", ", $tables));
