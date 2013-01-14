	

function callServerPost(controllerURL, params, loadFunction, errorType)
{
	dojo.xhrPost(
	{	
		url: controllerURL,
		handleAs: "json",
		content: params,
		load: loadFunction, 
		error: function() 
		{
	 		console.log("ERROR:" + errorType);
		}
	});
}

function callServerPostForm(controllerURL, params, loadFunction, errorType, formId)
{
	var formElement = dojo.byId(formId);
	dojo.xhrPost(
	{	
		url: controllerURL,
		handleAs: "json",
		form: formElement,
		content: params,
		load: loadFunction, 
		error: function() {
			console.log("ERROR:" + errorType);
		}
	});		
}

function replaceURLWithHTMLLinks(text) {
    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/i;
    return text.replace(exp,"<a href='$1'>$1</a>"); 
}



function stripslashes(str) {
    str = str.replace(/\\'/g,'\'');
    str = str.replace(/\\"/g,'"');
    str = str.replace(/\\\\/g,'\\');
    str = str.replace(/\\0/g,'\0');
    return str;
}

function checkEmail(email) {
	atPos = email.indexOf("@")
	stopPos = email.lastIndexOf(".")
	if ((!email.length) || (atPos == -1 || stopPos == -1) || (stopPos < atPos) || (stopPos - atPos == 1)){
		return false;
	} else {
		return true;
	}
}


dojo.require("dojo.parser");
dojo.require("dojo.io.iframe"); 

function uploadFile( formId, loadFunction, errorType){
	
	console.log(formId);
	console.log("IN UTILITY");
	
	dojo.io.iframe.send({
		url: "upload_controller.php",
		form: dojo.byId(formId),
		timeout: 120000,
		preventCache: true,
		handleAs: "json",
		handle: loadFunction,
		error: function (res,ioArgs) {
			alert('please choose a smaller file. Sorry, but my hosting is not very good');
		}
	});
} 
