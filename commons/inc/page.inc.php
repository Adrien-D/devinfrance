<?php
/*
	application commons
	$Author: MrRayures $
	$URL: svn://svn.noparking.net/var/repos/projets/opentime.fr/applications/ofr/inc/page.inc.php $
	$Revision: 792 $

	Copyright (C) No Parking 2012 - 2013
*/

class Commons_Page {
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
	
	function url($content, $parameters = array()) {
		$url = "";
		
		if ($GLOBALS['param']['commons_web_urlrewriting']) {
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
		if ($GLOBALS['param']['commons_web_minifycss']) {
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
		if ($GLOBALS['param']['commons_web_minifyjs']) {
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
			return $this->title." | ".$GLOBALS['param']['commons_app_name'];
		} else {
			return $GLOBALS['param']['commons_app_name'];
		}
	}
	
	function rss() { }
	
	function beta() { }
	
	function logo() { }
	
	function baseline() { }
	
	function navigation() {	}
	
	function actions() { }
	
	function header() { }
	
	function footer() { }

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

	function show() {
		$arguments = func_get_args();
		switch (count($arguments)) {
			case 0:
				$content = "";
				break;
			case 1:
				$content = "{$arguments[0]}";
				break;
			default:
				$content = "";
				foreach ($arguments as $i => $argument) {
					$content .= "{$argument}";
				}
				break;
		}
	
		$content = "<div class=\"main\"><div class=\"page-content\"><div class=\"container_3 clearfix\">".$content."</div><div class=\"shadow\"></div></div></div>";
	
		return $this->header().$this->top().$content.$this->footer();
	}

	function redirect($url) {
		header("Location: ".$url);
		exit();
	}
}
