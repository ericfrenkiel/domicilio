<?php
require_once('../lib/header.php');
require_once('../lib/Posting.php');
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
  $posting->setOwnerId(123);
  $posting->addToDB();
  header("Location: view.php?id=" . $posting->getId());
  return;
} else {
  require_once('../lib/PostingEditor.php');
  $page_editor = new PostingEditor();
  $page_editor->setAction('create_posting.php')
              ->setPosting(id(new Posting())
                             ->setCost('1000')
                             ->setTitle('10$ Super awesome place to live')
                             ->setAddress('1601 S California Ave')
                             ->setCity('Palo Alto')
                             ->setState('CA')
                             ->setInfo('Wassup, just take it'));


}
?>
<script type="text/javascript">
  $(function() {
    $("#accordion").accordion({
      active: false, collapsible: true, autoHeight: false
    });
  });
  </script>
<h1>Create Your Posting</h1>
<br/><br />
<div id="accordion">
	<h2><a href="#">Property Details</a></h2>
	<?php echo $page_editor->render();?>
	<h2><a href="#">Amenities</a></h2>
  <div>Amenity editor</div>
	<h2><a href="#">Photos</a></h2>
	<div>photos go here</div>
</div>


<?php require_once('../lib/footer.php');?>