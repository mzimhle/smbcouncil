<?php/* Add this on all pages on top. */set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');/*** Standard includes */require_once 'config/database.php';require_once 'config/smarty.php';/*** Check for login */require_once 'administration/includes/auth.php';/* objects. */require_once 'class/profile.php';$profileObject 	= new class_profile();if (isset($_GET['code']) && trim($_GET['code']) != '') {		$code = trim($_GET['code']);		$profileData = $profileObject->getByCode($code);		if(!$profileData) {		header('Location: /administration/participant/profile/view/');		exit;	}		$smarty->assign('profileData', $profileData);	} else {	header('Location: /administration/participant/profile/view/');	exit;}/* Check posted data. */if(count($_POST) > 0) {	$errorArray		= array();	$data 				= array();	$formValid		= true;	$success			= NULL;		if(isset($_POST['profile_page']) && trim($_POST['profile_page']) == '') {		$errorArray['profile_page'] = 'required';		$formValid = false;			}		if(count($errorArray) == 0 && $formValid == true) {						$data 	= array();						$data['profile_page']			= trim($_POST['profile_page']);				$data['profile_code']			= $profileData['profile_code'];							/*Update. */		$where		= $profileObject->getAdapter()->quoteInto('profile_code = ?', $profileData['profile_code']);		$success	= $profileObject->update($data, $where);												if(count($errorArray) == 0) {										header('Location: /administration/participant/profile/view/');				exit;				}				}		/* if we are here there are errors. */	$smarty->assign('errorArray', $errorArray);	}$smarty->display('administration/participant/profile/view/page.tpl');?>