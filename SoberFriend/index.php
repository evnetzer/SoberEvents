<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
			
			<script src="http://code.jquery.com/jquery-latest.js"></script>
			<script src="bootstrap/js/bootstrap.min.js"></script>
			<link rel="stylesheet" type="text/css" href="style/login.css" />
			<!--<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
			<script src="script/login.js" type="text/javascript"></script>
			<script type="text/javascript" src="script/utility.js"></script>
			<script type="text/javascript" src="script/dojo_1.6.1/dojo/dojo.js" djconfig="parseOnLoad:true, isDebug:true"></script>
			
			
	</head>
	<body id="login" >
		
		<div id="title">
			<p>Sober Events</p>
		</div>
		
		<div id="welcome-message">
			<p> This is a site that connects people who desire to live a sober life style.  We provide our users with information about local events created by people who share this positive outlook on life. 
			</p>
		</div>
		
		<div id="login-wrapper" class="png_bg">
			
			<div id="login-content">
				<form id="login_form">
					<p>
						<label>Username</label>
						<input class="text-input" type="text" name="username" value="">
					</p>
					<br style="clear: both;">
					<p>
						<label>Password</label>
						<input class="text-input" type="password" name="password">
					</p>
					<br style="clear: both;">
					
				</form>
				<p>
						<input class="button" type="submit" onclick="verifyUsers()" value="Sign In">
					</p>
			</div>
		</div>
		<div id="dummy">
		</div>
		<div id="dummy2">
		</div>
	</body>
</html>

