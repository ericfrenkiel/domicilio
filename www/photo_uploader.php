<?php
$require_signed = true;
require_once('../lib/header.php');
?>
  <p>To upload a file, click on the button below. Drag-and-drop is supported in FF, Chrome.</p>
  <p>Progress-bar is supported in FF3.6+, Chrome6+, Safari4+</p>

  <div id="file-uploader-demo1">
    <noscript>
      <p>Please enable JavaScript to use file uploader.</p>
      <!-- or put a simple form for upload here -->
    </noscript>
  </div>

    <script>
        $(document).ready(function(){
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader-demo1'),
                action: 'test_upload.php',
                debug: true,
                onComplete: function(id, fileName, responseJSON) {

                }
            });
        });
    </script>
<?
include_css('fileuploader.css');
include_js('fileuploader.js');
require_once('../lib/footer.php');

?>
