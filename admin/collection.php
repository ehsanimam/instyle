<? 
include ("common.php"); 
include "functions.php";

$intid1=get_param("id");


if($intid1=="")
{
//$intid=6;
//Mod BY p@arrth
$latsql="select max(cat_id) l from tblcat";
$lat_id=mysql_query($latsql);
$intid=mysql_result($lat_id,"l");
//echo $intid;

}else{
$intid=$intid1;
}
             
$rno = 5;

$sql = "select * from tblproduct where prod_name like '".$txtSearch ."%' order by prod_name";	


	
$pr_rs=mysql_query($sql);

$rnum=mysql_num_rows($pr_rs);
$i_sls =0;


if($rnum>=0)
     {
        $mod=$rnum%$rno;
        if($mod>0)
        {
          $tpage=($rnum-$mod)/$rno +1; 
        }
        else
        {
          $tpage=($rnum-$mod)/$rno;
        }
        if($cpage=="")
        {
          $cpage=1;       /*variable for page no.....*/
        }

        $skip=($cpage-1)*$rno;
		if(($skip+$rno)>$rnum)
 
        {
          $lmt=$rnum-$skip;
        }
        else
        {
          $lmt=$rno;
        }
        $start=$skip +1;
        $end=$skip + $lmt;
}


if (($btnS) && ($txtSearch!="")):
	$query = "select * from tblproduct where prod_name like '".$txtSearch ."%' order by prod_name";	
else:
$query = "select * from tblproduct where cat_id =".$intid."  order by prod_date desc limit $skip,$lmt ";

endif;


$pr_rs1=mysql_query($query);

$rnum1=mysql_num_rows($pr_rs1);

if ($rnum1!=0){

	$i_sl = 0;
	if($i_sl==0)
	
	$pid_first = mysql_result($pr_rs1,$i_sl,"prod_id");
	$p_id = mysql_result($pr_rs1,$i_sl,"prod_id");
	$p_nm = mysql_result($pr_rs1,$i_sl,"prod_name");
	$p_img = mysql_result($pr_rs1,$i_sl,"prod_image");
	
						
	if ($i_sl=="0"):
		$n_pr_img = $p_img;
	
	endif;	

}

//Query for slideshow
$sql7 = "select * from tblproduct order by rand()";	
$pr_rs7=mysql_query($sql7);
$rnum7=mysql_num_rows($pr_rs7);
$i_sls7 =0;

	$curr_url=str_replace("/","",($SCRIPT_NAME));
	$curr_url1=$_SERVER['PHP_SELF'];
	
	$curr_url2=$_SERVER['QUERY_STRING'];
	
	$curr_url3=str_replace("/","",($curr_url1."?".$curr_url2)); 
	$page=get_param("cpage");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="generator" content="Adobe GoLive" />
		<title>Untitled Page</title>
		<style>
		
		</style>
		<script language="JavaScript" src="css.js"></script>
<script>
var d = document.getElementById("bottomFrame");
if(d)alert(d.name);
if(d)d.height="600px";

</script>
<script>
<!--

function CallBig(m,n,o,p,q)
		{
			var frm = document.frm_main;		
			frm.action = 'collection.php?id='+q;
			frm.pr_img.value = m;
			frm.pr_cd.value = n;
			frm.skip1.value = o;
			frm.lmt1.value = p;
			frm.intid.value = q;
			frm.submit();
		}
		function callImg(m)
		{
			window.open("imgB.php?img="+ m,"popWin","width=880 height=550 scrollbars=1");
		}
//-->
</script>
<style type="text/css">

#photoholder {
	width:599px;
	height:410px;
	border:none;
	background:#ffffff url('images/loading2.gif') 50% 50% no-repeat;
	//background-image:url('images/loading2.gif');
}
#thephoto {
	width:599px;
	height:410px;
}

body {
		text-align: center; /* for IE */
	}
	#container {
		margin: 0 auto;   /* align for good browsers */
		text-align: left; /* counter the body center */
		
	}
</style>
<script type="text/javascript">
<!--
var d= new Image();
d.src="images/loading2.gif";
document.write("<style type='text/css'>#thephoto {visibility:hidden;}</style>");

