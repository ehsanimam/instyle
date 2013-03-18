/* 
* This script is to simply erase the value (content) of the input form
* when it gets focus and returns the same value (content) when blurs out.
* However, when a mnanual input has been done, it doesn't work anymore.
* Author: Webguy@bewebbled.com
*
* use on theKey:
* onfocus="clearme(this)" onblur="fillme(this)"
*/

	var input_value = '';

	function clearme(me)
	{
		input_value = me.value;
		if (input_value == 'Name *' || input_value == 'Phone' || input_value == 'Email *' || input_value == 'Comments')
		{
			me.style.color = 'black';
			me.value = '';
		}
		else
		{
			input_value = '';
			return false;
		}	
	}

	function fillme(me)
	{
		var y = me.value;
		if (y == '')
		{
			if (input_value == 'Name *' || input_value == 'Phone' || input_value == 'Email *' || input_value == 'Comments')
			{
				me.style.color = '#a1a1a1';
				if (y == '') me.value = input_value;
			}
			else
			{
				me.style.color = '#a1a1a1';
				if (me.name == 'name') me.value = 'Name *';
				if (me.name == 'phone') me.value = 'Phone';
				if (me.name == 'email') me.value = 'Email *';
				if (me.name == 'comments') me.value = 'Comments';
			}
		}
	}

	function checkme(id)
	{
		var input_name = id + '_name';
		var input_email = id + '_email';
		var input_phone = id + '_phone';
		var input_comments = id + '_comments';
		var alert_msg = '';
		name_check = document.getElementById(input_name);
		if (name_check.value == 'Name *' || name_check.value == '')
		{
			alert_msg = alert_msg + 'NAME field is required.\n';
		}
		email_check = document.getElementById(input_email);
		if (email_check.value == 'Email *' || email_check.value == '')
		{
			alert_msg = alert_msg + 'EMAIL field is required.\n';
		}
		if (alert_msg != '')
		{
			alert(alert_msg + '\nPlease try again.\n');
			return false;
		}
	}
	
/*
* Multi type popup script v1.0 (dropdown menu, tool tip, img tip etc..)
* Created: May 27rd, 2011. This notice must stay intact for usage
* Author: Webguy@bewebbled.com combined scripts from various scripts
* Main source is from Dynamic Drive at http://www.dynamicdrive.com/
*
* use on theKey:
* onmouseover="showObj(objId,me)" onmouseout="closetime()"
*
* use on theObj:
* onmouseover="cancelclosetime()" onmouseout="closetime()"
*/
	function alertme()
	{
		alert('Me');
	}

	// set the object variable (drop down menu div, tool tip div, img tool tip div, etc..)
	var theObj = 0;

	var theKey			= 0;			// the object initiating script theObj
	var opentimeout		= 100;			// time delay for the hidden object to pop out
	var closetimeout	= 300;			// time delay for the object to hide again
	var opentimer					// set variable for window object timeout
	var closetimer					// set variable for window object timeout
	
	// show theObj
	function showObj(objID,me) {
		theKey = me;
		// cancel close timeout if from another theKey
		cancelclosetime();
		// get div element by id
		if (typeof objID == "string") {
			objID = document.getElementById(objID);
		}
		// close any other theObj open usually from another theKey
		if (theObj && theObj != objID) theObj.style.visibility = 'hidden';
		// get the ID and show theObj using time delay
		theObj = objID;
		opentimer = window.setTimeout(opentime, opentimeout);
	}

	// move theObj near mouse before showing via updatePos
	function opentime() {
		if (theObj) theObj.style.visibility = 'visible';
	}

	// hiding theObj
	function close() {
		if (theObj) theObj.style.visibility = 'hidden';
		// reset var
		theObj = 0;
	}

	// closing theObj on mouseout
	function closetime() {
		closetimer = window.setTimeout(close, closetimeout);
	}

	// cancel close timer (this is when mouse hovers out of theKey on to theObj
	function cancelclosetime() {
		if (closetimer) {
			window.clearTimeout(closetimer);
			closetimer = null;
		}
	}

	// close theObj when click-out
	document.onclick = close;