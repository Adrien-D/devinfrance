<?php
/*
	application commons
	$Author: david $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/require.inc.php $
	$Revision: 5560 $

	Copyright (C) No Parking 2012 - 2013
*/

$test_run = ((isset($_GET['content']) and $_GET['content'] == "test.php") or php_sapi_name() == "cli");

$current_directory = dirname(__FILE__);

require($current_directory."/../cfg/config.inc.php");
require($current_directory."/../cfg/param.inc.php");

if (isset($GLOBALS['pathconfig']['cfg']) and !empty($GLOBALS['pathconfig']['cfg'])) {
	require($GLOBALS['pathconfig']['cfg']."/config.inc.php");
	require($GLOBALS['pathconfig']['cfg']."/param.inc.php");
}

require($current_directory."/html_checkbox.inc.php");
require($current_directory."/html.inc.php");
require($current_directory."/record.inc.php");
require($current_directory."/collector.inc.php");
require($current_directory."/collector_dated.inc.php");
require($current_directory."/db.inc.php");
require($current_directory."/db_reporter.inc.php");
require($current_directory."/area.inc.php");
require($current_directory."/form_area.inc.php");
require($current_directory."/form_page_control.inc.php");
require($current_directory."/misc.inc.php");
require($current_directory."/format.inc.php");
require($current_directory."/html_input.inc.php");
require($current_directory."/html_list.inc.php");
require($current_directory."/html_select.inc.php");
require($current_directory."/html_textarea.inc.php");
require($current_directory."/working_area.inc.php");
require($current_directory."/../lang/fr_FR.lang.php");

require($current_directory."/../../devinfrance/lang/fr_FR.lang.php");
require($current_directory."/../../devinfrance/cfg/config.inc.php");
require($current_directory."/../../devinfrance/cfg/param.inc.php");
require($current_directory."/../../devinfrance/inc/hit.inc.php");
require($current_directory."/../../devinfrance/inc/content.inc.php");
require($current_directory."/../../devinfrance/inc/block.inc.php");
require($current_directory."/../../devinfrance/inc/page.inc.php");
require($current_directory."/../../devinfrance/inc/author.inc.php");
require($current_directory."/../../devinfrance/inc/authors.inc.php");
require($current_directory."/../../devinfrance/inc/blocks.inc.php");
require($current_directory."/../../devinfrance/inc/bot.inc.php");
require($current_directory."/../../devinfrance/inc/file.inc.php");
require($current_directory."/../../devinfrance/inc/files.inc.php");
require($current_directory."/../../devinfrance/inc/hits.inc.php");
require($current_directory."/../../devinfrance/inc/languages.inc.php");
require($current_directory."/../../devinfrance/inc/page_admin.inc.php");
require($current_directory."/../../devinfrance/inc/proposition.inc.php");
require($current_directory."/../../devinfrance/inc/propositions.inc.php");
require($current_directory."/../../devinfrance/inc/result.inc.php");
require($current_directory."/../../devinfrance/inc/results.inc.php");
require($current_directory."/../../devinfrance/inc/site.inc.php");
require($current_directory."/../../devinfrance/inc/sites.inc.php");
require($current_directory."/../../devinfrance/inc/tools.inc.php");
require($current_directory."/../../devinfrance/inc/typeresult.inc.php");
require($current_directory."/../../devinfrance/inc/typeresults.inc.php");
require($current_directory."/../../devinfrance/inc/update.inc.php");
require($current_directory."/../../devinfrance/inc/vote.inc.php");
require($current_directory."/../../devinfrance/inc/votes.inc.php");


if (!isset($GLOBALS['param']['locale_lang'])) {
	$GLOBALS['param']['locale_lang'] = "fr_FR";
}

if (strpos($_SERVER['SCRIPT_FILENAME'], "setup.php") === false) {
	$db = new db($dbconfig);
	$db->query("SET NAMES 'utf8'");
}

if (function_exists("date_default_timezone_set")) {
	date_default_timezone_set($GLOBALS['param']['commons_app_locale_timezone']);
}
