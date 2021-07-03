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
require_once 'class/_comm.php';

$campaignObject	= new class_campaign();
$commObject 		= new class_comm();		

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$code = trim($_GET['code']);

	$campaignData = $campaignObject->getByCode($code);

	if($campaignData) {
		$smarty->assign('campaignData', $campaignData);
		
		$commData = $commObject->getByCampaign($code);

		if($commData) {
			$smarty->assign('commData', $commData);
		}
		
	} else {
		header('Location: /administration/campaign/mailers/');
		exit;
	}
} else {
	header('Location: /administration/campaign/mailers/');
	exit;
}

 /* Display the template  */	
$smarty->display('administration/campaign/mailers/comms.tpl');
?>