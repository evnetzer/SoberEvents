<?php

class Upload{
	
	protected $_uploaded = array();
	protected $_destination;
	protected $_max = 51200;
	protected $_messages = array();
	protected $_permitted = array('image/gif',
									'image/jpeg',
									'image/pjpeg',
									'image/png');
	protected $_renamed = false;
	
	public function __construct($path){
		if(!is_dir($path) || !is_writable($path)){
			throw new Exception("$path must be a valid, writable directory.");
		}
		$this->_destination = $path;
		$this->_uploaded = $_FILES;
	}
	
	public function move() {
		$field = current($this->_uploaded);
		$sucess = move_uploaded_file($field['tmp_name'], $this->destination .
			$field['name']);
		if($success) {
			$this->messages[] = $field['name'] . 'uploaded sucessfully';
		}else{
			$this->_messages[] = 'Could not upload ' . $field['name'];
		}
	}
	
	
}
	