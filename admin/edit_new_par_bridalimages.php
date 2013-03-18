<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include 'top.php'; 
if(isset($_POST['image_submit']))
{

$csql = "select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'"; 
		$cs3 = mysql_query($csql);
		$cs_row3 = mysql_fetch_array($cs3);

		$color_names=explode(",",$cs_row3['colornames']);		
				
			foreach($color_names as $col){
						
							$get_color = mysql_query("SELECT * 
												FROM 
												 tblcolor
												WHERE
												  color_code='".$col."'") or die(mysql_error());
							$csrow=mysql_fetch_array($get_color);	


if ($_FILES["front_".$cs_row3['prod_no']."_".$csrow['color_code']]['name']!="")
		{
		    $img_front1=$_FILES["front_".$cs_row3['prod_no']."_".$csrow['color_code']]['name'];
			$uploadFilesTo1 = '../images/bridal/product_front';
			$fileatt1 =$_FILES["front_".$cs_row3['prod_no']."_".$csrow['color_code']]['tmp_name'];
			$fileatt_type1 =$_FILES["front_".$cs_row3['prod_no']."_".$csrow['color_code']]['type'];
			
			$img1=explode(".",$img_front1);
			
			$fileatt_name1=$cs_row3['prod_no']."_".$csrow['color_code'].".".$img1[1];
			$fp1 = fopen($fileatt1, 'rb');
			$data1 = fread($fp1, filesize($fileatt1));
			fclose($fp1);
			$data1 = chunk_split(base64_encode($data1));
			move_uploaded_file($fileatt1, $uploadFilesTo1.'/'.$fileatt_name1);
			
		}
		
if ($_FILES["back_".$cs_row3['prod_no']."_".$csrow['color_code']]['name']!="")
		{
		    $img_front2=$_FILES["back_".$cs_row3['prod_no']."_".$csrow['color_code']]['name'];
			$uploadFilesTo2 = '../images/bridal/product_back';
			$fileatt2 =$_FILES["back_".$cs_row3['prod_no']."_".$csrow['color_code']]['tmp_name'];
			$fileatt_type2 =$_FILES["back_".$cs_row3['prod_no']."_".$csrow['color_code']]['type'];
			
			$img2=explode(".",$img_front2);
			
			$fileatt_name2=$cs_row3['prod_no']."_".$csrow['color_code'].".".$img2[1];
			$fp2 = fopen($fileatt2, 'rb');
			$data2 = fread($fp2, filesize($fileatt2));
			fclose($fp2);
			$data2 = chunk_split(base64_encode($data2));
			move_uploaded_file($fileatt2, $uploadFilesTo2.'/'.$fileatt_name2);
			
		}
		
if ($_FILES["side_".$cs_row3['prod_no']."_".$csrow['color_code']]['name']!="")
		{
		    $img_front3=$_FILES["side_".$cs_row3['prod_no']."_".$csrow['color_code']]['name'];
			$uploadFilesTo3 = '../images/bridal/product_side';
			$fileatt3 =$_FILES["side_".$cs_row3['prod_no']."_".$csrow['color_code']]['tmp_name'];
			$fileatt_type3 =$_FILES["side_".$cs_row3['prod_no']."_".$csrow['color_code']]['type'];
			
			$img3=explode(".",$img_front3);
			
			$fileatt_name3=$cs_row3['prod_no']."_".$csrow['color_code'].".".$img3[1];
			$fp3 = fopen($fileatt3, 'rb');
			$data3 = fread($fp3, filesize($fileatt3));
			fclose($fp3);
			$data3 = chunk_split(base64_encode($data3));
			move_uploaded_file($fileatt3, $uploadFilesTo3.'/'.$fileatt_name3);
			
		}
	
	if ($_FILES["icon_".$cs_row3['prod_no']."_".$csrow['color_code']]['name']!="")
		{
		    $img_front4=$_FILES["icon_".$cs_row3['prod_no']."_".$csrow['color_code']]['name'];
			$uploadFilesTo4 = '../images/bridal/product_coloricon';
			$fileatt4 =$_FILES["icon_".$cs_row3['prod_no']."_".$csrow['color_code']]['tmp_name'];
			$fileatt_type4 =$_FILES["icon_".$cs_row3['prod_no']."_".$csrow['color_code']]['type'];
			
			$img4=explode(".",$img_front4);
			
			$fileatt_name4=$cs_row3['prod_no']."_".$csrow['color_code'].".".$img4[1];
			$fp4 = fopen($fileatt4, 'rb');
			$data4 = fread($fp4, filesize($fileatt4));
			fclose($fp4);
			$data4 = chunk_split(base64_encode($data4));
			move_uploaded_file($fileatt4, $uploadFilesTo4.'/'.$fileatt_name4);
			
		}
		
		
		if ($_FILES["video_".$cs_row3['prod_no']."_".$csrow['color_code']]['name']!="")
		{
		    $img_front5=$_FILES["video_".$cs_row3['prod_no']."_".$csrow['color_code']]['name'];
			$uploadFilesTo5 = '../images/bridal/product_video';
			$fileatt5 =$_FILES["video_".$cs_row3['prod_no']."_".$csrow['color_code']]['tmp_name'];
			$fileatt_type5 =$_FILES["video_".$cs_row3['prod_no']."_".$csrow['color_code']]['type'];
			
			$img5=explode(".",$img_front5);
			
			$fileatt_name5=$cs_row3['prod_no']."_".$csrow['color_code'].".".$img5[1];
			$fp5 = fopen($fileatt5, 'rb');
			$data5 = fread($fp5, filesize($fileatt5));
			fclose($fp5);
			$data5 = chunk_split(base64_encode($data5));
			move_uploaded_file($fileatt5, $uploadFilesTo5.'/'.$fileatt_name5);
			
		}
		
		$chkcolor = "select * from tbl_stock where des_id='".$cs_row3['designer']."' and cs_id='".$csrow['color_id']."' and prod_id='".$_REQUEST['prod_id']."'";
		$hcolor = mysql_query($chkcolor);
		if(mysql_num_rows($hcolor) <= 0)
		{
	
	
  $import="INSERT into tbl_stock (des_id,
									cs_id,
									prod_id,
									size_0,
									size_2,
									size_4,
									size_6,
									size_8,
									size_10,
									size_12,
									size_14,
									size_16,
									size_xs,
									size_s,
									size_m,
									size_l,
									size_xl) 
							values(
									'".$cs_row3['designer']."',
									'".$csrow['color_id']."',
									'".$_REQUEST['prod_id']."',
									'".$_REQUEST[$col.'_size_0']."',
									'".$_REQUEST[$col.'_size_2']."',
									'".$_REQUEST[$col.'_size_4']."',
									'".$_REQUEST[$col.'_size_6']."',
									'".$_REQUEST[$col.'_size_8']."',
									'".$_REQUEST[$col.'_size_10']."',
									'".$_REQUEST[$col.'_size_12']."',
									'".$_REQUEST[$col.'_size_14']."',
									'".$_REQUEST[$col.'_size_16']."',
									'".$_REQUEST[$col.'_size_xs']."',
									'".$_REQUEST[$col.'_size_s']."',
									'".$_REQUEST[$col.'_size_m']."',
									'".$_REQUEST[$col.'_size_l']."',
									'".$_REQUEST[$col.'_size_xl']."'
								   )";
								   

       $res_imp=mysql_query($import) or die(mysql_error());
	
	}else{
			$msg=2;
	}	
							
		
			
				
		}
		
		echo "<script type=\"text/javascript\">
									<!--
									window.location = \"edit_new_par_bridalproduct.php?act=show&prod_id=".$_REQUEST['prod_id']."&mode=e&msg=3\"
									//-->
									</script>
								";

}
?>
<title>In Style New York::Admin Section</title>
<link href="../js/style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
   // document.prod_frm.subcat.value=0;
    document.prod_frm.method="post";
    document.prod_frm.action="edit_new_par_bridalproduct.php?act=show&mode=e";
    document.prod_frm.submit();

}
function confirmLink(theLink,msg)
{
    // Confirmation is not required in the configuration file
    var is_confirmed = confirm(msg);
    return is_confirmed;
} 

