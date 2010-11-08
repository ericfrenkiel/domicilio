<?php

require_once("../lib/core.php");
require_once("../lib/db.php");
if (isset($_POST['posting_submitted'])) {
  require_once('../lib/Posting.php');
  $posting = Posting::fromPOST();
  echo "Preview <hr />";
  require_once('../lib/PostingRenderer.php');
  $renderer = new PostingRenderer($posting);
  echo $renderer->render();
}
?>