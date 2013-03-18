<?php
session_start();
	include("common.php");
	include("webfunction.php");
	include("libmail.php");
//===================================Meta code area==============================================
$thispage = substr($_SERVER["PHP_SELF"],6,strlen($_SERVER["PHP_SELF"]));
list($thisfilename,$thissurname) = split('[/.-]',$thispage,2);
$Strmet = sprintf("SELECT * FROM `tblmeta` WHERE `pagename`='%s' limit 1", $thisfilename);
$aobj =mysql_query($Strmet);
$a = mysql_fetch_array($aobj);

if($a['title']!="")
{
		$mytitle = $a['title'];
}
else{
	$mytitle="Online Luxury Shopping Below Retail Pricing at Instylenewyork.com";
}

if($a['description']!=""){$mydesc = $a['description'];}else{$mydesc="Visit instylenewyork.com for Apparel for Her featuring new collections from top designers.  instylenewyork.com  has fashions top names in clothing, shoes, jewelries, bridal, collections and accessories for women, men, and kids.";}

if($a['keyword']!=""){$mykey = $a['keyword'];}else{$mykey="InStyle New York,InCircle,prada,bcbg,marc jacobs,chloe,frye,juicy couture,manolo blahnik,isabella fiore,eileen fisher,kate spade,vera wang,stuart weitzman,catherine malandrino,rock and republic,burberry,Theory,seven jeans,trina turk,dior,dana buchman,lacoste,tory by trb,yves saint laurent, instylenewyork.com";}
//===================================End Meta code area==============================================
//+++++++++++++++++++++++++++++++++EMAIL SUBSCRIBE+++++++++++++++++++++++++++++++++++++++++++++++++
$this_file=$_SERVER['PHP_SELF'];
$this_str=$_SERVER['QUERY_STRING'];
if($this_str!=""){ $this_url=($this_file."?".$this_str); }else{ $this_url=($this_file);} 

if($_POST["email"]!=""){

		$sqlcheck = "select * from tblemail_subscribe where email_addr = '$_POST[email]' limit 1";
		$a = MyQuery($sqlcheck);
		if(isset($a[0]) && $a[0]!=""){
			 alert("Sorry ! email: ".$_POST[email]." already exist","womens_apparel_product.php?".$_SERVER['QUERY_STRING'],"");		
		}
		else
		{
			$insert_email="insert into tblemail_subscribe (email_id, email_addr, create_date) values(0, '$_POST[email]', now())"; 
			 mysql_query($insert_email);
			 alert("Thank you for registering", "womens_apparel_product.php?".$_SERVER['QUERY_STRING'],"");		
		}
}
//++++++++++++++++++++++++++++++END EMAIL SUBSCRIBE+++++++++++++++++++++++++++++++++++++++++++++++++
//	include("function/paganition.php");
	if($_GET["catID"]!=""){
		$h_id=Gethead_id($_GET["catID"]);
		$h_name = strtolower(Gethead_name($h_id));
		$Strsql =sprintf("SELECT * FROM `tblcat` WHERE `view_status`='Y' and heading_id='%s' order by priority",$h_id);
	}
	else
	{
		$Strsql ="SELECT * FROM `tblcat` WHERE `view_status`='Y' and heading_id='1' order by priority";
	}
	$res =mysql_query($Strsql);
define("RECORD_PER_PAGE",1,true);
//changes 26/10/07
$type_sql ="SELECT * FROM `tbltypecat` where heading_id=1";
$type_que = mysql_query($type_sql);
//**********************
$sql = "SELECT * FROM `tbl_product` WHERE `subcat_id`='".$_GET['subcatID']."' AND `view_status`='Y' ORDER BY `seque` ASC";
$type_idmenu = MyQuery($sql);
//$result=pagination_new($sql,RECORD_PER_PAGE,$_GET['page']);
$img0 = 0;
$img1 = 0;
$img2 = 0;
$img3 = 0;

$curr_url1=$_SERVER['PHP_SELF'];
	
$curr_url2=$_SERVER['QUERY_STRING'];
	
$curr_url3=($curr_url1."?".$curr_url2); 

