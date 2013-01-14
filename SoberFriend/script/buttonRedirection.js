function redirectToHome(){
	//window.location = '/home.php';
	document.getElementById("homeWrapper").style.display='block';
	//document.getElementById("messagesWrapper").style.display='none';
	//document.getElementById("profileWrapper").style.display='none';
	document.getElementById("eventsWrapper").style.display='none';
	document.getElementById("modalWrapper").style.display='none';
}

function redirectToMessages(){
	//window.location = '/messages.php';
	//viewMessage(1);
	//document.getElementById("homeWrapper").style.display='none';
	//document.getElementById("messagesWrapper").style.display='block';
	//document.getElementById("profileWrapper").style.display='none';
	//document.getElementById("eventsWrapper").style.display='none';
	
	//document.getElementById("modalWrapper").style.display='none';
	console.log("Im here!");
	//LOAD ALL MESSAGES SENT TO CURRENT USER
	callServerPost('controller.php', {method: 'load_receivedMessages'}, setReceivedMessages, 'LOADING RECEIVED MESSAGES');
	
}

function redirectToEvents(){
	document.getElementById("homeWrapper").style.display='none';
	//document.getElementById("messagesWrapper").style.display='none';
	//document.getElementById("profileWrapper").style.display='none';
	
	document.getElementById("eventsWrapper").style.display='block';
}

function setReceivedMessages(jsonMessageUser){
	//for(i=0; i< jsonMessageUser.length; i++){
		dojo.byId('messageBoardFrom1').innerHTML = '"' + stripslashes(jsonMessageUser[0].name) + '"';
		dojo.byId('messageBoardFrom2').innerHTML = '"' + stripslashes(jsonMessageUser[1].name) + '"';
		//dojo.byId('messageBoardSubject1').innerHTML = '"' + stripslashes(jsonMessageUser[0].subject) + '"';
		//dojo.byId('messageBoardSubject2').innerHTML = '"' + stripslashes(jsonMessageUser[1].subject) + '"';
		
		
		dojo.byId('actualMessage1').innerHTML = '"' + stripslashes(jsonMessageUser[0].message) + '"';
		//dojo.byId('messageSubject1').innerHTML = '"' + stripslashes(jsonMessageUser[0].subject) + '"';
		
		dojo.byId('actualMessage2').innerHTML = '"' + stripslashes(jsonMessageUser[1].message) + '"';
		//dojo.byId('messageSubject2').innerHTML = '"' + stripslashes(jsonMessageUser[1].subject) + '"';
	//}
}

function redirectToEditProfile(){
	//window.location = '/editProfile.php';
	document.getElementById("homeWrapper").style.display='none';
	//document.getElementById("messagesWrapper").style.display='none';
	document.getElementById("profileWrapper").style.display='block';
	document.getElementById("eventsWrapper").style.display='none';
	
	document.getElementById("modalWrapper").style.display='none';
}


function redirectToEditProfileN(){
	window.location = '/index2.php';
	//document.getElementById("homeWrapper").style.display='none';
	//document.getElementById("messagesWrapper").style.display='none';
	//document.getElementById("profileWrapper").style.display='block';
}


function showMessageModal(tableIndex){	
	console.log("show MESSAGE Modal");
	var tableNameId = concatenate('tableName', tableIndex);
	console.log(tableNameId);
	var name = dojo.byId(tableNameId).innerHTML; 
	console.log(name);
	dojo.byId('sendMessageToId').innerHTML = '"' + stripslashes(name) + '"' ;
	
	console.log("in show message modal");
	var tableUserIdHolder = concatenate("tableUserIdHolder", tableIndex);
	//var toUserId= dojo.byId(tableUserToId).value;
	//var toUserId= dojo.attr(tableUserToId, 'value');
	var toUserId = dojo.byId(tableUserIdHolder).value;
	console.log(tableUserIdHolder);
	console.log(toUserId);
	var tableUserIdHolder = 'tableUserTooId';
	dojo.attr(tableUserIdHolder, 'value', toUserId);
	//dojo.attr(tableUserIdHolder,'value', jsonContent[i].userId);
	var z = dojo.byId('tableUserTooId').value;
	console.log("MARKER");
	console.log(z);

	/*
	document.getElementById("modalWrapper").style.display='block';
	document.getElementById("homeWrapper").style.display='none';
	document.getElementById("messagesWrapper").style.display='none';
	document.getElementById("profileWrapper").style.display='none';
	
	if(tableIndex == 1){
		console.log("IN TABEL INDEX 1");
		dojo.attr('tableUserId','value', 1);*/
		//console.log(dojo.attr('tableUserId','value'));
	/*
	}
	if(tableIndex == 2)
		dojo.attr('tableUserId','value', 2);
	if(tableIndex == 3)
		dojo.attr('tableUserId','value', 3);
		*/
}

function viewMessage(index){
	redirectToMessages();
	if(index==1){
		document.getElementById("actualMessage1").style.display='block';
		document.getElementById("actualMessage2").style.display='none';
		document.getElementById("actualMessage3").style.display='none';
		document.getElementById("actualMessage4").style.display='none';
		document.getElementById("iconPlay1").style.display='block';
		document.getElementById("iconPlay2").style.display='none';
		document.getElementById("iconPlay3").style.display='none';
		document.getElementById("iconPlay4").style.display='none';
		//document.getElementById("messageSubject1").style.display='block';
		//document.getElementById("messageSubject2").style.display='none';
		

	}
	if(index==2){
		document.getElementById("actualMessage1").style.display='none';
		document.getElementById("actualMessage2").style.display='block';
		document.getElementById("actualMessage3").style.display='none';
		document.getElementById("actualMessage4").style.display='none';
		document.getElementById("iconPlay1").style.display='none';
		document.getElementById("iconPlay2").style.display='block';
		document.getElementById("iconPlay3").style.display='none';
		document.getElementById("iconPlay4").style.display='none';
	}if(index==3){
		document.getElementById("actualMessage1").style.display='none';
		document.getElementById("actualMessage2").style.display='none';
		document.getElementById("actualMessage3").style.display='block';
		document.getElementById("actualMessage4").style.display='none';
		document.getElementById("iconPlay1").style.display='none';
		document.getElementById("iconPlay2").style.display='none';
		document.getElementById("iconPlay3").style.display='block';
		document.getElementById("iconPlay4").style.display='none';
	}if(index==4){
		document.getElementById("actualMessage1").style.display='none';
		document.getElementById("actualMessage2").style.display='none';
		document.getElementById("actualMessage3").style.display='none';
		document.getElementById("actualMessage4").style.display='block';
		document.getElementById("iconPlay1").style.display='none';
		document.getElementById("iconPlay2").style.display='none';
		document.getElementById("iconPlay3").style.display='none';
		document.getElementById("iconPlay4").style.display='block';
	}
	
	
}



