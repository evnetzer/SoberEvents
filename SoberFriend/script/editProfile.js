dojo.require("dijit.form.TextBox");
dojo.require("dijit.form.Textarea");
dojo.require("dijit.Dialog");
dojo.require("dijit.form.CheckBox");
dojo.require("dijit.form.Button");
dojo.require("dojo.parser");


var EXECUTE_CONTROLLER = 'controller.php';

dojo.addOnLoad(init);

function init() {
	callServerPost('controller.php', {method: 'load_personalStatement'}, setPersonalStatement, 'LOADING PERSONALSTATEMENT');
	callServerPost('controller.php', {method: 'load_userImage'}, setImages, 'LOADING USER IMAGES');
	callServerPost('controller.php', {method: 'load_tableImages'}, setTableImages, 'LOADING TABLE IMAGES');
	callServerPost('controller.php', {method: 'load_content'}, setContent, 'LOADING CONTENT');
	callServerPost('controller.php', {method: 'load_events'}, setEventContent, 'LOADING EVENTS');
	callServerPost('controller.php', {method: 'loadThisUsersContent'}, setThisUsersContent, 'LOADING EVENTS');
	dojo.byId(refreshLoopHolder).value=0;
	dojo.byId(refreshLoopEventsHolder).value=0;
	redirectToHome();
}


function setEventContent(jsonEvents){
	if(dojo.byId(refreshLoopEventsHolder).value >= jsonEvents.length)
	{
		dojo.byId(refreshLoopEventsHolder).value =0;
	}
	var j=0;//column
	var k=0;//row
	var x=0;//id holder
	for(var i=dojo.byId(refreshLoopEventsHolder).value; i<jsonEvents.length; i++)
	{
		if(j == 3)
		{
			k++;
			j=0;
		}
		
		rowColString=concatenate(k.toString(),j.toString());
		var eventTitle = concatenate("eventTitle",rowColString);
		var eventContent =concatenate("eventContent",rowColString);
		var eventImage= concatenate("eventImage", rowColString);
		var eventId= concatenate("EventIdHolder", x);
		x++;
		
		dojo.byId(eventTitle).innerHTML = jsonEvents[i].title;
		dojo.byId(eventContent).innerHTML = jsonEvents[i].description;
		dojo.byId(eventImage).src=formatImageString(jsonEvents[i].filename);
		dojo.byId(eventId).value=jsonEvents[i].eventId;
		j++;
	}
}

function loadEventsIAmAttending()
{
	callServerPost('controller.php', {method: 'loadThisUsersEvents'}, setThisUsersEvents, 'LOADING THIS USERS EVENTS');
}

function setThisUsersEvents(jsonEvents)
{
	//for( var i = dojo.byId(refreshLoopHolder).value; i<jsonContent.length; i++)
	//{
		dojo.byId('eventsIAmAttending1').innerHTML='"' + stripslashes(jsonEvents[0].title) + '"';
		dojo.byId('eventsIAmAttending2').innerHTML='"' + stripslashes(jsonEvents[1].title) + '"';
		dojo.byId('eventsIAmAttending3').innerHTML='"' + stripslashes(jsonEvents[2].title) + '"';
		dojo.byId('eventsIAmAttending4').innerHTML='"' + stripslashes(jsonEvents[3].title) + '"';
		dojo.byId('eventsIAmAttending5').innerHTML='"' + stripslashes(jsonEvents[4].title) + '"';
		
	//}
}

function setThisUsersContent(jsonContent)
{
	dojo.attr('thisUsersName', 'innerHTML', jsonContent.name);
	dojo.byId('thisUserImage').src=formatImageString(jsonContent.filename);
}

function refreshPeople()
{
	callServerPost('controller.php', {method: 'load_content'}, setContent, 'LOADING CONTENT');
	dojo.byId(refreshLoopHolder).value = parseInt(dojo.byId(refreshLoopHolder).value)+4;
}
function refreshEvents()
{
	
	callServerPost('controller.php', {method: 'load_events'}, setEventContent, 'LOADING EVENTS');
	dojo.byId(refreshLoopEventsHolder).value = parseInt(dojo.byId(refreshLoopEventsHolder).value)+7;
	
}

function closeSignUpForEvent()
{
	document.getElementById("signUpSuccess").style.display='none';
}

function signUpForEvent()
{
	callServerPostForm('controller.php', { method: 'signUpForEvent' },  sendMessageHandeler, 'HAH PRO', 'signUpEvent_form');
	document.getElementById("signUpSuccess").style.display='block';
}

function loadEventDetails(rowCol) 
{
	if(rowCol==0)
	{
		eventIdHolder = "EventIdHolder0";
	}
	else
	{
		var eventIdHolder = concatenate("EventIdHolder", rowCol);
	}
	var eventIdHolderValue = dojo.byId(eventIdHolder).value;
	dojo.byId("EventIdHolderFinal").value = eventIdHolderValue;
	callServerPostForm('controller.php', { method: 'load_eventsDetails' }, setEventDetails , 'SIGN UP FOR EVENT ERROR', 'signUpEvent_form');
}

