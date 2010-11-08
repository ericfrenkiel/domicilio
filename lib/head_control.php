<?php
global $head_included;
$head_included = array();

function include_css($file) {
  global $head_included;
  $head_included[] = "<link href=\"/css/" . $file . "\" media=\"screen\""
    . " rel=\"stylesheet\" type=\"text/css\" />";
}

function include_js($file) {
  global $head_included;
  $head_included[] = "<script type=\"text/javascript\" src=\"/js/" . $file
    . "\"></script>";
}

?>