<!DOCTYPE html PUBLIC "-/W3C/DTD XHTML 1.0 Transitional/EN" "http:/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http:/www.w3.org/1999/xhtml">
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
			<li><a href="/administration/calendar/" title="">Calendar</a></li>
			<li><a href="/administration/calendar/view/" title="">View</a></li>
			<li>Calendar</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>Calendar Event</h2>
    <div id="sidetabs">
        <ul> 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($calendarData)}/administration/calendar/view/attend.php?code={$calendarData.calendar_code}{/if}" title="attendees">attendees</a></li>
			<li><a href="{if isset($calendarData)}/administration/calendar/view/comms.php?code={$calendarData.calendar_code}{/if}" title="attendees">comms</a></li>
        </ul>
    </div><!--tabs-->	  
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/calendar/view/details.php{if isset($calendarData)}?code={$calendarData.calendar_code}{/if}" method="post">
        <table width="850" border="0" align="center" cellpadding="0" cellspacing="0" class="form" style="float: left;">
          <tr>
            <td colspan="2">
				<h4 class="error">Name</h4><br />
				<input type="text" name="calendar_name" id="calendar_name" value="{$calendarData.calendar_name}" size="80"><br />
				{if isset($errorArray.calendar_name)}<span class="error">{$errorArray.calendar_name}</span>{else}Event Title{/if}
			</td>				
          </tr>    
          <tr>
            <td colspan="2">
				<h4 class="error">Subject</h4><br />
				<input type="text" name="calendar_subject" id="calendar_subject" value="{$calendarData.calendar_subject}" size="80"><br />
				{if isset($errorArray.calendar_subject)}<span class="error">{$errorArray.calendar_subject}</span>{else}Email Subject{/if}
			</td>				
          </tr> 		  
		   <tr>
            <td colspan="2">
				<h4 class="error">Type</h4><br />
				<select id="calendartype_code" name="calendartype_code">
					<option value=""> ---- </option>
					{html_options options=$calendartypeData selected=$calendarData.calendartype_code}
				</select><br />
				{if isset($errorArray.calendartype_code)}<span class="error">{$errorArray.calendartype_code}</span>{else}Type of meeting / event this is{/if}	
			</td>				
          </tr>
			<tr>
            <td colspan="2">
				<h4 class="error">Location</h4><br />
				<input type="text" name="calendar_address" id="calendar_address" value="{$calendarData.calendar_address}" size="80"><br />
				{if isset($errorArray.calendar_address)}<span class="error">{$errorArray.calendar_address}</span>{else}Location / Address of the event{/if}			
			</td>				
			</tr>
          <tr>
            <td>
				<h4 class="error">Start Date:</h4><br />
				<input type="text" name="calendar_startdate" id="calendar_startdate" value="{$calendarData.calendar_startdate|default:$startdate|date_format:'%Y-%m-%d %H:%M'}" size="20" readonly /><br />
				{if isset($errorArray.calendar_startdate)}<span class="error">{$errorArray.calendar_startdate}</span>{else}Start date and time of the meeting / event{/if}	
			</td>	
			<td>
				<h4 class="error">End Date:</h4><br />
				<input type="text" name="calendar_enddate" id="calendar_enddate" value="{$calendarData.calendar_enddate|default:$enddate|date_format:'%Y-%m-%d %H:%M'}" size="20" readonly /><br />
				{if isset($errorArray.calendar_enddate)}<span class="error">{$errorArray.calendar_enddate}</span>{else}End date and time of the meeting / event{/if}
			</td>				
          </tr>		
          <tr>
            <td colspan="2">
				<h4 class="error">Description:</h4><br />
				<textarea id="calendar_description" name="calendar_description" rows="50" cols="100">{$calendarData.calendar_description}</textarea>
				{if isset($errorArray.calendar_description)}<span class="error">{$errorArray.calendar_description}</span>{else}Details of the meeting / event.{/if}
			</td>			
          </tr>			  
        </table>
		<div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>		
      </form>
	</div>
	<div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript">
$(document).ready(function() {	

			
	new nicEditor({
		iconsPath	: '/library/javascript/nicedit/nicEditorIcons.gif',
		buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript', 'upload'],
		uploadURI : '/library/javascript/nicedit/nicUpload.php',
	}).panelInstance('calendar_description');
	
	$("#calendar_startdate").datetimepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	$( "#calendar_enddate" ).datetimepicker({
		dateFormat: 'yy-mm-dd'
	});
	
});
				
function submitForm() {
	nicEditors.findEditor('calendar_description').saveContent();
	document.forms.detailsForm.submit();					 
}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
