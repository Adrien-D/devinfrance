<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/sites.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/

$directory_medias = dirname(__FILE__)."/../../medias/images/sites/";

$html = "<div class=\"Title\">".__("Sites")."</div>";
if (isset($_POST['operations'])) {
	$operation = determine_operation($_POST['operations']);
	$sites = new Devinfrance_Sites();
	$sites->id = array_keys($_POST['site']);
	$sites->select();
	switch ($operation) {
		case "refresh" :
			$sites->add_image($directory_medias);
			break;
		case "visit":
			$sites->visit();
			break;
		case "delete":
			$sites->delete();
			break;
		case "mail":
			$html .= $sites->send();
			break;
	}
}

$sites = new Devinfrance_Sites();
$sites->set_limit($GLOBALS['param']['commons_app_nb_records'], isset($_GET['init']) ? (int)$_GET['init'] : 0);
$sites->calc_found_rows(true);
$sites->set_order("date_update", "DESC");
$sites->select();

$area = new Form_Area();
$area->id = "form_devinfrance_sites";
$area->data = $sites->manage();
$area->length = $sites->found_rows();
$area->operations = $sites->operations();
$area->navigation = $sites->pagination();
echo $page->show($html.$area->show());