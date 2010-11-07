<?php

require_once('../lib/header.php');
require_once('../lib/posting_editor.php');
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
  $posting = array();
  $posting['id'] = edx($_POST, 'posting_id', 'No data');
  $posting['title'] = edx($_POST, 'posting_title', 'No data');
  $posting['address'] = edx($_POST, 'posting_address', 'No data');
  $posting['cost'] = edx($_POST, 'posting_cost', 'No data');
  $posting['info'] = edx($_POST, 'posting_info', 'No data');
  echo "Received info <hr />";
  foreach ($posting as $key => $val) {
    echo "Posting {$key}: " . htmlspecialchars($val) . "<br />";
  }
} else {
  $page_editor = new PostingEditor();
  $page_editor->setId('test_1')
              ->setAction('create_posting.php')
              ->setTitle('10$ Super awesome place to live');

  echo $page_editor->render();
}
require_once('../lib/footer.php');

?>