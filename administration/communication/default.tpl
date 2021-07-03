<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sportal</title>
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
			<li><a href="/administration/communication/" title="Communication">Communication</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Communication</h2><br /><br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th>Mail</th>
						<th>Added</th>
						<th>Person</th>
						<th>Email</th>
						<th>Output</th>						
					</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$commData item=item}
			  <tr>
				<td align="left"><a class="{if $item._comm_sent eq '1'}success{else}error{/if}" href="/administration/communication/details.php?code={$item._comm_code}">{$item._comm_code}</a></td>	
				<td>{$item._comm_added}</td>
				<td align="left"><a href="/administration/participants/details.php?code={$item.participant_code}" target="_blank">{$item.participant_name} {$item.participant_surname}</a></td>
				<td align="left">{$item._comm_name}</td>
				<td align="left">{$item._comm_output}</td>						
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
<!-- End Main Container -->
</body>
</html>
