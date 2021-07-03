<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/** Check for login */
require_once 'administration/includes/auth.php';
require_once 'class/calendartype.php';

$calendartypeObject = new class_calendartype();

if(isset($_GET['code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$success					= NULL;
	$code						= trim($_GET['code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['calendartype_deleted'] = 1;
		
		$where	= $calendartypeObject->getAdapter()->quoteInto('calendartype_code = ?', $code);
		$success	= $calendartypeObject->update($data, $where);
		
		if($success) {
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

/* Setup Pagination. */
$calendartypeData = $calendartypeObject->getAll("calendartype.calendartype_deleted = 0",'calendartype_added DESC');
if($calendartypeData) $smarty->assign('calendartypeData', $calendartypeData);

/* End Pagination Setup. */
$smarty->display('administration/calendar/types/default.tpl');

?>