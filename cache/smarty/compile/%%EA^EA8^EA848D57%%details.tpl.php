<?php /* Smarty version 2.6.20, created on 2014-12-31 13:39:14
         compiled from administration/campaign/mailers/details.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMB COUNCIL</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/administration/" title="Home">Home</a></li>
			<li><a href="/administration/campaign/" title="Jobs">Campaign</a></li>
			<li><a href="/administration/campaign/mailers/" title="Jobs">Mailers</a></li>
			<li><?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>Edit Mailer<?php else: ?>Add a Mailer<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>Edit Mailer<?php else: ?>Add a Mailer<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>/administration/campaign/mailers/mail.php?code=<?php echo $this->_tpl_vars['campaignData']['_campaign_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Mail">Mail</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>/administration/campaign/mailers/comms.php?code=<?php echo $this->_tpl_vars['campaignData']['_campaign_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Comms">Comms</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/campaign/mailers/details.php<?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>?code=<?php echo $this->_tpl_vars['campaignData']['_campaign_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name / Title:</h4><br />
				<input type="text" name="_campaign_name" id="_campaign_name" value="<?php echo $this->_tpl_vars['campaignData']['_campaign_name']; ?>
" size="60" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['_campaign_name'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_campaign_name']; ?>
</span><?php endif; ?>
			</td>					
          </tr>
          <tr>
			<td>
				<h4 class="error">Subject:</h4><br />
				<input type="text" name="_campaign_subject" id="_campaign_subject" value="<?php echo $this->_tpl_vars['campaignData']['_campaign_subject']; ?>
" size="60" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['_campaign_subject'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_campaign_subject']; ?>
</span><?php endif; ?>
			</td>					
          </tr>
          <tr>
			<td>
				<h4>Note:</h4><br />
				To add peoples names on the mailer please add the following variables on the mailer: <br /><br />
					<table>					
					<tr><td>[fullname]</td><td>=</td><td>Participant Name and Surname</td></tr>
					<tr><td>[name]</td><td>=</td><td>Participant Name only</td></tr>
					<tr><td>[surname]</td><td>=</td><td>Participant Surname only</td></tr>
					<tr><td>[cellphone]</td><td>=</td><td>Participant cellphone</td></tr>
					<tr><td>[email]</td><td>=</td><td>Participant email</td></tr>
					<tr><td>[area]</td><td>=</td><td>Participant area</td></tr>
					</table>
			</td>
          </tr>	
          <tr>
			<td colspan="2">
				<h4 class="error">Content:</h4><br />
				<textarea id="_campaign_content" name="_campaign_content" cols="100" rows="50"><?php echo $this->_tpl_vars['campaignData']['_campaign_content']; ?>
</textarea>
				<?php if (isset ( $this->_tpl_vars['errorArray']['_campaign_content'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_campaign_content']; ?>
</span><?php endif; ?>
			</td>
          </tr>		  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
	<br /><br />	
    </div><!--inner-->
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<?php echo '
<script type="text/javascript" language="javascript">
$(document).ready(function() {			
	new nicEditor({
		iconsPath	: \'/library/javascript/nicedit/nicEditorIcons.gif\',
		uploadURI : \'/library/javascript/nicedit/nicUpload.php\',
	}).panelInstance(\'_campaign_content\');				
});

function submitForm() {
	nicEditors.findEditor(\'_campaign_content\').saveContent();
	document.forms.detailsForm.submit();					 
}

</script>
'; ?>

<!-- End Main Container -->
</body>
</html>