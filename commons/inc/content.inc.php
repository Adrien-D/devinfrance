<?php
/*
	application ofr
	$Author: maxime $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/content.inc.php $
	$Revision: 572 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_Content {
	public $content;
	public $context;
	public $contents_path;
	
	function __construct($content = "", $contents_path = null) {
		$this->content = $content;
		
		if ($contents_path === null) {
			$this->contents_path = dirname(__FILE__)."/../contents";
		} else {
			$this->contents_path = $contents_path;
		}
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
				return realpath($this->contents_path.$this->context()."/home.php");
			case !preg_match("/^[a-z0-9_]*\.php$/", $this->content):
			case !file_exists($this->contents_path.$this->context()."/".$this->content):
				return realpath(dirname(__FILE__)."/../contents/404.php");
			default:
				return realpath($this->contents_path.$this->context()."/".$this->content);
		}
	}
}
