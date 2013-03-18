<?
include("../common.php");
include('../functionsadmin.php');
include("security.php");

//$strFile1        =  $_FILES["cat_image"]["name"];
//$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

if($_GET['action']=='edit')
{
	
	  	if($_POST['type_name']==''){
		$err="Please complete all the entries.";
    	}else{
		$update_query="update tbltypesubcat set type_name='$type_name',heading_id='$headings',title='".addslashes($title)."',description='".addslashes($description)."',keyword='".addslashes($keyword)."',alttags='".addslashes($alttags)."'  where type_id='$eid'";
		mysql_query($update_query) or die("Error updating Heading");
		
		print "<script>opener.location.href='edit_typesubcategory.php';window.close();</script>";
		}
}
else
{
   	
}

$select="select * from tbltypesubcat where type_id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


if(@$type_name=='')
{
 $type_name=$row['type_name'];
 $heading=$row['heading_id'];
}

?>
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
	
	
	
	function getQty(strURL) {
	
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('subcatdiv').innerHTML=req.responseText;						
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
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<form name="category" action="typesubcat_edit_popup.php?eid=<?=@$eid;?>&action=edit" method="post" enctype="MULTIPART/FORM-data">
<table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
<input type="hidden" name=eid value="<?=@$eid;?>">
<!--<input type="hidden" name="strOldFile1" id="strOldFile1" value="<?php echo $row['icon_img'];?>" />-->
	<table width=100% align=center cellspacing=2 cellpadding=2>
	<tr bgcolor=cccccc>
		<td align=center colspan=2><h1>Edit Type-Sub Sub Category</h1></td></tr>
	<tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>
	<tr>
                  <td valign=top class="text" align="right"> Sub Category: </td>
                  <td align="left">
				  	<select name="headings" id="headings" class="inputbox" onChange="getQty('subcat2.php?option=typesubcat&subcatid='+this.value)">
						<option value="">---Select---</option>
						<?php
							$sql_heading = "select * from tblsubcat";
							$res_heading = mysql_query($sql_heading);
							while($row_heading = mysql_fetch_array($res_heading)) {
								if($heading == $row_heading['subcat_id']){
									$selected = "selected";
								}else{
									$selected = "";
								}
						 ?>
						 <option value="<?php echo $row_heading['subcat_id']?>" <?php echo $selected;?>><?php echo $row_heading['subcat_name'];?></option>
						 <?php } ?>
					</select>
				  </td>
                </tr>
                <tr>
		<td valign=top class="text" align="right">Type -Sub Sub Category Name:</td>
		<td><div id="subcatdiv"><select name="type_name" id="type_name" class="inputbox">
						<option value="">---Select---</option>
						<?php
							$sql_heading1 = "select * from tblsubsubcat where subcat_id='".$heading."'";
							$res_heading1 = mysql_query($sql_heading1);
							while($row_heading1 = mysql_fetch_array($res_heading1)) {
							
							if($type_name == $row_heading1['id']){
									$selected = "selected";
								}else{
									$selected = "";
								}
						 ?>
						 <option value="<?=$row_heading1['id']?>" <?php echo $selected;?>><?php echo $row_heading1['name'];?></option>
						 <?php } ?>
					</select></div></td>
	</tr>
                <tr>
		<td valign=top class="text" align="right">Title:</td>
		<td><input type="text" name="title" class="inputboxbig" value="<?=stripslashes($row['title']);?>"></td>
	</tr>
     <tr>
		<td valign=top class="text" align="right">Description:</td>
		<td><textarea name="keyword" class="textareabig"><?=stripslashes($row['description']);?></textarea></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Keywords:</td>
		<td><textarea name="keyword" class="textareabig"><?=stripslashes($row['keyword']);?></textarea></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Alt Tags:</td>
		<td><input type="text" name="alttags" class="inputboxbig" value="<?=stripslashes($row['alttags']);?>"></td>
	</tr>
	<!--<tr>
		<td>&nbsp;</td>
		<td class="error"><img src="../images/subcategory_icon/thumb/<?php echo $row['icon_img'];?>"></td>
	</tr>
	<tr>
			<td class="text">Upload New Image</td>
			<td align="left"><input type="file" name="i_image" id="i_image" class="inputbox"></td>
	</tr>-->
	<tr><td colspan=2 align=center><input type="submit" value="Update" class=button> </td></tr>
	</table>
</td></tr></table>
</form>