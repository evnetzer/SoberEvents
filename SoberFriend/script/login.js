
function verifyUsers(){
	callServerPostForm('controller.php', { method: 'verify_users' }, getUsersHandler , 'HAH HOO', 'login_form');
}

function getUsersHandler(jsonUsers){
	if(jsonUsers=='YES')
		window.location = '/index2.php'
	else 
		console.log("BAD USER");
}

function createAccountRedirect(){
	window.location = '/createAccount.php';
}
