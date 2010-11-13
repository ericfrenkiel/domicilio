<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>php-sdk</title>
<style>
body {
font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
}
h1 a {
text-decoration: none;
color: #3b5998;
}
h1 a:hover {
text-decoration: underline;
}
</style>
</head>
<body>
<!--
We use the JS SDK to provide a richer user experience. For more info,
look here: http://github.com/facebook/connect-js
-->
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
FB.init({
appId : '111665148898653',
status : true, // check login status
cookie : true, // enable cookies to allow the server to access the session
xfbml : true // parse XFBML
});

// whenever the user logs in, we refresh the page
FB.Event.subscribe('auth.login', function() {
window.location.reload();
});
};

(function() {
var e = document.createElement('script');
e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
e.async = true;
document.getElementById('fb-root').appendChild(e);
}());
</script>


<h1><a href="example.php">php-sdk</a></h1>

<?php if ($me): ?>
<a href="<?php echo $logoutUrl; ?>">
<img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
</a>
<?php else: ?>
<div>
Using JavaScript &amp; XFBML: <fb:login-button></fb:login-button>
</div>
<div>
Without using JavaScript &amp; XFBML:
<a href="<?php echo $loginUrl; ?>">
<img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
</a>
</div>
<?php endif ?>

<h3>Session</h3>
<?php if ($me): ?>
<pre><?php print_r($session); ?></pre>

<h3>You</h3>
<img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
<?php echo $me['name']; ?>

<h3>Your User Object</h3>
<pre><?php print_r($me); ?></pre>
<?php else: ?>
<strong><em>You are not Connected.</em></strong>
<?php endif ?>

<h3>Naitik</h3>
<img src="https://graph.facebook.com/naitik/picture">
<?php echo $naitik['name']; ?>
</body>
</html>