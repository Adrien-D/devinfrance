<?php
/*
	application devinfrance
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/plugins/openwide/plugins/openwide/inc/bot.inc.php $
	$Revision: 68 $

	Copyright (C) No Parking 2012 - 2013
*/

class Devinfrance_Bot {
	public $directory_cfg = "";
	
	function __construct(db $db = null) {
		if ($db === null) {
			$db = new db();
		}
		$this->db = $db;
		$this->directory_cfg = dirname(__FILE__)."/../../cfg";
	}
	
	function help() {
		$help = __("Methods available with Devinfrance_Bot:")."\n";
		$ReflectionClass = new ReflectionClass('Devinfrance_Bot');
		foreach ($ReflectionClass->getMethods() as $method) {
			if (!in_array($method->getName(), array("help", "__construct"))) {
				$help .= "--".$method->getName()."\n";
			}
		}

		return $help;
	}
	
	function visit_sites() {
		$sites = new Devinfrance_Sites();
		$sites->visited = 0;
		$sites->select();
		foreach ($sites as $site) {
			return $site->visit();
		}
	}
	
	function able_file($url) {
		$head = get_headers($url."/devinfrance.txt");
		if (preg_match("/404/", $head[0])) {
			return false;
		} else if (preg_match("/200/", $head[0])) {
			return true;
		}
		return false;
	}
	
	function add_site($url = null) {
		$site = new Devinfrance_Site();
		$site->url = $url;
		
		if ($site->save()) {
			$file = new Devinfrance_File();
			if ($this->able_file($url)) {
				$file->content = file_get_contents($url."/devinfrance.txt");	
			}
			$file->sites_id = $site->id;
			if ($file->save()) {
				$file->parse();
				$site->visited = time();
				return $site->save();
			}
		}
		return false;
	}
	
	function minify_css() {
		$index = dirname(__FILE__)."/../index.php";
		if (file_exists($index)) {
			$lines = file($index);
			foreach ($lines as $line) {
				if (preg_match("/\.css/", $line)) {
					$blocks = explode("\"", $line);
					foreach ($blocks as $block) {
						if (preg_match("/\.css/", $block)) {
							$files[] = $block;
						}
					}
				}
			}
		}
		
		$css = "";
		$name = "";
		foreach ($files as $file) {
			$path = dirname(__FILE__)."/../".$file;
			if (file_exists($path)) {
				$css .= file_get_contents($path);
				$name .= $file;
			}
		}
		require dirname(__FILE__)."/../../../libraries/compact_css/compact_css.php";
		if (!empty($name)) {
			(bool)file_put_contents(dirname(__FILE__)."/../medias/css/".md5($name).".minified.css", $css);
			return (bool)clean_css(dirname(__FILE__)."/../medias/css/".md5($name).".minified.css");
		} else {
			return false;
		}
	}
	
	function minify_js() {
		$index = dirname(__FILE__)."/../index.php";
		if (file_exists($index)) {
			$lines = file($index);
			foreach ($lines as $line) {
				if (preg_match("/\.js/", $line)) {
					$blocks = explode("\"", $line);
					$files[] = $blocks[1];
				}
			}
		}

		$js = "";
		$name = "";
		require dirname(__FILE__)."/../../../libraries/rgrove-jsmin-php-8689392/jsmin.php";
		foreach ($files as $file) {
			$path = dirname(__FILE__)."/../".$file;
			if (file_exists($path)) {
				$js .= JSMin::minify(file_get_contents($path));
				$name .= $file;
			}
		}
		
		if (!empty($name)) {
			return (bool)file_put_contents(dirname(__FILE__)."/../medias/js/".md5($name).".minified.js", $js);
		} else {
			return false;
		}
	}

