<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/devinfrance/contents/contact.php $
	$Revision: 833 $

	Copyright (C) No Parking 2012 - 2013
*/

$directory_medias = dirname(__FILE__)."/../medias/images/sites/";
$url_medias = $GLOBALS['param']['devinfrance_uri']."medias/images/sites/";
$directory_propositions = dirname(__FILE__)."/../medias/images/propositions/";
$url_propositions = $GLOBALS['param']['devinfrance_uri']."medias/images/propositions/";

$start = isset($_GET['init'])? $_GET['init'] : 0;

$sites = new Devinfrance_Sites();
$sites->set_order("date_insert", "DESC");
$sites->calc_found_rows(true);
$sites->set_limit(5, $start);
$sites->select();

$page->isfrontoffice = true;
$page->title = __("Sites");
echo $page->show(
	array(
			'value' => $page->title_capacity(),
	),
	array(
		'value' => $page->cadre_sites($url_medias, $directory_medias),
		'class' => "cadre",
	),
	array(
		'value' => "<div class=\"actionlectures\">Des sites qui comptent</div>"."<div id=\"title\" class=\"line\"></div>",
		'class' => "big_title",
	),
	array(
			'value'=> $sites->show($directory_propositions, $url_propositions),
			"class" => "sites",
	)
);
