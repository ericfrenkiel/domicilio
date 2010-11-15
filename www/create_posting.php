<?php
$require_signed = true;
require_once('../lib/header.php');
require_once('../lib/Posting.php');
require_once('../lib/constants/states.php');
include_css('fileuploader.css');
include_js('fileuploader.js');
if (isset($_GET['uber_shity_secret_test'])) {
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
  global $uid;
  $posting->setOwnerId($uid);
  if ($posting->getId()) {
    $posting->updateDB();
  } else {
    $posting->addToDB();
  }
  header("Location: post_on_craigslist.php?id=" . $posting->getId());
  return;
} else {
  $id = (int)idx($_GET, 'id', 0);
  $posting = Posting::fromDB($id);
  $is_edit = true;
  if ($posting === false) {
    $posting = id(new Posting())
                 ->setCost('')
                 ->setTitle('')
                 ->setAddress('')
                 ->setCity('')
                 ->setState('CA')
                 ->setInfo('');
    $is_edit = false;
  }
}
?>
<?php include_css("editor.css");?>
<script type="text/javascript">
  $(function() {
    $("#accordion").accordion({
      active: 0, collapsible: false, autoHeight: true
    });
  });
  </script>
<?php
  if ($is_edit) {
    echo "<h1>Edit Your Posting</h1>";
  } else {
    echo "<h1>Create Your Posting</h1>";
  }
?>
<br />
<br />
<form id="posting_form" method="post"
	action="create_posting.php"><input
	type="hidden" name="posting_id"
	value="<?php echo htmlspecialchars($posting->getId()) ?>">
<div id="accordion">
<h2><a href="#">Property Details</a></h2>
<div>
<!--BEGIN NEW CODE -->

<div class="edit">
<div class="left_edit">Title:</div>
<div class="right_edit"><input type="text" name="posting_title"
	value="<?php echo htmlspecialchars($posting->getTitle()) ?> " />
</div>
</div>

<div class="edit">
<div class="left_edit">Cost ($/per month):</div>
<div class="right_edit"><input type="text" name="posting_cost"
	value="<?php echo htmlspecialchars($posting->getCost()); ?>" />
</div>
</div>

<div class="edit">
<div class="left_edit">Info:</div>
<div class="right_edit"><textarea type="text" name="posting_info"
	rows="10"> <?php echo  htmlspecialchars($posting->getInfo()) ?> </textarea>
</div>
</div>

 <!-- END NEW CODE -->
 </div>
<h2><a href="#">Address</a></h2>
<div><div class="edit">
<div class="left_edit">Address:</div>
<div class="right_edit"><input type="text" name="posting_address"
  value="<?php echo  htmlspecialchars($posting->getAddress())?>" />
</div>
</div>

<div class="edit">
<div class="left_edit">City:</div>
<div class="right_edit"><input type="text" name="posting_city"
  value="<?php echo  htmlspecialchars($posting->getCity()) ?>" />
</div>
</div>

<div class="edit">
<div class="left_edit">State:</div>
<div class="right_edit"><select name="posting_state" size="1">
<?php
  global $state_list;
  $cur_state = $posting->getState();
  foreach ($state_list as $short => $long): ?>
  <option value="<?php echo  $short ?>"
    <?php if ($short === $cur_state) echo "selected='selected'"; ?>>
  <?php echo $long ?></option>
  <?php endforeach; ?>
