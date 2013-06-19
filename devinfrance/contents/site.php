<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/devinfrance/contents/contact.php $
	$Revision: 833 $

	Copyright (C) No Parking 2012 - 2013
*/

$directory_medias = dirname(__FILE__)."/../medias/images/sites/";
$url_medias = $GLOBALS['param']['devinfrance_uri']."medias/images/sites/";

$site = new Devinfrance_Site();
if (isset($_POST['site'])) {
	if (isset($_POST['save'])) {
		$site->alert_errors(true);
		$site->fill($_POST['site']);
		if ($site->check()) {
			$site->save();
			if ($site->send("contact@devinfrance.fr")) {
				echo $page->show($site->thank());
			} else {
				echo $page->show($site->apologize());
			}
			exit();
			
		} else {
			$site->alert_errors(true);
		}
	} else {
		$site->fill($_POST['site']);
	}
}


$route = isset($_GET['route']) ? $_GET['route'] : "";

switch ($route) {
	case "get":
		$site->load(array('id' => (int)$_GET['id']));
		$site->directory_medias = $directory_medias;
		$site->url_medias = $url_medias;
					
		$title = __("Site: %s", array($site->name));
		$content = $site->show($directory_medias, $url_medias, 1, $site->id);

		$sidebar = $block->show("action-inscription");
		break;
	case "add":
	default:
		$page->body_classes = array("body-special-grid");
		$title = __("Want to add your site?");
		$content = $site->add();
		$sidebar = $block->show("details-inscription");
		break;
}

$page->isfrontoffice = true;
$page->title = $title;
echo $page->show(
	array(
		'value' => $page->title_capacity(),
	),
	array(
		'value' => $content,
		'class' => "list_site",
	),
	array(
		'value' => "<div class=\"cadre_inscription\" id=\"inscription_fixed\">".$sidebar."</div>",
		'class' => "large_clear",
	)
);
