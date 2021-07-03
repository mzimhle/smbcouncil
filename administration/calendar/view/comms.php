<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Other resources. */
require_once 'administration/includes/auth.php';

require_once 'class/calendar.php';
require_once 'class/_comm.php';

$calendarObject	= new class_calendar();
$commObject 		= new class_comm();		

if (!empty($_GET['code']) && $_GET['code'] != '') {

	$code = trim($_GET['code']);

	$calendarData = $calendarObject->getByCode($code);

	if($calendarData) {
		$smarty->assign('calendarData', $calendarData);
		
		$commData = $commObject->getByReference('calendar-'.$code);

		if($commData) {
			$smarty->assign('commData', $commData);
		}

	} else {
		header('Location: /administration/calendar/view/');
		exit;
	}
} else {
	header('Location: /administration/calendar/view/');
	exit;
}

 /* Display the template  */	
$smarty->display('administration/calendar/view/comms.tpl');
?>