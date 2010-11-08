<?php
	$LISTINGS_PER_PAGE = 100;
	$link = mysql_connect('localhost', 'thedom_thedom', 'ETP+}fViQKK_');
	mysql_select_db('thedom_info', $link);
	// Get the list of listings for this user (no more than 100
	//var_dump($_GET);
	$query = "select * from postings"; // where facebook_id=".mysql_real_escape_string($_GET['fb_sig_user']);
	$result= mysql_query( $query );
	if (!$result) {
    		$message  = 'Invalid query: ' . mysql_error() . "\n";
    		$message .= 'Whole query: ' . $query;
    		die($message);
	}
	while ($row = mysql_fetch_assoc($result)) {
		echo 'posting_id:';
		echo $row[id].' '. $row[info].' '.$row[address];
		echo '<br>';
	}
	mysql_close();
?>
