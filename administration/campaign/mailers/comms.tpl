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
			<li><a href="/administration/campaign/" title="Campaign">Campaign</a></li>
			<li><a href="/administration/campaign/mailers/" title="Jobs">Mailers</a></li>
			<li>{$campaignData._campaign_name}</li>
			<li>Sent mails</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{$campaignData._campaign_name}</h2>
    <div class="clearer"><!-- --></div>	
    <div id="sidetabs">
        <ul >             
            <li><a href="/administration/campaign/mailers/details.php?code={$campaignData._campaign_code}" title="Details">Details</a></li>
			<li><a href="/administration/campaign/mailers/mail.php?code={$campaignData._campaign_code}" title="Mail">Mail</a></li>
			<li class="active"><a href="#" title="Details">Comms</a></li>
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
			<th>Views</th>
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
			<td align="left">{$item._tracker}</td>
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
