<?php


class Profile 
{
	public $_profileId;
	public $_uId;
	public $_interest;
	public $_soberLength;
	public $_personalStatement;

	function Id() {
		return $this->_profileId;
	}
	
	public function UId($uid){
		if ($uid) {
			$this->_uId = $uid;
		}	
		return $this->_uId;
	} 
	
	public function Interest($interest) {
		if ($interest) {
			$this->_interest = $interest;
		}	
		return $this->_interest;
	}
	
	public function SoberLength($soberLength) {
		if ($soberLength) {
			$this->_soberLength = $soberLength;
		}	
		return $this->_soberLength;
	}
	
	public function PersonalStatement($personalStatement) {
		if ($personalStatement) {
			$this->_personalStatement = $personalStatement;
		}	
		return $this->_personalStatement;
	}
	
		
	public function Save()  {
		
		if($this->_interest AND $this->_soberLength ) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO Profile (uId, interest, soberLength) " .
				"VALUES (:uId, :interest, :soberLength)");
			$successful = $preparedStatement->execute(array( ':uId' => $this->_uId, ':interest' => $this->_interest, ':soberLength' => $this->_soberLength));
/*
			if ($successful) {
				$this->_userId = (int)DB::LastInsertId();
				return $this->_userId;
			} 
			else
			{
				return NULL;
			}
			*/
		}
	}
	public function SavePersonalStatement()  {
		
		if($this->_personalStatement) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"UPDATE Profile
				SET PersonalStatement=:personalStatement
				WHERE uId=:uId");
			$successful = $preparedStatement->execute(array( ':uId' => $this->_uId, ':personalStatement' => $this->_personalStatement));

		}
	}
	/*
	public static function FindContentsByTopicId($topicId) {
		$preparedStatement = DB::Prepare(
			"SELECT p.comment, p.datetime, u.email, p.song_file, p.artwork_file " .
			"FROM posts p, users u " .
			"WHERE p.topic_id = :topicId AND p.user_id = u.id " .
			"ORDER BY p.id ");

		$successful = $preparedStatement->execute(array(':topicId' => $topicId));
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
		
		$contents = array();
		foreach ($rows as $row) {
			$content = new Content();
			$content->_comment = $row['comment'];
			$content->_datetime = date_create($row['datetime']);
			$content->_email = $row['email'];
			$content->_songFile = $row['song_file'];
			$content->_artworkFile =  $row['artwork_file'];
			
			$contents[] = $content;
		}
		return $contents;
		
	}
}
	*/
	public static function GetProfile($UID){
		$preparedStatement = DB::Prepare(
			"SELECT personalStatement, interest, soberLength " .
			"FROM Profile " .
			"WHERE uId = :UID"
			);

		$preparedStatement->execute(array(':UID' => $UID));
		
		
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);

		$personalStatements = array();
		foreach($rows as $row){
			$profile = new Profile();
			$profile->_personalStatement = $row['personalStatement'];
			$profile->_interest = $row['interest'];	
			$profile->_soberLength = $row['soberLength'];	
			//$personalStatements[] = $profile;
			//$personalStatements[]=$row['personalStat']
			//echo($row['personalStatement']);
			$personalStatements[]=$profile;
		}
		return $profile;
	}
	
	
	
	public function SaveInterests()  {
		
		if($this->_interest) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"UPDATE Profile
				SET interest=:interest
				WHERE uId=:uId");
			$successful = $preparedStatement->execute(array( ':uId' => $this->_uId, ':interest' => $this->_interest));

		}
	}
/*	
	public static function FindAllUsers(){
		$preparedStatement = DB::Prepare(
			"SELECT * " .
			"FROM Profile");

		$preparedStatement->execute();
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);

		$profiles = array();
		foreach($rows as $row){
			$profile = new Profile();
			$user->_userId = $row['userId'];
			$user->_name = $row['name'];
			$user->_password = $row['password'];
			
			$users[] = $user;
		}
		
		return $users;
	}
	*/
	
	//havnt added PersonalStatemnt to thsi function
	public function ToAssocArray() 
	{
		$arr = array ( 'profileId'=> $this->_profileId, 'personalStatement'=>$this->_personalStatement, 'interest'=> $this->_interest, 'soberLength'=> $this->_soberLength);
		return $arr;
	}
	
	
}



	