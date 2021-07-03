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
			<li><a href="/administration/campaign/sms/" title="SMS">SMS</a></li>
			<li>{if isset($campaignData)}Edit Mailer{else}Add a Mailer{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($campaignData)}Edit Mailer{else}Add a Mailer{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($campaignData)}/administration/campaign/sms/sms.php?code={$campaignData._campaign_code}{else}#{/if}" title="SMS">SMS</a></li>
			<li><a href="{if isset($campaignData)}/administration/campaign/sms/comms.php?code={$campaignData._campaign_code}{else}#{/if}" title="Comms">Comms</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/campaign/sms/details.php{if isset($campaignData)}?code={$campaignData._campaign_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name / Title:</h4><br />
				<input type="text" name="_campaign_name" id="_campaign_name" value="{$campaignData._campaign_name}" size="60" />
				{if isset($errorArray._campaign_name)}<br /><span class="error">{$errorArray._campaign_name}</span>{/if}
			</td>					
          </tr>
          <tr>
			<td colspan="2">
				<h4 class="error">Message:</h4><br />
				<textarea id="_campaign_message" name="_campaign_message" cols="60" rows="3">{$campaignData._campaign_message}</textarea>
				<br /><em id="charcount" class="error">0 characters entered.</em>
				{if isset($errorArray._campaign_message)}<br /><span class="error">{$errorArray._campaign_message}</span>{/if}
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
	$("#_campaign_message").keyup(function () {
		var i = $("#_campaign_message").val().length;
		$("#charcount").html(i+' characters entered.');
		if (i > 160) {
			$('#charcount').removeClass('success');
			$('#charcount').addClass('error');
		} else if(i == 0) {
			$('#charcount').removeClass('success');
			$('#charcount').addClass('error');
		} else {
			$('#charcount').removeClass('error');
			$('#charcount').addClass('success');
		} 
	});
});

function submitForm() {
	document.forms.detailsForm.submit();					 
}

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
