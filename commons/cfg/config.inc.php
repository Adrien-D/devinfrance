<?php
/*
	opentime
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/cfg/config.inc.php.dist $
	$Revision: 5958 $

	Copyright (C) No Parking 2012 - 2013
*/

## software config
$config['name'] = "Opentime";		// nom de l'application
$config['version'] = "1.990";		// version de l'application
$config['title'] = "intranet de gestion du temps";		// titre de l'application tel qu'il apparaît dans la fenêtre du navigateur

## URL config
$config['root_url'] = "";		// adresse - de type URL - de l'application. Note : ne pas mettre de slash à la fin.
$config['external_url'] = "";		// adresse - de type URL - d'une autre version de l'application. Note : ne pas mettre de slash à la fin.

## define path to 'mysqldump' function
$config['mysqldump']              = "mysqldump";		// exemple de commande sous windows : c:/program files/wamp/mysql/bin/mysqldump.exe; exeple de commande sous linux : /usr/local/mysql/bin/mysqldump

## database config
$dbconfig['type'] = "mysql";		// type de serveur de la base de données (mysql, par défaut)
$dbconfig['host'] = "localhost";		// nom du serveur de la base de données (localhost, par défaut)
$dbconfig['user'] = "root";		// login de l'application pour accéder à la base de données
$dbconfig['pass'] = "";		// mot de passe de l'application pour accéder à la base de données
$dbconfig['name'] = "devinfrance";		// nom de la base de données
$dbconfig['new'] = "0";		// forcer la création d'une nouvelle connexion

# seedwork tables
$dbconfig['table_user'] = "user";
$dbconfig['table_blockip'] = "blockip";
$dbconfig['table_fantome'] = "fantome";
$dbconfig['table_fantome_db'] = "fantome_db";
$dbconfig['table_session'] = "session";

# software tables
$dbconfig['table_absencecredit'] = "absencecredit";
$dbconfig['table_chargeplan'] = "chargeplan";
$dbconfig['table_contact'] = "contact";
$dbconfig['table_contactcategory'] = "contactcategory";
$dbconfig['table_contactcivilite'] = "contactcivilite";
$dbconfig['table_contactcomment'] = "contactcomment";
$dbconfig['table_contactcountry'] = "contactcountry";
$dbconfig['table_contactfunction'] = "contactfunction";
$dbconfig['table_contactoptions']     = "contactoptions";
$dbconfig['table_contactoptionslists'] = "contactoptionslists";
$dbconfig['table_contactpersonal'] = "contactpersonal";
$dbconfig['table_contactservice'] = "contactservice";
$dbconfig['table_currencies'] = "currencies";
$dbconfig['table_currenciesrates'] = "currenciesrates";
$dbconfig['table_customer'] = "customer";
$dbconfig['table_customercontacts'] = "customercontacts";
$dbconfig['table_customerlink'] = "customerlink";
$dbconfig['table_customeroptions'] = "customeroptions";
$dbconfig['table_customeroptionslists'] = "customeroptionslists";
$dbconfig['table_estimatetask'] = "estimatetask";
$dbconfig['table_estimatebudget'] = "estimatebudget";
$dbconfig['table_event'] = "event";
$dbconfig['table_eventtype'] = "eventtype";
$dbconfig['table_eventsource'] = "eventsource";
$dbconfig['table_expense'] = "expense";
$dbconfig['table_expensesubject'] = "expensesubject";
$dbconfig['table_expensesubjectoptions'] = "expensesubjectoptions";
$dbconfig['table_expenserate'] = "expenserate";
$dbconfig['table_expenseprojectrate'] = "expenseprojectrate";
$dbconfig['table_forecast'] = "forecast";
$dbconfig['table_expenseforecast'] = "expenseforecast";
$dbconfig['table_holiday'] = "holiday";
$dbconfig['table_hour'] = "hour";
$dbconfig['table_hourlink'] = "hourlink";
$dbconfig['table_houroptions'] = "houroptions";
$dbconfig['table_managementuser'] = "managementuser";
$dbconfig['table_managementuserlink'] = "managementuserlink";
$dbconfig['table_userlinkoptions'] = "userlinkoptions";
$dbconfig['table_passwordrequests'] = "passwordrequests";
$dbconfig['table_payrollelements'] = "payrollelements";
$dbconfig['table_personal'] = "personal";
$dbconfig['table_personaladdition'] = "personaladdition";
$dbconfig['table_personalrequest'] = "personalrequest";
$dbconfig['table_personalrequeststatus'] = "personalrequeststatus";
$dbconfig['table_personalmeter'] = "personalmeter";
$dbconfig['table_personalvariation'] = "personalvariation";
$dbconfig['table_project'] = "project";
$dbconfig['table_projectcontacts'] = "projectcontacts";
$dbconfig['table_projectlink'] = "projectlink";
$dbconfig['table_projectoptions'] = "projectoptions";
$dbconfig['table_projectoptionslists']     = "projectoptionslists";
$dbconfig['table_projectstatus'] = "projectstatus";
$dbconfig['table_purchase'] = "purchase";
$dbconfig['table_quote'] = "quote";
$dbconfig['table_quoteline'] = "quoteline";
$dbconfig['table_quotelinespan'] = "quotelinespan";
$dbconfig['table_quotelinesimple'] = "quotelinesimple";
$dbconfig['table_invoice'] = "invoice";
$dbconfig['table_invoiceline'] = "invoiceline";
$dbconfig['table_invoicelineexpense'] = "invoicelineexpense";
$dbconfig['table_invoicelinespan'] = "invoicelinespan";
$dbconfig['table_invoicelinesimple'] = "invoicelinesimple";
$dbconfig['table_salary'] = "salary";
$dbconfig['table_rate'] = "rate";
$dbconfig['table_rateproject'] = "rateproject";
$dbconfig['table_request'] = "request";
$dbconfig['table_requestoptions'] = "requestoptions";
$dbconfig['table_requestoptionslists'] = "requestoptionslists";
$dbconfig['table_requestpriority'] = "requestpriority";
$dbconfig['table_requeststatus'] = "requeststatus";
$dbconfig['table_requestfieldpermissions'] = "requestfieldpermissions";
$dbconfig['table_requestaction'] = "requestaction";
$dbconfig['table_salefigure'] = "salefigure";
$dbconfig['table_salefigureoptions'] = "salefigureoptions";
$dbconfig['table_tasksubject'] = "tasksubject";
$dbconfig['table_timekeeper'] = "timekeeper";
$dbconfig['table_useroptions'] = "useroptions";
$dbconfig['table_useroptionsdated'] = "useroptionsdated";
$dbconfig['table_recurrents'] = "recurrents";
$dbconfig['table_userweekdetails'] = "userweekdetails";
$dbconfig['table_validationlocks'] = "validationlocks";

