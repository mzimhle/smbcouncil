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
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/administration/calendar/" title="">Calendar</a></li>
			<li><a href="/administration/calendar/types/" title="">Types</a></li>
			<li>{if isset($calendartypeData)}Edit Calendar Type{else}Add a Calendar Type{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($calendartypeData)}Edit Calendar Type{else}Add a Calendar Type{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/calendar/types/details.php{if isset($calendartypeData)}?code={$calendartypeData.calendartype_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
		<tr>
			<td class="left_col{if isset($errorArray.calendartype_name)} error{/if}"><h4>Description:</h4></td>
			<td><input type="text" name="calendartype_name" id="calendartype_name" value="{$calendartypeData.calendartype_name}" size="60"/></td>
		</tr>			
		<tr>
			<td class="left_col{if isset($errorArray.calendartype_colour)} error{/if}"><h4>Colour:</h4></td>
			<td><input type="text" name="calendartype_colour" id="calendartype_colour" value="{$calendartypeData.calendartype_colour}" size="60"/><p>Please make this a one letter word.</td>
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
<script type="text/javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
