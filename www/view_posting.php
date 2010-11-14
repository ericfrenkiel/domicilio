<?php

require_once('../lib/header.php');
require_once('../lib/Posting.php');
$id = $_GET['id'];
$id = (int)idx($_GET, 'id', 0);
$posting = Posting::fromDB($id);
if ($posting) {
?>
 <div id="fb-root"></div>
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
      appId  : '<?php echo THEDOM_APP_ID; ?>',
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : false  // parse XFBML
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
<h1><?php echo htmlspecialchars($posting->getTitle()); ?></h1>
<div class="price">
      <div class="price_data">
          <sup class="currency_if_required"></sup><sup>$</sup>
      <div class="currency_with_sup"><?php echo htmlspecialchars($posting->getCost()); ?></div>
       </div>
   <div class="price_modifier">                    Per month
    </div>
               </div>
<br /> <br />
<?php echo htmlspecialchars($posting->getAddress()); ?>
<div id="left">
<div id="tabs">
<ul>
	<li><a href="#tabs-2">Photos</a></li>
	<li><a href="#tabs-3">Maps</a></li>
	<li><a href="#tabs-4">Streetview</a></li>
	<li><a href="#tabs-1">Contact Information</a></li>
</ul>
<div id="tabs-2" style="min-height: 400px; min-width:500px; text-align: center;">
<?php
foreach ($posting->getPhotos() as $photo) {
  echo "<img src=\"" . htmlspecialchars($photo['src']) . "\" "
    . "style=\"max-width:450px;\" /><br />";
}
?>
</div>
<div id="tabs-3" style="min-height: 400px; min-width:500px;" >
<script>
var map;
var geocoder;
var panorama;
var position;
function initialize() {
    geocoder = new google.maps.Geocoder();
    var req = <?php echo json_encode(array(
      'address' => $posting->getFullAddress())); ?>;
    geocoder.geocode( req, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        position = results[0].geometry.location;
        var myOptions = {
          zoom: 14,
          center: position,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("tabs-3"), myOptions);

        var marker = new google.maps.Marker({
          map: map,
          position: position
         });

      	var panoOptions = {
      	  position: position,
      	  addressControlOptions: {
      	    position: google.maps.ControlPosition.BOTTOM,
      	    style: {
      	      "fontWeight" : "bold",
      	      "backgroundColor" : "#85AA40",
      	      "color" :"#FFFFFF"
      	    }
      	  },
      	  linksControl: false,
      	  navigationControlOptions: {
      	    style: google.maps.NavigationControlStyle.SMALL
      	  },
      	  enableCloseButton: false,
      	};
      	panorama = new google.maps.StreetViewPanorama(
      	    document.getElementById("tabs-4"), panoOptions);

        $('#tabs').bind('tabsshow', function(event, ui) {
            if (ui.panel.id == "tabs-4") {
              google.maps.event.trigger(panorama, 'resize');
            } else
            if (ui.panel.id == "tabs-3") {
              google.maps.event.trigger(map, 'resize');
              map.setCenter(position);
            }
          });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    }
    );

  }
</script>
</div>
<div id="tabs-4" style="min-height: 400px; min-width:500px;">
<script>
initialize();
</script>
</div>
<div id="tabs-1" style="min-height: 400px; min-width:500px; margin-bottom: 20px;">

<script>
function contactOwner() {

}
</script>

<input value="Contact The Owner" onClick="contactOwner()" type="button" onClick="contactOwner()"/>
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
<div class="v3_button" style="width:50px;height:25px;">Grab</div>
<div class="v3_button v3_orange" style="width:50px;height:25px;">Save</div>
<div class="v3_button v3_red" style="width:50px;height:25px;">Poll</div>
</div>

</div>


<?php
} else {
  echo "I don't get it.";
}
  require_once('../lib/footer.php');
?>

