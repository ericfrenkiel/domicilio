<html>
<body>

 <div id="fb-root"></div>
 <script src="http://connect.facebook.net/en_US/all.js"></script>
 <script>
   FB.init({
     appId  : '111665148898653',
     status : true, // check login status
     cookie : true, // enable cookies to allow the server to access the session
     xfbml  : true  // parse XFBML
   });
 </script>
</body>

<script>

FB.login(function(response) {
  if (response.session) {
        alert('Success');
  } else {
        alert('Fail');
  }
});

/*
FB.logout(function(response) {
  // user is now logged out
});

*/
</script>

</html>