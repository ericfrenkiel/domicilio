<?php

$posting_id = $_GET['id'];
$profile_id = $_GET['fb_id'];

$link = mysql_connect('localhost', 'thedom_thedom', 'ETP+}fViQKK_');
mysql_select_db('thedom_info', $link);
$query = "replace posting_interest set profile_id = $profile_id, posting_id = $posting_id";
$result= mysql_query( $query );

if ($result)
        echo 'success';
else
        echo mysql_error();;
?>