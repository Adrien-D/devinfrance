<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/site.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/

$directory_medias = dirname(__FILE__)."/../../medias/images/sites/";
$url_medias = $GLOBALS['param']['devinfrance_uri']."medias/images/sites/";

$html = "";
$html2 = "";
$html1 = "<div class=\"Title\">".__("New site")."</div>";


$site_id = isset($_GET['id_sites']) ? (int)$_GET['id_sites'] : 0;

if (isset($_POST['site']) and is_array($_POST['site'])) {
	$site = new Devinfrance_Site();
	$site->load(array('id' => (int)$_POST['site']['id']));
	
	switch ($_POST['site']) {
		case "delete":
			if ($site->load(array('id' => (int)$_POST['site']['id']))) {
				$site->delete();
			}
			break;
		case "edit":
		default:
			$site->fill($_POST['site']);
			$site->save();
			$site_id = $site->id;
			
			$site->directory_medias = $directory_medias;
			$site->url_medias = $url_medias;
			
			if(isset($_POST['confirm'])) {
				switch ($_POST['confirm']) {
					case "auto" :
						$site->add_image("", $site->directory_medias);
						break;
					case "file" : 
						if (isset($_FILES['upload'])) {
							$site->add_image($_FILES['upload'], $site->directory_medias);
						}
						break;
					case "nothing":
					default :
					break;
				}
			}
			break;
	}
}

$site = new Devinfrance_Site();
$site->directory_medias = $directory_medias;
$site->url_medias = $url_medias;
if ($site_id > 0) {
	$site->load(array('id' => $site_id));
	
	$html1 =  "";
	$html .= "<div class=\"Title\">".__("Files")."</div>";
}


$files = new Devinfrance_Files();
$files->sites_id = $site_id;
$files->set_order("date_insert", "DESC");
$files->select();

$last_result = new Devinfrance_Results();
if (isset($files[0])) {
	$last_result->files_id = $files[0]->id;
	$last_result->date_insert = $files[0]->date_insert;
	$last_result->calc_found_rows(true);
	$last_result->set_order("date_insert", "DESC");
	$last_result->select();
	$html2 = "<div class=\"Title\">".__("Last result")."</div>";
	if (!(isset($last_result[0]))) {
		$html2 .= "aucun résultat trouvé";
	}
}


echo $page->show($html1.$site->edit().
				$html2.$last_result->show().
				$html.$files->show());