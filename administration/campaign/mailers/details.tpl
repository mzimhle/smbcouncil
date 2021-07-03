<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMB COUNCIL</title>
{include_php file='administration/includes/css.php'}
{include_php file='administration/includes/javascript.php'}
</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    {include_php file='administration/includes/header.php'}
  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/administration/" title="Home">Home</a></li>
			<li><a href="/administration/campaign/" title="Jobs">Campaign</a></li>
			<li><a href="/administration/campaign/mailers/" title="Jobs">Mailers</a></li>
			<li>{if isset($campaignData)}Edit Mailer{else}Add a Mailer{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($campaignData)}Edit Mailer{else}Add a Mailer{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($campaignData)}/administration/campaign/mailers/mail.php?code={$campaignData._campaign_code}{else}#{/if}" title="Mail">Mail</a></li>
			<li><a href="{if isset($campaignData)}/administration/campaign/mailers/comms.php?code={$campaignData._campaign_code}{else}#{/if}" title="Comms">Comms</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/campaign/mailers/details.php{if isset($campaignData)}?code={$campaignData._campaign_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name / Title:</h4><br />
				<input type="text" name="_campaign_name" id="_campaign_name" value="{$campaignData._campaign_name}" size="60" />
				{if isset($errorArray._campaign_name)}<br /><span class="error">{$errorArray._campaign_name}</span>{/if}
			</td>					
          </tr>
          <tr>
			<td>
				<h4 class="error">Subject:</h4><br />
				<input type="text" name="_campaign_subject" id="_campaign_subject" value="{$campaignData._campaign_subject}" size="60" />
				{if isset($errorArray._campaign_subject)}<br /><span class="error">{$errorArray._campaign_subject}</span>{/if}
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
				<textarea id="_campaign_content" name="_campaign_content" cols="100" rows="50">{$campaignData._campaign_content}</textarea>
				{if isset($errorArray._campaign_content)}<br /><span class="error">{$errorArray._campaign_content}</span>{/if}
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
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function() {			
	new nicEditor({
		iconsPath	: '/library/javascript/nicedit/nicEditorIcons.gif',
		uploadURI : '/library/javascript/nicedit/nicUpload.php',
	}).panelInstance('_campaign_content');				
});

function submitForm() {
	nicEditors.findEditor('_campaign_content').saveContent();
	document.forms.detailsForm.submit();					 
}

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
