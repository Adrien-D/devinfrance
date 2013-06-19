<?php
/*
	application commons
	$Author: maxime $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/cli/bot.php $
	$Revision: 571 $

	Copyright (C) No Parking 2012 - 2013
*/

require dirname(__FILE__)."/../inc/require.inc.php";

if (isset($argv)) {
	$args = array_slice($argv, 1);
} else {
	$args = $_GET;
}

$bot = new Commons_Bot();

$i = 0;
foreach ($args as $arg) {
	$arg = str_replace("--", "", $arg);
	if (!preg_match("/=/", $arg)) {
		$i++;
		$actions[$i] = array();
		$actions[$i]['method'] = $arg;
	} else {
		list($argument, $value) = explode("=", $arg);
		$actions[$i]['elements'][$argument] = $value;
	} 
}
	
foreach ($actions as $action) {
	if (method_exists($bot, $action['method'])) {
		if (isset($action['elements']) and is_array($action['elements'])) {
			return $bot->{$action['method']}($action['elements']);
		} else {
			return $bot->{$action['method']}();
		}
	} else {
		return $bot->help();
	}
}
