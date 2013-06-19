<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/devinfrance/contents/contact.php $
	$Revision: 833 $

	Copyright (C) No Parking 2012 - 2013
*/

$author = new Devinfrance_Author();
$author->load(array('id' => (int)$_GET['id']));

$propositions = new Devinfrance_Propositions();
$propositions->authors_id = $_GET['id'];
$propositions->set_order("date_insert", "DESC");
$propositions->select();

$page->isfrontoffice = true;
$page->title = $author->name;
echo $page->show(
	array(
			'value' => $page->title_capacity(),
	),
	array(
		'value' => $author->show().$propositions->show_short(),
		'class' => "",
	),
	array(
		'value' => $block->show("action-proposition"),
		'class' => "small",
	)
);
