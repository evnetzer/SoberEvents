<?php
class RegisteredFor 
{
	public $_eventId;
	public $_userId;

	function EventId($eid) {
		if ($eid) {
			$this->_eventId = $eid;
		}	
		return $this->_eventId;
	}
	
	function UserId($uid) {
		if ($uid) {
			$this->_userId = $uid;
		}	
		return $this->_userId;
	}
	
	public function Save()  {
		if($this->_eventId AND $this->_userId ) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO RegisteredFor (userId, eventId) " .
				"VALUES (:userId, :eventId)");
			$successful = $preparedStatement->execute(array(':userId' => $this->_userId, ':eventId' => $this->_eventId));
		}
	}
	
	public static function GetEventIdsByUserId($UID){
		$preparedStatement = DB::Prepare(
			"SELECT eventId " .
			"FROM RegisteredFor " .
			"WHERE userId = :UID"
			);
		$preparedStatement->execute(array(':UID' => $UID));
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
		$eventIds = array();
		foreach($rows as $row){
			$RF = new RegisteredFor();
			$RF->_eventId=$row['eventId'];
			$RF->_userId=$UID;
			$eventIds[]=$RF;
			//$eventIds[]=$row['eventId'];
		}
		return $eventIds;
	}
	
	

	
	

	public function ToAssocArray() 
	{
		$arr = array ( 'eventId' => $this->_eventId, 'userId'=> $this->_userId);
		return $arr;
	}
	
	
}