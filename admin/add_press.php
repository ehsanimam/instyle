<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");
include 'top.php'; 

		
		if($_POST['add'] == 01){
				$strFile1_1        =  strtolower($_FILES["press_img_cover"]["name"]);
				$strTempFile1_1    =  $_FILES["press_img_cover"]["tmp_name"]; 
				
				$strFile1_2        =  strtolower($_FILES["press_img_1"]["name"]);
				$strTempFile1_2    =  $_FILES["press_img_1"]["tmp_name"]; 
				
				$strFile1_3        =  strtolower($_FILES["press_img_2"]["name"]);
				$strTempFile1_3    =  $_FILES["press_img_2"]["tmp_name"]; 
				
				
			 if($strFile1_1!=''){	
			 	$randomno=RandomNumber(5);
				$strFileName1= $randomno.$strFile1_1;	
				
				copy($strTempFile1_1,"press_cover/".$strFileName1);
				gd2resize("press_cover/".$strFileName1,120,155,"press_cover/thumb/",""); 
			
				if($strFile1_2!=''){	
					$randomno=RandomNumber(5);
					$strFileName2= $randomno.$strFile1_2;	
					
					copy($strTempFile1_2,"press_1/".$strFileName2);
					gd2resize("press_1/".$strFileName2,579,780,"press_1/zoom/",""); 	
				}	
				
				if($strFile1_3!=''){	
					$randomno=RandomNumber(5);
					$strFileName3= $randomno.$strFile1_3;	
					
					copy($strTempFile1_3,"press_2/".$strFileName3);
					gd2resize("press_2/".$strFileName3,579,780,"press_2/zoom/",""); 	
				}	
				
				$sql="INSERT INTO `tbl_press`(title,cover_img,img_1,img_2) VALUES ('".$_POST['comment']."','$strFileName1','$strFileName2','$strFileName3')";
				mysql_query($sql) or die(mysql_error());
				$err_ = "Successfully added";
				
			}else{
				$err_ = "Cover Image should not empty";
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<form name="category" action="add_press.php?action=add" method="post" enctype="MULTIPART/FORM-data">
	<input type="hidden" name="add" id="add" value="01" />
                    <table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD PRESS</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? echo $err_; ?></td></tr>
                  	<tr>
                      	<td width="45%" align="right" class="text">Title: </td>
                      	<td width="55%" align="left"><input type="text" name="comment" id="comment" class="inputbox" /></td>
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
					<tr><td colspan=2 align=center><input type="submit" value="Add" class="button"> </td></tr>
                     </table>

                    </td></tr></table>
                    </form></td>
</tr>
</table>
<? include 'footer.php'; ?>