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

	public function generate_dataset() {
		$script  = "Data = {\n";
		$script .= "	table: [\n";
		//Add multiple rows here
		$script .= $this->generate_rows();
		$script .= "\n	]\n";
		$script .= "}";
		return $script;
	}

	public function generate_table_script() {
		$script  = "YAHOO.util.Event.addListener(window, 'load', function() {\n";
		$script .= "	YAHOO.example.Basic = function() {\n";

		//column defs here
		$script .= $this->generate_column_defs();
		
		$script .= "		var myDataSource = new YAHOO.util.DataSource(Data.table);\n";
		$script .= "		myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;\n";

		//schema here
		$script .= $this->generate_schema();

		$script .= "		var myDataTable = new YAHOO.widget.DataTable('basic',\n";
		$script .= "				myColumnDefs, myDataSource);\n";
		
		$script .= "		return {\n";
		$script .= "			oDS: myDataSource,\n";
		$script .= "			oDT: myDataTable\n";
		$script .= "		};\n";
		$script .= "	}();\n";
		$script .= "});\n";

		return $script;
	}

	public function generate_external_includes() {
		return "<body class='yui-skin-sam'><div id='basic'></div></body>".
		"<!--CSS file (default YUI Sam Skin) -->
		<link type='text/css' rel='stylesheet' href='http://yui.yahooapis.com/2.9.0/build/datatable/assets/skins/sam/datatable.css'>".
		 
		"<!-- Dependencies -->".
		"<script src='http://yui.yahooapis.com/2.9.0/build/yahoo-dom-event/yahoo-dom-event.js'></script>".
		"<script src='http://yui.yahooapis.com/2.9.0/build/element/element-min.js'></script>".
		"<script src='http://yui.yahooapis.com/2.9.0/build/datasource/datasource-min.js'></script>".
		 
		// "<!-- OPTIONAL: JSON Utility (for DataSource) -->
		// 		<script src='http://yui.yahooapis.com/2.9.0/build/json/json-min.js'></script>".
		 
		// "<!-- OPTIONAL: Connection Manager (enables XHR for DataSource) -->
		// 		<script src='http://yui.yahooapis.com/2.9.0/build/connection/connection-min.js'></script>".
		 
		// "<!-- OPTIONAL: Get Utility (enables dynamic script nodes for DataSource) -->
		// 		<script src='http://yui.yahooapis.com/2.9.0/build/get/get-min.js'></script>".
		 
		"<!-- Source files -->
				<script src='http://yui.yahooapis.com/2.9.0/build/datatable/datatable-min.js'></script>";
	}

	public function print_table() {
		$script  = "<div>";
		$script .= $this->generate_external_includes();
		$script .= "<script>".$this->generate_dataset()."</script>";
		$script .= "<script>".$this->generate_table_script()."</script>";
		$script .= "</div>";
		echo $script;
	}

	private function generate_rows() {
		$row = array();
		for($i = 0; $i < $this->row_count; $i++) {
			$string = "{";
			$data = array();
			foreach($this->headers as $head) {
				if(!is_null($head->get_data($i))) {
					$s = "\"".$head->get_name()."\"" . ": \"" . $head->get_data($i)."\"";
					array_push($data, $s);
				}
			}
			$string .= comma_seperate($data, true);
			$string .= "}";
			array_push($row, $string);
		}
		return comma_seperate($row, true);
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

	private function generate_column_defs() {
		$script = "			var myColumnDefs = [\n";
		$array = array();
		foreach($this->headers as $head) {
			$name = $head->get_name();
			$string = "					{key:\"$name\", sortable:true}";
			array_push($array, $string);
		}
		$script .= comma_seperate($array, true);
		$script .= "\n			];\n";
		return $script;
	}

	private function generate_schema() {
		$script  = "		    myDataSource.responseSchema = {\n";
		$script .= "		        fields: [";
		$array = array();
		foreach($this->headers as $head) {
			$name = $head->get_name();
			$string = "\"$name\"";
			array_push($array, $string);
		}
		$script .= comma_seperate($array, false);
		$script .= "]\n";
		$script .= "	    };\n";

	}
}