function initImage() {
	imageId = 'thephoto';
	image = document.getElementById(imageId);
	setOpacity(image, 0);
	image.style.visibility = "visible";
	fadeIn(imageId,0);
}
function fadeIn(objId,opacity) {
	if (document.getElementById) {
		obj = document.getElementById(objId);
		if (opacity <= 100) {
			setOpacity(obj, opacity);
			opacity += 10;
			window.setTimeout("fadeIn('"+objId+"',"+opacity+")", 100);
		}
	}
}
function setOpacity(obj, opacity) {
	opacity = (opacity == 100)?99.999:opacity;
	// IE/Win
	obj.style.filter = "alpha(opacity:"+opacity+")";
	// Safari<1.2, Konqueror
	obj.style.KHTMLOpacity = opacity/100;
	// Older Mozilla and Firefox
	obj.style.MozOpacity = opacity/100;
	// Safari 1.2, newer Firefox and Mozilla, CSS3
	obj.style.opacity = opacity/100;
}
//window.onload = function() {initImage()}
// -->
</script>
<style type="text/css">
@import "css/glide-scroll-rel-v.css";
</style>
<script src="js/dw_scrollObj.js" type="text/javascript"></script>
<script src="js/dw_glidescroll.js" type="text/javascript"></script>
<script type="text/javascript">
/*************************************************************************
  This code is from Dynamic Web Coding at www.dyn-web.com
  Copyright 2001-4 by Sharon Paine 
  See Terms of Use at www.dyn-web.com/bus/terms.html
  regarding conditions under which you may use this code.
  This notice must be retained in the code as is!
*************************************************************************/

function initScrollLayer() {
  // arguments: id of layer containing scrolling layers (clipped layer), id of layer to scroll, 
  // if horizontal scrolling, id of element containing scrolling content (table?)
  var wndo = new dw_scrollObj('wn', 'lyr1', null);
  
  // pass id's of any wndo's that scroll inside tables
  // i.e., if you have 3 (with id's wn1, wn2, wn3): dw_scrollObj.GeckoTableBugFix('wn1', 'wn2', 'wn3');
  dw_scrollObj.GeckoTableBugFix('wn'); 
}

</script>	
<link href="ie.css" rel="stylesheet" type="text/css">
</head>



	<body bgcolor="#000000" onload="initScrollLayer();initImage()">
			<table width="100%" align="center" bgcolor="#444341" cellspacing="0" cellpadding="10">
			<tr>
			<td>
		<table border="0" align="center" cellspacing="0" cellpadding="0"  >
			<tr>
				<td valign="top" align="left" style="width:175px!important;width:205px">
				
				<table width="100%">
				<tr>
				<td height="150" valign="top">
				<table border="0" cellspacing="0" cellpadding="0" align="left">
                 <div style="font-family:Verdana,Arial;text-transform:uppercase;color:#ffffff;font-size:11px;font-stretch: extra-condensed">
				 Current Collections:
				                        <?
		
		
				$q = "select * from tblcat";
				
				$r = mysql_query($q);
				$rows = mysql_num_rows($r);
				
				$i = 0;
				while($i<$rows):
								  	
				$cat_name = mysql_result($r,$i,"cat_name");
				$cat_id = mysql_result($r,$i,"cat_id");
					
					
