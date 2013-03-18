<?php
	include("../common.php");
	include('../functionsadmin.php');
	//include("security.php");

	//$strFile1        =  $_FILES["cat_image"]["name"];
	//$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

	if(isset($_GET['action']) && $_GET['action'] == 'edit')
	{
		$strOldFile1 = $_POST['strOldFile1'];
		if($_POST['name']!='')
		{
		//****************************************************
			$strFile1        =  $_FILES["i_image"]["name"];
			$strTempFile1    =  $_FILES["i_image"]["tmp_name"];

			if($strFile1!="")
			{
				if (!empty($strOldFile1) && file_exists("../images/subsubcategory_icon/".$strOldFile1))
				{
						//Delete the image file from server
						//@unlink("../images/subcategory_icon/".$strOldFile1);
						@unlink("../images/subsubcategory_icon/thumb/".$strOldFile1);
						//@unlink("../images/subcategory_icon/zoom/".$strOldFile1);
						
						// at the image repo
						@unlink(IMG_REPO_URL_VAR."images/subsubcategory_icon/thumb/".$strOldFile1);
				}
						$randomno=RandomNumber(5);
						$strFileName1   = $randomno.strtolower($strFile1);
				
						//Upload the File1.
						copy($strTempFile1,"../images/subsubcategory_icon/".$strFileName1);
						copy($strTempFile1,"../images/subsubcategory_icon/thumb/".$strFileName1);
						// at the image repo
						copy($strTempFile1,IMG_REPO_URL_VAR."images/subsubcategory_icon/".$strFileName1);
						copy($strTempFile1,IMG_REPO_URL_VAR."images/subsubcategory_icon/thumb/".$strFileName1);
						
						gd2resize("../images/subsubcategory_icon/thumb/".$strFileName1,169,129,"../images/subsubcategory_icon/thumb/","");
						//gd2resize("../images/subcategory_icon/".$strFileName1,579,446,"../images/subcategory_icon/zoom/","");
						// at the image repo
						gd2resize(IMG_REPO_URL_VAR."images/subsubcategory_icon/thumb/".$strFileName1,169,129,IMG_REPO_URL_VAR."images/subsubcategory_icon/thumb/","");
			}		
	 
	  //*************************************************************************************************** 

		//******************************************** Price PDF
	   /*$strFile1_pdf_p  =  strtolower($_FILES["pdF_price"]["name"]);
	   $strTempFile1_pdf_p=  $_FILES["pdF_price"]["tmp_name"]; */ 
   
		/*if (!empty($strTempFile1_pdf_p))
		{
				//Delete the image file from server
				//@unlink("pdf_price/".$strFile1_pdf_p);
				move_uploaded_file($strTempFile1_pdf_p,"pdf_price/".$strFile1_pdf_p);
				
				$sql_pdf_p="update tblsubsubcat set pdf_p='$strFile1_pdf_p' where subcat_id='$eid'";
 
				mysql_query($sql_pdf_p) or die("Error updating tblcat");
		}*/
	//********************************************************
	//******************************************* Color PDF
		/*$strFile1_pdf_c  =  strtolower($_FILES["pdF_color"]["name"]);
	    $strTempFile1_pdf_c=  $_FILES["pdF_color"]["tmp_name"];  
   
		if (!empty($strTempFile1_pdf_c))
		{
				//Delete the image file from server
				//@unlink("pdf_color/".$strFile1_pdf_c);
			if (!file_exists("pdf_color/".$strFile1_pdf_c))
			{			
				move_uploaded_file($strTempFile1_pdf_c,"pdf_color/".$strFile1_pdf_c);
			}	
				$sql_pdf_c="update tblsubcat set pdf_c='$strFile1_pdf_c' where subcat_id='$eid'";
 
				mysql_query($sql_pdf_c) or die("Error updating tblcat");
		}
		*/
	//*****************************************************	

		if($strFileName1==""){
			$strFileName1 = $strOldFile1;
		}
	  	$update_query="update tblsubsubcat set name='$name',icon_img='$strFileName1',title='".addslashes($title)."',description='".addslashes($description)."',keyword='".addslashes($keyword)."',alttags='".addslashes($alttags)."',url_structure='".addslashes($url_structure)."' where id='$eid'";
		mysql_query($update_query) or die("Error updating tblsubcat1");
		
		
		if ($cat_image!='')
		{
			//admin_newsubcatimg($cat_image, $eid);
		}
		print "<script>opener.location.href='edit_subsubcategory.php';window.close();</script>";
	}
  else
  {
   	$err="Please complete all the entries.";
  }
}

$select="select * from tblsubsubcat where id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<form name="category" action="subsubcat_edit_popup.php?eid=<?=@$eid;?>&action=edit" method="post" enctype="MULTIPART/FORM-data">
<table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
<input type="hidden" name=eid value="<?=@$eid;?>">
<input type="hidden" name="strOldFile1" id="strOldFile1" value="<?php echo $row['icon_img'];?>" />
	<table width=100% align=center cellspacing=2 cellpadding=2>
	<tr bgcolor=cccccc>
		<td align=center colspan=2><h1>Edit Sub Sub-Category</h1></td></tr>
	<tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>
	<tr>
		<td valign=top class="text" align="right">Sub-Category Name:</td>
		<td><input type="text" name="name" class="inputbox" value="<?=$row['name'];?>"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="error"><img src="<?php echo IMG_REPO_URL; ?>images/subsubcategory_icon/thumb/<?php echo $row['icon_img'];?>"></td>
	</tr>
	<tr>
			<td class="text" align="right">Upload New Icon Image</td>
			<td align="left"><input type="file" name="i_image" id="i_image" class="inputbox"><br />
			 <span style="color:#FF0000;" class="text">images size should be 169(w)px X 129(h)px</span>
			
			</td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Title:</td>
		<td><input type="text" name="title" class="inputboxbig" value="<?=stripslashes($row['title']);?>"></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Description:</td>
		<td><textarea name="description" class="textareabig"><?=stripslashes($row['description']);?></textarea></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Keywords:</td>
		<td><textarea name="keyword" class="textareabig"><?=stripslashes($row['keyword']);?></textarea></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Alt Tags:</td>
		<td><input type="text" name="alttags" class="inputboxbig" value="<?=stripslashes($row['alttags']);?>"></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Url Structure:</td>
		<td><input type="text" name="url_structure" class="inputboxbig" value="<?=stripslashes($row['url_structure']);?>"></td>
	</tr>
	
	<tr><td colspan=2 align=center><input type="submit" value="Update" class=button> </td></tr>
	</table>
</td></tr></table>
</form>