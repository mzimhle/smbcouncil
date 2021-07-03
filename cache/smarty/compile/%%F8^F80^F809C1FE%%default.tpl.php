<?php /* Smarty version 2.6.20, created on 2015-04-21 14:05:55
         compiled from administration/participant/view/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'administration/participant/view/default.tpl', 48, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMB COUNCIL</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<script type="text/javascript" language="javascript" src="default.js"></script>
</head>

<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<div id="breadcrumb">
        <ul>
            <li><a href="/administration/" title="Home">Home</a></li>
			<li><a href="/administration/participant/" title="Jobs">Members</a></li>
			<li><a href="/administration/participant/view/" title="Jobs">View</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Members</h2>
	<a href="/administration/participant/view/details.php" title="Click to Add a new Member" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Member</span></a>  <br /> 
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>				
				<th>Added</th>
				<th>Picture</th>
				<th>Area</th>
				<th>Full Name</th>
				<th>Login Types</th>
				<th>Email</th>
				<th></th>
				<th></th>
				<th></th>
				</tr>
			   </thead>
			   <tbody> 
			  <?php $_from = $this->_tpl_vars['participantData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['participant_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
				<td align="left"><img src="<?php if ($this->_tpl_vars['item']['participant_image_path'] == ''): ?>/images/avatar.jpg<?php else: ?><?php echo $this->_tpl_vars['item']['participant_image_path']; ?>
tny_<?php echo $this->_tpl_vars['item']['participant_image_name']; ?>
<?php echo $this->_tpl_vars['item']['participant_image_ext']; ?>
<?php endif; ?>" width="60" /></td>
				<td align="left"><?php if ($this->_tpl_vars['item']['areapost_code'] != ''): ?><?php echo $this->_tpl_vars['item']['areapost_suburb']; ?>
, <?php echo $this->_tpl_vars['item']['areapost_city']; ?>
, <?php echo $this->_tpl_vars['item']['areapost_box']; ?>
<?php else: ?>N/A<?php endif; ?></td>
				<td align="left"><a href="/administration/participant/view/details.php?code=<?php echo $this->_tpl_vars['item']['participant_code']; ?>
"><?php echo $this->_tpl_vars['item']['participant_name']; ?>
 <?php echo $this->_tpl_vars['item']['participant_surname']; ?>
</a></td>
				<td align="left"><a href="/administration/participant/view/login.php?code=<?php echo $this->_tpl_vars['item']['participant_code']; ?>
"><?php echo $this->_tpl_vars['item']['participantlogin_type']; ?>
</a></td>
				<td align="left"><?php echo $this->_tpl_vars['item']['participant_email']; ?>
</td>
				<td align="left"><?php if ($this->_tpl_vars['item']['participant_active'] == '1'): ?><span style="color: green;">Active</span><?php else: ?><span style="color: red;">Not Active</span><?php endif; ?></td>
				<td align="right"><?php if ($this->_tpl_vars['item']['participant_active'] == '1'): ?><span style="color: green;">N/A</span><?php else: ?><button onclick="resendregmail('<?php echo $this->_tpl_vars['item']['participant_code']; ?>
')">Re-send Reg-Mail</button><?php endif; ?></td>
				<td align="right"><button onclick="deleteitem('<?php echo $this->_tpl_vars['item']['participant_code']; ?>
')">Delete</button></td>
			  </tr>
			  <?php endforeach; endif; unset($_from); ?>     
			  </tbody>
			</table>
		 </div>
		 <!-- End Content Table -->	
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'administration/includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<?php echo '
<script type="text/javascript" language="javascript">
function deleteitem(id) {					
	if(confirm(\'Are you sure you want to delete this item?\')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "delete_code="+id,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Item deleted!\');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	
	return false;
	
}
function sendcompemail(id) {					
	if(confirm(\'Are you sure you want to send this competition entry mail?\')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "code="+id+"&competition=1",
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Email sent!\');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	
	return false;
	
}
function resendregmail(id) {					
	if(confirm(\'Are you sure about this ?\')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "code="+id+"&resend=1",
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Email sent!\');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	
	return false;
	
}
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>