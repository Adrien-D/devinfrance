<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/files.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/

$html = "<div class=\"Title\">".__("Files")."</div>";
if (isset($_POST['operations'])) {
	$operation = determine_operation($_POST['operations']);
	$files = new Devinfrance_Files();
	$files->id = array_keys($_POST['file']);
	$files->select();
	switch ($operation) {
		case "delete":
			$files->delete();
			break;
	}
}

$files = new Devinfrance_Files();
$files->set_limit($GLOBALS['param']['nb_records'], isset($_GET['init']) ? (int)$_GET['init'] : 0);
$files->calc_found_rows(true);
$files->set_order("date_insert", "DESC");
$files->select();

$area = new Form_Area();
$area->id = "form_devinfrance_files";
$area->data = $files->manage();
$area->length = $files->found_rows();
$area->operations = $files->operations();
$area->navigation = $files->pagination();

echo $page->show($html.$area->show());