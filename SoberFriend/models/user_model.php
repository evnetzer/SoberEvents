<?php


class User 
{
	public $_userId;
	public $_name;
	public $_password;

	function Id() {
		return $this->_userId;
	}
	
	public function Name($name) {
		if ($name) {
			$this->_name = $name;
		}	
		return $this->_name;
	}
	
	public function Password($password) {
		if ($password) {
			$this->_password = $password;
		}	
		return $this->_password;
	}
	
		
	public function Save()  {
		
		if($this->_name AND $this->_password ) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO User (name, password) " .
				"VALUES (:name, :password)");
			$successful = $preparedStatement->execute(array( ':name' => $this->_name, ':password' => $this->_password));
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
	
	public static function FindUserById($UID){
		$preparedStatement = DB::Prepare(
			"SELECT userId, name, password " .
			"FROM User " .
			"WHERE userId = :UID");

		$preparedStatement->execute(array(':UID' => $UID));
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
		
		//UNESSARY looping
		$users = array();
		foreach($rows as $row){
			$user = new User();
			$user->_userId = $row['userId'];
			$user->_name = $row['name'];
			$user->_password = $row['password'];
			
			$users[] = $user;
		}
		return $user;
	}
	
	public static function FindAllUsers(){
		$preparedStatement = DB::Prepare(
			"SELECT * " .
			"FROM User");

		$preparedStatement->execute();
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);

		$users = array();
		foreach($rows as $row){
			$user = new User();
			$user->_userId = $row['userId'];
			$user->_name = $row['name'];
			$user->_password = $row['password'];
			
			$users[] = $user;
		}
		
		return $users;
	}
	
  
	
	public function ToAssocArray() 
	{
		$arr = array ( 'userId'=> $this->_userId, 'name'=> $this->_name, 'password'=> $this->_password);
		return $arr;
	}
	
	
}



	