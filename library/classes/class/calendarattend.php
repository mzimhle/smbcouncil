<?php

//custom enquiry item class as enquiry table abstraction
class class_calendarattend extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'calendarattend';
	protected $_primary = 'calendarattend_code';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['calendarattend_added']	= date('Y-m-d H:i:s');
		$data['calendarattend_code']		= $this->createReference();
		$data['calendarattend_hascode'] = md5(date('Y-m-d h:i:s'));
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
         $data['calendarattend_updated'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }
	
	
	public function getAll() {
	
			$select = $this->_db->select()	
							->from(array('calendarattend' => 'calendarattend'))
							->joinLeft('calendar', 'calendar.calendar_code = calendarattend.calendar_code')
							->joinLeft('calendartype', 'calendartype.calendartype_code = calendar.calendartype_code')
							->joinLeft('mailinglist', 'mailinglist.mailinglist_code = calendarattend.mailinglist_code')
							->where('calendarattend_deleted = 0');

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function deleteByCalendar($calendarcode) {
		
		$where = $this->getAdapter()->quoteInto('calendar_code = ?', $calendarcode);		 
		return parent::delete($where);		
		
	}
	
	public function delete($code) {
		
		$where = $this->getAdapter()->quoteInto('calendarattend_code = ?', $code);		 
		return parent::delete($where);		
		
	}
	
	public function getByCalendarCode($code) {
	
			$select = $this->_db->select()	
							->from(array('calendarattend' => 'calendarattend'))
							->joinLeft('calendar', 'calendar.calendar_code = calendarattend.calendar_code')
							->joinLeft('calendartype', 'calendartype.calendartype_code = calendar.calendartype_code')
							->joinLeft('mailinglist', 'mailinglist.mailinglist_code = calendarattend.mailinglist_code')
							->where('calendarattend_deleted = 0')
							->where('calendarattend.calendar_code = ? ', $code);

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getAttendeeByCalendarCode($code, $calendar) {
	
			$select = $this->_db->select()	
							->from(array('calendarattend' => 'calendarattend'))
							->joinLeft('calendar', 'calendar.calendar_code = calendarattend.calendar_code')
							->joinLeft('calendartype', 'calendartype.calendartype_code = calendar.calendartype_code')
							->joinLeft('mailinglist', 'mailinglist.mailinglist_code = calendarattend.mailinglist_code')
							->where('calendarattend_deleted = 0')
							->where('calendarattend.calendarattend_user = ? ', $code)
							->where('calendarattend.calendar_code = ? ', $calendar);

	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getByMailinglist($code, $calendar) {
	
			$select = $this->_db->select()	
							->from(array('calendarattend' => 'calendarattend'))
							->joinLeft('calendar', 'calendar.calendar_code = calendarattend.calendar_code')
							->joinLeft('calendartype', 'calendartype.calendartype_code = calendar.calendartype_code')
							->joinLeft('mailinglist', 'mailinglist.mailinglist_code = calendarattend.mailinglist_code')
							->where('calendarattend_deleted = 0')
							->where('calendarattend.mailinglist_code = ? ', $code)
							->where('calendarattend.calendar_code = ? ', $calendar);

	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getByHashCode( $code ) {
	
			$select = $this->_db->select()	
							->from(array('calendarattend' => 'calendarattend'))
							->joinLeft('calendar', 'calendar.calendar_code = calendarattend.calendar_code')
							->joinLeft('calendartype', 'calendartype.calendartype_code = calendar.calendartype_code')
							->joinLeft('mailinglist', 'mailinglist.mailinglist_code = calendarattend.mailinglist_code')
							->where('calendarattend_deleted = 0')
							->where('calendarattend.calendarattend_hascode = ? ', $code);

	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getByCode( $code ) {
	
		$select = $this->select() 
						->from(array('calendarattend' => 'calendarattend'))
						->joinLeft('calendar', 'calendar.calendar_code = calendarattend.calendar_code')
						->joinLeft('calendartype', 'calendartype.calendartype_code = calendar.calendartype_code')
						->joinLeft('mailinglist', 'mailinglist.mailinglist_code = calendarattend.mailinglist_code')
						->where('calendarattend_deleted = 0')
					    ->where('calendarattend_code = ? ', $code)
					    ->limit(1);
					   
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	public function getCode($code) {
	
		$select = $this->_db->select() 
					   ->from(array('calendarattend' => 'calendarattend'))
					   ->where('calendarattend.calendarattend_code = ?', $code)
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