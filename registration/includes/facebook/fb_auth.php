<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once('config/database.php');
require_once('config/smarty.php');
require_once('global_functions.php');

$smarty->assign('APP_ID', APP_ID);
$smarty->assign('APP_SECRET', APP_SECRET);

/* Include relevent files. */
require_once 'api/facebook/facebook.php';

/* Create our Application instance (replace this with your appId and secret) */
$facebook = new Facebook(array('appId'  => APP_ID, 'secret' => APP_SECRET));	

/* Get User ID */
$social_user = $facebook->getUser();

/* check user. */
if($social_user) {
	
	/* Get facebook user. */
	try {
		/* Get facebook user. */
		$facebookGuest = $facebook->api('/me');

	} catch(FacebookApiException $fae) {

		/* Clean up. */
		$social_user = NULL;
		if(isset($facebookGuest)) UNSET($facebookGuest);
	}
	
	/* Check if user exists on our database by email and user id. */
	if(isset($facebookGuest['email']) && trim($facebookGuest['email']) != '') {
	
		/* Get jobSeeker class. */
		require_once 'class/participant.php';
		
		/* Create Objects. */
		$participantObject 			= new class_participant();
		
		/* Check if email exists. */
		$facebookUser = $participantObject->checkFB(trim($facebookGuest['email']), $facebookGuest['id']);
		
		/* Check if user exists. */
		if($facebookUser) {
			
			/* Update "last login" */
			$data = array('participant_last_login' => date('Y-m-d H:i:s'));
			$where = $participantObject->getAdapter()->quoteInto('participant_fb_id = ?', trim($facebookGuest['id']));
			$participantObject->update($data, $where);				
			
		} else {
		
			$data 															= array();	
			$data['participant_code']								= $participantObject->createReference();
			$data['participant_name'] 								= isset($facebookGuest['first_name']) && trim($facebookGuest['first_name']) != '' ? trim($facebookGuest['first_name']) : null;
			$data['participant_surname'] 							= isset($facebookGuest['last_name']) && trim($facebookGuest['last_name']) != '' ? trim($facebookGuest['last_name']) : null;
			$data['participant_gender'] 							= isset($facebookGuest['gender']) && trim($facebookGuest['gender']) != '' ? strtolower(trim($facebookGuest['gender'])) : null;
			$data['participant_username'] 						= isset($facebookGuest['email']) && trim($facebookGuest['email']) != '' ? trim($facebookGuest['email']) : null;
			$data['participant_registration_confirmation'] 	= md5($data['participant_code']);
			$data['participant_active']	 							= 1;
			$data['participant_logintype'] 							= 'facebook';
			$data['participant_password'] 							= $participantObject->createPassword();
			$data['participant_fb_id']								= isset($facebookGuest['id']) && trim($facebookGuest['id']) != '' ? trim($facebookGuest['id']) : null;
			$data['participant_fb_link']								= isset($facebookGuest['link']) && trim($facebookGuest['link']) != '' ? trim($facebookGuest['link']) : null;
			$data['participant_fb_email']							= isset($facebookGuest['email']) && trim($facebookGuest['email']) != '' ? trim($facebookGuest['email']) : null;
			$data['participant_fb_location']						= isset($facebookGuest['location']['name']) && trim($facebookGuest['location']['name']) != '' ? trim($facebookGuest['location']['name']) : null;
							
			/* Insert the data. */ 
			$participantObject->insert($data);							
		}
		
		/* Setup the login variables. */
		$zfsession->logintype	= 'facebook';
		$zfsession->identity	= $facebookGuest['email'];	
		
	} else {
		/* Emptry the user. */
		$social_user = NULL;			
	}
} else {
	/* Emptry the user. */
	$social_user = NULL;
}

?>