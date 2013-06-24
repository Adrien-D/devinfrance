<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/cfg/config.inc.php.dist $
	$Revision: 5958 $

	Copyright (C) No Parking 2012 - 2013
*/

## software config
$config['name'] = "Commons";		// nom de l'application
$config['version'] = "1";		// version de l'application
$config['title'] = "Dossier commun aux applications";		// titre de l'application tel qu'il apparaît dans la fenêtre du navigateur

## URL config
$config['root_url'] = "";		// adresse - de type URL - de l'application. Note : ne pas mettre de slash à la fin.
$config['external_url'] = "";		// adresse - de type URL - d'une autre version de l'application. Note : ne pas mettre de slash à la fin.

## define path to 'mysqldump' function
$config['mysqldump']              = "mysqldump";		// exemple de commande sous windows : c:/program files/wamp/mysql/bin/mysqldump.exe; exeple de commande sous linux : /usr/local/mysql/bin/mysqldump

## database config
$dbconfig['type'] = "mysql";		// type de serveur de la base de données (mysql, par défaut)
$dbconfig['host'] = "localhost";		// nom du serveur de la base de données (localhost, par défaut)
$dbconfig['user'] = "root";		// login de l'application pour accéder à la base de données
$dbconfig['pass'] = "";		// mot de passe de l'application pour accéder à la base de données
$dbconfig['name'] = "devinfrance";		// nom de la base de données
$dbconfig['new'] = "0";		// forcer la création d'une nouvelle connexion

$dbconfig['table_commons_users'] = "commons_users";		// création de la table commons users

$config['commons_version'] = "7";