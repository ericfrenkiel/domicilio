<?php

require_once('../lib/header.php');
require_once('../lib/Posting.php');
require_once('../lib/PostingEditor.php');
if (isset($_GET['test'])) {
  $res = db_query('desc postings');
  echo "<pre>";
  while ($arr = db_fetch($res)) {
    foreach ($arr as $val) {
      echo htmlspecialchars($val) . " ";
    }
    echo  "\n";
  }
  echo "</pre>";
} else if (isset($_POST['posting_submitted'])) {
  $posting = Posting::fromPOST();
  echo "Received info <hr />";
  echo "Posting: " . htmlspecialchars($posting->getTitle()) . "<br />";
} else {
  $page_editor = new PostingEditor();
  $page_editor->setAction('create_posting.php')
              ->setPosting(id(new Posting())
                             ->setId('test_1')
                             ->setTitle('10$ Super awesome place to live'));

  echo $page_editor->render();
}
require_once('../lib/footer.php');

?>