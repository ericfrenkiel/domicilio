<?php

$require_signed = true;
require_once('../lib/header.php');
require_once('../lib/Posting.php');
require_once('../lib/craig.php');

$id = (int)idx($_GET, 'id', 0);
$posting = Posting::fromDB($id);
if ($posting && $posting->getOwnerId() === $uid) {
  require_once('../lib/PostingRenderer.php');
  $renderer = new PostingRenderer($posting);
  echo $renderer->render();
?>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.Canvas.setAutoResize();
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
<hr />
<div>
<div id="div_sel_1" style="display:none;">
<label for="sel_1" style="width:150px">World place</label>
<select name="sel_1" id="sel_1" style="width:500px"></select>
</div>
<div id="div_sel_2" style="display:none;">
<label for="sel_2" style="width:150px">Metro Area</label>
<select name="sel_2" id="sel_2" style="width:500px"></select>
</div>
<div id="div_sel_3" style="display:none;">
<label for="sel_3" style="width:150px">Region</label>
<select name="sel_3" id="sel_3" style="width:500px"></select>
</div>
</div>

<script>
<?php
  echo "var posting_id = {$id};";
?>
function fillSelect(id, options) {
  var count = 0;
  for (var obj in options) {
    if (obj == '/') {
      continue;
    }
    $('#sel_' + id).append(
      '<option>' + options[obj] + '</option>'
    );
    $('#sel_' + id + ' option:last-child').val(obj);
    ++ count;
  }
  if (count) {
    $('#div_sel_' + id).css('display', '');
    $('#sel_' + id).change(function() {
      var url = $('option:selected', '#sel_' + id).val();
      if (id == 1) {
        url += '/H/apa';
      }
      requestSelect(id + 1, url);
    }).change();
  }
}

function drawForm(data) {
  $('#div_form').html(data);
  $('#div_form').css('display', '');
}

function requestSelect(id, url) {
  for (var i = id; i <= 3; ++ i) {
    $('#sel_' + i).unbind();
    $('#sel_' + i).empty();
    $('#div_sel_' + i).css('display', 'none');
  }
  $('#div_form').css('display', 'none');
  $.post("craig_ajax.php", {
      url: url,
      posting_id: posting_id
      }, function(data) {
    var obj = $.parseJSON(data);
    if (obj.success) {
      if (obj.form) {
        drawForm(obj.data);
      } else {
        fillSelect(id, obj.data);
      }
    } else if (obj.error) {
      alert(obj.error);
    } else {
      alert('WTF???');
    }
  });
}
requestSelect(1, '/');
</script>
<hr>
<div id="div_form" class="div_form" style="display:none;">
</div>
<?
  include_css('craigform.css?' . mt_rand());
} else { //Posting owner is different failed
  echo "You can't post this posting to craigslist";
}
require_once('../lib/footer.php');

?>
