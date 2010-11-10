<?php
  global $start_time;
  $end_time = microtime(true) - $start_time;
  $buffer = ob_get_contents( );
  ob_end_clean( );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="title" content="Domicilio" />
<meta name="description" content="Domicilio is a social layer for real estate." />
	<title>Domicilio: Social Real Estate</title>
	<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="/js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="/js/jquery.labelify.js"></script>
	<script type="text/javascript" src="/js/jquery.infinitecarousel2.min.js"></script>
	<script src="/js/jquery.fbox.js" type="text/javascript"></script>
	<script type='text/javascript' src='/js/jquery.autocomplete.js'></script>

	<link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="/css/jquery.css" />
	<link href="/css/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="/css/jquery.autosuggest.css" />	

<?php
  global $head_included;
  $head_included = array_unique($head_included);
  foreach ($head_included as $val) {
    echo $val;
  }
?>
</head>
        <body>
                <div id="container">
                  <div id="header">
                        <div id="navigation">
                          <ol>
                                <li><a href="/create_posting.php"><img src="/images/craigslist.png"><span style="float:right;margin-left:3px;">Post on Craigslist</span></a></li>
                          </ol>
                        </div>
                        <a href="/"><img src="/images/logo.png" alt="Domicilio" border="0"
/></a>
                </div>
                <div id="subnav">
                </div>
                  <div id="main">
<?php
  echo $buffer;
?>
 </div>
                  <div id="footer">
                          <div id="footersearch" style="float:left;"><input type="text"
value="Find a Property" style="float: right; margin-right: 11px; margin-top: 3px;"></div>
                </div>
        </body>
</html>

