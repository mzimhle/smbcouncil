<?php
//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('max_execution_time', 500); //300 seconds = 1 minute

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';

require_once 'class/_comm.php';
require_once 'class/_commcampaign.php';

$commObject 				= new class_comm();
$commcampaignObject 	= new class_commcampaign();

/* This is a cron job. */
/* Get list of files in the SMS batch folder. */
$files = glob($_SERVER['DOCUMENT_ROOT'].'/crons/comms/SMS/*.txt');

if(is_array($files) && count($files) > 0) {
	for($i = 0; $i < count($files); $i++) {
		
		$pos = strpos($files[$i], '_sent');
		
		if($pos === false) {
			
			$commcamaigncode = basename($files[$i],".txt");
			
			$returned = $commObject->sendBatchSMS($commcamaigncode);
			
			if($returned) {
				/* SMS sent. */
				$data = array();
				$data['_commcampaign_sent']			= 1;
				$data['_commcampaign_sentDate']	= date('Y-m-d h:i:s');
				
				$where = $commcampaignObject->getAdapter()->quoteInto('_commcampaign_code = ?', $commcamaigncode);
				$success = $commcampaignObject->update($data, $where);
				
				echo $commcamaigncode;
				exit;
			}
		}
	}
}


// var_dump($commObject->sendBatchSMS($returned));
	
?>