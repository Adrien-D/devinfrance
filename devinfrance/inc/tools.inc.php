<?php
/*
	application ofr
	$Author: frank $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/tools.inc.php $
	$Revision: 940 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Tools {
	static function remote_address() {
		if ($_SERVER) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$remote_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$remote_address = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				$remote_address = $_SERVER['REMOTE_ADDR'];
			}
		} else {
			if (getenv('HTTP_X_FORWARDED_FOR')) {
				$remote_address = getenv('HTTP_X_FORWARDED_FOR');
			} elseif (getenv('HTTP_CLIENT_IP')) {
				$remote_address = getenv('HTTP_CLIENT_IP');
			} else {
				$remote_address = getenv('REMOTE_ADDR');
			}
		}
		return $remote_address;
	}
}
