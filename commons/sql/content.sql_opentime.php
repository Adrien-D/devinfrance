<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/sql/content.sql.php $
	$Revision: 5957 $

	Copyright (C) No Parking 2012 - 2013
*/

$queries = array(
	'absencecredit' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_absencecredit']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  absencecredit_id BIGINT(21) NOT NULL DEFAULT '0',
	  user_id INT(11) NOT NULL DEFAULT '0',
	  referer_id INT(11) NOT NULL DEFAULT '0',
	  description MEDIUMTEXT NOT NULL,
	  personalmeter_id TINYINT(4) NOT NULL DEFAULT '0',
	  span INT(10) NOT NULL DEFAULT '0',
	  day INT(10) NOT NULL DEFAULT '0',
	  requeststatus_id TINYINT(4) NOT NULL DEFAULT '0',
	  personalrequest_id BIGINT(21) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY absencecredit_id (absencecredit_id),
	  KEY personalmeter_id (personalmeter_id),
	  KEY user_id (user_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'blockip' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_blockip']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  ip VARCHAR(15) NOT NULL DEFAULT '',
	  username VARCHAR(80) NOT NULL DEFAULT '',
	  time int(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY ip (ip)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'chargeplan' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_chargeplan']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  user_id INT(11) NOT NULL,
	  project_id BIGINT(21) NOT NULL,
	  day INT(10) NOT NULL,
	  span INT(10) NOT NULL,
	  span_published INT(10) NOT NULL,
	  comment MEDIUMTEXT NOT NULL,
	  time INT(10) NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'contact' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_contact']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  contact_number VARCHAR(20) NOT NULL DEFAULT '',
	  contactcivilite_id TINYINT(4) NOT NULL DEFAULT '0',
	  firstname VARCHAR(100) NOT NULL DEFAULT '',
	  lastname VARCHAR(100) NOT NULL DEFAULT '',
	  company VARCHAR(100) NOT NULL DEFAULT '',
	  taxnumber VARCHAR(100) NULL DEFAULT '',
	  title VARCHAR(50) DEFAULT NULL,
	  contactfunction_id INT(11) NOT NULL DEFAULT '0',
	  contactservice_id INT(11) NOT NULL DEFAULT '0',
	  street VARCHAR(100) NOT NULL DEFAULT '',
	  zip VARCHAR(20) NOT NULL DEFAULT '',
	  city VARCHAR(100) NOT NULL DEFAULT '',
	  contactcountry_id INT(11) NOT NULL DEFAULT '0',
	  phone VARCHAR(100) NOT NULL DEFAULT '',
	  phone2 VARCHAR(100) DEFAULT NULL,
	  fax VARCHAR(100) NOT NULL DEFAULT '',
	  cellphone VARCHAR(100) NOT NULL DEFAULT '',
	  email VARCHAR(100) NOT NULL DEFAULT '',
	  email2 VARCHAR(100) DEFAULT NULL,
	  web VARCHAR(255) NOT NULL DEFAULT '',
	  contactcategory_id TEXT NOT NULL,
	  texte BLOB,
	  user_id INT(11) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'contactcategory' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_contactcategory']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  parent BIGINT(21) NOT NULL DEFAULT '0',
	  name TEXT NOT NULL,
	  description TEXT NOT NULL,
	  texte BLOB NOT NULL,
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY parent (parent)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'contactcivilite' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_contactcivilite']." (
		  id TINYINT(4) NOT NULL AUTO_INCREMENT,
		  name VARCHAR(50) NOT NULL DEFAULT '',
		  shortname VARCHAR(10) NOT NULL DEFAULT '',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_contactcivilite']." VALUES (1, 'Monsieur', 'M.');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_contactcivilite']." VALUES (2, 'Madame', 'Mme');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_contactcivilite']." VALUES (3, 'Mademoiselle', 'Mlle');",
	),
	
	'contactcomment' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_contactcomment']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  contact_id BIGINT(21) NOT NULL DEFAULT '0',
	  texte BLOB NOT NULL,
	  day INT(10) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  user_id INT(11) NOT NULL DEFAULT '0',
	  present_id MEDIUMTEXT NOT NULL,
	  commentstatus_id TINYINT(4) NOT NULL DEFAULT '0',
	  visites INT(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY id_rubrique (contact_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'contactcountry' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_contactcountry']." (
	  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
	  name char(255) NOT NULL DEFAULT '',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'contactfunction' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_contactfunction']." (
	  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
	  name char(255) NOT NULL DEFAULT '',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'contactpersonal' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_contactpersonal']." (
	  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
	  contact_id BIGINT(21) NOT NULL DEFAULT '0',
	  street VARCHAR(100) NOT NULL DEFAULT '',
	  zip VARCHAR(20) NOT NULL DEFAULT '',
	  city VARCHAR(100) NOT NULL DEFAULT '',
	  contactcountry_id INT(11) NOT NULL DEFAULT '0',
	  phone VARCHAR(100) NOT NULL DEFAULT '',
	  fax VARCHAR(100) NOT NULL DEFAULT '',
	  cellphone VARCHAR(100) NOT NULL DEFAULT '',
	  email VARCHAR(100) NOT NULL DEFAULT '',
	  web VARCHAR(255) NOT NULL DEFAULT '',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'contactservice' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_contactservice']." (
	  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
	  name char(255) NOT NULL DEFAULT '',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'contactoptions' => "CREATE TABLE IF NOT EXISTS ".$GLOBALS['dbconfig']['table_contactoptions']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  contact_id TINYINT(4) NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  value MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'contactoptionslists' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_contactoptionslists']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  list MEDIUMTEXT NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'currencies' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_currencies']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  name MEDIUMTEXT NOT NULL DEFAULT '',
	  iso TINYTEXT NOT NULL DEFAULT '',
	  symbol VARCHAR(100) NOT NULL DEFAULT '',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'currenciesrates' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_currenciesrates']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  currency_id INT(11) NOT NULL DEFAULT '0',
	  amount FLOAT(11,6),
	  day INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY currency_id (currency_id),
	  KEY day (day)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'customer' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_customer']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  number TINYTEXT NOT NULL,
	  name VARCHAR(100) NOT NULL DEFAULT '',
	  description VARCHAR(255) NOT NULL DEFAULT '',
	  color VARCHAR(6) NOT NULL DEFAULT '',
	  user_id MEDIUMTEXT NOT NULL,
	  customerstatus_id tinyint(4) NOT NULL DEFAULT '0',
	  customerlink_id tinyint(4) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY customerstatus_id (customerstatus_id),
	  KEY customerlink_id (customerlink_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'customercontacts' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_customercontacts']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  customer_id INT(11) NOT NULL,
	  contact_id INT(11) NOT NULL,
	  PRIMARY KEY (id),
	  KEY customer_id (customer_id),
	  KEY contact_id (contact_id),
	  UNIQUE (customer_id, contact_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'customerlink' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_customerlink']." (
	  id TINYINT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  name VARCHAR(100) NOT NULL
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'customeroptions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_customeroptions']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  customer_id INT(11) NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  value MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id),
	  KEY customer_id (customer_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'customeroptionslists' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_customeroptionslists']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  list MEDIUMTEXT NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'estimatebudget' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_estimatebudget']." (
	  id INT(11) unsigned NOT NULL auto_increment,
	  project_id BIGINT(21) unsigned NOT NULL,
	  salefigure DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  purchase DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  day int(10) unsigned NOT NULL,
	  PRIMARY KEY  (id),
	  KEY project_id (project_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'estimatetask' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_estimatetask']." (
	  id INT(11) unsigned NOT NULL auto_increment,
	  project_id BIGINT(21) unsigned NOT NULL,
	  task_id INT(8) unsigned NOT NULL,
	  day int(10) unsigned NOT NULL,
	  span int(10) unsigned NOT NULL,
	  PRIMARY KEY  (id),
	  KEY project_id (project_id),
	  KEY task_id (task_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'event' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_event']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  event_id BIGINT(21) NOT NULL DEFAULT '0',
	  user_id INT(11) NOT NULL DEFAULT '0',
	  assigned_id MEDIUMTEXT NOT NULL,
	  contact_id MEDIUMTEXT NOT NULL,
	  customer_id INT(11) NOT NULL DEFAULT '0',
	  project_id BIGINT(21) NOT NULL DEFAULT '0',
	  eventcategory_id VARCHAR(30) DEFAULT NULL,
	  day int(10) DEFAULT NULL,
	  start int(10) DEFAULT NULL,
	  stop int(10) DEFAULT NULL,
	  priority_id tinyint(4) NOT NULL DEFAULT '0',
	  eventtype_id INT(11) NOT NULL DEFAULT '0',
	  eventsource_id INT(11) NOT NULL DEFAULT '0',
	  private tinyint(2) NOT NULL DEFAULT '0',
	  finish tinyint(4) NOT NULL DEFAULT '0',
	  title VARCHAR(80) DEFAULT NULL,
	  description text,
	  location VARCHAR(255) DEFAULT NULL,
	  hourlink_id INT(11) NOT NULL DEFAULT '0',
	  time int(10) DEFAULT NULL,
	  PRIMARY KEY (id),
	  KEY event_id (event_id),
	  KEY customer_id (customer_id),
	  KEY eventtype_id (eventtype_id),
	  KEY eventsource_id (eventsource_id),
	  KEY finish (finish),
	  KEY hourlink_id (hourlink_id),
	  KEY project_id (project_id),
	  KEY priority_id (priority_id),
	  KEY user_id (user_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'eventsource' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_eventsource']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  name VARCHAR(100) NOT NULL DEFAULT '',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'eventtype' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_eventtype']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  name VARCHAR(100) NOT NULL DEFAULT '',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'expense' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_expense']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  expense_id BIGINT(21) NOT NULL DEFAULT '0',
	  customer_id INT(11) NOT NULL DEFAULT '0',
	  project_id BIGINT(21) NOT NULL DEFAULT '0',
	  expensesubject_id int(5) NOT NULL DEFAULT '0',
	  user_id INT(11) unsigned NOT NULL DEFAULT '0',
	  billable tinyint(2) NOT NULL DEFAULT '0',
	  prepaid tinyint(2) NOT NULL DEFAULT '0',
	  description MEDIUMTEXT NOT NULL,
	  comment MEDIUMTEXT NOT NULL,
	  amount decimal(13,6) NOT NULL DEFAULT '0.000000',
	  payment tinyint(2) NOT NULL DEFAULT '0',
	  requeststatus_id tinyint(4) NOT NULL DEFAULT '0',
	  referer_id INT(11) NOT NULL DEFAULT '0',
	  day int(10) NOT NULL DEFAULT '0',
	  time int(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY billable (billable),
	  KEY customer_id (customer_id),
	  KEY expense_id (expense_id),
	  KEY expensesubject_id (expensesubject_id),
	  KEY payment (payment),
	  KEY prepaid (prepaid),
	  KEY project_id (project_id),
	  KEY requeststatus_id (requeststatus_id),
	  KEY user_id (user_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'expenseforecast' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_expenseforecast']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  expensesubject_id tinyint(4) unsigned NOT NULL DEFAULT '0',
	  project_id BIGINT(21) NOT NULL DEFAULT '0',
	  amount decimal(13,6) NOT NULL DEFAULT '0.000000',
	  time int(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY expensesubject_id (expensesubject_id),
	  KEY project_id (project_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		
	'expenserate' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_expenserate']." (
		  id INT(11) unsigned NOT NULL AUTO_INCREMENT,
		  expensesubject_id TINYINT(4) NOT NULL DEFAULT '0',
		  coef FLOAT(6,3) NOT NULL DEFAULT '1.00',
		  unit VARCHAR(10) NOT NULL DEFAULT '',
		  vat FLOAT(5,2) NOT NULL DEFAULT '19.60',
		  day INT(10) NOT NULL DEFAULT '0',
		  time INT(10) NOT NULL DEFAULT '0',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (1, 1, '0.26', 'km', '0.00', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (2, 2, '1.00', '".$GLOBALS['param']['currency']."', '19.60', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (3, 3, '1.00', '".$GLOBALS['param']['currency']."', '0.00', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (4, 4, '1.00', '".$GLOBALS['param']['currency']."', '19.60', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (5, 5, '1.00', '".$GLOBALS['param']['currency']."', '0.00', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (6, 6, '1.00', '".$GLOBALS['param']['currency']."', '19.60', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (7, 7, '1.00', '".$GLOBALS['param']['currency']."', '0.00', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (8, 8, '1.00', '".$GLOBALS['param']['currency']."', '19.60', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (9, 9, '1.00', '".$GLOBALS['param']['currency']."', '0.00', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expenserate']." VALUES (10, 10, '1.00', '".$GLOBALS['param']['currency']."', '19.60', 946681200, UNIX_TIMESTAMP(CURRENT_DATE()));",
	),
	
	'expenseprojectrate' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_expenseprojectrate']." (
	  id INT(11) unsigned NOT NULL auto_increment,
	  expensesubject_id TINYINT(4) unsigned NOT NULL,
	  project_id BIGINT(21) unsigned NOT NULL,
	  amount DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  PRIMARY KEY (id),
	  KEY project_id (project_id),
	  KEY expensesubject_id (expensesubject_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'expensesubject' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_expensesubject']." (
		  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
		  name VARCHAR(255) NOT NULL DEFAULT '',
		  expensenumber VARCHAR(10) NOT NULL DEFAULT '',
		  style enum('red','yellow','green','black') NOT NULL DEFAULT 'black',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (1, 'frais km', '6251000', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (2, 'parking', '6251000', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (3, 'transport sans TVA', '6250000', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (4, 'transport avec TVA', '6250000', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (5, 'restauration sans TVA', '6257000', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (6, 'restauration avec TVA', '6257000', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (7, 'hôtel sans TVA', '1.00', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (8, 'hôtel avec TVA', '1.00', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (9, 'divers sans TVA', '1.00', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_expensesubject']." VALUES (10, 'divers avec TVA', '1.00', 'black');",
	),
	
	'expensesubjectoptions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_expensesubjectoptions']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  expensesubject_id BIGINT(21) NOT NULL,
	  name VARCHAR(32) NOT NULL,
	  value MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id),
	  UNIQUE KEY expensesubject_id_name (expensesubject_id, name),
	  KEY expensesubject_id (expensesubject_id),
	  KEY name (name)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'fantome' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_fantome']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  content MEDIUMTEXT NOT NULL,
	  timer FLOAT(12,10) NOT NULL DEFAULT '0.0000000000',
	  time INT(10) NOT NULL DEFAULT '0',
	  access VARCHAR(10) NOT NULL DEFAULT '',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'fantome_db' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_fantome_db']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  content MEDIUMTEXT NOT NULL,
	  query MEDIUMTEXT NOT NULL,
	  rows INT(11) NOT NULL DEFAULT '0',
	  timer FLOAT(12,10) NOT NULL DEFAULT '0.0000000000',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'forecast' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_forecast']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  task_id int(8) NOT NULL DEFAULT '0',
	  project_id BIGINT(21) NOT NULL DEFAULT '0',
	  span int(10) NOT NULL DEFAULT '0',
	  time int(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY task_id (task_id),
	  KEY project_id (project_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'holiday' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_holiday']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  name TEXT,
	  day INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'hour' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_hour']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  project_id VARCHAR(255) NOT NULL DEFAULT '0',
	  task_id int(8) NOT NULL DEFAULT '0',
	  user_id INT(11) NOT NULL DEFAULT '0',
	  comment blob NOT NULL,
	  span int(10) NOT NULL DEFAULT '0',
	  day int(10) NOT NULL DEFAULT '0',
	  hourlink_id INT(11) NOT NULL DEFAULT '0',
	  request_id BIGINT(21) NOT NULL DEFAULT '0',
	  recurrent_id BIGINT(21) NOT NULL DEFAULT '0',
	  time int(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY project_id (project_id),
	  KEY user_id (user_id),
	  KEY hourlink_id (hourlink_id),
	  KEY recurrent_id (recurrent_id),
	  KEY request_id (request_id),
	  KEY task_id (task_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'hourlink' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_hourlink']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  name VARCHAR(255) NOT NULL DEFAULT '',
	  colour VARCHAR(6) NOT NULL DEFAULT '',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'houroptions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_houroptions']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  hour_id BIGINT(21) NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  value MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id),
	  KEY hour_id (hour_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'invoice' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_invoice']." (
	  id BIGINT(21) unsigned NOT NULL AUTO_INCREMENT,
	  project_id BIGINT(21) unsigned NOT NULL DEFAULT '0',
	  user_id int(10) unsigned NOT NULL DEFAULT '0',
	  contact_id int(10) unsigned DEFAULT NULL,
	  quote_id int(10) unsigned DEFAULT NULL,
	  number VARCHAR(20) NOT NULL DEFAULT '',
	  title MEDIUMTEXT NOT NULL,
	  description MEDIUMTEXT NOT NULL,
	  vatrate FLOAT(9,2) DEFAULT NULL,
	  day int(10) NOT NULL DEFAULT '0',
	  time int(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY contact_id (contact_id),
	  KEY project_id (project_id),
	  KEY quote_id (quote_id),
	  KEY user_id (user_id)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
	
	'invoiceline' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_invoiceline']." (
	  id BIGINT(21) unsigned NOT NULL auto_increment,
	  invoice_id BIGINT(21) unsigned NOT NULL default '0',
	  title MEDIUMTEXT NOT NULL,
	  description MEDIUMTEXT NOT NULL,
	  PRIMARY KEY  (id),
	  KEY invoice_id (invoice_id)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
	
	'invoicelineexpense' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_invoicelineexpense']." (
	  invoiceline_id BIGINT(21) unsigned NOT NULL DEFAULT '0',
	  quantity decimal(13,6) NOT NULL DEFAULT '0.000000',
	  expensesubject_id int(8) unsigned NOT NULL,
	  PRIMARY KEY invoiceline_id (invoiceline_id),
	  KEY expensesubject_id (expensesubject_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'invoicelinesimple' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_invoicelinesimple']." (
	  invoiceline_id BIGINT(21) unsigned NOT NULL DEFAULT '0',
	  amount decimal(13,6) NOT NULL DEFAULT '0.000000',
	  PRIMARY KEY (invoiceline_id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
	
	'invoicelinespan' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_invoicelinespan']." (
	  invoiceline_id BIGINT(21) unsigned NOT NULL DEFAULT '0',
	  span int(10) NOT NULL DEFAULT '0',
	  task_id int(8) unsigned NOT NULL,
	  PRIMARY KEY invoiceline_id (invoiceline_id),
	  KEY task_id (task_id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
	
	'managementuser' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_managementuser']." (
		  id INT(11) NOT NULL AUTO_INCREMENT,
		  user_id INT(11) NOT NULL DEFAULT '0',
		  access VARCHAR(10) NOT NULL DEFAULT '',
		  administrativenumber VARCHAR(100) NOT NULL DEFAULT '',
		  week FLOAT(10,2) NOT NULL DEFAULT '".(array_sum(unserialize($GLOBALS['param']['serialized_week'])) / 3600)."',
		  weekdetails VARCHAR(200) NOT NULL DEFAULT '".$GLOBALS['param']['serialized_week']."',
		  validation INT(10) DEFAULT NULL,
		  annualstart INT(10) NOT NULL DEFAULT '0',
		  responsible_id MEDIUMTEXT,
		  userlink_id TINYINT(4) NOT NULL DEFAULT '0',
		  defaultpage VARCHAR(50) DEFAULT NULL,
		  todo TINYINT(4) NOT NULL DEFAULT '1',
		  PRIMARY KEY (id),
		  KEY access (access),
		  KEY user_id (user_id),
		  KEY userlink_id (userlink_id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_managementuser']." (user_id, access, week, weekdetails, validation) VALUES ('1', 'aa', '35', 'a:7:{i:0;i:25200;i:1;i:25200;i:2;i:25200;i:3;i:25200;i:4;i:25200;i:5;i:0;i:6;i:0;}', UNIX_TIMESTAMP(DATE_ADD(CURRENT_DATE, INTERVAL(- DAYOFWEEK(CURRENT_DATE) + 1) DAY)))",
	),
	
	'managementuserlink' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_managementuserlink']." (
	  id TINYINT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  number TINYTEXT NOT NULL DEFAULT '',
	  name VARCHAR(100) NOT NULL
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'passwordrequests' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_passwordrequests']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  timestamp INT(10) NOT NULL DEFAULT '0',
	  token VARCHAR(32) NOT NULL DEFAULT '',
	  completed INT(1) NOT NULL DEFAULT '0',
	  user_id INT(11) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'payrollelements' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_payrollelements']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  project_id VARCHAR(255) NOT NULL DEFAULT '0',
	  task_id INT(8) NOT NULL DEFAULT '0',
	  user_id INT(11) NOT NULL DEFAULT '0',
	  comment BLOB NOT NULL,
	  span INT(10) NOT NULL DEFAULT '0',
	  day INT(10) NOT NULL DEFAULT '0',
	  hourlink_id INT(11) NOT NULL DEFAULT '0',
	  request_id BIGINT(21) NOT NULL DEFAULT '0',
	  recurrent_id BIGINT(21) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  snapshot_time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY project_id (project_id),
	  KEY user_id (user_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'personal' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_personal']." (
		  id TINYINT(4) NOT NULL AUTO_INCREMENT,
		  name VARCHAR(255) NOT NULL DEFAULT '',
		  colour VARCHAR(6) NOT NULL DEFAULT '',
		  number TINYTEXT NOT NULL DEFAULT '',
		  assimilable TINYINT(2) NOT NULL DEFAULT '0',
		  personalmeter_id TINYINT(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (id),
		  KEY id (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personal']." VALUES (1, 'jour férié', '277825', '', '1', '0');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personal']." VALUES (2, 'maladie', 'efc943', '', '0', '0');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personal']." VALUES (3, 'RTT', '3145d2', '', '1', '2');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personal']." VALUES (4, 'congé', 'ea1e13', '', '1', '1');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personal']." VALUES (5, 'convention collective', 'b900d4', '', '1', '0');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personal']." VALUES (6, 'récupération', '93e611', '', '0', '0');",
	),
	
	'personaladdition' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_personaladdition']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  user_id INT(11) NOT NULL DEFAULT '0',
	  personalmeter_id TINYINT(4) NOT NULL DEFAULT '0',
	  span INT(10) NOT NULL DEFAULT '0',
	  day INT(10) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'personalmeter' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_personalmeter']." (
		  id TINYINT(4) NOT NULL AUTO_INCREMENT,
		  name VARCHAR(100) NOT NULL DEFAULT '',
		  weeksperyear INT(11) NOT NULL DEFAULT '0',
		  daysperyear INT(11) NOT NULL DEFAULT '0',
		  annualstart TINYINT(4) DEFAULT '1' NOT NULL,
		  openabledays TINYINT(4) DEFAULT '0' NOT NULL,
		  prorata TINYINT(4) DEFAULT '1' NOT NULL,
		  provision TINYINT(4) DEFAULT '1' NOT NULL,
		  fixed TINYINT(4) NOT NULL DEFAULT '0',
		  maxhalfdays INT(11) NOT NULL DEFAULT '0',
		  balance VARCHAR(100) DEFAULT NULL,
		  maxswitch INT(11) NOT NULL DEFAULT '0',
		  absencecredit_personalmeter_id INT NOT NULL DEFAULT '0',
		  recuperation TINYINT(4) NOT NULL DEFAULT '0',
		  timeunit VARCHAR(5) NOT NULL DEFAULT 'd',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personalmeter']." VALUES (1, 'congés payés', 5, 0, 1, 0, 1, 1, 0, 0, 'halfday', 0, 0, 0, 'd');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personalmeter']." VALUES (2, 'RTT', 0, 0, 1, 0, 1, 0, 0, 0, 'halfday', 0, 0, 0, 'd');",
	),
	
	'personalrequest' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_personalrequest']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  request_id BIGINT(21) NOT NULL DEFAULT '0',
	  user_id INT(11) NOT NULL DEFAULT '0',
	  description MEDIUMTEXT NOT NULL,
	  personal_id TINYINT(4) NOT NULL DEFAULT '0',
	  startday INT(10) NOT NULL DEFAULT '0',
	  starthalf TINYINT(4) NOT NULL DEFAULT '0',
	  startspan INT(10) NOT NULL DEFAULT '0',
	  stopday INT(10) NOT NULL DEFAULT '0',
	  stophalf TINYINT(4) NOT NULL DEFAULT '0',
	  stopspan INT(10) NOT NULL DEFAULT '0',
	  referer_id INT(11) NOT NULL DEFAULT '0',
	  comment MEDIUMTEXT NOT NULL,
	  requeststatus_id TINYINT(4) NOT NULL DEFAULT '0',
	  requestreplaced_id BIGINT(21) DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY request_id (request_id),
	  KEY user_id (user_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'personalrequeststatus' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_personalrequeststatus']." (
		  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
		  name char(100) NOT NULL DEFAULT '',
		  colour VARCHAR(6) NOT NULL DEFAULT '',
		  permission VARCHAR(100) NOT NULL DEFAULT '',
		  completion VARCHAR(100) NOT NULL DEFAULT '',
		  confirmed TINYINT(4) NOT NULL DEFAULT '0',
		  validated TINYINT(4) NOT NULL DEFAULT '0',
		  refused TINYINT(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personalrequeststatus']." VALUES (1, 'proposition', 'bbec97', '', '', '0', '0', '0');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personalrequeststatus']." VALUES (2, 'en cours', '97e25f', 'a|b', 'a|b', '1', '0', '0');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personalrequeststatus']." VALUES (3, 'validé', '68c424', 'aa|b', 'a|b', '0', '1', '0');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personalrequeststatus']." VALUES (4, 'en attente', 'fbaa15', 'a|b', 'a|b', '0', '0', '0');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_personalrequeststatus']." VALUES (5, 'refusé', 'e73029', 'aa|b', 'a|b', '0', '0', '1');",
	),

	'personalvariation' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_personalvariation']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  user_id INT(11) NOT NULL DEFAULT '0',
	  personalmeter_id TINYINT(4) NOT NULL DEFAULT '0',
	  span INT(10) NOT NULL DEFAULT '0',
	  day INT(10) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'project' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_project']." (
	  id BIGINT(21) unsigned NOT NULL AUTO_INCREMENT,
	  parent BIGINT(21) NOT NULL DEFAULT '0',
	  name VARCHAR(255) NOT NULL DEFAULT '',
	  project_number TINYTEXT NOT NULL,
	  description BLOB NOT NULL,
	  customer_id INT(11) NOT NULL DEFAULT '0',
	  user_id MEDIUMTEXT NOT NULL,
	  costproduction DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  salefigure_real DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  salefigure_previ DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  salefigure_day INT(10) NOT NULL DEFAULT '0',
	  salefigure_paid DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  purchase_real DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  purchase_previ DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  profitability FLOAT(6,2) NOT NULL DEFAULT '0.00',
	  margin DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  projectstatus_id TINYINT(4) NOT NULL DEFAULT '0',
	  start INT(10) NOT NULL DEFAULT '0',
	  stop INT(10) NOT NULL DEFAULT '0',
	  validation INT(10) NOT NULL DEFAULT '0',
	  projectlink_id INT(11) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY projectstatus_id (projectstatus_id),
	  KEY customer_id (customer_id),
	  KEY parent (parent),
	  KEY projectlink_id (projectlink_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'projectcontacts' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_projectcontacts']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  project_id INT(11) NOT NULL,
	  contact_id INT(11) NOT NULL,
	  PRIMARY KEY (id),
	  KEY project_id (project_id),
	  KEY contact_id (contact_id),
	  UNIQUE (project_id, contact_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'projectlink' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_projectlink']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  name VARCHAR(100) NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'projectoptions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_projectoptions']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  project_id BIGINT(21) NOT NULL,
	  name VARCHAR(32) NOT NULL,
	  value MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id),
	  UNIQUE KEY project_id_name (project_id, name),
	  KEY project_id (project_id),
	  KEY name (name)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'projectoptionslists' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_projectoptionslists']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  list MEDIUMTEXT NOT NULL,
	  number TINYTEXT NOT NULL DEFAULT '',
	  name MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'projectstatus' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_projectstatus']." (
		  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
		  name char(100) NOT NULL DEFAULT '',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_projectstatus']." VALUES (1, 'proposition');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_projectstatus']." VALUES (2, 'production');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_projectstatus']." VALUES (3, 'clôturé');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_projectstatus']." VALUES (4, 'facturation');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_projectstatus']." VALUES (5, 'refusé');",
	),
	
	'purchase' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_purchase']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  purchase_number VARCHAR(15) DEFAULT NULL,
	  amount DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  amount_paid DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  day INT(10) NOT NULL DEFAULT '0',
	  project_id BIGINT(21) NOT NULL DEFAULT '0',
	  description MEDIUMTEXT NOT NULL,
	  user_id INT(11) NOT NULL DEFAULT '0',
	  contact_id INT(11) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY purchase_number (purchase_number)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'quote' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_quote']." (
	  id BIGINT(21) NOT NULL auto_increment,
	  project_id BIGINT(21) NOT NULL default '0',
	  user_id INT(11) NOT NULL default '0',
	  number VARCHAR(20) NOT NULL DEFAULT '',
	  contact_id BIGINT(21) NOT NULL DEFAULT '0',
	  title MEDIUMTEXT NOT NULL,
	  description MEDIUMTEXT NOT NULL,
	  day INT(10) NOT NULL default '0',
	  time INT(10) NOT NULL default '0',
	  PRIMARY KEY  (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'quoteline' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_quoteline']." (
	  id BIGINT(21) NOT NULL auto_increment,
	  quote_id BIGINT(21) NOT NULL default '0',
	  title MEDIUMTEXT NOT NULL,
	  description MEDIUMTEXT NOT NULL,
	  PRIMARY KEY  (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'quotelinesimple' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_quotelinesimple']." (
	  quoteline_id BIGINT(21) NOT NULL default '0',
	  amount DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  PRIMARY KEY (quoteline_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'quotelinespan' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_quotelinespan']." (
	  quoteline_id BIGINT(21) NOT NULL default '0',
	  span INT(10) NOT NULL default '0',
	  task_id INT(8) unsigned NOT NULL,
	  PRIMARY KEY  (quoteline_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'rate' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_rate']." (
	  id INT(11) unsigned NOT NULL AUTO_INCREMENT,
	  task_id INT(8) unsigned NOT NULL DEFAULT '0',
	  direct FLOAT(11,6) NOT NULL DEFAULT '0.0000',
	  production FLOAT(11,6) NOT NULL DEFAULT '0.0000',
	  day INT(10) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'rateproject' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_rateproject']." (
	  id INT(11) unsigned NOT NULL auto_increment,
	  task_id INT(8) unsigned NOT NULL,
	  project_id BIGINT(21) unsigned NOT NULL,
	  amount FLOAT(11,6),
	  PRIMARY KEY (id),
	  KEY project_id (project_id),
	  KEY task_id (task_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",

	'recurrents' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_recurrents']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  project_id VARCHAR(255) NOT NULL DEFAULT '0',
	  task_id int(8) NOT NULL DEFAULT '0',
	  user_id INT(11) NOT NULL DEFAULT '0',
	  comment MEDIUMTEXT,
	  start int(10) NOT NULL DEFAULT '0',
	  stop int(10) NOT NULL DEFAULT '0',
	  begin int(10) NOT NULL DEFAULT '0',
	  span int(10) NOT NULL DEFAULT '0',
	  day int(10) NOT NULL DEFAULT '0',
	  hourlink_id INT(11) NOT NULL DEFAULT '0',
	  request_id BIGINT(21) NOT NULL DEFAULT '0',
	  time int(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY project_id (project_id),
	  KEY user_id (user_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",		
	
	'request' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_request']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  number BIGINT(21) NOT NULL,
	  request_id BIGINT(21) NOT NULL DEFAULT '0',
	  customer_id INT(11) NOT NULL DEFAULT '0',
	  project_id BIGINT(21) NOT NULL DEFAULT '0',
	  titre TEXT NOT NULL,
	  description TEXT NOT NULL,
	  comment TEXT NOT NULL,
	  user_id MEDIUMTEXT NOT NULL,
	  users_id MEDIUMTEXT NOT NULL,
	  assigned_id MEDIUMTEXT NOT NULL,
	  referer_id MEDIUMTEXT NOT NULL,
	  requeststatus_id TINYINT(4) NOT NULL DEFAULT '0',
	  requestpriority_id TINYINT(4) NOT NULL DEFAULT '0',
	  weight TINYINT(4) NOT NULL DEFAULT '0',
	  start INT(10) DEFAULT NULL,
	  stop INT(10) DEFAULT NULL,
	  private TINYINT(2) NOT NULL DEFAULT '0',
	  repeated TINYINT(2) NOT NULL DEFAULT '0',
	  repetition VARCHAR(15) NOT NULL DEFAULT '',
	  amount DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  options MEDIUMTEXT NOT NULL,
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY request_id (request_id),
	  KEY number (number),
	  KEY customer_id (customer_id),
	  KEY project_id (project_id),
	  KEY requeststatus_id (requeststatus_id),
	  KEY requestpriority_id (requestpriority_id),
	  KEY private (private),
	  KEY repeated (repeated),
	  KEY repetition (repetition)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'requestoptions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_requestoptions']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  request_id BIGINT(21) NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  value MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'requestoptionslists' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_requestoptionslists']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  list MEDIUMTEXT NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'requestpriority' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_requestpriority']." (
		  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
		  name char(255) NOT NULL DEFAULT '',
		  style enum('red','yellow','green','black') NOT NULL DEFAULT 'black',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requestpriority']." VALUES (1, 'faible', 'green');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requestpriority']." VALUES (2, 'normale', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requestpriority']." VALUES (3, 'haute', 'yellow');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requestpriority']." VALUES (4, 'TRES HAUTE', 'red');",
	),
	
	'requeststatus' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_requeststatus']." (
		  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
		  name char(100) NOT NULL DEFAULT '',
		  colour VARCHAR(6) NOT NULL DEFAULT '',
		  archived TINYINT(2) NOT NULL DEFAULT '0',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requeststatus']." VALUES (1, 'proposition', 'bbec97', 0);",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requeststatus']." VALUES (2, 'en cours',    '97e25f', 0);",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requeststatus']." VALUES (3, 'validé',      '68c424', 1);",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requeststatus']." VALUES (4, 'en attente',  'fbaa15', 0);",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_requeststatus']." VALUES (5, 'refusé',      'e73029', 1);",
	),
	
	'requestfieldpermissions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_requestfieldpermissions']." (
	  id INT(11) unsigned NOT NULL AUTO_INCREMENT,
	  name MEDIUMTEXT NOT NULL,
	  required_for_statuses MEDIUMTEXT NOT NULL,
	  readonly_for_roles MEDIUMTEXT NOT NULL,
	  columnvisible_for_roles MEDIUMTEXT NOT NULL,
	  filtervisible_for_roles MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'requestaction' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_requestaction']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  field_id VARCHAR(255) NOT NULL DEFAULT '',
	  operator VARCHAR(255) NOT NULL DEFAULT '',
	  value VARCHAR(255) NOT NULL DEFAULT '',
	  action VARCHAR(255) NOT NULL DEFAULT '',
	  dest VARCHAR(255) NOT NULL DEFAULT '',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'salary' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_salary']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  user_id INT(11) NOT NULL DEFAULT '0',
	  coeff FLOAT(8,2) NOT NULL DEFAULT '0.00',
	  day INT(10) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'salefigure' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_salefigure']." (
	  id BIGINT(21) NOT NULL auto_increment,
	  salefigure_number VARCHAR(15) default NULL,
	  amount DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  amount_paid DECIMAL(13,6) NOT NULL DEFAULT '0.000000',
	  day int(10) NOT NULL default '0',
	  project_id BIGINT(21) NOT NULL default '0',
	  description MEDIUMTEXT NOT NULL,
	  contact_id BIGINT(21) NOT NULL default '0',
	  comment MEDIUMTEXT NOT NULL,
	  vat FLOAT(3,2) NOT NULL default '0.00',
	  payment TINYTEXT NOT NULL,
	  invoice_id BIGINT(21) NOT NULL default '0',
	  user_id INT(11) NOT NULL default '0',
	  time int(10) NOT NULL default '0',
	  PRIMARY KEY  (id),
	  KEY salefigure_number (salefigure_number)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		
	'salefigureoptions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_salefigureoptions']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  salefigure_id BIGINT(21) NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  value MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'session' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_session']." (
	  sesskey VARCHAR(32) NOT NULL DEFAULT '',
	  expiry INT(11) unsigned NOT NULL DEFAULT '0',
	  value TEXT NOT NULL,
	  PRIMARY KEY (sesskey)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'tasksubject' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_tasksubject']." (
		  id TINYINT(4) unsigned NOT NULL AUTO_INCREMENT,
		  name CHAR(255) NOT NULL DEFAULT '',
		  number TINYTEXT NOT NULL DEFAULT '',
		  style ENUM('red','yellow','green','black') NOT NULL DEFAULT 'black',
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_tasksubject']." VALUES (1, 'direction', '', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_tasksubject']." VALUES (2, 'administratif', '', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_tasksubject']." VALUES (3, 'production n°1', '', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_tasksubject']." VALUES (4, 'production n°2', '', 'black');",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_tasksubject']." VALUES (5, 'production n°3', '', 'black');",
	),
	
	'timekeeper' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_timekeeper']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  user_id INT(11) NOT NULL DEFAULT '0',
	  start INT(10) NOT NULL DEFAULT '0',
	  stop INT(10) NOT NULL DEFAULT '0',
	  span INT(10) NOT NULL DEFAULT '0',
	  referer_id INT(11) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'user' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_user']." (
		  id INT(11) NOT NULL AUTO_INCREMENT,
		  username VARCHAR(80) NOT NULL DEFAULT '',
		  password VARCHAR(50) NOT NULL DEFAULT '',
		  name VARCHAR(200) NOT NULL DEFAULT '',
		  email VARCHAR(200) NOT NULL DEFAULT '',
		  ip VARCHAR(15) NOT NULL DEFAULT '',
		  accept VARCHAR(20) NOT NULL DEFAULT '0.0.0.0/255',
		  PRIMARY KEY (id),
		  UNIQUE KEY username (username),
		  KEY name (name)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_user']." (id, username, password, name, email, ip, accept) VALUES (1, 'admin', ".$GLOBALS['config']['mysql_password']."('admin'), 'Administrator', '', '', '0.0.0.0/255');",
	),
		
	'userlinkoptions' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_userlinkoptions']." (
		  id BIGINT(21) NOT NULL AUTO_INCREMENT,
		  userlink_id TINYINT(4) NOT NULL,
		  name MEDIUMTEXT NOT NULL,
		  value MEDIUMTEXT NOT NULL,
		  PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	),
	
	'useroptions' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_useroptions']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  user_id INT(11) NOT NULL,
	  name MEDIUMTEXT NOT NULL,
	  value MEDIUMTEXT NOT NULL,
	  PRIMARY KEY (id),
	  KEY user_id (user_id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
	
	'useroptionsdated' => array(
		"CREATE TABLE ".$GLOBALS['dbconfig']['table_useroptionsdated']." (
		  id BIGINT(21) NOT NULL AUTO_INCREMENT,
		  user_id INT(11) NOT NULL,
		  name MEDIUMTEXT NOT NULL,
		  value MEDIUMTEXT NOT NULL,
		  day INT(10) NOT NULL DEFAULT '0',
		  PRIMARY KEY (id),
		  KEY user_id (user_id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		"INSERT INTO ".$GLOBALS['dbconfig']['table_useroptionsdated']." (id, user_id, name, value, day) VALUES (1, 1, 'task_id', 1, 946681200);",
	),
		
	'userweekdetails' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_userweekdetails']." (
	  id INT(11) NOT NULL AUTO_INCREMENT,
	  user_id INT(11) NOT NULL DEFAULT '0',
	  weekdetails VARCHAR(200) NOT NULL DEFAULT '".$GLOBALS['param']['serialized_week']."',
	  day INT(10) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id)
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
		
	'validationlocks' => "CREATE TABLE ".$GLOBALS['dbconfig']['table_validationlocks']." (
	  id BIGINT(21) NOT NULL AUTO_INCREMENT,
	  user_id INT(11) NOT NULL DEFAULT '0',
	  comment MEDIUMTEXT DEFAULT '',
	  day INT(10) NOT NULL DEFAULT '0',
	  time INT(10) NOT NULL DEFAULT '0',
	  PRIMARY KEY (id),
	  KEY day (day)
	 ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM;",
);