?>
                                        <tr align="left" valign="top" onMouseOver="this.bgColor='#cccccc'" onMouseOut="this.bgColor=''"> 
                                          
                                          <td width="100%"> 
                                            <? if(($curr_url3=="collection.php?id=$cat_id")||($curr_url3=="collection.php?cpage=$page&id=$cat_id")||($cat_id==$intid)) {?>
                                            <a href="nv/collection.php?id=<?=$cat_id?>" ><font color="#000000"> 
                                            <?=$cat_name?>
                                            </font> </a> 
                                            <? }else{ ?>
                                            <a href="collection.php?id=<?=$cat_id?>"><font color="#666666"> 
                                            <?=$cat_name?>
                                            </font> </a> 
                                            <? }?>
                                          </td>
                                        </tr>
                                        <?  
	$i++;
	
	endwhile;
	
	?>
	</div>
	</table>
				</td>
				</tr>
				<tr>
				<td valign="bottom">
				
				<table width="100%" align="left">
				<tr>
				<td valign="bottom" height="190">
				<?if($pr_cd=="")
				$pr_cd = $pid_first;
				
				if ($pr_cd):
					$q_st = "select * from tblproduct where prod_id = ". $pr_cd;
						
					$r_st = mysql_query($q_st);
					$pr_nm = mysql_result($r_st,0,"prod_name");
					
					//Mod By P@arrth
					$pr_descp = mysql_result($r_st,0,"prod_desc");
				
					$q_c = "select color_id from tblproduct where prod_id = ". $pr_cd;					
					$r_c = mysql_query($q_c);
					$i = 0;
					$rows = mysql_num_rows($r_c);
					$color_id = "";
					while($rows>$i):
						$color_id = $color_id . ",". mysql_result($r_c,$i,"color_id");
					$i++;
					endwhile;
					
					$q_cl = "select * from tblcolor where color_id in (". substr($color_id,1).")";
					$r_cl = mysql_query($q_cl);
					$i_cl = 0;
					$rows_cl = mysql_num_rows($r_cl);
					$color_nm = "";
					while($rows_cl>$i_cl):
						$color_nm = $color_nm . ",". mysql_result($r_cl,$i_cl,"color_name");
					$i_cl++;
					endwhile;

					//= Size ===
					$q_s = "select size_id from tblproduct where prod_id = ". $pr_cd;
					$r_s = mysql_query($q_s);
					$i_s = 0;
					$rows_s = mysql_num_rows($r_s);
					$size_id = "";
					while($rows_s>$i_s):
						$size_id = $size_id . ",". mysql_result($r_s,$i_s,"size_id");
					$i_s++;
					endwhile;

					if (substr($size_id,1)!=""):
						$q_sz = "select * from tblsize where size_id in (". substr($size_id,1).")";
						$r_sz = mysql_query($q_sz);
						$i_sz = 0;
						$rows_sz = mysql_num_rows($r_sz);
						$size_nm = "";
						if ($rows_sz>0):
							while($rows_sz>$i_sz):
								$size_nm = $size_nm . ",". mysql_result($r_sz,$i_sz,"size_name");
							$i_sz++;
							endwhile;
						endif;
					endif;
				endif;?>
				<br /><br />
				<div style="text-align:left">
Name:<br /><font style="font-face:Arial;font-size:12px;color:#b7b6b6"><?=$pr_nm?> </font><br /><br />
Description:<br /><div style="font-face:Arial;font-size:12px;color:#b7b6b6;height:50px;"><?=$pr_descp?></div><br /><br />

 <?if ($pr_img):?>
                                            <a class="lnk1" href="JavaScript:callImg('<?=$pr_img?>');">Zoom</a> 
                                            <?else:?>
                                            <a class="lnk1" href="JavaScript:callImg('<?=$n_pr_img?>');">Zoom</a> 
                                            <?endif;?>
<br /><br />
<a href="colorsamples.html" style="font-face:Arial;font-size:12px;color:#fffff">view color samples</a>
<br /><br />
<a href="samplesale.html" style="font-face:Arial;font-size:12px;color:#fffff">Enquire on this product</a>
</div>
  <?if($cpage>1){?>
                                            <a href="collection.php?cpage=<?echo $cpage-1;?>&id=<?=$intid?>" class="TextMenuHeadLine"><strong>PREVIOUS PAGE</strong></a> 
                                            <?}?>
                                          </td>
                                          <td align="right" colspan="2" valign="top" class="TextMenuHeadLine"> 
                                            <?if($cpage<$tpage){?>
                                            <a href="collection.php?cpage=<?echo $cpage+1;?>&id=<?=$intid?>" class="TextMenuHeadLine"><strong>NEXT PAGE</strong></a> 
                                            <?}?>
													</td>
				</tr>
				</table>
				
				</td>
				</tr>
				</table>
				</td>
				<td width="120">
				
				<div id="hold">
<div id="wn"> 
 
	<div id="lyr1" class="content">
