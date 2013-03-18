<?php
session_start();
session_cache_expire(15);
$_SESSION['purl'] = 'womens_apparel_cat';
include("common.php"); 
include("webfunction.php");
//===================================Meta code area==============================================
$thispage = substr($_SERVER["PHP_SELF"],1,100);
$Strmet = "SELECT * FROM `tblmeta` WHERE `pagename`='".$thispage."'";

if($_GET["subcatID"]!=""){
if($_GET["subsubcatID"]!=""){
$Strmet = "SELECT * FROM `tblsubsubcat` WHERE `id`='".$_GET['subsubcatID']."' and `subcat_id`='".$_GET["subcatID"]."'";
}else{
$Strmet = "SELECT * FROM `tblsubcat` WHERE `subcat_id`='".$_GET['subcatID']."' and `cat_id`='".$_GET["catID"]."'";
}
} else {
$thispage = substr($_SERVER["PHP_SELF"],1,100);
$Strmet = "SELECT * FROM `tblmeta` WHERE `pagename`='".$thispage."'";

}

$aobj =mysql_query($Strmet);
$a = mysql_fetch_array($aobj);
$alt_tags = $a['alttags'];

if($a['title']!=""){$mytitle = $a['title'];}else{$mytitle="Online Luxury Shopping Below Retail Pricing at Instylenewyork.com";}

if($a['description']!=""){$mydesc = $a['description'];}else{$mydesc="Visit instylenewyork.com for Apparel for Her featuring new collections from top designers.  instylenewyork.com  has fashions top names in clothing, shoes, jewelries, bridal, collections and accessories for women, men, and kids.";}

if($a['keyword']!=""){$mykey = $a['keyword'];}else{$mykey="InStyle New York,InCircle,prada,bcbg,marc jacobs,chloe,frye,juicy couture,manolo blahnik,isabella fiore,eileen fisher,kate spade,vera wang,stuart weitzman,catherine malandrino,rock and republic,burberry,Theory,seven jeans,trina turk,dior,dana buchman,lacoste,tory by trb,yves saint laurent, instylenewyork.com";}


//===================================End Meta code area==============================================

//+++++++++++++++++++++++++++++++++EMAIL SUBSCRIBE+++++++++++++++++++++++++++++++++++++++++++++++++
$this_file=$_SERVER['PHP_SELF'];
$this_str=$_SERVER['QUERY_STRING'];
if($this_str!=""){ $this_url=($this_file."?".$this_str); }else{ $this_url=($this_file);} 

if($_POST["email"]!=""){

         
        $sqlcheck1 = "select * from tbluser where e_mail = '$_POST[email]' limit 1";
		$a1 = MyQuery($sqlcheck1);

       if(isset($a1[0]) && $a1[0]!=""){
	   
	    $sqlcheck = "select * from tblemail_subscribe where email_addr = '$_POST[email]' limit 1";
		$a = MyQuery($sqlcheck);
		if($a[0]==""){
		
			$insert_email="insert into tblemail_subscribe (email_id, email_addr, create_date) values(0, '$_POST[email]', now())"; 
			 mysql_query($insert_email);
		
		}
	   
		 header("http://instylenewyork.com/womens-apparel-search.php?".$_SERVER['QUERY_STRING']);
	   
	   
		}else{
		
		if(!ereg("^([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$", $_POST['email'])) {
				$_SESSION['msgbox']='';
				alert("Sorry! email address invalid","womens-apparel-search.php?".$_SERVER['QUERY_STRING'],"");		
			} else {
		$sqlcheck = "select * from tblemail_subscribe where email_addr = '$_POST[email]' limit 1";
		$a = MyQuery($sqlcheck);
         if(isset($a[0]) && $a[0]!=""){
		 
		 header("womens-apparel-search.php?".$_SERVER['QUERY_STRING']);
		 			//alert("", "womens-apparel-by-designer.php?".$_SERVER['QUERY_STRING'],"");	 

			 }else{
			 
			 $insert_email="insert into tblemail_subscribe (email_id, email_addr, create_date) values(0, '$_POST[email]', now())"; 
			 mysql_query($insert_email);
			 alert("Thank you for registering", "womens-apparel.php?".$_SERVER['QUERY_STRING'],"");

			 
			 }		
			}


        }
		
}
//++++++++++++++++++++++++++++++END EMAIL SUBSCRIBE+++++++++++++++++++++++++++++++++++++++++++++++++

