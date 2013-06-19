<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/propositions.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/


$html = "<div class=\"Title\">".__("Propositions")."</div>";
if (isset($_POST['operations'])) {
	$operation = determine_operation($_POST['operations']);
	$propositions = new Devinfrance_Propositions();
	$propositions->id = array_keys($_POST['proposition']);
	$propositions->select();
	switch ($operation) {
		case "delete":
			$propositions->delete();
			break;
	}

}

$propositions = new Devinfrance_Propositions();
$propositions->set_limit($GLOBALS['param']['nb_records'], isset($_GET['init']) ? (int)$_GET['init'] : 0);
$propositions->calc_found_rows(true);
$propositions->set_order("date_update", "DESC");
$propositions->select();

$area = new Form_Area();
$area->id = "form_devinfrance_propositions";
$area->data = $propositions->manage();
$area->length = $propositions->found_rows();
$area->operations = $propositions->operations();
$area->navigation = $propositions->pagination();

echo $page->show($html.$area->show());