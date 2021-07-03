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
    <!-- Start Content recruiter -->
  <div id="content">
    {include_php file='administration/includes/header.php'}
  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/administration/" title="Home">Home</a></li>
			<li><a href="/administration/participant/" title="Members">Members</a></li>
			<li><a href="/administration/participant/view/" title="Members">View</a></li>
			<li>{$participantData.participant_name} {$participantData.participant_surname}</li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner"> 
    <h2>{$participantData.participant_name} {$participantData.participant_surname}</h2>
    <div id="sidetabs">
        <ul> 
            <li><a href="{if isset($participantData)}/administration/participant/view/details.php?code={$participantData.participant_code}{/if}" title="Details">Details</a></li>
			<li><a href="/administration/participant/view/login.php?code={$participantData.participant_code}" title="Login">Login</a></li>
			<li class="active"><a href="" title="Mailers">Mailers</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
	<h4>Mailer Results</h4><br />
	<form id="detailsForm" name="detailsForm" action="#" method="post">
		<table id="dataTable" border="0" cellspacing="0" cellpadding="5" width="100%">
			<thead>
			<tr>
			<th>Date Sent</th>
			<th>Reference</th>
			<th>Name</th>
			<th>Email</th>
			<th>Result</th>
			<th>Mailer</th>
			</tr>
		   </thead>
		   <tbody> 
		  {foreach from=$commData item=item}
		  <tr class="{if $item._comm_sent eq '1'}success{else}error{/if}">
			<td align="left">{$item._comm_added|date_format}</td>
			<td align="left">{$item._comm_reference}</td>
			<td align="left">{$item.mailinglist_name} {$item.mailinglist_surname}</td>
			<td align="left">{$item.mailinglist_email}</td>
			<td align="left">{$item._comm_output}</td>
			<td align="left"><a href="/mailers/view/{$item._comm_code}" target="_blank">View Mailer</a></td>
		  </tr>
		  {/foreach}     
		  </tbody>
		</table>
	</form>
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
<!-- End Main Container -->
</body>
</html>
