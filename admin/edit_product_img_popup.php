<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");

$prod_id = $_POST['prod_id'];
$act     = $_POST['act'];
$mode    = $_POST['mode'];
$color   = $_POST['cs'];
$size    = $_POST['size'];

if($size) {
$sizes = implode(',',$size);
}
if(isset($_POST['cmdSubmit']))
{	


$getpic = mysql_query("SELECT  * FROM  tbl_color_size  WHERE cs_id='".$color."'") or die(mysql_error());
$getres=mysql_fetch_array($getpic);

	
		mysql_query("insert into tbl_product_imgs (
						prod_id, 
						color_id, 
						colors, 
						img_back, 
						img_01, 
						img_02, 
						img_03, 
						img_04,
						video,  
						sizes) values (
						'".$prod_id."', 
						'".$color."', 
						'".$getres['color']."', 
						'".$prod_img4."', 
						'".$prod_img0."', 
						'".$prod_img1."', 
						'".$prod_img2."', 
						'".$prod_img3."',
						'".$video."', 
						'".$sizes."')
					") or die(mysql_error());
   		
		print "<script>opener.location.href='edit_new_par_product.php?act=".$act."&prod_id=".$prod_id."&mode=".$mode."';window.close();</script>";
	
}

 
?>
<title>In Style New York::Admin Section</title>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	$('#submit').click(function() {
	  $('#loading').show();
	});
});
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
	
	
	
	function getCs(strURL) {		
		
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('csdiv').innerHTML=req.responseText;						
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
<link href="style.css" rel="stylesheet" type="text/css">

	<center><span  class="text"><strong>UPLOAD PRODUCT PICTURE</strong><br />
	<span style="color:#ff0000;"><strong><? echo @$msg;?></strong></span>&nbsp;</span></center>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">

          <form name="prod_frm" method="post" action="edit_product_img_popup.php?act=add" enctype="multipart/form-data">
         	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  				<tr valign="top">
					<td class="border_color">
						<table border="0" cellpadding="5" cellspacing="1" width=100%  valign = "top">
                <!--DWLayoutTable-->
                <input type="hidden" name="prod_id" value="<?=$_GET['prod_id']?>">
				<input type="hidden" name="act" value="show">
				<input type="hidden" name="mode" value="e">
                <input type="hidden" name="hidOldFile1" value="<?PHP print $p_row['prod_image'] ; ?>">
                <? if(@$prod_return==1){?>
                <tr bgcolor="#eeeeee"> 
                  <td class="error" colspan=2>&nbsp;</td>
                </tr>
                <? }?>
				<tr bgcolor="#eeeeee"> 
                  <td class="text" align="right">Color : </td>
                  <td align="left" class="text">
				  <?php
				  $cs = mysql_query("select * from tbl_color_size where des_id='".$_GET['des_id']."'") or die(mysql_error());
				  if(mysql_num_rows($cs) > 0) {
				  	?> <select name="cs" style="font-size:11px;" onChange="getCs('color_size.php?cs_id='+this.value)">
						<option> - select color - </option>
					 <?php
				  	while($cs_row = mysql_fetch_array($cs)) {
						?>
						<option value="<?=$cs_row['cs_id']?>" <?php echo $cs_row['cs_id']==$get_img['colors'] ? 'selected' : ''; ?>><?=$cs_row['color']?> - <?=$cs_row['style']?></option>
						<?
					}
					?> </select> <?php
				  } else {
				  	echo '<option> no available color </option>';
				  }
				  ?>
				  </td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td class="text" align="right" style="line-height:18px;">Sizes : <br /> Stock :</td>
                  <td class="text">
				 <div id="csdiv">select color</div>
				  </td>
                </tr>		
				
                <tr bgcolor="#eeeeee"> 
                  <td colspan=2 align=center> <input type="submit" id="submit" style="width:100px;" name="cmdSubmit" class=button value="Upload & Save">                   </td>
                </tr>
              </table>
				  </td>
					</tr>
				</table>
			</form>

	
	</td>
</tr>
</table>
			  <div style="text-align:center;display:none;" class="text" id="loading">Uploading images. Please wait...</div>