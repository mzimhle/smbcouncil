<?php

//custom enquiry item class as enquiry table abstraction
class class_profilerole extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'profilerole';
	protected $_primary = 'profilerole_code';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp        
        $data['profilerole_added'] = date('Y-m-d H:i:s');
        $data['profilerole_code'] = $this->createReference();
		        
		return parent::insert($data);
    }

	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where)
    {
        // add a timestamp
        $data['profilerole_updated'] = date('Y-m-d H:i:s');        
		
        return parent::update($data, $where);
    }
	
	public function getAll($where = 'profilerole.profilerole_deleted = 0', $order = 'profilerole_added DESC') {
	
		$select = $this->_db->select() 
					   ->from(array('profilerole' => 'profilerole'))
					   ->joinLeft('profile', 'profile.profile_code = profilerole.profile_code')
					   ->joinLeft('profilecategory', 'profilecategory.profilecategory_code = profilerole.profilecategory_code')
					   ->where($where)
					   ->order($order);

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getByProfile($code) {
	
		$select = $this->_db->select() 
					   ->from(array('profilerole' => 'profilerole'))
					   ->joinLeft('profile', 'profile.profile_code = profilerole.profile_code')
					   ->joinLeft('profilecategory', 'profilecategory.profilecategory_code = profilerole.profilecategory_code')
					   ->where('profilerole.profilerole_deleted = 0')
					   ->where('profilerole.profile_code = ?', $code)
					   ->order('profilerole_added DESC');

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function checkRole($code, $role) {
	
		$select = $this->_db->select() 
					   ->from(array('profilerole' => 'profilerole'))
					   ->joinLeft('profile', 'profile.profile_code = profilerole.profile_code')
					   ->joinLeft('profilecategory', 'profilecategory.profilecategory_code = profilerole.profilecategory_code')
					   ->where('profilerole.profilerole_deleted = 0')
					   ->where('profilerole.profile_code = ?', $code)
					   ->where('profilerole.profilecategory_code = ?', $role)
					   ->order('profilerole_added DESC');

	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getByCode( $code )
	{
		$select = $this->select() 
						->from(array('profilerole' => 'profilerole'))
					    ->where('profilerole_code = ? ', $code)
					    ->limit(1);
					   
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getCode($code) {
	
		$select = $this->_db->select() 
					   ->from(array('profilerole' => 'profilerole'))
					   ->where('profilerole.profilerole_code = ?', $code)
					   ->limit(1);
					   
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	   
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		//$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i = 0; $i < 5; $i++) {
			$reference .= $codeAlphabet[rand(1,$count)];
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