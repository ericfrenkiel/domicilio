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