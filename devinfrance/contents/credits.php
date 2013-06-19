<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/contents/home.php $
	$Revision: 823 $

	Copyright (C) No Parking 2012 - 2013
*/
$page->isfrontoffice = true;
$page->title = __("Credits");

echo $page->show(
	"<h1>".__("Credits")."</h1>",
	array(
		'value' => $block->show("details-credits"),
		'class' => "medium",
	),
	array(
		'value' => $block->show("action-liste"),
		'class' => "small",
	),
	array(
			'value' => "",
			'class' => "clear",
	)
);
