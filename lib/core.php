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

function slog( $s )
{
  $tm = date( "d.m.Y H:i", time( ) );
  $m = $tm.": ".$_SERVER['PHP_SELF'].":\r\n    " . $s . "\r\n";

  $f = fopen("../slog.txt", "a");
  fwrite( $f, $m );
  fclose( $f );
}

function elog( $s )
{
  $tm = date( "d.m.Y H:i", time( ) );
  $m = $tm.": ".$_SERVER['PHP_SELF'].":\r\n    " . $s . "\r\n";

  $f = fopen("../elog.txt", "a");
  fwrite( $f, $m );
  fclose( $f );
}


?>