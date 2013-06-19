<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://svn.noparking.net/var/repos/opentime/inc/format.inc.php $
	$Revision:473 $

	Copyright (C) No Parking 2012 - 2013
*/

class Format {
	static function page_class($string) {
		$elements = explode("/", $string);
		$string = array_pop($elements);
		$elements = explode(".", $string);
		return "page-".array_shift($elements);
	}
	
	static function body_class($string) {
		$elements = explode(".", $string);
		return "body-".array_shift($elements);
	}
	
	static function text($string, $convert_http = true) {
		$string = htmlspecialchars($string);
		if (strpos($string, "http://") !== false and $convert_http) {
			$string = preg_replace("/(http):\/\/([^[:space:]]*)([[:alnum:]#?\/&=])/","<a href=\"\\1://\\2\\3\">\\1://\\2\\3</a>", $string);
		}
		$string = nl2br($string);
		
		return $string;
	}
	
	static function name($string) {
		if (!trim($string)) {
			$string = "<em>".$GLOBALS['txt_noname']."</em>";
		}
	
		return $string;
	}
	
	static function date_time($timestamp) {
		if ($timestamp == 0) {
			return "";
		}
		
		return date("d/m/Y H:i:s", $timestamp);
	}
	
	static function date($timestamp) {
		if ($timestamp == 0) {
			return "";
		}
		
		return date("d/m/Y", $timestamp);
	}
	
	static function date_day($timestamp) {
		if ($timestamp == 0) {
			return "";
		}
		$month = date("F", $timestamp);
		return date("d ", $timestamp).__($month).date(" Y", $timestamp);
	}
	
	static function date_in_full($timestamp) {
		if ($timestamp == 0) {
			return "";
		}
		return $GLOBALS['array_week'][date("w", $timestamp)]." ".date("d", $timestamp)." ".$GLOBALS['array_month'][(int)date("m", $timestamp)]." ".date("Y", $timestamp);
	}

	static function time_start_stop($start, $stop, $day = 0) {
		$time = "";
		if ($day == 0) {
			$day = mktime(0, 0, 0, date("m", $start), date("d", $start), date("Y", $start));
		}
		if ($day != mktime(0, 0, 0, date("m", $start), date("d", $start), date("Y", $start))) {
			$time .= date("d/m/Y", $start)." ";
		}
		if ("00h00" != date("H\hi", $start)) {
			$time .= date("H\hi", $start);
		}
		if ($stop > $start) {
			$time .= " - ";
			if ($day != mktime(0, 0, 0, date("m", $stop), date("d", $stop), date("Y", $stop))) {
				$time .= date("d/m/Y", $stop)." ";
			}
			if ("00h00" != date("H\hi", $stop)) {
				$time .= date("H\hi", $stop);
			}
		}

		return $time;
	}

	static function time($timestamp) {
		if ($timestamp == 0) {
			return "";
		}
		
		return date("H:i:s", $timestamp);
	}

	static function span_input($timestamp, $unit = null, $always_show_unit = false, $precision = 2) {
		if ($timestamp != 0) {
			return self::span($timestamp, $unit, $always_show_unit, $precision);
		} else {
			return "";
		}
	}

	static function span($timestamp, $unit = null, $always_show_unit = false, $precision = 2) {
		if ($unit === null) {
			$unit = $GLOBALS['param']['time_unit'];
		}

		if ($unit == "d") {
			$span = round($timestamp / $GLOBALS['param']['absence_fullday'], $precision);
			if ($always_show_unit) {
				$span .= " ".$GLOBALS['txt_day_'];
			}
		} elseif ($unit == "h-10") {
			$span = round($timestamp / 3600, $precision);
		} else {
			$span = time_format(round($timestamp, 4));
		}
		
		return $span;
	}

}
