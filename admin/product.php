<?php
	include("common.php");
	include("webfunction.php");
//===================================Meta code area==============================================
$thispage = substr($_SERVER["PHP_SELF"],6,strlen($_SERVER["PHP_SELF"]));
list($thisfilename,$thissurname) = split('[/.-]',$thispage,2);
$Strmet = sprintf("SELECT * FROM `tblmeta` WHERE `pagename`='%s' limit 1", $thisfilename);
$aobj =mysql_query($Strmet);
$a = mysql_fetch_array($aobj);

if($a['title']!=""){$mytitle = $a['title'];}else{$mytitle="Online Luxury Shopping Below Retail Pricing at Instylenewyork.com";}

if($a['description']!=""){$mydesc = $a['description'];}else{$mydesc="Visit instylenewyork.com for Apparel for Her featuring new collections from top designers.  instylenewyork.com  has fashions top names in clothing, shoes, jewelries, bridal, collections and accessories for women, men, and kids.";}

if($a['keyword']!=""){$mykey = $a['keyword'];}else{$mykey="InStyle New York,InCircle,prada,bcbg,marc jacobs,chloe,frye,juicy couture,manolo blahnik,isabella fiore,eileen fisher,kate spade,vera wang,stuart weitzman,catherine malandrino,rock and republic,burberry,Theory,seven jeans,trina turk,dior,dana buchman,lacoste,tory by trb,yves saint laurent, instylenewyork.com";}


$sql_prod = "select * from tbl_product where prod_id='".$_GET['pro_id']."' and view_status='Y' and  hide_sketch='N' ORDER BY seque ASC"; 
						echo "sql is in : ".$sql_prod;
						
						$prod_data = MyQuery($sql_prod);

$mytitle=$prod_data[2].'-'.QueryDesigner($prod_data[14]).'-'.$prod_data[3];
//===================================End Meta code area==============================================

//+++++++++++++++++++++++++++++++++EMAIL SUBSCRIBE+++++++++++++++++++++++++++++++++++++++++++++++++
$this_file=$_SERVER['PHP_SELF'];
$this_str=$_SERVER['QUERY_STRING'];
if($this_str!=""){ $this_url=($this_file."?".$this_str); }else{ $this_url=($this_file);} 

