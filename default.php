<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* objects. */
require_once 'class/_comm.php';
require_once 'class/participant.php';
require_once 'class/participantlogin.php';
require_once 'class/File.php';

require_once 'global_functions.php';

/* include the Zend class for Authentification */
require_once 'Zend/Session.php';

/* Set up the namespace */
if(isset($zfsession)) {
	$zfsession = $zfsession->identity = null; 
	unset($zfsession, $zfsession->identity);
}

$zfsession 					= new Zend_Session_Namespace('FrontendUser');

$participantObject 			= new class_participant();
$participantloginObject 	= new class_participantlogin();
$commObject 				= new class_comm();
$fileObject 					= new File(array('gif', 'png', 'jpg', 'jpeg', 'gif'));

if(count($_GET) > 0 && isset($_GET['ajax']) && trim($_GET['ajax']) == 'fb') {
	
	$errorMessages				= '';
	$data 							= array();
	$formValid					= true;
	
	if(isset($_GET['id']) && trim($_GET['id']) == '') {
		$errorMessages = 'No facebook id received.';
		$formValid = false;		
	}
	
	if(isset($_GET['email']) && trim($_GET['email']) != '') {
		if($participantObject->validateEmail(trim($_GET['email'])) == '') {
			$errorMessages = 'Please enter a valid email address';
			$formValid = false;
		}
	} else {
		$errorMessages = 'No email has been given.';
		$formValid = false;			
	}	
	
	if($formValid == true && $errorMessages == '') {
			
			/* Check if email exists in the facebook login. */
			$emailData = $participantloginObject->checkUsername(trim($_GET['email']), 'FACEBOOK', true);
			
			if($emailData) {				

				/* Update the data. */
				$wheregl = $participantloginObject->getAdapter()->quoteInto('participantlogin_code = ?', $emailData['participantlogin_code']);
				$participantloginObject->updateLogin($_GET, $wheregl, 'FACEBOOK');		
				$participantlogincode = $emailData['participantlogin_code'];	
				
			} else {
				
				/* Check if email exists in other login types, except facebook. */
				$userData = $participantloginObject->checkUsername(trim($_GET['email']), 'FACEBOOK', false);
					
				if(!$userData) {					
					$data 							= array();	
					$data['participant_name'] 		= isset($_GET['first_name']) && trim($_GET['first_name']) != '' ? trim($_GET['first_name']) : null;
					$data['participant_surname'] 	= isset($_GET['last_name']) && trim($_GET['last_name']) != '' ? trim($_GET['last_name']) : null;
					$data['participant_gender'] 	= isset($_GET['gender']) && trim($_GET['gender']) != '' ? strtolower(trim($_GET['gender'])) : null;
					$data['participant_email'] 		= isset($_GET['email']) && trim($_GET['email']) != '' ? trim($_GET['email']) : null;
					$data['participant_active']	 	= 1;	
					
					/* Insert the data. */ 
					$participantcode = $participantObject->insert($data);
				} else {						
					$participantcode = $userData['participant_code'];
					
					if($userData['participantlogin_type'] == 'EMAIL') {						
						/* Activate participant if the email address is that of the EMAIL type. */
						$email_data = array('participantlogin_active' => 1);
						$email_where = $participantloginObject->getAdapter()->quoteInto('participantlogin_code = ?', $userData['participantlogin_code']);
						$email_success = $participantloginObject->update($email_data, $email_where);
						
						/* Activate account and stay on this page. */
						$email_data = $email_where = null; $email_data = array('participant_active' => 1, 'participant_code' => $userData['participant_code']);
						$email_where = $participantObject->getAdapter()->quoteInto('participant_code = ?', $userData['participant_code']);
						$email_success = $participantObject->update($email_data, $email_where);
					}					
				}
				
				/* Insert the login data. */ 
				$participantlogincode = $participantloginObject->insertLogin($_GET, 'FACEBOOK', $participantcode);	
				
			}

			/* Setup the login variables. */
			$zfsession->identity	= $participantlogincode;		
	}

	/* if we are here there are errors. */
	$output['message']	= $errorMessages;	
	$output['result']			= $formValid;
	
	echo json_encode($output);
	exit;	
}

/* Check posted data. */
if(count($_POST) > 0 && !isset($_GET['ajax'])) {
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['participant_name']) && trim($_POST['participant_name']) == '') {
		$errorArray['participant_name'] = 'Please add a full name';
		$formValid = false;		
	}
	
	if(isset($_POST['participant_email']) && trim($_POST['participant_email']) != '') {
		if($participantObject->validateEmail(trim($_POST['participant_email'])) == '') {
			$errorArray['participant_email'] = 'Needs to be a valid email address';
			$formValid = false;	
		} else {
		
			$emailData = $participantloginObject->checkEmail(trim($_POST['participant_email']));
			
			if($emailData) {
				$errorArray['participant_email'] = 'Email already exists';
				$formValid = false;				
			}
		}
	} else {
		$errorArray['participant_email'] = 'Please add an email address';
		$formValid = false;			
	}
	
	if(count($errorArray) == 0 && $formValid == true) {

		$data 	= array();	
		$data['participant_name']	= trim($_POST['participant_name']);	
		$data['participant_email']	= trim($_POST['participant_email']);
		$data['participant_active']	= 0;
		
		$success = $participantObject->insert($data);
		
		$datalogin = array();
		$datalogin['participant_code'] 					= $success;
		$datalogin['participantlogin_username'] 	= $data['participant_email'];
		$datalogin['participantlogin_name'] 			= $data['participant_name'];
		
		/* Insert the login data. */ 
		$participantlogincode = $participantloginObject->insertLogin($datalogin, 'EMAIL', $success);
		
		if(count($errorArray) == 0) {
			/* Setup the login variables. */
			$zfsession->identity		= $participantlogincode;
			
			// redirect to the success page. 
			header('Location: /registration/complete/');
			exit;		
		}
			
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

/* Display the template */	
$smarty->display('default.tpl');
?>