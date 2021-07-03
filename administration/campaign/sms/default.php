<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/**
 * Check for login
 */
require_once 'administration/includes/auth.php';
require_once 'class/_campaign.php';

$campaignObject = new class_campaign();
 
 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['_campaign_deleted'] = 1;
		
		$where = $campaignObject->getAdapter()->quoteInto('_campaign_code = ?', $code);
		$success	= $campaignObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not delete, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

/* Setup Pagination. */
$campaignData = $campaignObject->getAll("_campaign_deleted = 0 and _campaign_type = 'SMS'",'_campaign._campaign_added');
if($campaignData) $smarty->assign_by_ref('campaignData', $campaignData);

/* End Pagination Setup. */

$smarty->display('administration/campaign/sms/default.tpl');
?>