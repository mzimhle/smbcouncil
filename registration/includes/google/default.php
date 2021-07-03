<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* standard config include. */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* include the Zend class for Authentification */
require_once 'Zend/Session.php';

/* Set up the namespace */
$zfsession = new Zend_Session_Namespace('FrontendUser');

/* Check for mode. */
$openid_mode = isset($_GET['openid_mode']) ? trim($_GET['openid_mode']) : NULL;

/* First lets check if there is no one logged in. */

	if($openid_mode == 'cancel') {
		/* Do nothing. */
	} else { 
		/* Get google login API class file. */
		require_once 'api/gmail/openid.php';

		/* Get the variables that we will save later. */
		$openid_ext1_value_firstname	= isset($_GET['openid_ext1_value_firstname']) ? trim($_GET['openid_ext1_value_firstname']) : NULL;
		$openid_ext1_value_lastname	= isset($_GET['openid_ext1_value_lastname']) ? trim($_GET['openid_ext1_value_lastname']) : NULL;
		$openid_ext1_value_email			= isset($_GET['openid_ext1_value_email']) ? trim($_GET['openid_ext1_value_email']) : NULL;
		$openid_identity						= isset($_GET['openid_identity']) ? trim($_GET['openid_identity']) : NULL;

		/* Check if email is an actual email. */
		if($openid_ext1_value_email != NULL) {
			/* Check here. */
			if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $openid_ext1_value_email)) { 
				$openid_ext1_value_email = NULL;
			}
		}

		if($openid_ext1_value_firstname == NULL && $openid_ext1_value_lastname == NULL && $openid_ext1_value_email == NULL) {
			/* Creating new instance */
			$openid = new LightOpenID;
			$openid->identity = 'https://www.google.com/accounts/o8/id';
			
			/* setting call back url */
			$openid->returnUrl = 'http://'.$_SERVER['HTTP_HOST'].'/registration/includes/google/';
			
			/* finding open id end point from google */
			$endpoint 	=	$openid->discover('https://www.google.com/accounts/o8/id');
			$fields 	=	'?openid.ns=' . urlencode('http://specs.openid.net/auth/2.0') .
							'&openid.return_to=' . urlencode($openid->returnUrl) .
							'&openid.claimed_id=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
							'&openid.identity=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
							'&openid.mode=' . urlencode('checkid_setup') .
							'&openid.ns.ax=' . urlencode('http://openid.net/srv/ax/1.0') .
							'&openid.ax.mode=' . urlencode('fetch_request') .
							'&openid.ax.required=' . urlencode('email,firstname,lastname') .
							'&openid.ax.type.firstname=' . urlencode('http://axschema.org/namePerson/first') .
							'&openid.ax.type.lastname=' . urlencode('http://axschema.org/namePerson/last') .
							'&openid.ax.type.email=' . urlencode('http://axschema.org/contact/email');
			
			/* Ask user to using his/her gmail account. */
			header('Location: ' . $endpoint . $fields);	
			exit;
			
		} else {

			/* objects. */
			require_once 'class/_comm.php';
			require_once 'class/participant.php';
			require_once 'class/participantlogin.php';

			/* Get Object. */
			$participantObject 			= new class_participant();
			$participantloginObject 	= new class_participantlogin();
			$commObject 				= new class_comm();
			
			/* Check data exists. */			
			$googleData = $participantloginObject->checkUsername(trim($openid_ext1_value_email), 'GOOGLE', true);

			/* Insert/Update data array. */
			
			$google = array();
			$google['participantlogin_id'] 				= $openid_identity;
			$google['participantlogin_username'] 	= $openid_ext1_value_email;
			$google['participantlogin_name'] 		= $openid_ext1_value_firstname;
			$google['participantlogin_surname'] 	= $openid_ext1_value_lastname;
			$google['participantlogin_active'] 		= 1;

			if(!$googleData) {
			
				/* Check if email exists in other login types, except facebook. */
				$loginData = $participantloginObject->checkUsername(trim($openid_ext1_value_email), 'GOOGLE', false);
				
				if(!$loginData) {
					
					/* Insert new user. */
					$data = array();
					$data['participant_name'] 		= $openid_ext1_value_firstname;
					$data['participant_surname'] 	= $openid_ext1_value_lastname;
					$data['participant_email'] 		= $openid_ext1_value_email;
					$data['participant_active']		= 1;
					
					/* Insert the data. */ 
					$participantcode = $participantObject->insert($data);		
				} else {
					$participantcode = $loginData['participant_code'];
					
					if($loginData['participantlogin_type'] == 'EMAIL') {						
						/* Activate participant if the email address is that of the EMAIL type. */
						$email_data = array('participantlogin_active' => 1);
						$email_where = $participantloginObject->getAdapter()->quoteInto('participantlogin_code = ?', $loginData['participantlogin_code']);
						$email_success = $participantloginObject->update($email_data, $email_where);
						
						/* Activate account and stay on this page. */
						$email_data = $email_where = null; $email_data = array('participant_active' => 1, 'participant_code' => $loginData['participant_code']);
						$email_where = $participantObject->getAdapter()->quoteInto('participant_code = ?', $loginData['participant_code']);
						$email_success = $participantObject->update($email_data, $email_where);
					}
				}
				
				/* Insert the login data. */ 
				$participantlogincode = $participantloginObject->insertLogin($google, 'GOOGLE', $participantcode);						
						
			} else {
			
					$where = null; $where = array();
					$where[] = $participantloginObject->getAdapter()->quoteInto('participantlogin_username = ?', $googleData['participantlogin_username']);
					$where[] = $participantloginObject->getAdapter()->quoteInto('participantlogin_type = ?', 'GOOGLE');
					$where[] = $participantloginObject->getAdapter()->quoteInto('participant_code = ?', $googleData['participant_code']);
					$participantloginObject->updateLogin($google, $where, 'GOOGLE');
					
					$participantlogincode = $googleData['participantlogin_code'];
			}
			
			/* Setup the login variables. */
			$zfsession->identity		= $participantlogincode;
			
			// redirect the user back to the demo page
			header('Location: /registration/complete/');	
			exit;
			
		}
	}


/* Redirect to the account page. */
header('Location: /');
exit;	

?>
