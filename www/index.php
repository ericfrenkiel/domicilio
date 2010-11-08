<?php require_once('../lib/header.php');?>

<form action="index.php">
<input name="search" type="text"/>
		<input type="text" id="CityLocal" value="" />
		<input type="button" value="Get Value" onclick="lookupLocal();" />
		<input name="submit" type="submit"/>
</form>

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
		echo $row[id].' '.$row[title].' '.$row[info].' '.$row[address];
		echo '<br>';
	}
	mysql_close();
?>

<script type="text/javascript">

var ac = $("#CityLocal").autocomplete("/location_typeahead.php");

function findValue(li) {
	if( li == null ) return alert("No match!");

	// if coming from an AJAX call, let's use the CityId as the value
	if( !!li.extra ) var sValue = li.extra[0];

	// otherwise, let's just display the value in the text box
	else var sValue = li.selectValue;

	alert("The value you selected was: " + sValue);
}

function selectItem(li) {
	findValue(li);
}

function formatItem(row) {
	return row[0] + " (id: " + row[1] + ")";
}

function lookupAjax(){
	var oSuggest = $("#CityAjax")[0].autocompleter;

	oSuggest.findValue();

	return false;
}

function lookupLocal(){
	var oSuggest = $("#CityLocal")[0].autocompleter;

	oSuggest.findValue();

	return false;
}
</script>

</html>

<?php require_once('../lib/footer.php');?>
