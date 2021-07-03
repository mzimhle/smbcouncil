<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMB COUNCIL</title>
{include_php file='administration/includes/css.php'}
{include_php file='administration/includes/javascript.php'}
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	odataTable = $('#dataTable').dataTable({					
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",							
		"bSort": true,
		"bFilter": true,
		"bInfo": false,
		"iDisplayLength": 20,
		"bLengthChange": false							
	});		
	odataTable.fnFilter('');
});
</script>
{/literal}
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
			<li><a href="/administration/calendar/" title="Calendar">Calendar</a></li>
			<li><a href="/administration/calendar/view/" title="View">View</a></li>
			<li>{$calendarData.calendar_name}</li>
			<li>Sent mails</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{$calendarData._calendar_name}</h2>
    <div class="clearer"><!-- --></div>	
    <div id="sidetabs">
        <ul>             
            <li><a href="/administration/calendar/view/details.php?code={$calendarData.calendar_code}" title="Details">Details</a></li>
			<li><a href="/administration/calendar/view/attend.php?code={$calendarData.calendar_code}" title="attendees">attendees</a></li>
			<li class="active"><a href="#" title="Comms">Comms</a></li>
        </ul>
    </div><!--tabs-->	
	<div class="detail_box">
	<h4>Mailer Results</h4><br />
	<form id="detailsForm" name="detailsForm" action="#" method="post">
		<table id="dataTable" border="0" cellspacing="0" cellpadding="5" width="100%">
			<thead>
			<tr>
			<th>Sent</th>
			<th>Name</th>
			<th>Email</th>
			<th>Cellphone</th>
			<th>Result</th>
			<th>Mailer</th>
			</tr>
		   </thead>
		   <tbody> 
		  {foreach from=$commData item=item}
		  <tr>
			<td align="left">{$item._comm_added|date_format}</td>
			<td align="left">{$item.mailinglist_name} {$item.mailinglist_surname}</td>
			<td align="left">{$item.mailinglist_email}</td>
			<td align="left">{$item.mailinglist_cellphone}</td>
			<td align="left" class="{if $item._comm_sent eq '1'}success{else}error{/if}">{$item._comm_output}</td>
			<td align="left"><a href="/mailers/view/{$item._comm_code}" target="_blank">View Mailer</a></td>
		  </tr>
		  {/foreach}     
		  </tbody>
		</table>
	</form>
	</div>
	<div class="clearer"><!-- --></div>	
    </div><!--inner-->
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
</body>
</html>
