<?php

//custom account item class as account table abstraction
class class_commcampaign extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= '_commcampaign';
	protected $_primary = '_commcampaign_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data) {
        // add a timestamp
        $data['_commcampaign_added']	= date('Y-m-d H:i:s');

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
        $data['_commcampaign_updated'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }
	
	/**
	 * get job by job _commcampaign Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {		
		$select = $this->_db->select()	
					->from(array('_commcampaign' => '_commcampaign'))
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = _commcampaign._commcampaign_addedby and participant_deleted = 0')
					->where('_commcampaign_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getCode($code) {
		$select = $this->_db->select()	
					->from(array('_commcampaign' => '_commcampaign'))
					->where('_commcampaign_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;	
	}
	
	public function getAll($where = '_commcampaign_deleted = 0', $order = '_commcampaign._commcampaign_name DESC') {
		
		$select = $this->_db->select()	
					->from(array('_commcampaign' => '_commcampaign'))
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = _commcampaign._commcampaign_addedby and participant_deleted = 0')
					->where($where)
					->order($order);						

        $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;		
	}
}
?>