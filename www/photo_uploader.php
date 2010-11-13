<?php
$require_signed = true;
require_once('../lib/header.php');
?>
  Selected photos:
  <div id='selected_images' class="preview_div"></div>
  Your photos:
  <div id='your_images' class="preview_div"></div>
  <hr />
  <div id="fb-root"></div>
  <p>To upload a file, click on the button below. Drag-and-drop is supported in FF, Chrome.</p>
  <p>Progress-bar is supported in FF3.6+, Chrome6+, Safari4+</p>

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
          $('#img_input_' + photo.id).remove();
        }
      }
      photo.in = where;
      if (photo.in == 1) {
        $('#hidden_imgs').append(
          '<input type="hidden" id="img_input_' + photo.id + '" '
            + 'name="img_input_"' + photo.id + '" value="'
            + photo.id + '" />'
        );
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
<?
require_once('../lib/footer.php');

?>
