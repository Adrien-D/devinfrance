<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/sql/content.sql.php $
	$Revision: 5307 $

	Copyright (C) No Parking 2012 - 2013
*/

if (!isset($queries)) {
        $queries = array();
}
$queries += array(
	'devinfrance_authors' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_authors']." (
	  id int(21) NOT NULL AUTO_INCREMENT,
	  name varchar(255) NOT NULL DEFAULT '',
	  description mediumtext NOT NULL DEFAULT '',
	  url varchar(255) NOT NULL,
	  date_insert int(10) unsigned NOT NULL default '0',
	  date_update int(10) unsigned NOT NULL default '0',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
		
	'devinfrance_blocks' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_blocks']." (
	  id int(11) unsigned NOT NULL auto_increment,
	  name varchar(255) NOT NULL,
	  value mediumtext NOT NULL,
	  language varchar(10) NOT NULL,
	  date_insert int(10) unsigned NOT NULL default '0',
	  date_update int(10) unsigned NOT NULL default '0',
	  PRIMARY KEY (id),
	  UNIQUE KEY name (name)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
		
	'devinfrance_files' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_files']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  sites_id INT(11) NOT NULL DEFAULT '0',
	  content mediumtext NOT NULL DEFAULT '',
	  day INT(10) NOT NULL DEFAULT '0',
	  date_insert INT(10) NOT NULL DEFAULT '0',
	  date_update INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'devinfrance_hits' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_hits']." (
	`id` int(21) NOT NULL AUTO_INCREMENT,
	`unique_id` varchar(255) NOT NULL,
	`cookie` varchar(255) NOT NULL DEFAULT '',
	`http_user_agent` varchar(255) NOT NULL,
	`referer` varchar(255) NOT NULL,
	`remote_address` varchar(255) NOT NULL,
	`uri` varchar(255) NOT NULL,
	`delay` float(9,4) DEFAULT NULL,
	`date_insert` int(10) unsigned NOT NULL DEFAULT '0',
	`date_update` int(10) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
		
	'devinfrance_propositions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_propositions']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  title mediumtext NOT NULL DEFAULT '',
	  content mediumtext NOT NULL DEFAULT '',
	  authors_id INT(11) NOT NULL,
	  url varchar(255) NOT NULL DEFAULT '',
	  date_insert INT(10) NOT NULL DEFAULT '0',
	  date_update INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		
	'devinfrance_results' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_results']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  files_id INT(11) NOT NULL DEFAULT '0',
	  name varchar(255) NOT NULL DEFAULT '',
	  value mediumtext NOT NULL DEFAULT '',
	  day INT(10) NOT NULL DEFAULT '0',
	  date_insert INT(10) NOT NULL DEFAULT '0',
	  date_update INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'devinfrance_sites' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_sites']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  url varchar(255) NOT NULL DEFAULT '',
	  name varchar(255) NOT NULL DEFAULT '',
	  email varchar(255) NOT NULL DEFAULT '',
	  visited INT(10) NOT NULL DEFAULT '0',
	  date_insert INT(10) NOT NULL DEFAULT '0',
	  date_update INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'devinfrance_typeresult' =>	"CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_typeresult']." (
		id INT(11) NOT NULL AUTO_INCREMENT,
		sites_id INT(11) NOT NULL,
		family varchar(255) NOT NULL DEFAULT '',
		value varchar(255) NOT NULL DEFAULT '',
		count INT(11) DEFAULT 0,
		date_insert INT(10) unsigned NOT NULL default '0',
		date_update INT(10) unsigned NOT NULL default '0',
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
		
	'devinfrance_votes' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_votes']." (
		id INT(11) NOT NULL AUTO_INCREMENT,
		remote_address varchar(255) NOT NULL DEFAULT '',
		propositions_id varchar(255) NOT NULL DEFAULT '',
		value INT(11) NULL DEFAULT '0',
		date_insert INT(10) unsigned NOT NULL default '0',
		date_update INT(10) unsigned NOT NULL default '0',
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
);
