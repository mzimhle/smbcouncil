<?php

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/** Check for login */
require_once 'administration/includes/auth.php';
require_once 'class/calendar.php';
require_once 'class/calendarattend.php';
require_once 'class/mailinglist.php';
require_once 'class/_comm.php';

$calendarObject 		= new class_calendar();
$calendarattendObject	= new class_calendarattend();
$mailinglistObject 			= new class_mailinglist();
$commObject 			= new class_comm();

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$reference = trim($_GET['code']);

	$calendarData = $calendarObject->getByCode($reference);
	
	if($calendarData) {
	
		$smarty->assign('calendarData', $calendarData);
		
		$attendeeData = $calendarattendObject->getByCalendarCode($calendarData['calendar_code']);
		if($attendeeData) $smarty->assign('attendeeData', $attendeeData);

	} else {
		header('Location: /administrator/calendar/view/');
		exit;		
	}
} else {
	header('Location: /administrator/calendar/view/');
	exit;		
}

if(isset($_GET['action']) && trim($_GET['action']) == 'smsall') {

	$response					= array();
	$response['result'] 		= true;
	$response['error'] 		= '';
	
	if(!isset($calendarData)) {
		$response['result'] = false;
		$response['error'] 	= 'Please select calendar event';
	}
		
	if(isset($_REQUEST['message']) && trim($_REQUEST['message']) == '') {
		$response['result'] = false;
		$response['error'] 	= 'Message required';
	} else {
		if(strlen(trim($_REQUEST['message'])) > 160) {
			$response['result'] = false;
			$response['error'] 	= 'Message character limit is 160 characters';				
		}
	}	
	
	if($response['result'] == true && $response['error'] == '') {
		
		$attendeeData = $calendarattendObject->getByCalendarCode($calendarData['calendar_code']);
		
		if($attendeeData) {
		
			for($i = 0; $i < count($attendeeData); $i++) {
				
				$attendeeData[$i]['reference'] = 'calendar-'.$calendarData['calendar_code'];
				$success = $commObject->sendSMS(trim($_REQUEST['message']) , $attendeeData[$i]);
									
				$data = array();
				$data['calendarattend_reminder'] = date('Y-m-d H:i:s');
				
				$where = array();
				$where[] = $calendarattendObject->getAdapter()->quoteInto('calendar_code = ?', $calendarData['calendar_code']);
				$where[] = $calendarattendObject->getAdapter()->quoteInto('mailinglist_code = ?', $attendeeData[$i]['mailinglist_code']);
				$success = $calendarattendObject->update($data, $where);
			}
		}	else {
			$response['result'] = false;
			$response['error'] 	= 'There are no attendees for this event';		
		}
	}
	
	echo json_encode($response);
	die();	
	
}

if(isset($_GET['action']) && trim($_GET['action']) == 'emailall') {

	$response					= array();
	$response['result'] 		= true;
	$response['error'] 		= '';
	
	if(!isset($calendarData)) {
		$response['result'] = false;
		$response['error'] 	= 'Please select calendar event';
	}
	
	if($response['result'] == true && $response['error'] == '') {
		
		$attendeeData = $calendarattendObject->getByCalendarCode($calendarData['calendar_code']);
		
		if($attendeeData) {
		
			for($i = 0; $i < count($attendeeData); $i++) {
				
				$attendeeData[$i]['reference']		= 'calendar-'.$calendarData['calendar_code'];

				$success = $commObject->sendEmail($attendeeData[$i], null, $calendarData['calendar_subject'], 'mailers/calendar.html');
				
				$data = array();
				$data['calendarattend_reminder'] = date('Y-m-d H:i:s');
				
				$where = array();
				$where[] = $calendarattendObject->getAdapter()->quoteInto('calendar_code = ?', $calendarData['calendar_code']);
				$where[] = $calendarattendObject->getAdapter()->quoteInto('mailinglist_code = ?', $attendeeData[$i]['mailinglist_code']);
				$success = $calendarattendObject->update($data, $where);
			}
		}	else {
			$response['result'] = false;
			$response['error'] 	= 'There are no attendees for this event';		
		}
	}
	
	echo json_encode($response);
	die();	
	
}

