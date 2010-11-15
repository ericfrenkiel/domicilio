<?php

require_once("../lib/core.php");
require_once("../lib/db.php");


if (isset($_POST['posting_submitted'])) {
  require_once('../lib/Posting.php');
  global $posting;
  $posting = Posting::fromPOST();
  echo "Preview <hr />";
  if ($posting) {
    require('../lib/pattern.php');
  } else {
    echo "No posting";
  }
}

?>