if($_POST["email"]!=""){

		$sqlcheck = "select * from tblemail_subscribe where email_addr = '$_POST[email]' limit 1";
		$a = MyQuery($sqlcheck);
		if(isset($a[0]) && $a[0]!=""){
			 alert("Sorry ! email: ".$_POST[email]." already exist","product.php?".$_SERVER['QUERY_STRING'],"");		
		}
		else
		{
			$insert_email="insert into tblemail_subscribe (email_id, email_addr, create_date) values(0, '$_POST[email]', now())"; 
			 mysql_query($insert_email);
			 alert("Thank you for registering", "product.php?".$_SERVER['QUERY_STRING'],"");		
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
$sql = "SELECT * FROM `tbl_product` WHERE `subcat_id`='".$_GET['subcatID']."' AND `view_status`='Y' and  hide_sketch='N' ORDER BY `seque` ASC";
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

<script  language="JavaScript" src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script  type="text/javascript" src="js/jQuery.bubbletip-1.0.4.js"></script>
<!--<script src="js/minizoompan.js" type="text/javascript"></script>

 <script src="js/jqzoom.pack.1.0.1.js" type="text/javascript"></script>
<script src="js/jquery.jqzoom1.0.1.js" type="text/javascript"></script> -->
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>

<script type="text/javascript">
		$(document).ready(function() {
			$('#a1_up').bubbletip($('#tip1_up'), { positionAtElement: $('#sp1') });
			$('#a2_up').bubbletip($('#tip2_up'), { positionAtElement: $('#sp2') });
			$('#a3_up').bubbletip($('#tip3_up'), { positionAtElement: $('#sp3') });
			$('#a4_up').bubbletip($('#tip4_up'), { positionAtElement: $('#sp4') });
			//$('#a1_up').bubbletip($('#tip1_up'), { positionAtElement: $('#colorsample') });
			//$('#a2_up').bubbletip($('#tip2_up'), { positionAtElement: $('#addtoproject') });
			//$('#a3_up').bubbletip($('#tip3_up'), { positionAtElement: $('#email') });
			//$('#a4_up').bubbletip($('#tip4_up'), { positionAtElement: $('#ptearsheet') });

		});
	</script>

	<script type="text/javascript">
			$(document).ready(function(){

				$("#imgprod").mousemove(function(e){
					  $('.follow').css('top', (e.clientY-130)).css('left', (e.clientX-360));
					  //$('.follow').css('top', e.clientY).css('left', e.clientX);
				});

			});
		</script>


<script type="text/JavaScript">
<!--
function openManWin(url,name,wNum,hNum) {
 newWin=window.open(url,name,'resizable=yes,toolbar=no,location=no,scrollbars=yes,width='+wNum+',height='+hNum+',status=no');
 newWin.focus();
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



//-->
</script>
<script language="javascript">
function openPopUp(int_imageid)
{
	var str_url="blowup.php?p_id="+ int_imageid;
window.open(str_url, '', "status=no, resizable=no, scrollbars=no, toolbar=no, maximize=no, hotkeys=no, width=640, height=550, center");
}

function emailPopUp(int_imageid)
{
	var str_url="friend_mail.php?urls=<?php echo urlencode($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>&p_id="+int_imageid;
	window.open(str_url, '', "status=no, resizable=no, scrollbars=no, toolbar=no, maximize=no, hotkeys=no, width=550, height=350,center");
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
</script>
</head>

<body onload="MM_preloadImages('images/b_up1_2.jpg','images/b_fur1_2.jpg','images/b_bath1_2.jpg','images/b_light1_2.jpg','images/b_our1_2.jpg','images/b_press1_2.jpg','images/b_contact1_2.jpg','images/bu_co1_2.gif','images/bu_cat1_2.gif','images/bu_se1_2.gif')">

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
			<?if($_GET["f"]=="cat" || $_GET["f"]==""){?>
					<th width="68" scope="row"><div align="left"><a href="womens-apparel.php" target="_top" onclick="MM_nbGroup('down','group1','bucat12','',1)" onmouseover="MM_nbGroup('over','bucat12','images/bu_cat1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="images/bu_cat1_2.gif" name="bucat12" border="0" /></a></div></th>
					<th width="71" scope="row"><div align="left"><a href="womens-apparel-by-designer.php" target="_top" onclick="MM_nbGroup('down','group1','buco11','',1)" onmouseover="MM_nbGroup('over','buco11','images/bu_co1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="images/bu_co1_1.gif" name="buco11" border="0" /></a></div></th>
					<th width="54" scope="row"><div align="left"><a href="womens_apparel_search.php" target="_top" onclick="MM_nbGroup('down','group1','buse11','',1)" onmouseover="MM_nbGroup('over','buse11','images/bu_se1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="images/bu_se1_1.gif" name="buse11" border="0" /></a></div></th>
				<?}else{?>
					<th width="68" scope="row"><div align="left"><a href="womens-apparel.php" target="_top" onclick="MM_nbGroup('down','group1','bucat12','',1)" onmouseover="MM_nbGroup('over','bucat12','images/bu_cat1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="images/bu_cat1_1.gif" name="bucat12" border="0" /></a></div></th>
					<th width="71" scope="row"><div align="left"><a href="womens-apparel-by-designer.php" target="_top" onclick="MM_nbGroup('down','group1','buco11','',1)" onmouseover="MM_nbGroup('over','buco11','images/bu_co1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="images/bu_co1_2.gif" name="buco11" border="0" /></a></div></th>
					<th width="54" scope="row"><div align="left"><a href="womens_apparel_search.php" target="_top" onclick="MM_nbGroup('down','group1','buse11','',1)" onmouseover="MM_nbGroup('over','buse11','images/bu_se1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="images/bu_se1_1.gif" name="buse11" border="0" /></a></div></th>
				<?}?>		
			  
			  </tr>
			  <tr>
				<th colspan="3" scope="row">
				<div align="center" class="tableleftpanel">
					<?php while($row = mysql_fetch_array($res)){  ?>
					<table width="100%" cellspacing="2" cellpadding="2" border="0">
						<tbody>
						<tr>
							<td class="normal_txt borderbot txtleft"><a href="<?=$_SESSION['purl']?>.php?catID=<?php echo $row['cat_id'];?>" <?php if($row['cat_id'] == $_GET['catID'] && isset($_GET['TypeID'])==false){ ?>class="txt_page_gray"<?php }else{ ?>class="txt_page_gray"<?php } ?>><?php echo strtoupper($row['cat_name']);?></a></td>
															</tr>
															<?php 
																if($_GET['log']==1){
																	$cid = $quee['cat_id'];
																}else{
																	$cid = $_GET['catID'];
																}
																//if($cid == $row['cat_id'] && $_GET['TypeID']==''){
																$sql_subcat = "SELECT * FROM `tblsubcat` WHERE `cat_id`='".$row['cat_id']."' AND `view_status`='Y' ORDER BY `index` ASC";
																$res_sucat = mysql_query($sql_subcat);
																while($rows_subcat = mysql_fetch_array($res_sucat)){
															?>
															<tr>
																<td class="normal_txt txtleft"><a href="<?=$_SESSION['purl']?>.php?catID=<?php echo $row['cat_id'];?>&subcatID=<?php echo $rows_subcat['subcat_id']?>&pro=1" <?php if($rows_subcat['subcat_id'] == $_GET['subcatID']){ ?>class="txt_page_black"<?php }else{ ?>class="txt_page"<?php } ?>><?php echo $rows_subcat['subcat_name'];?></a></td>
															</tr>
															<?php }//} ?>
															</tbody>
														</table><br class="clear-all"/>
													<?php }?>	
					
			
					<br class="clear-all"/>
					<form name="frmsearch2" action="womens_apparel_search.php" method="get">
					<table width="100%" cellspacing="3" cellpadding="3" border="0">
						<tbody><tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY PRODUCT NAME<br/>OR STYLE NUMBER</td>
						</tr>
						<tr>
							<td class="normal_txt txtleft"><?if($_GET["product_name"]==""){?><input type="text" class="search_head width160" name="product_name" onblur="javascript:wipeIn(this,'Enter A STYLE NUMBER');" onfocus="javascript:wipeOut(this,'Enter A STYLE NUMBER');" value="Enter A STYLE NUMBER"/><?}else{?><input type="text" class="search_head width160" name="product_name" onblur="javascript:wipeIn(this,'<?=$_GET["product_name"]?>');" onfocus="javascript:wipeOut(this,'<?=$_GET["product_name"]?>');" value="<?=$_GET["product_name"]?>"/><?}?></td>
						</tr>
                        <tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY STYLE NUMBER</td>
						</tr>
                        <tr>
                        <?php $cs = mysql_query("select * from tbl_product where view_status='Y' and  hide_sketch='N'") or die(mysql_error());
 ?>
							<td><select name="productno" style="width:auto;"> 
						<option value=""> - Select Product - </option>
					 <?php
				  	while($cs_row = mysql_fetch_array($cs)) {
						?>
						<option value="<?=$cs_row['prod_id']?>" <?php if($cs_row['prod_id']==$_REQUEST['productno']){ echo 'selected="selected"'; }?>><?=$cs_row['prod_no']?></option>
						<?
					  }
					
					?> </select></td>
						</tr>
                        <tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY COlOR</td>
						</tr>
                        <tr>
                        <?php $cs1 = mysql_query("select * from tblcolor order by color_name asc") or die(mysql_error());
 ?>
							<td><select name="colorid" style="width:auto;"> 
						<option value=""> - Select Color - </option>
					 <?php
				  	while($cs_row1 = mysql_fetch_array($cs1)) {
						?>
						<option value="<?=$cs_row1['color_id']?>" <?php if($cs_row1['color_id']==$_REQUEST['colorid']){ echo 'selected="selected"'; }?>><?=$cs_row1['color_name']?></option>
						<?
					  }
					
					?> </select></td>
						</tr>
                        <tr>
							<td class="normal_txt txt_page_black" align="left">SEARCH BY DESIGNER</td>
						</tr>
                        <tr>
                        <?php $cs2 = mysql_query("select * from designer order by designer asc") or die(mysql_error());
 ?>
							<td><select name="des_id" style="width:auto;"> 
						<option value=""> - Select Designer - </option>
					 <?php
				  	while($cs_row2 = mysql_fetch_array($cs2)) {
						?>
						<option value="<?=$cs_row2['des_id']?>" <?php if($cs_row2['des_id']==$_REQUEST['des_id']){ echo 'selected="selected"'; }?>><?=$cs_row2['designer']?></option>
						<?
					  }
					
					?> </select></td>
						</tr>
						<tr>
							<td class="normal_txt txtleft"><input type="submit" class="search_head submit" name="search2" value="SEARCH">
							<input type="hidden" name="f" value="sku">
							</td>
						</tr>
						</tbody>
					</table>
					</form>
				</div></th>
			  </tr>
			</table>
		</div><!-- end div id lefpanel-->
<!-------------------------------------------For Zoom Image------------------------------------------->					
				<?php 
					if($_GET['pro_id'] != ""){ 

						$sql_prod = "select * from tbl_product where prod_id='".$_GET['pro_id']."' and view_status='Y' and  hide_sketch='N' ORDER BY seque ASC"; 
						//echo "sql is in : ".$sql_prod;
						//exit;
						$prod_data = MyQuery($sql_prod);
						if($prod_data[0] !=""){
							$id_p = $prod_data[0];  
							$img = "images/".$prod_data[15]."/".$prod_data[3]."_".$prod_data[16].".jpg"; // prod_image0
							$img_roll = $prod_data[13]; // prod_image0
							$big_img = "<a href=\"javascript:openPopUp(".$id_p.")\" class=txt_page_22>Zoom In</a>";
													
							$email_F =	"<a id=\"a3_up\" href=\"javascript:emailPopUp(".$id_p.")\">";
							$email_friend =	"<a href=\"javascript:emailPopUp(".$id_p.")\" class=\"poptip\">Email to a Friend</a>";
							$email_this =	"<a href=\"javascript:email_this(".$id_p.")\" class=\"poptip\">Email us regarding this product</a>";
							$addtoproject="<a id=\"a2_up\"  href=cart.php?act=add&p_id=$id_p&cat_id=$prod_data[6]&subcat_id=$prod_data[7]>";
												
							 $imgurl = "admin/product_picture/zoom/";
							 $imgfullurl = "admin/product_picture/";
							 $imgurl_s = "../admin/product_picture/sketch/zoom/";
							 $price = $row_zoom['catalogue_price'];  //
							 $pdesc = trim($prod_data[9]);  // prod_desc
							
						}
						$sql_zoom = "select * from tblzoom_img where prod_id='".$_GET['pro_id']."'"; 
							$zoom_data = MyQuery($sql_zoom);
							if($zoom_data[0] !=""){
								$zoomfile1 = $zoom_data[1];
								$zoomfile2 = $zoom_data[2];
							}
							else
							{
								$zoomfile1 = "";
								$zoomfile2 = "";
							}
						
				}
				else
				{
						// no prod_id value echo empty product here
				}
								?>
		<div id="bodycontent" style="height:600px;">
				<div id="product-img" style="width:470px;">
				<div id="product-head">
					<div id="product-link">
					
					<?php					
					$get_prod = mysql_fetch_array(mysql_query("SELECT
									  tp.*, d.designer as ddesigner, d.destype_id,
									  ts.subcat_name,
										t.color_name 										
										FROM
									  tbl_product tp
									  LEFT JOIN designer d ON d.des_id = tp.designer
									  JOIN tblsubcat ts ON ts.subcat_id = tp.subcat_id
									  LEFT JOIN tblcolor t ON t.color_id in (tp.colors) 
									WHERE
									  tp.prod_id='".$_GET['pro_id']."' and tp.view_status='Y'"));
					?>
					<a href="womens-apparel.php" ><?=QueryCatName($_GET['catID'])?></a> / 
					<a href="womens-apparel-by-designer.php?catID=<?=$get_prod['cat_id']?>&subcatID=<?=$get_prod['subcat_id']?>&type=<?=$get_prod['destype_id']?>&designer=<?=$get_prod['designer']?>" ><?=QueryDesigner($get_prod['designer'])?></a> / 
					<?=$get_prod['prod_name']?>
					</div>
					<!-- end div id product-link-->

					<div id="product-page" style="width:470px;">
					</div><!-- end div id product-page-->
				</div><!-- end div id product-head -->
						<div id="imgprod" class="boxgrid caption" style="width:470px; height:540px; border: 1px solid #000;">
							
						<?if($_GET["vimg"]!=""){?>
							<a href="javascript:openManWin('product800.php?prod_id=<?=$_GET["vimg"];?>','800Win',630,800);">
							<img src="resizeimage.php?w=470&constrain2=1&img=<?php echo $imgurl.$_GET["vimg"];?>"  alt="<?=$prod_data[2];?>" name="img_prod" id="img_prod" border="0"/>
						<? } else { ?>
							<a href="javascript:openManWin('product800.php?prod_id=<?=$img;?>','800Win',630,800);">
							<img src="resizeimage.php?w=470&constrain2=1&img=<?php echo $img;?>"  alt="<?=$prod_data[2];?>" name="img_prod" id="img_prod" border="0"/>
						<?}?>
						 </a> 
							
							
								<p><img src="images/Magnifying_glass.png" width="21" height="21" style="border:0px; position: absolute;" valign="middle" class="follow"/></p>
							
						</div><!-- end div id imgprod-->
				</div><!-- end div id product-img-->

				<div id="product-detail" style="width:260px;"><br /><br />
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td valign="top">
						<table border="0" cellpadding="3" cellspacing="0" width="100%" style="border:1px solid #999;">
						<tr><td style="background:#efefef;width:90px;"><strong>Product Name</strong></td><td style="background:#efefef;"><?=$get_prod['prod_name']?></td></tr>
						<tr><td><strong>Designer</strong></td><td><?=$get_prod['ddesigner']?></td></tr>
						<tr><td style="background:#efefef;"><strong>Category</strong></td><td style="background:#efefef;"><?=$get_prod['subcat_name']?></td></tr>
						<tr><td><strong>Color</strong></td><td><?=$get_prod['color_name']?></td></tr>
						<tr><td style="background:#efefef;"><strong>Size</strong></td><td style="background:#efefef;"><?=$get_prod['size_name']?></td></tr>
						<tr><td><strong>Description</strong></td><td><?=$get_prod['prod_desc']?></td></tr>
						</table><br /><br />
						<table border="0" cellpadding="3" cellspacing="0" width="100%" style="border:1px solid #999;">
						<tr>
						<td style="background:#efefef;width:70px;">Item</td><td style="background:#efefef;">Quantity</td><td style="background:#efefef;">Size/Color</td>
						</tr>
						<tr>
						<td><strong><?=$get_prod['prod_id']?></strong> <br /> Price: <?=$get_prod['catalogue_price']?> <br /> In Stock</td><td><input type="text" name="qty" style="width:25px;" /></td><td><?=$get_prod['size_name']?> / <?=$get_prod['color_name']?></td>
						</tr>						
						</table>
						<div align="right"><input type="submit" name="btnsend" value="add to cart" class="search_head submit" style="margin-top:3px;" /></div>
						
					<br />	
					</td></tr>
					<tr><td valign="bottom">
						<div class="bubbleInfo">
							<!--<span id="sp1"><a id="a1_up" href="javascript:color_samples();">
								<img src="images/colorsample.jpg" id="colorsample" />
							</a></span>
							-->
							<span  id="sp2"><?php echo $addtoproject;?><!-- <a id="a2_up" href="#"> -->
								<img src="images/addtoproject.jpg" id="addtoproject" />
							</a></span>
							<span  id="sp3"><?php echo $email_F;?><!-- <a id="a3_up" href="#"> -->
								<img src="images/email.jpg" id="email" />
							</a></span>
							<span  id="sp4"><a id="a4_up" href="javascript:print_page();">
								<img src="images/ptearsheet.jpg" id="ptearsheet" />
							</a></span>
						</div>
						   <div id="tip1_up" style="display:none;"><pre class="tip">View Color Samples</pre></div>
						   <div id="tip2_up" style="display:none;"><pre class="tip">Add to Project</pre></div>
						   <div id="tip3_up" style="display:none;"><pre class="tip"><?=$email_this;?><br/><br/><?=$email_friend;?></pre></div>
						   <div id="tip4_up" style="display:none;"><pre class="tip">Print Tear Sheet</pre></div>
					</td></tr>
					
				</table>
				

				</div><!-- end div id product-detail-->
				
		</div><!-- end div id bodycontent-->
	</div><!-- end div id wrapper-->
</div><!-- end div id mainbg-->
<br class="clear-all"/>
<div id="botwhitebg" align="center">
	<div id="wrapbottom">
		<div id="addrbot"><p>In Style New York Showroom, 979 Third Avenue ( D&D Building ), Suite 814, New York, NY 10022</p>
			<p>Phone: 646 415 9150, Fax: 646 415 8308,  Email: <a href="mailto:info@instylenewyork.com">info@instylenewyork.com</a></p>
		</div>
		<div id="copyright">Copyright 2010 In Style New York Italy</div>
	</div><!-- end div id wrapbottom-->
</div><!-- end div id botwhitebg-->

</body>
</html>





