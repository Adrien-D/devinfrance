<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/devinfrance/contents/contact.php $
	$Revision: 833 $

	Copyright (C) No Parking 2012 - 2013
*/
$directory_propositions = dirname(__FILE__)."/../medias/images/propositions/";
$url_propositions = $GLOBALS['param']['devinfrance_uri']."medias/images/propositions/";

$html = "";
$proposition = new Devinfrance_Proposition();
$proposition->load(array('id' => (int)$_GET['id']));

$vote = new Devinfrance_Vote();
$vote->propositions_id = $proposition->id;
$vote->remote_address = Devinfrance_Tools::remote_address();
if ($vote->match_existing(array("propositions_id", "remote_address"))) {
	$vote->load(array("propositions_id" => $proposition->id, "remote_address" => Devinfrance_Tools::remote_address()));
}
if (isset($_POST["button_vote".$proposition->id])) {
	if ($_POST["button_vote".$proposition->id] == "+1") {
		$vote->value = 1;
	} else {
		$vote->value = (int)(-1);
	}
	$vote->save();
}
$votes = new Devinfrance_Votes();
$votes->propositions_id = $proposition->id;
$votes->select();

$page->isfrontoffice = true;
$page->title = $proposition->title;
echo $page->show(
	array(
			'value' => $page->title_capacity(),
	),
	array(
		'value' => $html.$proposition->show($directory_propositions, $url_propositions, 0),
		'class' => "large",
	)
);