</select></div>
</div></div>
<h2><a href="#">Amenities</a></h2>
<div>Amenity editor</div>
<h2><a href="#">Photos</a></h2>
<div>photos go here
  Selected photos:
  <div id='selected_images' class="preview_div"></div>
  Your photos:
  <div id='your_images' class="preview_div"></div>
  <hr />
  <div id="fb-root"></div>
  <p>To upload a file, click on the button below. Drag-and-drop is supported in FF, Chrome.</p>

  <div id="file-uploader-demo1">
    <noscript>
      <p>Please enable JavaScript to use file uploader.</p>
      <!-- or put a simple form for upload here -->
    </noscript>
  </div>
  <div id="hidden_imgs"></div>

  <script>
    var photos = {};
    function addPhoto(id, where) {
      FB.api('/' + id, function(photo) {
        if (photo && photo.id) {
          photos[photo.id] = photo;
          putPhoto(photo, where);
        }
      });
    }
    function initPhotos() {
      var photoIds = [ <?php
  global $uid;
  if ($uid) {
    $res = db_query("select fb_photo_id from photos where "
      . "owner_id = '" . db_escape($uid) . "';");
    $ids = array();
    while ($arr = db_fetch($res)) {
      $ids[] = "'" . $arr[0] . "'";
    }
    echo implode(', ', $ids);
  }
?>];
      for(var id in photoIds) {
        addPhoto(photoIds[id], 0);
      }
    }

    function selectPreviewSrc(photo) {
      var i;
      for (i = photo.images.length - 1; i >= 0; -- i) {
        if (photo.images[i].height >= 100) {
          return photo.images[i].source;
        }
      }
      return '';
    }

    function clickOnImg(id) {
      var photo = photos[id];
      putPhoto(photo, 1 - photo.in);
    }

    function drawPhoto(photo, where, visible) {
      var element_id;
      if (where == 1) {
        element_id = '#selected_images';
      } else if (where == 0) {
        element_id = '#your_images';
      }
      if (visible) {
        $(element_id).append(
          '<img class="photoPreview" id="img_' + photo.id + '" src="'
            + selectPreviewSrc(photo)
            + '" onclick="clickOnImg(\'' + photo.id + '\');"/>'
        );
      } else {
        $('#img_' + photo.id).remove();
      }
    }

    function putPhoto(photo, where) {
      if (photo.in != 'undefined') {
        drawPhoto(photo, photo.in, false);
        if (photo.in == 1) {
          $('#imgs_input_' + photo.id).remove();
        }
      }
      photo.in = where;
      if (photo.in == 1) {
        $('#hidden_imgs').append(
          '<div id="imgs_input_' + photo.id + '">'
            + '<input type="hidden" name="img_input_id_' + photo.id + '" value="'
            + photo.id + '" id="img_input_id_' + photo.id + '" />'
            + '<input type="hidden" name="img_input_src_' + photo.id + '"'
            + ' id="img_input_src_' + photo.id + '" />'
            + '<input type="hidden" name="img_input_preview_' + photo.id + '"'
            + ' id="img_input_preview_' + photo.id + '" />'
         + '</div>'
        );
        $('#img_input_src_' + photo.id).val(photo.images[0].source);
        $('#img_input_preview_' + photo.id).val(selectPreviewSrc(photo));
      }
      drawPhoto(photo, photo.in, true);
    }

    function facebookInitialized() {
      initPhotos();
    }

    window.fbAsyncInit = function() {
      FB.Event.subscribe('auth.login', facebookInitialized);
      FB.init({appId: '<?php echo THEDOM_APP_ID; ?>',
               session: <?php global $session; echo json_encode($session); ?>,
               status: true,
               cookie: true,
               xfbml: false});
    };
    (function() {
      var e = document.createElement('script');
      e.async = true;
      e.src = document.location.protocol +
        '//connect.facebook.net/en_US/all.js';
      document.getElementById('fb-root').appendChild(e);
    }());
        $(document).ready(function(){
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader-demo1'),
                action: 'test_upload.php',
                debug: true,
                onComplete: function(id, fileName, res) {
                  if (res.success) {
                    addPhoto(res.id, 1);
                  }
                }
            });
        });
    </script>
    <script>
    $(function() {
        //$("input:submit").button().css('background-color','#fea913');
      });

    </script>
</div>
</div>
<div id="preview" style="display: none; width: 720px;"></div>
<div class="edit">
  <div class="center_edit">
    <input class="v3_button v3_fixed_width" type="submit" name="Create" value="Continue" />
    <input class="v3_button v3_fixed_width" type="submit" name="Create" value="Preview" onclick="preview();return false;" /></div>
</div>

<input type="hidden" name="posting_submitted" value="1" /></form>
<script>
    function preview() {
     jQuery.facebox.loading();
      $.post("preview.php", $("#posting_form").serialize(),
     function(data){ $("#preview").html(data);
     jQuery.facebox({ div: '#preview' });
    });
    };
  </script>

<?php require_once('../lib/footer.php');?>
