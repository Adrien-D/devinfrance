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
	array(
			'value' => $page->title_capacity(),
	),
	array(
		'value' => "<div class=\"actionlectures\">Contact</div>"."<div id=\"title\" class=\"line\"></div>",
		'class' => "big_title",
	),
	array(
			'value' => "",
			'class' => "clear",
	)
);
