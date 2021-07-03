<?php

//custom account item class as account table abstraction
class class_comm extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 		= '_comm';
	protected $_primary	= '_comm_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['_comm_added'] 	= date('Y-m-d H:i:s');
        $data['_comm_code'] 	= isset($data['_comm_code']) ? $data['_comm_code'] : $this->createReference();        		
		
		return parent::insert($data);		
    }
	
	/**
	 * get job by job _comm Id
 	 * @param string job id
     * @return object
	 */
	public function viewComm($code) {
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))				
					->joinLeft('mailinglist', 'mailinglist.mailinglist_code = _comm.mailinglist_code and mailinglist_deleted = 0')		
					->where('_comm_code = ?', $code)					
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	/**
	 * get job by job _comm Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{		
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))				
					->joinLeft('mailinglist', 'mailinglist.mailinglist_code = _comm.mailinglist_code and mailinglist_deleted = 0')				
					->where('_comm_code = ?', $code)					
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}

	public function getByReference($code) {
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))	
					->joinLeft('mailinglist', 'mailinglist.mailinglist_code = _comm.mailinglist_code and mailinglist_deleted = 0')	
					->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = mailinglist.areapost_code')
					->where('_comm._comm_reference = ?', $code);	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;	
	}
	
	public function getAll($where = '_comm_added != \'\'', $order = '_comm_added asc') {		
	
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))	
					->joinLeft('mailinglist', 'mailinglist.mailinglist_code = _comm.mailinglist_code and mailinglist_deleted = 0')			
					->where($where)
					->order($order);	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function createSMSBatch($commCampaign, $mailinglistData) {
		
		/* A file will be created with a batch to send out later on, a scheduled tasks will have to run every 3 minutes to send the items. */
		$stringComm =  "api_id:3476493\n";
		$stringComm .= "user:willowvine\n";
		$stringComm .= "password:DUJbgGdNRXROaA\n";
		$stringComm .= "text:Hello #field1#. ".$commCampaign['_commcampaign_message']."\n";
		$stringComm .= "reply:admin@willow-nettica.co.za\n";
		$stringComm .= "Delimiter:|\n";
						
		foreach($mailinglistData as $mailinglist) {
			$stringComm .="csv:".$this->formatCellForBatch($mailinglist['mailinglist_cellphone'])."|".$mailinglist['mailinglist_name']."\n";
			//$stringComm .="csv:27735640764|".$mailinglist['mailinglist_name']."\n";
		}
		
		/* Create afile with the batch. */		
		$file = $_SERVER['DOCUMENT_ROOT'].'/crons/comms/SMS/'.$commCampaign['_commcampaign_code'].'.txt';
		
		if(file_put_contents($file, $stringComm)) {
			return $commCampaign['_commcampaign_code'];
		} else {
			return false;
		}
	}
	
	public function formatCellForBatch($number) {		
		$ptn = "/^0/";  // Regex		
		$rpltxt = "27";  // Replacement string
		return preg_replace($ptn, $rpltxt, $number);		
	}
	
	public function sendBatchSMS($commcampaigncode) {
		
		$file = $_SERVER['DOCUMENT_ROOT'].'/crons/comms/SMS/'.$commcampaigncode.'.txt';
		
		if(file_exists($file)) {
		
			$string = file_get_contents($file);
			
			$return = $this->sendTextEmail($string, $commcampaigncode);
			
			if($return) {
				rename($file, $_SERVER['DOCUMENT_ROOT'].'/crons/comms/SMS/'.$commcampaigncode.'_sent.txt');
			}
			
			return $return;
			
		} else {
			return false;
		}
	}
	
	public function sendSMS($message, $mailinglist, $campaign = null) {		
		
		$user 			= "willowvine"; 
		$password 	= "DUJbgGdNRXROaA"; 
		$api_id 			= "3420082"; 
		$baseurl 		="http://api.clickatell.com"; 
		$text 			= urlencode($message); 
		$to 				= $mailinglist['mailinglist_cellphone']; 
		
		$successCounter	= 0;
		$failCounter			= 0;
		
		$data										= array();
		$data['_comm_code']			= $this->createReference();
		$data['mailinglist_code']		= $mailinglist['mailinglist_code'];
		$data['_comm_type']			= 'SMS';
		$data['_comm_name']		= $mailinglist['mailinglist_name'];
		$data['_comm_cellphone']	= $mailinglist['mailinglist_cellphone'];
		$data['_comm_email']		= $mailinglist['mailinglist_email'];
		$data['_comm_message']	= trim($message);
		$data['_comm_sent']			= 0;
		$data['_campaign_code']	= $campaign;
		$data['_comm_reference']	= $mailinglist['reference'];
					
		if( preg_match( "/^0[0-9]{9}$/", trim($mailinglist['mailinglist_cellphone']))) {
			
			$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id"; 

			// do auth call 
			$ret = file($url); 

			// split our response. return string is on first line of the data returned 

			$sess = explode(":",$ret[0]); 
			
			if ($sess[0] == "OK") {
			
				$sess_id = trim($sess[1]); // remove any whitespace 
				
				$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text"; 
				
				// do sendmsg call 
				$ret = file($url); 
				
				$send = explode(":",$ret[0]); 
				
				if ($send[0] == "ID") { 																						
					$data['_comm_output']	= 'Success! : '.$send[0].' : '.$send[1];
					$data['_comm_sent']		= 1;					
				} else  {
					$data['_comm_output']	= 'Send message failed : '.$send[0].' : '.$send[1];
					$data['_comm_sent']		= 0;	  
				}
			} else { 
				$data['_comm_output']	= "Authentication failure: ". $ret[0]; 
				$data['_comm_sent']		= 0;	  
			} 
		} else {
			$data['_comm_output']	=  "Invalid number ".$mailinglist['mailinglist_cellphone'];	
			$data['_comm_sent']		= 0;		  
		}
		
		$this->insert($data);
		$return = $data['_comm_sent'] == 1 ? $data['_comm_code'] : false;
		return $return;
		
	}
	
	public function sendTextEmail($message, $commcampaigncode) {
		// require 'config/smarty.php';
		global $smarty;
		
		require_once('Zend/Mail.php');
		
		$mail = new Zend_Mail();
		
		$data						= array();
		$data['_comm_code']	= $this->createReference();
		
		$mail->setFrom('admin@willow-nettica.co.za', 'Willow-Nettica'); //EDIT!!											
		$mail->addTo('sms@messaging.clickatell.com');
		$mail->addTo('admin@willow-nettica.co.za');
		$mail->setSubject('SMS Batch: '.$commcampaigncode);
		$mail->setBodyText($message);			

		/* Save data to the comms table. */
		$data['mailinglist_code']				= 'SMS-100';
		$data['_comm_type']					= 'BATCH-EMAIL';
		$data['_comm_name']				= 'clickatell';
		$data['_comm_sent']					= null;
		$data['_comm_email']				= 'sms@messaging.clickatell.com';
		$data['_comm_html']					= $message;
		$data['_commcampaign_code']	= $commcampaigncode;
		
		$this->insert($data);

		try {
			$mail->send();
			$data['_comm_sent']	= 1;	
			$data['_comm_output']	= 'Email Sent!';
			
		} catch (Exception $e) {
			$data['_comm_sent']		= 0;	
			$data['_comm_output']	= $e->getMessage();
		}
		
		$where = $this->getAdapter()->quoteInto('_comm_code = ?', $data['_comm_code']);
		$success = $this->update($data, $where);
		
		$mail = null; unset($mail);
		$return = $data['_comm_sent'] == 1 ? $data['_comm_code'] : false;
		return $return;		
	}
	
	public function sendEmail($mailinglist, $message, $subject, $file) {

		// require 'config/smarty.php';
		global $smarty;
		
		require_once('Zend/Mail.php');
		
		$mail = new Zend_Mail();
		
		$data						= array();
		$data['_comm_code']	= $this->createReference();
		
		$smarty->assign('tracking', $data['_comm_code']);
		$smarty->assign('mailinglist', $mailinglist);
		$smarty->assign('message', $message);
		$smarty->assign('domain', $_SERVER['HTTP_HOST']);
		
		$template = $smarty->fetch($file);
		
		$mail->setFrom('info@smbcouncil.org', 'SMB Council'); //EDIT!!											
		$mail->addTo($mailinglist['mailinglist_email']);
		$mail->setSubject($subject);
		$mail->setBodyHtml($template);			

		/* Save data to the comms table. */
		$data['mailinglist_code']				= $mailinglist['mailinglist_code'];
		$data['_comm_type']					= 'EMAIL';
		$data['_comm_name']				= $mailinglist['mailinglist_name'];
		$data['_comm_sent']					= null;
		$data['_comm_email']				= $mailinglist['mailinglist_email'];
		$data['_comm_html']					= $template;
		$data['_comm_reference']			= $mailinglist['reference'];
		$data['_campaign_code']	= null;

		$this->insert($data);

		try {		
			$mail->send();
			$data['_comm_sent']	= 1;	
			$data['_comm_output']	= 'Email Sent!';
			
		} catch (Exception $e) {
			$data['_comm_sent']		= 0;	
			$data['_comm_output']	= $e->getMessage();
		}
		
		$where = $this->getAdapter()->quoteInto('_comm_code = ?', $data['_comm_code']);
		$success = $this->update($data, $where);
		
		$mail = null; unset($mail);
		$return = $data['_comm_sent'] == 1 ? $data['_comm_code'] : false;
		return $return;
	}
	

	
	public function sendCampaign($mailinglistData, $campaignData) {
		
		require_once('Zend/Mail.php');
		
		$mail = null; unset($mail);
		$mail = new Zend_Mail();

		$data				= array();
		$data['_comm_code']	= $this->createReference();
		
		$message = $campaignData['_campaign_html'];
		
		$message = str_replace('[fullname]', $mailinglistData['mailinglist_name'], $message);
		$message = str_replace('[cellphone]', $mailinglistData['mailinglist_cellphone'], $message);
		$message = str_replace('[email]', $mailinglistData['mailinglist_email'], $message);
		$message = str_replace('[area]', $mailinglistData['areapost_suburb'].', '.$mailinglistData['areapost_city'].', '.$mailinglistData['areapost_box'], $message);
		$message = str_replace('[tracking]', $data['_comm_code'], $message);
		$message = str_replace('[datetime]', date("F j, Y, g:i a"), $message);
		
		if($mailinglistData['mailinglist_category'] == 'mailinglist') {
			$message = str_replace('[show]', 'block', $message);
		} else {
			$message = str_replace('[show]', 'none', $message);
		}

		$mail->setFrom('info@smbcouncil.org', 'SMB Council'); //EDIT!!
		$mail->addTo($mailinglistData['mailinglist_email']);
		$mail->setSubject($campaignData['_campaign_subject']);
		$mail->setBodyHtml($message);			

		/* Save data to the comms table. */
		$data['mailinglist_code']		= $mailinglistData['mailinglist_code'];
		$data['_comm_type']			= 'email';
		$data['_comm_email']		= trim($mailinglistData['mailinglist_email']);
		$data['_comm_cellphone']	= trim($mailinglistData['mailinglist_cellphone']);
		$data['_comm_output']		= '';
		$data['_campaign_code']	= $campaignData['_campaign_code'];
		$data['_comm_sent']			= null;
		$data['_comm_html']			= str_replace($data['_comm_code'], '', $message);
		$data['_comm_name']		= $campaignData['_campaign_name'];
		$data['_comm_reference']	= 'CAMPAIGN';

		$this->insert($data);
		$return = false;
		
		try {
			$mail->send();
			$data['_comm_sent']	= 1;
			$return = $data['_comm_code'];
			$data['_comm_output']	= 'Email Sent!';
			
		} catch (Exception $e) {
			$data['_comm_sent']	= 0;	
			$return = 0;
			$data['_comm_output']	= $e->getMessage();
		}
		
		$where = $this->getAdapter()->quoteInto('_comm_code = ?', $data['_comm_code']);
		$success = $this->update($data, $where);
		
		return $return;
	}
	
	public function getByCampaign($code) {
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))	
					->joinLeft('mailinglist', 'mailinglist.mailinglist_code = _comm.mailinglist_code and mailinglist_deleted = 0')	
					->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = mailinglist.areapost_code')
					->joinLeft(array('_tracker' => '_tracker'), '_tracker._comm_code = _comm._comm_code', array('_tracker._comm_code as _comm_count', 'IFNULL(count(_tracker._tracker_code), 0) AS _tracker'))
					->where('_comm._campaign_code = ?', $code)
					->group('_comm._comm_code');	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;	
	}
	
	public function getByMailingReference($reference, $category) {
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))	
					->joinLeft('mailinglist', 'mailinglist.mailinglist_code = _comm.mailinglist_code and mailinglist_deleted = 0')	
					->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = mailinglist.areapost_code')
					->where('mailinglist.mailinglist_reference = ?', $reference)
					->where('mailinglist.mailinglist_category = ?', $category);	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;	
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
						->from(array('_comm' => '_comm'))		
					   ->where('_comm_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;				   		
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++) {
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $reference;
		}
	}

	function reference() {
		return date('Y-m-d-H:i:s');
	}	
}
?>