<?php
/*
	application commons
	$Author: bodart $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/form_page_control.inc.php $
	$Revision: 5938 $

	Copyright (C) No Parking 2012 - 2013
*/

class Form_Page_Control {
	public $content;
	public $total;

	function __construct($content, $total) {
		$this->content = $content;
		$this->total = $total;
	}

	function show($init = null) {
		$html = "";

		if ($this->total) {
			if (!isset( $GLOBALS['param']['nb_records'])) {
				trigger_error("\$GLOBALS['param']['nb_records']) is undefined", E_USER_ERROR);
			} else if ($GLOBALS['param']['nb_records'] <= 0) {
				trigger_error("\$GLOBALS['param']['nb_records']) must be greater than 0", E_USER_ERROR);
			} else {
				$nbpages = ceil($this->total / $GLOBALS['param']['nb_records']);

				$html = "<ul class=\"pager clearfix\"><li class=\"page\">".$GLOBALS['txt_page']."</li>";
				for ($i = 1; $i <= $nbpages; $i++) {
					$current_init = ($i-1) * $GLOBALS['param']['nb_records'];

					if (is_numeric($init) and $init == $current_init) {
						$html .= "<li class=\"currentpage\">".$i."</li>";
					} else {
						$html .= "<li><a href=\"".link_content($this->content."&amp;init=".$current_init)."\">".$i."</a></li>";
					}
				}
				$html .= "</ul>";
				
			}
		}
		return $html;
	}
}
