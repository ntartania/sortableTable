<html>
	<body class="yui-skin-sam"><div id="basic"></div></body>
	<!--CSS file (default YUI Sam Skin) -->
	<link type="text/css" rel="stylesheet" href="http://yui.yahooapis.com/2.9.0/build/datatable/assets/skins/sam/datatable.css">
	 
	<!-- Dependencies -->
	<script src="http://yui.yahooapis.com/2.9.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
	<script src="http://yui.yahooapis.com/2.9.0/build/element/element-min.js"></script>
	<script src="http://yui.yahooapis.com/2.9.0/build/datasource/datasource-min.js"></script>
	 
	<!-- OPTIONAL: JSON Utility (for DataSource) -->
	<script src="http://yui.yahooapis.com/2.9.0/build/json/json-min.js"></script>
	 
	<!-- OPTIONAL: Connection Manager (enables XHR for DataSource) -->
	<script src="http://yui.yahooapis.com/2.9.0/build/connection/connection-min.js"></script>
	 
	<!-- OPTIONAL: Get Utility (enables dynamic script nodes for DataSource) -->
	<script src="http://yui.yahooapis.com/2.9.0/build/get/get-min.js"></script>
	 
	<!-- Source files -->
	<script src="http://yui.yahooapis.com/2.9.0/build/datatable/datatable-min.js"></script>
	 
</html>

<?php
	require_once('sortableTable.php');
	$data = array(
		array("id"=>"po-0167", "quantity"=>1, "amount"=>1),
		array("id"=>"po-0783", "quantity"=>9, "amount"=>4),
		array("id"=>"po-0297", "quantity"=>7, "amount"=>7),
		array("id"=>"po-1482", "quantity"=>3, "amount"=>2),
	);


	$table = new SortableTable();

	foreach($data as $row) {
		$table->add_row($row);
	}

	echo "<script>".$table->generate_dataset()."</script>";
	echo "<script>".$table->generate_table_script()."</script>";
