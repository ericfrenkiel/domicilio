<?php

$require_signed = true;
require_once('../lib/header.php');
require_once('../lib/Posting.php');
require_once('../lib/craig.php');

$id = (int)idx($_GET, 'id', 0);
$posting = Posting::fromDB($id);
if ($posting && $posting->getOwnerId() === $uid) {
  echo "<h1><img src=\"/images/craigslist_logo.png\" style=\"width:50px; height:50px; vertical-align:middle;\">Post " .
   htmlspecialchars($posting->getTitle()) . " on Craigslist</h1><br style=\"clear:both;\"/><br />";
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
<div>
<div id="div_sel_1" style="display:none;">
<label for="sel_1" style="width:150px">World place</label>
<select name="sel_1" id="sel_1" style="width:500px"></select>
</div>
<image id="loader_1" style="display:none;" src="images/js/loading.gif" />
<div id="div_sel_2" style="display:none;">
<label for="sel_2" style="width:150px">Metro Area</label>
<select name="sel_2" id="sel_2" style="width:500px"></select>
</div>
<image id="loader_2" style="display:none;" src="images/js/loading.gif" /
<div id="div_sel_3" style="display:none;">
<label for="sel_3" style="width:150px">Region</label>
<select name="sel_3" id="sel_3" style="width:500px"></select>
</div>
<image id="loader_3" style="display:none;" src="images/js/loading.gif" />
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
    if (count == 0 && id == 1) {
      $('#sel_' + id).append(
        '<option>'  + '</option>'
      );
      $('#sel_' + id + ' option:last-child').val('');
    } else {
      $('#sel_' + id).append(
        '<option>' + options[obj] + '</option>'
      );
      $('#sel_' + id + ' option:last-child').val(obj);
    }
    ++ count;
  }
  if (count) {
    $('#div_sel_' + id).css('display', '');
    $('#sel_' + id).change(function() {
      var url = $('option:selected', '#sel_' + id).val();
      if (url) {
        if (id == 1) {
          url += '/H/apa';
        }
        requestSelect(id + 1, url);
      }
    }).change();
  }
}

function drawForm(data) {
  $('#div_form').html(data);
  $('#div_form').css('display', '');
}

function draw_loading(id) {
  $('#loader_' + id).css('display', '');
}

function hide_loading(id) {
  $('#loader_' + id).css('display', 'none');
}

function requestSelect(id, url) {
  for (var i = id; i <= 3; ++ i) {
    $('#sel_' + i).unbind();
    $('#sel_' + i).empty();
    $('#div_sel_' + i).css('display', 'none');
  }
  $('#div_form').css('display', 'none');
  draw_loading(id);
  $.post("craig_ajax.php", {
      url: url,
      posting_id: posting_id
      }, function(data) {
    var obj = $.parseJSON(data);
    hide_loading(id);
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
<image id="loader_4" style="display:none;" src="images/js/loading.gif" />
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
