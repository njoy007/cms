<?php
class Application_Model_Bugs extends Zend_Db_Table_Abstract
{
	protected $_name = 'bugs';
	
	public function createBug($name, $email, $date, $url, $description, $priority, $status)
	{
		// create a new row in the bug table
		$row = $this->createRow();
		
		// Set the row data
		$row->author = $name;
		$row->email = $email;
		$dateObject = new Zend_Date($date);
		$row->date = $dateObject->get(Zend_Date::TIMESTAMP);
		$row->url = $url;
		$row->description = $description;
		$row->priority = $priority;
		$row->status = $status;
		
		// save the new row
		$row->save();
		
		// now fetch the id of the row you just created and return it
		$id = $this->_db->lastInsertId();
		return $id;	
	}
	public function fetchBugs($filters=array(), $sortField=null, $limit=null, $page=1)
	{
		$select = $this->select();
		// add any filter which are set
		if(count($filters) > 0)
		{
			foreach ($filters as $field => $filter)
			{
				$select->where($field . ' = ?', $filter);
			}
		}
		// add the sort field is it is set
		if(null != $sortField)
		{
			$select->order($sortField);
		}
		return $this->fetchAll($select);
	}
}
