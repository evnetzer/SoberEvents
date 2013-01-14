<?php
	session_start();
	ini_set("memory_limit", "512K");
	
	//echo("IN UPLOAD CONTROLLER!!!!!!!!!!");
	
	include '../models/utility.php';
	include '../models/connection.php';
	//include '../models/song_model.php';
	//include '../models/artwork_model.php';
	
	$method = $_POST['method'];	
	
	$path = '';
	$id = '';
	$audio = 0;
	
	if($method == 'upload_audio') {
		$arr = UploadAudio();
		$path = $arr['path'];
		$id = $arr['id'];
	} else if($method ='upload_image') {
		echo("YESSSSSS");
		//$arr  = UploadImage();		
		//$path = $arr['path'];
		//$id = $arr['id'];
	}
	
	function GenerateFilename($userId, $format) {
		$today = getdate();
		$filename = $userId . $today['seconds'] . $today['minutes'];
		$filename = $filename . $today['hours'] . $today['mday'];
		$filename = $filename . $today['mon'] . $today['year'] . "." . $format;
		return $filename;
	}
	
	function UploadAudio() {	
		
		$originalFilename = basename($_FILES['audio_file']['name']);
		//list($name, $format) = explode(".", $originalFilename);
		$format = strrchr($originalFilename, ".");
		list($tmp, $format) = explode(".", $format);
		$format  = strtolower($format);
		$filename = GenerateFilename($_SESSION['user_id'], $format);
		$target_path = '../audio/' . $filename;
		move_uploaded_file($_FILES['audio_file']['tmp_name'], $target_path); 

		$path = 'audio/'. $filename;
		$audio = 1;
		$song = new Song();
		$song->Filename($filename);
		$id = $song->Save();
		
		$arr = array('path' => $path, 'id' => $filename);
		
		return $arr;
	}
	
	function UploadImage() {
		echo ("IN UPPPPPPPPPPP");
		$audio = 'fuck';
		$originalFilename = basename($_FILES['image_file']['name']);
		$format = strrchr($originalFilename, ".");
		list($tmp, $format) = explode(".", $format);
		$format  = strtolower($format);
		$filename = GenerateFilename($_SESSION['user_id'], $format);
		$target_path = '../images/' . $filename;
		$path = 'upload/' . $filename;

		$uploadedfile = $_FILES['image_file']['tmp_name'];
		
		if (($format == "jpg") || ($format == "jpeg") || ($format == "png") || ($format == "gif")) {
 			if($format=="jpg" || $format=="jpeg" ) {
				$src = imagecreatefromjpeg($uploadedfile);
			} else if($format=="png") {
				$src = imagecreatefrompng($uploadedfile);
			}
			else {
				$src = imagecreatefromgif($uploadedfile);
			}
		}
 
		list($width,$height)=getimagesize($uploadedfile);
		$newwidth=250;
		$newheight=($height/$width)*$newwidth;
		$tmp=imagecreatetruecolor($newwidth,$newheight);

		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

		imagejpeg($tmp,$target_path,100);
		imagedestroy($src);
		imagedestroy($tmp);
		
		//$artwork = new Artwork();
		//$artwork->Filename($filename);
		//$id = $artwork->Save();
		
		$arr = array('path' => $path, 'id' => $filename);

		return $arr;
	}
?>
<html>
<head>
<script>isLoaded = true;</script>
</head>
<body>
<textarea>{'path':'<?php echo $path; ?>', id:'<?php echo $id; ?>', audio:'<?php echo $audio; ?>'}</textarea>
</body>
</html>
