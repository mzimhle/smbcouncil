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
			<li><a href="/administration/participant/" title="Members">Members</a></li>
			<li><a href="/administration/participant/view/" title="Members">View</a></li>
			<li>{$participantData.participant_name} {$participantData.participant_surname}</li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner"> 
    <h2>{$participantData.participant_name} {$participantData.participant_surname}</h2>
    <div id="sidetabs">
        <ul> 
            <li><a href="/administration/participant/view/details.php?code={$participantData.participant_code}" title="Details">Details</a></li>
			<li class="active"><a href="" title="LOGIN">LOGIN</a></li>
			<li><a href="/administration/participant/view/mail.php?code={$participantData.participant_code}" title="Mailers">Mailers</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
	<h4>Login Types for the user:</h4><br>
	<form method="post" action="#" name="itemaddForm" id="itemaddForm">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="innertable">
		<thead>
		<tr>
			<th>Added</th>
			<th>Image</th>
			<th>Fullname</th>
			<th>Location</th>			
			<th>Email</th>
			<th>Password</th>			
			<th>type</th>
			<th>Account ID</th>
			<th>Status</th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$participantloginData item=item}
		  <tr>
			<td>{$item.participantlogin_added|date_format}</td>
			<td align="left"><img src="{if $item.participantlogin_image eq ''}/images/avatar.jpg{else}{$item.participantlogin_image}{/if}" width="60" /></td>
			<td align="left">{$item.participantlogin_name} {$item.participantlogin_surname}</td>
			<td align="left">{$item.participantlogin_location}</td>			
			<td align="left">{$item.participantlogin_username}</td>
			<td align="left">{$item.participantlogin_password}</td>
			<td align="left">{$item.participantlogin_type}</td>
			<td align="left">{$item.participantlogin_id}</td>
			<td align="left">{if $item.participantlogin_active eq '1'}<span style="color: green;">Active</span>{else}<span style="color: red;">Not Active</span>{/if}</td>
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
