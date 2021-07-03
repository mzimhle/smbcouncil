<?php

//custom enquiry item class as enquiry table abstraction
class class_calendar extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'calendar';
	protected $_primary = 'calendar_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['calendar_added']		= date('Y-m-d H:i:s');
		$data['calendar_code']		= $this->createReference();
		
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
        $data['calendar_updated']	= date('Y-m-d H:i:s');        
		
        return parent::update($data, $where);
    }
	
	public function getByCode($code) {
	
		$select = $this->_db->select() 
						->from(array('calendar' => 'calendar'))
						->joinLeft('calendartype', 'calendartype.calendartype_code = calendar.calendartype_code')
						->where('calendar_deleted = 0')
						->where('calendar_code = ?', $code);
					   
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getAll($where = 'calendar.calendar_code is not null', $order = 'calendar_added desc', $list = false) {
	
		if($list) {
			$select = $this->_db->select() 
							->from(array('calendar' => 'calendar'))
							->joinLeft('calendartype', 'calendartype.calendartype_code = calendar.calendartype_code')
							->where('calendar_deleted = 0')
							->where($where)
							->order($order);
		} else {
		
			$select = "select
								calendar.*, calendartype.*, group_concat(mailinglist_name separator ', ') As attendees, count(mailinglist_name) as attendeesnumber
							from
								calendar as calendar
								left join calendartype on calendartype.calendartype_code = calendar.calendartype_code
								left join calendarattend on  calendarattend.calendar_code = calendar.calendar_code and calendarattend_active = 1 and calendarattend_deleted = 0	
								left join mailinglist on  mailinglist.mailinglist_code = calendarattend.mailinglist_code and mailinglist_deleted = 0								
							where
								calendar.calendar_deleted = 0 and $where
							group by calendar.calendar_code
							order by $order;";									
		}
		
	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getCode($code) {
	
		$select = $this->_db->select() 
					   ->from(array('calendar' => 'calendar'))
					   ->where('calendar.calendar_code = ?', $code)
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
		
		for($i = 0; $i < 10; $i++) {
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