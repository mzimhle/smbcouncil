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
			<li><a href="/administration/participant/subscribe/" title="Subscribers">Subscribers</a></li>
			<li>{if isset($mailinglistData)}Edit Subscriber{else}Add a Subscriber{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner"> 
    <h2>{if isset($mailinglistData)}Edit Subscriber{else}Add a Subscriber{/if}</h2>
    <div id="sidetabs">
        <ul> 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/participant/subscribe/details.php{if isset($mailinglistData)}?code={$mailinglistData.mailinglist_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="mailinglist_name" id="mailinglist_name" value="{$mailinglistData.mailinglist_name}" size="30" />
				{if isset($errorArray.mailinglist_name)}<br /><span class="error">{$errorArray.mailinglist_name}</span>{else}<br />Subscribers name(s){/if}
			</td>		
			<td>
				<h4 class="error">Area code:</h4>
				<input type="text" name="areapost_name" id="areapost_name" value="{if $mailinglistData.areapost_code neq ''}{$mailinglistData.areapost_suburb}, {$mailinglistData.areapost_city}, {$mailinglistData.areapost_box}{/if}" size="30" />
				<input type="hidden" name="areapost_code" id="areapost_code" value="{$mailinglistData.areapost_code}" />
				{if isset($errorArray.areapost_code)}<br /><span class="error">{$errorArray.areapost_code}</span>{else}<br />In which area/suburb does the member live in{/if}
			</td>				
          </tr>
          <tr>
			<td>
				<h4 class="error">Email:</h4><br />
				<input type="text" name="mailinglist_email" id="mailinglist_email" value="{$mailinglistData.mailinglist_email}" size="30" />
				{if isset($errorArray.mailinglist_email)}<br /><span class="error">{$errorArray.mailinglist_email}</span>{/if}
			</td>	
			<td>
				<h4>Cellphone:</h4><br />
				<input type="text" name="mailinglist_cellphone" id="mailinglist_cellphone" value="{$mailinglistData.mailinglist_cellphone}" size="30" />
				{if isset($errorArray.mailinglist_cellphone)}<br /><span class="error">{$errorArray.mailinglist_cellphone}</span>{else}<br />e.g 0735896547{/if}
			</td>				
          </tr>  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">

function submitForm() {
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
	
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/area.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == '') {
				$('#areapost_name').html('');
				$('#areapost_code').val('');					
			} else {
				$('#areapost_name').html('<b>' + ui.item.value + '</b>');
				$('#areapost_code').val(ui.item.id);	
			}
			$('#areapost_name').val('');										
		}
	});
	
});

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