## txt
$txtconfig['table_personal']       = "personnel";

if (isset($_SERVER['HTTP_USER_AGENT']) and preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
	$htmlconfig['textarea_cols']     = "51";
	$htmlconfig['textarea_rows']     = "5";
	$htmlconfig['textredac_cols']    = "70";
	$htmlconfig['textredac_rows']    = "10";
	$htmlconfig['textbig_cols']      = "140";
	$htmlconfig['textbig_rows']      = "20";
	$htmlconfig['text_size1']        = "45";
	$htmlconfig['text_size2']        = "40";
	$htmlconfig['text_size3']        = "20";
	$htmlconfig['text_size4']        = "12";
	$htmlconfig['text_size5']        = "7";
} else {
	$htmlconfig['textarea_cols']     = "33";
	$htmlconfig['textarea_rows']     = "5";
	$htmlconfig['textredac_cols']    = "50";
	$htmlconfig['textredac_rows']    = "10";
	$htmlconfig['textbig_cols']      = "100";
	$htmlconfig['textbig_rows']      = "20";
	$htmlconfig['text_size1']        = "38";
	$htmlconfig['text_size2']        = "28";
	$htmlconfig['text_size3']        = "17";
	$htmlconfig['text_size4']        = "11";
	$htmlconfig['text_size5']        = "6";
}

$config['ext_lock'] = "0";		// activation de la version d'évaluation (0 - non, par défaut)
$config['ext_demo'] = "0";		// activation du mode démonstration, ie. blocage de la configuration (0 - non, par défaut)
$config['cache_includes'] = "0";		// utilisation du système de cache pour les fichiers inclus au démarrage (1 - oui, par défaut)
$config['mysql_session'] = "0";		// utilisation d'un système de session sur bdd MySQL (0 - non, par défaut)
$config['mysql_sessionspan'] = "14400";		// durée en secondes de la session MySQL ("14400", par défaut)
$config['mysql_temp_tables'] = "1";		// possibilité d'utiliser les tables temporaires sur bdd MySQL (1 - oui, par défaut)
$config['mysql_password'] = "password";		// utilisation de la fonction 'password' ou 'old_password' pour les mots de passe MySQL ("password", par défaut)
$config['error_handling'] = "0";		// utilisation d'un système de gestion des erreurs avec PHP (1 - oui, par défaut)
$config['db_profiler'] = "0";		// utilisation d'un profiler pour les requêtes à la base de données (0 - non, par défaut)
$config['link_handling'] = "";		// utilisation d'un format particulier pour la gestion des liens ("", par défaut)
$config['synchronization_delay'] = "3600";		// durée en secondes du délai entre synchronisation ("3600", par défaut)
$config['cron_delay'] = "604800";		// durée en secondes du délai entre cron ("604800", par défaut)
$config['cron_last'] = "";		// timestamp du dernier passage du cron ("", par défaut)
$config['firewall_max_attempt'] = "5";		// nombre maximum de tentative de connexion ("5", par défaut)
$config['message_log'] = "1";		// utilsiation d'un fichier de log pour tracer certains évènements (0 - non, par défaut)
$config['lock_time'] = "0";		// timestamp de la fin de l'évaluation (0, par défaut)
$config['layout_mediaserver'] = "";		// serveur pour tous les medias -- js, css, images ("", par défaut)
$config['email_smtp'] = "";		// adresse du serveur SMTP responsable de l'envoi des courriels ("", par défaut)
$config['synchronizer'] = "0";		// activation de la synchronisation (0 - non, par défaut)
