
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

function check_required_fields()
{
	var alert_msg = '';
	if (document.getElementById("prod_name").value == "") alert_msg = "Please enter a Product Name.\n";
	if (document.getElementById("prod_no").value == "") alert_msg = alert_msg + "Please enter a Product Number.\n";
	if (document.getElementById("designer").value == "") alert_msg = alert_msg + "Please enter a Desginer.\n";
	if (document.getElementById("cat").value == "") alert_msg = alert_msg + "Please enter a Category.\n";
	if (document.getElementById("subcat").value == "") alert_msg = alert_msg + "Please enter a Subcategory.\n";
	if (document.getElementById("primary_image_color_cs").value == " - select color - " || document.getElementById("primary_image_color_cs").value == "")
	{
		alert_msg = alert_msg + "Please enter primary image color.\n";
	}
	
	if (alert_msg)
	{
		alert(alert_msg);
		return false;
	}
}
