<?php
  require_once('../lib/core.php');

function craig_curl($url_add, $params = null) {
  if (strlen($url_add) > 0 && $url_add[0] === '/') {
    $url_add = substr($url_add, 1);
  }
  $url = "https://post.craigslist.org/" . $url_add;
  if (!$ch) {
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
    CURLOPT_REFERER        => 'https://post.craigslist.org/sfo/H/apa/nby/',
  );

  if ($params) {    $opts[CURLOPT_POSTFIELDS] = $params;
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

function parse_craig_options($txt) {
  $txt = str_replace(array('\n', "\n", "\r", "\t"), array('', "", "", ' '), $txt);
  $c = preg_match_all("/<li><a href=\"(.+?)\">(|.+?)<\/a>/",
             $txt, $a, PREG_SET_ORDER);
  $result = array();
  foreach ($a as &$arr) {
    $href = $arr[1];
    $text = $arr[2];
    $result[$href] = $text;
  }
  return $result;
}

function fill_form($form, $id) {  require_once('../lib/Posting.php');
  require_once('../lib/PostingRenderer.php');
  $posting = Posting::fromDB($id);  $email = 'bigdude@gmail.com';
  $renderer = new PostingRenderer($posting);
  $form = preg_replace(
    array(
      "/<button type=\"button\".+?<br clear=\"all\"><\/div>/",
      "/<div id=\"map\">/",
      "/action=\"/",
      "/<div class=\"highlight\".+?<\/div><br>/",
      "/<div class=\"bchead\".+?<\/div>(.+?)<br>/",
      "/Rent:<\/span>.+?value=\"/", //Rent
      "/Posting Title:<\/span>.+?value=\"/", //Title
      "/<textarea .+?>/", //Html
      "/Your email address/", //Mail 1
      "/Type email address again/", //Mail 1
      "/xstreet0.+?value=\"/", //Street
      "/name=\"city\".+?value=\"/", //City
      "/name=\"region\".+?value=\"/", //State
    ),
    array(
      "",
      "<div class=\"row\">",
      "action=\"https://post.craigslist.org",
      "",
      "$1",
      "\${0}" . htmlspecialchars($posting->getCost()),
      "\${0}" . htmlspecialchars($posting->getTitle()),
      "\${0}" . htmlspecialchars($renderer->render(true)),
      htmlspecialchars($email),
      htmlspecialchars($email),
      "\${0}" . htmlspecialchars($posting->getAddress()),
      "\${0}" . htmlspecialchars($posting->getCity()),
      "\${0}" . htmlspecialchars($posting->getState()),
    ),
    $form);
  return $form;
}

function parse_craig_form($txt, $id) {
  $txt = str_replace(array('\n', "\n", "\r", "\t"), array('', "", "", ' '), $txt);
  $c = preg_match_all("/(<form id=\"postingForm\".+?<\/form>)/",
             $txt, $a, PREG_SET_ORDER);
  $result = array();
  foreach ($a as &$arr) {
    $form = $arr[1];
    return fill_form($form, $id);
  }
  return '';
}

function parse_craig($txt, $id = 0) {
  if (strpos($txt, '"postingForm"') > 0) {
    return array('success' => true,
                 'form' => true,
                 'data' => parse_craig_form($txt, $id));
  } else {
    return array('success' => true,
                 'form' => false,
                 'data' => parse_craig_options($txt));
  }
}

?>