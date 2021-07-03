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
			<li><a href="/administration/participant/subscribe/" title="Subscribers">Subscribers</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Subscribers</h2>
	<a href="/administration/participant/subscribe/details.php" title="Click to Add a new Subscriber" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Subscriber</span></a>  <br /> 
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>				
				<th>Added</th>				
				<th>Full Name</th>
				<th>Cellphone</th>
				<th>Email</th>
				<th>Area</th>
				<th></th>
				<th></th>
				</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$mailinglistData item=item}
			  <tr>
				<td>{$item.mailinglist_added|date_format}</td>				
				<td align="left"><a href="/administration/participant/subscribe/details.php?code={$item.mailinglist_code}">{$item.mailinglist_name} {$item.mailinglist_surname}</a></td>
				<td align="left">{$item.mailinglist_cellphone}</td>
				<td align="left">{$item.mailinglist_email}</td>
				<td align="left">{if $item.areapost_code neq ''}{$item.areapost_suburb}, {$item.areapost_city}, {$item.areapost_box}{else}N/A{/if}</td>
				<td align="left">{if $item.mailinglist_active eq '1'}<span style="color: green;">Active</span>{else}<span style="color: red;">Not Active</span>{/if}</td> 
				<td align="right"><button onclick="deleteitem('{$item.mailinglist_code}')">Delete</button></td>
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
