<?php
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php");

	if (@$action == 'add')
	{
		if ($sub_name != '' && $cat != '')
		{
			// Insert subcat to tblsubcat
			$getid = admin_ins_subcat($cat,$sub_name,$title,$description,$keyword,$alttags,$url_structure,$footer);
		
			if ($getid != -1) // ---> mysql_insert_id or -1
			{
				// add subcat to designer table
				$sel_des_2 = "SELECT * FROM designer WHERE des_id = '".$_POST['linked_designer']."'";
				$qry_des_2 = mysql_query($sel_des_2) or die('Select error: '.mysql_error());
				$ary_des_2 = mysql_fetch_array($qry_des_2);
				
				$subcats = $ary_des_2['subcats'].$getid.',';
				
				$upd_des_3 = "
					UPDATE designer
					SET subcats = '".$subcats."'
					WHERE des_id = '".$_POST['linked_designer']."'
				";
				$qry_des_3 = mysql_query($upd_des_3) or die('Update error: '.mysql_error());
				
				// queries for folder structuring
				$get_subcat = mysql_query("
					SELECT
						c.folder AS c_folder, 
						sc.folder AS sc_folder, 
						d.folder AS d_folder
					FROM
						designer d
						JOIN tblsubcat sc ON sc.cat_id = d.catid
						JOIN tblcat c ON c.cat_id = sc.cat_id
					WHERE d.des_id = '".$_POST['linked_designer']."'
					AND sc.subcat_id = '".$getid."'
				");
				$subcatq 	= mysql_fetch_array($get_subcat);
				
				$path 		= "../product_assets/".$subcatq['c_folder']."/".$subcatq['d_folder'];
				$subfolder  = $path.'/'.trim($url_structure);
				// at products image repo
				$path_var 		= IMG_REPO_URL_VAR."product_assets/".$subcatq['c_folder']."/".$subcatq['d_folder'];
				$subfolder_var  = $path_var.'/'.trim($url_structure);
				
				//add subfolder under designer where necessary
				if ( ! file_exists($subfolder))
				{
					$old = umask(0);
					if ( ! mkdir($subfolder, 0777, TRUE)) die('Unable to create "'.$subfolder.'" folder.');
					umask($old);
				}
				if ( ! file_exists($subfolder_var)) // --> at the products image repo
				{
					$old = umask(0);
					if ( ! mkdir($subfolder_var, 0777, TRUE)) die('Unable to create "'.$subfolder_var.'" folder.');
					umask($old);
				}
				
				// --> because storybook has subsubcats
				// now subsubcats at storybook are to be removed
				if (SITE_DOMAIN !== 'www.storybookknits.com_')
				{
					//add product view folders where necessary
					$folder_paths = array($subfolder, $subfolder_var);
					foreach ($folder_paths AS $the_path)
					{
						if ( ! file_exists($the_path.'/product_back'))
						{
							$old = umask(0);
							if ( ! mkdir($the_path.'/product_back', 0777, TRUE)) die('<br />Unable to create "'.$the_path.'/product_back".');
							umask($old);
						}
						if ( ! file_exists($the_path.'/product_coloricon'))
						{
							$old = umask(0);
							if ( ! mkdir($the_path.'/product_coloricon', 0777, TRUE)) die('Unable to create "'.$the_path.'/product_coloricon".');
							umask($old);
						}
						if ( ! file_exists($the_path.'/product_front'))
						{
							$old = umask(0);
							if ( ! mkdir($the_path.'/product_front', 0777, TRUE)) die('Unable to create "'.$the_path.'/product_front".');
							umask($old);
						}
						if ( ! file_exists($the_path.'/product_side'))
						{
							$old = umask(0);
							if ( ! mkdir($the_path.'/product_side', 0777, TRUE)) die('Unable to create "'.$the_path.'/product_side".');
							umask($old);
						}
						if ( ! file_exists($the_path.'/product_video'))
						{
							$old = umask(0);
							if ( ! mkdir($the_path.'/product_video', 0777, TRUE)) die('Unable to create "'.$the_path.'/product_video".');
							umask($old);
						}
					}
				}
				
				$err = "SubCategory has been added.";
				$sub_name = '';
				$cat = '';
			}
			else
			{
				$err = "SubCategory already exists.";
				//header('location:add_subcategory.php?err='.$err);
			}
		}
		else
		{
			$err = "Please complete all the entries.";
		}
	}

	// Query categories
	$q_cat = "SELECT * FROM tblcat ORDER BY cat_name ASC";
	$a_cat = mysql_query($q_cat);
	$n_cat = mysql_num_rows($a_cat);
	
	// Query designers
	if (SINGLE_DESIGNER_SITE)
	{
		$q_des = "SELECT * FROM designer WHERE designer = '".SITE_NAME."'";
		$a_des = mysql_query($q_des);
		$n_des = mysql_num_rows($a_des);
	}
	else
	{
		$q_des = "SELECT * FROM designer ORDER BY designer ASC";
		$a_des = mysql_query($q_des);
		$n_des = mysql_num_rows($a_des);
	}
	
	include 'top.php'; 
?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="333" class="tab" align="center" valign="middle">
	
	<!--bof form============================================================================-->
	<form name="subcategory" action="add_subcategory.php?action=add" method="post" enctype="MULTIPART/FORM-data">
	<table width=85% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2>
			<tr bgcolor=cccccc>
				<td align=center colspan=2><h1>ADD Sub Category</h1></td>
			</tr>
			<tr>
				<td align=center colspan=2 class=error><?=@$err;?></td>
			</tr>
			<?php
			if ($n_cat > 0)
			{ ?>
                <tr>
					<td width="48%" valign=top class="text" align="right">Select Category : </td>
					<td width="52%" align="left">
						<select name="cat" class=combobig>
							<option value="">Select</option>
							<?php
							while ($row_cat = mysql_fetch_array($a_cat))
							{
								if ($row_cat['cat_id'] != 23) // ---> not clearance
								{ ?>
									<option value="<?=@$row_cat['cat_id'];?>"><?=$row_cat['cat_name'];?></option>
									<?php
								}
							} ?>
						</select>
						<script language="JavaScript">document.subcategory.cat.value="<?=$cat;?>" </script>
					</td>
                </tr>
                <?php
			} ?>
			<tr> 
				<td valign=top class="text" align="right">SubCategory : </td>
				<td align="left"><input type="text" name="sub_name"  class="inputbox" value="<?=@$sub_name;?>"></td>
			</tr>
			
			<?php if (SINGLE_DESIGNER_SITE): ?>
			
				<input type="hidden" name="linked_designer" value="<?php echo $row_des['des_id']; ?>" />
				
			<?php else: ?>
			
				<tr><td valign=top class="text" align="right" colspan="2">&nbsp;</td></tr> <!-- spacer -->
				<tr> 
					<td valign=top class="text" align="right"></td>
					<td align="left" class="text">
						<span style="font-style:italic;color:red;">
							Link a designer to the subcat in order to create the image directories
						</span>
					</td>
				</tr>
				<tr>
					<td valign=top class="text" align="right">Designers : </td>
					<td align="left">
						<?php
							if ($n_des > 0)
							{
								while ($row_des = mysql_fetch_array($a_des))
								{ ?>
									<div class="text" style="width:180px;float:left;">
										<input type="checkbox" name="linked_designer" value="<?php echo $row_des['des_id']; ?>" />
										<?php echo '&nbsp;'.$row_des['designer']; ?>
									</div>
									<?php
								}
							}
						?>
					</td>
				</tr>
				<tr> 
					<td valign=top class="text" align="right"></td>
					<td align="left" class="text">
						<span style="font-style:italic;color:red;">
							If you need to link this subcat to another designer,<br />
							please go to edit link of Edit/Delet Designer menu.
						</span>
					</td>
				</tr>
				
			<?php endif; ?>
			
			<tr><td valign=top class="text" align="right" colspan="2">&nbsp;</td></tr> <!-- spacer -->
			<tr>
				<td valign=top class="text" align="right">Icon Image : </td>
				<td align="left"><input type="file" name="i_image" id="i_image" class="inputbox" /></td>
			</tr>
			<tr>
				<td valign=top>&nbsp;</td>
				<td height="28" align="left" valign="top"><span class="text" style="color:#FF0000">images size should be 169(w)px X 129(h)px</span></td>
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
				<td valign=top class="text" align="right">Footer Text:</td>
				<td align="left"><textarea name="footer" class="textareabig" style="width:500px;height:180px;"><?=@$footer_text;?></textarea></td>
			</tr>	
			<tr>
				<td>&nbsp;</td><td align="left"> <input type="submit" value="Add" class=button> </td>
			</tr>
		</table>
	</td></tr>
	</table>
	</form>
	<!--eof form============================================================================-->
	
</td></tr>
</table>
<?php include 'footer.php';