<form name='frm_main' method="post" action ="<?=$PHP_SELF?>">  
				<table id="imgTbl" align="center" border="0" cellpadding="0" cellspacing="0">
                                  
                                    <?
							
	
			if (($btnS) && ($txtSearch!="")):
				$q = "select * from tblproduct where prod_name like'". $txtSearch ."%'";
			
							
			else:
				if (($skip1) && ($lmt1)):
					$q = "select * from tblproduct where cat_id =".$intid."  order by prod_date desc limit $skip1,$lmt1 ";
			
				else:
					$q = "select * from tblproduct where cat_id =".$intid."  order by prod_date desc limit $skip,$lmt ";
				
		

				endif;
			endif;
			
				$r = mysql_query($q);
				$rows = mysql_num_rows($r);
				$i = 0;
				$m = 1;
				while($i<$rows):
				  
				  if($i==0)
				  
					$p_id_first = mysql_result($r,$i,"prod_id");
					
					$p_id = mysql_result($r,$i,"prod_id");
					$p_nm = mysql_result($r,$i,"prod_name");
					$p_img = mysql_result($r,$i,"prod_image");
					$p_price = mysql_result($r,$i,"prod_price");
					$p_disprice = mysql_result($r,$i,"discount_price");
					$intid = mysql_result($r,$i,"cat_id");
					$subcat_id = mysql_result($r,$i,"subcat_id");
					
										
					if ($i=="0"):
						$n_pr_img = $p_img;
				
					endif;?>
                                    <tr> 
                                    <td>
                                    <a href="JavaScript:CallBig('<?=$p_img?>','<?=$p_id?>','<?=$skip?>','<?=$lmt?>','<?=$intid?>');" title="Detail" ><img src="../siteadmin/product_picture/mini_thumb/<?=$p_img?>" width="90" height="70" border="0"></a><img src="images/spacer.jpg" width="5" height="1">
                                    </td>
                                     </tr>
                                    <?  
						
					//	$v = $m/6 ;
						
					//	$brk = strpos($v,".");
					//	if ($brk=="") {echo "<tr>";} 
					//	$m++;
						$i++;
						endwhile;
						
						?>
                                 
                               
                             
                <? $pr_img="" ;?>
				<script>
				var r = new Image();
				r.src='../siteadmin/product_picture/thumb_zoom/<?=$p_img?>';
				</script>

                <input type='hidden' name='pr_img' value="<?=$pr_img?>">
                <input type='hidden' name='pr_cd' value="<?=$pr_cd?>">
                <input type='hidden' name='cat_id' value="<?=$cat_id?>">
                <input type='hidden' name='skip1' value="<?=$skip?>">
                <input type='hidden' name='lmt1' value="<?=$lmt?>">
                <input type='hidden' name='intid' value="<?=$intid?>">
                <input type='hidden' name='cpage' value="<?=$cpage?>">
                <input type='hidden' name='pid_first' value="<?=$p_id_first?>">
              </form>
            </table>
			</div>
		</div>
	</div>
				</td>
				</td>

		<td>
<table class="scrollLinks" border="0" cellpadding="0" cellspacing="0">
<tr>
<!-- dw_scrollObj.scrollBy arguments: scroll area id (this is also first argument to constructor), 
     amount to scroll onclick on x, y axes, (optional, not included here) duration of glide -->
	<td valign="top"><a href="javascript:;" onclick="dw_scrollObj.scrollBy('wn',0,140); return false" title="Click to scroll"><img src="images/aro-up.gif" width="11" height="18" alt="" /></a>
	</td>
</tr>
<tr>
<td class="spacer"></td>
</tr>

<tr>
	<td valign="bottom"><a href="javascript:;" onclick="dw_scrollObj.scrollBy('wn',0,-140); return false" title="Click to scroll"><img src="images/aro-dn.gif" width="11" height="18" alt="" /></a>
	</td>
	
	</tr>
</table>
</td>
				<td>
				<?if ($pr_img):?>
                    <a  href="#"><img src="../siteadmin/product_picture/medium/<?=$pr_img?>"  width="599" height="410" border="0" alt="Click here to zoom" onclick="JavaScript:callImg('<?=$pr_img?>');" /></a> 
                    <?elseif($n_pr_img):?>
                    <a  href="#"><img src="../siteadmin/product_picture/medium/<?=$n_pr_img?>" width="599"  height="410" border="0" alt="Click here to zoom" onclick="JavaScript:callImg('<?=$n_pr_img?>');" /></a> 
                    <?else:?>
                    <img src="images/collection.jpg" width="599" height="410" /> 
                    <?endif;?>
				</td>
			</tr>
		</table>
		</td>
		</tr>
	</table>
		<p></p>
	</body>

</html>