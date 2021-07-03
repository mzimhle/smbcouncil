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
			<li><a href="/administration/participant/" title="Participant">Participant</a></li>
			<li><a href="/administration/participant/profile/" title="Profile">Profile</a></li>
			<li><a href="/administration/participant/profile/view/" title="View">View</a></li>
			<li>{$profileData.profile_name} {$profileData.profile_surname}</li>
			<li>Profile Page</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>Manage {$profileData.profile_name} {$profileData.profile_surname} Page</h2>
    <div id="sidetabs">
        <ul > 
            <li><a href="/administration/participant/profile/view/details.php?code={$profileData.profile_code}" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Page">Page</a></li>
			<li><a href="/administration/participant/profile/view/role.php?code={$profileData.profile_code}" title="Roles">Roles</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/participant/profile/view/page.php?code={$profileData.profile_code}" method="post"   enctype="multipart/form-data">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">		  	  			   		
          <tr>            
			<td valign="top" colspan="3">
				<h4 {if isset($errorArray.profile_page)}class="error"{/if}>Page</h4><br />
				<textarea name="profile_page" id="profile_page" rows="60" cols="140" maxlength="500">{$profileData.profile_page}</textarea>
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
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">

function submitForm() {
	nicEditors.findEditor('profile_page').saveContent();
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
	new nicEditor({
		iconsPath	: '/library/javascript/nicedit/nicEditorIcons.gif',
		buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript', 'upload'],
		maxHeight 	: '2000',
		uploadURI : '/library/javascript/nicedit/nicUpload.php',
	}).panelInstance('profile_page');
});

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
