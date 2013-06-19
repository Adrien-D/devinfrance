<?php
/*
 application devinfrance
$Author: manon.polle $
$URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/contents/admin/block.php $
$Revision: 885 $

Copyright (C) No Parking 2012 - 2013
*/
$block_id = isset($_GET['id_blocks']) ? (int)$_GET['id_blocks'] : 0;

if (isset($_POST['block']) and is_array($_POST['block'])) {
	$block = new Devinfrance_Block();
	switch ($_POST['block']) {
		case "delete":
			if ($block->load(array('id' => (int)$_POST['block']['id']))) {
				$block->delete();
			}
			break;
		case "edit":
		default:
			$block->fill($_POST['block']);
			$block->save();
			$block_id = $block->id;
			break;
	}
}

$block = new Devinfrance_Block();
if ($block_id > 0) {
	$block->load(array('id' => $block_id));
}

echo $page->show($block->edit());