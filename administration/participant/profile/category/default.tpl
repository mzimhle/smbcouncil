<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMB COUNCIL</title>
{include_php file='administration/includes/css.php'}
{include_php file='administration/includes/javascript.php'}
<script type="text/javascript" language="javascript" src="default.js"></script>
</head>

<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    {include_php file='administration/includes/header.php'}
	<div id="breadcrumb">
        <ul>
            <li><a href="/administration/" title="Home">Home</a></li>
			<li><a href="/administration/participant/" title="Members">Members</a></li>
			<li><a href="/administration/participant/profile/" title="Profiles">Profiles</a></li>
			<li><a href="/administration/participant/profile/category/" title="Categories">Categories</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Categories</h2>
	<a href="/administration/participant/profile/category/details.php" title="Click to Add a new Category" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Category</span></a> <br /> 
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
					<th>Added</th>
					<th>Name</th>
					<th>Description</th>
					<th></th>
				</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$profilecategoryData item=item}
			  <tr>
				<td align="left">{$item.profilecategory_added|date_format}</td>
				<td align="left"><a href="/administration/participant/profile/category/details.php?code={$item.profilecategory_code}">{$item.profilecategory_name}</a></td>
				<td align="left">{$item.profilecategory_description}</td>
				<td align="right"><button onclick="deleteitem('{$item.profilecategory_code}')">Delete</button></td>
			  </tr>
			  {/foreach}     
			  </tbody>
			</table>
		 </div>
		 <!-- End Content Table -->	
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">
function deleteitem(id) {					
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "delete_code="+id,
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
