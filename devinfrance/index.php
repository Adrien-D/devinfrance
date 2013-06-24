<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/index.php $
	$Revision: 766 $

	Copyright (C) No Parking 2012 - 2013
*/

require dirname(__FILE__)."/../commons/inc/require.inc.php";

if (function_exists("date_default_timezone_set")) {
	date_default_timezone_set($GLOBALS['param']['commons_app_locale_timezone']);
}

session_start();

$hit = new Devinfrance_Hit();
$hit->start();

$GLOBALS['location'] = "index.php";

$content = new Devinfrance_Content(isset($_GET['content']) ? $_GET['content'] : "");
$block = new Devinfrance_Block();
$page = new Devinfrance_Page($content);

$page->add_css("medias/css/styles.css");
$page->add_css("medias/css/colorbox.css");
$page->add_css("medias/css/mobiles.css");

$page->add_js("medias/js/display.js");
$page->add_js("medias/js/jquery-1.7.2.js");
$page->add_js("medias/js/jquery.functions.js");
require $content->file();

$hit->stop();
$hit->add();