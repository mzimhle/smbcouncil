<?php /* Smarty version 2.6.20, created on 2015-04-08 08:35:54
         compiled from administration/calendar/view/details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'administration/calendar/view/details.tpl', 56, false),array('modifier', 'default', 'administration/calendar/view/details.tpl', 71, false),array('modifier', 'date_format', 'administration/calendar/view/details.tpl', 71, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-/W3C/DTD XHTML 1.0 Transitional/EN" "http:/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http:/www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMB COUNCIL</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

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
			<li><a href="<?php if (isset ( $this->_tpl_vars['calendarData'] )): ?>/administration/calendar/view/attend.php?code=<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
<?php endif; ?>" title="attendees">attendees</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['calendarData'] )): ?>/administration/calendar/view/comms.php?code=<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
<?php endif; ?>" title="attendees">comms</a></li>
        </ul>
    </div><!--tabs-->	  
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/calendar/view/details.php<?php if (isset ( $this->_tpl_vars['calendarData'] )): ?>?code=<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
<?php endif; ?>" method="post">
        <table width="850" border="0" align="center" cellpadding="0" cellspacing="0" class="form" style="float: left;">
          <tr>
            <td colspan="2">
				<h4 class="error">Name</h4><br />
				<input type="text" name="calendar_name" id="calendar_name" value="<?php echo $this->_tpl_vars['calendarData']['calendar_name']; ?>
" size="80"><br />
				<?php if (isset ( $this->_tpl_vars['errorArray']['calendar_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['calendar_name']; ?>
</span><?php else: ?>Event Title<?php endif; ?>
			</td>				
          </tr>    
          <tr>
            <td colspan="2">
				<h4 class="error">Subject</h4><br />
				<input type="text" name="calendar_subject" id="calendar_subject" value="<?php echo $this->_tpl_vars['calendarData']['calendar_subject']; ?>
" size="80"><br />
				<?php if (isset ( $this->_tpl_vars['errorArray']['calendar_subject'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['calendar_subject']; ?>
</span><?php else: ?>Email Subject<?php endif; ?>
			</td>				
          </tr> 		  
		   <tr>
            <td colspan="2">
				<h4 class="error">Type</h4><br />
				<select id="calendartype_code" name="calendartype_code">
					<option value=""> ---- </option>
					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['calendartypeData'],'selected' => $this->_tpl_vars['calendarData']['calendartype_code']), $this);?>

				</select><br />
				<?php if (isset ( $this->_tpl_vars['errorArray']['calendartype_code'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['calendartype_code']; ?>
</span><?php else: ?>Type of meeting / event this is<?php endif; ?>	
			</td>				
          </tr>
			<tr>
            <td colspan="2">
				<h4 class="error">Location</h4><br />
				<input type="text" name="calendar_address" id="calendar_address" value="<?php echo $this->_tpl_vars['calendarData']['calendar_address']; ?>
" size="80"><br />
				<?php if (isset ( $this->_tpl_vars['errorArray']['calendar_address'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['calendar_address']; ?>
</span><?php else: ?>Location / Address of the event<?php endif; ?>			
			</td>				
			</tr>
          <tr>
            <td>
				<h4 class="error">Start Date:</h4><br />
				<input type="text" name="calendar_startdate" id="calendar_startdate" value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['calendarData']['calendar_startdate'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['startdate']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['startdate'])))) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
" size="20" readonly /><br />
				<?php if (isset ( $this->_tpl_vars['errorArray']['calendar_startdate'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['calendar_startdate']; ?>
</span><?php else: ?>Start date and time of the meeting / event<?php endif; ?>	
			</td>	
			<td>
				<h4 class="error">End Date:</h4><br />
				<input type="text" name="calendar_enddate" id="calendar_enddate" value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['calendarData']['calendar_enddate'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['enddate']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['enddate'])))) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
" size="20" readonly /><br />
				<?php if (isset ( $this->_tpl_vars['errorArray']['calendar_enddate'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['calendar_enddate']; ?>
</span><?php else: ?>End date and time of the meeting / event<?php endif; ?>
			</td>				
          </tr>		
          <tr>
            <td colspan="2">
				<h4 class="error">Description:</h4><br />
				<textarea id="calendar_description" name="calendar_description" rows="50" cols="100"><?php echo $this->_tpl_vars['calendarData']['calendar_description']; ?>
</textarea>
				<?php if (isset ( $this->_tpl_vars['errorArray']['calendar_description'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['calendar_description']; ?>
</span><?php else: ?>Details of the meeting / event.<?php endif; ?>
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
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {	

			
	new nicEditor({
		iconsPath	: \'/library/javascript/nicedit/nicEditorIcons.gif\',
		buttonList 	: [\'bold\',\'italic\',\'underline\',\'left\',\'center\', \'ol\', \'ul\', \'xhtml\', \'fontFormat\', \'fontFamily\', \'fontSize\', \'unlink\', \'link\', \'strikethrough\', \'superscript\', \'subscript\', \'upload\'],
		uploadURI : \'/library/javascript/nicedit/nicUpload.php\',
	}).panelInstance(\'calendar_description\');
	
	$("#calendar_startdate").datetimepicker({
		dateFormat: \'yy-mm-dd\'
	});
	
	$( "#calendar_enddate" ).datetimepicker({
		dateFormat: \'yy-mm-dd\'
	});
	
});
				
function submitForm() {
	nicEditors.findEditor(\'calendar_description\').saveContent();
	document.forms.detailsForm.submit();					 
}
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>