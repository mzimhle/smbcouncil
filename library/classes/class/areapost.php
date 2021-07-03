<?php

//custom account item class as account table abstraction
class class_areapost extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'areapost';
	protected $_primary = 'areapost_code';

	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data) {
        // add a timestamp
		//$data['areapost_code']		= $this->createReference();		

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
	 * get job by job areapost Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {		
		$select = $this->_db->select()	
					->from(array('areapost' => 'areapost'))
					->joinLeft(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code')
					->where('areapost_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get job by job areapost Id
 	 * @param string job id
     * @return object
	 */
	public function checkExists($city, $suburb, $street, $box) {		
		$select = $this->_db->select()	
					->from(array('areapost' => 'areapost'))
					->where("lower(replace(areapost_city, ' ', '')) = lower(replace(?, ' ', ''))", $city)
					->where("lower(replace(areapost_suburb, ' ', '')) = lower(replace(?, ' ', ''))", $suburb)
					->where("lower(replace(areapost_street, ' ', '')) = lower(replace(?, ' ', ''))", $street)
					->where("lower(replace(areapost_box, ' ', '')) = lower(replace(?, ' ', ''))", $box)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getAll($where = "areapost.areapost_city != ''", $order = "areapost.areapost_city desc, areapost.areapost_suburb", $limit = 10) {
	
		$select = $this->_db->select()	
					->from(array('areapost' => 'areapost'))
					->joinLeft(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code')
					->where($where)
					->order($order)
					->limit($limit);
        $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;		
	}
	
	public function getByDemarcation($code) {
	
		$select = $this->_db->select()	
					->from(array('areapost' => 'areapost'))
					->joinLeft(array('areapostregion' => 'areapostregion'), 'areapostregion.areapostregion_code = areapost.areapostregion_code')
					->where("areapost.demarcation_id = ?", $code);
					
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
						->from(array('areapost' => 'areapost'))
					   ->where('areapost_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
}
?>