<?php
/* standard config include. */
require_once 'config/database.php';
require_once 'config/smarty.php';

global $smarty;

/* include the Zend class for Authentification */
require_once 'Zend/Session.php';

/* Set up the namespace */
$zfsession = new Zend_Session_Namespace('FrontLogin');

/* Check for facebook authenitcation. */
require_once 'facebook_auth.php';

echo 'echo: '.$zfsession->identity.'<br /><br />';
/* Check if logged in, otherwise redirect */
if (isset($zfsession->identity) || !is_null($zfsession->identity) || $zfsession->identity != '') {
	/* Class */

	/* get user details by username */
	if(isset($zfsession->fb_id) && $zfsession->fb_id != '') {	
		/* Get Facebook account details. */
		$userData	= $jobSeekerObject->getByEmail($zfsession->identity, "fb_user_id = '".$zfsession->fb_id."'");
	} else if(isset($zfsession->twitter_id) && $zfsession->twitter_id != '') {	
		/* Get Twitter account details. */
		$userData	= $jobSeekerObject->getByTwitterId($zfsession->twitter_id);
	} else if(isset($zfsession->google_id) && $zfsession->google_id != ''){
		/* Get Google account details. */
		$userData	= $jobSeekerObject->getByEmail($zfsession->identity, "google_identity != '' OR google_identity != NULL");
	} else {
		/* Get Normal account details. */
		$userData	= $jobSeekerObject->getByEmail($zfsession->identity);		
	}	

	$smarty->assign('userData', $userData[0]);	
	global $userData;	
}

?>