<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/misc.inc.php $
	$Revision: 5914 $

	Copyright (C) No Parking 2012 - 2013
*/

function __($string, $replacements = null) {
	if (isset($GLOBALS['__'][$string])) {
		$string = $GLOBALS['__'][$string];
	} else {
		trigger_error("Translation '".$string."' is missing.", E_USER_WARNING);
	}
	switch (true) {
		case $replacements === null:
			return $string;
		case is_array($replacements):
			return vsprintf($string, $replacements);
	}
}

function compareSPLFileInfo($splFileInfo1, $splFileInfo2) {
    return strcmp($splFileInfo1->getFileName(), $splFileInfo2->getFileName());
}

function utf8_real_decode($string) {
	if (extension_loaded("mbstring")) {
		$real_decode = mb_convert_encoding($string, "ISO-8859-1", "UTF-8");
	} else {
		$real_decode = utf8_decode($string);
	}
	
	return $real_decode;
}

function utf8_ucwords($string) {
	if (extension_loaded("mbstring")) {
		$ucwords = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
	} else {
		$ucwords = ucwords($string);
	}
	
	return $ucwords;

}

function utf8_ucfirst($string) {
	if (extension_loaded("mbstring")) {
		mb_internal_encoding("UTF-8");
		$ucfirst = mb_strtoupper(mb_substr($string, 0, 1)).mb_substr($string, 1);
	} else {
		$ucfirst = ucfirst($string);
	}
	
	return $ucfirst;
}

function utf8_strtolower($string) {
	if (extension_loaded("mbstring")) {
		mb_internal_encoding("UTF-8");
		$strtoupper = mb_strtolower($string);
	} else {
		$strtoupper = strtolower($string);
	}

	return $strtoupper;
}

function utf8_strtoupper($string) {
	if (extension_loaded("mbstring")) {
		mb_internal_encoding("UTF-8");
		$strtoupper = mb_strtoupper($string);
	} else {
		$strtoupper = strtoupper($string);
	}

	return $strtoupper;
}

function utf8_strlen($string) {
	if (extension_loaded('mbstring') === false) {
		return strlen($string);
	} else {
		mb_internal_encoding('UTF-8');
		return mb_strlen($string);
	}
}

function utf8_substr($string, $start, $length="") {
	if (extension_loaded("mbstring")) {
		mb_internal_encoding("UTF-8");
		if ($length !== "") {
			$substr = mb_substr($string, $start, $length);
		} else {
			$substr = mb_substr($string, $start);
		}
	} else {
		if ($length !== "") {
			$substr = substr($string, $start, $length);
		} else {
			$substr = substr($string, $start);
		}
	}

	return $substr;
}

function utf8_htmlentities($string) {
	return htmlentities($string, ENT_COMPAT, "UTF-8");
}

function utf8_urlencode($text) {
	return urlencode(utf8_decode($text));
}

function utf8_urldecode($text) {
	return urldecode(utf8_encode($text));
}

function column_number_in_excel($int) {
	if ($int > 25) {
		$column_number = $GLOBALS['array_excel'][floor($int / 26) - 1];
		$column_number .= $GLOBALS['array_excel'][$int % 26];
	} else {
		$column_number = $GLOBALS['array_excel'][$int];
	}

	return $column_number;
}

function renew_session() {
	if (isset($GLOBALS['_SESSION'])) {
		unset($GLOBALS['_SESSION']);
	}
	session_destroy();
	session_regenerate_id();
}

function array_2_string($array) {
	if (!is_array($array)) {
		$string = $array;
	} else {
		$string = "array(";
		foreach($array as $key => $value) {
			if (!is_int($key)) {
				$key = "\"".$key."\"";
			}
			if (!is_int($value)) {
				$value = "\"".$value."\"";
			}
			$string .= $key." => ".$value.", ";
		}
		$string = preg_replace("/(.), $/", "\\1", $string);
		$string .= ")";
	}

	return $string;
}

function is_url($url) {
	return (preg_match('#^https?://[a-z0-9]{2,}+([\._a-z0-9-]+)*\.[a-z]{2,7}/?$#', $url));
}

function is_email($e) {
	return (preg_match('/[_a-z0-9-]+([\._a-z0-9-]+)*@[\._a-z0-9-]+(\.[a-z0-9-]{2,7})+/', $e));
}

function array_2_list($array, $delimeter = "", $map = NULL) {
	if ($map === null) {
		if ($delimeter == "") {
			$map = "intval";
		} else if ($delimeter == "'") {
			$map = "mysql_real_escape_string";
		}
	}

	if (is_array($array)) {
		$array = array_unique($array);
		if (sizeof($array) == 0) {
			$array = array(0);
		}
		if ($map) {
			$array = array_map($map, $array);
		}
		$list = implode($delimeter.",".$delimeter, $array);
		$list = $delimeter.$list.$delimeter;
		$list = "(".$list.")";
	} else {
		$list = "(".$delimeter."0".$delimeter.")";
	}
	return $list;
}

function success_status($message, $priority = 0) {
	if (!isset($_SESSION['global_status'])) {
		$_SESSION['global_status'] = array();
	}
	if ($GLOBALS['param']['layout_multiplestatus']) {
		$_SESSION['global_status'][] = array(
			'value' => "<li class=\"content_success_status\">".$message."</li>",
			'priority' => $priority,
		);
	} else {
		$_SESSION['global_status'][] = array(
			'value' => "<div class=\"content_success_status\"><span><ul><li>".$message."</li></ul></span></div>",
			'priority' => $priority,
		);
	}
	return $_SESSION['global_status'];
}


function determine_operation($vars) {
	if (is_array($vars)) {
		foreach ($vars as $operation) {
			if (!empty($operation)) {
				return $operation;
			}
		}
		return "";
	} else {
		return $vars;
	}
}