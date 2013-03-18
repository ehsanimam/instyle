<?php
session_start();
session_cache_expire(15);
$_SESSION['purl'] = 'womens_apparel_cat';
include("common.php"); 
include("webfunction.php");
//===================================Meta code area==============================================
$thispage = substr($_SERVER["PHP_SELF"],6,strlen($_SERVER["PHP_SELF"]));
list($thisfilename,$thissurname) = split('[/.-]',$thispage,2);

if($_GET["subcatID"]!=""){
if($_GET["subsubcatID"]!=""){
$Strmet = "SELECT * FROM `tblsubsubcat` WHERE `id`='".$_GET['subsubcatID']."' and `subcat_id`='".$_GET["subcatID"]."'";
}else{
$Strmet = "SELECT * FROM `tblsubcat` WHERE `subcat_id`='".$_GET['subcatID']."' and `cat_id`='".$_GET["catID"]."'";
}
} else {
$Strmet ="SELECT * FROM `tblcat` WHERE `cat_id`='1'";

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
	   
		 header("http://instylenewyork.com/fashion-jewelry-accessories-designer.php?".$_SERVER['QUERY_STRING']);
	   
	   
		}else{
		
		if(!ereg("^([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$", $_POST['email'])) {
				$_SESSION['msgbox']='';
				alert("Sorry! email address invalid","fashion-jewelry-accessories-designer.php?".$_SERVER['QUERY_STRING'],"");		
			} else {
		$sqlcheck = "select * from tblemail_subscribe where email_addr = '$_POST[email]' limit 1";
		$a = MyQuery($sqlcheck);
         if(isset($a[0]) && $a[0]!=""){
		 
		 header("fashion-jewelry-accessories-designer.php?".$_SERVER['QUERY_STRING']);
		 			//alert("", "fashion-jewelry-accessories-designer.php?".$_SERVER['QUERY_STRING'],"");	 

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
	header("Location:http://instylenewyork.com/womens_apparel_product.php?".$_SERVER['QUERY_STRING']);	
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
if($_SESSION['msgbox']!='1') {
include('modal.php');
}
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
				
				<th width="71" scope="row"><div align="left"><a href="<?=WOMENS_SITE_URL?>fashion-jewelry-accessories.php" target="_top" onclick="MM_nbGroup('down','group1','bucat12','',1)" onmouseover="MM_nbGroup('over','bucat12','<?=WOMENS_SITE_URL?>images/bu_cat1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="<?=WOMENS_SITE_URL?>images/bu_cat1_1.gif" name="bucat12" width="70" height="32" border="0" /></a></div></th>
				<th width="68" scope="row"><div align="left"><a href="<?=WOMENS_SITE_URL?>fashion-jewelry-accessories-designer.php" target="_top" onclick="MM_nbGroup('down','group1','buco11','',1)" onmouseover="MM_nbGroup('over','buco11','<?=WOMENS_SITE_URL?>images/bu_co1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="<?=WOMENS_SITE_URL?>images/bu_co1_2.gif" name="buco11" width="67" height="32" border="0" /></a></div></th>
				<th width="54" scope="row"><div align="left"><a href="<?=WOMENS_SITE_URL?>womens-apparel-search.php" target="_top" onclick="MM_nbGroup('down','group1','buse11','',1)" onmouseover="MM_nbGroup('over','buse11','<?=WOMENS_SITE_URL?>images/bu_se1_2.gif','',1)" onmouseout="MM_nbGroup('out')"><img src="<?=WOMENS_SITE_URL?>images/bu_se1_1.gif" name="buse11" border="0" /></a></div></th>
			  </tr>
			  <tr>
				<th colspan="3" scope="row">
				<div align="center" class="tableleftpanel">
					<?php
					$cat_id 	= $_GET['catID'];
					$subcat_id	= $_GET['subcatID']; //this par is actually designer
					$subkat_id  = $_GET['subkatID'];	
					$subsubcat_id  = $_GET['subsubcatID'];									
					$dsign =1;
					//echo ">>>>>".$cat_id.":".$subcat_id.":".$dsign;
					if ($dsign==1)
					{
					  $res = @mysql_query("SELECT * FROM `tblcat` WHERE `view_status`='Y' 
					          and cat_id='19' order by priority") or die(mysql_error());
					if(@mysql_num_rows($res) > 0) 
					{
					?>
                    <?php while($row = mysql_fetch_array($res))
					{  ?>
					 <table width="100%" cellspacing="2" cellpadding="2" border="0" >
						<tbody>
						<tr>
							<td class="normal_txt borderbot txtleft">JEWELRY AND ACCESSORIES</td>
						</tr>
						<?php 
                            if($_GET['log']==1){
                                $cid = $quee['cat_id'];
                            }else{
                                $cid = $_GET['catID'];
                            }
							
							$sql_designer = "SELECT * FROM `designer` WHERE view_status='Y' and `catid`='".
							$row['cat_id']."' order by ordering asc";
							
							$des_type = mysql_query($sql_designer);
							while($row_des = mysql_fetch_array($des_type))
							{?>
						      <tr><?php  
									$seo_url ='fashion-jewelry-accessories-designer.php'							?>								
									<td class="normal_txt txtleft"><a href="<?=$site_url?><?=$seo_url?>?catID=<?=$row['cat_id']?>&subcatID=<?=$row_des['des_id']?>" <?php if(
									$row_des['des_id'] == $_GET['subcatID']){ ?>class="txt_page_black"<?php 
									}else{?>class="txt_page_black"<?php } ?>><?php  echo $row_des['designer'];
									?></a></td>                                                            
   							 </tr>
                            <?php 
							//echo ">>>".$subcat_id."==".$row_des['des_id'];
							
							{
							$resx = @mysql_query("SELECT * FROM `tblsubcat` WHERE `view_status`='Y' and								
							cat_id='19'") 	or die(mysql_error());	
   					        if(@mysql_num_rows($resx) > 0) 
					            {
							      $seo_url ='fashion-jewelry-accessories-designer.php';		
                                   while($rowx = mysql_fetch_array($resx))
					               {  
								   //echo $row_des['des_id'].":".$rowx['subcat_id']."<<>>";
					    if (
						   (($row_des['des_id']==26) && (($rowx['subcat_id']==108)||($rowx['subcat_id']==110)) )
							||
   						   (($row_des['des_id']==28) && (($rowx['subcat_id']==111)) )	
						    ||
						   (($row_des['des_id']==27) && (($rowx['subcat_id']==109)) )
							
						   )
									   {
								   ?>
						               <tr>
	                                    <td class="normal_txt txtleft"><a href="<?=$site_url?><?=$seo_url?>?catID=<?=$row['cat_id']?>&subcatID=<?=$row_des['des_id']?>&subkatID=<?=$rowx['subcat_id']?>" <?php if($rowx['subcat_id']== $_GET['subkatID'] && $row_des['des_id'] == $_GET['subcatID']){?>class="txt_page_maroon"<?php }else{?>class="normal_txtn"
                                        <?php } ?>> <?php  echo $rowx['subcat_name'];?></a></td> 
                                       </tr>
                                       <?php 
									   }
					               }//while
 				                       ?>

				               
				              <?php }//iff
							  }//if num
							 //while
							}
							?>
							</tbody>
							</table><br class="clear-all"/> <br class="clear-all"/>
							<?php 
							
					
							} //while fetch
						 }//if num>
						} //$dsign==1 	
						
//---------------------------------------------------------------------													
				?>	
					
			
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
          <?php
		  //} else {
		  	//echo 'No designer return';
		  //}
		  ?>          
		</div><!-- end div id lefpanel-->
		<div style="text-align:right;">
		<table border="0" cellspacing="0" cellpadding="0" style="width:780px; style="margin-bottom:10px;"><tr><td>

<!-- START OF BODY -->

<?php
$cat_id 	= $_GET['catID'];
$subcat_id	= $_GET['subcatID']; //this par is actually designer
$subkat_id  = $_GET['subkatID'];  //type cat

				


if(!isset($cat_id) && !isset($subcat_id)  && !isset($subkat_id)) {
// BEGIN CATEGORY THUMBS
	$get_designer_thumbs = @mysql_query("SELECT * FROM designer WHERE view_status='Y' and catid=19") or die(mysql_error());
	if(@mysql_num_rows($get_designer_thumbs) > 0) {
		while($srow = @mysql_fetch_array($get_designer_thumbs)) {
			?>
            <div  style="width:170px; height:130px; margin:2px 5px 20px 20px; float:left; text-align:left;">
            <div>
            
            <a href="<?=WOMENS_SITE_URL?>fashion-jewelry-accessories-designer.php?catID=19&subcatID=<?php echo $srow['des_id']?>" <?php if($srow['des_id'] == $_GET['subcatID']){ ?>class="txt_page_black"<?php }else{ ?>class="normal_txtn"<?php } ?>>
            <img src="./images/designer_icon/<?=$srow['icon_img']?>" border="0" />
            </a>
            </div>
            <?=$srow['designer']?>
            </div>
            <?php
		}
	} else {
		echo 'No designer return';
	}
		echo '<div style="clear:left;"></div>';
// END CATEGORY THUMBS

} 

if(isset($cat_id) && isset($subcat_id)  ) 
{

$sql_designer = "SELECT * FROM `designer` WHERE  `des_id`='".$subcat_id."'";
$des_type = mysql_query($sql_designer);
$row_des = mysql_fetch_array($des_type);
$dname=$row_des['designer'];
$_SESSION['designer']=$dname;


$sql_designer = "SELECT * FROM `tblsubcat` WHERE  `subcat_id`='".$subkat_id."'";
$des_type = mysql_query($sql_designer);
$row_des = mysql_fetch_array($des_type);
$catname=$row_des['subcat_name'];
$_SESSION['cat']=$catname;
//echo '>>>>>'.$sql_designer;

// BEGIN CATEGORY PRODUCT THUMBS
	$adjacents = 3;
    if (isset($subkat_id)) 
	{	
	 $sq="SELECT	count(*) AS num
	  from (
	   select tp.prod_no
		FROM
		  tbl_product tp
		  JOIN tblcat c ON c.cat_id = tp.cat_id
		  JOIN tblsubcat sc ON sc.subcat_id = tp.subcat_id
		  JOIN designer d ON d.des_id = tp.designer
		  JOIN tbl_stock ts ON ts.prod_id = tp.prod_id																									        WHERE
		  c.cat_id = '".$cat_id."'
		AND
		  d.des_id = '".$subcat_id."'
		AND
		  d.view_status='Y' 
		AND
		  tp.view_status='Y' 
		And 
		  sc.subcat_id='".$subkat_id."'
		  GROUP BY
					  tp.prod_no ) as sqc";
     }
	  else
	{	
	 $sq="SELECT	count(*) AS num
	  from (
	   select tp.prod_no
		FROM
		  tbl_product tp
		  JOIN tblcat c ON c.cat_id = tp.cat_id
		  JOIN tblsubcat sc ON sc.subcat_id = tp.subcat_id
		  JOIN designer d ON d.des_id = tp.designer
		  JOIN tbl_stock ts ON ts.prod_id = tp.prod_id																									        WHERE
		  c.cat_id = '".$cat_id."'
		AND
		  d.des_id = '".$subcat_id."'
		AND
		  d.view_status='Y' 
		AND
		  tp.view_status='Y' 
		  GROUP BY
					  tp.prod_no ) as sqc"; 
     }

	$total_pages = @mysql_fetch_array(mysql_query($sq)) or die(mysql_error());
												
	$xnum = $total_pages;											
	$total_pages 	= $total_pages['num'];	
	if($total_pages == 0) {
		echo '<div align="left" style="font-size:12px;"> &nbsp; &nbsp; No product return </div>';
	} else {
	
	    if (isset($subkat_id)) 
	{	
			$targetpage 	= WOMENS_SITE_URL."fashion-jewelry-accessories-designer.php?catID=".$cat_id."&subcatID=".$subcat_id."&subkatID=".$subkat_id;
	} else
	{
			$targetpage 	= WOMENS_SITE_URL."fashion-jewelry-accessories-designer.php?catID=".$cat_id."&subcatID=".$subcat_id;
	
	}		
			$limit			= 25;
			
			$page = $_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit; 			//first item to display on this page
			else
				$start = 0;								//if no page var is given, set start to 0
			if (isset($subkat_id)) 
			{			
			 $sq = "SELECT tp.prod_id, tp.seque, tp.prod_name, tp.prod_no, tp.prod_desc, tp.catalogue_price, 
			       tp.less_discount, tp.primary_img_id, tp.primary_img_id, sc.folder AS subcat_folder, 
				   sc.subcat_name, d.folder AS designer_folder
					FROM
					  tbl_product tp
					  JOIN tblcat c ON c.cat_id = tp.cat_id
					  JOIN tblsubcat sc ON sc.subcat_id = tp.subcat_id
					  JOIN designer d ON d.des_id = tp.designer
					  JOIN tbl_stock ts ON ts.prod_id = tp.prod_id																									                    WHERE
					  c.cat_id = '".$cat_id."'
					AND
					  d.des_id = '".$subcat_id."'
					AND
					  d.view_status='Y' 
					AND
					  tp.view_status='Y' 
					And 
					  sc.subcat_id='".$subkat_id."'									  																	                    GROUP BY
					  tp.prod_no									  
					ORDER BY
					  tp.seque
					LIMIT $start, $limit
					";
				}
				  else
				{
				 $sq = "SELECT tp.prod_id, tp.seque, tp.prod_name, tp.prod_no, tp.prod_desc, 
				    tp.catalogue_price, tp.less_discount, tp.primary_img_id, tp.primary_img_id, sc.folder AS
					 subcat_folder,  sc.subcat_name, d.folder AS designer_folder
					FROM
					  tbl_product tp
					  JOIN tblcat c ON c.cat_id = tp.cat_id
					  JOIN tblsubcat sc ON sc.subcat_id = tp.subcat_id
					  JOIN designer d ON d.des_id = tp.designer
					  JOIN tbl_stock ts ON ts.prod_id = tp.prod_id																									                    WHERE
					  c.cat_id = '".$cat_id."'
					AND
					  d.des_id = '".$subcat_id."'
					AND
					  d.view_status='Y' 
					AND
					  tp.view_status='Y' 
											  																	                    GROUP BY
					  tp.prod_no 									  
					ORDER BY
					  sc.subcat_id,tp.seque
					LIMIT $start, $limit
					";				
				
				}  	
			
			$result = @mysql_query($sq) or die(mysql_error());
			$row = mysql_fetch_array($result);
			
		
			include("pagination.php");	
			//$subcat_name = @mysql_fetch_array($result);
			?>
            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-bottom:10px;">
            <tr> 
			<td style="font-size:12px;text-align:left;"> &nbsp; &nbsp; Jewelry and Accessories. <?php echo $_SESSION['designer'].". ";?><strong><?php echo $row['subcat_name'];?></strong></td>            
            <td align="right"><div class="pagination"><?=$pagination?></div></td>
            </tr></table>
            <?php
  		    $cnamex=$row['subcat_name'];
			while($row) {
			   //echo ">>>".$row['prod_no'];
			   if (($cnamex!=$row['subcat_name'])) {
			   ?>

            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-bottom:10px;">
            <tr><td style="font-size:12px;text-align:left;"> &nbsp; &nbsp; Jewelry and Accessories .<?php echo $_SESSION['designer'].". ";?><strong><?php echo $row['subcat_name'];?></strong></td>
            </tr></table>

               
               <?php
			   $cnamex=$row['subcat_name'];
			   $sfix = $cnamex;// str_replace (" ", "", $cnamex);
			    }
				$img_url		 = BASE_WOMENS_SITE_URL.'product_assets/JWLRYACCSRIES/'.$row['designer_folder'].'/'. $cnamex.'/';
				$img_thumb 	     = $img_url.'product_front/'.$row['prod_no'].'_'.$row['primary_img_id'].'.jpg';
				$img_thumb_back  = $img_url.'product_back/'.$row['prod_no'].'_'.$row['primary_img_id'].'.jpg';
				$img_thumb_side  = $img_url.'product_side/'.$row['prod_no'].'_'.$row['primary_img_id'].'.jpg'; 
		echo	"*:".$sfix.":*".$img_thumb;	
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
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <td colspan="2">
                  <div class="fadehover">
                 <a href="<?=WOMENS_SITE_URL?>womens_apparel_product.php?catID=<?=$cat_id?>&subcatID=<?=$subcat_id?>&pro_id=<?=$row['prod_id']?>&color_id=<?=$row['primary_img_id']?>">
                 <img class="a" src="<?=BASE_WOMENS_SITE_URL?>res.php?w=140&h=210&constrain2=1&img=<?=$thumb?>" border="0" alt="<?=$alt_tags?>" title="<?=$alt_tags?>" />
                 <img class="b" src="<?=BASE_WOMENS_SITE_URL?>res.php?w=140&h=210&constrain2=1&img=<?=$back?>" border="0"  alt="" title="<?=$alt_tags?>" />               
                 </a>
                </div>
                </td>
                </tr>
                <tr>
                  
                  
                    <td width="50%" style="height:434px;text-align:left;"> <?=$row['prod_no']?></td>
                    <td width="50%" align="right" style="text-align:right;">$<?=number_format($row['catalogue_price'], 2, '.', ',')?> </td>
                  
                  
                </tr>
                </table>
                </div>
                <?php
			$row = mysql_fetch_array($result);	
			}
			echo '<table> <tr><td></td></tr>
			</table>';
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



