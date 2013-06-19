<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/page.inc.php $
	$Revision: 833 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Page {
	public $title = null;
	public $content = null;
	public $js;
	public $css;
	public $elements = array();
	
	function __construct($content = null) {
		$this->content = $content;
		$this->js = array();
		$this->css = array();
	}
	
	function add_css($files) {
		if (!is_array($files)) {
			$files = array($files);
		}
		
		foreach ($files as $file) {
			$this->css[] = $file;
		}
	}
	
	function css_minified() {
		$name = "";
		foreach ($this->css as $css) {
			$name .= $css;
		}
		return "<link rel=\"stylesheet\" type=\"text/css\" href=\"medias/css/".md5($name).".minified.css\" />";
	}
	
	function css_normal() {
		$html = "";
		foreach ($this->css as $css) {
			$html .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$css."\" />";
		}
		return $html;
	}
	
	function css() {
		if ($GLOBALS['param']['devinfrance_web_minifycss']) {
			return $this->css_minified();
		} else {
			return $this->css_normal();
		}
	}
	
	function add_js($files) {
		if (!is_array($files)) {
			$files = array($files);
		}
		
		foreach ($files as $file) {
			$this->js[] = $file;
		}
	}
	
	function js_minified() {
		$name = "";
		foreach ($this->js as $js) {
			$name .= $js;
		}
		return "<script type=\"text/javascript\" src=\"medias/js/".md5($name).".minified.js\"></script>";
	}
	
	function js_normal() {
		$html = "";
		foreach ($this->js as $js) {
			$html .= "<script type=\"text/javascript\" src=\"".$js."\"></script>";
		}
		return $html;
	}
	
	function js() {
		if ($GLOBALS['param']['devinfrance_web_minifyjs']) {
			return $this->js_minified();
		} else {
			return $this->js_normal();
		}
	}
	
	function add_top($top) {
		$this->top = $top;
	}
	
	function top() {
		if (!empty($this->top)) {
			return $this->top;
		}
	}
	
	function content_not_found() {
		header("HTTP/1.0 404 Not found");

		return <<<HTML
			<p>Page non trouvée</p>
HTML;
	}
	
	function title() {
		if (!empty($this->title)) {
			return $this->title." - Dev in France";
		} else {
			return "Dev in France";
		}
	}
	
	function beta() {
		return "";
	}
	
	function logo() {
		return "
			<h1 class=\"logo\">
				<a href=\"index.php\" title=\"Retour à l'accueil\">
					<img src=\"medias/images/devinfrance.png\" alt=\"Dev In France : se compter pour peser\" />
				</a>
			</h1>
		";		
	}
	
	function baseline() {
		return "<h1 class=\"baseline\">Se compter pour peser</h1>";		
	}
		
	function url($content, $parameters = array()) {
		$url = "";
		
		if ($GLOBALS['param']['devinfrance_web_urlrewriting']) {
			$url = array_shift(explode(".", $content));
			if (is_array($parameters) and count($parameters)) {
				if (isset($parameters['route'])) {
					$url .= "-".$parameters['route'];
					unset($parameters['route']);
				}
				$elements = array();
				foreach ($parameters as $key => $value) {
					$elements[] = $key."=".$value;
				}
				if (count($elements) > 0) {
					$url .= "?".join("&", $elements);
				}
			}
		} else {
			$url = "index.php?content=".$content;
			if (is_array($parameters) and count($parameters)) {
				$elements = array();
				foreach ($parameters as $key => $value) {
					$elements[] = $key."=".$value;
				}
				if (count($elements) > 0) {
					$url .= "&".join("&", $elements);
				}
			}
		}

		return $url;
	}
	
	function navigation() {
		$pages = array(
 			'sites.php' => __("Sites"),
 			'propositions.php' => __("Propositions"),
			'team.php' => __("Team"),
			'contact.php' => __("Contact"),
		);
		$html = "";
		foreach ($pages as $content => $title) {
			$pattern = preg_replace("/s*\.php/", "", $content);
			if ($this->content instanceof Devinfrance_Content and preg_match("/".preg_quote($pattern, "/")."/", $this->content->content)) {
				$html .= "
					<li class=\"selected\">
						<a href=\"".$this->url($content)."\">".$title."</a>
					</li>";
			} else {
				$html .= "
					<li>
						<a href=\"".$this->url($content)."\">".$title."</a>
					</li>";
			}
		}
		return "
			<nav id=\"navigation-mobile\" class=\"navigation\" role=\"navigation\">
				<ul>".$html."<li class=\"navigation-mobile-off\"><a href=\"#\">Fermer</a></li></ul>
			</nav>
		";
	}
		
	function actions() { }
	
	function header() {
		$classes = isset($this->body_classes) ? $this->body_classes : array();
		if (isset($GLOBALS['content'])) {
			if (!empty($GLOBALS['content']->content)) {
				$classes[] = Format::body_class($GLOBALS['content']->content);
			} else {
				$classes[] = "default";
			}
			if (!empty($GLOBALS['content']->context)) {
				$classes[] = Format::body_class($GLOBALS['content']->context);
			}
		}
		$class = join(" ", $classes);
		header("Content-Type: text/html; charset=UTF-8");
		return <<<HTML
		
<!doctype html> 
<html lang="fr"> 
<head>
	<meta charset="utf-8">
	<meta name="author" content="No Parking">
    <link rel="author" href="humans.txt" /> 
    <title>{$this->title()}</title>
    <meta name="description" content="Dev in France">
    <meta name="keywords"  content="devinfrance">
	<meta name="viewport" content="width=device-width">
	
	<link rel="shortcut icon" href="medias/favicon.ico" />
	<link rel="apple-touch-icon" href="medias/apple-touch-icon.png">
	
	{$this->css()}
	
	<!--[if lte IE 7]> 
		<link rel="stylesheet" type="text/css" href="medias/css/ie.css" />
	<![endif]--> 
	<!--[if lte IE 9]> 
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
	<![endif]--> 
	
</head>
<body class="{$class}">
	<header class="header" role="banner" id="top">
		<div class="header-content clearfix">
			
			{$this->menu()}
			<div class="clear"></div>
		</div>
	</header><!--/END Header-->
	
HTML;
	}
	function block($name) {
		$block = new Devinfrance_Block();
		return $block->show($name);
	} 

	function js_google_analytics() {
		if (!empty($GLOBALS['param']['ofr_web_analytics'])) {
			return "<script type=\"text/javascript\">
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', '".$GLOBALS['param']['ofr_web_analytics']."']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
			
			</script>";
		}
	}
	
	function footer() {
		$block = new Devinfrance_Block();
		return  <<<HTML
		<footer class="footer" role="contentinfo">
			<div class="container_3 clearfix">
				<div class="footer-deco"></div>
					<div class="footer-info">
						<div class="part">{$block->show('contact-devinfrance')}</div>
						<div class="part">{$this->down_menu()}	</div>		
						<div class="part">{$block->show('equipe-devinfrance')}</div>
					</div>
				</div>
			</div>
		</footer><!-- /END Footer  -->
		
		{$this->js()}
		{$this->js_google_analytics()}
	</body>
</html>
HTML;
	}

	function grid() {
		$arguments = func_get_args();
		$content = "";
		
		foreach ($arguments as $argument) {
			if (!is_array($argument)) {
				$content .= "<h1 class=\"page-title\">".$argument."</h1><div class=\"clear\"></div>";
			} else {
				$content .= "<div class=\"grid_".$argument['grid']."\">".$argument['value']."</div>";
			}
		}
		
		return $content;
	}
	
	function intermediate() { }
	
	function title_capacity() {
		$sites = new Devinfrance_Sites();
		return "<div class=\"count_title\" id=\"count_title\">
					<div class=\"count_sites\">".$sites->get_count()."</div>
					Dev. in France
				</div>";
	}
	
	function is_selected($onglet) {
		$pages = array (
				"" => "Accueil",
				"propositions.php" => "Propositions",
				"proposition.php" => "Propositions",
				"sites.php" => "Sites inscrits",
				"site.php" => "Sites inscrits",
				"contact.php" => "A Propos"
				);
		foreach ($pages as $url => $page) {
			if ($this->content == $url && $page == $onglet) {
				return true;
			}
		}
		return false;
	}
	
	function menu()  {
		$selected = array("accueil","sites","propositions","contact");
		if (preg_match("/site/", $this->content)) {
			$selected[1] = "selected";
		} else if (preg_match("/proposition/", $this->content)) {
			$selected[2] = "selected";
		} else if (preg_match("/contact/", $this->content)) {
			$selected[3] = "selected";
		} else {
			$selected[0] = "selected";
		}
		$block = new Devinfrance_Block();
		$html = "<table class=\"fixed_menu\" id=\"fixed_menu\"><tr>";
		$html .= "<td id=\"td_accueil\" class=\"accueil\" ><div id=\"accueil\" class=\"link_left\" ><a id=\"$selected[0]\" href=\"".$GLOBALS['param']['devinfrance_uri']."\">Accueil</a></div></td>";
		$html .= "<td id=\"td_sites\" class=\"sites\"><div id=\"sites\" class=\"link_left\" ><a id=\"$selected[1]\" href=\"".$this->url('sites.php&init=0')."\">Sites inscrits</a></div></td>";
		$html .= "<td><div id=\"title_menu\" class=\"title_menu\">".$block->show('baseline')."</div></td>";
		$html .= "<td id=\"td_propositions\" class=\"propositions\"><div id=\"propositions\" class=\"link_right\" ><a id=\"$selected[2]\" href=\"".$this->url('propositions.php&init=0')."\">Propositions</a></div></td>";
		$html .= "<td id=\"td_contact\" class=\"contact\"><div id=\"contact\" class=\"link_right\" ><a id=\"$selected[3]\" href=\"".$this->url('contact.php')."\">À propos</a></div></td></tr>";
		$html .= "</table>";
		;
		return $html;
	}
	
	function down_menu() {
		return "<div class=\"down_menu\">
					<a href=\"".$GLOBALS['param']['devinfrance_uri']."\">Accueil</a><br />
					<a href=\"".$this->url('sites.php&init=0')."\">Sites inscrits</a><br />
					<a href=\"".$this->url('propositions.php&init=0')."\">Propositions</a><br />
					<a href=\"".$this->url('contact.php')."\">A Propos</a><br />
				</div>";
		;
	}
	
	function gauge() {
		$block = new Devinfrance_Block();
		$sites = new Devinfrance_sites();
		$scale = ((550 / $GLOBALS['param']['devinfrance_goal']) == 0)? 1: (550 / $GLOBALS['param']['devinfrance_goal']);
		$max_gauge = $sites->get_count() * 550 / $GLOBALS['param']['devinfrance_goal'];
		$data_axis = ($sites->get_count()-1) * 550 / $GLOBALS['param']['devinfrance_goal'];
		return "<table class=\"fixed_menu\" id=\"hidden_menu\"><tr>
					<td><div class=\"title_menu\">".$block->show('baseline')."</div></td></tr>
				</table>
				<div class=\"gauge_top\"></div>
				<div class=\"gauge_first_number\">1</div>
				<div class=\"gauge_page\" style=\"height: ".($max_gauge)."px;\"></div>
				<div class=\"gauge_scale\">1&nbsp;dev&nbsp;|&nbsp;".($scale)."px</div>
				<div class=\"gauge_current\" style=\"margin-top: ".$data_axis."px;\">".$sites->get_count()."</div>
				<div class=\"gauge_goal\">OBJ.&nbsp;:&nbsp;".$GLOBALS['param']['devinfrance_goal']."</div>
			";
	}
		
	function cadre_sites($url_medias, $directory_medias) {
		$block = new Devinfrance_Block();
		$site = new Devinfrance_Site();
		return "<div class=\"left\">".
					$block->show("home-intro")."
				</div>
				<div class=\"right\">".
					$block->show("action-inscription").
					$block->show("details-technique")."
				</div>
			";
	}
				
	function cadre($url_medias, $directory_medias) {
		$block = new Devinfrance_Block();
		$sites = new Devinfrance_Sites();
		$sites->set_order("date_insert", "DESC");
		$sites->is_visited = true;
		$sites->set_limit(15);
		$sites->select();
		$site = new Devinfrance_Site();
		return "<div class=\"left\">".
					$block->show("home-intro").
					$block->show("action-inscription").
					$block->show("details-technique")."
				</div>
				<div class=\"right\">".
					$block->show("derniers-sites").
					"<div class=\"sites_thumbnails\">".
						$sites->show_thumbnails($url_medias, $directory_medias)."
					</div>
					<div class=\"tout_voir_link\">
						<img src=\"".$GLOBALS['param']['devinfrance_uri']."/medias/images/fleche.png\" alt=\"&#8594;\"/>".
						$block->show("tout-voir").$site->count_dev()."
					</div>
				</div>
			";
	}
				
	function show() {
		$content = "";
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (is_array($argument)) {
				$properties = "";
				foreach ($argument as $attribute => $value) {
					if ($attribute != "value") {
						$properties .= " ".$attribute."=\"".$value."\"";
					}
				}
				$content .= "<div".$properties.">".$argument['value']."</div>";
			} else {
				$content .= $argument;
			}
		}
	
		$content = "<div class=\"main\"><div class=\"page-content\"><div class=\"container_3 clearfix\">".$content."</div><div class=\"shadow\"></div></div></div>";
		if (isset($this->isfrontoffice)) {
			return $this->header().$this->gauge().$this->top().$content.$this->footer();
		}
		return $this->header().$this->top().$content.$this->footer();
	}

	function redirect($url) {
		header("SID: ".session_id());
		header("Location: ".$url);
		exit();
	}
}
