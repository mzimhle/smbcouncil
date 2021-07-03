<?php

ini_set('max_execution_time', 2100); //300 seconds = 5 minutes

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Other resources. */
require_once 'administration/includes/auth.php';

require_once 'class/_campaign.php';
require_once 'class/mailinglist.php';
require_once 'class/_comm.php';

$campaignObject		= new class_campaign();
$mailinglistObject		= new class_mailinglist();
$commObject 			= new class_comm();		

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$reference = trim($_GET['code']);

	$campaignData = $campaignObject->getByCode($reference);

	if($campaignData) {
		$smarty->assign('campaignData', $campaignData);
		
	} else {
		header('Location: /administration/campaign/sms/');
		exit;
	}
} else {
	header('Location: /administration/campaign/sms/');
	exit;
}

$mailinglistPairs = $mailinglistObject->pairs();
if($mailinglistPairs) $smarty->assign('mailinglistPairs', $mailinglistPairs);

 /* Competition mail */
if(isset($_GET['category'])) {
	
	$errorArray				= array();
	$errorArray['message']	= '';
	$errorArray['result']	= 1;	
	$errorArray['data']	= array();	
	
	if (isset($_GET['category']) && trim($_GET['category']) != '') {
		
		$code = trim($_GET['category']);
		
		$mailinglistData = $mailinglistObject->getByCategory($code, 'sms');
		
		if(!$mailinglistData) {
			$errorArray['message']	= 'No contacts in this category.';
			$errorArray['result']	= 0;	
		} else {
			$errorArray['data']	= $mailinglistData;	
		}
	} else {
		$errorArray['message']	= 'Please select category.';
		$errorArray['result']	= 0;		
	}
	
	echo json_encode($errorArray);
	exit;
}

 /* Competition mail */
if(count($_POST) > 0 && !isset($_GET['category'])) {

	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['mailinglist_code']) && count($_POST['mailinglist_code']) == 0) {
		$errorArray['mailinglist_code'] = 'Please select contacts to send an email to.';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {		

		for($i = 0; $i < count($_POST['mailinglist_code']); $i++) {
		
			$mailinglistData = false; $mailinglistData = $mailinglistObject->getByCode($_POST['mailinglist_code'][$i]);
			
			if($mailinglistData) {
				$mailinglistData['reference'] = 'CAMPAIGN';
				$success = $commObject->sendSMS($campaignData['_campaign_message'], $mailinglistData, $campaignData['_campaign_code']);	
			}
		}
		
		header('Location: /administration/campaign/sms/comms.php?code='.$campaignData['_campaign_code']);	
		exit;		
				
	}
}


 /* Display the template  */	
$smarty->display('administration/campaign/sms/sms.tpl');
?>