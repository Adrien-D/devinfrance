<?php
/*
	application devinfrance
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/hits.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/

$html = "<div class=\"Title\">".__("Hits")."</div>";
$hits = new Devinfrance_Hits();
$hits->set_limit($GLOBALS['param']['nb_records'], isset($_GET['init']) ? (int)$_GET['init'] : 0);
$hits->calc_found_rows(true);
$hits->noparking = $GLOBALS['param']['devinfrance_noparking_ip'];
$hits->set_order("date_update", "DESC");
$hits->select();

$area = new Working_Area($hits->show());
echo $page->show($html.$area->show());