<?php
	$LISTINGS_PER_PAGE = 100;
	$link = mysql_connect('localhost', 'thedom_thedom', 'ETP+}fViQKK_');
	mysql_select_db('thedom_info', $link);
	
	$locations = array_filter(split(',', $_GET['q']));
	$page = $_GET['p'];	
	// bedrooms predicate

	$bedroom_predicate = 'AND (1 = 0';
	$amenities_predicate = '';
	$location_predicate = '';
	foreach ($locations as $l) {
		if (strncasecmp($l, 'b_', 2) == 0) {
			$bedroom_predicate .= ' OR bedrooms = '.substr($l, 2);
		}
		if (strncasecmp($l, 'a_', 2) == 0) {
			$amenity_id = substr($l, 2);
			$amenities_predicate .= "AND exists(select * from posting_amenity where postings.id = posting_amenity.posting_id AND amenity_id=$amenity_id) ";
		}
		if (strncasecmp($l, 'l_', 2) == 0) {
			$location_id = substr($l, 2);
			$location_predicate .= "AND exists(select * from posting_location where postings.id = posting_location.posting_id AND location_id=$location_id) ";
		}
	}
	$bedroom_predicate .= ')';
	
	if ($bedroom_predicate == 'AND (1 = 0)') $bedroom_predicate = '';
	
	// amenities predicate
	$query = "select * from postings WHERE 1 = 1 $bedroom_predicate $location_predicate $amenities_predicate";
	$result= mysql_query( $query );
	if (!$result) {
    		$message  = 'Invalid query: ' . mysql_error() . "\n";
    		$message .= 'Whole query: ' . $query;
    		die($message);
	}

	$result_arr = array();
	while ($row = mysql_fetch_assoc($result)) {
		$result_arr[] = $row;
	}
	mysql_close();
	echo json_encode($result_arr);
	exit();
?>
