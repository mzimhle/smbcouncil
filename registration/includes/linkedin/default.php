<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/* include the Zend class for Authentification */

/* Start session and load library. */
require_once('Zend/Session.php');

require_once 'config/database.php';
require_once 'config/smarty.php';

// include the LinkedIn class
require_once('global_functions.php');

require_once('api/linkedin/linkedin_3.2.0.class.php');
 
// display constants
$API_CONFIG = array(
	'appKey'		=> LNK_APP_KEY,
	'appSecret'	=> LNK_APP_SECRET,
	'callbackUrl'	=> LNK_CALL_BACK_URL
);

$zfsession = new Zend_Session_Namespace('FrontendUser');

define('CONNECTION_COUNT', 20);
define('DEFAULT_COMPANY_SEARCH', 'Microsoft');
define('PORT_HTTP', '80');
define('PORT_HTTP_SSL', '443');
define('UPDATE_COUNT', 10);

$_REQUEST[LINKEDIN::_GET_TYPE] = (isset($_REQUEST[LINKEDIN::_GET_TYPE])) ? $_REQUEST[LINKEDIN::_GET_TYPE] : '';

/**
* Handle user initiated LinkedIn connection, create the LinkedIn object.
*/

// check for the correct http protocol (i.e. is this script being served via http or https)
if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS'] == 'on') {
	$protocol = 'https';
} else {
	$protocol = 'http';
}
  
// set the callback url
$API_CONFIG['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '').$_SERVER['PHP_SELF'] . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';

$OBJ_linkedin = new LinkedIn($API_CONFIG);

// check for response from LinkedIn
$_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';

if(!$_GET[LINKEDIN::_GET_RESPONSE]) {

	// LinkedIn hasn't sent us a response, the user is initiating the connection

	// send a request for a LinkedIn access token
	$response = $OBJ_linkedin->retrieveTokenRequest();

	if($response['success'] === TRUE) {
	  
	  // store the request token
	  $zfsession->linkedin = $response['linkedin'];	  
	  
	  
	  // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
	  header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
	  
	} else {
		/* Something wrongw with the token. */
		header('Location: /404/');
		exit;	
	}
	
} else {
	
	
	if(isset($_GET['oauth_verifier'])) {
		
		// LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
		$response = $OBJ_linkedin->retrieveTokenAccess($zfsession->linkedin['oauth_token'], $zfsession->linkedin['oauth_token_secret'], $_GET['oauth_verifier']);

		if($response['success'] === TRUE) {

			// the request went through without an error, gather user's 'access' tokens
			$zfsession->linkedin['access'] = $response['linkedin'];

			// set the user as authorized for future quick reference
			$zfsession->linkedin['authorized'] = TRUE;
			
			$userprofile = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address)');
					
			if($userprofile['success'] === TRUE) {
				
				/* objects. */
				require_once 'class/_comm.php';
				require_once 'class/participant.php';
				require_once 'class/participantlogin.php';

				/* Get Object. */
				$participantObject 			= new class_participant();
				$participantloginObject 	= new class_participantlogin();
				$commObject 				= new class_comm();
				
				$response = new SimpleXMLElement($userprofile['linkedin']);
				
				/* Check data exists. */			
				$linkedinData = $participantloginObject->checkUsername(trim($response->{'email-address'}), 'LINKEDIN', true);
				
				if(!$linkedinData) {
				
					/* Check if email exists in other login types, except facebook. */
					$mailinglist = $participantloginObject->checkUsername(trim($response->{'email-address'}), 'LINKEDIN', false);
						
					if(!$mailinglist) {
						$data 	= array();	
						$data['participant_name'] 					= $response->{'first-name'};
						$data['participant_surname'] 				= $response->{'last-name'};
						$data['participant_email'] 			= $response->{'email-address'};
						$data['participant_active']	 				= 1;					
						/* Insert the data. */ 
						$participantcode = $participantObject->insert($data);

					} else {						
						$participantcode = $mailinglist['participant_code'];
						
						if($mailinglist['participantlogin_type'] == 'EMAIL') {						
							/* Activate participant if the email address is that of the EMAIL type. */
							$email_data = array('participantlogin_active' => 1);
							$email_where = $participantloginObject->getAdapter()->quoteInto('participantlogin_code = ?', $mailinglist['participantlogin_code']);
							$email_success = $participantloginObject->update($email_data, $email_where);
							
							/* Activate account and stay on this page. */
							$email_data = $email_where = null; $email_data = array('participant_active' => 1, 'participant_code' => $mailinglist['participant_code']);
							$email_where = $participantObject->getAdapter()->quoteInto('participant_code = ?', $mailinglist['participant_code']);
							$email_success = $participantObject->update($email_data, $email_where);
						}						
					}
					
					/* Insert the login data. */ 
					$participantlogincode = $participantloginObject->insertLogin($response, 'LINKEDIN', $participantcode);						
					
				} else {
					
					$where = null; $where = array();
					$where[] = $participantloginObject->getAdapter()->quoteInto('participantlogin_username = ?', trim($response->{'email-address'}));
					$where[] = $participantloginObject->getAdapter()->quoteInto('participantlogin_type = ?', 'LINKEDIN');
					$where[] = $participantloginObject->getAdapter()->quoteInto('participant_code = ?', $linkedinData['participant_code']);
					$participantloginObject->updateLogin($response, $where, 'LINKEDIN');
					
					$participantlogincode = $linkedinData['participantlogin_code'];			
				}
				
				/* Setup the login variables. */
				$zfsession->identity	= $participantlogincode;
				
				// redirect the user back to the demo page
				header('Location: /registration/complete/');	
				exit;
			
			} else {				
				// redirect the user back to the demo page
				header('Location: /');
				exit;
			}
		} else {
			// redirect the user back to the demo page
			header('Location: /');
			exit;
		}
	} else {
		// redirect the user back to the demo page
		header('Location: /');
		exit;
	}
}
?>