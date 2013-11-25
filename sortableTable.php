<?php

require_once('helper.php');
require_once('header.php');

class SortableTable {

	private $headers;
	private $row_count;

	function __construct() {
		$this->headers = array();
		$this->row_count = 0;
	}

	public function add_header($name) {
		if(!$this->header_exists($name)) {
			array_push($this->headers,new Header($name));
		}
	}

	public function add_row($row) {
		foreach($row as $head => $value) {
			$this->add_header($head);
			$h = $this->get_header($head);
			$h->add_data($value, $this->row_count);
		}
		$this->row_count++;
	}

	private function header_exists($name) {
		if(is_null($this->get_header($name))) {
			return false;
		}
		return true;
	}

	private function get_header($name) {
		foreach($this->headers as $head) {
			if($head->get_name() == $name) {
				return $head;
			}
		}
		return null;
	}

	/****** Generate Data Set ******/

	private function generate_data() {
		$s .= "var data = [\n";

		$array = array();

		for($i = 0; $i < $this->row_count; $i++) {
			array_push($array, $this->generate_data_row($i));
		}

		$s .= comma_seperate($array, true);
		$s .= "\n];";
		return $s;
	}

	private function generate_data_row($id) {
		$array = array();
		foreach($this->headers as $h) {
			array_push($array, "\"".$h->get_name()."\"".": \"".$h->get_data($id)."\"");
		}
		$s  = "{\n".comma_seperate($array, true)."\n}";
		return $s;
	}

	/****** Generate Columns ******/

	private function generate_cols() {
		$array = array();
		foreach($this->headers as $h) {
			$string = "{key: '".$h->get_name()."', label: '".$h->get_name()."', sortable:true, allowHTML:true}";
			array_push($array, $string);
		}
		$s .= "var cols = [\n";
		$s .= comma_seperate($array, true);
		$s .= "\n];\n";
		return $s;
	}

	/****** Add Included Scripts ******/

	private function add_scripts() {
		$s  = "<script src='http://yui.yahooapis.com/3.13.0/build/yui/yui-min.js'></script>";

		return $s;
	}

	/****** Generate Table Script ******/

	private function generate_table_script() {
		$s .= "var dt = new Y.DataTable({\n";
		$s .= "    data: data,\n";
		$s .= "    columns: cols,\n";
		$s .= "});\n\n";

		$s .= "dt.render('#dtable');\n";
		return $s;		
	}

	/****** Generate Load Script ******/

	private function generate_load_script() {
		$s = "";
		$s .= "YUI().use('datatable', 'datatype-number-format', function (Y) {\n";
		$s .= $this->generate_data() . "\n";
		$s .= $this->generate_cols() . "\n";
		$s .= $this->generate_table_script();
		$s .= "});";
	
		return $s;
	}

	/****** Print Table ******/

	public function print_table() {
		$s = "";
		//$s  .= $this->add_scripts() . "\n";
		$s .= "<script>\n";
		$s .= $this->generate_load_script();
		$s .= "</script>";

		echo $s;
	}
}