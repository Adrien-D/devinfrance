<?php
/*
	application ofr
	$Author: manon.polle $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/page_admin.inc.php $
	$Revision: 889 $

	Copyright (C) No Parking 2012 - 2013
*/


class Devinfrance_Page_Admin extends Devinfrance_Page {
	
	function actions() {
		$content = $GLOBALS['content']->content; 
		switch (true) {
			case (preg_match("/author/", $content)):
			case (preg_match("/proposition/", $content)):
				return "
				<div id=\"actions\">
					<ul>
						<li><a href=\"admin.php?content=propositions.php\">".__("List propositions")."</a></li>
						<li><a href=\"admin.php?content=proposition.php\">".__("New proposition")."</a></li>
						<li><a href=\"admin.php?content=authors.php\">".__("List authors")."</a></li>
						<li><a href=\"admin.php?content=author.php\">".__("New author")."</a></li>
					</ul>
				</div>
				";
			case (preg_match("/file/", $content)):
			case (preg_match("/site/", $content)):
				return "
				<div id=\"actions\">
					<ul>
						<li><a href=\"admin.php?content=site.php\">".__("New site")."</a></li>
						<li><a href=\"admin.php?content=sites.php\">".__("List sites")."</a></li>
						<li><a href=\"admin.php?content=files.php\">".__("List files")."</a></li>
					</ul>
				</div>
				";
			case (preg_match("/block/", $content)):
				return "
				<div id=\"actions\">
				<ul>
				<li><a href=\"admin.php?content=block.php\">".__("New block")."</a></li>
				<li><a href=\"admin.php?content=blocks.php\">".__("List blocks")."</a></li>
				</ul>
				</div>
				";
			case (preg_match("/result/", $content)):
				return "
				<div id=\"actions\">
					<ul>
						<li><a href=\"admin.php?content=results.php\">".__("List results")."</a></li>
						<li><a href=\"admin.php?content=results.php&last=true\">".__("Last results")."</a></li>
						<li><a href=\"admin.php?content=results_details.php\">".__("Last figures")."</a></li>
					</ul>
				</div>
				";
			default:
				return "";
		}
	}


	function navigation() {
		$pages = array(
			'home.php' => __("Home"),
			'hits.php' => __("Hits"),
			'propositions.php' => __("Propositions"),
			'sites.php' => __("Sites"),
			'results.php' => __("Results"),
			'blocks.php' => __("Blocks"),
		);
		
		$actions = array(
			"" => __("Home"),
			"block.php" => __("Blocks"),
			"blocks.php" => __("Blocks"),
			"author.php" => __("Propositions"),
			"authors.php" => __("Propositions"),
			"proposition.php" => __("Propositions"),
			"propositions.php" => __("Propositions"),
			"results_details.php" => __("Results"),
			"results.php" => __("Results"),
			"file.php" => __("Sites"),
			"files.php" => __("Sites"),
			"site.php" => __("Sites"),
			"sites.php" => __("Sites"),
		);
		
		$html = "";
		foreach ($pages as $content_page => $title_page) {
			$content = "";
			$title = "";
			if (array_key_exists((string)$this->content->content, $actions)) {
				$content = $this->content->content;
				$title = $actions[(string)$this->content->content];
			}
			if ($this->content instanceof Devinfrance_Content && (($this->content->content == $content_page) || ($title == $title_page))) {
				$html .= "
					<li class=\"selected\">
						<strong><a href=\"admin.php?content=".$content_page."\">".$title_page."</a></strong>
					</li>";
			} else {
				$html .= "
					<li>
						<a href=\"admin.php?content=".$content_page."\">".$title_page."</a>
					</li>";
			}
		}
		
		return "
			<nav id=\"navigation\" class=\"navigation clearfix\" role=\"navigation\">
				<ul>".$html."</ul>
				".show_status()."
			</nav>
		";
	}
	
	function header() {
		$classes = array();
		if (isset($GLOBALS['content'])) {
			if (!empty($GLOBALS['content']->content)) {
				$classes[] = Format::body_class($GLOBALS['content']->content);
			}
			if (!empty($GLOBALS['content']->context)) {
				$classes[] = Format::body_class($GLOBALS['content']->context);
			}
		}
		$class = join(" ", $classes);
		header("Content-Type: text/html; charset=UTF-8");
		return <<<HTML
			<!DOCTYPE html>
			<html>
				<head>
					<meta charset="utf-8"> 
			   		<meta name="author" content="No Parking"> 
			   		<meta name="viewport" content="width=device-width, maximum-scale=1" />
					<title>Administration | Devinfrance.fr</title>
					{$this->css()}
					{$this->js()}
					<link rel="shortcut icon" href="medias/favicon.ico" />
				</head>
				<body class="{$class}">
					<div class="global">
						<header class="header">
							<div class="header-content">
								{$this->logo()}
								<!--<a class="mobi-menu" href="#navigation">Menu</a>-->
								{$this->navigation()}
								<div class="clear"></div>
							</div>
						</header>
						{$this->beta()}
						{$this->actions()}
						
HTML;
	}
	
	function footer() {
		return "
						<footer class=\"footer\">
							<div class=\"credits-content clearfix\">
								<a class=\"noparking-credit\" href=\"http://www.noparking.net/\" target=\"_blank\">© 2011 No Parking</a>
							</div>	
						</footer>
					</div>
				</body>
			</html>
		";
	}
}
