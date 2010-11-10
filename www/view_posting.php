<?php require_once('../lib/header.php');?>
<script>
	$(function() {
		$("#tabs").tabs();
		$("#tabs2").tabs();
	});
</script>
<script type="text/javascript"
    src="http://maps.google.com/maps/api/js?sensor=false">
</script>
<h1>Beauitful 1 bd/1ba in SOMA</h1>
	<div id="price">$2300</div>
<br /> <br />
lorem ipsum
<div id="tabs">
<ul>
	<li><a href="#tabs-2">Photos</a></li>
	<li><a href="#tabs-3">Maps</a></li>
	<li><a href="#tabs-4">Streetview</a></li>
	<li><a href="#tabs-1">Grab it</a></li>
</ul>
<div id="tabs-2">
<p>photos</p>
</div>
<div id="tabs-3" style="min-height: 400px; min-width:500px;" >
<script>
function initialize() {
    var myLatlng = new google.maps.LatLng(42.345573,-71.098326);
    var myOptions = {
      zoom: 8,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("tabs-3"), myOptions);
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
</div>

</div>
<div id="tabs2">
<ul>
	<li><a href="#tabs-5">Description</a></li>
	<li><a href="#amenities">Amenities</a></li>
</ul>
<div id="tabs-5">

<div id="description" class="details_content">
            <div id="description_text" class="rounded_less trans">
                <p>please check homeawayconnect calendar property no. 407955</p>

<p>a desert-style luxury retreat in Venice Beach.
<br>eight blocks from the beach, steps to Santa Monica.
<br>Perfect for two. </p>

<p>Cactus Flower is a brand-new 100% sustainable building with solar electric power, solar 
radiant floor heating, solar domestic hot water, reverse osmosis water filtration, hi-efficacy 
appliances, organic cotton towels and linens and non-toxic cleaners.
</p>
            </div>

            <ul id="description_details" class="rounded_less">
                <li style="padding:0 0 8px 10px; font-size:14px;">Details</li>
                <li class="alt"><span class="property">Room type:</span><span 
class="value">Entire home/apt</span></li>
                <li><span class="property">Bed type:</span><span class="value">Real 
Bed</span></li>
                <li class="alt"><span class="property">Accommodates:</span><span 
class="value">2</span></li>
                
                    <li><span class="property">Bedrooms:</span><span 
class="value">1</span></li>
                
                
                    <li class="alt"><span class="property">Bathrooms:</span><span 
class="value">1</span></li>
                

                
                    <li><span class="property">Extra people:</span><span class="value" 
id="extra_people_pricing">No Charge</span></li>
                

                
                    <li class="alt"><span class="property">Minimum Stay:</span><span 
class="value">7 nights</span></li>
                
                
                    <li><span class="property">Weekly Price:</span><span class="value"><span 
id="weekly_price_string">$1600</span> / week</span></li>
                
                
                    <li class="alt"><span class="property">Monthly Price:</span><span 
class="value"><span id="monthly_price_string">$5850</span> / month</span></li>
                
                
                

                

                
                    
                        <li><span class="property">city:</span><span class="value">
                        <a href="/venice">Venice</a></span>
                        </li>

                        
                    
                

                
                    <li class="alt"><span class="property">Size:</span><span 
class="value">600ft<sup style="line-height:0;">2</sup> / 56m<sup 
style="line-height:0;">2</sup></span></li>
                
                <li><span class="property">Cancellation:</span><span class="value"><a 
href="/home/cancellation_policies" onclick="window.open(this.href);return 
false;">Strict</a></span></li>
                
            </ul>
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
            

            <div class="clear"></div>

        </div>
</div>
</div>
<?php require_once('../lib/footer.php');?>

