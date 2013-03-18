<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");

$up_id = $_GET['id'];

$sql = "select * from tbl_contract where id='".$up_id."'";
$res = mysql_query($sql);
$rows = mysql_fetch_array($res);
$img_name = $rows['img'];

		if($_POST['edit'] == 01){
				
				$strFile1_2 =  strtolower($_FILES["contract_img"]["name"]);
				$strTempFile1_2 =  $_FILES["contract_img"]["tmp_name"]; 
				$strFileName2= $randomno_2.$strFile1_2;	
				
			 if($strFile1_2!=''){	
			 
			 	$old_image_path1 = "contract/".$img_name;
				$old_image_path2 = "contract/thumb/".$img_name;
				$old_image_path22 = "contract/mini_thumb/".$img_name;
				$old_image_path3 = "contract/zoom/".$img_name;
				
				if(is_file($old_image_path1)==true):
					unlink($old_image_path1);
					unlink($old_image_path2);
					unlink($old_image_path22);
					unlink($old_image_path3);
				endif;
			 	
				copy($strTempFile1_2,"contract/".$strFileName2);
				gd2resize("contract/".$strFileName2,162,125,"contract/thumb/",""); 
				gd2resize("contract/".$strFileName2,90,75,"contract/mini_thumb/",""); 
				gd2resize("contract/".$strFileName2,579,446,"contract/zoom/",""); 	
				
				$sql="update `tbl_contract` set img='$strFile1_2',type='".$_POST['type']."' where id='$up_id'";
				mysql_query($sql) or die(mysql_error());
				//header("Location: edit_collection.php");
				echo "<script>window.opener.location.reload();</script>";
				echo "<script>this.close();</script>";
				
			}else{
					$err_ = "Image should not empty";
			}
		}	
					
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
    document.category.method="post";
    document.category.action="legal.php?action=add";
    document.category.submit();
    
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td align="center" valign="middle">
	
	<form name="category" action="<?php echo $_SERVER['PHP_SELF'];?>?action=edit&id=<?php echo $up_id;?>" method="post" enctype="MULTIPART/FORM-data">
	<input type="hidden" name="edit" id="add" value="01" />
                    <table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>EDIT contract  </h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? echo $err_; ?></td></tr>
					<tr>
                      	<td width="45%" align="right" class="text">Upload Image: </td>
                      	<td width="55%" align="left"><input type="file" name="contract_img" id="contract_img" class="inputbox"></td>
                    </tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left"><input type="image" src="contract/thumb/<?php echo $img_name;?>"></td>
					</tr>
                    <tr>
                      <td align="right" class="text" valign="top">Comment: </td>
                      <td height="28" align="left" valign="top"><select name="type" id="type">
					  	<option value="Office" <?php if($rows['type']=='Office'){ echo 'selected';}?>>Office</option>
						<option value="Wardrobe" <?php if($rows['type']=='Wardrobe'){ echo 'selected';}?>>Wardrobe</option>
					  </select></td>
                    </tr>
                    <!--<tr>
                      <td valign="middle" class="text" align="right">Do you want to show this image on index page? </td>
                      <td height="28" align="left" valign="middle"><select class="combobig" name="toshow">
					  <option value="0">No</option>
					  <option value="1">Yes</option>
					  </select></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="text" align="right">Do you want to show this category on index page?</td>
                      <td align="left" valign="middle"><select class="combobig" name="toshowcat">
					  <option value="0">No</option>
					  <option value="1">Yes</option>
					  </select></td>
                    </tr>-->
					<!--<tr>
                      <td valign="middle" class="text" align="right">Upload Small Image : </td>
                      <td align="left" valign="middle"><input type="file" name="prod_image" class="button"></td>
                    </tr>
					 <tr>
                      <td valign=top>&nbsp;</td>
                      <td height="28" align="left" valign="top"><span class="text" style="color:#FF0000">(image size should be 190(w) x 98(h) px)</span></td>
                    </tr>-->
					<tr><td colspan=2 align=center><input type="submit" value="Edit" class="button"> </td></tr>
                     </table>

                    </td></tr></table>
                    </form></td>
</tr>
</table>
<? include 'footer.php'; ?>