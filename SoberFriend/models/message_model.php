<?php
class Message 
{
	public $_messageId;
	public $_toUID;
	public $_fromUID;
	public $_message;
	public $_subject;

	function Id() {
		return $this->_messageId;
	}
		
	public function ToUID($toUID) {
		if ($toUID) {
			$this->_toUID = $toUID;
		}	
		return $this->_toUID;
	}
	
	public function FromUID($fromUID) {
		if ($fromUID) {
			$this->_fromUID = $fromUID;
		}	
		return $this->_fromUID;
	}
	
	public function Message($message) {
		if ($message) {
			$this->_message = $message;
		}	
		return $this->_message;
	}
	
	public function Subject($subject) {
		if ($subject) {
			$this->_subject = $subject;
		}	
		return $this->_subject;
	}
	
	public function Save()  {
		
		if($this->_toUID AND $this->_fromUID AND $this->_message AND $this->_subject) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO Message (toUID, fromUID, message, subject) " .
				"VALUES (:toUID, :fromUID, :message, :subject)");
			$successful = $preparedStatement->execute(array(':toUID' => $this->_toUID, ':fromUID' => $this->_fromUID, ':message' => $this->_message, ':subject' => $this->_subject));
		}
	}
	
	public static function LoadMessagesById($toUID) {
		$preparedStatement = DB::Prepare(
			"SELECT M.messageId, M.fromUID, M.message, M.subject " .
			"FROM Message M " .
			"WHERE M.toUID = :toUID");
		$preparedStatement->execute(array(':toUID' => $toUID));
		
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);

		$messages = array();
		foreach($rows as $row){
			$message = new Message(1);
			$message->_messageId = $row['messageId'];
			$message->_toUID = $toUID;
			$message->_fromUID = $row['fromUID'];
			$message->_message = $row['message'];
			$message->_subject = $row['subject'];
			
			
			$messages[]=$message;
		}
		return($messages);
	}

	public function ToAssocArray() 
	{
		$arr = array ( 'messageId' => $this->_messageId, 'toUID'=> $this->_toUID, 'fromUID'=> $this->_fromUID, 'message'=> $this->_message, 'subject'=> $this->_subject );
		return $arr;
	}
	
	
}