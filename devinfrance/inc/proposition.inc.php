<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/projets/devinfrance.fr/applications/devinfrance/inc/propositions.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Proposition extends Record {
	const table = "devinfrance_propositions";

	public $id = 0;
	public $title = "";
        public $content = "";
        public $url = "";
        public $authors_id = "";
        public $date_insert = 0;
        public $date_update = 0;

        protected $errors = array();
        protected $alert_errors = false;
    
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = (int)$id;
	}
	
    function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load($this->db->config['table_devinfrance_propositions'], $properties);
		} else {
			return false;			
		}
    }
    
    function body() {
    	$body = "";
    	foreach (array_keys($this->get_public_properties()) as $property) {
    		$body .= $property." : \n";
    		$body .= $this->{$property}."\n\n";
    	}
    	return $body;
    }
    
    function show($directory_propositions, $url_propositions,$in_list, $key=1) {
    	$html = "";
		
		$vote = new Devinfrance_Vote();
		$vote->propositions_id = $this->id;
		$vote->remote_address = Devinfrance_Tools::remote_address();
		if ($vote->match_existing(array("propositions_id", "remote_address"))) {
			$vote->load(array("propositions_id" => $this->id, "remote_address" => Devinfrance_Tools::remote_address()));
		}
		if (isset($_POST["button_vote".$this->id])) {
			if ($_POST["button_vote".$this->id] == "1") {
				$vote->value = 1;
			} else {
				$vote->value = (int)(-1);
			}
			$vote->save();
		}
		$votes = new Devinfrance_Votes();
		$votes->propositions_id = $this->id;
		$votes->select();

		$author = new Devinfrance_Authors();
		$author->id = $this->authors_id;
		$author->select();
		
		$content = ($in_list == 1)? $this->format_content($this->content): $this->content;
		
		$num = isset($_GET['init'])? $this->id : $key;
		$num = isset($_GET['id'])? "single" : $num;
						
		$html .= "<div class=\"proposition\" id=\"prop_$num\">
						<div class=\"left_proposition\">
							<p class=\"proposition_date\">".Format::date_day($this->date_insert)."</p>
							<div class=\"proposition_image\">
								<a href=\"".$this->url_local()."\">".$this->title."</a>
								".$this->show_image($directory_propositions, $url_propositions)."
							</div>
							<div class=\"votes\">
								<p class=\"proposition_vote\"><img src=\"".$GLOBALS['param']['devinfrance_uri']."/medias/images/fleche.png\" alt=\"&#8594;\"/> VOTE</p>".$vote->show()."
								<p class=\"equal\">=</p>
								<p class=\"proposition_votes\">".$votes->calc_result()."</p>
							</div>
						</div>
						<div class=\"right_proposition\">
							<div class=\"proposition_content\">".$content."</div>
							<p class=\"proposition_author\">
								<a href=\"".$GLOBALS['param']['devinfrance_uri']."index.php?content=author.php&id=".$author[0]->id."\" class=\"proposition_author\">".$author[0]->name."</a>
							</p>
	 						<p class=\"author_description\">".$author[0]->description."</p>
						</div>
						<div class=\"right_proposition\">
							
	 					</div>
	 					<div class=\"clear_table\"></div>
					</div>";
		return $html;

    }
    
    function format_content($text) {
    	if (strlen($text) > 850) {
    		$text = substr($text, 0, 750);
    		if (strlen(substr($text,0,mb_strripos($text,"."))) < 350) {
    			$text = substr($text,0,mb_strripos($text,",")).",";
    		} else {
    			$text = substr($text,0,mb_strripos($text,".")).".";
    		}
    		
    		$text .= " <a href=\"".$GLOBALS['param']['devinfrance_uri']."index.php?content=proposition.php&id=".$this->id."\">[...]</a>";
    	}
    	return $text;
    }
    
    function format_short($text) {
    	$text = wordwrap($text, 45, "<br />");
    	$text = explode("<br />", $text);
    	$text = $text[0]."<br />".$text[1]."<br />".$text[2];
    	$text .= " <a href=\"".$GLOBALS['param']['devinfrance_uri']."index.php?content=proposition.php&id=".$this->id."\">[...]</a>";
    	return $text;
    }
    
    function url_local() {
    	return "index.php?content=proposition.php&id=".$this->id;
    }
   
    function delete() {
    	$result = $this->db->query("
    			DELETE FROM ".$this->db->config['table_devinfrance_propositions']."
    			WHERE id = ".(int)$this->id
    	);
    	$this->db->status($result[1], "d", __("proposition"));
    	
    	return (bool)$result[1];
    }
    
    function save() {
    	if ($this->is_updatable()) {
    		return $this->update();
    	} else {
    		return $this->insert();
    	}
    }

	function is_deletable() {
		return ($this->id > 0);
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
    
    function is_available() {
    	$query = "
    	SELECT COUNT(id)
    	FROM ".$this->db->config['table_devinfrance_propositions']."
    	WHERE title = ".$this->db->quote($this->title);
    	if ($this->id > 0) {
    		$query .= " AND id <> ".$this->id;
    	}
    	return $this->db->getValue($query) <= 0;
    }
    
    function update() {
		if ($this->is_updatable()) {
			list($result, $num) = $this->db->query("
				UPDATE ".$this->db->config['table_devinfrance_propositions']."
				SET title = ".$this->db->quote($this->title).",
				content = ".$this->db->quote($this->content).",
				url = ".$this->db->quote($this->url).",
				authors_id = ".$this->db->quote($this->authors_id).",
				date_update = ".time()."
				WHERE id = ".(int)$this->id
			);
			$this->db->status($num, "u", __("proposition"));
			return $result;
		} else {
			$this->db->status(-1, "u", __("proposition"));
			return false;
		}
	}
    
    function is_insertable() {
    	switch (true) {
    		case empty($this->title):
    			return false;
    		default:
    			return true;
    	}
    }

    function insert() {
    	if ($this->is_insertable()) {
			list($result, $num, $this->id) = $this->db->getID("
				INSERT INTO ".$this->db->config['table_devinfrance_propositions']."
				SET title = ".$this->db->quote($this->title).",
				content = ".$this->db->quote($this->content).",
				url = ".$this->db->quote($this->url).",
				authors_id = ".$this->db->quote($this->authors_id).",
				date_update = ".time().",
				date_insert = ".time()
			);
			$this->db->status($num, "i", __("proposition"));
			return $result;
		} else {
			$this->db->status(-1, "i", __("proposition"));
			return false;
		}
    }
    
    function delete_image($directory_propositions) {
    	if (file_exists($directory_propositions."proposition".$this->authors_id.$this->id.".jpeg")) {
    		unlink($directory_propositions."proposition".$this->authors_id.$this->id.".jpeg");
    	}
    }
    
    function show_image($directory_propositions, $url_propositions) {
    	if (file_exists($directory_propositions."proposition".$this->authors_id.$this->id.".jpeg")) {
    		return "<a href=\"$this->url\" target=\"_blank\"><img src=\"".$url_propositions."proposition".$this->authors_id.$this->id.".jpeg\" /></a>";
    	}
    	return "<img src=\"http://www.apercite.fr/api/apercite/240x180/oui/oui/".$this->url."\" />";
    }
    
    function verify_image($md5_local) {
    	$image = file_get_contents("http://www.apercite.fr/api/apercite/320x240/oui/oui/".$this->url);
    	$md5_dl = md5($image);
    	if (!($md5_dl == $md5_local)) {
    		return $image;
    	}
    	return false;
    }
    
    function add_image($destination) {
    	$md5_local = md5(file_get_contents($destination."image_creation.jpeg"));
    	$time = time();
    	$moy = $this->verify_image($md5_local);
    	while (!($moy)) {
    		if (time() > $time + 60000) {
    			break;
    		}
    		$moy = $this->verify_image($md5_local);
    	}
		if (isset($moy) && $moy != false) {
    		if (file_exists($destination."proposition".$this->authors_id.$this->id.".jpeg")) {
    			unlink($destination."proposition".$this->authors_id.$this->id.".jpeg");
    		}
    		file_put_contents($destination."proposition".$this->authors_id.$this->id.".jpeg", $moy);
    		
    		$img = imagecreatefromjpeg($destination."proposition".$this->authors_id.$this->id.".jpeg");
    		$dest = imagecreatetruecolor(284, 213);
    		imagecopyresampled($dest, $img, 0, 0, 0, 0,284,213, 320, 240);
    		unlink($destination."proposition".$this->authors_id.$this->id.".jpeg");
    		imagejpeg($dest, $destination."proposition".$this->authors_id.$this->id.".jpeg");
    	}
    }
    
	function edit() {
		$id = new Html_Input("proposition[id]", (int)$this->id, "hidden");
		$html = $id->input();
		
		$list_authors[]="";
		$authors = new Devinfrance_Authors();
		$authors->set_order("name","ASC");
		$authors->select();
		foreach ($authors as $author) {
			$list_authors[$author->id] = $author->name;
		}
		$title = new Html_Input("proposition[title]", $this->title);
		$author = new Html_Select("proposition[authors_id]", $list_authors, $this->authors_id);
		$content = new Html_Textarea("proposition[content]", $this->content);
		$url = new Html_Input("proposition[url]", $this->url);
		
		$save = new Html_Input("save", __("Send"), "submit");
		
		$list = array(
			'title' => array(
				'class' => "clearfix",
				'value' => $title->item(__("Title")),
			),
			'authors_id' => array(
				'class' => "clearfix",
				'value' => $author->item(__("Author")),
			),
			'content' => array(
				'class' => "clearfix",
				'value' => $content->item(__("Content")),
			),
			'url' => array(
				'class' => "clearfix",
				'value' => $url->item(__("URL")),
			),
			'save' => array(
				'class' => "itemsform-submit",
				'value' => $save->input(),
			),
		);
		
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
		$html .= $items->show();
		
		return "
			<form id=\"proposition-".$this->id."\" method=\"post\" action=\"\">".$html."</form>
		";
	}
}
