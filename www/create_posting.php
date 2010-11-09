<?php
$require_signed = true;
require_once('../lib/header.php');
require_once('../lib/Posting.php');
if (isset($_GET['photo_test'])) {
  $photo = '/home/evgeny/trunk/www/images/logo.png';
  if (is_readable($photo)) {
    $res = upload_photo($photo, 'Our logo');
    echo htmlspecialchars(print_r($res, true));
  } else {
    echo "FAIL";
  }
/*
    if ( !isset( $_FILES["ff$i"] ) || !$_FILES["ff$i"]['size'] )
      return true;
		$ff = $_FILES["ff$i"];
		$real_name = $ff['name'];
		$fsize = $ff['size'];
		settype( $fsize, 'integer' );
		$fn = $ff['tmp_name'];
*/
} else if (isset($_GET['test'])) {
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
  $posting->setOwnerId(123);
  if ($posting->getId()) {
    $posting->updateDB();
  } else {
    $posting->addToDB();
  }
  header("Location: view.php?id=" . $posting->getId());
  return;
} else {
  require_once('../lib/PostingEditor.php');
  $page_editor = new PostingEditor();
  $id = idx($_GET, 'id', 0);
  $posting = Posting::fromDB($id);
  $is_edit = true;
  if ($posting === false) {
    $posting = id(new Posting())
                 ->setCost('1000')
                 ->setTitle('10$ Super awesome place to live')
                 ->setAddress('1601 S California Ave')
                 ->setCity('Palo Alto')
                 ->setState('CA')
                 ->setInfo('Wassup, just take it');
    $is_edit = false;
  }
  $page_editor->setAction('create_posting.php')
              ->setPosting($posting);

  echo $page_editor->render($is_edit);
}
require_once('../lib/footer.php');

?>
