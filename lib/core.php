<?php

function id($a) {
}

function idx($array, $key, $default = null) {
  }
  return $array[$key];
}

function edx($array, $key, $default = null) {
  if (empty($array) || empty($array[$key])) {
    return $default;
  }
  return $array[$key];
}

?>