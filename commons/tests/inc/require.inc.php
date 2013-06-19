<?php
/*
	opentime
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/require.inc.php $
	$Revision: 4475 $

	Copyright (C) No Parking 2012 - 2013
*/

require_once dirname(__FILE__)."/../../inc/require.inc.php";
require_once dirname(__FILE__)."/../../../../../simpletest/autorun.php";
require_once dirname(__FILE__)."/simpletest_table_tester.php";

$GLOBALS['dbconfig']['name'] = "dvlpt_test";

$db = new db();
if (!$db->getVerifDatabase($GLOBALS['dbconfig']['name'])) {
	$db->query("CREATE SCHEMA `".$GLOBALS['dbconfig']['name']."`");
	if (!$db->getVerifDatabase($GLOBALS['dbconfig']['name'])) {
		echo "<br />".$GLOBALS['txt_accessdenied']."\n";
		exit();
	}
}

if (function_exists("date_default_timezone_set")) {
	date_default_timezone_set($GLOBALS['param']['locale_timezone']);
}

$_SESSION['username'] = "admin";
$_SESSION['name'] = "Administrator";
$_SESSION['userid'] = 1;
$_SESSION['user_id'] = 1;
$_SESSION['useraccess'] = "aa";
$content = "test.php";
$location = "index.php";
