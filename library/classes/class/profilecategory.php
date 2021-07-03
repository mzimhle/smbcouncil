<?php

//custom enquiry item class as enquiry table abstraction
class class_profilecategory extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'profilecategory';
	protected $_primary = 'profilecategory_code';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp        
        $data['profilecategory_added'] = date('Y-m-d H:i:s');
        $data['profilecategory_code'] = $this->createReference();
		        
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
        $data['profilecategory_updated'] = date('Y-m-d H:i:s');        
		
        return parent::update($data, $where);
    }
	
	public function getAll($where = 'profilecategory.profilecategory_deleted = 0', $order = 'profilecategory_added DESC') {
	
		$select = $this->_db->select() 
					   ->from(array('profilecategory' => 'profilecategory'))
					   ->where($where)
					   ->order($order);

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * Get all jobSections as pairs.
	 * example: $jobSections = $collection->jobSectionPairs();
     * @return array
	 */
	 public function pairs() {
		$select = $this->_db->select()
						->from(array('profilecategory' => 'profilecategory'), array('profilecategory_code', 'profilecategory_name'))
					   ->where('profilecategory_active = 1 AND profilecategory_deleted = 0')
					   ->order('profilecategory_name ASC');

		$result =  $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function getByCode( $code )
	{
		$select = $this->select() 
						->from(array('profilecategory' => 'profilecategory'))
					    ->where('profilecategory_code = ? ', $code)
					    ->limit(1);
					   
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getCode($code) {
	
		$select = $this->_db->select() 
					   ->from(array('profilecategory' => 'profilecategory'))
					   ->where('profilecategory.profilecategory_code = ?', $code)
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