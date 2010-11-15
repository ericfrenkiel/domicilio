<?php

function id($a) {  return $a;
}

function idx($array, $key, $default = null) {  if (empty($array) || !isset($array[$key])) {    return $default;
  }
  return $array[$key];
}

function edx($array, $key, $default = null) {
  if (empty($array) || empty($array[$key])) {
    return $default;
  }
  return $array[$key];
}

function unsafe_post($s) {  $val = idx($_POST, $s, '');
  return get_magic_quotes_gpc()
    ? stripslashes($val)
    : $val;
}

function get($s, $defualt = null) {  return idx($_GET, $s, $defualt);
}
function json_answer($a) {  return json_encode($a);
}

function easy_curl($url, $params = null) {  if (!$ch) {
    $ch = curl_init($url);
  }

  if ($params === null) {
    $params = array();
  }

  $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) "
         . "Gecko/20030624 Netscape/7.1 (ax)";

  $opts = array(
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_HEADER         => 0,
    CURLOPT_TIMEOUT        => 60,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT      => $agent,
  );

  if ($params) {
    $opts[CURLOPT_POSTFIELDS] = $params;
    $opts[CURLOPT_POST] = true;
  }

  // disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
  // for 2 seconds if the server does not support this header.
  if (isset($opts[CURLOPT_HTTPHEADER])) {
    $existing_headers = $opts[CURLOPT_HTTPHEADER];
    $existing_headers[] = 'Expect:';
    $opts[CURLOPT_HTTPHEADER] = $existing_headers;
  } else {
    $opts[CURLOPT_HTTPHEADER] = array('Expect:');
  }

  curl_setopt_array($ch, $opts);
  $result = curl_exec($ch);
  if ($result === false) {
    elog('Curl error #' . curl_errno($ch) . ': ' . curl_error($ch));
    curl_close($ch);
    return false;
  }
  curl_close($ch);
  return $result;
}

function slog( $s )
{
  $tm = date( "d.m.Y H:i", time( ) );
  $m = $tm.": ".$_SERVER['PHP_SELF'].":\r\n    " . $s . "\r\n";

  $f = fopen("../logs/slog.txt", "a");
  fwrite( $f, $m );
  fclose( $f );
}

function elog( $s )
{
  $tm = date( "d.m.Y H:i", time( ) );
  $m = $tm.": ".$_SERVER['PHP_SELF'].":\r\n    " . $s . "\r\n";

  $f = fopen("../logs/elog.txt", "a");
  fwrite( $f, $m );
  fclose( $f );
}


?>