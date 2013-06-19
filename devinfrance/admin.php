<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/devinfrance/admin.php $
	$Revision: 779 $

	Copyright (C) No Parking 2012 - 2013
*/

require dirname(__FILE__)."/../commons/inc/require.inc.php";

$GLOBALS['param']['devinfrance_web_minifycss'] = 0;
$GLOBALS['param']['devinfrance_web_minifyjs'] = 0;

session_start();

$content = new Devinfrance_Content(isset($_GET['content']) ? $_GET['content'] : "");
$block = new Devinfrance_Block();
$page = new Devinfrance_Page_Admin($content);
$page->add_js("./medias/js/display.js");
$page->add_js($GLOBALS['param']['devinfrance_opentime_medias_url']."medias/js/jquery.js");
$page->add_js($GLOBALS['param']['devinfrance_opentime_medias_url']."medias/js/jquery.form.js");
$page->add_js($GLOBALS['param']['devinfrance_opentime_medias_url']."medias/js/jquery.common.js");
$page->add_js($GLOBALS['param']['devinfrance_opentime_medias_url']."medias/js/common.js");
$page->add_js($GLOBALS['param']['devinfrance_opentime_medias_url']."medias/js/jquery.tablehover.js");
$page->add_css("medias/css/devinfrance.admin.css");

$content->context("/admin");
require $content->file();