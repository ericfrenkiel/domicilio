<?php 
	require_once('search_index.php');
	$all = SI();
	// Index of all amenities
	$q = strtolower($_GET['q']);
	
	$return_arr = array();
	foreach ($all as $e) {
		if (strncmp($q, strtolower($e['name']), strlen($q)) == 0) {
			$return_arr[] = $e;
		}
	}
	
    header("Content-type: application/json");
	echo json_encode($return_arr);
?>