
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try {
		xmlhttp=new XMLHttpRequest();
	}
	catch(e) {
		try {			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e) {
			try {
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1) {
				xmlhttp=false;
			}
		}
	}
	return xmlhttp;
}

function getCat(pre, strURL) {
	var x = document.getElementById("designer").selectedIndex;
	var y = document.getElementById("designer").options;
	var txt = y[x].value;
	strURL = pre + strURL + '?d=' + txt;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {
					document.getElementById('categories_option').innerHTML = req.responseText;
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.status);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
	strURL2 = pre + 'admin/list_products_subcategories_option.php?d=' + txt;
	var req2 = getXMLHTTP();
	if (req2) {
		req2.onreadystatechange = function() {
			if (req2.readyState == 4) {
				// only if "OK"
				if (req2.status == 200) {
					document.getElementById('subcategories_option').innerHTML = req2.responseText;
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req2.status);
				}
			}				
		}			
		req2.open("GET", strURL2, true);
		req2.send(null);
	}
	spinner.stop();
}

function getSubcat(pre, strURL) {
	var x = document.getElementById("cat").selectedIndex;
	var y = document.getElementById("cat").options;
	var txt = y[x].value;
	strURL = pre + strURL + '?c=' + txt;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {
					document.getElementById('subcategories_option').innerHTML = req.responseText;
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.status);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
	spinner.stop();
}

function getSubsubcat(pre, strURL) {
	var x = document.getElementById("subcat").selectedIndex;
	var y = document.getElementById("subcat").options;
	var txt = y[x].value;
	strURL = pre + strURL + '?s=' + txt;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {
					document.getElementById('subsubcategories_option').innerHTML = req.responseText;
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.status);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
	spinner.stop();
}

function goSpin(id)
{
	var opts = {
		lines: 13, // The number of lines to draw
		length: 8, // The length of each line
		width: 4, // The line thickness
		radius: 10, // The radius of the inner circle
		rotate: 0, // The rotation offset
		color: '#000', // #rgb or #rrggbb
		speed: 1, // Rounds per second
		trail: 60, // Afterglow percentage
		shadow: false, // Whether to render a shadow
		hwaccel: false, // Whether to use hardware acceleration
		className: 'spinner', // The CSS class to assign to the spinner
		zIndex: 2e9, // The z-index (defaults to 2000000000)
		top: 'auto', // Top position relative to parent in px
		left: 'auto' // Left position relative to parent in px
	};
	if (typeof id == "string") target = document.getElementById(id);
	var spinner = new Spinner(opts).spin(target);
}

function select_me(string)
{
	window.document.menu_tab_frm.action = "list_products.php?sel=" + string;
	window.document.menu_tab_frm.method = "post";
	window.document.menu_tab_frm.submit();
}

function goto(page, sel)
{
	if (page == 1) { window.document.menu_tab_frm.action="list_products.php?sel=" + sel; }
	else { window.document.menu_tab_frm.action="list_products.php?sel=" + sel + "&p=" + page; }
	window.document.menu_tab_frm.method = "post";
	window.document.menu_tab_frm.submit();
}

function _do(prod_no, page, sel)
{
	window.document.prod_list_disp_frm.action="list_products.php?sel=" + sel + "&p=" + page + "&pn=" + prod_no;
	window.document.prod_list_disp_frm.method = "post";
	window.document.prod_list_disp_frm.submit();
}

