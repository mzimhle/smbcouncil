<?php
/* Add this on all pages on top. */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']).PATH_SEPARATOR.realpath($_SERVER['DOCUMENT_ROOT']).'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'class/areapost.php';

$areapostObject	= new class_areapost();

$results 				= array();
$list						= array();	

if(isset($_REQUEST['term'])) {

	$q			= trim($_REQUEST['term']); 

	$filter		= "areapost.areapost_suburb like '%$q%'";
	
	$areaData	= $areapostObject->getAll($filter, 'areapost.areapost_city desc, areapost.areapost_suburb', 20);	
	
	if($areaData) {
		for($i = 0; $i < count($areaData); $i++) {
			$list[] = array(
				"id" 		=> $areaData[$i]["areapost_code"],
				"label" 	=> $areaData[$i]['areapost_suburb'].', '.$areaData[$i]['areapost_city'].', '.$areaData[$i]['areapost_box'],
				"box" 		=> $areaData[$i]['areapost_box'],
				"suburb"	=> $areaData[$i]['areapost_suburb']
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