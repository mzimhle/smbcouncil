<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/** Check for login */
require_once 'administration/includes/auth.php';
require_once 'class/calendar.php';
require_once 'class/calendartype.php';

$calendarObject 		= new class_calendar();
$calendartypeObject		= new class_calendartype();

$calendartypeData = $calendartypeObject->pairs();
if($calendartypeData) { $smarty->assign('calendartypeData', $calendartypeData); }

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$reference = trim($_GET['code']);

	$calendarData = $calendarObject->getByCode($reference);
	
	if($calendarData) {
		$smarty->assign('calendarData', $calendarData);
		
	} else {
		header('Location: /administration/calendar/view/');
		exit;		
	}
} else if((isset($_GET['startdate']) && isset($_GET['enddate'])) && (trim($_GET['startdate']) == date('Y-m-d H:i', strtotime(trim($_GET['startdate'])))) && (trim($_GET['enddate']) == date('Y-m-d H:i', strtotime(trim($_GET['enddate']))))) {

	$smarty->assign('startdate', trim($_GET['startdate']));
	$smarty->assign('enddate', trim($_GET['enddate']));
}

/* Check posted data. */
if(count($_POST) > 0 && !isset($_GET['action'])) {

	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	$areaByName	= NULL;
	
	
	if(isset($_POST['calendartype_code']) && trim($_POST['calendartype_code']) == '') {
		$errorArray['calendartype_code'] = 'required';
		$formValid = false;		
	}		
	
	if(isset($_POST['calendar_name']) && trim($_POST['calendar_name']) == '') {
		$errorArray['calendar_name'] = 'required';
		$formValid = false;		
	}		
	
	if(isset($_POST['calendar_subject']) && trim($_POST['calendar_subject']) == '') {
		$errorArray['calendar_subject'] = 'required for emails';
		$formValid = false;		
	}	
	
	if(isset($_POST['calendar_startdate']) && trim($_POST['calendar_startdate']) != date('Y-m-d H:i', strtotime(trim($_POST['calendar_startdate'])))) {
		$errorArray['calendar_startdate'] = 'required';
		$formValid = false;		
	} else {
		if(isset($_POST['calendar_enddate']) && trim($_POST['calendar_enddate']) != date('Y-m-d H:i', strtotime(trim($_POST['calendar_enddate'])))) {
			$errorArray['calendar_enddate'] = 'required';
			$formValid = false;		
		} else {
			
			$startdate = strtotime(trim($_POST['calendar_startdate']));
			$enddate = strtotime(trim($_POST['calendar_enddate']));

			if($startdate > $enddate) {
				$errorArray['calendar_enddate'] = 'required';
				$formValid = false;					
			}
		}	
	}	
	
	if(isset($_POST['calendar_description']) && strlen(trim($_POST['calendar_description'])) < 10) {
		$errorArray['calendar_description'] = 'required';
		$formValid = false;
	}

	if(isset($_POST['calendar_address']) && trim($_POST['calendar_address']) == '') {
		$errorArray['calendar_address'] = 'required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		/* required.	*/
		$data['calendartype_code'] 	= trim($_POST['calendartype_code']);	
		$data['calendar_subject'] 		= trim($_POST['calendar_subject']);	
		$data['calendar_name'] 			= trim($_POST['calendar_name']);	
		$data['calendar_startdate'] 	= trim($_POST['calendar_startdate']);				
		$data['calendar_enddate'] 		= trim($_POST['calendar_enddate']);		
		$data['calendar_address'] 		= trim($_POST['calendar_address']);	
		$data['calendar_description'] 	= htmlspecialchars_decode(stripslashes(trim($_POST['calendar_description'])));	

		if(isset($calendarData)) {
			/*Update. */
			$where = $calendarObject->getAdapter()->quoteInto('calendar_code = ?', $calendarData['calendar_code']);
			$success = $calendarObject->update($data, $where);
			$success = $calendarData['calendar_code'];
		} else {
			/* Insert. */
			$success = $calendarObject->insert($data);
		}	
				
		header('Location: /administration/calendar/view/attend.php?code='.$success);
		exit;		
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
	
}

 /* Display the template  */	
$smarty->display('administration/calendar/view/details.tpl');
?>