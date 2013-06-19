<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/contents/home.php $
	$Revision: 823 $

	Copyright (C) No Parking 2012 - 2013
*/

$directory_medias = dirname(__FILE__)."/../medias/images/sites/";
$url_medias = $GLOBALS['param']['devinfrance_uri']."medias/images/sites/";
$directory_propositions = dirname(__FILE__)."/../medias/images/propositions/";
$url_propositions = $GLOBALS['param']['devinfrance_uri']."medias/images/propositions/";

$start = isset($_GET['init'])? $_GET['init'] : 0;
$propositions = new Devinfrance_Propositions();
$propositions->set_order("date_insert", "DESC");
$propositions->set_limit(5, $start);
$propositions->calc_found_rows(true);
$propositions->select();

$page->isfrontoffice = true;
echo $page->show(
	array(
		'value' => $page->title_capacity(),
	),
	array(
		'value' => $page->cadre($url_medias, $directory_medias),
		'class' => "cadre",
	),
	array(
		'value' => $block->show("action-lectures")."<div id=\"title\" class=\"line\"></div>",
		'class' => "big_title",
	),
	array(
		'value' => $propositions->show($directory_propositions, $url_propositions),
		'class' => "propositions",
	),
	array(
			'value' => "",
			'class' => "clear",
	),
	array(
			'value' => "",
			'class' => "clear",
	)
);
