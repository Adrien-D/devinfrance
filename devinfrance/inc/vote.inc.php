<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2012
*/

class Devinfrance_Vote extends Record {
	public $id = 0;
        public $remote_address = "";
        public $propositions_id = 0;
        public $value = 0;
        public $date_insert = "";
	public $date_update = "";
	
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = (int)$id;
	}
	
	function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load($this->db->config['table_devinfrance_votes'], $properties);
		} else {
			return false;
		}
	}
	
	function delete() {
		$result = $this->db->query("
				DELETE FROM ".$this->db->config['table_devinfrance_votes']."
				WHERE id = ".(int)$this->id
		);
		$this->db->status($result[1], "d", __("vote"));
		 
		return (bool)$result[1];
	}
	
	function match_existing(array $patterns) {
		if (is_array($patterns) and count($patterns) > 0) {
			return parent::match_existing($this->db->config['table_devinfrance_votes'], $patterns);
		} else {
			return false;		
		}
	}
	
	function show() {
		$class_for = "vote_for";
		$class_against = "vote_against";
		$votes = new Devinfrance_Votes();
		if ($this->value == 1) {
			$src_for = $GLOBALS['param']['devinfrance_uri']."medias/images/like_hover.png";
			$src_against = $GLOBALS['param']['devinfrance_uri']."medias/images/dontlike.png";
			$disabled_for = "disabled = 'disabled'";
			$disabled_against = "";
			$class_for .= "_select";
		} else if ($this->value == -1) {
			$src_for = $GLOBALS['param']['devinfrance_uri']."medias/images/like.png";
			$src_against = $GLOBALS['param']['devinfrance_uri']."medias/images/dontlike_hover.png";
			$disabled_for = "";
			$disabled_against = "disabled = 'disabled'";
			$class_against .= "_select";
		} else {
			$src_for = $GLOBALS['param']['devinfrance_uri']."medias/images/like.png";
			$src_against = $GLOBALS['param']['devinfrance_uri']."medias/images/dontlike.png";
			$disabled_for = "";
			$disabled_against = "";
		}
		
		
		return "<form id=\"form_vote".$this->id."\" name=\"form_vote\" method=\"POST\" action=\"\" class=\"form_vote\">
					<input type=\"submit\" name=\"button_vote".$this->propositions_id."\" class=\"".$class_for."\" ".$disabled_for." id=\"".$class_for.$this->propositions_id."\" value=\"1\" style=\"background: url('".$src_for."') center center no-repeat;\" onmouseover=\"this.style.background='url(medias/images/like_hover.png) center center no-repeat'\" onmouseout=\"this.style.background='url(medias/images/like.png) center center no-repeat'\"/>
					/<input type=\"submit\" name=\"button_vote".$this->propositions_id."\" class=\"".$class_against."\" ".$disabled_against." id=\"".$class_against.$this->propositions_id."\" value=\"-1\" style=\"background: url('".$src_against."') center center no-repeat;\" onmouseover=\"this.style.background='url(medias/images/dontlike_hover.png) center center no-repeat'\" onmouseout=\"this.style.background='url(medias/images/dontlike.png) center center no-repeat'\"/>
				</form>";
	
	}
    
    function save() {
    	if ($this->is_updatable()) {
    		return $this->update();
    	} else {
    		return $this->insert();
    	}
    }
    
    function is_updatable() {
    	switch (true) {
    		case $this->id <= 0:
    		case !is_numeric($this->id):
    		case !$this->is_insertable():
    			return false;
    		default:
    			return true;
    	}
    }
    
    function update() {
		if ($this->is_updatable()) {
			list($result, $num) = $this->db->query("
				UPDATE ".$this->db->config['table_devinfrance_votes']."
				SET remote_address = ".$this->db->quote($this->remote_address).",
					propositions_id = ".(int)$this->propositions_id.",
					value = ".(int)$this->value.",
					date_update = ".time()."
				WHERE id = ".(int)$this->id
			);
			$this->db->status($num, "u", __("vote"));
			return $result;

		} else {
			$this->db->status(-1, "u", __("vote"));
			return false;
		}
    }
    
    function is_insertable() {
    	switch (true) {
    		case empty($this->propositions_id):
    			return false;
    		default:
    			return true;
    	}
    }

    function insert() {
		if ($this->is_insertable()) {
			list($result, $num, $this->id) = $this->db->getID("
				INSERT INTO ".$this->db->config['table_devinfrance_votes']."
				SET remote_address = ".$this->db->quote($this->remote_address).",
					propositions_id = ".(int)$this->propositions_id.",
					value = ".(int)$this->value.",
					date_update = ".time().",
					date_insert = ".time()
			);
			$this->db->status($num, "i", __("vote"));
			return $result;
		} else {
			$this->db->status(-1, "i", __("vote"));
			return false;
		}
    }
}
