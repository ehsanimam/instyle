<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");

$up_id = $_GET['id'];

$sql = "select * from tbl_press where press_id='".$up_id."'";
$res = mysql_query($sql);
$rows = mysql_fetch_array($res);
$img_name1 = $rows['cover_img'];
$img_name2 = $rows['img_1'];
$img_name3 = $rows['img_2'];

		if($_POST['edit'] == 01){
		
				$strFile1_1        =  strtolower($_FILES["press_img_cover"]["name"]);
				$strTempFile1_1    =  $_FILES["press_img_cover"]["tmp_name"]; 
				
				$strFile1_2        =  strtolower($_FILES["press_img_1"]["name"]);
				$strTempFile1_2    =  $_FILES["press_img_1"]["tmp_name"]; 
				
				$strFile1_3        =  strtolower($_FILES["press_img_2"]["name"]);
				$strTempFile1_3    =  $_FILES["press_img_2"]["tmp_name"]; 
				
				$sql="update `tbl_press` set title='".$_POST['comment']."' where press_id='".$up_id."'";
				mysql_query($sql) or die(mysql_error());
				
			 if($strFile1_1!=''){	
			 
			 	$old_image_path1 = "press_cover/".$img_name1;
				$old_image_path2 = "press_cover/thumb/".$img_name1;
						
				if(is_file($old_image_path1)==true):
					unlink($old_image_path1);
					unlink($old_image_path2);
				endif;
					
				$randomno=RandomNumber(5);
				$strFileName1= $randomno.$strFile1_1;	
				
				copy($strTempFile1_1,"press_cover/".$strFileName1);
				gd2resize("press_cover/".$strFileName1,120,155,"press_cover/thumb/",""); 
				
					$sql="update `tbl_press` set cover_img='$strFileName1' where press_id='$up_id'";
					mysql_query($sql) or die(mysql_error());
			}
				if($strFile1_2!=''){	
					
					$old_image_path11 = "press_1/".$img_name2;
					$old_image_path22 = "press_1/zoom/".$img_name2;
					
					if(is_file($old_image_path11)==true):
						unlink($old_image_path11);
						unlink($old_image_path22);
					endif;
					
					$randomno=RandomNumber(5);
					$strFileName2= $randomno.$strFile1_2;	
					
					copy($strTempFile1_2,"press_1/".$strFileName2);
					gd2resize("press_1/".$strFileName2,579,780,"press_1/zoom/",""); 	
					
					$sql="update `tbl_press` set img_1='$strFileName2' where press_id='$up_id'";
					mysql_query($sql) or die(mysql_error());
				}	
				
				if($strFile1_3!=''){	
				
					$old_image_path111 = "press_2/".$img_name3;
					$old_image_path222 = "press_2/zoom/".$img_name3;
					
					if(is_file($old_image_path111)==true):
						unlink($old_image_path111);
						unlink($old_image_path222);
					endif;
			 	
				
					$randomno=RandomNumber(5);
					$strFileName3= $randomno.$strFile1_3;	
					
					copy($strTempFile1_3,"press_2/".$strFileName3);
					gd2resize("press_2/".$strFileName3,579,780,"press_2/zoom/",""); 	
					
					$sql="update `tbl_press` set img_2='$strFileName3' where press_id='$up_id'";
					mysql_query($sql) or die(mysql_error());
				}		
				
				
				
				//header("Location: edit_collection.php");
				echo "<script>window.opener.location.reload();</script>";
				echo "<script>this.close();</script>";
				
			
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
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>EDIT PRESS</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? echo $err_; ?></td></tr>
                  	<tr>
                      	<td width="45%" align="right" class="text">Title: </td>
                      	<td width="55%" align="left"><input type="text" name="comment" id="comment" class="inputbox" value="<?php echo $rows['title'];?>" /></td>
                    </tr>
					<tr>
                      	<td width="45%" align="right" class="text">Upload Cover Image: </td>
                      	<td width="55%" align="left"><input type="file" name="press_img_cover" id="press_img_cover" class="inputbox"></td>
                    </tr>
                   <tr>
                      	<td width="45%" align="right" class="text">Upload Image: </td>
                      	<td width="55%" align="left"><input type="file" name="press_img_1" id="press_img_1" class="inputbox"></td>
                    </tr>
					<tr>
                      	<td width="45%" align="right" class="text">Upload Image: </td>
                      	<td width="55%" align="left"><input type="file" name="press_img_2" id="press_img_2" class="inputbox"></td>
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