//include("function/paganition.php");
$Strsql ="SELECT * FROM `tblcat` WHERE `view_status`='Y'  and  cat_id='1' order by priority";
$res =mysql_query($Strsql);
$ress =mysql_query($Strsql);
$quee = mysql_fetch_array($ress);
//changes 26/10/07
$type_sql ="SELECT * FROM `tbltypecat` where heading_id=1";
$type_que = mysql_query($type_sql);
//**********************

if($_GET['zoom']==1){
	header("Location:http://instylenewyork.com/womens_jewelry_product.php?".$_SERVER['QUERY_STRING']);	
	exit();
}
//echo $sql;

define('WOMENS_SITE_URL','http://instylenewyork.com/');
define('BASE_WOMENS_SITE_URL','http://instylenewyork.com/');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 

<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->

var req1;
function createRequestObject1() {
	req1 = false;
    // branch for native XMLHttpRequest object
    if(window.XMLHttpRequest) {
    	try {
			req1 = new XMLHttpRequest();
        } catch(e) {
			req1 = false;
        }
    // branch for IE/Windows ActiveX version
    } else if(window.ActiveXObject) {
       	try {
        	req1 = new ActiveXObject("Msxml2.XMLHTTP");
      	} catch(e) {
        	try {
          		req1 = new ActiveXObject("Microsoft.XMLHTTP");
        	} catch(e) {
          		req1 = false;
        	}
		}
    }
	return req1;
}
function setimgflg(cat_id,subcat_id,id)	
{
	var count = 'cid'+id;
	req1=createRequestObject1();
		if(req1) 
		{
			req1.onreadystatechange = ajaxupdate1;
			url="<?=WOMENS_SITE_URL?>viewsubcat.php?cat_id="+cat_id+'&subcat_id='+subcat_id+'&id='+id;
			req1.open("GET", url, true);
			req1.send("");
		}
}	
function ajaxupdate1() 
{
	
		if (req1.readyState == 4) 
		{
			if (req1.status == 200) 
			{
				var response = req1.responseText;
					if(response!='')
					{
					
						response= response.replace(/^\s+|\s+$/g, '');
						response1 = response.split('@!#$');
					var count = 'cid'+response1[1];
					var arrow = 'arrdown'+response1[1];
					var arrdown=document.getElementById(arrow);
					if(document.getElementById(count).style.display=="block")
					{
						document.getElementById(count).style.display="none";
						document.getElementById(count).innerHTML = "";
						arrdown.src='images/arrow_down.gif';
					}
					else
					{
						document.getElementById(count).style.display="block";
						document.getElementById(count).innerHTML = response1[0];
						arrdown.src='images/arrow_up.gif';
					}
				}
			}
			else
			{
				alert("There was a problem retrieving the data:\n" +
				req1.statusText);
			}
		}
	}
</script>

<?php
//if($_SESSION['msgbox']!='1') {
//include('modal.php');
//}
?>
<script language="javascript" type="text/javascript" src="<?=WOMENS_SITE_URL?>js/browser.js"></script>
<script language="javascript" type="text/javascript" src="<?=WOMENS_SITE_URL?>admin/js/function.js"></script>
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
<script type="text/javascript" src="<?=WOMENS_SITE_URL?>js/jquery.js"></script>
    
    <script type='text/javascript'>
	$(document).ready(function(){
	$("img.a").hover(
	function() {
	$(this).stop().animate({"opacity": "0"}, "slow");
	},
	function() {
	$(this).stop().animate({"opacity": "1"}, "slow");
	});
	 
	});
	</script>
    
    
<link href="<?=WOMENS_SITE_URL?>style/main.css" rel="stylesheet" type="text/css"/>
<link href="<?=WOMENS_SITE_URL?>style/style_b.css" rel="stylesheet" type="text/css"/>
<link href="<?=WOMENS_SITE_URL?>style/style.css" rel="stylesheet" type="text/css"/>

<title><?=$mytitle;?></title>

<style>							 
div.fadehover {
	position: relative;
	}
 
