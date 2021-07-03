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
			<li><a href="/administration/campaign/" title="Campaign">Campaign</a></li>
			<li><a href="/administration/campaign/sms/" title="Campaign">Mailers</a></li>
			<li>{$campaignData._campaign_name}</li>
			<li>Mail to members</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{$campaignData._campaign_name}</h2>
    <div class="clearer"><!-- --></div>	
    <div id="sidetabs">
        <ul >             
            <li><a href="/administration/campaign/sms/details.php?code={$campaignData._campaign_code}" title="Details">Details</a></li>
			<li class="active"><a href="#" title="SMS">SMS</a></li>
			<li><a href="/administration/campaign/sms/comms.php?code={$campaignData._campaign_code}" title="Details">Comms</a></li>
        </ul>
    </div><!--tabs-->	
	<div class="detail_box">
	<h4>Contacts to sms</h4><br />
	<table width="100%" class="innertable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td>
				<select id="participantcategory_code" name="participantcategory_code">
					<option value=""> --- </option>
					{html_options options=$mailinglistPairs}
				</select>
				<button onclick="getcontacts();return false;">Get Contacts</button>
				{if isset($errorArray.participantcategory_code)}<br /><span class="error">{$errorArray.participantcategory_code}</span>{/if}
			</td>
		</tr>								
		</tbody>						
	</table>	
	<br />
	<form id="detailsForm" name="detailsForm" action="/administration/campaign/sms/sms.php?code={$campaignData._campaign_code}" method="post">
	<table width="100%" class="innertable" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>			
			<th>Name</th>
			<th>Email</th>
			<th>Cellphone</th>
			<th>Area / Town</th>
			<th></th>
		</tr>
		</thead>
		<tbody id="contacts" name="contacts"></tbody>						
	</table>
	<br />
	<button onclick="sendSMS(); return false;">SMS Selected Contacts</button>
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

function sendSMS() {
	document.forms.detailsForm.submit();					 
}

function getcontacts() {
	var category = $('#participantcategory_code').val();
	
	if(category !=  '') {
		if(confirm('Are you sure you want to add this category?')) {
			$.ajax({
				type: "GET",
				url: "sms.php?code={/literal}{$campaignData._campaign_code}{literal}",
				data: "category="+category,
				dataType: "json",
				success: function(output){
					if(output.result == 1) {
						var html = '';
						for(var i = 0; i < output.data.length; i++) {
							var item = output.data[i];
							
							if($('#tr_'+item.mailinglist_code).length) {
								/* Do nothing. */
							} else {
								html += '<tr id="tr_'+item.mailinglist_code+'"><td>';
								html += item.mailinglist_name+'<input type="hidden" id="mailinglist_code[]" name="mailinglist_code[]" value="'+item.mailinglist_code+'" />';
								html += '</td><td>';
								html += item.mailinglist_email;
								html += '</td><td>';
								html += item.mailinglist_cellphone;
								html += '</td><td>';
								html += item.areapost_suburb+', '+item.areapost_city;
								html += '</td><td><button onclick="deleteItem(\''+item.mailinglist_code+'\'); return false;">Delete</button></td></tr>';							
							}
						}
						
						$('#contacts').append(html);
						
					} else {
						alert(output.message);
					}
				}
			});		
		}	
	} else {
		alert('Please select category first.');
	}
	return false;
}

function deleteItem(code) {
	if(confirm('Are you sure you want to delete this item?')) {
			$('#tr_'+code).remove();
	}
	return false;			

}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
