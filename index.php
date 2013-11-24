<p>This text should be before the table</p>
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

	$table->print_table();
?>

<div id="dtable" class="yui-skin-sam"></div>