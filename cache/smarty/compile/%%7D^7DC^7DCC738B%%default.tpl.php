<?php /* Smarty version 2.6.20, created on 2015-07-21 20:47:24
         compiled from registration/complete/default.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SMB Council</title>
<meta name="keywords" content="small business, medium business, entrepreneurs, finance">
<meta name="description" content="The Small Medium Business council member registration (<?php echo $this->_tpl_vars['participantloginData']['participant_name']; ?>
 <?php echo $this->_tpl_vars['participantloginData']['participant_surname']; ?>
) using <?php echo $this->_tpl_vars['participantloginData']['participantlogin_type']; ?>
">          
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="21 days">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta property="og:title" content="SMB Council"> 
<meta property="og:image" content="http://www.smbcouncil.org/images/logo.png"> 
<meta property="og:url" content="http://www.smbcouncil.org">
<meta property="og:site_name" content="SMB Council">
<meta property="og:type" content="website">
<meta property="og:description" content="The Small Medium Business council member registration (<?php echo $this->_tpl_vars['participantloginData']['participant_name']; ?>
 <?php echo $this->_tpl_vars['participantloginData']['participant_surname']; ?>
) using <?php echo $this->_tpl_vars['participantloginData']['participantlogin_type']; ?>
">
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

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
                    <h1>Pre-Registration Completed</h1> <!--<h1>Thank you for Register</h1> /// after submiting the form-->
                    <p>You have joined the informative team that will help you grow as an individual as well as a business.</p>
                    <!--<p>You will be the first in line to recieve information and resources that will help your business grow.</p> /// after submiting the form-->
					<?php if ($this->_tpl_vars['participantloginData']['participantlogin_type'] == 'EMAIL'): ?>
					<p>Thank you, <em><?php echo $this->_tpl_vars['participantloginData']['participant_name']; ?>
 <?php echo $this->_tpl_vars['participantloginData']['participant_surname']; ?>
</em> for registering with the SMB Council website.</p>
					<p>We have sent you an email to confirm your registration. The email will contain a link that will verify your email address and activate your account.</p>
					<?php else: ?>
					<p>Thank you, <em><?php echo $this->_tpl_vars['participantloginData']['participant_name']; ?>
 <?php echo $this->_tpl_vars['participantloginData']['participant_surname']; ?>
</em> for registering with the SMB Council website using <?php echo $this->_tpl_vars['participantloginData']['participantlogin_type']; ?>
.</p>
					<?php endif; ?>
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