img.a {
	position: absolute;
	left: 0;
	top: 0;
	z-index: 10;
		}
 
img.b {
	position: absolute;
	left: 0;
	top: 0;
	}
 
</style>

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

</head>

<body>
<?php
//if($_SESSION['msgbox']!='1') {
//include('message.php');
//}

?>
<div id="headblackbg" align="center">
		
	<div id="topmenu">
		   <?php include('top_nav.php'); ?>
	</div><!-- end div id topmenu-->
</div><!-- end div id blackheadbg-->
<div id="mainbg" align="center">
	<div id="wrapper">
		<div id="leftpanel">
			<table width="190" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				
				<th width="71" scope="row"><div align="left"><a href="<?=WOMENS_SITE_URL?>womens-apparel.php" target="_top" onclick="MM_nbGroup('down','group1','bucat12','',1)" onmouseover="MM_nbGroup('over','bucat12','<?=BASE_WOMENS_SITE_URL?>images/bu_cat1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="<?=$site_url?>images/bu_cat1_1.gif" name="bucat12" width="70" height="32" border="0" /></a></div></th>
			<th width="68" scope="row"><div align="left"><a href="<?=WOMENS_SITE_URL?>womens-apparel-by-designer.php" target="_top" onclick="MM_nbGroup('down','group1','buco11','',1)" onmouseover="MM_nbGroup('over','buco11','<?=BASE_WOMENS_SITE_URL?>images/bu_co1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="<?=$site_url?>images/bu_co1_1.gif" name="buco11" width="67" height="32" border="0" /></a></div></th>
            <th width="54" scope="row"><div align="left"><a href="<?=WOMENS_SITE_URL?>womens-apparel-search.php" target="_top" onclick="MM_nbGroup('down','group1','buse11','',1)" onmouseover="MM_nbGroup('over','buse11','<?=BASE_WOMENS_SITE_URL?>images/bu_se1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="<?=$site_url?>images/bu_se1_2.gif" name="buse11" width="53" height="32" border="0" /></a></div></th>
			  </tr>
			  <tr>
				<th colspan="3" scope="row" style="text-align:left;">
				<div align="center" class="tableleftpanel">
					<form name="frmsearch2" action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<table width="100%" cellspacing="3" cellpadding="3" border="0">
						<tbody>
						
                        <tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY PRICE</td>
						</tr>
                        <tr>
							<td class="normal_txt txtleft">
                          <select name="productprice" onChange="frmsearch2.submit();" style="width:165px;"> 
							<option value=""> - Select price range - </option>
							<option value="25-95">$25 - $95</option>
                            <option value="95-185">$95 - $185</option>
                            <option value="185-295">$185 - $295</option>
                            <option value="295-420">$295 - $420</option>
                             <option value="420-675">$420 - $675</option>
                              <option value="675-985">$675 - $985</option>
                               <option value="985-1500">$985 - $1500</option>
                                <option value="1500-7500">$1500 - $7500</option>
                          </select>
                        	</td>
						</tr>
                        <tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY COlOR</td>
						</tr>
                        <tr>
                        <?php $cs1 = mysql_query("select * from tblcolor order by color_name asc") or die(mysql_error());
 ?>
							<td class="normal_txt txtleft"><select name="colorid" onChange="frmsearch2.submit();"  style="width:165px;"> 
						<option value=""> - Select Color - </option>
					 <?php
				  	while($cs_row1 = mysql_fetch_array($cs1)) {
						?>
						<option value="<?=$cs_row1['color_code']?>"><?=$cs_row1['color_name']?></option>
						<?
					  }
					
					?> </select></td>
						</tr>
                        <tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY DESIGNER</td>
						</tr>
                        <tr>
                        <?php $cs2 = mysql_query("select * from designer where view_status='Y' and catid='1' order by designer asc") or die(mysql_error());
 ?>
							<td class="normal_txt txtleft"><select name="des_id" onChange="frmsearch2.submit();"  style="width:165px;"> 
						<option value=""> - Select Designer - </option>
					 <?php
				  	while($cs_row2 = mysql_fetch_array($cs2)) {
						?>
						<option value="<?=$cs_row2['des_id']?>"><?=$cs_row2['designer']?></option>
						<?
					  }
					
					?> </select></td>
						</tr>
						
						
						
                   <tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY EVENT</td>
						</tr>
                        <tr>
                        <?php $cs2 = mysql_query("select * from tblevent where view_status='Y' order by event_name asc") or die(mysql_error());
 ?>
							<td class="normal_txt txtleft"><select name="event_id" onChange="frmsearch2.submit();"  style="width:165px;"> 
						<option value=""> - Select Event - </option>
					 <?php
				  	while($cs_row2 = mysql_fetch_array($cs2)) {
						?>
						<option value="<?=$cs_row2['event_name']?>"><?=$cs_row2['event_name']?></option>
						<?
					  }
					
					?> </select></td>
						</tr>
						
       <tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY STYLE</td>
						</tr>
                        <tr>
                        <?php $cs2 = mysql_query("select * from tblstyle where view_status='Y' order by style_name asc") or die(mysql_error());
 ?>
							<td class="normal_txt txtleft"><select name="style_id" onChange="frmsearch2.submit();"  style="width:165px;"> 
						<option value=""> - Select Style - </option>
					 <?php
				  	while($cs_row2 = mysql_fetch_array($cs2)) {
						?>
						<option value="<?=$cs_row2['style_id']?>"><?=$cs_row2['event_name']?></option>
						<?
					  }
					
					?> </select></td>
						</tr>						
						
						
						
						
						
						
						
						
						


						
						
<tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY STYLE# </td>
						</tr>                        
                        
<tr>
							<td class="normal_txt txtleft"><? if($_REQUEST["product_name"]==""){?><input type="text" class="search_head width160" name="product_name" onblur="javascript:wipeIn(this,'Enter A STYLE NUMBER');" onfocus="javascript:wipeOut(this,'Enter A STYLE NUMBER');" value=""/><? }else{ ?><input type="text" class="search_head width160" name="product_name" onblur="javascript:wipeIn(this,'<?=$_REQUEST["product_name"]?>');" onfocus="javascript:wipeOut(this,'<?=$_REQUEST["product_name"]?>');" value="<?=$_GET["product_name"]?>"/><? } ?></td>
						</tr>                        
						<tr>
							<td class="normal_txt txtleft"><input type="submit" class="search_head submit" name="search2" value="SEARCH">
							<input type="hidden" name="f" value="sku">
							</td>
						</tr>
						</tbody>
					</table>
					</form>
             		<br class="clear-all"/>    
               		<br class="clear-all"/>    

					<form name="frmsubscribe" action="<?=$this_url;?>" method="post" onSubmit="javascript:return _check();">
					<table width="100%" cellspacing="3" cellpadding="3" border="0">
						<tbody>
						<tr>
							<td class="normal_txt txt_page_gray2" align="left">BE IN THE KNOW</td>
						</tr>
						<tr>
							<td class="txtsize10">Register to receive product updates</td>
						</tr>
						<tr>
							<td class="normal_txt txtleft"><input type="text" name="email" class="width157" value="Your Email" onclick="if (this.value=='Your Email'){this.value='';}"/></td>
						</tr>
						<tr>
							<td class="normal_txt txtleft"><input type="submit" class="search_head submit" name="subscribe" value="SUBMIT"/></td>
						</tr>
						</tbody>
					</table>
					</form>					
				</div></th>
			  </tr>
			</table>     
		</div><!-- end div id lefpanel-->
		<div style="text-align:right;">
		<table border="0" cellspacing="0" cellpadding="0" style="width:780px;"><tr><td>

<!-- START OF BODY -->

<?php
$cat_id 	= $_GET['catID'];
$subcat_id	= $_GET['subcatID'];



