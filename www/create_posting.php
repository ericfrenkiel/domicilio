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
  $page_editor->setAction('create_posting.php');
	$page_editor->setCost('1000');
	$page_editor->setTitle('10$ Super awesome place to live');
	$page_editor->setAddress('1601 S California Ave');
	$page_editor->setCity('Palo Alto');
	$page_editor->setState('CA');
	$page_editor->setInfo('Wassup, just take it');
}
?>
<?php include_css("editor.css");?>
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

<!--BEGIN NEW CODE -->
<form id="posting_form" method="post" action="<?php echo $page_editor->getAction() ?>">

  <input type="hidden" name="posting_id" value="<?php echo htmlspecialchars($page_editor->getId()) ?>">

  <div class="edit">
  <div class="left_edit">Title:</div>
  <div class="right_edit">
    <input type="text" name="posting_title" value="<?php echo htmlspecialchars($page_editor->getTitle()) ?> " />
    </div>
  </div>

  <div class="edit">
  <div class="left_edit">Address:</div>
  <div class="right_edit">
    <input type="text" name="posting_address" value="<?php echo  htmlspecialchars($page_editor->getAddress())?>" />
    </div>
  </div>

  <div class="edit">
  <div class="left_edit">City:</div>
  <div class="right_edit">
    <input type="text" name="posting_city"
     value="<?php echo  htmlspecialchars($page_editor->getCity()) ?>" />
    </div>
  </div>

  <div class="edit">
  <div class="left_edit">State:</div>
  <div class="right_edit">
    <select name="posting_state" size="1">
<?php  require_once('../lib/constants/states.php');
  global $state_list;
  $cur_state = $page_editor->getState();
  foreach ($state_list as $short => $long): ?>
    <option value="<?php echo  $short ?>" <?php if ($short === $cur_state) echo "selected='selected'"; ?> > <?php echo $long ?> </option>
  <?php endforeach; ?>
  </select></div>
  </div>

  <div class="edit">
  <div class="left_edit">Cost ($/per month):</div>
  <div class="right_edit">
    <input type="text" name="posting_cost" value="<?php echo  htmlspecialchars($page_editor->getCost()) ?>" />
    </div>
  </div>

  <div class="edit">
  <div class="left_edit">Info:</div>
  <div class="right_edit">
    <textarea type="text" name="posting_info" rows="10"> <?php echo  htmlspecialchars($page_editor->getInfo()) ?> </textarea>
    </div>
  </div>

  <div class="edit">
  <div class="center_edit">
  <input type="submit" name="Create"  value="Create new posting" />
  <input type="submit" name="Create"value="Preview" onclick="preview();return false;" />
  </div>
  </div>

  <input type="hidden" name="posting_submitted"
      value="1" />

  </form>
  <div id="preview" style="display:none;width:720px;"></div>
  <script>
    function preview() {
     jQuery.facebox.loading();
      $.post("preview.php", $("#posting_form").serialize(),
     function(data){ $("#preview").html(data);
     jQuery.facebox({ div: '#preview' });
    });
    };
  </script>
<!-- END NEW CODE -->

	<h2><a href="#">Amenities</a></h2>
  <div>Amenity editor</div>
	<h2><a href="#">Photos</a></h2>
	<div>photos go here</div>
</div>


<?php require_once('../lib/footer.php');?>