function setEventDetails(jsonEvent)
{
	dojo.byId('eventDetailsImage').src=formatImageString(jsonEvent.filename);
	dojo.byId('eventDetailsTitle').innerHTML='"' + stripslashes(jsonEvent.title) + '"';
	dojo.byId('eventDetailsWhen').innerHTML='"' + stripslashes(jsonEvent.meetTime) + '"';
	dojo.byId('eventDetailsDescription').innerHTML='"' + stripslashes(jsonEvent.description) + '"';
}

function uploadImageFile() {
	console.log("in upload Image file");
	var imageFile = dojo.attr('id_imageFile', 'value');
	var ext = imageFile.substr(imageFile.lastIndexOf('.')+1);
	ext = ext.toLowerCase();
	if((ext=='jpeg') || (ext=='jpg') || (ext=='png') || (ext=='gif')) {
		uploadFile('id_artworkForm', showArtworkPreview, 'UPLOADING IMAGE');
	}
}

function loadOthersProfile(tableIndex){
	showMessageModal(tableIndex);
	callServerPostForm('controller.php', { method: 'load_usersContent' }, loadOthersProfileHandler , 'HAH PRO', 'sentMessage_form');
}

function loadOthersProfileHandler(jsonUserContent){
	dojo.byId('othersProfilePersonalStatement').innerHTML = '"' + stripslashes(jsonUserContent.personalStatement) + '"';
	dojo.byId('othersProfileInterest').innerHTML = '"' + stripslashes(jsonUserContent.interest) + '"';
	dojo.byId('othersProfileSoberLength').innerHTML = '"' + stripslashes(jsonUserContent.soberLength) + '"';
	dojo.byId('othersProfileImage').src=formatImageString(jsonUserContent.filename);
}

function createEvent2()
{
	callServerPostForm('controller.php', { method: 'save_event' }, sendMessageHandeler , 'HAH PRO', 'createEvent_form');
}




function closeSubmitMessage()
{
	document.getElementById("messageSentSuccess").style.display='none';
}

function submitMessage()
{
	var toUId = dojo.byId('tableUserTooId').value;
	console.log("CALL server post!!!!!!");
	console.log(toUId);
	callServerPostForm('controller.php', { method: 'send_message' }, sendMessageHandeler , 'HAH PRO', 'sentMessage_form');
	document.getElementById("messageSentSuccess").style.display='block';
}

function sendMessageHandeler(){
	console.log("in sent message handeler");
}

function setContent(jsonContent)
{
	var tableImage;
	var tableName;
	var tableInterest;
	var tableUserIdHolder;
	var j=0;
	if(dojo.byId(refreshLoopHolder).value > jsonContent.length)
	{
		dojo.byId(refreshLoopHolder).value =0;
	}
	for( var i = dojo.byId(refreshLoopHolder).value; i<jsonContent.length; i++)
	{
		tableImage = concatenate('tableImage',j);
		tableName = concatenate('tableName', j);
		tableInterest = concatenate('tableInterest', j);
		tableUserIdHolder = concatenate('tableUserIdHolder', j);
		j++;
		
		console.log(jsonContent[i].name);
		console.log(jsonContent.length);
		dojo.attr(tableUserIdHolder,'value', jsonContent[i].userId);
		dojo.attr(tableInterest, 'innerHTML', jsonContent[i].title);//changed for interest
		dojo.attr(tableName, 'innerHTML', jsonContent[i].name);
		dojo.byId(tableImage).src=formatImageString(jsonContent[i].filename);
		
		var x = dojo.byId(tableUserIdHolder).value;
	}
}


function formatImageString($filename){
	var txt = new String($filename);
	var txt2 = new String("upload/");
	var n = txt2.concat(txt);
	console.log("in format image");
	console.log(n);
	return n;
}

function setTableImages(jsonImages)
{
	var txt = new String(jsonImages[1].filename);
	var txt2 = new String("upload/");
	var n = txt2.concat(txt);
}

function setImages(jsonImages)
{
	var txt = new String(jsonImages.filename);
	var txt2 = new String("upload/");
	var n = txt2.concat(txt);
	dojo.byId('image').src=n;
}

function setPersonalStatement(jsonStatement)
{
	dojo.byId('personalStatementId').innerHTML = '"' + stripslashes(jsonStatement.personalStatement) + '"';
	dojo.byId('interestId').innerHTML = '"' + stripslashes(jsonStatement.interest) + '"';
}

function setInterests(jsonInterests) {
	console.log("in set interests");
}

function submitProfile(){
	callServerPostForm('controller.php', { method: 'save_profile' }, submitProfileHandler , 'HAH PRO', 'profile_form');
}

function submitProfileHandler(jsonUsers){
	console.log("in submitProfile js handler");
}

function submitImage()
{
	console.log("in submit Image");
}

function submitPersonalStatement()
{
	callServerPostForm('controller.php', { method: 'save_personalStatement' }, submitProfileHandler , 'HAH PRO', 'personalStatement_form');
	callServerPost('controller.php', {method: 'load_personalStatement'}, setPersonalStatement, 'LOADING PERSONALSTATEMENT');
}


