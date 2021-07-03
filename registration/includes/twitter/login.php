<?php 

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/* include the Zend class for Authentification */

/* Start session and load library. */
require_once('Zend/Session.php');

require_once 'config/database.php';

require_once('twitter/twitteroauth.php');
require_once('global_functions.php');

$zfsession = new Zend_Session_Namespace('FrontSubscriber');

/* Build TwitterOAuth object with client credentials. */
$twitteroauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
 
/* Get temporary credentials. */
$request_token = $twitteroauth->getRequestToken(OAUTH_CALLBACK);

/* Save temporary credentials to session. */
$zfsession->oauth_token			= $request_token['oauth_token'];
$zfsession->oauth_token_secret	= $request_token['oauth_token_secret'];
 
/* If everything goes well.. */
if($twitteroauth->http_code==200) {

    /* Let's generate the URL and redirect */
    $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
    header('Location: '.$url);
	exit;
	
} else {

	/* Clean up. */
	$zfsession = $twitteroauth = $request_token = NULL; 
	UNSET($zfsession, $twitteroauth, $request_token);
}



?>