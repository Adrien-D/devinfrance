<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/devinfrance/contents/contact.php $
	$Revision: 833 $

	Copyright (C) No Parking 2012 - 2013
*/

$directory_propositions = dirname(__FILE__)."/../medias/images/propositions/";
$url_propositions = $GLOBALS['param']['devinfrance_uri']."medias/images/propositions/";
$url = $GLOBALS['param']['devinfrance_uri']."index.php?content=propositions.php&init=0";

$start = isset($_GET['init'])? $_GET['init'] : 0;

$propositions = new Devinfrance_Propositions();
$propositions->set_order("date_insert", "DESC");
$propositions->calc_found_rows(true);
if (isset($_POST['confirm'])) {
	if (($_POST['authors']!= 0)) {
		$url .= "&author=".$_POST['authors'];
	}
	header("Location:".$url);
}
if (isset($_GET['author'])) {
	$propositions->authors_id = isset($_GET['author'])? $_GET['author'] : 0;
}
$propositions->select();
$count = $propositions->count();
$propositions->set_limit(5, $start);
$propositions->select();

$authors = new Devinfrance_Authors();
$authors->select();
$propositions_filter = new Devinfrance_Propositions();
$propositions_filter->set_order("date_insert", "DESC");
$propositions_filter->select();

$page->isfrontoffice = true;
$page->title = __("Propositions");
echo $page->show(
	array(
		'value' => $page->title_capacity(),
	),
	array(
		'value' => $block->show("action-lectures")."<div id=\"title\" class=\"line\"></div>",
		'class' => "big_title",
	),
	array(
		'value' => $propositions->show($directory_propositions, $url_propositions),
		'class' => "propositions",
	)
);
