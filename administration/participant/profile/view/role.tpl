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
			<li>Profile roles</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{$profileData.profile_title}</h2>
    <div class="clearer"><!-- --></div>	
    <div id="sidetabs">
        <ul >             
            <li><a href="/administration/participant/profile/view/details.php?code={$profileData.profile_code}" title="Details">Details</a></li>
			<li><a href="/administration/participant/profile/view/page.php?code={$profileData.profile_code}" title="Page">Page</a></li>
			<li class="active"><a href="#" title="Roles">Roles</a></li>
        </ul>
    </div><!--tabs-->	
	<div class="detail_box">
	<h4>Select profile role</h4><br />
	<form id="detailsForm" name="detailsForm" action="/administration/participant/profile/view/role.php?code={$profileData.profile_code}" method="post">
	<table width="100%" class="innertable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td>
				<select id="profilecategory_code" name="profilecategory_code">
					<option value=""> --- </option>
					{html_options options=$profilecategoryPairs}
				</select>
				<button onclick="submitForm();return false;">Add Role</button>
				{if isset($errorArray.profilecategory_code)}<br /><span class="error">{$errorArray.profilecategory_code}</span>{/if}
			</td>
		</tr>								
		</tbody>						
	</table>	
	<br />	
	<table width="100%" class="innertable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>				
				<th>Added</th>
				<th>Role</th>
				<th>Descript</th>
				<th></th>
				</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$profileroleData item=item}
			  <tr>
				<td>{$item.profilerole_added|date_format}</td>
				<td align="left">{$item.profilecategory_name}</td>
				<td align="left">{$item.profilecategory_description}</td>
				<td align="right"><button onclick="deleteitem('{$item.profilerole_code}'); return false;">Delete</button></td>
			  </tr>
			  {/foreach}     
			  </tbody>				
	</table>
	<br />
	</form>
	</div>
	<div class="clearer"><!-- --></div>	

    </div><!--inner-->	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript">	

function submitForm() {
	document.forms.detailsForm.submit();					 
}

function deleteitem(id) {					
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({ 
				type: "GET",
				url: "role.php",
				data: "code={/literal}{$profileData.profile_code}{literal}&delete_code="+id,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Item deleted!');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	
	return false;
	
}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
