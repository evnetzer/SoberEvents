<?php
class Event 
{
	public $_eventId;
	public $_title;
	public $_description;
	public $_imageId;
	public $_meetPlace;
	public $_meetTime;

	function Id() {
		return $this->_eventId;
	}
	
	public function Title($title){
		if ($title) {
			$this->_title = $title;
		}	
		return $this->_title;
	} 
	
	public function Description($description) {
		if ($description) {
			$this->_description = $description;
		}	
		return $this->_description;
	}
	
	public function ImageId($imageId) {
		if ($imageId) {
			$this->_imageId = $imageId;
		}	
		return $this->_imageId;
	}
		
	public function MeetPlace($meetPlace) {
		if ($meetPlace) {
			$this->_meetPlace = $meetPlace;
		}	
		return $this->_meetPlace;
	}
	
	public function MeetTime($meetTime) {
		if ($meetTime) {
			$this->_meetTime = $meetTime;
		}	
		return $this->_meetTime;
	}
	
	public function ToAssocArray() 
	{
		$arr = array ( 'eventId' => $this->_eventId, 'title'=> $this->_title, 'description'=> $this->_description, 
		'imageId'=> $this->_imageId, 'meetPlace'=> $this->_meetPlace, 'meetTime'=> $this->_meetTime);
		return $arr;
	}
	public function GetImageId()
	{
		return $this->_imageId;
	}
	
	public function Save()  {
		
		if($this->_title AND $this->_description ) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO Event (title, description,imageId, meetPlace, meetTime) " .
				"VALUES (:title, :description, :imageId, :meetPlace, :meetTime)");
			$successful = $preparedStatement->execute(array(':title' => $this->_title, ':description' => $this->_description, 
			':imageId' => $this->_imageId, ':meetPlace' => $this->_meetPlace, ':meetTime' => $this->_meetTime));
			if ($successful) {
				$this->_eventId = (int)DB::LastInsertId();
				return $this->_eventId;
			} 
			else
			{
				return NULL;
			}
		}
	}
	
	
	public static function GetEventById($EID){
		$preparedStatement = DB::Prepare(
			"SELECT title, description, imageId, meetPlace, meetTime " .
			"FROM Event " .
			"WHERE eId = :EID"
			);
		$preparedStatement->execute(array(':EID' => $EID));
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
		$events = array();
		foreach($rows as $row){
			$event = new Event();
			$event->_eventId=$EID;
			$event->_title = $row['title'];
			$event->_description = $row['description'];
			$event->_imageId = $row['imageId'];
			$event->_meetPlace = $row['meetPlace'];
			$event->_meetTime = $row['meetTime'];
			$events[]=$event;
		}
		return $events;
	}
	
	public static function GetAllEvents(){
		$preparedStatement = DB::Prepare(
			"SELECT eId, title, description, imageId, meetPlace, meetTime " .
			"FROM Event " 
			);
		$preparedStatement->execute();
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
		$events = array();
		foreach($rows as $row){
			$event = new Event();
			$event->_eventId=$row['eId'];
			$event->_title = $row['title'];
			$event->_description = $row['description'];
			$event->_imageId = $row['imageId'];
			$event->_meetPlace = $row['meetPlace'];
			$event->_meetTime = $row['meetTime'];
			$events[]=$event;
		}
		return $events;
	}

	
	
	
}