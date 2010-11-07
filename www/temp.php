<?php
echo "<!DOCTYPE html>
<html>
<head>
<meta name=\"viewport\" content=\"initial-scale=1.0, user-scalable=no\" />
<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"/>
<title>Google Maps JavaScript API v3 Example: Marker Simple</title>
<link href=\"http://code.google.com/apis/maps/documentation/javascript/examples/default.css\" rel=\"stylesheet\" type=\"text/css\" />
<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>
<script type=\"text/javascript\">
  function initialize() {
    var myLatlng = new google.maps.LatLng(-25.363882,131.044922);
    var myOptions = {
      zoom: 4,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById(\"map_canvas\"), myOptions);

    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title:\"Hello World!\"
    });
  }
</script>
</head>
<body onload=\"initialize()\">
  <div id=\"map_canvas\" style='width:200px;height:200px;></div>
</body>

</html>
\n";
?>