<?php
/*
	application ofr
	$Author: maxime $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/cli/bot.php $
	$Revision: 571 $

	Copyright (C) No Parking 2012 - 2013
*/

require dirname(__FILE__)."/../../commons/inc/require.inc.php";

if (isset($argv)) {
	$args = new arrayIterator(array_slice($argv, 1));
} else {
	$args = new arrayIterator(array_keys($_GET));
}


$bot = new Devinfrance_Bot();

foreach ($args as $arg) {
	$arg = str_replace("-", "", $arg);
	if (method_exists($bot, $arg)) {
		$return = $bot->$arg();
		if ($return === true or $return === false) {
			return $return;
		} else {
			echo $return;	
		}
	} else {
		echo $bot->help();
	}
}
