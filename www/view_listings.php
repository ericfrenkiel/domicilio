<?php
	$locations = array_filter(split(',', $_GET['as_values_q']));
	foreach ($locations as $l) {

                if ($l == 'bm') {
                        $require_signed = 1;
                }
        }
        require_once '../lib/header.php';
?>


<div id="searchpage" class="rounded_top">
<div id="searchbar" class="rounded_top">
<div id="search_params">

<form action="view_listings.php?auth_nikita=1">
        <input type="hidden" name="auth_nikita" value="1" />
	<input type="text" id="as-selections-q" value="" class="as-value rounded"/>
<input type="submit" style="-moz-border-radius-bottomleft: 0pt; -moz-border-radius-topleft: 0pt; width: 120px; position: relative;" class="as-value v3_button v3_fixed_width" value="Search" name="submit">
</form>
</div></div>
<div id="search_body">
<?php
	$LISTINGS_PER_PAGE = 100;
	$link = mysql_connect('localhost', 'thedom_thedom', 'ETP+}fViQKK_');
	mysql_select_db('thedom_info', $link);

	$locations = array_filter(split(',', $_GET['as_values_q']));
        // bedrooms predicate
	$bedroom_predicate = 'AND (1 = 0';
	$amenities_predicate = '';
	$location_predicate = '';
        $bm_predicate = '';
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
                if (strncasecmp($l, 'bm', 2) == 0 && $uid) {
                        $bm_predicate = "AND exists(select * from posting_interest where postings.id = posting_interest.posting_id AND profile_id=$uid)";
                }
	}
	$bedroom_predicate .= ')';

	if ($bedroom_predicate == 'AND (1 = 0)') $bedroom_predicate = '';

	// amenities predicate
	$query = "select * from postings WHERE 1 = 1 $bedroom_predicate $location_predicate $amenities_predicate $bm_predicate";
	$result= mysql_query( $query );
	if (!$result) {
	  $message  = 'Invalid query: ' . mysql_error() . "\n";
	  $message .= 'Whole query: ' . $query;
	  die($message);
	}


// createan array and traverse it twcice one for the ,ap and once for the results
$result_arr = array();
while ($row = mysql_fetch_assoc($result)) {
  $result_arr[] = $row;
 }
mysql_close();

foreach($result_arr as $row) {
  echo 'posting_id:';
  echo $row[id].' '.$row[title].' '.$row[info].' '.$row[address];
  echo '<br>';
}

?>


<script type="text/javascript">

var ac = $("#as-selections-q").autoSuggest("/location_typeahead.php", {selectedItemProp: "name", searchObjProps: "name", asHtmlID: "q"});

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
	var oSuggest = $("#as-selections-q")[0].autocompleter;

	oSuggest.findValue();

	return false;
}

function lookupLocal(){
	var oSuggest = $("#as-selections-q")[0].autocompleter;

	oSuggest.findValue();

	return false;
}
</script>
</div></div>
</html>

<?php require_once('../lib/footer.php');?>