	function purge_accounts() {
		if ($GLOBALS['param']['devinfrance_database_prefix']) {
			list($result, $count) = $this->db->query("
				SELECT SCHEMA_NAME
				FROM information_schema.SCHEMATA
			");
			while ($row = $this->db->fetchArray($result)) {
				if (preg_match("/^".$GLOBALS['param']['devinfrance_database_prefix']."[0-9]+$/", $row['SCHEMA_NAME'])) {
					$this->db->query("DROP DATABASE `".$row['SCHEMA_NAME']."`");
				}
				if (preg_match("/^".$GLOBALS['param']['devinfrance_database_prefix']."test[0-9]+$/", $row['SCHEMA_NAME'])) {
					$this->db->query("DROP DATABASE `".$row['SCHEMA_NAME']."`");
				}
			}
			list($result, $count) = $this->db->query("
				SELECT User
				FROM mysql.user
			");
			while ($row = $this->db->fetchArray($result)) {
				if (preg_match("/^".$GLOBALS['param']['devinfrance_database_prefix']."[0-9]+$/", $row['User'])) {
					$this->db->query("DROP USER '".$row['User']."'@'".$GLOBALS['param']['devinfrance_database_host']."'");
				}
				if (preg_match("/^".$GLOBALS['param']['devinfrance_database_prefix']."test[0-9]+$/", $row['User'])) {
					$this->db->query("DROP USER '".$row['User']."'@'".$GLOBALS['param']['devinfrance_database_host']."'");
				}
			}
			$this->db->query("FLUSH PRIVILEGES");
		}
		$files = glob($GLOBALS['param']['devinfrance_accounts_path']."*", GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file) and strpos(".", $file) !== 0) {
				if (file_exists($file."cfg/config.inc.php")) {
					unlink($file."cfg/config.inc.php");
				}
				if (file_exists($file."cfg/param.inc.php")) {
					unlink($file."cfg/param.inc.php");
				}
				if (file_exists($file."cfg/")) {
					rmdir($file."cfg/");
				}
				if (file_exists($file."index.php")) {
					unlink($file."index.php");
				}
				if (file_exists($file)) {
					rmdir($file);
				}
			} 
		}
		$this->db->query("TRUNCATE TABLE ".$GLOBALS['dbconfig']['table_devinfrance_accounts']);
		
		return true;
	}
	
	function test_configuration() {
		$message = "Test 'devinfrance_opentime_path = ".realpath($GLOBALS['param']['devinfrance_opentime_path'])."' : ".(int)file_exists($GLOBALS['param']['devinfrance_opentime_path'])."\n";
		$message .= "Test 'devinfrance_accounts_path = ".realpath($GLOBALS['param']['devinfrance_accounts_path'])."' : ".(int)file_exists($GLOBALS['param']['devinfrance_accounts_path'])."\n";

		return $message;
	}

	function reinstall_database() {
		$this->uninstall_database();
		return $this->install_database();
	}
	
	function install_blocks() {
		$page = new Devinfrance_Page();
		$blocks = array(		

			'action-inscription' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<h4>Ajouter son site :</h4>
<p>Il suffit d'ajouter un fichier <a href="http://devinfrance.fr/devinfrance.txt" target="_blank">"devinfrance.txt" <img id="download_devinfrance" src="medias/images/download.png" /></a><br />à la racine de votre site. Puis, faites le nous savoir...</p>
<form class="clearfix" id="" action="index.php?content=site.php&route=add" method="post">
	<div class="arrow"><img src="medias/images/fleche.png" /></div>
	<input type="text" name="site[url]" value="" placeholder="URL">
	<input type="image" src="medias/images/ok.png" />
</form>
HTML
			),
			'action-lectures' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<h4>D'autres ont des propositions</h4>
HTML
			),
			'action-liste' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<div class="action action-liste">
	<h4>Ceux qui souhaitent peser...</h4>
	<p><a href="{$page->url("sites.php")}">Consultez les listes des inscrits</a></p>
</div>
HTML
			),
			'action-proposition' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<div class="action action-proposition">
	<h4>Envie de contribuer aux propositions ?</h4>
	<p>Il suffit d'écrire un billet de blog ou de relever une page sur un site web puis de nous l'envoyer par email : <a href="mailto:contact@devinfrance.fr">contact@devinfrance.fr</a></p>
