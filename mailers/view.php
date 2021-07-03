<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';

$array = explode('/',$_SERVER['REQUEST_URI']);

if (isset($array[3]) && trim($array[3]) != '') {

	/* objects. */
	require_once 'class/_comm.php';

	$commObject	= new class_comm();
	
	$code = trim($array[3]);
	
	$commData = $commObject->getByCode($code);

	if($commData) {
		echo $commData['_comm_html']; exit;
	} else {
		header('Location: /');
		exit;
	}
} else {
	header('Location: /');
	exit;
}

