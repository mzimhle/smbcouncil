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
			<li><a href="/administration/participant/profile/category/" title="Category">Categories</a></li>
			<li>{if isset($profilecategoryData)}Edit Category{else}Add a Category{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner"> 
      <h2>{if isset($profilecategoryData)}Edit Category{else}Add a Category{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/participant/profile/category/details.php{if isset($profilecategoryData)}?code={$profilecategoryData.profilecategory_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">	  
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="profilecategory_name" id="profilecategory_name" value="{$profilecategoryData.profilecategory_name}" size="60" />
				{if isset($errorArray.profilecategory_name)}<br /><span class="error">{$errorArray.profilecategory_name}</span>{/if}
			</td>
          </tr>
          <tr>
			<td>
				<h4 class="error">Description:</h4><br />
				<textarea name="profilecategory_description" id="profilecategory_description" rows="3" cols="60">{$profilecategoryData.profilecategory_description}</textarea>
				{if isset($errorArray.profilecategory_description)}<br /><span class="error">{$errorArray.profilecategory_description}</span>{/if}
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
	document.forms.detailsForm.submit();					 
}

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
