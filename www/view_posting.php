<?php require_once('../lib/header.php');?>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<div id="tabs">
<ul>
	<li><a href="#tabs-1">Basic Info</a></li>
	<li><a href="#tabs-2">Photos</a></li>
	<li><a href="#tabs-3">Maps</a></li>
	<li><a href="#tabs-4">Streetview</a></li>
</ul>
<div id="tabs-1">
<p>basic info</p>
</div>
<div id="tabs-2">
<p>photos</p>
</div>
<div id="tabs-3">
<p>maps</p>
</div>
<div id="tabs-4">
<p>street view</p>
</div>
</div>
<?php require_once('../lib/footer.php');?>

