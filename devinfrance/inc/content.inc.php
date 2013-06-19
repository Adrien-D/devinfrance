<?php
/*
	application devinfrance
	$Author: maxime $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/content.inc.php $
	$Revision: 572 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Content {
	public $content;
	public $context;
	
	function __construct($content = "") {
		$this->content = $content;
	}
	
	function __toString() {
		return $this->context."::".$this->content;
	}

	function context($context = null) {
		if ($context !== null) {
			$this->context = $context;
		}
		return $this->context;
	}
	
	function file() {
		switch (true) {
			case $this->content == "":
			case $this->content == "home.php":
				return realpath(dirname(__FILE__)."/../contents".$this->context."/home.php");
			case !preg_match("/^[a-z0-9_]*\.php$/", $this->content):
			case !file_exists(dirname(__FILE__)."/../contents".$this->context()."/".$this->content):
				return realpath(dirname(__FILE__)."/../contents/404.php");
			default:
				return realpath(dirname(__FILE__)."/../contents".$this->context()."/".$this->content);
		}
	}
}
