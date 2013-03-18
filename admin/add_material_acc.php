<?php
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php");

	//$strFile1        =  $_FILES["cat_image"]["name"];
	//$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

	//$strFile2        =  $_FILES["prod_image"]["name"];
	//$strTempFile2    =  $_FILES["prod_image"]["tmp_name"];

	if(@$action=='add')
	{
		if($name!='' )
		{
			  $cid=0;
			  $cid = admin_add_material($name,$cat_image,$priority,$heading_id,$title,$description,$keyword,$alttags,$url_structure);
			if($cid != -1){
				$err="material has been added.";
			}else {
				$err = "material already exists"; 
			$name='';
			}
		}
		else
		{
			$err="Please complete all the entries.";
		} 
	}

	include 'top.php'; 
?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
    document.material.method="post";
    document.material.action="add_material_acc.php?action=add";
    document.material.submit();
    
}


function check_file() {
	var fileVal=document.material.pdF_price.value;
	var fileVal_2=document.material.pdF_color.value;
	if(fileVal!="") {
			var ext_p=fileVal.substr(fileVal.lastIndexOf(".")).toLowerCase();
			if(ext_p!=".pdf") {
				alert("This is not a PDF file ! Please verify    ");
				document.material.pdF_price.focus();
				return false;
			}	
		}
	
	if(fileVal_2!="") {
			var ext_c=fileVal_2.substr(fileVal_2.lastIndexOf(".")).toLowerCase();
			if(ext_c!=".pdf") {
				alert("This is not a PDF file ! Please verify    ");
				document.material.pdF_color.focus();
				return false;
			}	
		}
		
	}
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="333" class="tab" align="center" valign="middle">

	<!--bof form=================================================================================-->
	<form name="material" action="add_material_acc.php?action=add" method="post" enctype="MULTIPART/FORM-data" onsubmit="javascript: return check_file();">
                    <table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Material Facet For <span style="color:red;">Jewelries And Accessories</span></h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? echo @$err; ?></td></tr>

                    <tr>
						<td width="45%" class="text" align="right">Material Name : </td>
                    	<td width="55%" align="left"><input type="text" name="name" class="inputbox" value="<? echo @$name;?>"></td>
					</tr>
					 <tr>
						<td width="45%" class="text" align="right">Type Head name : </td>
                    	<td width="55%" align="left">
						<?php
					/*
					| ------------------------------------------------------------------------------------------------
					| Assigning facets into two groups - Womens Apparel and Jewelry And Accessories
					| Setting each to it's own
					|
						$sql = sprintf("select id, headings from tbl_type_headings");
								echo SelectValue($sql, "heading_id", @$heading_id);
					*/
						?>
					<select name="heading_id">
						<option value="19">Jewelries And Accessories</option>
					</select>

						</td>
					</tr>
					<tr>
                      	<td class="text" align="right">Upload PDF(Price List) : </td>
                      	<td align="left"><input type="file" name="pdF_price" id="pdF_price" class="inputbox"></td>
                    </tr>
					<tr>
                      	<td class="text" align="right">Upload PDF(Color List) : </td>
                      	<td align="left"><input type="file" name="pdF_color" id="pdF_color" class="inputbox"></td>
                    </tr>
                    <tr>
                      	<td class="text" align="right">Upload Image : </td>
                      	<td align="left"><input type="file" name="cat_image" class="inputbox"></td>
                    </tr>
                    <tr>
                      <td valign=top>&nbsp;</td>
                      <td height="28" align="left" valign="top"><span class="text" ="color:#FF0000">(image size should be 750(w) x 568(h) px)</span></td>
                    </tr>
                     <tr> 
                  <td  align="right" valign=top class="text">Title : </td>
                  <td  align="left"><input type="text" name="title"  class="inputboxbig" value="<?=@$title;?>"></td>
                </tr>
                 <tr> 
                  <td  align="right" valign=top class="text">Description : </td>
                  <td  align="left"><textarea  name="description"  class="textareabig"><?=@$description;?></textarea></td>
                </tr>
                 <tr> 
                  <td  align="right" valign=top class="text">Keywords : </td>
                  <td  align="left"><textarea  name="keyword"  class="textareabig"><?=@$keyword;?></textarea></td>
                </tr>
                 <tr> 
                  <td  align="right" valign=top class="text">Alt Tags : </td>
                  <td  align="left"><input type="text" name="alttags"  class="inputboxbig" value="<?=@$alttags;?>"></td>
                </tr>
                 <tr> 
                  <td  align="right" valign=top class="text">Url Structure : </td>
                  <td  align="left"><input type="text" name="url_structure"  class="inputboxbig" value="<?=@$url_structure;?>"></td>
                </tr>
					<tr>
                      <td valign=top align=right class="text" >Priority (affects the order in which material is displayed 1-127)</td>
                     	<td width="55%" align="left"><input type="text" name="priority" class="inputbox" value="<? echo @$priority;?>"></td>
					</tr>
                    <!--<tr>
                      <td valign="middle" class="text" align="right">Do you want to show this image on index page? </td>
                      <td height="28" align="left" valign="middle"><select class="combobig" name="toshow">
					  <option value="0">No</option>
					  <option value="1">Yes</option>
					  </select></td>
                    </tr>
                    <tr>
                      <td valign="middle" class="text" align="right">Do you want to show this style on index page?</td>
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
<? include 'footer.php';