if(empty($_POST['product_name']) && empty($_POST['productprice']) && empty($_POST['colorid']) && empty($_POST['event_id']) && empty($_POST['style_id']) &&  empty($_POST['des_id']) && empty($_GET['page'])) {
// BEGIN CATEGORY THUMBS
	?>
    <div style="text-align:left;font-size:12px;"> &nbsp; &nbsp; Please Select Style Number and Search</div>
    <?php
// END CATEGORY THUMBS

} else {
// BEGIN CATEGORY PRODUCT THUMBS
	if ( isset($_POST['product_name']) || isset($_POST['productprice']) || isset($_POST['colorid']) || isset($_POST['des_id']) || isset($_POST['event_id'])   || isset($_POST['style_id'])    ) 
	{
		$_SESSION['product_name']	= $_POST['product_name'];
		$_SESSION['$productprice']	= $_POST['productprice'];
		$_SESSION['$color_id']		= $_POST['colorid'];
		$_SESSION['$des_id']		= $_POST['des_id'];
		$_SESSION['$event_id']		= $_POST['event_id'];		
		$_SESSION['$style_id']		= $_POST['style_id'];				
	}
	
	$price	= explode('-',$_SESSION['$productprice']);

//echo '<br>-->'.$_SESSION['product_name'].':'.$_SESSION['$productprice'].':'.$_SESSION['$color_id'].':'.$_SESSION['$des_id'].'xxx';

		
	$adjacents = 3;
	if ($price[0]=='') {$price[0]='0';}
	if ($price[1]=='') {$price[1]='999999999.99';}	
	$sq="SELECT tp.prod_id
												FROM
												  tbl_product tp
												  JOIN tblcat c ON c.cat_id = tp.cat_id
												  JOIN tblsubcat sc ON sc.subcat_id = tp.subcat_id
												  JOIN designer d ON d.des_id = tp.designer
												  JOIN tbl_stock ts ON ts.prod_id = tp.prod_id
												WHERE
												  tp.view_status = 'Y'
                                                AND  
			             						   tp.cat_id='1'  									  
												  
												AND
												   d.view_status='Y' 
												AND
												  tp.prod_name like '%".$_SESSION['product_name']."%'
												AND
												  tp.primary_img_id like '%".$_SESSION['$color_id']."%'
												AND
												  tp.designer like '%".$_SESSION['$des_id']."%'
												AND
												  tp.events like '%".$_SESSION['$event_id']."%'
												AND
									             tp.styles like '%".$_SESSION['$style_id']."%'														  
												AND
												
												  tp.catalogue_price >= '".$price[0]."'
												AND
												  tp.catalogue_price <= '".$price[1]."'
												GROUP BY
												  tp.prod_id
												";		//echo $sq;
	$total_pages = mysql_query($sq) or die(mysql_error());
												
   // echo '<table><tr><td>details:'.$sq.'</td></tr></table>';
	//exit;						
												
	$total_pages 	= @mysql_num_rows($total_pages);	
	if($total_pages == 0) {
		echo '<div align="left" style="font-size:12px;"> &nbsp; &nbsp; No product found </div>';
	} else {
	
			$targetpage 	= WOMENS_SITE_URL."womens-apparel-search.php?s=y";
			$limit			= 25;
			
			$page = $_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit; 			//first item to display on this page
			else
				$start = 0;	
	if ($price[0]=='') {$price[0]='0';}
	if ($price[1]=='') {$price[1]='999999999.99';}	
	
			$sq = "SELECT
									  tp.prod_id, tp.seque, tp.prod_name, tp.prod_no, tp.prod_desc, tp.catalogue_price, tp.less_discount, tp.primary_img_id, tp.primary_img_id,
									  sc.folder AS subcat_folder, sc.subcat_name, 
									  d.folder AS designer_folder,tp.cat_id,tp.subcat_id
									FROM
									  tbl_product tp
									  JOIN tblcat c ON c.cat_id = tp.cat_id
									  JOIN tblsubcat sc ON sc.subcat_id = tp.subcat_id
									  JOIN designer d ON d.des_id = tp.designer
									  JOIN tbl_stock ts ON ts.prod_id = tp.prod_id
									WHERE
									  tp.view_status = 'Y'
                                      AND  
									   tp.cat_id='1'  									  
									AND
									   d.view_status='Y'
									AND
									  tp.prod_name like '%".$_SESSION['product_name']."%'
									AND
									  tp.primary_img_id like '%".$_SESSION['$color_id']."%'
									AND
									  tp.designer like '%".$_SESSION['$des_id']."%'
									AND
									  tp.events like '%".$_SESSION['$event_id']."%'									  
									AND
									  tp.styles like '%".$_SESSION['$style_id']."%'									  
									  
									AND
									  tp.catalogue_price >= '".$price[0]."'
									AND
									  tp.catalogue_price <= '".$price[1]."'
									GROUP BY
									  tp.prod_id
									ORDER BY
									  tp.seque
									LIMIT $start, $limit
									";
			//echo '<table><tr><td>details:'.$sq.'</td></tr></table>';
			//exit;						
			$result = @mysql_query($sq) or die(mysql_error());
		    
			//unset($_POST['product_name']);
			//unset($_POST['productprice']);
			//unset($_POST['colorid']);
			//unset($_POST['des_id']);
		    
			include("pagination.php");	
			//$subcat_name = @mysql_fetch_array($result);
			?>
            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-bottom:10px;">
            <tr><td style="font-size:12px;text-align:left;"> &nbsp; &nbsp; Womens Apparel / Search results (<?=$total_pages?>)</td>
            <td align="right"><div class="pagination"><? echo $pagination; ?></div></td>
            </tr></table>
            <?php
			
			while($row = mysql_fetch_array($result)) {
				$cat_id 	= $row['cat_id'];
				$subcat_id	= $row['subcat_id'];
			
				$img_url		 = BASE_WOMENS_SITE_URL.'product_assets/WMANSAPREL/'.$row['designer_folder'].'/'.$row['subcat_folder'].'/';
				$img_thumb 	     = $img_url.'product_front/'.$row['prod_no'].'_'.$row['primary_img_id'].'.jpg';
				$img_thumb_back  = $img_url.'product_back/'.$row['prod_no'].'_'.$row['primary_img_id'].'.jpg';
				$img_thumb_side  = $img_url.'product_side/'.$row['prod_no'].'_'.$row['primary_img_id'].'.jpg';
				//die($img_thumb_back);
				if($img = @GetImageSize($img_thumb)) {
					$thumb = $img_thumb;
						if($img2 = @GetImageSize($img_thumb_back)) {
							$back = $img_thumb_back;
						} else {
							if($img3 = @GetImageSize($img_thumb_side)) {
								$back = $img_thumb_side;
							} else {
								$back = $img_thumb;
							}
						}
				} else {
					$thumb = BASE_WOMENS_SITE_URL.'/images/instylelnylogo.jpg';
					$back  = BASE_WOMENS_SITE_URL.'/images/instylelnylogo.jpg';
				}
				
				?>
                <div style="width:140px; height:210px; margin:2px 2px 20px 14px; float:left;">
						  <?php $alt_tags=$row['prod_name'].'-'.$row['prod_no']; ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr><td colspan="2">
                  <div class="fadehover">
                 <a href="<?=WOMENS_SITE_URL?>womens_apparel_product.php?catID=<?=$cat_id?>&subcatID=<?=$subcat_id?>&pro_id=<?=$row['prod_id']?>&color_id=<?=$row['primary_img_id']?>">
                 <img class="a" src="<?=BASE_WOMENS_SITE_URL?>res.php?w=140&h=210&constrain2=1&img=<?=$thumb?>" border="0" style="color: #777777;" alt="<?=$alt_tags?>" title="<?=$alt_tags?>" />
                 <img class="b" src="<?=BASE_WOMENS_SITE_URL?>res.php?w=140&h=210&constrain2=1&img=<?=$back?>" border="0" style="color: #777777;" alt="" title="<?=$alt_tags?>" />               
                 </a>
                </div>
                </td>
                  </tr>
                  <tr>
                    <td width="50%" style="height:435px;text-align:left;"> <?=$row['prod_no']?></td>
                    <td width="50%" align="right" style="text-align:right;">$<?=number_format($row['catalogue_price'], 2, '.', ',')?> </td>
                  </tr>
                </table>
                </div>
                <?php
			}
			?>
            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-bottom:10px;">
            <tr><td style="font-size:12px;text-align:left;"> &nbsp; &nbsp; Womens Apparel / Search results (<?=$total_pages?>)</td>
            <td align="right"><div class="pagination"><? echo $pagination; ?></div></td>
            </tr></table>
            <?php
	}
// END CATEGORY PRODUCT THUMBS

}

?>

<!-- END OF BODY  -->

		</td></tr></table>
		</div><!-- end div id bodycontent-->
	</div><!-- end div id wrapper-->
</div><!-- end div id mainbg-->
<br class="clear-all"/>
<? include "footer.php";?>
</body>
</html>

