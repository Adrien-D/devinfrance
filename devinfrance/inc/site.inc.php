<?php
/*
    application devinfrance
    $Author: perrick $
    $URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
    $Revision: 68 $

    Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Site extends Record {
	public $id = 0;
        public $url = "";
        public $name = "";
        public $email = "";
        public $visited = 0;
        public $date_insert = "";
	public $date_update = "";
 
	protected $errors = array();
	protected $alert_errors = false;
	
	function __construct($id = 0, db $db = null) {
		parent::__construct($db);
		$this->id = (int)$id;
	}
	
	function count_dev() {
		$result = new Devinfrance_Typeresult();
		return "<div id=\"info_dev\"></div>";
	}
	
	function load(array $properties) {
		if (is_array($properties) and count($properties) > 0) {
			return parent::load($this->db->config['table_devinfrance_sites'], $properties);
		} else {
			return false;
		}
	}
	
	function show_table() {
		if (file_exists($this->directory_medias.$this->format($this->name).".jpeg")) {
			$img = "<a href=\"".$this->url."\"><img src=\"".$this->url_medias.$this->format($this->name).".jpeg\" /></a>";
		} else {
			$img = "";
		}
		return "<h1>".$this->name."</h1>
			<p><a href=\"".$this->url."\">".$this->url."</a></p>".$img;
	}
	
	function show($directory_sites, $url_sites,$in_list, $key=1) {
		$html = "";
		$files = new Devinfrance_Files();
		$files->sites_id = $this->id;
		$files->last = array($this->visited, ($this->visited + 1) , ($this->visited - 1) , ($this->visited + 2) , ($this->visited - 2));
		$files->select();
			$content = "";
		if (isset($files[0])) {
			$content = $files[0]->content;
		}
		
		$num = isset($_GET['id'])? "single" : $key;
		
		$html .= "<table class=\"site\" id=\"site_$num\">
			<tr>
				<td class=\"left_site\">
					<p class=\"site_name\">".$this->name."</p>
					<p class=\"site_url\"><a href=\"$this->url\" class=\"site_url\" target=\"_blank\" >$this->url</a></p>
					<p class=\"site_date\">Derni&egrave;re visite: ".Format::date($this->date_insert)."</p>
				</td>
				<td class=\"site_content\">
					".$files->format($content)."
				</td>
				<td class=\"right_site\">
					<p class=\"site_image\">".$this->show_image($directory_sites, $url_sites)."</p>
				</td>
			</tr>
		</table>";
		
		return $html;
	}
	
	function show_image($directory_sites, $url_sites) {
		if (file_exists($directory_sites.$this->format($this->name).".jpeg")) {
			return "<a href=\"$this->url\" target=\"_blank\"><img src=\"".$url_sites.$this->format($this->name).".jpeg\" /></a>";
		}
		return "<img src=\"http://www.apercite.fr/api/apercite/320x240/oui/oui/".$this->url."\" />";
	}
	
	function body() {
		$body = "";
		foreach (array_keys($this->get_public_properties()) as $property) {
			$body .= $property." : \n";
			$body .= $this->{$property}."\n\n";
		}
		return $body;
	}
	
	function delete() {
		return false;
	}
	
	function check() {
		return count($this->errors("*")) === 0;
	}
	
        function url_local() {
                return "index.php?content=site.php&route=get&id=".$this->id;
        }
   
	function is_visitable() {
		if (empty($this->url) == false && is_url($this->url) == true)
                        return true;
                else    
                        return false;
	}

	function able_file() {
		$head = get_headers($this->url."devinfrance.txt");
		if (preg_match("/404/", $head[0])) {
			return false;
		} else
		if (preg_match("/200/", $head[0])) {
			return true;
		}
		return false;
	}
	
	function visit() {
		if ($this->is_visitable()) {
			if($this->able_file()) {
				$file = new Devinfrance_File();
				$file->content = file_get_contents($this->url."devinfrance.txt");
				$file->sites_id = $this->id;
				if ($file->save()) {
					$file->parse();
					$this->visited = time();
					return $this->save();
				} else {
					return false;
				}
			}
		}
		return false;
	}
	
	function thank() {
		return "<p class=\"success\"><span></span>".
				__("Your message was sent successfully. We'll get back to you as as possible. Thanks!").
				"</p>";
	}
	
	function apologize() {
		return "<p class=\"error\"><span></span>".
				__("Sorry, something went wrong while sending your message. We'll try to fix this as soon as possible...").
				"</p>";
	}
	
	function send($to = "contact@nostopping.net") {
		require_once dirname(__FILE__)."/../../commons/lib/phpmailer/class.phpmailer.php";
	
		$mail = new PHPMailer();
		if (!empty($GLOBALS['config']['email_smtp'])) {
			$mail->IsSMTP();
			$mail->Host = $GLOBALS['config']['email_smtp'];
			$mail->SMTPAuth = false;
		}
		$mail->CharSet = "utf-8";
		$mail->From = $this->email;
		$mail->FromName = $this->name;
		$mail->AddAddress($to);
		$mail->WordWrap = $GLOBALS['param']['email_wrap'];
		$mail->IsHTML(false);
		$mail->Subject = __("Dev in France site | %s", array(date("d/m/Y H:i")));
		$mail->Body = $this->body();
		return $mail->send();
	}
	
	function send_appologize($to) {
		require_once dirname(__FILE__)."/../../commons/lib/phpmailer/class.phpmailer.php";
	
		$mail = new PHPMailer();
		if (!empty($GLOBALS['config']['email_smtp'])) {
			$mail->IsSMTP();
			$mail->Host = $GLOBALS['config']['email_smtp'];
			$mail->SMTPAuth = false;
		}
		$mail->CharSet = "utf-8";
		$mail->From = $GLOBALS['param']['email_from'];
		$mail->FromName = "Devinfrance";
		$mail->AddAddress($to);
		$mail->IsHTML(false);
		$mail->Subject = "Il manque votre fichier devinfrance.txt";
		$mail->Body = "Désolé, nous n'avons pas trouvé de fichier 'devinfrance.txt' à la racine de votre site. Merci de l'ajouter...";
		return $mail->send();
	}

	function add() {
		$name = new Html_Input("site[name]", $this->name);
		$name->properties['class'] = "required";
		$url = new Html_Input("site[url]", $this->url);
		$url->properties['class'] = "required";
		$email = new Html_Input("site[email]", $this->email);
		$email->properties['class'] = "required";
		$save = new Html_Input("save", __("Send"), "submit");
	
		$list = array(
				'url' => array(
						'class' => "clearfix required",
						'value' => $url->item(__("URL"), "", $this->show_errors("url")),
				),
				'name' => array(
						'class' => "clearfix required",
						'value' => $name->item(__("Webiste's name"), "", $this->show_errors("name")),
				),
				'email' => array(
						'class' => "clearfix required",
						'value' => $email->item(__("Email"), "", $this->show_errors("email")),
				),
				'save' => array(
						'class' => "itemsform-submit",
						'value' => $save->input(),
				),
		);
	
		$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
	
		return "
			<form id=\"site-add\" method=\"post\" action=\"\">".
			$items->show()."
			</form>
		";
	}
    
	function errors($property = "*") {
		$this->errors = array();

		if ($property == "name" or $property == "*" or (is_array($property) and in_array("name", $property))) {
			if ($this->name == "") {
				$this->errors[] = __("Name must not be empty");
			}
		}

		if ($property == "url" or $property == "*" or (is_array($property) and in_array("url", $property))) {
			if ($this->url == "") {
				$this->errors[] = __("URL must not be empty");
			}
                        if (!is_url($this->url)) {
				$this->errors[] = __("URL format is invalid");
			}
		}

		if ($property == "email" or $property == "*" or (is_array($property) and in_array("email", $property))) {
			if ($this->email == "") {
				$this->errors[] = __("Email must not be empty");
			}
			if (!is_email($this->email)) {
				$this->errors[] = __("Email format is invalid");
			}
		}

		return $this->errors;
	}

	function alert_errors($bool = null) {
		if (isset($bool)) {
			$this->alert_errors = (bool)$bool;
		}
		return $this->alert_errors;
	}
	
	function show_errors($property = "*") {
		if ($this->alert_errors()) {
			$errors = $this->errors($property);
			if (count($errors) > 0) {
				return "<ul class=\"errors\"><li>".join("</li><li>", $this->errors($property))."</li></ul>";
			}
		}
		return "";
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
			if (substr($this->url, -1) != "/") {
				$this->url .= "/";
			}
			list($result, $num) = $this->db->query("
				UPDATE ".$this->db->config['table_devinfrance_sites']."
				SET url = ".$this->db->quote($this->url).",
				name = ".$this->db->quote($this->name).",
				email = ".$this->db->quote($this->email).",
				visited = ".(int)$this->visited.",
				date_update = ".time()."
				WHERE id = ".(int)$this->id
			);
			$this->db->status($num, "u", __("website"));
			return $result;

		} else {
			$this->db->status(-1, "u", __("website"));
			return false;
		}
	}
    
    function is_insertable() {
    	switch (true) {
    		case empty($this->url):
    			return false;
    		default:
    			return true;
    	}
    }

    function insert() {
		if ($this->is_insertable()) {
			if (substr($this->url, -1) != "/") {
				$this->url .= "/";
			}
			list($result, $num, $this->id) = $this->db->getID("
				INSERT INTO ".$this->db->config['table_devinfrance_sites']."
				SET url = ".$this->db->quote($this->url).",
				name = ".$this->db->quote($this->name).",
				email = ".$this->db->quote($this->email).",
				visited = ".(int)$this->visited.",
				date_update = ".time().",
				date_insert = ".time()
			);
			$this->db->status($num, "i", __("website"));
			return $result;

		} else {
			$this->db->status(-1, "i", __("website"));
			return false;
		}
    }
    
    function format($text) {
    	$text = strtolower($text);
    	$text = preg_replace ("/[ ]/", "", $text);
    	return $text;
    }
    
    function copy_image($extension, $destination) {
    	$time = time();
    	$new_name = "copieof".$this->format($this->name).$time;
    	copy($destination.$this->format($this->name).$extension.".jpeg", $destination.$new_name.$extension.".jpeg");
    	unlink($destination.$this->format($this->name).$extension.".jpeg");
    }
    
    function verify_image($md5_local) {
    	$image = file_get_contents("http://www.apercite.fr/api/apercite/320x240/oui/oui/".$this->url);
    	$md5_dl = md5($image);
    	if (!($md5_dl == $md5_local)) {
    		return $image;
    	}
    	return false;
    }
    
    function add_image($file, $destination) {
    	if (!($file == "") && !($file['error']) && ($file != "") ) {
    		copy($file['tmp_name'], $destination.$this->format($this->name).".jpeg");
    	} else {
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
    			if (file_exists($destination.$this->format($this->name).".jpeg")) {
    				$this->copy_image("", $destination);
    			}
    			if (file_exists($destination.$this->format($this->name)."_min.jpeg")) {
    				$this->copy_image("_min", $destination);
    			}
    			if (file_exists($destination.$this->format($this->name)."_mingrey.jpeg")) {
    				$this->copy_image("_mingrey", $destination);
    			}
    			
    			file_put_contents($destination.$this->format($this->name).".jpeg", $moy);
    			
    			$img = imagecreatefromjpeg($destination.$this->format($this->name).".jpeg");
    			$dest = imagecreate(64, 56);
    			imagecopyresampled($dest, $img, 0, 0, 0, 0, 64, 56, 320, 240);
    			imagejpeg($dest, $destination.$this->format($this->name)."_min.jpeg");
    			
    			$img = imagecreatefromjpeg($destination.$this->format($this->name)."_min.jpeg");
    			$dest = imagecreate(64, 56);
    			imagecopymergegray($dest, $img, 0, 0, 0, 0, 64, 56, 70);
    			imagefilter($dest, IMG_FILTER_GRAYSCALE);
    			imagejpeg($dest, $destination.$this->format($this->name)."_mingrey.jpeg");
    		}
    	}
    }
    
    function edit() {
    	$id = new Html_Input("site[id]", (int)$this->id, "hidden");
    	$html = $id->input();
    	
		$upload = new Html_Input("upload", __("Display"), "file");
		$upload->accept = 'image/png';
		
    	$confirm = new Html_Input('confirm',"file","radio");
    	$min_image = new Html_Input('confirm',"auto","radio");
    	$nothing = new Html_Input('confirm',"nothing","radio");
    	
    	$url = new Html_Input("site[url]", $this->url);
    	$name = new Html_Input("site[name]", $this->name);
    	$email = new Html_Input("site[email]", $this->email);
    	
    	$nothing->checked = true;
    	
    	$visited = new Html_Input("site[visited]", Format::date_time($this->visited));
    	$visited->disabled = "disabled";
    	
    	$save = new Html_Input("save", __("Send"), "submit");
    
    	$list = array(
    			 'upload' => array(
    			 		'class' => "clearfix",
    			 		'value' => $upload->item(__("File")),
    			 ),
    			 'confirm' => array(
    			 		'class' => "clearfix",
    			 		'value' => $confirm->item(__("Upload file")).$min_image->item(__("Auto thumbnail")).$nothing->item(__("None")),
    			 ),
    			'url' => array(
    					'class' => "clearfix",
    					'value' => $url->item(__("URL")),
    			),
    			'name' => array(
    					'class' => "clearfix",
    					'value' => $name->item(__("Webiste's name")),
    			),
    			'email' => array(
    					'class' => "clearfix",
    					'value' => $email->item(__("Email")),
    			),
    			'visited' => array(
    					'class' => "clearfix",
    					'value' => $visited->item(__("Last visit")),
    			),
    			'save' => array(
    					'class' => "itemsform-submit",
    					'value' => $save->input(),
    			),
    	);
    
    	$items = new Html_List(array('leaves' => $list, 'class' => "itemsform"));
    	$html .= $id->input().$items->show();
		if ($this->id > 0){
			file_exists($this->directory_medias.$this->format($this->name).".jpeg")? $formulaire = "
			<form id=\"site-".$this->id."\" method=\"post\" action=\"\" enctype=\"multipart/form-data\">
				<img id=\"min-image\" src=\"".$this->url_medias.$this->format($this->name).".jpeg\" alt=\"Img site\">".
				$html.
			"</form>" :
				$formulaire = "
				<form id=\"site-".$this->id."\" method=\"post\" action=\"\" enctype=\"multipart/form-data\">
					<img id=\"min-image\" src=\"http://www.apercite.fr/api/apercite/320x240/oui/oui/".$this->url."\" alt=\"Img site\">".
					$html.
				"</form>" ;
		} else {
			$formulaire = "
    		<form id=\"site-".$this->id."\" method=\"post\" action=\"\" enctype=\"multipart/form-data\">".
    			$html.
    		"</form>";
		}
    	return $formulaire;
    }
}
