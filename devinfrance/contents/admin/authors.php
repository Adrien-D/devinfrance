<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/authors.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/


$html = "<div class=\"Title\">".__("Authors")."</div>";
if (isset($_POST['operations'])) {
	$operation = determine_operation($_POST['operations']);
	$authors = new Devinfrance_Authors();
	$authors->id = array_keys($_POST['author']);
	$authors->select();
	switch ($operation) {
		case "delete":
			$authors->delete();
			break;
	}
}

$authors = new Devinfrance_Authors();
$authors->set_limit($GLOBALS['param']['commons_app_nb_records'], isset($_GET['init']) ? (int)$_GET['init'] : 0);
$authors->calc_found_rows(true);
$authors->set_order("name", "ASC");
$authors->select();

$area = new Form_Area();
$area->id = "form_devinfrance_authors";
$area->data = $authors->manage();
$area->length = $authors->found_rows();
$area->operations = $authors->operations();
$area->navigation = $authors->pagination();
echo $page->show($html.$area->show());