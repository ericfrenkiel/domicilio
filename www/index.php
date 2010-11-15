<?php
$require_signed=1;
require_once('../lib/header.php');
?>

<div id="tagline" style="margin: 0px auto; margin-bottom: 30px; margin-top:30px; width: 500px; height: auto;">


<span style="margin:20px;font-size: 36px;height: 50px;">Find your next apartment<font align="center" style="margin-top:10px; font-size: 20px;position:relative;left:130px;"><br />(<i>near your friends</i>)</font></span>
</div>


<div id="bigbar" style="width: auto; height: 50px;margin:0px auto;">

<form action="/postings.php">
	<input type="text" id="as-selections-q" value="" class="as-value rounded" style="float:left;height: 28px;"/>
<input name="submit" type="submit" value="Search" class="v3_button v3_fixed_width" style="-moz-border-radius-bottomleft:0;
-moz-border-radius-topleft:0;
-webkit-border-radius-topleft:0;
-webkit-border-radius-bottomleft:0;
width:120px;position:relative;top:0x;
"/>
<span style="font-size:14px; color: #808080;float:left;">Ex. 1 bd/1ba near [friend's name]</span>
</form>

<script type="text/javascript">
<?php require 'gen_search_index.php' ?>
var ac = $("#as-selections-q").autoSuggest(search_index.items, {asHtmlID: "q", preFill: search_init.items});
</script>

</div>
<div id="homeboxbg">
<div class="homebox">
</div>
<div class=homebox">
</div>
<div class="homebox">
</div>
</div>
<?php require_once('../lib/footer.php');?>

