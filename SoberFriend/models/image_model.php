<?php
class Image 
{
	public $_imageId;
	public $_uId;
	public $_filename;

	function Id() {
		return $this->_imageId;
	}
	
	public function UId($uid){
		if ($uid) {
			$this->_uId = $uid;
		}	
		return $this->_uId;
	} 
	
	public function Filename($filename) {
		if ($filename) {
			$this->_filename = $filename;
		}	
		return $this->_filename;
	}
		
	public function Save()  {
		
		if($this->_filename) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO Image (uId, filename) " .
				"VALUES (:uId, :filename)");
			$successful = $preparedStatement->execute(array( ':uId' => $this->_uId, ':filename' => $this->_filename));

			if ($successful) {
				$this->_imageId = (int)DB::LastInsertId();
				return $this->_imageId;
			} 
			else
			{
				return NULL;
			}
		
		}
	}
	
	
	public static function GetImage($UID){
		$preparedStatement = DB::Prepare(
			"SELECT filename " .
			"FROM Image " .
			"WHERE uId = :UID"
			);

		$preparedStatement->execute(array(':UID' => $UID));
		
		
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);

		$personalStatements = array();
		foreach($rows as $row){
			$image = new Image();
			$image->_filename = $row['filename'];
			
			$personalStatements[]=$image;
		}
		return $image;
	}
	
	public static function GetImageById($UID){
		$preparedStatement = DB::Prepare(
			"SELECT filename " .
			"FROM Image " .
			"WHERE imageId = :UID"
			);

		$preparedStatement->execute(array(':UID' => $UID));
		
		
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);

		$personalStatements = array();
		foreach($rows as $row){
			$image = new Image();
			$image->_filename = $row['filename'];
			
			$personalStatements[]=$image;
		}
		return $image;
	}
	
	
	
	/*
public function Save()  {
		if($this->_name AND $this->_datetime AND $this->_key) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO topics (name, code, datetime) " .
				"VALUES (:name, :key, :datetime)");
			$successful = $preparedStatement->execute(array( ':name' => $this->_name,
			 ':key' => $this->_key, ':datetime' => Util::DatabaseDateTime($this->_datetime)));

			if ($successful) {
				$this->_id = (int)DB::LastInsertId();
				return $this->_id;
			} 
			else
			{
				return NULL;
			}
		}
	}
*/	
	public function ToAssocArray() 
	{
		$arr = array ( 'uId' => $this->_uId, 'imageId'=> $this->_imageId, 'filename'=> $this->_filename);
		return $arr;
	}
	
	
}