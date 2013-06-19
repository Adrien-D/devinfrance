<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/developers.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/

$html = "<div class=\"Title\">".__("Last figures")."</div>";

$last_type_results = new Devinfrance_Typeresults();
$last_type_results->select();


$area = new Form_Area();
$area->id = "form_devinfrance_type_result";
$area->data = $last_type_results->manage();
echo $page->show($html.$area->show());