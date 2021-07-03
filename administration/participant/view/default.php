<?php/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');/*** Standard includes */require_once 'config/database.php';
require_once 'config/smarty.php';/** * Check for login */require_once 'administration/includes/auth.php';require_once 'class/participant.php';$participantObject = new class_participant();  if(isset($_GET['delete_code'])) {		$errorArray				= array();	$errorArray['error']	= '';	$errorArray['result']	= 0;		$formValid				= true;	$success					= NULL;	$code						= trim($_GET['delete_code']);			if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {		$data	= array();		$data['participant_deleted'] = 1;		$data['participant_code'] = $code;				$where = $participantObject->getAdapter()->quoteInto('participant_code = ?', $code);		$success	= $participantObject->update($data, $where);					if(is_numeric($success) && $success > 0) {			$errorArray['error']	= '';			$errorArray['result']	= 1;					} else {			$errorArray['error']	= 'Could not delete, please try again.';			$errorArray['result']	= 0;						}	}		echo json_encode($errorArray);	exit;} /* Competition mail */if(isset($_GET['competition'])) {		$errorArray				= array();	$errorArray['error']	= '';	$errorArray['result']	= 0;			if (isset($_GET['code']) && trim($_GET['code']) != '') {				$code = trim($_GET['code']);				$participantData = $participantObject->getByCode($code);		if(!$participantData) {			$errorArray['error']	= 'Participant does not exist.';			$errorArray['result']	= 1;			}	} else {		$errorArray['error']	= 'Participant does not exist.';		$errorArray['result']	= 1;			}		if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {				$_commsObject = new class_comms();					$participantData['category'] = 'phase-1-competition';		$_commsObject->sendEmailComm('mailers/web/competition_entry.html', $participantData, 'Bizlounge Competition Entry', array('email' => 'info@bizlounge.co.za', 'name' => 'Business Lounge Information'));			$errorArray['error']	= '';		$errorArray['result']	= 1;				}		echo json_encode($errorArray);	exit;}/* Check posted data. */if(isset($_GET['resend'])) {		$errorArray				= array();	$errorArray['error']	= '';	$errorArray['result']	= 0;			if (isset($_GET['code']) && trim($_GET['code']) != '') {				$code = trim($_GET['code']);				$participantData = $participantObject->getByCode($code);		if(!$participantData) {			$errorArray['error']	= 'Participant does not exist.';			$errorArray['result']	= 1;			}	} else {		$errorArray['error']	= 'Participant does not exist.';		$errorArray['result']	= 1;			}		if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {					$_commsObject = new class_comms();			$participantData['category'] = 'resend-registration';		$_commsObject->sendEmailComm('mailers/web/registration_confirm_reminder.html', $participantData, 'Email Confirmation Reminder', array('email' => 'info@bizlounge.co.za', 'name' => 'Business Lounge Information'));					$errorArray['error']	= '';		$errorArray['result']	= 1;				}		echo json_encode($errorArray);	exit;}/* Setup Pagination. */$participantData = $participantObject->getAll('participant_deleted = 0','participant.participant_added');if($participantData) $smarty->assign_by_ref('participantData', $participantData);/* End Pagination Setup. */$smarty->display('administration/participant/view/default.tpl');?>