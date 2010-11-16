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

<script>
function updateSearchResult() {
  $.ajax({
      url: "/search_results.php?q=" + $("#as-values-q").val(),
        cache: false,
        success: function(html){
        $("#search_results").html(html);
      }
    });
}
</script>

<form action="postings.php?auth_nikita=1" name="searchForm">
        <input type="hidden" name="auth_nikita" value="1" />
	<input type="text" id="as-selections-q" value="" class="as-value rounded"/>
<input type="button" onclick="updateSearchResult();" style="-moz-border-radius-bottomleft: 0pt; -moz-border-radius-topleft: 0pt; width: 120px; position: relative;" class="as-value v3_button v3_fixed_width" value="Search" name="submit">
</form>

<div id="search_results">
</div>


<div id="search_js">
<script type="text/javascript">
<?php require 'gen_search_index.php' ?>
var ac = $("#as-selections-q").autoSuggest(search_index.items, {selectedItemProp: "name", searchObjProps: "name", asHtmlID: "q", preFill: search_init.items});
updateSearchResult();
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
</div>


<?php mysql_close();
require_once('../lib/footer.php');?>


