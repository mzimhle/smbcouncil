<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'class/calendar.php';

$calendarObject	= new class_calendar();

$calendar		= array();
$i				= 0;
$calendarData	= $calendarObject->getAll('calendar_deleted = 0 and calendar_active = 1', 'calendar_added desc');

if($calendarData) {
	foreach($calendarData as $item) {
		
		$calendar[$i]['id']					= $i;
		$calendar[$i]['start'] 				= $item['calendar_startdate'];
		$calendar[$i]['end'] 				= $item['calendar_enddate'];
		$calendar[$i]['title']				= ' ('.$item['attendeesnumber'].'): '.$item['calendar_name'].', in '.$item['calendar_address'];
		$calendar[$i]['url']					= '/administration/calendar/view/details.php?code='.$item['calendar_code'];
		$calendar[$i]['allDay']			= false;
		$calendar[$i]['className']		= $item['calendartype_colour'];		
		$i++;
	}
}

$json = json_encode($calendar);

echo "var bookings = $json;";

?>