if(isset($_GET['action']) && trim($_GET['action']) == 'emailattendee') {

	$response					= array();
	$response['result'] 		= true;
	$response['error'] 		= '';
	
	
	if(!isset($_POST['attendeecode'])) {
		$response['result'] = false;
		$response['error'] 		= 'Please choose attendee';
	} else if(trim($_POST['attendeecode']) == '') {
		$response['result'] = false;
		$response['error'] 		= 'Please choose attendee';		
	}
	
	if(!isset($calendarData)) {
		$response['result'] = false;
		$response['error'] 	= 'Please select calendar event';
	}
	
	if($response['result'] == true && $response['error'] == '') {
		
		$attendeeData = $calendarattendObject->getByMailinglist(trim($_POST['attendeecode']), $calendarData['calendar_code']);
		
		if($attendeeData) {
			
			$attendeeData['reference']	=  'calendar-'.$calendarData['calendar_code'];
			$success = $commObject->sendEmail($attendeeData, null, $calendarData['calendar_subject'], 'mailers/calendar.html');
			
			if($success) {
				$data = array();
				$data['calendarattend_reminder'] = date('Y-m-d H:i:s');
				
				$where = array();
				$where[] = $calendarattendObject->getAdapter()->quoteInto('calendar_code = ?', $calendarData['calendar_code']);
				$where[] = $calendarattendObject->getAdapter()->quoteInto('mailinglist_code = ?', $attendeeData['mailinglist_code']);
				$success = $calendarattendObject->update($data, $where);
			} else {
				$response['result'] = false;
				$response['error'] 	= 'We could not send email.';				
			}
		}	else {
			$response['result'] = false;
			$response['error'] 	= 'Attendee does exist.';		
		}
	}
	
	echo json_encode($response);
	die();	
	
}

if(isset($_GET['action']) && trim($_GET['action']) == 'deleteattendee') {
	$response					= array();
	$response['result'] 		= true;
	$response['error'] 		= '';
	
	
	if(!isset($_POST['attendeecode'])) {
		$response['result'] = false;
		$response['error'] 		= 'Please choose attendee';
	} else if(trim($_POST['attendeecode']) == '') {
		$response['result'] = false;
		$response['error'] 		= 'Please choose attendee';		
	}
	
	if(!isset($calendarData)) {
		$response['result'] = false;
		$response['error'] 	= 'Please select calendar event';
	}
	
	if($response['result'] == true && $response['error'] == '') {
	
		$data = array();
		$data['calendarattend_deleted'] = 1;
		
		$where = array();
		$where[] = $calendarattendObject->getAdapter()->quoteInto('calendar_code = ?', $calendarData['calendar_code']);
		$where[] = $calendarattendObject->getAdapter()->quoteInto('mailinglist_code = ?', trim($_POST['attendeecode']));
		$success = $calendarattendObject->update($data, $where);
			
	}
	
	echo json_encode($response);
	die();	
	
}

if(isset($_GET['action']) && trim($_GET['action']) == 'addattendee') {

	$response				= array();
	$response['result'] 	= true;
	$response['attendee']	= null;
	$response['error'] 		= '';

	if(!isset($calendarData)) {
		$response['result'] = false;
		$response['error'] 		= 'Please add calendar first';
	}		

	if(!isset($_POST['mailinglistcode'])) {
		$response['result'] = false;
		$response['error'] 		= 'Please add a profile first';
	} else if(trim($_POST['mailinglistcode']) == '') {
		$response['result'] = false;
		$response['error'] 		= 'Please add a profile first';
	}
	
	if($response['result'] == true && $response['error'] == '') {
	
		$data = array();
		$data['calendar_code']	= $calendarData['calendar_code'];
		$data['mailinglist_code']	= trim($_POST['mailinglistcode']);
				
		if($calendarattendObject->insert($data)) {
			$response['attendee']	= $mailinglistObject->getByCode($data['mailinglist_code']);
		} else {
			$response['result'] = false;
			$response['error'] 		= 'We could not add the profile';		
		}
		
	}
	
	echo json_encode($response);
	die();	
}

 /* Display the template  */	
$smarty->display('administration/calendar/view/attend.tpl');
?>