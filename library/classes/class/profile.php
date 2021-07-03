<?php

require_once 'mailinglist.php';

//custom account item class as account table abstraction
class class_profile extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= 'profile';
	protected $_primary	= 'profile_code';
	
	protected $_mailinglist			= null;
	
	function init()	{
		$this->_mailinglist 			= new class_mailinglist();
	}
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data, $register = false) {
        // add a timestamp
        $data['profile_added']	= date('Y-m-d H:i:s');
        $data['profile_code']		= $this->createReference();

		$success = parent::insert($data);	
		
		if($success) {
		
			$profileData = $this->getCode($success);			

			if($profileData) {
				
				/* Create a new mailerlist record. */
				$this->_mailinglist->insertMailinglist('profile', $profileData);
				
			}
		}
		
		return $success;
    }
	
    public function update(array $data, $where) {
        // add a timestamp
        $data['profile_updated'] 		= date('Y-m-d H:i:s');
				
        $success = parent::update($data, $where);

		$tempData = $this->getByCode($data['profile_code']);
		
		$this->_mailinglist->updateMailinglist('profile', $tempData);
				
		return $success;
    }
	
	public function getAll($where, $order)	{
	
		$select = $this->_db->select()	
						->from(array('profile' => 'profile'))
						->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = profile.profile_code and mailinglist.mailinglist_category = 'profile'")
						->where($where)
						->where('profile_deleted = 0')
						->order($order);
	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
						->from(array('profile' => 'profile'))	
						->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = profile.profile_code and mailinglist.mailinglist_category = 'profile'")
						->where('profile.profile_code = ?', $code)
						->where('profile_deleted = 0')
						->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
						->from(array('profile' => 'profile'))	
						->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
					   ->where('profile_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createReference() {
		/* New reference. */
		$code = "";
		$codeAlphabet = '123456789';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $code;
		}
	}

	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getFile($file)
	{
		$select = $this->_db->select()	
						->from(array('profile' => 'profile'))	
						->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
					   ->where('profile_image_name = ?', $file)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createFile() {
		/* New reference. */
		$code = "";
		$codeAlphabet = '123456789';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<15;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getFile($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createFile();
		} else {
			return $code;
		}
	}
	
	/**
	 * get job by job profile Id
 	 * @param string job id
     * @return object
	 */
	public function getByEmail($cell, $code = null) {
	
		if($code == null) {
			$select = $this->_db->select()	
						->from(array('profile' => 'profile'))	
						->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = profile.profile_code and mailinglist.mailinglist_category = 'profile'")
						->where('profile_cellphone = ?', $cell)
						->where('profile_deleted = 0')
						->limit(1);
       } else {
			$select = $this->_db->select()	
						->from(array('profile' => 'profile'))	
						->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = profile.profile_code and mailinglist.mailinglist_category = 'profile'")
						->where('profile_cellphone = ?', $cell)
						->where('profile.profile_code != ?', $code)
						->where('profile_deleted = 0')
						->limit(1);		
	   }
	   
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job profile Id
 	 * @param string job id
     * @return object
	 */
	public function getByCell($cell, $code = null) {
	
		if($code == null) {
			$select = $this->_db->select()	
						->from(array('profile' => 'profile'))	
						->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = profile.profile_code and mailinglist.mailinglist_category = 'profile'")
						->where('profile_cellphone = ?', $cell)
						->where('profile_deleted = 0')
						->limit(1);
       } else {
			$select = $this->_db->select()	
						->from(array('profile' => 'profile'))	
						->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
						->joinLeft('mailinglist', "mailinglist.mailinglist_reference = profile.profile_code and mailinglist.mailinglist_category = 'profile'")
						->where('profile_cellphone = ?', $cell)
						->where('profile.profile_code != ?', $code)
						->where('profile_deleted = 0')
						->limit(1);		
	   }
	   
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get job by job profile Id
 	 * @param string job id
     * @return object
	 */
	public function getByIDnumber($idnumber, $code = null) {
		if($code == null) {
		$select = $this->_db->select()	
					->from(array('profile' => 'profile'))	
					->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
					->joinLeft('mailinglist', "mailinglist.mailinglist_reference = profile.profile_code and mailinglist.mailinglist_category = 'profile'")
					->where('profile_idnumber = ?', $idnumber)
					->where('profile_deleted = 0')
					->limit(1);
       } else {
		$select = $this->_db->select()	
					->from(array('profile' => 'profile'))	
					->joinLeft('areapost', 'areapost.areapost_code = profile.areapost_code')
					->joinLeft('mailinglist', "mailinglist.mailinglist_reference = profile.profile_code and mailinglist.mailinglist_category = 'profile'")
					->where('profile_idnumber = ?', $idnumber)
					->where('profile.profile_code != ?', $code)
					->where('profile_deleted = 0')
					->limit(1);		
	   }
	   
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function validateIDnumber($idnr) {	
		if(strlen(trim($idnr)) == 13) {
			if(preg_match('/([0-9][0-9])(([0][1-9])|([1][0-2]))(([0-2][0-9])|([3][0-1]))([0-9])([0-9]{3})([0-9])([0-9])([0-9])/', trim($idnr))) {
				return trim($idnr);
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
		
	public function validateEmail($string) {
		if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($string))) {
			return trim($string);
		} else {
			return '';
		}
	}
	
	public function validateCell($string) {
		if(preg_match('/^0[0-9]{9}$/', $this->onlyCellNumber(trim($string)))) {
			return $this->onlyCellNumber(trim($string));
		} else {
			return '';
		}
	}
	
	public function onlyCellNumber($string) {

		/* Remove some weird charactors that windows dont like. */
		$string = strtolower($string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("é", "", $string);
		$string = str_replace("è", "", $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace("ë", "", $string);	
		$string = str_replace('___' , '' , $string);
		$string = str_replace('__' , '' , $string);	
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("é", "", $string);
		$string = str_replace("è", "", $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace("ë", "", $string);	
		$string = str_replace("â€“", "", $string);	
		$string = str_replace("â", "", $string);	
		$string = str_replace("€", "", $string);	
		$string = str_replace("“", "", $string);	
		$string = str_replace("#", "", $string);	
		$string = str_replace("$", "", $string);	
		$string = str_replace("@", "", $string);	
		$string = str_replace("!", "", $string);	
		$string = str_replace("&", "", $string);	
		$string = str_replace(';' , '' , $string);		
		$string = str_replace(':' , '' , $string);		
		$string = str_replace('[' , '' , $string);		
		$string = str_replace(']' , '' , $string);		
		$string = str_replace('|' , '' , $string);		
		$string = str_replace('\\' , '' , $string);		
		$string = str_replace('%' , '' , $string);	
		$string = str_replace(';' , '' , $string);		
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);	
		$string = str_replace('-' , '' , $string);	
		$string = str_replace('+27' , '0' , $string);	
		$string = str_replace('(0)' , '' , $string);	
		
		$string = preg_replace('/^00/', '0', $string);
		$string = preg_replace('/^27/', '0', $string);
		
		$string = preg_replace('!\s+!',"", strip_tags($string));
		
		return $string;				
	}
}
?>