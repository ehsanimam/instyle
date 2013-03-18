<?php
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php");

	//$strFile1        =  $_FILES["style_image"]["name"];
	//$strTempFile1    =  $_FILES["style_image"]["tmp_name"];
	//echo '>>>'.$name.':'.$eid;
	if (@$action == 'edit')
	{
		if ($name != '')
		{
			$update_query = "update tblcolors set color_name='$name',priority='$priority', heading_id='$heading_id',title='".addslashes($title)."',description='".addslashes($description)."',keyword='".addslashes($keyword)."',alttags='".addslashes($alttags)."',url_structure='".addslashes($url_structure)."' where color_id='$eid'";
			mysql_query($update_query);
			
			if ($style_image != '')
			{
				//admin_newcatimg($style_image, $eid);
				/*$strFile1        =  $_FILES["pdF"]["name"];
				$strTempFile1    =  $_FILES["pdF"]["tmp_name"];  
				move_uploaded_file($strTempFile1,"pdf/".strtolower($strFile1));*/
			}
	
			//******************************************** Price PDF
			$strFile1_pdf_p  =  strtolower($_FILES["pdF_price"]["name"]);
			$strTempFile1_pdf_p=  $_FILES["pdF_price"]["tmp_name"];  
	   
			if (!empty($strTempFile1_pdf_p))
			{
					//Delete the image file from server
					//@unlink("pdf_price/".$strFile1_pdf_p);
					move_uploaded_file($strTempFile1_pdf_p,"pdf_price/".$strFile1_pdf_p);
					
					$sql_pdf_p="update tblcolors set pdf_p='$strFile1_pdf_p' where color_id ='$eid'";
	 
					mysql_query($sql_pdf_p) or die("Error updating tblcolors");
			}
			
			//********************************************************
			//******************************************* Color PDF
			$strFile1_pdf_c  =  strtolower($_FILES["pdF_color"]["name"]);
			$strTempFile1_pdf_c=  $_FILES["pdF_color"]["tmp_name"];  
	   
			if (!empty($strTempFile1_pdf_c))
			{
					//Delete the image file from server
					//@unlink("pdf_color/".$strFile1_pdf_c);
					move_uploaded_file($strTempFile1_pdf_c,"pdf_color/".$strFile1_pdf_c);
					
					$sql_pdf_c="update tblcolors set pdf_c='$strFile1_pdf_c' where style_id ='$eid'";
	 
					mysql_query($sql_pdf_c) or die("Error updating tblstyle");
			}
		
			//*****************************************************	
		
			print "<script>opener.location.href='edit_acc_color_facet.php';window.close();</script>";
		}
		else
		{
			$err = "Please complete all the entries.";
		}
	}

	$select="select * from tblcolors where color_id='$eid' AND heading_id = '19'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);

	if(@$name=='')
	{
		$name=$row['color_name'];
		$imgn=$row['color_img'];
		$imgs=$row['img_name'];
		$def_substyle_id=$row['def_substyle_id'];
		$priority=$row['priority'];
	}

	/*
	$select="select * from tblright where which_page='$eid' order by img_date desc";
	$res=mysql_query($select);
	$rw=mysql_fetch_array($res);
	*/
?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">

<!--bof form=================================================================================-->
<form name="style" action="color_edit_acc_facet_popup.php?eid=<?=$eid;?>&action=edit" method="post" enctype="MULTIPART/FORM-data">
<table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td>
	<input type="hidden" name=eid value="<?=$eid;?>">
	<table width=100% align=center cellspacing=2 cellpadding=2>
		<!--DWLayoutTable-->
		<tr bgcolor=cccccc> 
            <td align=center colspan=2><h1>Edit Color Facet - <span style="color:red;">Jewelries And Accessories</span></h1></td>
		</tr>
		<tr>
            <td align=center colspan=2 class="error">
				<?=@$err;?>
            </td>
		</tr>
		<tr> 
            <td width="460" valign=top class="text" align="right">Color Name : </td>
            <td width="413"><input type="text" name="name" class="inputbox" value="<?=$name;?>"></td>
		</tr>
		<tr> 
            <td width="460" valign=top class="text" align="right">Head Name : </td>
            <td width="413">
				<?php
				/*
				| ------------------------------------------------------------------------------------------------
				| Assigning facets into two groups - Womens Apparel and Jewelry And Accessories
				| Setting each to it's own
				|
				$sql = sprintf("select id, headings from tbl_type_headings");
				echo SelectValue($sql, "heading_id", @$row[heading_id]); 
				*/
				?>
				<select name="heading_id">
					<option value="19">Jewelry And Accessories</option>
				</select>
			</td>
		</tr>
		<tr>
            <td align=center colspan=2 class="error"><img src="../images/style/<?=$imgn;?>"></td>
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
            <td class="text" align="right">Upload Big New Image : </td>
            <td align="left"><input type="file" name="style_image" class="inputbox"></td>
		</tr>
		<tr> 
            <td height="30" colspan="2" align="center" valign="top">
				<span class="text" style="color:#FF0000">(image size should be 7500(w) x568(h) px)</span>
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
		<tr>
			<td valign=top align=right class="text" >Priority (affects the order in which style is displayed 1-127)</td>
			<td width="55%" align="left"><input type="text" name="priority" class="inputbox" value="<? echo @$priority;?>"></td>
		</tr>
		<?php
		/*
	  	for ($cnt=0;$cnt<4;$cnt++)
   		{
   			$imgn=mysql_result($res,$cnt,1);
			$rid=mysql_result($res,$cnt,0);
			$sub_id=mysql_result($res,$cnt,3);
			$rowid="rowid".$cnt;   		
		}
		*/
		?>
		<tr>
            <td colspan=2 align=center><input type="submit" value="Update" class=button>
            </td>
		</tr>
	</table>
</td></tr>
</table>
</form>
<!--bof form=================================================================================-->
