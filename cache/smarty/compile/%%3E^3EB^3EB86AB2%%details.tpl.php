<?php /* Smarty version 2.6.20, created on 2014-12-18 10:47:24
         compiled from administration/communication/details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'administration/communication/details.tpl', 9, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Comm Sent</title>
</head>
<body>
	<a href="/administration/communication/"><h3>Go Back</h3></a>
	<?php echo $this->_tpl_vars['commData']['_comm_name']; ?>
 - <?php echo ((is_array($_tmp=@$this->_tpl_vars['commData']['_comm_email'])) ? $this->_run_mod_handler('default', true, $_tmp, "N/A") : smarty_modifier_default($_tmp, "N/A")); ?>
 - <?php echo ((is_array($_tmp=@$this->_tpl_vars['commData']['_comm_cellphone'])) ? $this->_run_mod_handler('default', true, $_tmp, "N/A") : smarty_modifier_default($_tmp, "N/A")); ?>
<br />
	Output: <?php echo $this->_tpl_vars['commData']['_comm_output']; ?>
<br /><br />
	<?php if ($this->_tpl_vars['commData']['_comm_html'] == ''): ?>
	Message: <?php echo $this->_tpl_vars['commData']['_comm_message']; ?>

	<?php else: ?>
	Mailer Sent: <br /><br />
	<table>
		<tr><td align="center" width="200px">
			<?php echo $this->_tpl_vars['commData']['_comm_html']; ?>

		</td></tr>
	</table>
	<?php endif; ?>
</body>
</html>