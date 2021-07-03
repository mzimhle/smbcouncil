<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/calendarattend.php';

$calendarattendObject	= new class_calendarattend();

$page = explode('/',$_SERVER['REQUEST_URI']);
$response = isset($page[3]) && trim($page[3]) != '' ? trim($page[3]) : null;
$hashcode = isset($page[4]) && trim($page[4]) != '' ? trim($page[4]) : null;

if($response != null && $hashcode != null) {

	$attendeeData = $calendarattendObject->getByHashCode($hashcode);
	
	if($attendeeData) {
		$smarty->assign('attendeeData', $attendeeData);
	} else {
		header('Location: /');
		exit;
	}
} else {
	header('Location: /');
	exit;
}

$data = array();
$data['calendarattend_response'] = (int)$response == 1 ? 1 : 0;

$where = array();
$where[] = $calendarattendObject->getAdapter()->quoteInto('calendar_code = ?', $attendeeData['calendar_code']);
$where[] = $calendarattendObject->getAdapter()->quoteInto('calendarattend_hascode = ?', $attendeeData['calendarattend_hascode']);
$success = $calendarattendObject->update($data, $where);
	
if($response == 0) {
	$message = '<span style="color: red;">We are sorry to hear that you will not be joining us for the <b>'.$attendeeData['mailinglist_name'].'</b> event/meeting.</span>';
} else {
	$message = '<span style="color: green;">We are happy to hear that you will be joining us for the <b>'.$attendeeData['mailinglist_name'].'</b> event/meeting.</span>';
}

$smarty->assign('message', $message);
$smarty->assign('domain', $_SERVER['HTTP_HOST']);

$display = $smarty->fetch('mailers/calendar_response.html');

echo $display; exit;

?>