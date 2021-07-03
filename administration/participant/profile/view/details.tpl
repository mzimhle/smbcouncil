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
			<li><a href="/administration/participant/profile/" title="Profiles">Profiles</a></li>
			<li><a href="/administration/participant/profile/view/" title="Members">View</a></li>
			<li>{if isset($profileData)}Edit Profile{else}Add a Profile{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner"> 
    <h2>{if isset($profileData)}Edit Profile{else}Add a Profile{/if}</h2>
    <div id="sidetabs">
        <ul> 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($profileData)}/administration/participant/profile/view/page.php?code={$profileData.profile_code}{else}#{/if}" title="Page">Page</a></li>
			<li><a href="{if isset($profileData)}/administration/participant/profile/view/role.php?code={$profileData.profile_code}{else}#{/if}" title="Roles">Roles</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/participant/profile/view/details.php{if isset($profileData)}?code={$profileData.profile_code}{/if}" method="post" enctype="multipart/form-data">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="profile_name" id="profile_name" value="{$profileData.profile_name}" size="30" />
				{if isset($errorArray.profile_name)}<br /><span class="error">{$errorArray.profile_name}</span>{else}<br />Members name(s){/if}
			</td>	
			<td>
				<h4 class="error">Surname:</h4><br />
				<input type="text" name="profile_surname" id="profile_surname" value="{$profileData.profile_surname}" size="30" />
				{if isset($errorArray.profile_surname)}<br /><span class="error">{$errorArray.profile_surname}</span>{else}<br />Members surname{/if}
			</td>	
			<td>
				<h4 class="error">Area code:</h4>
				<input type="text" name="areapost_name" id="areapost_name" value="{if $profileData.areapost_code neq ''}{$profileData.areapost_suburb}, {$profileData.areapost_city}, {$profileData.areapost_box}{/if}" size="30" />
				<input type="hidden" name="areapost_code" id="areapost_code" value="{$profileData.areapost_code}" />
				{if isset($errorArray.areapost_code)}<br /><span class="error">{$errorArray.areapost_code}</span>{else}<br />In which area/suburb does the member live in{/if}
			</td>				
          </tr>
          <tr>
			<td>
				<h4 class="error">Email:</h4><br />
				<input type="text" name="profile_email" id="profile_email" value="{$profileData.profile_email}" size="30" />
				{if isset($errorArray.profile_email)}<br /><span class="error">{$errorArray.profile_email}</span>{/if}
			</td>	
			<td>
				<h4 class="error">Cellphone:</h4><br />
				<input type="text" name="profile_cellphone" id="profile_cellphone" value="{$profileData.profile_cellphone}" size="30" />
				{if isset($errorArray.profile_cellphone)}<br /><span class="error">{$errorArray.profile_cellphone}</span>{else}<br />e.g 0735896547{/if}
			</td>	
			<td>
				<h4>Telephone:</h4><br />
				<input type="text" name="profile_telephone" id="profile_telephone" value="{$profileData.profile_telephone}" size="30" />
				{if isset($errorArray.profile_telephone)}<br /><span class="error">{$errorArray.profile_telephone}</span>{else}<br />e.g 0215896547{/if}
			</td>				
          </tr>
          <tr>
			<td>
				<h4>ID Number:</h4><br />
				<input type="text" name="profile_idnumber" id="profile_idnumber" value="{$profileData.profile_idnumber}" size="30" />
				{if isset($errorArray.profile_idnumber)}<br /><span class="error">{$errorArray.profile_idnumber}</span>{else}<br />South African ID number e.g 9009155845088{/if}
			</td>	
			<td>
				<h4>Gender:</h4><br />
				<select id="profile_gender" name="profile_gender">
					<option value=""></option>
					<option value="male" {if $profileData.profile_gender eq 'male'}selected{/if}>Male</option>
					<option value="female" {if $profileData.profile_gender eq 'female'}selected{/if}>Female</option>
				</select>
				{if isset($errorArray.profile_gender)}<br /><span class="error">{$errorArray.profile_gender}</span>{else}<br />e.g 0735896547{/if}
			</td>	
			<td>
				<h4>Date of Birth:</h4><br />
				<input type="text" name="profile_dateofbirth" id="profile_dateofbirth" value="{$profileData.profile_dateofbirth}" size="10"/>
				{if isset($errorArray.profile_dateofbirth)}<br /><span class="error">{$errorArray.profile_dateofbirth}</span>{/if}
			</td>				
          </tr>
          <tr>
			<td valign="top" colspan="2">
				<h4>Short Description:</h4> Description of the profile as to what he does currently before, interests and hobbies.<br /><br />
				<textarea id="profile_description" name="profile_description" cols="60" rows="3">{$profileData.profile_description}</textarea>
				{if isset($errorArray.profile_description)}<br /><br /><span class="error">{$errorArray.profile_description}</span>{/if}
			</td>
			<td valign="top">
				<h4>Position:</h4> <br />
				<input type="text" name="profile_position" id="profile_position" value="{$profileData.profile_position}" size="30"/>
				{if isset($errorArray.profile_position)}<br /><span class="error">{$errorArray.profile_position}</span>{else}<br />Organization's position{/if}		
			</td>
          </tr>
          <tr>
			<td valign="top">
				<h4 {if isset($errorArray.profile_image)}class="error"{/if} >User Image:</h4> Images to upload: gif, png, jpg and jpeg<br /><br />
				<input type="file" id="profile_image" name="profile_image" />
				{if isset($errorArray.profile_image)}<br /><br /><span class="error">{$errorArray.profile_image}</span>{/if}
			</td>
			<td valign="top" colspan="2">
				{if !isset($profileData)} 
					<img src="/images/avatar.jpg" />
				{else}
					{if $profileData.profile_image_path eq ''}
						<img src="/images/avatar.jpg" />
					{else}
						<img src="{$profileData.profile_image_path}tmb_{$profileData.profile_image_name}{$profileData.profile_image_ext}" />
					{/if}
				{/if}
			</td>
          </tr>
          <tr>
			<td colspan="3">
				<h4>Personal Website:</h4><br />
				<input type="text" name="profile_social_website" id="profile_social_website" value="{$profileData.profile_social_website}" size="60" />
			</td>						
          </tr>		 
          <tr>
			<td colspan="3">
				<h4>Twitter Profile Link:</h4><br />
				<input type="text" name="profile_social_twitter" id="profile_social_twitter" value="{$profileData.profile_social_twitter}" size="60" />
			</td>						
          </tr>		
          <tr>
			<td colspan="3">
				<h4>Facebook Profile Link:</h4><br />
				<input type="text" name="profile_social_facebook" id="profile_social_facebook" value="{$profileData.profile_social_facebook}" size="60" />
			</td>						
          </tr>	
          <tr>
			<td colspan="3">
				<h4>Google+ Profile Link:</h4><br />
				<input type="text" name="profile_social_googleplus" id="profile_social_googleplus" value="{$profileData.profile_social_googleplus}" size="60" />
			</td>						
          </tr>
          <tr>
			<td colspan="3">
				<h4>LinkedIn Profile Link:</h4><br />
				<input type="text" name="profile_social_linkedin" id="profile_social_linkedin" value="{$profileData.profile_social_linkedin}" size="60" />
			</td>						
          </tr>	
          <tr>
			<td colspan="3">
				<h4>Who'sWho Profile Link:</h4><br />
				<input type="text" name="profile_social_whoswho" id="profile_social_whoswho" value="{$profileData.profile_social_whoswho}" size="60" />
			</td>						
          </tr>			  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/administration/participant/profile/view/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
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
	
	$( "#profile_dateofbirth" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
	
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
