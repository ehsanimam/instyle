
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

function confirm_del()
{
	return confirm('Are you sure you want to delete this color and its stocks?');
}

function del_primary_alert()
{
	alert("You cannot delete a Primary Color."+'\n\n'+"Please add another primary color, or, set another primary color before deleting old primary color.");
	return false;
}

function back_display()
{
	window.document.cancel_button_form.submit();
    //location.href="edit_new_product_designer.php?cat_id=<?=$cat;?>&des_id=<?=$des?>&subcat_id=<?=$subcat1?>"
}

function check_new_arrival(param)
{
	if (param == 'Y')
	{
		alert("You cannot assign this to 'CLEARANCE'."+'\n\n'+"Please unset it from 'New Arrival' and update the product detail first.");
		return false;
	}
	return true;
}

function check_clearance(param)
{
	if (param == 'Y')
	{
		alert("You cannot assign this to 'NEW ARRIVAL'."+'\n\n'+"Please unset it from 'Clearance' and update the product detail first.");
		return false;
	}
	return true;
}

function showsubcat(str)
{
	if (str == "")
	{
		document.getElementById("txtHint").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open("GET", "getsubcat.php?q=" + str, true);
	xmlhttp.send();
}

function check_date_availability(id) // ----> on blur of product availability input box
{
	var preOrder = id.slice(id.length - 1);
	
	var d = document.getElementById(id).value;
	var yyyy = d.slice(6);
	var mm = d.slice(0,2);
	var dd = d.slice(3,5);
	var db_date = Date.UTC(yyyy,mm,dd);
	
	var d_today = new Date();
	var month = new Array(12);
	month[0] = "01";
	month[1] = "02";
	month[2] = "03";
	month[3] = "04";
	month[4] = "05";
	month[5] = "06";
	month[6] = "07";
	month[7] = "08";
	month[8] = "09";
	month[9] = "10";
	month[10] = "11";
	month[11] = "12";
	var d_mm = month[d_today.getMonth()];
	var d_dd = d_today.getDate();
	var d_yyyy = d_today.getFullYear();
	var today = Date.UTC(d_yyyy,d_mm,d_dd);
	
	if (preOrder == 1)
	{
		if (db_date <= today) alert('The availability date set is no longer in the future.' + "\n\n" + 'This makes product on regular sale upon update.');
	}
	else
	{
		if (db_date > today) alert('The avalability date set is in the future.' + "\n\n" + 'This makes product on PRE-ORDER upon update.');
	}
}

function select_me(id)
{
	if (id === 'content1')
	{
		document.getElementById(id).style.display = 'block';
		document.getElementById('content2').style.display = 'none';
	}
	if (id === 'content2')
	{
		document.getElementById(id).style.display = 'block';
		document.getElementById('content1').style.display = 'none';
	}
}

function show_loder_gif()
{
	document.getElementById("div_loader").style.display = 'block';
	//document.getElementById("img_loader").style.display = 'block';
	
		alwaysOnTop.init({ // for internal div
			targetid: 'img_loader',
			orientation: 1,
			position: [-140, 220],
			fadeduration: [000, 000]
		})
}