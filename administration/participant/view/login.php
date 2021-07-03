<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */
require_once 'administration/includes/auth.php';

/* objects. */
require_once 'class/participantlogin.php';
require_once 'class/participant.php';

$participantloginObject = new class_participantlogin();
$participantObject 		= new class_participant();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$participantData = $participantObject->getByCode($code);
	
	if($participantData) {
	
		$smarty->assign('participantData', $participantData);
		
		$participantloginData = $participantloginObject->getByParticipant($code);
		
		if($participantloginData) {
			$smarty->assign('participantloginData', $participantloginData);
		}
	} else {
		header('Location: /administration/participant/view/');
		exit;		
	}
} else {
	header('Location: /administration/participant/view/');
	exit;
}

$smarty->display('administration/participant/view/login.tpl');
?>