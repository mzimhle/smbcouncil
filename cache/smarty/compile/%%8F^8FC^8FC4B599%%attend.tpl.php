<?php /* Smarty version 2.6.20, created on 2015-04-08 00:32:17
         compiled from administration/calendar/view/attend.tpl */ ?>
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
			<li><?php echo $this->_tpl_vars['calendarData']['calendar_name']; ?>
</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php echo $this->_tpl_vars['calendarData']['calendar_name']; ?>
</h2>
    <div id="sidetabs">
        <ul> 
            <li><a href="/administration/calendar/view/details.php?code=<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
" title="Details">Details</a></li>
			<li class="active"><a href="#" title="attendees">attendees</a></li>
			<li><a href="/administration/calendar/view/comms.php?code=<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
" title="Details">Comms</a></li>
        </ul>
    </div><!--tabs-->	  
	<div class="detail_box" style="width: 1076px; !important;">
      <form id="detailsForm" name="detailsForm" action="#" method="post">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="form">		  
          <tr>
            <td>
				Search for attendees:&nbsp; &nbsp; &nbsp;<br />
				<input type="text" name="contactsearch" id="contactsearch" value="" size="80" />
			</td>			
          </tr>			  
          <tr>
            <td>
				<h4 class="error">Attendees:</h4><br />
				<ul id="attendees" name="attendees" style="list-style: none; padding: 0; margin: 0;">
				<?php $_from = $this->_tpl_vars['attendeeData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<li id="attendee_<?php echo $this->_tpl_vars['item']['mailinglist_code']; ?>
" class="<?php if ($this->_tpl_vars['item']['calendarattend_response'] == '1'): ?>success<?php endif; ?><?php if ($this->_tpl_vars['item']['calendarattend_response'] == '0'): ?>error<?php endif; ?>">
					<button onclick="emailattendee('<?php echo $this->_tpl_vars['item']['mailinglist_code']; ?>
'); return false;">Email</button>&nbsp; &nbsp; &nbsp;
					<button onclick="deleteattendee('<?php echo $this->_tpl_vars['item']['mailinglist_code']; ?>
'); return false;">remove</button>&nbsp; &nbsp; &nbsp;
					<?php echo $this->_tpl_vars['item']['mailinglist_name']; ?>
 - <?php echo $this->_tpl_vars['item']['mailinglist_email']; ?>
 -  <?php echo $this->_tpl_vars['item']['mailinglist_cellphone']; ?>

				</li>
				<?php endforeach; endif; unset($_from); ?>
				</ul>
			</td>			
          </tr>	
			<tr>
				<td>		
				<div class="clearer"><!-- --></div>
				<div class="mrg_top_10">
				<a href="javascript:void(0);" onclick="emailAll(); return false;" class="blue_button fl"><span>Send email to all attendees</span></a>   
				</div>
				</td>
			</tr>			  
			<tr>
				<td>
					<h4>Send Message:</h4><br />
					<textarea id="message" name="message" rows="3" cols="100"></textarea>
					<p id="charcount" class="error">0 characters entered.</p>
					<div class="mrg_top_10">
					  <a href="javascript:void(0);" onclick="sendSMS(); return false;" class="blue_button fl"><span>Send sms to all attendees</span></a>   
					</div>					
				</td>
			</tr>
        </table>	
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

	$("#message").keyup(function () {
		var i = $("#message").val().length;
		$("#charcount").html(i+\' characters entered.\');
		if (i > 160) {
			$(\'#charcount\').removeClass(\'success\');
			$(\'#charcount\').addClass(\'error\');
		} else if(i == 0) {
			$(\'#charcount\').removeClass(\'success\');
			$(\'#charcount\').addClass(\'error\');
		} else {
			$(\'#charcount\').removeClass(\'error\');
			$(\'#charcount\').addClass(\'success\');
		} 
	});	

	/* Search for mentors. */
	$( "#contactsearch").autocomplete({
		source: "/feeds/profiles.php",
		minLength: 1,
		select: function( event, ui ) {
		
			if(ui.item.id == \'\') {
				
				$("#contactsearch").val(\'\');
			} else {
				
				if($(\'#attendee_\'+ui.item.id).length == 0) {
					addAttendee(ui.item.id);
				} else {
					alert(\'This has already been added.\');
				}
				
				$("#contactsearch").val(\'\');
			}
			
			$(\'#contactsearch\').val(\'\');										
		}
	});
});

function sendSMS(code) {
	
	if(confirm(\'Are you sure you want to sms all attendees? This may take a while...\')) {
		$.post("?action=smsall&code='; ?>
<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
<?php echo '", {
				attendeecode	: code,
				message	: $(\'#message\').val()
			},
			function(data) {
				if(data.result) {
					alert(\'SMS has been sent to all attendees\');
				} else {
					alert(data.error);
				}
			},
			\'json\'
		);	
	}
	return false;
}

function emailAll(code) {
		
	if(confirm(\'Are you sure you want to email all attendees? This may take a while...\')) {
		$.post("?action=emailall&code='; ?>
<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
<?php echo '", {
				attendeecode	: code
			},
			function(data) {
				if(data.result) {
					alert(\'Email has been sent to all attendees\');
				} else {
					alert(data.error);
				}
			},
			\'json\'
		);	
	}
	return false;
}

function emailattendee(code) {
		
	if(confirm(\'Are you sure you want to send this email?\')) {
		$.post("?action=emailattendee&code='; ?>
<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
<?php echo '", {
				attendeecode	: code
			},
			function(data) {
				if(data.result) {
					alert(\'Email has been sent\');
				} else {
					alert(data.error);
				}
			},
			\'json\'
		);	
	}
	return false;
}

function deleteattendee(code) {
	
	if(confirm(\'Are you sure you want to delete this attendee?\')) {
		$.post("?action=deleteattendee&code='; ?>
<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
<?php echo '", {
				attendeecode	: code
			},
			function(data) {
				if(data.result) {
					$(\'#attendee_\'+code).remove();
				} else {
					alert(data.error);
				}
			},
			\'json\'
		);	
	}
	return false;
}

function addAttendee(mailinglistcode) {
	
	$.post("?action=addattendee&code='; ?>
<?php echo $this->_tpl_vars['calendarData']['calendar_code']; ?>
<?php echo '", {
			mailinglistcode	: mailinglistcode
		},
		function(data) {
			if(data.result) {
				window.location.href = window.location.href;
			} else {
				alert(data.error);
			}
		},
		\'json\'
	);	
	
	return false;
}
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>