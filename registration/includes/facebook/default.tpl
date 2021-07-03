<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

</head>
<body>

{literal}
<div id="fb-root"></div>
<script type="text/javascript">
window.fbAsyncInit = function() {
  FB.init({
	appId      : '{/literal}{$APP_ID}{literal}',
	status     : true, 
	cookie     : true,
	xfbml      : true,
	oauth      : true,
  });
	FB.Event.subscribe('auth.login', function () {
          window.location = window.location.href;
      });
};
(function(d){
   var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   d.getElementsByTagName('head')[0].appendChild(js);
 }(document));
</script>
{/literal}
<h1>Social Networks</h1>
<p>Login using a social network, choose one you are registered with below.</p>
<div class="fb-login-button fr" perms="email,user_location">Login with Facebook</div>
<br>


</body>
</html>