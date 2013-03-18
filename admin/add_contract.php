<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");
include 'top.php'; 


		if($_POST['add'] == 01){
				$strFile1_2        =  strtolower($_FILES["contract_img"]["name"]);
				$strTempFile1_2    =  $_FILES["contract_img"]["tmp_name"]; 
				$strFileName2= $randomno_2.$strFile1_2;	
				
			 if($strFile1_2!=''){	
				copy($strTempFile1_2,"contract/".$strFileName2);
				gd2resize("contract/".$strFileName2,162,125,"contract/thumb/",""); 
				gd2resize("contract/".$strFileName2,90,75,"contract/mini_thumb/",""); 
				gd2resize("contract/".$strFileName2,579,446,"contract/zoom/",""); 	
				
				$sql="INSERT INTO `tbl_contract`(img,type) VALUES ('$strFile1_2','".$_POST['type']."')";
				mysql_query($sql) or die(mysql_error());
				$err_ = "Successfully added";
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<form name="category" action="add_contract.php?action=add" method="post" enctype="MULTIPART/FORM-data">
	<input type="hidden" name="add" id="add" value="01" />
                    <table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD PRESS</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? echo $err_; ?></td></tr>
                    <tr>
                      	<td width="45%" align="right" class="text">Upload Image: </td>
                      	<td width="55%" align="left"><input type="file" name="contract_img" id="contract_img" class="inputbox"></td>
                    </tr>
                    <tr>
                      <td align="right" class="text" valign="top">Type: </td>
                      <td height="28" align="left" valign="top"><select name="type" id="type">
					  	<option value="Office">Office</option>
						<option value="Wardrobe">Wardrobe</option>
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
					<tr><td colspan=2 align=center><input type="submit" value="Add" class="button"> </td></tr>
                     </table>

                    </td></tr></table>
                    </form></td>
</tr>
</table>
<? include 'footer.php'; ?>