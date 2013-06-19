<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/sql/content.sql.php $
	$Revision: 5495 $

	Copyright (C) No Parking 2012 - 2013
*/

if (!isset($queries)) {
        $queries = array();
}
$queries += array(
	'commons_users' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_commons_users']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  email VARCHAR(255) NOT NULL DEFAULT '',
	  firstname VARCHAR(255) NOT NULL DEFAULT '',
	  lastname VARCHAR(255) NOT NULL DEFAULT '',
	  password VARCHAR(255) NOT NULL DEFAULT '',
	  `activated` tinyint(4) NOT NULL DEFAULT '0',
	  `date_insert` int(10) unsigned NOT NULL DEFAULT '0',
	  `date_update` int(10) unsigned NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  UNIQUE (email)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
);
