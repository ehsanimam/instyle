var xmlHttp
// for contract page
function do_img(id_,acts)
{
    //alert(id_);
	var url="ajximg.php?id="+id_+"&act="+acts;	
	//document.getElementById("product-img").innerHTML = "<span class='error'>Please wait ... Loading ...</span><br><br><img src='images/loadingAnimation.gif' height='13' width='208' />";
	xmlHttp = GetXmlHttpObject(ReturnImg)
	xmlHttp.open("GET", url , true)
	xmlHttp.send(null)
}
function ReturnImg() {
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {		
		document.getElementById("product-img-contract").innerHTML = xmlHttp.responseText;
	}
}
// End for contract page

// for product page
function do_prodimg(id_,imgno)
{
	var myOna=new Array("onone","ontwo","onthree", "onfour");
	var myFlag = 0;
	for (i=0;i<myOna.length;i++)
	{
		if(imgno == i)
		{
			document.getElementById(myOna[i]).className="activestate";
		}
		else
		{
			if(document.getElementById(myOna[i]) != null)
			{
				document.getElementById(myOna[i]).className="normalstate";
			}
		}  
	}	

	var url="prodimg.php?id="+id_+"&imgno="+imgno;	
	//document.getElementById("imgprod").innerHTML = "<span class='error'>Please wait ... Loading ...</span><br><br><img src='images/loadingAnimation.gif' height='13' width='208' />";
	xmlHttp = GetXmlHttpObject(ReturnProdImg)
	xmlHttp.open("GET", url , true)
	xmlHttp.send(null)
}
function ReturnProdImg() {
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {		
		document.getElementById("imgprod").innerHTML = xmlHttp.responseText;
	}
}
// End for product page


// For view dimension price
function _dPrice(id_)
{
    //alert(id_);
	var url="ajxdPrice.php?id="+id_;
	document.getElementById("showdPrice").innerHTML = "<img src='images/loading.gif' height='16' width='16' />";
	xmlHttp = GetXmlHttpObject(ReturndPrice)
	xmlHttp.open("GET", url , true)
	xmlHttp.send(null)
	
}
function ReturndPrice() {
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
		document.getElementById("showdPrice").innerHTML = "";	
		document.getElementById("showdPrice").innerHTML = xmlHttp.responseText;
	}
}
// End For view dimension price


function GetXmlHttpObject(handler) { 

	var objXmlHttp=null



	if (navigator.userAgent.indexOf("Opera")>=0) {

		alert("This example doesn't work in Opera") 

		return; 

	}

	if (navigator.userAgent.indexOf("MSIE")>=0)	{ 

		var strName="Msxml2.XMLHTTP"

		if (navigator.appVersion.indexOf("MSIE 5.5")>=0)

		{

			strName="Microsoft.XMLHTTP"

		} 

		try	{ 

			objXmlHttp=new ActiveXObject(strName)

			objXmlHttp.onreadystatechange=handler 

			return objXmlHttp

		} catch(e) { 

			alert("Error. Scripting for ActiveX might be disabled") 

			return 

		} 

	} 

	if (navigator.userAgent.indexOf("Mozilla")>=0) {

		objXmlHttp=new XMLHttpRequest()

		objXmlHttp.onload=handler

		objXmlHttp.onerror=handler 

		return objXmlHttp

	}

}

