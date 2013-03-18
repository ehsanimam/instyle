
$(function()
{
	$(".date-pick").datePicker()
	$("#add_date").bind(
		"dpClosed",
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				//$("#add_date").dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
});

function check_form()
{
	var alert_msg = '';
	if (document.getElementById("sa_user").value == "") alert_msg = "Please enter a First Name.\n";
	if (document.getElementById("sa_lname").value == "") alert_msg = alert_msg + "Please enter a Last Name.\n";
	if (document.getElementById("sa_email").value == "") alert_msg = alert_msg + "Please enter an Email Address.\n";
	if (document.getElementById("sa_pword").value == "") alert_msg = alert_msg + "Please enter a Password.\n";
	if (document.getElementById("sa_pword2").value == "") alert_msg = alert_msg + "Please retype the Password.\n";
	
	if (alert_msg)
	{
		alert("You cannot send a blank form.\n" + "Please fill up form properly.");
		return false;
	}
}
