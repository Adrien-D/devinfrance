<?php
/*
	application ofr
	$Author: david $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/page_admin.inc.php $
	$Revision: 1028 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_Page_Admin extends Commons_Page {
	function actions() {
		return "";
	}

	function navigation() {
		$section = preg_replace("/\.php/", "", $this->content->content);
		$section = preg_replace("/_.*$/", "", $section);
		
		$html_branches = "<ul class=\"branches\">";
		$html_leaves = "";
		foreach ($this->pages() as $branch) {
			$class_branches = "";
			if (preg_match("/^".$section."/", $branch['content'])) {
				$class_branches = " class=\"selected\"";
				
				if (isset($branch['leaves'])) {
					$html_leaves = "<ul class=\"leaves\">";
					foreach ($branch['leaves'] as $leaf) {
						$class_leaves = "";
						if ($leaf['content'] == $this->content->content) {
							$class_leaves = " class=\"selected\"";
						}
						$html_leaves .= "<li".$class_leaves.">".Html_Tag::a("admin.php?content=".$leaf['content'], $leaf['title'])."</li>";
					}
					$html_leaves .= "</ul>";
				}
			}
			$title = "";
			if (isset($branch['image'])) {
				$title .= "<img src=\"".$branch['image']."\"> ";
			}
			$title .= $branch['title'];
			$html_branches .= "<li".$class_branches.">".Html_Tag::a("admin.php?content=".$branch['content'], $title)."</li>";
		}
		$html_branches .= "</ul>";
		
		return "<nav class=\"navigation clearfix\" role=\"navigation\">".$html_branches.$html_leaves."</nav>";
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
		$status = show_status();
		header("Content-Type: text/html; charset=UTF-8");
		return <<<HTML
			<!DOCTYPE html>
			<html>
				<head>
					<meta charset="utf-8"> 
			   		<meta name="author" content="No Parking"> 
			   		<meta name="viewport" content="width=device-width, maximum-scale=1" />
					<title>Administration | {$GLOBALS['param']['commons_app_name']}</title>
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
						{$status}
HTML;
	}
	
	function footer() {
		return "
						<footer class=\"footer\">
							<div class=\"credits-content clearfix\">
								<a class=\"noparking-credit\" href=\"http://www.noparking.net/\" target=\"_blank\">© 2012 - 2013 No Parking</a>
							</div>	
						</footer>
					</div>
				</body>
			</html>
		";
	}
}
