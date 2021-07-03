<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Check for login */
require_once 'administration/includes/auth.php';

/* objects. */
require_once 'class/_campaign.php';

$campaignObject = new class_campaign();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$campaignData = $campaignObject->getByCode($code);

	if($campaignData) {
		$smarty->assign('campaignData', $campaignData);
	} else {
		header('Location: /administration/campaig/mailers/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['_campaign_name']) && trim($_POST['_campaign_name']) == '') {
		$errorArray['_campaign_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['_campaign_subject']) && trim($_POST['_campaign_subject']) == '') {
		$errorArray['_campaign_subject'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['_campaign_content']) && trim($_POST['_campaign_content']) == '') {
		$errorArray['_campaign_content'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
	
		$data 	= array();				
		$data['_campaign_name']		= trim($_POST['_campaign_name']);		
		$data['_campaign_subject']	= trim($_POST['_campaign_subject']);	
		$data['_campaign_content']	= trim($_POST['_campaign_content']);			
		$data['_campaign_type']		= 'EMAIL';	
			
		$smarty->assign('campaignData', $data);		
		$smarty->assign('host', $_SERVER['HTTP_HOST']);
		
		$message = $smarty->fetch('templates/campaign.html');

		$data['_campaign_html']	= $message;	
		
		if(isset($campaignData)) {
			$where		= $campaignObject->getAdapter()->quoteInto('_campaign_code = ?', $campaignData['_campaign_code']);
			$success	= $campaignObject->update($data, $where);			
			$success 	= $campaignData['_campaign_code'];
		} else {
			$success = $campaignObject->insert($data);
		}
		
		if(count($errorArray) == 0) {
			header('Location: /administration/campaign/mailers/mail.php?code='.$success);	
			exit;		
		}
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('administration/campaign/mailers/details.tpl');

?>