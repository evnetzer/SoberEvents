
function verifyUsers(){
	console.log("in verify user!");
	callServerPostForm('controller.php', { method: 'verify_users' }, getUsersHandler , 'HAH HOO', 'login_form');
}

function getUsersHandler(jsonUsers){
	//console.log(jsonUsers);
	if(jsonUsers=='YES')
		window.location = '/index2.php'
	else 
		console.log("they aint cool");
}

function createAccountRedirect(){
	console.log("redirect to create user account")
	window.location = '/createAccount.php';
}