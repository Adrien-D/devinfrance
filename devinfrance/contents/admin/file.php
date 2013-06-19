<?php
/*
 application devinfrance
$Author: manon.polle $
$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/file.php $
$Revision: 885 $

Copyright (C) No Parking 2012 - 2013
*/
$html ="";
$file_id = isset($_GET['id_files']) ? (int)$_GET['id_files'] : 0;

$file = new Devinfrance_File();
if ($file_id > 0) {
	$file->load(array('id' => $file_id));
	$html = "<div class=\"sub_Title\">".__("Results")."</div>";
}


$results = new Devinfrance_Results();
$results->files_id = $file_id;
$results->select();

echo $page->show($file->edit().$html.$results->show());