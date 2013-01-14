<?php

//This class is designed to return an object containing elements from 
//USER, PROFILE, and IMAGE tables
 
class Content{
	
	public $_userId;
	public $_name;
	public $_interest;
	public $_filename;
	//public $_soberLength;
	//public $_personalStatement;
  
	public static function FindContentsById($UID){
		$preparedStatement = DB::Prepare(
			"SELECT U.name, P.interest, I.filename " .
			"FROM User U, Profile P, Image I " .
			"WHERE U.userId = :UID and U.userId=P.uId and U.userId=I.uId ");
		$preparedStatement->execute(array(':UID' => $UID));
		
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);

		$contents = array();
		foreach($rows as $row){
			$content = new Content();
			$content->_userId = $UID;
			$content->_name = $row['name'];
			$content->_interest = $row['interest'];
			$content->_filename = $row['filename'];
			
			$contents[]=$content;
		}
		return $contents;
		//return content;
	}
	
	
	public function ToAssocArray() 
	{
		$arr = array ( 'userId'=> $this->_userId, 'name'=> $this->_name,
		'interest'=> $this->_interest, 'filename'=> $this->_filename);
		
		 return $arr;
	}
	
	
	
	
	
}