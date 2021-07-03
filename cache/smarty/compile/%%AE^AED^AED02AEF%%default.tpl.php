<?php /* Smarty version 2.6.20, created on 2015-03-23 09:20:23
         compiled from administration/communication/default.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sportal</title>
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
			  <?php $_from = $this->_tpl_vars['commData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td align="left"><a class="<?php if ($this->_tpl_vars['item']['_comm_sent'] == '1'): ?>success<?php else: ?>error<?php endif; ?>" href="/administration/communication/details.php?code=<?php echo $this->_tpl_vars['item']['_comm_code']; ?>
"><?php echo $this->_tpl_vars['item']['_comm_code']; ?>
</a></td>	
				<td><?php echo $this->_tpl_vars['item']['_comm_added']; ?>
</td>
				<td align="left"><a href="/administration/participants/details.php?code=<?php echo $this->_tpl_vars['item']['participant_code']; ?>
" target="_blank"><?php echo $this->_tpl_vars['item']['participant_name']; ?>
 <?php echo $this->_tpl_vars['item']['participant_surname']; ?>
</a></td>
				<td align="left"><?php echo $this->_tpl_vars['item']['_comm_name']; ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['item']['_comm_output']; ?>
</td>						
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
<!-- End Main Container -->
</body>
</html>