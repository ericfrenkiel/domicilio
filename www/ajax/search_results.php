<?php
	$LISTINGS_PER_PAGE = 100;
	$link = mysql_connect('localhost', 'thedom_thedom', 'ETP+}fViQKK_');
	mysql_select_db('thedom_info', $link);

	$locations = array_filter(split(',', $_GET['q']));
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
	$query = "select distinct postings.id, postings.title, postings.cost, postings.address, postings.city, postings.state, posting_photos.posting_id, posting_photos.photo_url_thumbnail from postings inner join posting_photos on postings.id = posting_photos.posting_id WHERE 1 = 1 $bedroom_predicate $location_predicate $amenities_predicate $bm_predicate";
	$result= mysql_query( $query );
	if (!$result) {
	  $message  = 'Invalid query: ' . mysql_error() . "\n";
	  $message .= 'Whole query: ' . $query;
	  die($message);
	}

// createan array and traverse it twcice one for the ,ap and once for the results
$result_arr = array();
$uniq = array();
while ($row = mysql_fetch_assoc($result)) {
  if (isset($uniq[$row[id]])) {
    continue;
  }
  $uniq[$row[id]] = true;
  $result_arr[] = $row;
 }
mysql_close();

?>

<ul>
<?php
foreach($result_arr as $row):?>
  <li class="listing" style="float:left; width:700px;height:95px;border-bottom:1px dotted #A8A8A8;padding-top:5px;display:block;">
  <div class="apt_img" style="display: block; float:left;  min-width: 100px; height: 95px;margin-right:1q0px;"><a href="/view_posting.php?id=<?php echo $row[id]; ?>">
        <img style="padding:5px;border:none;" height="65" src="<?php echo $row[photo_url_thumbnail]; ?>" /></a></div>
  <div class="apt_info" style="display:block;">
    <div class="apt_title" style="float:left;display:block;"><a href="/view_posting.php?id=<?php echo $row[id]; ?>"><?php echo $row[title];?></a> </div>
    <div class="apt_address" style="float:left;display:block;width:500px;"><?php echo $row[address]?></div>
  </div>
  <div class="price" style="position:relative;top: -20px;">
      <div class="price_data">
          <sup class="currency_if_required"></sup><sup>$</sup>
      <div class="currency_with_sup"><?php echo $row[cost]?></div>
       </div>
   <div class="price_modifier">                    Per month
    </div>
               </div>

  </li>
<?php endforeach;?>

</ul>
