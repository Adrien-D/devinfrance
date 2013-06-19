<?php
/*
	opentime
	$Author: frank $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/area.inc.php $
	$Revision: 5513 $

	Copyright (C) No Parking 2012 - 2012
*/

class Form_Area extends Area {
	public $name = "";
	public $id = "";
	public $action = "";
	public $fields = array();
	public $method = "post";
	public $operations = array();
	public $navigation = "";
	public $enctype = "application/x-www-form-urlencoded";
	public $length = 0;

	function show_length() {
		if ($this->length > 0) {
			return "<ul class=\"infos\"><li><p><span>".$this->length."</span></p></li></ul>";
		}
	}
	
	function show_operations() {
		if (sizeof($this->operations)) {
			$html = "<ul class=\"operations\">";
			$html .= "<li>";
			$html .= "<select name=\"operations[]\" onchange=\"if (this.value != '' && Check('".$GLOBALS['status_confirm']."')) form.submit();\">";
			$html .= "<option value=\"\"></option>";
			foreach ($this->operations as $value => $label) {
				$html .= "<option value=\"".$value."\">".$label."</option>";
			}
			$html .= "</select>";
			$html .= "</li>";
			$html .= "<li class=\"divider\"></li>";
			$html .= "<li><a href=\"#\" class=\"add-all\">".$GLOBALS['txt_addall']."</a></li>";
			$html .= "<li class=\"divider\"></li>";
			$html .= "<li><a href=\"#\" class=\"remove-all\">".$GLOBALS['txt_removeall']."</a></li>";
			$html .= "</ul>";
			
			return $html;
		} else {
			return "";
		}
	}

	function show() {
		$string = "<div class=\"content_working content_form\">";
		
		$extra = "";
		if (!empty($this->id)) {
			$extra .= " id=\"".$this->id."\"";
			if (empty($this->name)) {
				$this->name = $this->id;
			}
		}
		if (!empty($this->name)) {
			$extra .= " name=\"".$this->name."\"";
		}
		$extra .= " action=\"".$this->action."\"";
		$extra .= " method=\"".$this->method."\"";
		$extra .= " enctype=\"".$this->enctype."\"";
		$string .= "<form class=\"form_area\"".$extra.">";

		$string .= "<div class=\"length-top clearfix\">".$this->show_length()."</div>";
		if ($this->length > 10) {
			$string .= "<div class=\"operations-top clearfix\">".$this->show_operations()."</div>";
		}
		
		foreach ($this->fields as $name => $value) {
			$field = new Html_Input($name, $value, "hidden");
			$string .= $field->input();
		}
		
		$string .= $this->data;
		
		$string .= "<div class=\"operations-bottom clearfix\">".$this->show_operations()."</div>";
		
		$string .= "</form>";
		$string .= $this->navigation;
		$string .= "</div>";

		return $string;
	}
}