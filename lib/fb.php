<?php
  require_once('../lib/facebook.php');
  require_once('../lib/core.php');
  require_once('../lib/db.php');

  define( 'THEDOM_APP_URL', "http://apps.facebook.com/nikita_domicilio/" );
  define( 'THEDOM_APP_ID', "111665148898653" );
  define( 'THEDOM_APP_SECRET', "122d40eac2a366b5e8d05b83ba93ce95" );

  function curl_request($url, $params) {
    if (!$ch) {
      $ch = curl_init();
    }
    if (!isset($params['method'])) {      $params['method'] = 'post';
    }
    if (!isset($params['access_token'])) {
      $params['access_token'] = THEDOM_APP_ID . '|' . THEDOM_APP_SECRET;
    }

    $opts = Facebook::$CURL_OPTS;
    $opts[CURLOPT_POSTFIELDS] = $params;
    $opts[CURLOPT_URL] = $url;

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

  function upload_photo($photo, $photo_text = '') {    global $session;
    $res_coded = curl_request('https://graph.facebook.com/me/photos',
      array('message' => $photo_text,
            'source' => '@' . realpath($photo),
            'access_token' => $session['access_token'])
    );
    $res = json_decode($res_coded);
    slog('Uploading photo: ' . $res_coded);
    if ($res->id) {
      global $uid;
      db_query("insert into photos (owner_id, title, fb_photo_id) values ("
        . "'" . db_escape($uid) . "', "
        . "'" . db_escape($photo_text) . "', "
        . "'" . db_escape($res->id) . "');"
      );
    }
    return $res;
  }

  function init_fb() {    $this_url = THEDOM_APP_URL . $_SERVER['PHP_SELF'];
    global $facebook;
    $facebook = new Facebook(array(
      'appId'  => THEDOM_APP_ID,
      'secret' => THEDOM_APP_SECRET,
      'cookie' => true,

    ));

    global $session;
    $session = $facebook->getSession();

    global $me, $uid;
    $me = null;
    // Session based API call.
    if ($session) {
      try {
        $uid = $facebook->getUser();
        $me = $facebook->api('/me');
      } catch (FacebookApiException $e) {
        error_log($e);
      }
    }

    // login or logout url will be needed depending on current user state.
    if (!$me) {
      if (!isset($_GET['cancel']))
      {
        $login_url = $facebook->getLoginUrl(array(
          'next' => $this_url,
          'cancel_url' => $this_url . "?cancel"));

        die("<script>window.top.location='" . addslashes($login_url) .
          "';</script>");
      }
      else
      {
         die('Sorry, you need to be authorized to to do this.');
      }
    }

  }
?>