<?php
global $start_time;
$start_time = microtime(true);
require_once("../lib/core.php");
require_once("../lib/db.php");
require_once("../lib/fb.php");
require_once("../lib/head_control.php");
if ($require_signed) {
  $this_url = THEDOM_APP_URL . $_SERVER['PHP_SELF'];  $facebook = new Facebook(array(
    'appId'  => THEDOM_APP_ID,
    'secret' => THEDOM_APP_SECRET,
    'cookie' => true,
  ));

  $session = $facebook->getSession();

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

      echo "<script>window.top.location='" . addslashes($login_url) .
        "';</script>";
      return;
    }
    else
    {
       echo 'Sorry, you need to be authorized to to do this.';
       return;
    }
  }
} else {
  ob_start( );
}
?>
