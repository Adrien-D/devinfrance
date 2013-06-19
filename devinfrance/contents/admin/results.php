<?php
/*
	application ofr
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/contents/admin/home.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/

$html = "<div class=\"Title\">".__("Results")."</div>";

if (isset($_POST['operations'])) {
	$operation = determine_operation($_POST['operations']);
	$results = new Devinfrance_Results();
	$results->id = array_keys($_POST['result']);
	$results->select();
	switch ($operation) {
		case "delete":
			$results->delete();
			break;
	}
}
if (isset($_GET['last'])) {
	$html = "<div class=\"Title\">".__("Last results")."</div>";
	$results_id[] = array();
	$sites = new Devinfrance_Sites();
	$sites->select();
	foreach ($sites as $site) {
		$files = new Devinfrance_Files();
		$files->sites_id = $site->id;
		$files->set_order("date_insert", "DESC");
		$files->set_limit(1);
		$files->select();
		if (isset($files[0])) {
			$results = new Devinfrance_Results();
			$results->files_id = $files[0]->id;
			$results->date_insert = $files[0]->date_insert;
			$results->select();
			foreach ($results as $result) {
				$results_id[] = $result->id;
			}
		}
	}
}

$results = new Devinfrance_Results();
$results->type_filter = isset($_GET['type']) ? $_GET['type'] : null;
$results->filter = isset($_GET['filter']) ? $_GET['filter'] : null;
$results->set_limit($GLOBALS['param']['nb_records'], isset($_GET['init']) ? (int)$_GET['init'] : 0);
$results->calc_found_rows(true);
if (isset($results_id)) { $results->id = $results_id;}
$results->set_order("date_insert", "DESC");
$results->select();

$area = new Form_Area();
$area->id = "form_devinfrance_results";
$area->data = $results->manage();
$area->length = $results->found_rows();
$area->operations = $results->operations();
$area->navigation = $results->pagination();

echo $page->show($html.$area->show());