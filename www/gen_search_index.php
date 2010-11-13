<?php

	$db = new PDO('mysql:host=localhost;dbname=thedom_info', 'thedom_thedom', 'ETP+}fViQKK_');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if (!$db) {
		die ('cannot connect to database');
	}

	function fill_table(&$all, $table_name, $prefix) {
		global $db;
		$st = $db->query("select id, name from $table_name");
		while ($r = $st->fetch()) {
			$e['name'] 	= $r['name'];
			$e['value'] 	= $prefix.$r['id'];
			$all[] = $e;
		}
	}
	fill_table(&$all, 'locations', 'l_');
	fill_table(&$all, 'amenities', 'a_');
	$all[] = array('name' => 'One Bedroom', 'value' => 'b_1');
	$all[] = array('name' => 'Two Bedrooms', 'value' => 'b_2');
	$all[] = array('name' => 'Three Bedrooms', 'value' => 'b_3');
	$all[] = array('name' => 'Four Bedrooms', 'value' => 'b_4');
	$all[] = array('name' => 'Five Bedrooms', 'value' => 'b_5');
	$all[] = array('name' => 'Six Bedrooms', 'value' => 'b_6');
	$all[] = array('name' => 'Seven Bedrooms', 'value' => 'b_7');
	$all[] = array('name' => 'Bookmarked', 'value' => 'bm');

	echo '<?php function SI() { return  unserialize(\''.serialize($all).'\');  }?>';
?>
