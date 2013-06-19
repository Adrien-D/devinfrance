<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/proposition.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/

$destination_image = dirname(__FILE__)."/../../medias/images/propositions/";

$proposition_id = isset($_GET['id_propositions']) ? (int)$_GET['id_propositions'] : 0;

if (isset($_POST['proposition'])) {
	$proposition = new Devinfrance_Proposition();
	switch ($_POST['proposition']) {
		case "delete":
			if ($proposition->load(array('id' => (int)$_POST['proposition']['id']))) {
				$proposition->delete();
			}
			break;
		case "edit":
		default:
			$proposition->fill($_POST['proposition']);
                        if (is_url($destination_image))
			$proposition->add_image($destination_image);
			$proposition->save();
			$proposition_id = $proposition->id;
	}
}
$html = "<div class=\"Title\">".__("New proposition")."</div>";
$proposition = new Devinfrance_Proposition();
if ($proposition_id > 0) {
	$proposition->load(array('id' => $proposition_id));
	$html = "";
}

echo $page->show($html.$proposition->edit());