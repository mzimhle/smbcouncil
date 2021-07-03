<?php /* Smarty version 2.6.20, created on 2015-07-21 20:47:24
         compiled from mailers/participant_register.html */ ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMB Council</title>
<?php echo '
<style type="text/css">
/* Client-specific Styles */
#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */
/* Reset Styles */
body{margin:0; padding:0; background-color: #343434; font-size: 20px;}
img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
table td{border-collapse:collapse;}
#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
a{color: #4c4c4c;text-decoration: none;}
</style>
'; ?>

</head>
<body style="margin: 0; padding: 0; text-align: center; background-image: url(http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/images/back.jpg)">
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/images/back.jpg">
	<tr>
    	<td align="center">
            <table width="600" border="0" cellpadding="0" cellspacing="0" style="box-shadow: 1px 2px 4px #222222;">
                <tr>
                    <td align="left" valign="top" style="font-size: 12px; font-family: Helvetica, Verdana, Arial, sans-serif;" bgcolor="#FFFFFF">
                    	<img src="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/images/head.gif" width="600" height="103" border="0" alt="SMB Council" style="display: block">
                    </td>
				</tr>
                <tr>
                    <td align="left" valign="top">
                    	<table width="600" border="0" align="left" cellpadding="25" cellspacing="0">
                        	<tr>
                            	<td valign="top" style="font-size: 12px; font-family: Helvetica, Verdana, Arial, sans-serif;" bgcolor="#FFFFFF">
                                	<span style="font-family: 'Century Gothic', Helvetica, Verdana, Arial, sans-serif; font-size: 24px; font-weight: bold; color: #0d1959;">Good day <?php echo $this->_tpl_vars['mailinglist']['mailinglist_name']; ?>
</span><br />
									<?php if ($this->_tpl_vars['mailinglist']['participantlogin_type'] == 'EMAIL'): ?>
										<p>Thank you for registering on our website. Before you login, please click on the link below to verify your email address. Without verification you will not be able to access your SMB Council member account.</p>
										<p>
										<a style="text-decoration: none; font-family: Helvetica, Verdana, Arial, sans-serif; font-size: 12px; font-weight: bold; color: #0d1959;" href="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/activate/member/<?php echo $this->_tpl_vars['mailinglist']['mailinglist_hashcode']; ?>
">Click here to confirm</a>
										<br /><br />If the above link does not open, then copy and paste the url below into your browser address bar:
										<p style="font-family: Helvetica, Verdana, Arial, sans-serif; font-size: 12px; font-weight: bold; color: #0d1959;">http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/activate/member/<?php echo $this->_tpl_vars['mailinglist']['mailinglist_hashcode']; ?>
</p>
										Below are your login details. This will be activated after you verify your email address. You can use your login details to access your account when the website launches. Launch details are on the website: <a href="http://www.smbcouncil.org">www.smbcouncil.org</a>. 
										</p>										
										<table width="100%" style="font-size: 12px; font-family: Helvetica, Verdana, Arial, sans-serif;" bgcolor="#FFFFFF">
											<tr><td>Username</td><td>:</td><td><?php echo $this->_tpl_vars['mailinglist']['participantlogin_username']; ?>
</td></tr>
											<tr><td>Password</td><td>:</td><td><?php echo $this->_tpl_vars['mailinglist']['participantlogin_password']; ?>
</td></tr>
										</table>
										<br /><br />										
									<?php else: ?>
										<p>Thank you for logging in using <?php echo $this->_tpl_vars['mailinglist']['participantlogin_type']; ?>
. You will simply login to your <?php echo $this->_tpl_vars['mailinglist']['participantlogin_type']; ?>
 account, then you will automatically be logged in on our website.</p>
										<p>
									<?php endif; ?>
									<p><a style="text-decoration: none; font-family: Helvetica, Verdana, Arial, sans-serif; font-size: 12px; font-weight: bold; color: #0d1959;" href="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/view/<?php echo $this->_tpl_vars['tracking']; ?>
">If you cannot see this email properly, please click here to view it on a browser</a></p>
                                    <p style="text-decoration: none; font-family: Helvetica, Verdana, Arial, sans-serif; font-size: 12px; font-weight: bold; color: #0d1959;">
									<br />
									Regards<br />
									The SMB Council Team
									</p>
                                </td>
                            </tr>
                        </table>
					</td>
				</tr>
                <tr>
					<td>
                        <table width="600" border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                                <td bgcolor="#FFFFFF" valign="bottom" height="15"><img src="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/images/footer.gif" width="600" height="126" border="0" alt="" style="display: block"></td>
                            </tr>
                        </table>
                    </td>
				</tr>
            </table>
            <table width="600" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="400" height="50" align="left" valign="bottom" style="font-size: 12px; font-family: Helvetica, Verdana, Arial, sans-serif; color: #FFFFFF;">
                        <a href="http://www.smbcouncil.org" target="_blank" style="color: #FFFFFF;">www.smbcouncil.org</a><br />Suite 0303, Vogue House | Cape Town
                    </td>
                    <td width="200" valign="bottom" align="right" style="font-size: 12px; font-family: Helvetica, Verdana, Arial, sans-serif;">
                        <a href="https://www.facebook.com/smbcouncil" target="_blank"><img src="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/images/fb_icon.png" width="27" height="29" border="0" alt="Facebook" /></a>&nbsp;&nbsp;
                        <a href="https://twitter.com/smbcouncil" target="_blank"><img src="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/images/tw_icon.png" width="27" height="29" border="0" alt="Twitter" /></a><!--&nbsp;&nbsp;
                        <a href="http://linkd.in/1bMcRiA" target="_blank"><img src="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/images/in_icon.png" width="27" height="29" border="0" alt="LinkedIn" /></a>&nbsp;&nbsp;
                        <a href="https://plus.google.com/b/100325846078534250868/100325846078534250868/posts" target="_blank"><img src="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/images/g_icon.png" width="27" height="29" border="0" alt="Google +" /></a>-->
                    </td>
                </tr>
            </table>
            <br /><br />
		</td>
	</tr>
</table>
<img src="http://<?php echo $this->_tpl_vars['domain']; ?>
/mailers/tracking/<?php echo $this->_tpl_vars['tracking']; ?>
" height="0" alt="" width="0" />
</body>
</html>