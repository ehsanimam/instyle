
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

function return_to_list()
{
	window.location.href="list_sales_user.php";
}

function check_form()
{
	var alert_msg = '';
	if (document.getElementById("sa_user").value == "") alert_msg = "Please enter a First Name.\n";
	if (document.getElementById("sa_lname").value == "") alert_msg = alert_msg + "Please enter a Last Name.\n";
	if (document.getElementById("sa_email").value == "") alert_msg = alert_msg + "Please enter an Email Address.\n";
	
	if (alert_msg)
	{
		alert("Please fill up required fields properly.");
		return false;
	}
}

