<?php
/*
 application devinfrance
$Author: manon.polle $
$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/author.php $
$Revision: 885 $

Copyright (C) No Parking 2012 - 2013
*/

$html = "<div class=\"Title\">".__("New author")."</div>";
$author_id = isset($_GET['id_authors']) ? (int)$_GET['id_authors'] : 0;

if (isset($_POST['author']) and is_array($_POST['author'])) {
	$author = new Devinfrance_Author();
	switch ($_POST['author']) {
		case "delete":
			if ($author->load(array('id' => (int)$_POST['author']['id']))) {
				$author->delete();
			}
			break;
		case "edit":
		default:
			$author->fill($_POST['author']);
			$author->save();
			$author_id = $author->id;
	}
}
$author = new Devinfrance_Author();
if ($author_id > 0) {
	$author->load(array('id' => $author_id));
}
$propositions = new Devinfrance_Propositions();
$propositions->authors_id = $author_id;
$propositions->select();

echo $page->show($html.$author->edit().$propositions->show_short());