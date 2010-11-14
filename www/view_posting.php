<?php

require_once('../lib/header.php');
$link = mysql_connect('localhost', 'thedom_thedom', 'ETP+}fViQKK_');
mysql_select_db('thedom_info', $link);
$id = $_GET['id'];
$query = "select * from postings where id=$id";
$result= mysql_query( $query );
$row = mysql_fetch_assoc($result);
?>

<script>
	$(function() {
		$("#tabs").tabs();
		$("#tabs2").tabs();
		$("button").button();
	});
</script>
<script type="text/javascript"
    src="http://maps.google.com/maps/api/js?sensor=false">
</script>
 <div id="fb-root"></div>
 <script>

function make_request(id, fb_id) {
  $.ajax({
      url: 'ajax/record.php?id='+id+'&fb_id='+fb_id,
        success: function(data) {
        $('.result').html(data);
        alert('Load was performed.');
      }
    });
}

function login(id) {
  FB.login(function(response) {
             if (response.session) {
               FB.api('/me', function(response) {
                        if (response.session) {
                          make_request(id, response.id);
                        } else {
                          alert('You have to allow to connect to Facebook to perform this action');
                        }
                      });
             }
           }
          );
}

function record(id) {
  FB.init({
      appId  : '111665148898653',
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : true  // parse XFBML
        });

  FB.getLoginStatus(function(response) {
                      if (response.session) {
                        FB.api('/me', function(response) {
                                 make_request(id, response.id);
                               });
                      } else {
                        login(id);
                      }
                    });
}

</script>
<div id="view">
<h1><?php echo $row['title']?></h1>
<div class="price">
      <div class="price_data">
          <sup class="currency_if_required"></sup><sup>$</sup>
      <div class="currency_with_sup"><?php echo $row['cost'] ?></div>
       </div>
   <div class="price_modifier">                    Per month
    </div>
               </div>
<br /> <br />
<?php echo $row['address'] ?>
<div id="left">
<div id="tabs">
<ul>
	<li><a href="#tabs-2">Photos</a></li>
	<li><a href="#tabs-3">Maps</a></li>
	<li><a href="#tabs-4">Streetview</a></li>
<<<<<<< HEAD
	<li><a href="#tabs-1" onclick="record(<?php echo $_GET['id']?>);">Grab it</a></li>
=======
	<li><a href="#tabs-1" onclick="alert('here');record(<?php echo $_GET['id']?>);">Contact Information</a></li>
>>>>>>> b54e9498bfb5168ff5e005e0ff2866ff7d8f0487
</ul>
<div id="tabs-2">
<?php

$query = "select * from posting_photos where posting_id=$id";
$result= mysql_query( $query );
while ($img_row = mysql_fetch_assoc($result)) {
?>
        <img src="<?php echo $img_row['photo_url'] ?>" width="350"/>
<?php
}

?>
</div>
<div id="tabs-3" style="min-height: 400px; min-width:500px;" >
<script>
function initialize() {

    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 14,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("tabs-3"), myOptions);

    geocoder = new google.maps.Geocoder();

    geocoder.geocode( { 'address': '<?php echo $row['address'] ?>'}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                          map.setCenter(results[0].geometry.location);
                          var marker = new google.maps.Marker({
                            map: map,
                                position: results[0].geometry.location
                                });
                        } else {
                          alert("Geocode was not successful for the following reason: " + status);
                        }
                      }
                      );

  }
initialize();
</script>
</div>
<div id="tabs-4" style="min-height: 400px; min-width:500px;">
<script>

        var fenway = new google.maps.LatLng(42.345573,-71.098326);

	// Note: constructed panorama objects have visible: true
	// set by default.
	var panoOptions = {
	  position: fenway,
	  addressControlOptions: {
	    position: google.maps.ControlPosition.BOTTOM,
	    style: {
	      "fontWeight" : "bold",
	      "backgroundColor" : "#191970",
	      "color" :"#A9203E"
	    }
	  },
	  linksControl: false,
	  navigationControlOptions: {
	    style: google.maps.NavigationControlStyle.SMALL
	  },
	  enableCloseButton: false,
	  visible:true
	};

	var panorama = new google.maps.StreetViewPanorama(
	    document.getElementById("tabs-4"), panoOptions);

    geocoder.geocode( { 'address': '<?php echo $row['address'] ?>'}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                          panorama.setPosition(results[0].geometry.location);
                                        } else {
                          alert("Geocode was not successful for the following reason: " + status);
                        }
                      }
                      );

