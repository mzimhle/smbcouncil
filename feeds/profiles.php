<?php
/* Add this on all pages on top. */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']).PATH_SEPARATOR.realpath($_SERVER['DOCUMENT_ROOT']).'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/mailinglist.php';

$mailinglistObject	= new class_mailinglist();

$results 				= array();
$list						= array();	

if(isset($_REQUEST['term'])) {

	$q			= trim($_REQUEST['term']); 
	
	$areaData	= $mailinglistObject->search($q, 'profile');	
	
	if($areaData) {
		for($i = 0; $i < count($areaData); $i++) {
			$list[] = array(
				"id" 		=> $areaData[$i]["mailinglist_code"],
				"label" 	=> $areaData[$i]['mailinglist_name'].', '.$areaData[$i]['mailinglist_email'].', '.$areaData[$i]['mailinglist_cellphone'],
				"name"	=> $areaData[$i]['mailinglist_name'].', '.$areaData[$i]['mailinglist_email'].', '.$areaData[$i]['mailinglist_cellphone']
			);			
		}	
	}
}

if(count($list) > 0) {
	echo json_encode($list); 
	exit;
} else {
	echo json_encode(array('id' => '', 'label' => 'no results')); 
	exit;
}
exit;

?>