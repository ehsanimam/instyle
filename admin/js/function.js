function IsNumeric(theForm,theElement,theMess) {
	var str=eval("window.document."+theForm+"."+theElement+".value");
	if(str=="") {
		alert(""+theMess+" should not be empty    ");
		eval("window.document."+theForm+"."+theElement+".focus()");
		return false;
	}
	if(isNaN(str)==true || parseInt(str) <= 0) {
		alert(""+theMess+" should not be alpha numeric and always greater than Zero    ");
		eval("window.document."+theForm+"."+theElement+".focus()");
		eval("window.document."+theForm+"."+theElement+".select()");
		return false;
	}
}
function isEmail(theForm,theElement,theMess) {
	var str=eval("window.document."+theForm+"."+theElement+".value");
	if(str=="") {
		alert(""+theMess+" should not be empty !!! Please provide a valid email address    ");
		eval("window.document."+theForm+"."+theElement+".focus()");
		return false;
	}
	var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/;
	if(re.test(str)==false) {
		alert("That is not a valid Email address. Please enter again.    ");
		eval("window.document."+theForm+"."+theElement+".focus()");
		eval("window.document."+theForm+"."+theElement+".select()");
		return false;
	}
}
function _doInputNumberOnly() {
	if(event.keyCode < 46 || event.keyCode > 57) {
		event.returnValue = false;
	}
}

function isEmpty(theForm,theElement,theMess) {
	var str=eval("window.document."+theForm+"."+theElement+".value");
	if(str=="") {
		alert(""+theMess+" should not be empty    ");
		eval("window.document."+theForm+"."+theElement+".focus()");
		return false;
	}
}
