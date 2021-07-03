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
            <li><a href="/administration/" title="">Home</a></li>
			<li><a href="/administration/calendar/" title="">Calendar</a></li>
			<li><a href="/administration/calendar/types/" title="">Types</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage calendar types</h2>		
	<a href="/administration/calendar/types/details.php" title="Click to Add a new Item" class="blue_button fr mrg_bot_10"><span style="float:left;">Add a new calendar type</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead> 
					<tr>
						<th>Added</th>
						<th>Name</th>
						<th>Color</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				  {foreach from=$calendartypeData item=item}
				  <tr>
					<td align="left">{$item.calendartype_added|date_format}</td>		
					<td align="left"><a href="/administration/calendar/types/details.php?code={$item.calendartype_code}">{$item.calendartype_name}</a></td>	
					<td align="left">{$item.calendartype_colour}</td>		
					<td align="left"><button onclick="javascript:deleteForm('{$item.calendartype_code}');">delete</button></td>
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
{literal}
<script type="text/javascript">
function deleteForm(id) {
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({
				type: "GET",
				url: "default.php",
				data: "code_delete="+id,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Deleted');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});								
	}
}					
</script>
{/literal} 
</div>
<!-- End Main Container -->
</body>
</html>
