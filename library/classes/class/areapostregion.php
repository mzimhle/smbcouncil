<?php

//custom account item class as account table abstraction
class class_areapostregion extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'areapostregion';
	protected $_primary = 'areapostregion_code';

	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data) {
        // add a timestamp
		$data['areapostregion_code']		= $this->createReference();		
		return parent::insert($data);	
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where) {
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job areapostregion Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {		
		$select = $this->_db->select()	
					->from(array('areapostregion' => 'areapostregion'))
					->joinLeft(array('demarcation' => 'demarcation'), 'demarcation.demarcation_id = areapostregion.demarcation_id')
					->where('areapostregion.areapostregion_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getByBox($box) {
		
		$select = $this->_db->select()	
					->from(array('areapostregion' => 'areapostregion'))
					->joinLeft(array('demarcation' => 'demarcation'), 'demarcation.demarcation_id = areapostregion.demarcation_id')
					->where('? between areapostregion_startbox and areapostregion_endbox', $box);
						
        $result = $this->_db->fetchRow($select);
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
						->from(array('areapostregion' => 'areapostregion'))
					   ->where('areapostregion_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createReference() {
	
		/* New reference. */
		$reference = "";
		$codeAlphabet = '0123456789';
		
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