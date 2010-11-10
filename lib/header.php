<?php
global $start_time;
$start_time = microtime(true);
require_once("../lib/core.php");
require_once("../lib/db.php");
require_once("../lib/fb.php");
require_once("../lib/head_control.php");
if ($require_signed) {
  init_fb();
}
ob_start( );
?>
