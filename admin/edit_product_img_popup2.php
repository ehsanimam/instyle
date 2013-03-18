<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");

$color_code  = $_POST['color_code'];
$prod_id = $_POST['prod_id'];
$act     = $_POST['act'];
$mode    = $_POST['mode'];


if(isset($_POST['image_submit']))
{


$get_img1 = mysql_fetch_array(mysql_query("select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'"));
$csrow1 = mysql_fetch_array(mysql_query("select * from tblcolor where color_code='".$_REQUEST['color_code']."'"));



if ($_FILES["front_".$get_img1['prod_no']."_".$csrow1['color_code']]['name']!="")
		{
		
		
		$file_product1="../images/product_front/".$get_img1["prod_no"]."_".$csrow1["color_code"].".jpg" ;
		 unlink($file_product1);
		
		
		    $img_front1=$_FILES["front_".$get_img1['prod_no']."_".$csrow1['color_code']]['name'];
			$uploadFilesTo1 = '../images/product_front';
			$fileatt1 =$_FILES["front_".$get_img1['prod_no']."_".$csrow1['color_code']]['tmp_name'];
			$fileatt_type1 =$_FILES["front_".$get_img1['prod_no']."_".$csrow1['color_code']]['type'];
			
			$img1=explode(".",$img_front1);
			
			$fileatt_name1=$get_img1['prod_no']."_".$csrow1['color_code'].".".$img1[1];
			$fp1 = fopen($fileatt1, 'rb');
			$data1 = fread($fp1, filesize($fileatt1));
			fclose($fp1);
			$data1 = chunk_split(base64_encode($data1));
			move_uploaded_file($fileatt1, $uploadFilesTo1.'/'.$fileatt_name1);
			
		}
		
if ($_FILES["back_".$get_img1['prod_no']."_".$csrow1['color_code']]['name']!="")
		{
		
		
		 $file_product2="../images/product_back/".$get_img1["prod_no"]."_".$csrow1["color_code"].".jpg" ;
		 unlink($file_product2);

		
		
		    $img_front2=$_FILES["back_".$get_img1['prod_no']."_".$csrow1['color_code']]['name'];
			$uploadFilesTo2 = '../images/product_back';
			$fileatt2 =$_FILES["back_".$get_img1['prod_no']."_".$csrow1['color_code']]['tmp_name'];
			$fileatt_type2 =$_FILES["back_".$get_img1['prod_no']."_".$csrow1['color_code']]['type'];
			
			$img2=explode(".",$img_front2);
			
			$fileatt_name2=$get_img1['prod_no']."_".$csrow1['color_code'].".".$img2[1];
			$fp2 = fopen($fileatt2, 'rb');
			$data2 = fread($fp2, filesize($fileatt2));
			fclose($fp2);
			$data2 = chunk_split(base64_encode($data2));
			move_uploaded_file($fileatt2, $uploadFilesTo2.'/'.$fileatt_name2);
			
		}
		
if ($_FILES["side_".$get_img1['prod_no']."_".$csrow1['color_code']]['name']!="")
		{
		
		 $file_product3="../images/product_side/".$get_img1["prod_no"]."_".$csrow1["color_code"].".jpg" ;
		 unlink($file_product3);

		
		    $img_front3=$_FILES["side_".$get_img1['prod_no']."_".$csrow1['color_code']]['name'];
			$uploadFilesTo3 = '../images/product_side';
			$fileatt3 =$_FILES["side_".$get_img1['prod_no']."_".$csrow1['color_code']]['tmp_name'];
			$fileatt_type3 =$_FILES["side_".$get_img1['prod_no']."_".$csrow1['color_code']]['type'];
			
			$img3=explode(".",$img_front3);
			
			$fileatt_name3=$get_img1['prod_no']."_".$csrow1['color_code'].".".$img3[1];
			$fp3 = fopen($fileatt3, 'rb');
			$data3 = fread($fp3, filesize($fileatt3));
			fclose($fp3);
			$data3 = chunk_split(base64_encode($data3));
			move_uploaded_file($fileatt3, $uploadFilesTo3.'/'.$fileatt_name3);
			
		}
	
	if ($_FILES["icon_".$get_img1['prod_no']."_".$csrow1['color_code']]['name']!="")
		{
		
		 $file_product4="../images/product_coloricon/".$get_img1["prod_no"]."_".$csrow1["color_code"].".jpg" ;
		 unlink($file_product4);

		
		    $img_front4=$_FILES["icon_".$get_img1['prod_no']."_".$csrow1['color_code']]['name'];
			$uploadFilesTo4 = '../images/product_coloricon';
			$fileatt4 =$_FILES["icon_".$get_img1['prod_no']."_".$csrow1['color_code']]['tmp_name'];
			$fileatt_type4 =$_FILES["icon_".$get_img1['prod_no']."_".$csrow1['color_code']]['type'];
			
			$img4=explode(".",$img_front4);
			
			$fileatt_name4=$get_img1['prod_no']."_".$csrow1['color_code'].".".$img4[1];
			$fp4 = fopen($fileatt4, 'rb');
			$data4 = fread($fp4, filesize($fileatt4));
			fclose($fp4);
			$data4 = chunk_split(base64_encode($data4));
			move_uploaded_file($fileatt4, $uploadFilesTo4.'/'.$fileatt_name4);
			
		}
		
		
		if ($_FILES["video_".$get_img1['prod_no']."_".$csrow1['color_code']]['name']!="")
		{
		
		 $file_product5="../images/product_video/".$get_img1["prod_no"]."_".$csrow1["color_code"].".flv" ;
		 unlink($file_product5);

		
		    $img_front5=$_FILES["video_".$get_img1['prod_no']."_".$csrow1['color_code']]['name'];
			$uploadFilesTo5 = '../images/product_video';
			$fileatt5 =$_FILES["video_".$get_img1['prod_no']."_".$csrow1['color_code']]['tmp_name'];
			$fileatt_type5 =$_FILES["video_".$get_img1['prod_no']."_".$csrow1['color_code']]['type'];
			
			$img5=explode(".",$img_front5);
			
			$fileatt_name5=$get_img1['prod_no']."_".$csrow1['color_code'].".".$img5[1];
			$fp5 = fopen($fileatt5, 'rb');
			$data5 = fread($fp5, filesize($fileatt5));
			fclose($fp5);
			$data5 = chunk_split(base64_encode($data5));
			move_uploaded_file($fileatt5, $uploadFilesTo5.'/'.$fileatt_name5);
			
		}
		
		
		 $import="update tbl_stock set size_0='".$_REQUEST[$csrow1[color_code].'_size_0']."',size_2='".$_REQUEST[$csrow1[color_code].'_size_2']."',size_4='".$_REQUEST[$csrow1[color_code].'_size_4']."',size_6='".$_REQUEST[$csrow1[color_code].'_size_6']."',size_8='".$_REQUEST[$csrow1[color_code].'_size_8']."',size_10='".$_REQUEST[$csrow1[color_code].'_size_10']."',size_12='".$_REQUEST[$csrow1[color_code].'_size_12']."',size_14='".$_REQUEST[$csrow1[color_code].'_size_14']."',size_16='".$_REQUEST[$csrow1[color_code].'_size_16']."',size_xs='".$_REQUEST[$csrow1[color_code].'_size_xs']."',size_s='".$_REQUEST[$csrow1[color_code].'_size_s']."',size_m='".$_REQUEST[$csrow1[color_code].'_size_m']."',size_l='".$_REQUEST[$csrow1[color_code].'_size_l']."',size_xl='".$_REQUEST[$csrow1[color_code].'_size_xl']."' where prod_id='".$_REQUEST['prod_id']."' and cs_id='".$csrow1['color_id']."'";
								   

       $res_imp=mysql_query($import) or die(mysql_error());	
				

   		
		print "<script>opener.location.href='edit_new_par_product.php?act=".$_REQUEST['act']."&prod_id=".$_REQUEST['prod_id']."&mode=".$_REQUEST['mode']."';window.close();</script>";

}

