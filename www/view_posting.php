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
<script type="text/javascript" src="/js/galleria.js"></script>
<script>Galleria.loadTheme('js/themes/classic/galleria.classic.js');</script>

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
    if (response.perms) {
       FB.api('/me', function(response) {
          if (response.session) {
            make_request(id, response.id);
          } else {
            alert('You have to allow to connect to Facebook to perform this action');
          }
        });
    } else {
    }
  } else {
  }
}, {perms:'user_photos,user_videos,user_checkins,publish_stream,email,friends_checkins'});
}

function record(id) {
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
function shareWithFriends() {
	FB.ui(
	  {
	    method: 'stream.publish',
	    message: 'I\'m thinking of moving here soon. What do you think?',
	    attachment: {
	      name: '<?php echo addslashes($posting->getTitle()) ?>',
	      caption: '<?php echo addslashes($posting->getFullAddress()) ?>',
	      description: (
	        ' '
	      ),
	      href: '<?php echo THEDOM_APP_URL ;?>view_posting.php?id=<?php echo $posting->getId(); ?>/'
	    },
	    action_links: [
	      { text: 'Check out Domicilio', href: '<?php echo THEDOM_APP_URL; ?>' }
	    ],
	    user_message_prompt: 'Ask your friends if this is a good place to live.'
	  },
	  function(response) {
		if (response && response.post_id) {
	    $('#askFriends').remove();
	  }}
	);
}
function contactPoster() {
jQuery.facebox('The owner has been notified of your interest. You will hear back soon!');
$('#contactPoster').fadeOut();
}
function savePosting() {
jQuery.facebox('Posting saved! To see it again just type "me" into the magic bar.');
$('#savePosting').fadeOut();
}

</script>
<div id="view">
<h1><?php echo htmlspecialchars($posting->getTitle()); ?></h1><br/>
<p style="margin-left: 30px;"><?php echo htmlspecialchars($posting->getFullAddress()); ?></p>
<div class="price" style="position: relative; top:-70px;">
      <div class="price_data">
          <sup class="currency_if_required"></sup><sup>$</sup>
      <div class="currency_with_sup"><?php echo htmlspecialchars($posting->getCost()); ?></div>
       </div>
   <div class="price_modifier">                    Per month
    </div>
               </div>


<!--<div id="left">-->

	<div id="contactPoster" class="v3_button" style="float:left;width:140px;height:25px;padding:5px 10px; margin-right:10px;"  onclick="contactPoster()">Contact Owner</div>
	<div id ="savePosting" class="v3_button v3_orange" style="float:left;width:140px;height:25px;padding:5px 10px; margin-right:10px;" onclick="savePosting()">Save for Later</div>
	<div id="askFriends" class="v3_button v3_blue" style="float:left;width:140px;height:25px;padding:5px 10px;margin-right:10px;" onclick="shareWithFriends();">Ask my Friends</div>
	<br /><br />
<div id="tabs">
<ul>
	<li><a href="#tabs-2">Photos</a></li>
	<li><a href="#tabs-3">Maps</a></li>
	<li><a href="#tabs-4">Streetview</a></li>
<!--	<li><a href="#tabs-1">Contact Information</a></li> -->
</ul>


<div id="tabs-2" style="min-height: 400px; min-width:500px; text-align: center;background-color: black;">
	<div class="images" style="height:600px; width: 700px;">
		<?php foreach ($posting->getPhotos() as $photo): ?>
  			<img  src=" <?php echo  htmlspecialchars($photo['src']);?> "/>
		<?php endforeach; ?>
	</div>

<script>$('.images').galleria();</script>
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
    geocoder.geocode(req, function(results, status) {
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
<!--<div id="tabs-1" style="min-height: 400px; min-width:500px; margin-bottom: 20px;">

<script>
function contactOwner() {

}
</script>

<input value="Contact The Owner" onClick="contactOwner()" type="button" onClick="contactOwner()"/>

</div>
-->
</div>

<div id="tabs2" style="margin-top:10px;margin-bottom:10px;">
<ul>
	<li><a href="#tabs-5">Description</a></li>
	<li><a href="#amenities">Amenities</a></li>
</ul>
<div id="tabs-5">

<div id="description" class="details_content">
            <div id="description_text" class="rounded_less trans">
<?php echo htmlspecialchars($posting->getInfo())?>
            </div>

        </div>

</div>
  <div id="amenities" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
      <div class="details_content" style="display: block;">
        <ul>
          <li>
            <div class="has_not"></div>
            <p>
              Smoking Allowed
            </p>
          </li>
          <li>
            <div class="has_not"></div>
            <p>
              Pets Allowed
            </p>
          </li>
          <li>
            <div class="has"></div>
            <p>
              TV
            </p>
          </li>
          <li>
            <div class="has"></div>
            <p>
              Cable TV
            </p>
          </li>
          <li>
            <div class="has"></div>
            <p>
              Internet <a title="Internet (wired or wireless)" class="tooltip"></a>
            </p>
          </li>
          <li>
            <div class="has"></div>
            <p>
              Wireless Internet <a title="A wireless router that guests can access 24/7." class="tooltip"></a>
            </p>
          </li>
          <li>
            <div class="has_not"></div>
            <p>
              Air Conditioning
            </p>
          </li>
          <li>
            <div class="has"></div>
            <p>
              Heating
            </p>
          </li>
        </ul>
        <ul>
          <li>
            <div class="has_not"></div>
            <p>
              Elevator in Building
            </p>
          </li>
          <li>
            <div class="has_not"></div>
            <p>
              Handicap Accessible <a title="The property is easily accessible. Guests should communicate about individual needs." class="tooltip"></a>
            </p>
          </li>
          <li>
            <div class="has_not"></div>
            <p>
              Pool <a title="A private swimming pool" class="tooltip"></a>
            </p>
          </li>
          <li>
            <div class="has"></div>
            <p>
              Kitchen <a title="Kitchen is available for guest use" class="tooltip"></a>
            </p>
          </li>
          <li>
            <div class="has_not"></div>
            <p>
              Parking Included
            </p>
          </li>
          <li>
            <div class="has"></div>
            <p>
              Washer / Dryer <a title="Paid or Free, in building" class="tooltip"></a>
            </p>
          </li>
          <li>
            <div class="has_not"></div>
            <p>
              Doorman
            </p>
          </li>
          <li>
            <div class="has_not"></div>
            <p>
              Gym <a title="Guests have free access to a gym" class="tooltip"></a>
            </p>
          </li>
        </ul>
        <ul>
          <li>
            <div class="has_not"></div>
            <p>
              Hot Tub
            </p>
          </li>
          <li>
            <div class="has"></div>
            <p>
              Indoor Fireplace
            </p>
          </li>
        </ul>
      </div>
    </div>

            <div class="clear"></div>

        </div>
<!--</div><div id="right">-->

</div>

<!--</div>-->


<?php
} else {
  echo "I don't get it.";
}
  require_once('../lib/footer.php');
?>