$pdf_c = QuerySubcatCchart($_GET['subcatID']);
if($_REQUEST['option']=='friendmail'){

$sqlf="select * from tbl_product where prod_id='".$_GET['pro_id']."'";
	$rsf=mysql_query($sqlf);
	$rowf=mysql_fetch_array($rsf);
	
	if(isset($_GET['color_id']) && !empty($_GET['color_id'])) {
	
		 $col_newf=$_GET['color_id'];
		 
	} else {
	
		 $col_newf=$rowf['primary_img_id'];
	}

	
	if(isset($_POST['option'])){
	
	$no_of_persons=explode(",",$_POST['to']);
	$num_persons=count($no_of_persons);
	$from = $_POST['from'];
	
		if($num_persons<=3){
		$msg = $_POST['msg'];
		$fileatt_name="images/product_front/".$rowf['prod_no']."_".$col_newf.".jpg";
		$m = new Mail(); // create the mail
			$m->From($from);
		$m->To($no_of_persons);
		$m->Bcc("info@instylenewyork.com");
		$m->Subject("Fabulous Dress at Instylenewyork.com");
		$m->Body($msg);
		$m->Priority(4);
		$m->Attach($fileatt_name, "image/jpg", "inline");
		$m->Send(); // send the mail 
		
		header("Location:womens_apparel_product.php?".$_SERVER['QUERY_STRING']);
		
		}

	}
	
}
//echo '>>>>'.$_GET['type'];
if($_GET['type'] == 'cart')
{
		$size=$_POST['size'];
		$qty=$_POST['qty'];
		$prod_id=$_POST['prod_id'];
		$color_id=$_POST['color_id'];
		$addcart=$_POST['addcart'];
		//die($size.','.$qty.','.$prod_id.','.$color_id.','.$addcart);
		if($_POST['color_id']=='')
	    {
			$error = " &nbsp; &nbsp; <img src=\"images/ico_warning.jpg\" align=\"absmiddle\"> Please select a color!";
		}
		else if($_POST['size']=='')
	    {
			$error = " &nbsp; &nbsp; <img src=\"images/ico_warning.jpg\" align=\"absmiddle\"> Please select a size!";
		}
		else if($qty=='')
	    {
			$error = " &nbsp; &nbsp; <img src=\"images/ico_warning.jpg\" align=\"absmiddle\"> Please enter a quantity!";
		}
		else
	    {
			header('Location:womens_apparel_cart.php?addcart='.$addcart.'&color_id='.$color_id.'&prod_id='.$prod_id.'&size='.$size.'&qty='.$qty);
		}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?=$mydesc;?>" />
<meta name="keywords" content="<?=$mykey;?>" />
<meta name="author" content="Pla" />
<meta name="subject" content="Instyle New York" />
<meta name="coverage" content="worldwide" />
<meta name="Content-Language" content="english" />
<meta name="resource-type" content="document" />
<meta name="robots" content="all,index,follow" />
<meta name="classification" content="Instyle New York" />
<meta name="rating" content="general" />
<meta name="revisit-after" content="10 days" />
<meta http-equiv="Pragma" content="no-cache">
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 

<title><?=$mytitle;?></title>
<script language="javascript" src="js/browser.js" type="text/javascript"></script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18902231-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<link href="style/main.css" rel="stylesheet" type="text/css"/>
<link href="style/style_b.css" rel="stylesheet" type="text/css"/>
<link href="style/style.css" rel="stylesheet" type="text/css"/>
<link href="style/bubbletip.css" rel="stylesheet" type="text/css" />
<link href="style/tabs.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="style/product.css" type="text/css">
<!-- <link rel="stylesheet" href="style/minizoompan.css" type="text/css"> -->
	<!--[if IE]>
	<link href="style/bubbletip-IE.css" rel="stylesheet" type="text/css" />
	<![endif]-->

<script language="javascript" type="text/javascript" src="admin/js/function.js"></script>
<script type="text/JavaScript">
<!--
function _check(){
	if(isEmpty('frmsubscribe','email','Email')==false){
		return false;
	}
	
	if(isEmail('frmsubscribe','email','Email')==false){
		return false;
	}
}
//-->
</script>
<script type="text/JavaScript">
<!--
function openManWin(url,name,wNum,hNum) {
 newWin=window.open(url,name,'resizable=yes,toolbar=no,location=no,scrollbars=yes,width='+wNum+',height='+hNum+',status=no');
 newWin.focus();
}

//-->
</script>
<script language="javascript">
function openManWin(url,name,wNum,hNum) {
 newWin=window.open(url,name,'resizable=yes,toolbar=no,location=no,scrollbars=yes,width='+wNum+',height='+hNum+',status=no');
 newWin.focus();
}
function openPopUp(int_imageid)
{
	var str_url="blowup.php?p_id="+ int_imageid;
window.open(str_url, '', "status=no, resizable=no, scrollbars=no, toolbar=no, maximize=no, hotkeys=no, width=640, height=550, center");
}

function emailPopUp(int_imageid,color_id)
{
	var str_url="send_friendmail.php?urls=<?php echo urlencode($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>&p_id="+int_imageid+"&color_id="+color_id;
	window.open(str_url, '', "status=no, resizable=no, scrollbars=no, toolbar=no, maximize=no, hotkeys=no, width=550, height=400,center");
}


function email_this(int_imageid)
{
	var str_url="regarding_this.php?urls=<?php echo urlencode($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>&p_id="+int_imageid;
	window.open(str_url, '', "status=no, resizable=no, scrollbars=no, toolbar=no, maximize=no, hotkeys=no, width=550, height=400,center");
}
function color_samples()
{
	//var str_url="color_samples.php";
	//var str_url = "admin/color_samples/COLOR_CHARTS_HiRes.pdf";
	//var str_url = "color_chart.php";
	var str_url = "color_chart2.php?pdf_c=<?php echo $pdf_c?>";
	window.open(str_url, '', "status=no, resizable=no, scrollbars=yes, toolbar=no, maximize=no, hotkeys=no, width=650, height=790,center");
}
function print_page()
{
	var str_url="print_page.php?catID=<?php echo $_GET['catID']?>&subcatID=<?php echo $_GET['subcatID']?>&pro_id=<?php echo $_GET['pro_id']?>&zoom=<?php $_GET['zoom']?>&page=<?php echo $_GET['page']?>&pg=<?php echo $_GET['pg']?>&TypeID=<?php echo $_GET['TypeID']?>";	
	window.open(str_url, '', "status=no, resizable=no, scrollbars=yes, toolbar=no, maximize=no, hotkeys=no, width=865, height=531,center");
}

function email_chk()
{
var email1=document.getElementById('email1').value;
var email=document.getElementById('email').value;
	if (email1 == "") 
	{
		alert("Please enter From email address")          
		document.sendfriend.from.focus();
		return false
	}	
	if(email1!= '')
	{
		var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if(!document.sendfriend.from.value.match(emailExp) ) 
		{
			alert("Please enter valid From email");
			document.sendfriend.from.focus()
			return false;
		}
	}
	if (email  == "") 
	{
		alert("Please enter From email address")          
		document.sendfriend.to.focus();
		return false
	}	
	if(email!='')
	{
		var arlene = email.split(",");
		var len = arlene.length;
		if(len>3){
		alert("Sorry you can not enter more than 3 email address.");
		document.getElementById('window').display='Block';
		}else{
			var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
			for(var i=0;i<len;i++)
			{
				if(!arlene[i].match(emailExp) ) 
				{
					alert("Please enter valid to email");
					document.sendfriend.to.focus()
					return false;
				}
			}
			document.sendfriend.submit();
		}
	}
	
}
</script>
<script>
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}
	
	
	
	function getQty(strURL) {
	
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('qtydiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}
	
	
</script>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript">
 jQuery.noConflict();
  // Code that uses other library's $ can follow here.
</script>

<link href="style/cloud-zoom.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript" src="js/cloud-zoom.1.0.2.js"></script>
<script src="js/mootools-yui-compressed.js"></script>
<script src="js/mt-1.2.4.2-more.js"></script>
<script src="js/swfobject.js"></script>
<script type="text/javascript">// <![CDATA[
function Show_Popup() {

	if(document.getElementById('sizet').style.visibility == "visible" || document.getElementById('sizet').style.visibility == "")
	{
		document.getElementById('sizet').style.visibility="hidden";
	}	
	jQuery('#window').fadeIn('fast');
	
	
}

function Close_Popup() {
	if(document.getElementById('sizet').style.visibility == "hidden")
	{
		document.getElementById('sizet').style.visibility="visible";
	}	
	jQuery('#window').fadeOut('fast');
}

function Show_Sizechart() {
	if(document.getElementById('sizet').style.visibility == "visible" || document.getElementById('sizet').style.visibility == "")
	{
		document.getElementById('sizet').style.visibility="hidden";
	}	
	jQuery('#windowsize').fadeIn('fast');
}

function Close_Sizechart() {
	if(document.getElementById('sizet').style.visibility == "hidden")
	{
		document.getElementById('sizet').style.visibility="visible";
	}	
	jQuery('#windowsize').fadeOut('fast');
}

// ]]&gt;</script>
<style type="text/css">
.imgBorder { border: 1px solid #333; }
</style>


<style type="text/css">
<!--
  .stylex {
	margin-left:0
	position: absolute;
	left: 0px;
	top: 0px;
	z-index: 5000;
	}
-->
</style>

</head>

<body>

<div id="headblackbg" align="center">
		
	<div id="topmenu">
		  <?php include('top_nav.php'); ?>
	</div><!-- end div id topmenu-->
</div><!-- end div id blackheadbg-->
<div id="mainbg" align="center">
	<div id="wrapper">
	<?php
	$cat_id 	= $_GET['catID'];
	$subcat_id	= $_GET['subcatID'];
	$prod_id	= $_GET['pro_id'];
	$type_id	= $_GET['TypeID'];
	$color_id	= $_GET['color_id'];
	
	$img_nthumb_url = 'admin/product_picture/thumb/';
	$img_thumb_url  = 'admin/product_picture/mini_thumb/';
	$img_normal_url = 'admin/product_picture/';
	$img_zoom_url	= 'admin/product_picture/zoom/';
	$img_icon_url   = 'admin/product_picture/sketch/';
	
	$query = mysql_query("SELECT
						  tp.prod_id, tp.prod_name, tp.prod_no, tp.cat_id,  tp.subcat_id, tp.prod_desc,
						  tp.catalogue_price, tp.less_discount, tp.primary_img, tp.primary_img_id, tp.colors,tp.colornames, d.designer,d.des_id, d.folder as designer_folder, 
						  cat.cat_name, subcat.subcat_name, subcat.folder AS subcat_folder, tcs.color_name,tcs.color_code 
						FROM
						  tbl_product tp
						  LEFT JOIN designer d ON d.des_id=tp.designer
						  LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
              			  LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
						  LEFT JOIN tblcolor tcs ON tcs.color_code = tp.primary_img_id
						WHERE
						  tp.prod_id = '".$prod_id."' and tp.view_status='Y' 
						");
						
					
	$frow = mysql_fetch_array($query);
	
	if(isset($color_id) && !empty($color_id)) {
	
		 $imgName_zoom="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_front/".$frow['prod_no']."_".$color_id.".jpg";
		 
	} else {
	
		 $imgName_zoom="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_front/".$frow['prod_no']."_".$frow['primary_img_id'].".jpg";
	}
		 
	?>
	<div align="left" class="sstxt">
		&nbsp;<a href="womens-apparel.php" class="text1" ><?=$frow['cat_name']?></a> 
        <img src="images/arrow_small.gif" align="absmiddle" /> 
		<a href="womens-apparel-by-designer.php?catID=<?=$_GET['catID']?>&subcatID=<?=$frow['des_id']?>" class="text1"><?=$frow['designer']?></a> 
		<img src="images/arrow_small.gif" align="absmiddle" /> 
		<a href="womens-apparel.php?catID=<?=$_GET['catID']?>&subcatID=<?=$_GET['subcatID']?>" class="text1"><?=$frow['subcat_name']?></a> 
		<img src="images/arrow_small.gif" align="absmiddle" /> 
		<font class="text1"><?=$frow['prod_no']?></font>
	</div>
    <div id="coldiv">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td style="width:340px;" rowspan="2">
		<table border="0"><tr><td>	
                <div id=container>
<div id='closebtn'></div>
<div id='imgvideo' style='display:none;'>
<div id='vidcont'></div>
</div>
<div id="image_div" class="zoom zoom_no_lbox">
                <a href='<?=$imgName_zoom?>' class ='cloud-zoom' id='zoom1'
					rel="zoomWidth:640,adjustX: -1, adjustY:-1">
					<img id='imgmain' src="res.php?w=325&h=487&constrain2=1&img=<?php echo $imgName_zoom;?>" style="width:325px;height:487px;border:0px;"  alt="<?=$frow['prod_name']?>"  title="<?=$frow['prod_name']?>" class="imgBorder"/>				</a>
                <!--<br />
                <a href="javascript:openManWin('product800.php?prod_id=<?=$imgName_zoom;?>','800Win',630,800);" style="font-size:12px;"><strong>View Big Image</strong></a>-->
                </div></div>
				</td>
				</tr>
				<!--<tr>
				<td>
				&nbsp;			
			</td>
			</tr>-->
			</table>
	</td>
	<td valign="top" align="left">
<div id="windowsize" style="display: none; vertical-align:top">
<ol id="toc">
    <li><a href="#page-1"><span>Apparel Size Chart</span></a></li>
    <li><a href="#page-2"><span>Measuring Info</span></a></li>
</ol>
<div class="content" id="page-1">
    <table width="100%" cellpadding="2" cellspacing="2" align="center">
        <tr>
        	<td style="height:280px;vertical-align:top;">
            <?php
            $get_tblsize = @mysql_query("SELECT * FROM tblsize where bust<>'0' and size_name<>'fs'");
            if(@mysql_num_rows($get_tblsize)>0) {
            ?><br />
            <table cellpadding="4" border="1" style="border-collapse:collapse;" align="center">
            <tr><td style="width:100px;background:#000;color:#fff;"><strong>Size</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Bust (in)</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Waist (in)</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Hip (in)</strong></td></tr>
            <?php
            while($srow = @mysql_fetch_array($get_tblsize)) {
            ?>
            <tr style="background:#efefef;"><td><?=$srow['size_name']?></td><td><?=$srow['bust']?></td><td><?=$srow['waist']?></td><td><?=$srow['hip']?></td></tr>
            <?php
            }
            ?>
            </table>
            <?php
        }
        ?>        	</td>
    	</tr>
	</table> 
    <div style="float:right"><a href="#" onclick="Close_Sizechart();"><img src="images/cross.gif" border="5" style="vertical-align:middle; border-color:#999999; border-style:solid"/></a></div>
   <div id="space"><!-- IE fix--></div>
</div>

<div class="content" id="page-2">
   <div style="text-align: center;"><IMG SRC="images/measuringInfo.jpg" border=0 width="565" height="410" alt="Measuring Info" longdesc="Measuring Information" /></div>
   <div style="float:right"><a href="#" onclick="Close_Sizechart();"><img src="images/cross.gif" border="5" style="vertical-align:middle; border-color:#999999; border-style:solid"/></a></div>
   <div id="space"><!-- IE fix--></div>
</div>

</div>  

  
   
	<div class="prdno"><?=$frow['prod_no']?></div>
    <div class="prdname"><?=strtoupper($frow['prod_name'])?> </div>
	<span class="prdname1">PRICE: $<?=$frow['catalogue_price']?>.00</span><br />
	<span class="prdname1">RETAIL: </span><strike><span class="retail">$<?=$frow['less_discount']?>.00</span></strike><br /><br />
    
    <?php $get_color = @mysql_fetch_array(@mysql_query("SELECT color_name FROM tblcolor WHERE color_code='".$_GET['color_id']."'")); ?>
    <div class="prdname">COLOR: <?=$get_color['color_name']?> </div>    
    
	<?php
	
		$get_color_list = @mysql_query("SELECT
										  tp.prod_id, tp.prod_no, col.color_code, col.color_name
										FROM
										  tbl_product tp
										  JOIN tbl_stock ts ON ts.prod_id = tp.prod_id
										  JOIN tblcolor col ON col.color_id = ts.cs_id
										WHERE
										  tp.prod_id = '".$frow['prod_id']."'") or die(mysql_error());
		if(@mysql_num_rows($get_color_list)>0){
			while($csrow=mysql_fetch_array($get_color_list)) {					
	
				$icon_url="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_coloricon/".$frow['prod_no']."_".$csrow['color_code'].".jpg";
				if (file_exists($icon_url)) {
				$icon_url="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_coloricon/".$frow['prod_no']."_".$csrow['color_code'].".jpg";
				}else{
				$icon_url="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_coloricon/".$frow['prod_no']."_".$csrow['color_code'].".gif";
				}		
			
				?> 
				<a href="womens_apparel_product.php?catID=<?=$_GET['catID']?>&subcatID=<?=$_GET['subcatID']?>&pro_id=<?=$frow['prod_id']?>&color_id=<?=$csrow['color_code']?>">
				<img src="resizeimage.php?w=25&constrain2=1&img=<?=$icon_url?>" class='imgBorder' title="[ <?=$csrow['color_name']?> ] Click to select/view color"/>
				</a>&nbsp;&nbsp;
				<?php
			}
        } else {
        	?> Out of Stock <?php
        }
		
        ?>
	<br /><br />  
    
 <div id="sizet">       

    <form name="size" action="womens_apparel_product.php?catID=<?php echo $_GET['catID']?>&subcatID=<?php echo $_GET['subcatID']?>&pro_id=<?php echo $_GET['pro_id']?>&zoom=<?php $_GET['zoom']?>&TypeID=<?php echo $_GET['TypeID']?>&type=cart" method="post" enctype='multipart/form-data'>

		<table cellspacing="0" cellpadding="0" border="0" width="200">        
		
		<tr><td style="font-size:12px;" width="70%"><strong>SIZE</strong> <span style="font-size:10px;">[<a href="#" onclick="javascript:Show_Sizechart();">SIZE CHART</a>]</span></td>
		<td style="font-size:12px;padding-left:10px;"><strong>QTY</strong></td></tr>
		<tr><td>
		<?php
		if(!isset($_GET['color_id']) && empty($_GET['color_id'])) {
			$cs_id = $frow['primary_img_id']; 
		} else {
			$cs_id = $_GET['color_id'];
		}
		
		 $csql = "select * from tblcolor where color_code='$cs_id'"; 
		 $cs3 = mysql_query($csql);
		$cs_row3 = mysql_fetch_array($cs3);
		

		if(count($color_names) > 1)
		{	
			?><input type="hidden" name="color_id" value="<?=$_GET['color_id'];?>" /><?
		}
		else
		{
		?>
        <input type="hidden" name="color_id" value="<?=$cs_id?>" />
		<? } ?>
        <input type="hidden" name="prod_id" value="<?=$frow['prod_id']?>" />
		<select name="size" style="font-size:11px;width:130px;" onChange="getQty('qty.php?size='+this.value+'&prod_id='+<?=$frow['prod_id']?>+'&des_id='+<?=$frow['des_id']?>+'&color_id='+<?=$cs_row3['color_id']?>)">
			<option value="">-select a size-</option>
            <?php
           
            $cs1 = mysql_query("select * from tblsize where bust>0") or die(mysql_error());
			while($cs_row1 = mysql_fetch_array($cs1)){
			
			$size_new="size_".strtolower($cs_row1['size_name']);
			
			$cs5= mysql_query("select * from tbl_stock where prod_id='".$frow['prod_id']."' and cs_id='".$cs_row3['color_id']."' and $size_new!=0") or die(mysql_error());
			$num_size=mysql_num_rows($cs5);
			$cs_row5 = mysql_fetch_array($cs5);
			if($num_size!=0){
            ?>
            <option value="<?=strtolower($cs_row1['size_name'])?>">Size <?=$cs_row1['size_name']?></option>
            <?php }   } ?>
		   </select>
	    </td><td>
		<div id="qtydiv" style="width:100px;margin-left:10px;">
		<select name="qty" style="font-size:11px;width:45px;">
        <option value=""> 0 </option>
        </select>
		</div>
		</td></tr>
		</table> <br />
	
<?=strtoupper('<strong>Availability:</strong> Ships Within 5-7 Business Days')?> <br /> 
	<table><tr><td>
	<input type="hidden" name="addcart" value="addcart" /><input type="image" src="images/btn_addtobag.gif" class="addtobag"/>
    </td><td style="vertical-align:middle;">
     <?
		if($error !='')
		{
			?> &nbsp; <span style="color:#CC0000;font-size:12px;font-weight:bold;"><? echo $error;?></span>
			<?
		}
		?>
    </td></tr></table>
    <br />
</form>
</div>



	<table border="0"><tr><td style="width:180px;">
    <div id="snlogos">
<table width="80" border="0">
	<tr height="30">
	<td><a href="#" onclick="return addthis_sendto('facebook');"><img src="images/facebook.gif" border="0"></a></td><td><a href="#" onclick="return addthis_sendto('twitter');"><img src="images/twitter.gif" border="0"></a></td><td><a href="#" onclick="return addthis_sendto('print');"><img src="images/print.gif" border="0"></a></td>
	</tr>
	</table><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=xa-4a67ed4c7662278c"></script>
<a href="#" onclick="javascript:Show_Popup();"><img src="images/send_dress.gif" border="0" /></a>
</div>
<?php 
if(isset($color_id) && !empty($color_id)) {
	
		 $col_new=$_GET['color_id'];
		 
	} else {
	
		 $col_new=$frow['primary_img_id'];
	}

?>

    
<div id="window" style="display: none;">
<form name="sendfriend" action="womens_apparel_product.php?catID=<?php echo $_GET['catID']?>&subcatID=<?php echo $_GET['subcatID']?>&pro_id=<?php echo $_GET['pro_id']?>&zoom=<?php $_GET['zoom']?>&TypeID=<?php echo $_GET['TypeID']?>" method="post" enctype='multipart/form-data'>
<table width="100%" cellpadding="2" cellspacing="2" align="center">
<tr bgcolor="#f2f2f2" height="25px">
  	<td  align="left" width="70%" colspan="2"><div style="float:left;" class="text"><b>Send Photo To Friends</b></div><div style="float:right"><a href="#" onclick="Close_Popup();"><img src="images/cross.gif" border="0" style="vertical-align:middle;"/></a></div></td>
  </tr>
  <tr>
  	<td colspan="2"><input type="image" src="resizeimage.php?w=100&h=125&constrain2=1&img=images/product_front/<?=$frow['prod_no'];?>_<?=$col_new;?>.jpg" /></td>
  </tr>
  <tr>
    <td  class="ntxt">From :</td>
    <td ><input type="text" name="from" class="inputbox2" id="email1"/>    </td>
  </tr>
  <tr>
    <td  class="ntxt">To :</td>
    <td ><input type="text" name="to" class="inputbox2" id="email"/>    </td>
  </tr>
  <!--<tr>
    <td class="ntxt">Subject : </td>
    <td><input type="text" name="subject" class="inputbox2"/></td>
  </tr>-->
  <tr>
    <td valign="top" class="ntxt">Comments:</td>
    <td>
      <textarea name="msg" cols="50" rows="5" class="inputbox2"></textarea>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="hidden" name="option" value="friendmail" /><input type="button" value="Send" name="send" class="bottonlook2"  onclick="email_chk()"/></td>
  </tr>
</table>
</form>
</div>


	</td><td style="vertical-align:top;">
	</td></tr>
	</table>
	<br />
	<div style="margin-bottom:2px;"><strong>PRODUCT OVERVIEW:</strong></div>
	<?=$frow['prod_desc']?>
	<br /><br />
	
	</td>
	
	</tr>
	<tr><td style="vertical-align:bottom;text-align:left;"><div class="stylex" align="left">
	<?php 
	if(isset($color_id) && !empty($color_id)) {
	 $image_front="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_front/".$frow['prod_no']."_".$color_id.".jpg";
	 }else{
	 $image_front="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_front/".$frow['prod_no']."_".$frow['primary_img_id'].".jpg";
	 }
	 if (file_exists($image_front)) {
	 ?>
	<a href='<?=$image_front?>' class='cloud-zoom-gallery' title='Front View'
		rel="useZoom: 'zoom1', smallImage: 'resizeimage.php?w=325&h=487&constrain2=1&img=<?=$image_front?>' " id="img_view" >
	<img src="res.php?w=60&h=90&constrain2=1&img=<?php echo $image_front;?>" style="width:60px;height:90px;" alt = "<?=$frow['prod_name']?>" class="imgBorder"/></a>
	<?php } ?>
	
	<?php
	if(isset($color_id) && !empty($color_id)) {
	 $image_side="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_side/".$frow['prod_no']."_".$color_id.".jpg";
}else{
	 $image_side="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_side/".$frow['prod_no']."_".$frow['primary_img_id'].".jpg";

}
	 if (file_exists($image_side)) {

	 ?>
	<a href='<?=$image_side?>' class='cloud-zoom-gallery' title='Side View'
		rel="useZoom: 'zoom1', smallImage: 'resizeimage.php?w=325&h=487&constrain2=1&img=<?=$image_side?>' " id="img_view">
	<img src="res.php?w=60&h=90&constrain2=1&img=<?php echo $image_side;?>" style="width:60px;height:90px;"  alt = "<?=$frow['prod_name']?>" class="imgBorder"/></a>
	<?php } ?>
	
	<?php 
	if(isset($color_id) && !empty($color_id)) {
	 $image_back="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_back/".$frow['prod_no']."_".$color_id.".jpg";
	 
}else{

	 $image_back="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_back/".$frow['prod_no']."_".$frow['primary_img_id'].".jpg";

}
	 if (file_exists($image_back)) {

	 ?>
	<a href='<?=$image_back?>' class='cloud-zoom-gallery' title='Back View'
		rel="useZoom: 'zoom1', smallImage: 'resizeimage.php?w=325&h=487&constrain2=1&img=<?=$image_back?>' " id="img_view">
	<img src="res.php?w=60&h=90&constrain2=1&img=<?php echo $image_back;?>" style="width:60px;height:90px;"  alt = "<?=$frow['prod_name']?>" class="imgBorder"/></a>
	<? } 
  $domain = $_SERVER['HTTP_HOST'];
  $url2 = "http://" . $domain ;
	if(isset($color_id) && !empty($color_id)) {
	 $video_play="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_video/".$frow['prod_no']."_".$color_id.".flv";
	 }else{
	 $video_play="product_assets/WMANSAPREL/".$frow['designer_folder']."/".$frow['subcat_folder']."/product_video/".$frow['prod_no']."_".$frow['primary_img_id'].".flv";
	 }
	
	if(file_exists($video_play)) {?>	
    <a id='showVideo' href="javascript:alert('No videos for this product.');" style="color:red" class='tooltip'>
	<img src="res.php?w=60&h=90&constrain2=1&img=images/instylelnylogo.jpg" class="imgBorder"/></a>
    <?php } ?>
	</div></td>
	<td>&nbsp;</td>
	</tr>
	</table>
	</div>
    </div><!-- end div id wrapper-->
    
</div><!-- end div id mainbg-->
<br class="clear-all"/>
<? include "footer.php"; 
?>

<script src="js/activatables.js" type="text/javascript"></script>
<script type="text/javascript">
	activatables('page', ['page-1', 'page-2']);
</script>

<script>
imgvideoFx = new Fx.Reveal($('imgvideo'),{duration: 500, mode: 'horizontal'});
imgFx= new Fx.Reveal($('imgmain'),{duration: 500, mode: 'horizontal'});
$('closebtn').addEvent('click',function(){imgvideoFx.dissolve();imgFx.reveal();$('closebtn').style.visibility='hidden';});
$('img_view').addEvent('click',function(){$('image_div').style.visibility='visible';});
$('showVideo').set('href','javascript:void(0)');
$('showVideo').addEvent('click',function(){showVideofn()});
var showVideofn=function(){
$('image_div').style.visibility='hidden';
imgFx.dissolve();
imgvideoFx.reveal();

var visibVid=function(){
$('vidcont').style.visibility='visible';
$('vidcont').style.width="325px";
$('vidcont').style.height="487px";
}
$('vidcont').style.width="1px";
$('vidcont').style.height="1px";
$('vidcont').style.align="left";
//$('vidcont').style.visibility='hidden';
 var so = new SWFObject('js/player.swf','ply','325','487','9','#000000');
  so.addParam('allowfullscreen','true');
  so.addParam('allowscriptaccess','always');
  so.addVariable('autostart','true');
  so.addParam('wmode','transparent');
  so.addVariable('repeat','always');
  so.addVariable('icons','false');
  so.addVariable('playerready','visibVid');
  so.addParam("salign", "l");
  so.addParam("align", "l");  
  so.addVariable('file','<?=$url2?>/<?=$video_play?>');
  so.write('vidcont');
//$('closebtn').style.visibility='visible';	
return false;
}
</script>


</body>
</html>