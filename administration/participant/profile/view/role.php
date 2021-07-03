<?php

ini_set('max_execution_time', 2100); //300 seconds = 5 minutes

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Other resources. */
require_once 'administration/includes/auth.php';

require_once 'class/profile.php';
require_once 'class/profilecategory.php';
require_once 'class/profilerole.php';

$profileObject		= new class_profile();
$profilecategoryObject		= new class_profilecategory();
$profileroleObject 			= new class_profilerole();		

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$reference = trim($_GET['code']);

	$profileData = $profileObject->getByCode($reference);

	if($profileData) {
	
		$smarty->assign('profileData', $profileData);
		
		$profileroleData = $profileroleObject->getByProfile($reference);

		if($profileroleData) {
			$smarty->assign('profileroleData', $profileroleData);
		}
		
	} else {
		header('Location: /administration/participant/profile/view/');
		exit;
	}
} else {
	header('Location: /administration/participant/profile/view/');
	exit;
}

 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['profilerole_deleted'] = 1;
		
		$where = $profileroleObject->getAdapter()->quoteInto('profilerole_code = ?', $code);
		$success	= $profileroleObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not delete, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}


$profilecategoryPairs = $profilecategoryObject->pairs();
if($profilecategoryPairs) $smarty->assign('profilecategoryPairs', $profilecategoryPairs);


 /* Competition mail */
if(count($_POST) > 0 && !isset($_GET['delete_code'])) {

	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['profilecategory_code']) && trim($_POST['profilecategory_code']) == '') {
		$errorArray['profilecategory_code'] = 'Please select a category';
		$formValid = false;		
	} else {
		
		$checkRole = $profileroleObject->checkRole($profileData['profile_code'],  trim($_POST['profilecategory_code']));
		
		if($checkRole) {
			$errorArray['profilecategory_code'] = 'Role already added to the profile';
			$formValid = false;				
		}
	}
	
	if(count($errorArray) == 0 && $formValid == true) {		
		
		$data = array();
		$data['profile_code'] = $profileData['profile_code'];
		$data['profilecategory_code'] = trim($_POST['profilecategory_code']);

		$success = $profileroleObject->insert($data);
		
		if($success) {
			header('Location: /administration/participant/profile/view/role.php?code='.$profileData['profile_code']);	
			exit;		
		} else {
			$errorArray['profilecategory_code'] = 'We could not add the role.';
			$formValid = false;		
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);		
}


 /* Display the template  */	
$smarty->display('administration/participant/profile/view/role.tpl');
?>