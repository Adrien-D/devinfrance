<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/contents/home.php $
	$Revision: 823 $

	Copyright (C) No Parking 2012 - 2013
*/
$page->isfrontoffice = true;
echo $page->show(
	"<h1>".__("Team")."</h1>",
	array(
		'value' => $block->show("team-noparking"),
		'class' => "medium",
	),
	array(
		'value' => $block->show("team-crezeo"),
		'class' => "medium",
	),
	array(
		'value' => $block->show("team-vcult"),
		'class' => "medium",
	),
	array(
		'value' => $block->show("team-balumpa"),
		'class' => "medium",
	)
);
