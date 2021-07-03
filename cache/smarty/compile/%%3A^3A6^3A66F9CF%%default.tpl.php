<?php /* Smarty version 2.6.20, created on 2015-07-26 22:28:32
         compiled from default.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SMB Council</title>
<meta name="keywords" content="small business, medium business, entrepreneurs, finance">
<meta name="description" content="The Small Medium Business council is an influential voice and advocate for entrepreneurs and small business owners in South Africa">          
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="21 days">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta property="og:title" content="SMB Council"> 
<meta property="og:image" content="http://www.smbcouncil.org/images/logo.png"> 
<meta property="og:url" content="http://www.smbcouncil.org">
<meta property="og:site_name" content="SMB Council">
<meta property="og:type" content="website">
<meta property="og:description" content="The Small Medium Business council is an influential voice and advocate for entrepreneurs and small business owners in South Africa">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php echo '
<div id="fb-root"></div>
<script type="text/javascript">

(function(d){
   var js, id = \'facebook-jssdk\'; if (d.getElementById(id)) {return;}
   js = d.createElement(\'script\'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   d.getElementsByTagName(\'head\')[0].appendChild(js);
}(document));
 
window.fbAsyncInit = function() {
  FB.init({
	appId      : \''; ?>
<?php echo $this->_tpl_vars['APP_ID']; ?>
<?php echo '\',
	status     : true, 
	cookie     : true,
	xfbml      : true,
	oauth      : true,
  });
	FB.Event.subscribe(\'auth.login\', function () {
		  window.location = window.location.href;
	  });
};
 
function fb_login(){
	FB.login(function(response) {

		if (response.authResponse) {
		
			access_token = response.authResponse.accessToken; //get access token
			user_id = response.authResponse.userID; //get FB UID

			FB.api(\'/me?fileds=id,first_name,last_name,gender,link,email\', function(response) {
			
				$.ajax({
					type: "GET",
					url: "default.php",
					data: {
						ajax: \'fb\',
						id: response.id,
						email: response.email,
						first_name: response.first_name,
						last_name: response.last_name,
						gender: response.gender,
						link: response.link
					},
					dataType: "json",
					success: function(data){						
							
						if(data.result == 1) {
							window.location = \'/registration/complete/\';
						} else {							
							alert(data.message);
						}						
					}
				});
			});

		} else {

		}
	}, {
		scope: \'email,user_location\'
	});
}
</script>
'; ?>

</head>
<body>
<section class="container">
    <div class="shieldbox">
        <div class="space cf">
            <div class="leftbox">
                <div class="logobox"><a href="/"><img src="/images/logo.png" width="176" height="200" alt="SMB Council" /></a></div>
                <div class="leftwrap">
                    <p>The Small Medium Business council (SMB | council) is an influential voice and advocate for entrepreneurs and small business owners.</p>
                    <p>We focus on securing policies, resources, and educational initiatives that encourage entrepreneurship and small business growth.</p>
                </div>
            </div>
            <div class="rightbox">
                <div class="rightwrap">
                    <h1>Pre-Register Now</h1>
                    <p>Be the first to get the latest educational information and resources that will help your small business grow.</p>
                    <form action="/" method="post" id="signupform" class="regform">
                        <label>Name</label>
                        <input type="text" name="participant_name" id="participant_name" class="shadow" />
						<?php if (isset ( $this->_tpl_vars['errorArray']['participant_name'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['participant_name']; ?>
</em><?php endif; ?>
                        <label>Email</label>
                        <input type="email" name="participant_email" id="participant_email"  class="shadow" />
						<?php if (isset ( $this->_tpl_vars['errorArray']['participant_email'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['participant_email']; ?>
</em><?php endif; ?>
                        <input type="submit" name="submit" value="Register" id="submit" class="shadow" />
                        <div class="floattxt"><label>OR</label></div>
                        <div class="soclog">
                            <a href="#" onclick="fb_login();"><img src="/images/fblog_btn.gif" width="29" height="31" alt="Facebook" class="shadow" /></a> &nbsp;&nbsp;
                            <a href="/registration/includes/linkedin/"><img src="/images/inlog_btn.gif" width="29" height="31" alt="LinkedIn" class="shadow" /></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <p class="counttxt cf">Launching in</p>
        <div class="countbox cf" id="edate"></div>
    </div>
	 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/founders.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</section>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</body>
</html>