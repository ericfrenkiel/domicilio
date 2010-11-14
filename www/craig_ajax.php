<?php
  require_once('../lib/core.php');
  require_once('../lib/db.php');
  require_once('../lib/craig.php');

  $url = unsafe_post('url');
  $posting_id = unsafe_post('posting_id');
  if (!$url) {
    die(json_answer(array("error" => "Empty url")));
  }
  $result = craig_curl($url);
  if ($result) {
    die(json_answer(parse_craig($result, $posting_id)));
  } else {
    slog($result);
    die(json_answer(array("error" => "Empty return")));
  }


?>