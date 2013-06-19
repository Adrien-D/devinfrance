<?php
/*
	application commons
	$Author: perrick $
	$URL: svn://o2.noparking.net:85/var/repos/opentime/inc/collector.inc.php $
	$Revision: 4557 $

	Copyright (C) No Parking 2012 - 2013
*/

class Collector_Dated extends Collector {
	protected $columns_joined = array();
	
	function select_last($raw = false) {
		$this->reset();

		$query = $this->get_query_dated();

		$this->set_up_dated();
		list($records) = $this->db->query($query);
		if ($this->limit_row_count) {
			$this->found_rows = !$this->calc_found_rows ? count($this) : $this->db->getValue("SELECT FOUND_ROWS()");
		}
		$this->tear_down_dated();
		

		while ($record = $this->db->fetchArray($records)) {
			if ($raw) {
				$this->instances[] = $record;
			} else {
				$instance = $this->get_instance($record);

				if ($instance !== null) {
					foreach ($record as $column => $value) {
						if (isset($instance->{$column})) {
							$instance->{$column} = $value;
						}
					}

					$this->instances[] = $instance;
				}
			}
		}

		return $this;
	}
	
	function set_up_dated() {
		$this->db->query($this->get_create_temporary_table());
		$this->db->query($this->get_lock());
		$this->db->query($this->get_insert_temporary_table());		
	}
	
	function tear_down_dated() {
		$this->db->query($this->get_unlock());
		$this->db->query($this->get_drop_temporary_table());
	}

	function get_query_dated() {
		$calc_found_rows = ($this->calc_found_rows) ? "SQL_CALC_FOUND_ROWS " : "";
		$columns = $this->get_columns();
		$from = $this->get_from();
		$where = $this->get_where();
		$limit = $this->get_limit();
		$join = $this->get_join();
		$temporay_join = $this->get_temporary_join();
		$group_by = $this->get_group_by();
		$order = $this->get_order();

		$query = "SELECT ".$calc_found_rows.join(', ', $columns)." FROM ".join(', ', $from);
		
		if ($temporay_join) {
			$query .= " ".$temporay_join;
		}

		if (sizeof($join) > 0) {
			$query .= " ".join(" ", $join);
		}

		if (sizeof($where) > 0) {
			$query .= " WHERE ".join(" AND ", $where);
		}

		$query .= $group_by;
		$query .= $order;
		$query .= $limit;

		return $query;
	}
	
	function get_create_temporary_table() {
		$temporary_join = "";
		foreach ($this->columns_joined as $column => $description) {
			$temporary_join .= $column." ".$description.", ";
		}
		return "CREATE TEMPORARY TABLE tmp (".$temporary_join."day INT(10) DEFAULT '0' NOT NULL)";
	}
	
	function get_lock() {
		$tables = array_merge(array($this->table), array_keys($this->get_join()));
		return "LOCK TABLES ".join(" read, ", array_unique($tables))." read";
	}
	
	function get_insert_temporary_table() {
		$columns = array_keys($this->columns_joined);
		$query_where = "";
		$where = $this->get_where();
		if (sizeof($where) > 0) {
			$query_where .= " WHERE ".join(" AND ", $where);
		}
		return "INSERT INTO tmp
			SELECT ".implode(", ", $columns).", MAX(day)
			FROM ".$this->table.
			$query_where."
			GROUP BY ".implode(", ", $columns)
		;
	}
	
	function get_temporary_join() {
		$temporary_join = "";
		foreach ($this->columns_joined as $column => $description) {
			$temporary_join .= $this->table.".".$column." = tmp.".$column." AND ";
		}
		return "INNER JOIN tmp ON ".$temporary_join.$this->table.".day = tmp.day";
	}
	
	function get_unlock() {
		return "UNLOCK TABLES";
	}
	
	function get_drop_temporary_table() {
		return "DROP TABLE tmp";
	}
}
