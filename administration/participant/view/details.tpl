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
			<li><a href="/administration/participant/" title="Members">Members</a></li>
			<li><a href="/administration/participant/view/" title="Members">View</a></li>
			<li>{if isset($participantData)}{$participantData.participant_name} {$participantData.participant_surname}{else}Add a Member{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner"> 
    <h2>{if isset($participantData)}{$participantData.participant_name} {$participantData.participant_surname}{else}Add a Member{/if}</h2>
    <div id="sidetabs">
        <ul> 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($participantData)}/administration/participant/view/login.php?code={$participantData.participant_code}{/if}" title="Login">Login</a></li>
			<li><a href="{if isset($participantData)}/administration/participant/view/mail.php?code={$participantData.participant_code}{/if}" title="Mailers">Mailers</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/participant/view/details.php{if isset($participantData)}?code={$participantData.participant_code}{/if}" method="post" enctype="multipart/form-data">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="participant_name" id="participant_name" value="{$participantData.participant_name}" size="30" />
				{if isset($errorArray.participant_name)}<br /><span class="error">{$errorArray.participant_name}</span>{else}<br />Members name(s){/if}
			</td>	
			<td>
				<h4 class="error">Surname:</h4><br />
				<input type="text" name="participant_surname" id="participant_surname" value="{$participantData.participant_surname}" size="30" />
				{if isset($errorArray.participant_surname)}<br /><span class="error">{$errorArray.participant_surname}</span>{else}<br />Members surname{/if}
			</td>	
			<td>
				<h4 class="error">Area code:</h4>
				<input type="text" name="areapost_name" id="areapost_name" value="{if $participantData.areapost_code neq ''}{$participantData.areapost_suburb}, {$participantData.areapost_city}, {$participantData.areapost_box}{/if}" size="30" />
				<input type="hidden" name="areapost_code" id="areapost_code" value="{$participantData.areapost_code}" />
				{if isset($errorArray.areapost_code)}<br /><span class="error">{$errorArray.areapost_code}</span>{else}<br />In which area/suburb does the member live in{/if}
			</td>				
          </tr>
          <tr>
			<td>
				<h4>Email:</h4><br />
				<input type="text" name="participant_email" id="participant_email" value="{$participantData.participant_email}" size="30" />
				{if isset($errorArray.participant_email)}<br /><span class="error">{$errorArray.participant_email}</span>{/if}
			</td>	
			<td>
				<h4>Cellphone:</h4><br />
				<input type="text" name="participant_cellphone" id="participant_cellphone" value="{$participantData.participant_cellphone}" size="30" />
				{if isset($errorArray.participant_cellphone)}<br /><span class="error">{$errorArray.participant_cellphone}</span>{else}<br />e.g 0735896547{/if}
			</td>	
			<td>
				<h4>Telephone:</h4><br />
				<input type="text" name="participant_telephone" id="participant_telephone" value="{$participantData.participant_telephone}" size="30" />
				{if isset($errorArray.participant_telephone)}<br /><span class="error">{$errorArray.participant_telephone}</span>{else}<br />e.g 0215896547{/if}
			</td>				
          </tr>
          <tr>
			<td>
				<h4>ID Number:</h4><br />
				<input type="text" name="participant_idnumber" id="participant_idnumber" value="{$participantData.participant_idnumber}" size="30" />
				{if isset($errorArray.participant_idnumber)}<br /><span class="error">{$errorArray.participant_idnumber}</span>{else}<br />South African ID number e.g 9009155845088{/if}
			</td>	
			<td>
				<h4 class="error">Gender:</h4><br />
				<select id="participant_gender" name="participant_gender">
					<option value=""></option>
					<option value="male" {if $participantData.participant_gender eq 'male'}selected{/if}>Male</option>
					<option value="female" {if $participantData.participant_gender eq 'female'}selected{/if}>Female</option>
				</select>
				{if isset($errorArray.participant_cellphone)}<br /><span class="error">{$errorArray.participant_cellphone}</span>{else}<br />e.g 0735896547{/if}
			</td>	
			<td>
				<h4 class="error">Date of Birth:</h4><br />
				<input type="text" name="participant_dateofbirth" id="participant_dateofbirth" value="{$participantData.participant_dateofbirth}" size="10"/>
				{if isset($errorArray.participant_dateofbirth)}<br /><span class="error">{$errorArray.participant_dateofbirth}</span>{else}<br />Member's date of birth{/if}
			</td>				
          </tr>
          <tr>
			<td valign="top">
				<h4 {if isset($errorArray.profile_image)}class="error"{/if} >User Image:</h4> Images to upload: gif, png, jpg and jpeg<br /><br />
				<input type="file" id="profile_image" name="profile_image" />
				{if isset($errorArray.profile_image)}<br /><br /><span class="error">{$errorArray.profile_image}</span>{/if}
			</td>
			<td valign="top" colspan="2">
				{if !isset($participantData)} 
					<img src="/images/avatar.jpg" />
				{else}
					{if $participantData.participant_image_path eq ''}
						<img src="/images/avatar.jpg" />
					{else}
						<img src="{$participantData.participant_image_path}tmb_{$participantData.participant_image_name}{$participantData.participant_image_ext}" />
					{/if}
				{/if}
			</td>
          </tr>			  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/administration/participant/view/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">

function submitForm() {
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
	
	$( "#participant_dateofbirth" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
	
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/area.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == '') {
				$('#areapost_name').html('');
				$('#areapost_code').val('');					
			} else {
				$('#areapost_name').html('<b>' + ui.item.value + '</b>');
				$('#areapost_code').val(ui.item.id);	
			}
			$('#areapost_name').val('');										
		}
	});
	
});

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