function submitInterests(){
	console.log("In submit interests");
	callServerPostForm('controller.php', { method: 'save_interests' }, submitProfileHandler , 'HAH PRO', 'interests_form');
	callServerPost('controller.php', {method: 'load_personalStatement'}, setPersonalStatement, 'LOADING PERSONALSTATEMENT');
}



function showHidden(divId1, divId2)
{
	if(document.getElementById(divId1).style.display == 'none')
	{
		document.getElementById(divId1).style.display='block';
		document.getElementById(divId2).style.display='none';
	}else{
		document.getElementById(divId1).style.display='none';
		document.getElementById(divId2).style.display='block';
	}
	
}

function concatenate(x, y)
{
	return x.concat(y);
}

//Scripting For Dynamically Adding rows to table
function addRow(name, interest, filename, rowNumber){
	/*
	var NAME= name;
	var INTEREST = interest;
	var FILENAME = filename;
	
		var ptable = document.getElementById('ptableQuestion');
		var lastElement = ptable.rows.length;
		var index = lastElement;
		var row = ptable.insertRow(lastElement);
		
		
		var tableName = concatenate("tableName", rowNumber);
		var tableInterest = concatenate("tableInterest", rowNumber);
		var tableImage = concatenate("tableImage", rowNumber);
		var sendMessageButtonId = concatenate("sendMessageButtonId", rowNumber);
		var viewProfileButtonId = concatenate("viewProfileButtonId", rowNumber);
		var tableUserIdHolder = concatenate("tableUserIdHolder", rowNumber);

	var cellLeft = row.insertCell(0);
		var outerImageInterestDiv = document.createElement('div');
			var outerImageDiv = document.createElement('div');
				outerImageDiv.id="outerImageDivId";
				var image = document.createElement('img');
					image.id=tableImage;
					image.width='75';
					image.height='75';
			outerImageDiv.appendChild(image);
			var outerInterestDiv = document.createElement('div');
				outerInterestDiv.id="outerInterestDivId";
				var interestWrapper = document.createElement('div');
				interestWrapper.id='textInWell';
					var name = document.createElement('div');
						name.id=tableName;
					var interest =document.createElement('div');
						interest.id=tableInterest;
				interestWrapper.appendChild(name);
				interestWrapper.appendChild(interest);
			outerInterestDiv.appendChild(interestWrapper);
		outerImageInterestDiv.appendChild(outerImageDiv);
		outerImageInterestDiv.appendChild(outerInterestDiv);
	cellLeft.appendChild(outerImageInterestDiv);

	dojo.addClass(tableInterest,"tableInterest" );
	dojo.attr(tableInterest, 'innerHTML', INTEREST);
	dojo.attr(tableName, 'innerHTML', NAME);
	dojo.style('outerImageDivId', 'float', 'left');
	dojo.style('outerInterestDivId', 'float', 'left');
	dojo.byId(tableImage).src=formatImageString(FILENAME);
	
	var cellRight = row.insertCell(1);
		var uIdHolderDiv = document.createElement('div');
			uIdHolderDiv.id=tableUserIdHolder;
			uIdHolderDiv.value=rowNumber;
		var sendMessageButton = document.createElement('button');
			sendMessageButton.id=sendMessageButtonId;
			sendMessageButton.type='button';
		var viewProfileButton = document.createElement('button');
			viewProfileButton.id=viewProfileButtonId;
			viewProfileButton.type='button';
	cellRight.appendChild(uIdHolderDiv);
	cellRight.appendChild(sendMessageButton);
	cellRight.appendChild(viewProfileButton);
	
	dojo.addClass(sendMessageButtonId,"btn btn-mini btn-primary" );
	dojo.attr(sendMessageButtonId, 'innerHTML', 'Send Message');
	dojo.attr(sendMessageButtonId, 'onclick',showMessageModal(1));
	
	
	dojo.addClass(viewProfileButtonId,"btn btn-link" );
	dojo.attr(viewProfileButtonId, 'innerHTML', 'View Profile');
	
	//dojo.style('id_artworkPreviewContainer', 'display', 'inline');
	*/
	
		
}

function checkCheckboxes() { 
	var e = document.getElementsByName("cb"); 
	var message  = 'Are you sure you want to delete?'; 
	var row_list = {length: 0}; 

	for (var i = 0; i < e.length; i++) { 
		var c_box = e[i]; 

		if (c_box.checked == true) { 
    		row_list.length++; 

    		row_list[i] = {}; 
    		row_list[i].row = c_box.parentNode.parentNode; 
    		row_list[i].tb  = row_list[i].row.parentNode; 
		} 
	} 

	if (row_list.length > 0 && window.confirm(message)) { 
		for (i in row_list) { 
  		if (i == 'length') { 
        	continue; 
    		} 
    
  		var r = row_list[i]; 
  		r.tb.removeChild(r.row); 
		} 
	} else if (row_list.length == 0) { 
		alert('You must select an email address to delete'); 
	}
} 


