<?php/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');/*** Standard includes */require_once 'config/database.php';
require_once 'config/smarty.php';/** * Check for login */require_once 'administration/includes/auth.php';require_once 'class/participant.php';$mailinglistObject = new class_mailinglist();  if(isset($_GET['delete_code'])) {		$errorArray				= array();	$errorArray['error']	= '';	$errorArray['result']	= 0;		$formValid				= true;	$success					= NULL;	$code						= trim($_GET['delete_code']);			if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {		$data	= array();		$data['mailinglist_deleted'] = 1;				$where = $mailinglistObject->getAdapter()->quoteInto('mailinglist_code = ?', $code);		$success	= $mailinglistObject->update($data, $where);					if(is_numeric($success) && $success > 0) {			$errorArray['error']	= '';			$errorArray['result']	= 1;					} else {			$errorArray['error']	= 'Could not delete, please try again.';			$errorArray['result']	= 0;						}	}		echo json_encode($errorArray);	exit;}/* Setup Pagination. */$mailinglistData = $mailinglistObject->getAll('mailinglist_deleted = 0 and mailinglist_category = \'mailinglist\'','mailinglist.mailinglist_added');if($mailinglistData) $smarty->assign_by_ref('mailinglistData', $mailinglistData);/* End Pagination Setup. */$smarty->display('administration/participant/subscribe/default.tpl');?>