$get_img = mysql_fetch_array(mysql_query("select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'"));

$csrow = mysql_fetch_array(mysql_query("select * from tblcolor where color_code='".$_REQUEST['color_code']."'"));
 
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

<link href="style.css" rel="stylesheet" type="text/css">

	<center><span  class="text"><strong>EDIT PRODUCT PICTURE</strong><br />
	<span style="color:#ff0000;"><strong><? echo @$msg;?></strong></span>&nbsp;</span></center>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">

          <form name="prod_frm" method="post" action="edit_product_img_popup2.php?act=add" enctype="multipart/form-data">
         	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">
         	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  				<tr valign="top">
					<td class="border_color">
						<table border="0" cellpadding="5" cellspacing="1" width=100%  valign = "top">
                <!--DWLayoutTable-->
                <input type="hidden" name="prod_id" value="<? echo $_REQUEST['prod_id']?>">
                <input type="hidden" name="color_code" value="<? echo $_REQUEST['color_code']?>">
                                <input type="hidden" name="mode" value="<? echo $_REQUEST['mode']?>">
                <input type="hidden" name="act" value="<? echo $_REQUEST['act']?>">

                <? if(@$prod_return==1){?>
                <tr bgcolor="#eeeeee"> 
                  <td class="error" colspan=2><? echo @$err;?>&nbsp;</td>
                </tr>
                <? }?>
                <tr style="background: none repeat scroll 0% 0% rgb(204, 204, 204);"> 
                  <td width="256" align="left" class="" colspan="2"><strong><?=$csrow['color_name']?></strong></td>
                </tr>
	            <tr bgcolor="#eeeeee"> 
                  <td width="256" align="right" class="text">Front Image : </td>
                  <td width="614" align="left" class="error"><input type="file" name="front_<?=$get_img['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td width="256" align="right" class="text">Back Image : </td>
                  <td width="614" align="left" class="error"><input type="file" name="back_<?=$get_img['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td width="256" align="right" class="text">Side Image : </td>
                  <td width="614" align="left" class="error"><input type="file" name="side_<?=$get_img['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox" >&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td width="256" align="right" class="text">Color Icon Image : </td>
                  <td width="614" align="left" class="error"><input type="file" name="icon_<?=$get_img['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 40 px x 40 px</td>
                </tr>
                 <tr bgcolor="#eeeeee"> 
                  <td width="256" align="right" class="text">Runway Video : </td>
                  <td width="614" align="left" class="error"><input type="file" name="video_<?=$get_img['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;video must be minimum 327 px x 589 px</td>
                </tr>
                <tr bgcolor="#eeeeee">
                <td width="353" align="right" class="text">Stock : </td> 
                  <td width="998" align="left" class="text" > 
				 <table width="576" border="0" cellspacing="5" cellpadding="0" class="text"><tr>
                 <?php
		
			$cs1 = mysql_query("select * from tblsize") or die(mysql_error());
			while($cs_row1 = mysql_fetch_array($cs1)){
			?>

				<td width="7%" ><strong>&nbsp;&nbsp;&nbsp;<?=$cs_row1["size_name"]?></strong> </td>
                <?php
		  }
          ?>
		</tr><tr>
		<?php
		
			$stock_qry="select * from tbl_stock where prod_id='".$_REQUEST['prod_id']."' and cs_id='".$csrow['color_id']."'";
			$stock_res=mysql_query($stock_qry);
			$stock_rec=mysql_fetch_array($stock_res);

		
			$cs4 = mysql_query("select * from tblsize") or die(mysql_error());
			while($cs_row4 = mysql_fetch_array($cs4)){
			?>

				<td><input type='text' name='<?=$csrow['color_code']?>_size_<?=strtolower($cs_row4["size_name"])?>' size='2' value="<?=$stock_rec['size_'.strtolower($cs_row4["size_name"])]?>"></td>
                <?php
		  }
		  ?>
         </tr></table>
				  
				  </td>
                </tr>
                <tr> 
                  <td colspan=2 align=center> <input type="submit" name="image_submit" class="inputbox" value="Upload Picture & Stock">                  </td>
                </tr>
				</table>

	</td>
</tr>
</table>
			</form>

	
	</td>
</tr>
</table>
			  <div style="text-align:center;display:none;" class="text" id="loading">Saving/Uploading. Please wait...</div>