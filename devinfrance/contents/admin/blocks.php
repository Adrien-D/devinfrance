<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/blocks.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/

$html = "<div class=\"Title\">".__("Blocks")."</div>";
if (isset($_POST['operations'])) {
	$operation = determine_operation($_POST['operations']);
	$blocks = new Devinfrance_Blocks();
	$blocks->id = array_keys($_POST['block']);
	$blocks->select();
	switch ($operation) {
		case "delete":
			$blocks->delete();
			break;
	}
}

$blocks = new Devinfrance_Blocks();
$blocks->set_limit($GLOBALS['param']['commons_app_nb_records'], isset($_GET['init']) ? (int)$_GET['init'] : 0);
$blocks->calc_found_rows(true);
$blocks->set_order("date_update", "DESC");
$blocks->select();

$area = new Form_Area();
$area->id = "form_devinfrance_blocks";
$area->data = $blocks->manage();
$area->length = $blocks->found_rows();
$area->operations = $blocks->operations();
$area->navigation = $blocks->pagination();

echo $page->show($html.$area->show());