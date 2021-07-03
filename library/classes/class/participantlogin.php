<?php

require_once '_comm.php';

//custom account item class as account table abstraction
class class_participantlogin extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= 'participantlogin';
	protected $_comm				= null;
	
	function init()	{
		$this->_comm				= new class_comm();
	}
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	
	public function insertLogin($data, $type, $participantcode) {
        // add a timestamp
		$indata												= array();
        $indata['participantlogin_added']			= date('Y-m-d H:i:s');
        $indata['participantlogin_code']			= $this->createReference();
		$indata['participantlogin_hashcode'] 	= md5(date('Y-m-d H:i:s'));
		$indata['participantlogin_password'] 	= $this->createPassword();
		$indata['participant_code']					= $participantcode;
		
		switch($type) {
			case 'FACEBOOK' :
				$indata['participantlogin_id']				= isset($data['id']) && trim($data['id']) != '' ? trim($data['id']) : null;
				$indata['participantlogin_name'] 			= isset($data['first_name']) && trim($data['first_name']) != '' ? trim($data['first_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['last_name']) && trim($data['last_name']) != '' ? trim($data['last_name']) : null;
				$indata['participantlogin_url']				= isset($data['link']) && trim($data['link']) != '' ? trim($data['link']) : null;
				$indata['participantlogin_username']	= isset($data['email']) && trim($data['email']) != '' ? trim($data['email']) : null;
				$indata['participantlogin_location']		= isset($data['location']['name']) && trim($data['location']['name']) != '' ? trim($data['location']['name']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_type']	 		= $type;
				break;
			case 'EMAIL' :				
				$indata['participantlogin_name'] 			= isset($data['participantlogin_name']) && trim($data['participantlogin_name']) != '' ? trim($data['participantlogin_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participantlogin_surname']) && trim($data['participantlogin_surname']) != '' ? trim($data['participantlogin_surname']) : null;
				$indata['participantlogin_username']	= isset($data['participantlogin_username']) && trim($data['participantlogin_username']) != '' ? trim($data['participantlogin_username']) : null;
				$indata['participantlogin_location']		= isset($data['participantlogin_location']) && trim($data['participantlogin_location']) != '' ? trim($data['participantlogin_location']) : null;;
				$indata['participantlogin_active']	 		= isset($data['participantlogin_active']) && trim($data['participantlogin_active']) != '' ? trim($data['participantlogin_active']) : 0;
				$indata['participantlogin_type']	 		= $type;
				break;	
			case 'LINKEDIN' :
				$indata['participantlogin_id']				= $data->id;
				$indata['participantlogin_name'] 			= isset($data->{'first-name'}) && trim($data->{'first-name'}) != '' ? trim($data->{'first-name'}) : null;
				$indata['participantlogin_surname'] 	= isset($data->{'last-name'}) && trim($data->{'last-name'}) != '' ? trim($data->{'last-name'}) : null;
				$indata['participantlogin_username']	= isset($data->{'email-address'}) && trim($data->{'email-address'}) != '' ? trim($data->{'email-address'}) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_image']			= isset($data->{'picture-url'}) && trim($data->{'picture-url'}) != '' ? trim($data->{'picture-url'}) : null;
				$indata['participantlogin_type']	 		= $type;
				break;	
			case 'GOOGLE' :
				$indata['participantlogin_id']				= isset($data['participantlogin_id']) && trim($data['participantlogin_id']) != '' ? trim($data['participantlogin_id']) : null;
				$indata['participantlogin_name'] 			= isset($data['participantlogin_name']) && trim($data['participantlogin_name']) != '' ? trim($data['participantlogin_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participantlogin_surname']) && trim($data['participantlogin_surname']) != '' ? trim($data['participantlogin_surname']) : null;
				$indata['participantlogin_url']				= isset($data['participantlogin_url']) && trim($data['participantlogin_url']) != '' ? trim($data['participantlogin_url']) : null;
				$indata['participantlogin_username']	= isset($data['participantlogin_username']) && trim($data['participantlogin_username']) != '' ? trim($data['participantlogin_username']) : null;
				$indata['participantlogin_location']		= isset($data['participantlogin_location']) && trim($data['participantlogin_location']) != '' ? trim($data['participantlogin_location']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_type']	 		= $type;
				break;				
		}

		$participantlogincode =  parent::insert($indata);	
		
		if($participantlogincode) {
		
			$participantloginData = $this->getByCode($participantlogincode);
			
			if($participantloginData) {
				
				$participantloginData['reference'] = 'PARTICIPANT_REGISTER';
				
				if($type == 'EMAIL') {
					$this->_comm->sendEmail($participantloginData, null, 'SMB COUNCIL Member Registration Confirmation', 'mailers/participant_register.html');			
				} else {
					$this->_comm->sendEmail($participantloginData, null, 'SMB COUNCIL Member Registration', 'mailers/participant_register.html');	
				}		
						
			}
		}
		
		return $participantlogincode;
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function updateLogin($data, $where, $type)
    {
        // add a timestamp
		$indata											= array();
        $indata['participantlogin_updated'] 	= date('Y-m-d H:i:s');
        
		switch($type) {
			case 'FACEBOOK' :
				$indata['participantlogin_id']				= isset($data['id']) && trim($data['id']) != '' ? trim($data['id']) : null;
				$indata['participantlogin_name'] 			= isset($data['first_name']) && trim($data['first_name']) != '' ? trim($data['first_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['last_name']) && trim($data['last_name']) != '' ? trim($data['last_name']) : null;
				$indata['participantlogin_url']				= isset($data['link']) && trim($data['link']) != '' ? trim($data['link']) : null;
				$indata['participantlogin_username']	= isset($data['email']) && trim($data['email']) != '' ? trim($data['email']) : null;
				$indata['participantlogin_location']		= isset($data['location']['name']) && trim($data['location']['name']) != '' ? trim($data['location']['name']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_lastlogin'] 		= date('Y-m-d H:i:s');
				break;	
			case 'EMAIL' :			
				$indata['participantlogin_name'] 			= isset($data['participantlogin_name']) && trim($data['participantlogin_name']) != '' ? trim($data['participantlogin_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participantlogin_surname']) && trim($data['participantlogin_surname']) != '' ? trim($data['participantlogin_surname']) : null;
				$indata['participantlogin_username']	= isset($data['participantlogin_username']) && trim($data['participantlogin_username']) != '' ? trim($data['participantlogin_username']) : null;
				$indata['participantlogin_location']		= isset($data['participantlogin_location']) && trim($data['participantlogin_location']) != '' ? trim($data['participantlogin_location']) : null;;
				$indata['participantlogin_active']	 		= isset($data['participantlogin_active']) && trim($data['participantlogin_active']) != '' ? trim($data['participantlogin_active']) : 0;
				$indata['participantlogin_type']	 		= $type;
				break;		
			case 'LINKEDIN' :
				$indata['participantlogin_id']				= $data->id;
				$indata['participantlogin_name'] 			= isset($data->{'first-name'}) && trim($data->{'first-name'}) != '' ? trim($data->{'first-name'}) : null;
				$indata['participantlogin_surname'] 	= isset($data->{'last-name'}) && trim($data->{'last-name'}) != '' ? trim($data->{'last-name'}) : null;
				$indata['participantlogin_username']	= isset($data->{'email-address'}) && trim($data->{'email-address'}) != '' ? trim($data->{'email-address'}) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_image']			= isset($data->{'picture-url'}) && trim($data->{'picture-url'}) != '' ? trim($data->{'picture-url'}) : null;
				$indata['participantlogin_type']	 		= $type;
				$indata['participantlogin_lastlogin'] 		= date('Y-m-d H:i:s');
				break;		
			case 'GOOGLE' :
				$indata['participantlogin_id']				= isset($data['participantlogin_id']) && trim($data['participantlogin_id']) != '' ? trim($data['participantlogin_id']) : null;
				$indata['participantlogin_name'] 			= isset($data['participantlogin_name']) && trim($data['participantlogin_name']) != '' ? trim($data['participantlogin_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participantlogin_surname']) && trim($data['participantlogin_surname']) != '' ? trim($data['participantlogin_surname']) : null;
				$indata['participantlogin_url']				= isset($data['participantlogin_url']) && trim($data['participantlogin_url']) != '' ? trim($data['participantlogin_url']) : null;
				$indata['participantlogin_username']	= isset($data['participantlogin_username']) && trim($data['participantlogin_username']) != '' ? trim($data['participantlogin_username']) : null;
				$indata['participantlogin_location']		= isset($data['participantlogin_location']) && trim($data['participantlogin_location']) != '' ? trim($data['participantlogin_location']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_type']	 		= $type;
				$indata['participantlogin_lastlogin'] 		= date('Y-m-d H:i:s');
				break;						
		}
		
        return parent::update($indata, $where);
    }
	
	public function notifyRegistration($participantlogincode) {
		
		$result = false;
		
		$participantloginData = $this->getByCode($participantlogincode);

		if($participantloginData) {
			
			$participantloginData['reference'] = 'PARTICIPANT_REGISTER';

			/* Send email confirmation */
			$result = $this->_comm->sendEmail($participantloginData, '', 'SMBCouncil Registration Confirmation', 'mailers/participant_register.html', null);

		}
		return $result;
	}
	
	public function getAll($where, $order)	{
	
		$select = $this->_db->select()	
						->from(array('participantlogin' => 'participantlogin'))
						->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code and participant_deleted = 0')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = participant.participant_code and mailinglist_deleted = 0 and mailinglist_category = 'participant'")
						->where($where)
						->where('participantlogin_deleted = 0')
						->order($order);

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	   
	}
	
	/**
	 * get all administrators ordered by column name
	 * example: $collection->getAlladministrators('administrator_title');
	 * @param string $order
     * @return object
	 */
	public function checkLogin($username = '', $password= ''){
		$select = $this->_db->select()	
							->from(array('participantlogin' => 'participantlogin'))
							->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code and participant_deleted = 0')
							->joinLeft('mailinglist', "mailinglist.mailinglist_reference = participant.participant_code and mailinglist_deleted = 0 and mailinglist_category = 'participant'")
							->where('participantlogin_username = ?', $username)
							->where('participantlogin_active = 1')
							->where('participantlogin_deleted = 0')
							->where("participantlogin_type in('EMAIL', 'SMS')")
							->where('participantlogin_password = ?', $password);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get all administrators ordered by column name
	 * example: $collection->getAlladministrators('administrator_title');
	 * @param string $order
     * @return object
	 */
	public function checkUsername($username, $type, $check = true){
			
			/* We are checking if the username exists by type of login */
			if($check == true) {
				$select = $this->_db->select()	
									->from(array('participantlogin' => 'participantlogin'))
									->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
									->joinLeft('mailinglist', "mailinglist.mailinglist_reference = participant.participant_code and mailinglist_deleted = 0 and mailinglist_category = 'participant'")
									->where('participantlogin_username = ?', $username)
									->where('participantlogin_deleted = 0')
									->where('participant_deleted = 0')
									->where("participantlogin_type = ?", $type);				
		} else {
			/* We are checking if current username already exist so that we can link the participantcode to it. */
			$select = $this->_db->select()	
								->from(array('participantlogin' => 'participantlogin'))
								->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
								->joinLeft('mailinglist', "mailinglist.mailinglist_reference = participant.participant_code and mailinglist_deleted = 0 and mailinglist_category = 'participant'")
								->where('participantlogin_username = ?', $username)
								->where('participantlogin_deleted = 0')
								->where('participant_deleted = 0')
								->where("participantlogin_type != ?", $type);					
		}
		
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get job by job mailinglist Id
 	 * @param string job id
     * @return object
	 */
	public function getByHash($code, $activate) {	
		$select = $this->_db->select()	
					->from(array('mailinglist' => 'mailinglist'))
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = mailinglist.mailinglist_reference and participant_deleted = 0')
					->joinLeft(array('participantlogin' => 'participantlogin'), 'participantlogin.participant_code = participant.participant_code')
					->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = mailinglist.areapost_code')
					->where('mailinglist.mailinglist_hashcode = ?', $code)
					->where('participantlogin_deleted = 0')
					->where('participantlogin.participantlogin_active = ?', $activate)
					->group('mailinglist.mailinglist_code')
					->limit(1);
		
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;	      
	}
	
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function checkEmail($email, $code = null) {	
	
		if($code == null) {
			$select = $this->_db->select()	
								->from(array('participantlogin' => 'participantlogin'))	
								->where('participantlogin_username = ?', $email)
								->where('participantlogin_deleted = 0');
		} else {
			$select = $this->_db->select()	
								->from(array('participantlogin' => 'participantlogin'))	
								->where('participantlogin_username = ?', $email)
								->where('participant_code != ?', $code)
								->where('participantlogin_deleted = 0');
			
		}
		
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($reference) {
		$select = $this->_db->select()	
						->from(array('participantlogin' => 'participantlogin'))	
						->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code and participant_deleted = 0')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = participant.participant_code and mailinglist_deleted = 0 and mailinglist_category = 'participant'")
						->where('participantlogin_code = ?', $reference)
						->where('participantlogin_deleted = 0')
						->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByParticipant($code) {
		$select = $this->_db->select()	
						->from(array('participantlogin' => 'participantlogin'))	
						->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code and participant_deleted = 0')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = participant.participant_code and mailinglist_deleted = 0 and mailinglist_category = 'participant'")
						->where('participantlogin.participant_code = ?', $code)
						->where('participantlogin_deleted = 0');

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
						->from(array('participantlogin' => 'participantlogin'))	
					   ->where('participantlogin_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createPassword() {
		/* New reference. */
		$password = "";
		$codeAlphabet = "abcdefghigklmnopqrstuvwxyz";
		$codeAlphabet .= "0123456789";
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<6;$i++){
			$password .= $codeAlphabet[rand(0,$count)];
		}
		
		return $password;

	}
	
	
	function createReference() {
		/* New reference. */
		$reference = "";
		// $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = '123456789';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
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
}
?>