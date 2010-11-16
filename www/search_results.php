<?php
        require_once '../lib/header.php';
	$LISTINGS_PER_PAGE = 100;
	$link = mysql_connect('localhost', 'thedom_thedom', 'ETP+}fViQKK_');
	mysql_select_db('thedom_info', $link);

	$locations = array_filter(split(',', $_GET['q']));
        // bedrooms predicate
	$bedroom_predicate = 'AND (1 = 0';
	$amenities_predicate = '';
	$location_predicate = '';
        $bm_predicate = '';
        $users = array();
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
                if (strncasecmp($l, 'n_', 2) == 0) {
                        $users[] = substr($l, 2);
                }
	}
	$bedroom_predicate .= ')';

	if ($bedroom_predicate == 'AND (1 = 0)') $bedroom_predicate = '';


        $locations = array();
        $locations_predicate;
        $locations_project;
        if ($users) {
                foreach ($users as $fb_id) {
                        $locations[$fb_id] = array();
                        $places = json_decode(curl_request("https://graph.facebook.com/$fb_id/checkins", array(type => 'checkin', 'access_token' => $session['access_token'], 'method' => 'GET')));
                        foreach ($places->{'data'} as $checkin) {
                                $locations[$fb_id][] = array('lat' => $checkin->{place}->{location}->{latitude}, 'lon' => $checkin->{place}->{'location'}->{'longitude'});
                        }
                }

                $locations_predicate = "AND (1 = 0";
                foreach ($users as $fb_id) {
                        $locations_project .= ", 1 = 0";
                        foreach ($locations[$fb_id] as $l) {
                                $cond = " or GLength(LineStringFromWKB(LineString(postings.location, GeomFromText('POINT({$l['lat']} {$l['lon']})')))) < 0.1";
                                $locations_project .= " $cond";
                                $locations_predicate .= " $cond";
                        }
                        $locations_project .= " as d_$fb_id";
                }
                $locations_predicate .= ")";
        }

	$query = "select distinct postings.id,
                        postings.title,
                        postings.cost,
                        postings.address,
                        postings.city,
                        postings.state,
                        posting_photos.posting_id,
                        posting_photos.photo_url_thumbnail
                        $locations_project
                from
                        postings
                inner join posting_photos on postings.id = posting_photos.posting_id
                WHERE 1 = 1
                        $bedroom_predicate $location_predicate $amenities_predicate $bm_predicate $locations_predicate";
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

<div class="face_pil">
<?php
        foreach ($users as $fb_id) {
                if ($row["d_$fb_id"]) {
                        echo '<img src="https://graph.facebook.com/'.$fb_id.'/picture" class=profile_pic/>';
                }
        }
?>
</div>
               </div>

  </li>
<?php endforeach;?>

</ul>
