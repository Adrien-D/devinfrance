<?php
/*
	application ofr
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/home.php $
	$Revision: 885 $

	Copyright (C) No Parking 2012 - 2013
*/


$page->add_js("medias/js/raphael-min.js");
$page->add_js("medias/js/popup.js");
$page->add_js("medias/js/jquery-1.7.2.js");
$page->add_js("medias/js/analytics.js");

$hits = new Devinfrance_Hits();
$hits->start = strtotime("-45days", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$hits->stop = time();
$hits->noparking = $GLOBALS['param']['devinfrance_noparking_ip'];
$hits->set_order("date_insert", "ASC");
$hits->select();

$current = $hits->start;
while ($current <= $hits->stop) {
	$nb_hits[$current] = 0;
	$current = strtotime("+1 day", $current);
}

foreach ($hits as $hit) {
	$current = mktime(0, 0, 0, date("m", $hit->date_insert), date("d", $hit->date_insert), date("Y", $hit->date_insert));
	$nb_hits[$current]++;
}


$index=0;
foreach ($nb_hits as $day => $nb) {
	$Labels[] = date("d/m/Y", $day);
	if( (date("d", $day) == 1) || ($index ==0) ){
		$Xaxis[] = date("dM", $day);
	}
	else{
		$Xaxis[] = date("d", $day);
	}
	$Stat[] = $nb;
	$index++;
}

$html = "<li class='tableau'>";
$html .= "<ul class='xAxis'>";
for ($i=0;$i<sizeof($Xaxis);$i++) {
	$html .= "<li>".$Xaxis[$i]."</li>";
}
$html .= "</ul>";

$html .="<ul class='Labels'>";
for ($i=0;$i<sizeof($Labels);$i++) {
	$html .= "<li>".$Labels[$i]."</li>";
}
$html .= "</ul>";

$html .= "<ul class='data'>";
$html .= "<li><ul data-legend='devinfrance.fr'>";
for ($i=0;$i<sizeof($Stat);$i++) {
	$html .= "<li>".$Stat[$i]."</li>";
}
$html .= "</ul></li>";
$html .= "</ul>";
$html .= "</li>";

$page->title = "Opentime";
$html .= "<div class='Title'>Nombre de hits sur les 45 derniers jours
	<div class='image' id='graph1'></div>
</div>";

$area = new Working_Area($html);
echo $page->show($area->show());
