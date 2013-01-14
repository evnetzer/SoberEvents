<?php
	session_start();
	
	
	include 'models/connection.php';
	include 'models/user_model.php';
	include 'models/profile_model.php';
	include 'models/image_model.php';
	include 'models/joined_model.php';
	include 'models/message_model.php';
	include 'models/event_model.php';
	include 'models/registeredFor_model.php';

	
	if(isset($_POST['method'])){
		$method = $_POST['method'];
	}else {
		$method = 'error';
	}
	
	if($method == 'save_user') {
		SaveUser();	
	}
	else if($method =="verify_users"){
		verifyUsers();
	}else if ($method == "save_profile"){
		SaveProfile();
	}else if($method == "save_image"){
		SaveImage();
	} else if ($method == "get_users"){
		GetUsers();
	}else if($method=="save_personalStatement"){
		SavePersonalStatement();
	}else if($method =="save_interests"){
		SaveInterests();
	}else if($method=="load_personalStatement"){
		LoadPersonalStatement();	
	}else if($method=="load_userImage"){
		LoadUserImage();
	}else if($method=="load_tableImages"){
		LoadTableImages();
	}else if($method=="load_content"){
		LoadContent();
	}else if($method=="send_message"){
		SendMessage();
	}else if($method=="load_receivedMessages"){
		LoadReceivedMessages();
	}else if($method=="load_events"){
		LoadEvents();
	}else if($method=="save_event"){
		SaveEvent();
	}else if($method == "load_usersContent"){
		LoadUsersContent();
	}else if($method == "load_eventsDetails"){
		LoadEventDetails();
	}else if($method == "signUpForEvent"){
		SignUpForEvent();
	}else if($method == "loadThisUsersContent"){
		LoadThisUsersContent();
	}else if($method == "loadThisUsersEvents"){
		loadThisUsersEvents();
	}
	
	function loadThisUsersEvents()
	{
		$x=array();
		$eventIds=RegisteredFor::GetEventIdsByUserId($_SESSION['uid']);
		foreach($eventIds as $eventI)
		{
			$eventI= $eventI->ToAssocArray();
			$events = Event::GetEventById($eventI['eventId']);
			foreach($events as $event)
			{
				$event= $event->ToAssocArray();
				$x[]=$event;
			}
		}
		echo(json_encode($x));
	}
	
	function SignUpForEvent(){
		$registeredFor = new RegisteredFor();
		$registeredFor->EventId($_POST['EventIdHolderFinal']);
		$registeredFor->UserId($_SESSION['uid']);
		$registeredFor->Save();
	}
	
	function LoadThisUsersContent()
	{
		$profile=Profile::GetProfile($_SESSION['uid']);
		$profile = $profile->ToAssocArray();
		$image=Image::GetImage($_SESSION['uid']);
		$image = $image->ToAssocArray();
		$user = User::FindUserById($_SESSION['uid']);
		$user = $user->ToAssocArray();
		$mergedElement = $profile + $image + $user;
		echo(json_encode($mergedElement));
	}
	
	function LoadUsersContent(){
		$profile=Profile::GetProfile($_POST['tableUserId']);
		$profile = $profile->ToAssocArray();
		$image=Image::GetImage($_POST['tableUserId']);
		$image = $image->ToAssocArray();
		$mergedElement = $profile + $image;
		echo(json_encode($mergedElement));
	}
	
	function SaveEvent(){
		$event= new Event();
		$event->Title($_POST['title']);
		$event->Description($_POST['description']);
		$event->ImageID($_SESSION['eventImageId']);
		$event->MeetPlace($_POST['meetPlace']);
		$event->MeetTime($_POST['meetTime']);
		$eventId= $event->Save();
		$registeredFor = new RegisteredFor();
		$registeredFor->EventId($eventId);
		$registeredFor->UserId($_SESSION['uid']);
		$registeredFor->Save();
	}
	
	
	function LoadEvents(){
		$events= Event::GetAllEvents();
		$array=array();
		if($events){
			foreach($events as $event){
				$event= $event->ToAssocArray();
				$i= $event['imageId'];
				$image=Image::GetImageById($i);
				$image = $image->ToAssocArray();
				$eventWithImage= $event+$image;
				$array[] = $eventWithImage;
				//$array[]=$event;
			}
			echo(json_encode($array));
		}		
	}
	
	function LoadEventDetails(){
		$events = Event::GetEventById($_POST['EventIdHolderFinal']);
		foreach($events as $event){
			$event= $event->ToAssocArray();
			$imageId = $event['imageId'];
			$image=Image::GetImageById($imageId);
			$image = $image->ToAssocArray();
			$merged = $event + $image;
		}
		echo(json_encode($merged));
	}
	
	function LoadReceivedMessages(){
		$messages = Message::LoadMessagesById($_SESSION['uid']);
			if($messages) {
				foreach($messages as $message) {
					$message = $message->ToAssocArray();
					$fromUID= $message['fromUID'];
					$user = User::FindUserById($fromUID);
					$user = $user->ToAssocArray();
					$mergedElement = $message + $user;
					$array[] = $mergedElement;
				}
				echo(json_encode($array));
			}else {
				echo(0);
			}
	}

	function sendMessage(){
		$message = new Message(1);
		$message->ToUID($_POST['tableUserId']);
		$message->FromUID($_SESSION['uid']);
		$message->Message($_POST['message']);
		$message->Subject($_POST['message']);
		$message->Save();
		
	}
	
	
	//loading all contents from user (many matches)..
	//only returning 1st index
	function LoadContent(){
		$x=array();
		for($i=1; $i<7; $i++){
			$array=array();
			$contents = Content::FindContentsById($i);
			$eventIds=RegisteredFor::GetEventIdsByUserId($i);
			foreach($eventIds as $eventI)
			{
				$eventI= $eventI->ToAssocArray();
				
			}
			$events = Event::GetEventById($eventI['eventId']);
			if($contents) {
				foreach($contents as $content) {
					foreach($events as $event)
					{
						$event= $event->ToAssocArray();
					}
					$content=$content->ToAssocArray();
					$mergedElement = $event + $content;
					$array[] = $mergedElement;
					//$array[] = $content;
				}
				//echo(json_encode($array[0]));
				$x[]=$array[0];//STUPID!!
			}else {
				echo(0);
			}
		}
		echo(json_encode($x));
	}
	
	function LoadTableImages(){
		$array = array();
		for($i=1; $i<4; $i++){
			$image=Image::GetImage($i);
			$image = $image->ToAssocArray();
			$array[]= $image;
		}
		echo(json_encode($array));
	}
	
	function LoadUserImage(){
		$image=Image::GetImage($_SESSION['uid']);
		$image = $image->ToAssocArray();
		echo(json_encode($image));
	}
	
	function LoadPersonalStatement(){
		$profile=Profile::GetProfile($_SESSION['uid']);
		$profile = $profile->ToAssocArray();
		echo(json_encode($profile));
	}
	
	function SaveInterests(){
		$profile = new Profile();
		$profile->UId($_SESSION['uid']);
		$profile->Interest($_POST['interests']);
		$profile->SaveInterests();
	}
	
	function SavePersonalStatement(){
		$profile = new Profile();
		$profile->UId($_SESSION['uid']);
		$profile->PersonalStatement($_POST['personalStatement']);
		$profile->SavePersonalStatement();
	}
		
	function SaveUser(){
		$user = new User();
		$user->Name($_POST['username']);
		$user->Password($_POST['password']);
		$id = $user->Save();
	}
	
	function SaveProfile(){
		$profile = new Profile();
		$profile->UId($_SESSION['uid']);
		$profile->Interest($_POST['interest']);
		$profile->SoberLength($_POST['soberLength']);
		$id = $profile->Save();
	}
	
	function SaveImage(){
		echo("in sabe IMages cotroller");
		$image = new Image();
		$image->UId($_SESSION['uid']);
		$image->Filename($_POST['file']);
		$id = $image->Save();
		return $id;
	}
	
	function verifyUsers(){
		$theyCool=false;
		$users= User::FindAllUsers();
		if($users){
			foreach($users as $user){
				if($user->_name==$_POST['username'] && $user->_password==$_POST['password']){
					$_SESSION['uid']=$user->_userId;
					$theyCool=true;
				}
			}
			if($theyCool==true){
				$_SESSION['autheticated'] = 'YES';
				
				echo(json_encode('YES'));
			}
			else{
				//$_SESSION['autheticated'] = 'NO';
				echo(json_encode('NO'));
			}
		}else{
			echo(json_encode('NO'));
		}
	}
	
	function GetUsers(){
		$users= User::FindAllUsers();
		if($users){
			$array = array();
			foreach($users as $user){
				$array[] = $user->ToAssocArray();
			}	
				echo(json_encode($array));
		}else{
			echo(0);
		}
				
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		