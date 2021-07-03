<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */
require_once 'administration/includes/auth.php';

/* objects. */
require_once 'class/participant.php';
require_once 'class/_comm.php';

$participantObject 	= new class_participant();
$commObject 		= new class_comm();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$participantData = $participantObject->getByCode($code);
	
	if($participantData) {
		$smarty->assign('participantData', $participantData);
		
		$commData = $commObject->getByMailingReference($participantData['participant_code'], 'participant');
		
		if($commData) {
			$smarty->assign('commData', $commData);
		}
	} else {
		header('Location: /administration/participant/view/');
		exit;		
	}
} else {
	header('Location: /administration/participant/view/');
	exit;
}


$smarty->display('administration/participant/view/mail.tpl');
?>