</script>
<script>
$('#tabs').bind('tabsshow', function(event, ui) {
                  if (ui.panel.id == "tabs-4") {
                    google.maps.event.trigger(panorama, 'resize');
                    panorama.setZoom( panorama.getZoom() );
                  }
                });

</script>
</div>
<div id="tabs-1" style="margin-bottom: 20px;">

<script>
function contactOwner() {

}
</script>

<inpxut value="Contact The Owner" onClick="contactOwner()" type="button" onClick="contactOwner()"/>
</div>

</div>

<div id="tabs2" style="margin-top:10px;margin-bottom:10px;">
<ul>
	<li><a href="#tabs-5">Description</a></li>
	<li><a href="#amenities">Amenities</a></li>
</ul>
<div id="tabs-5">

<div id="description" class="details_content">
            <div id="description_text" class="rounded_less trans">
<?php echo $row['info']?>
            </div>

        </div>

</div>
<div id="amenities">
<div style="display: block; " class="details_content">
                <ul>
                        <li>
                            <div class="has_not"></div>
                            <p>Smoking Allowed </p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Pets Allowed </p>

                        </li>

                        <li>
                            <div class="has"></div>
                            <p>TV </p>

                        </li>

                        <li>
                            <div class="has"></div>
                            <p>Cable TV </p>

                        </li>

                        <li>
                            <div class="has"></div>
                            <p>Internet <a class="tooltip" title="Internet (wired or wireless)"><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                        <li>
                            <div class="has"></div>
                            <p>Wireless Internet <a class="tooltip" title="A wireless router that guests can access 24/7."><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Air Conditioning </p>

                        </li>

                        <li>
                            <div class="has"></div>
                            <p>Heating </p>

                        </li>

                </ul>

                <ul>

                        <li>
                            <div class="has_not"></div>
                            <p>Elevator in Building </p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Handicap Accessible <a class="tooltip" title="The property is easily accessible.  Guests should communicate about individual needs."><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Pool <a class="tooltip" title="A private swimming pool"><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                        <li>
                            <div class="has"></div>
                            <p>Kitchen <a class="tooltip" title="Kitchen is available for guest use"><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Parking Included </p>

                        </li>

                        <li>
                            <div class="has"></div>
                            <p>Washer / Dryer <a class="tooltip" title="Paid or Free, in building"><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Doorman </p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Gym <a class="tooltip" title="Guests have free access to a gym"><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                </ul>

                <ul>

                        <li>
                            <div class="has_not"></div>
                            <p>Hot Tub </p>

                        </li>

                        <li>
                            <div class="has"></div>
                            <p>Indoor Fireplace </p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Buzzer/Wireless Intercom </p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Breakfast <a class="tooltip" title="Breakfast is provided."><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Family/Kid Friendly <a class="tooltip" title="The property is suitable for hosting families with children."><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                        <li>
                            <div class="has_not"></div>
                            <p>Suitable for Events <a class="tooltip" title="The property can accommodate a gathering of 25 or more attendees."><img alt="Questionmark_hover" src="/images/icons/questionmark_hover.png?1279494361" style="width:12px; height:12px;"></a></p>

                        </li>

                </ul>

</div>
</div>

            <div class="clear"></div>

        </div>
</div><div id="right">
<input class="v3_button" value="Grab" style="width:50px;height:25px;" />
<input class="v3_button v3_orange" value="Save" style="width:50px;height:25px;" />
<input class="v3_button v3_red" value="Poll" style="width:50px;height:25px;" />
</div>

</div>


<?php require_once('../lib/footer.php');?>