</script>
<script>
function back_display()
{
    location.href="edit_new_product.php?cat_id=<?=$cat;?>"
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">
          <form name="prod_frm" method="post" action="edit_new_par_bridalimages.php?prod_id=<?=$_REQUEST['prod_id']?>" enctype="multipart/form-data">
         	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  				<tr valign="top">
					<td class="border_color">
						<table border="0" cellpadding="5" cellspacing="1" width=100%  valign = "top">
                <!--DWLayoutTable-->
                <input type="hidden" name="prod_id" value="<? echo @$prod_id?>">
              <?php if($msg==2){?>
                <tr>
                  <td align=center colspan=2 class="error">For this product stock already exists.</td>
                </tr>
                <?php } ?>
                <?php if($_GET['msg']==1){?>
                <tr>
                  <td align=center colspan=2 class="error">Delete image Successful.</td>
                </tr>
                <?php } ?>
                
                <?php 
		$csql = "select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'"; 
		$cs3 = mysql_query($csql);
		$cs_row3 = mysql_fetch_array($cs3);

		$color_names=explode(",",$cs_row3['colornames']);		
				
			foreach($color_names as $col){
						
							$get_color = mysql_query("SELECT * 
												FROM 
												 tblcolor
												WHERE
												  color_code='".$col."'") or die(mysql_error());
							$csrow=mysql_fetch_array($get_color);	
				?>
                <tr style="background: none repeat scroll 0% 0% rgb(204, 204, 204);"> 
                  <td align="left" class="" colspan="2"><strong><?=$csrow['color_name']?></strong></td>
                </tr>
	            <tr bgcolor="#eeeeee"> 
                  <td width="353" align="right" class="text">Front Image : </td>
                  <td width="998" align="left" class="error"><input type="file" name="front_<?=$cs_row3['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td width="353" align="right" class="text">Back Image : </td>
                  <td width="998" align="left" class="error"><input type="file" name="back_<?=$cs_row3['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td width="353" align="right" class="text">Side Image : </td>
                  <td width="998" align="left" class="error"><input type="file" name="side_<?=$cs_row3['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox" >&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td width="353" align="right" class="text">Color Icon Image : </td>
                  <td width="998" align="left" class="error"><input type="file" name="icon_<?=$cs_row3['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 40 px x 40 px</td>
                </tr>
                 <tr bgcolor="#eeeeee"> 
                  <td width="353" align="right" class="text">Runway Video : </td>
                  <td width="998" align="left" class="error"><input type="file" name="video_<?=$cs_row3['prod_no']?>_<?=$csrow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;video must be minimum 327 px x 589 px</td>
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
		
			$cs4 = mysql_query("select * from tblsize") or die(mysql_error());
			while($cs_row4 = mysql_fetch_array($cs4)){
			
			?>

				<td><input type='text' name='<?=$col?>_size_<?=strtolower($cs_row4["size_name"])?>' size='2'></td>
                <?php
		  }
		  ?>
         </tr></table>
				  
				  </td>
                </tr>
                <?php } ?>
                <tr> 
                  <td colspan=2 align=center> <input type="submit" name="image_submit" class="inputbox" value="Upload Picture & Stock"> <a href="edit_new_par_product.php?act=show&prod_id=<?=$_REQUEST['prod_id']?>&mode=e" class="inputbox"><input type="button" name="next" value="Skip" class="inputbox" /></a></td>
                </tr>
				</table>
			</form>

	</td>
</tr>
</table>
<? include 'footer.php'; ?>