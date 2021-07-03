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
		header('Location: /administration/campaign/sms/');
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
	
	if(isset($_POST['_campaign_message']) && trim($_POST['_campaign_message']) == '') {
		$errorArray['_campaign_message'] = 'required';
		$formValid = false;		
	} else {
		if(strlen(trim($_POST['_campaign_message'])) > 160) {
			$errorArray['_campaign_message'] = 'Message limit of 160 characters';
			$formValid = false;					
		}
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
	
		$data 	= array();				
		$data['_campaign_name']		= trim($_POST['_campaign_name']);		
		$data['_campaign_message']	= trim($_POST['_campaign_message']);			
		$data['_campaign_type']		= 'SMS';	
		
		if(isset($campaignData)) {
			$where		= $campaignObject->getAdapter()->quoteInto('_campaign_code = ?', $campaignData['_campaign_code']);
			$success	= $campaignObject->update($data, $where);			
			$success 	= $campaignData['_campaign_code'];
		} else {
			$success = $campaignObject->insert($data);
		}
		
		if(count($errorArray) == 0) {
			header('Location: /administration/campaign/sms/sms.php?code='.$success);	
			exit;		
		}
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('administration/campaign/sms/details.tpl');

?>