</div>
HTML
			),
			'baseline' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
&#171; Des hommes et des idées<br />pour faire avancer l'industrie numérique &#187;	
HTML
			),
			'contact-devinfrance' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<h4>DEV. IN FRANCE</h4>
<p>
	Euratechnologies<br />
	165 avenue de bretagne<br />
	59000 Lille, FRANCE<br />
	<a href="mailto:contact@devinfrance.fr">contact<h5>at</h5>devinfrance.fr</a>
</p>
HTML
			),
			'derniers-sites' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<h4>Les derniers sites inscrits</h4>
HTML
			),
			'details-equipe' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<div>
	<h4>L'équipe derrière ce projet</h4>
	<p>Au départ, il y avait <a href="{$page->url("team.php")}">4 sociétés, chacune éditeur dans son domaine : Crezeo / No Parking / Balumpa / V-Cult</a>.</p>
</div>
HTML
			),
			'details-inscription' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<div>
	<h4>Moins de 5 minutes pour s'inscrire</h4>
	<p>Il suffit de compléter ce tout petit formulaire et surtout penser à ajouter un fichier texte à la racine du site ensuite.</p>
</div>
HTML
			),
			'details-reste' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<div>
	<h4>Pourquoi devinfrance.fr</h4>
	<p>L'industrie du logiciel mérite toute sa place dans la politique industrielle du pays...</p>
</div>
HTML
			),
			'details-technique' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<p><img src="medias/images/%3F.png" alt="?" /> Le fichier texte est le plus petit dénominateur commun pour les informaticiens, véritables créateurs de logiciel et d'application. Non intrusif sur leur boulot, il permet de marquer le site.</p>
HTML
			),
			'devinfrance-explication' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<div>
	<h4>Pourquoi devinfrance.fr</h4>
	<p>L'industrie du logiciel mérite toute sa place dans la politique industrielle du pays...</p>
</div>
HTML
			),
			'equipe-devinfrance' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<div>
	<p>Une initiative des sociétés<br /><a href="http://noparking.net" target="_blank" >NO PARKING</a>, <a href="http://crezeo.fr" target="_blank" >CREZEO</a>,<a href="http://balumpa.fr" target="_blank" > BALUMPA</a> et <a href="http://www.v-cult.com" target="_blank" >V-CULT</a></p>
	<br />
	<p>Avec à la direction artistique <a href="http://juliendrapier.fr/" target="_blank" >JULIEN DRAPIER.</p>
</div>
HTML
			),
			'home-intro' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<h4>Compter pour peser</h4>
<p><img src="medias/images/%3F.png" alt="?" /> Dev. in France est avant tout un agrégateur de compétence liant tous les acteurs de la filière digitale de France en faisant compter la voix de cette industrie en constante évolution.</p>
HTML
			),
			'tout-voir' => array(
				'language' => "fr_FR",
				'value' => <<<HTML
<a href=index.php?content=sites.php>Tout voir</a>
HTML
			),
		);
		
		foreach ($blocks as $name => $values) {
			$block = new Devinfrance_Block();
			$block->name = $name;
			$block->language = $values['language'];
			$block->value = $values['value'];
			$block->insert();
		}

		return true;
	}
	
	function uninstall_blocks() {
		return $this->db->query("TRUNCATE ".$this->db->config['table_devinfrance_blocks']);
	}
	
	function reinstall_blocks() {
		$this->uninstall_blocks();
		return $this->install_blocks();
	}
	
	function install_database() {
		$queries = array();
		$db = new db();
		require dirname(__FILE__)."/../../commons/sql/content.sql.php";
		require dirname(__FILE__)."/../sql/content.sql.php";
		$this->db->initialize($queries);
		$this->install_blocks();
		return true;
	}
	
	function uninstall_database() {
		require dirname(__FILE__)."/../../commons/sql/delete.sql.php";
		return true;
	}
}
