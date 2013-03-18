<?php
	include("../common.php");
	include('../functionsadmin.php');
	//include('security.php');

	$catid = isset($_POST['catidx']) ? $_POST['catidx'] : '';
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	
	if ($action == 'edit')
	{
		if (@$designer_name != '')
		{
			$strFile1        =  $_FILES["i_image"]["name"];
			$strTempFile1    =  $_FILES["i_image"]["tmp_name"];
			$footer_text	 =  $_POST['footer'];
			$subcats		 =  $_POST['subcats'];
			
			if ( ! empty($subcats))
			{
				/*
				| ----------------------------------------------------------------------------------
				| For each subcat, check and create folders where necessary
				*/
				foreach ($subcats as $sub)
				{
					//combine all subcats to a comma separated string
					@$subcat .= $sub.',';

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
						WHERE d.des_id = '".$_POST['eid']."'
						AND sc.subcat_id = '".$sub."'
					");
					$subcatq 	= mysql_fetch_array($get_subcat);
					
					$path 		= "../product_assets/".$subcatq['c_folder']."/".$subcatq['d_folder'];
					$subfolder  = $path.'/'.trim($subcatq['sc_folder']);
					
					//add subfolder under designer where necessary
					if ( ! file_exists($subfolder))
					{
						$old = umask(0);
						if ( ! mkdir($subfolder, 0777, TRUE)) die('Unable to create "'.$subfolder.'" folder.');
						umask($old);
					}
					
					//add product view folders where necessary
					if ( ! file_exists($subfolder.'/product_back'))
					{
						$old = umask(0);
						if ( ! mkdir($subfolder.'/product_back', 0777, TRUE)) die('<br />Unable to create "'.$subfolder.'/product_back".');
						umask($old);
					}
					if ( ! file_exists($subfolder.'/product_coloricon'))
					{
						$old = umask(0);
						if ( ! mkdir($subfolder.'/product_coloricon', 0777, TRUE)) die('Unable to create "'.$subfolder.'/product_coloricon".');
						umask($old);
					}
					if ( ! file_exists($subfolder.'/product_front'))
					{
						$old = umask(0);
						if ( ! mkdir($subfolder.'/product_front', 0777, TRUE)) die('Unable to create "'.$subfolder.'/product_front".');
						umask($old);
					}
					if ( ! file_exists($subfolder.'/product_side'))
					{
						$old = umask(0);
						if ( ! mkdir($subfolder.'/product_side', 0777, TRUE)) die('Unable to create "'.$subfolder.'/product_side".');
						umask($old);
					}
					if ( ! file_exists($subfolder.'/product_video'))
					{
						$old = umask(0);
						if ( ! mkdir($subfolder.'/product_video', 0777, TRUE)) die('Unable to create "'.$subfolder.'/product_video".');
						umask($old);
					}
					
					// free up mysql memory
					mysql_free_result($get_subcat);
				}
			}
			else
			{
				$subcat = '';
			}
			
			/*
			| ----------------------------------------------------------------------------------
			| Update the db table 'designer'
			*/
			if ( ! empty($strFile1) && file_exists($strTempFile1))
			{
				// Update the table with icon image
				$randomno = RandomNumber(5);
				$strFileName1 = $randomno.strtolower($strFile1);

				//Upload the File1.
				copy($strTempFile1,"../images/designer_icon/".$strFileName1);
				gd2resize("../images/designer_icon/".$strFileName1,169,129,"../images/designer_icon/thumb/","");
				gd2resize("../images/designer_icon/".$strFileName1,579,446,"../images/designer_icon/zoom/","");
			
				$update_query = "
					UPDATE designer
					SET 
						designer = '$designer_name', 
						catid = '".trim($_POST['catidx'])."', 
						folder = '".trim($_POST['folder'])."', 
						destype_id = '".$_POST['destype_id']."',
						icon_img = '$strFileName1',
						title = '".addslashes($title)."',
						description = '".addslashes($description)."',
						keyword = '".addslashes($keyword)."',
						alttags = '".addslashes($alttags)."',
						url_structure = '".addslashes($url_structure)."',
						footer = '".addslashes($footer_text)."',
						priority = '".(int)$priority."', 
						subcats = '".$subcat."' 
					WHERE
						des_id = '$eid'
				";
			}
			else
			{
				// Update the table even without icon image
				$update_query = "
					UPDATE designer 
					SET 
						designer = '$designer_name',
						catid = '".trim($_POST['catidx'])."', 
						folder = '".trim($_POST['folder'])."', 
						destype_id = '".$_POST['destype_id']."',
						title = '".addslashes($title)."',
						description = '".addslashes($description)."',
						keyword = '".addslashes($keyword)."',
						alttags = '".addslashes($alttags)."',
						url_structure = '".addslashes($url_structure)."',
						footer = '".addslashes($footer_text)."',
						priority = '".(int)$priority."',
						subcats = '".$subcat."' 
					WHERE
						des_id = '$eid'
				";
			}

			//echo  '>>>'.$update_query;
			mysql_query($update_query) or die("Update Designer error: ".mysql_error());

			print "<script>opener.location.href='edit_designer.php';window.close();</script>";
		}
		else
		{
			$err = "Please complete all the entries.";
		}
	}

	$select = "select * from designer where des_id='$eid'";
	$result = mysql_query($select);
	$row = mysql_fetch_array($result);

	if (@$designer_name == '')
	{
		$designer_name = $row['designer'];
		$catid = $row['catid'];
		$destype_id = $row['destype_id']; 
		$icon_img = $row['icon_img'];
		$subcategory = $row['subcats'];
		$priority = $row['priority'];
		$folder = $row['folder'];
	}

	//echo 'catid:'.$catid
?>
<title>Admin Section</title>
<script>
	function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp = false;	
		try {
			xmlhttp = new XMLHttpRequest();
		}
		catch(e) {
			try {	
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e) {
				try {
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1) {
					xmlhttp = false;
				}
			}
		}
		return xmlhttp;
	}
	
	function getDesigner(strURL) {
		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('designerdiv').innerHTML = req.responseText;						
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
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="1" cellspacing="1">
<tr><td>

	<!-----start-----------//-->
	<!--bof form========================================================================-->
	<form name="color" action="<?php echo $_SERVER['PHP_SELF'];?>?eid=<?=$eid;?>&action=edit" method="post"  enctype="MULTIPART/FORM-data">
	<table width="100%" border="1" bordercolor=cccccc cellspacing="0" cellpadding="0">
	<tr><td>
	
		<input type="hidden" name="eid" value="<?=@$eid;?>">
		<input type="hidden" name="destype_id" value="<?=@$destype_id;?>">
		
		<table width="100%" align="center" cellspacing="2" cellpadding="2">
			<tr bgcolor="cccccc">
				<td align="center" colspan="2">
					<b><font size="2" color="#000000" face="verdana,Arial">Edit Designer
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2"><b><font size="2" face="verdana" color="red"><?=@$err;?></td>
			</tr>
			<tr>
				<td valign=top><font size="2" color="#000000" face="verdana,Arial">Designer Name:</td>
				<td><input type="text" name="designer_name" class="inputbox" value="<?=@$designer_name;?>"></td>
			</tr>
			<tr>
				<td><font size="2" color="#000000" face="verdana,Arial">Category</font></td>
				<td>
					<select name="catidx">
						<option> - select category - </option>
						<?php
						$cat = mysql_query("select * from tblcat");
						if (mysql_num_rows($cat) > 0)
						{
							while ($rowc = mysql_fetch_array($cat))
							{ ?>
								<option value="<?=$rowc['cat_id']?>" <?php echo $rowc['cat_id'] == $catid ? 'selected' : ''; ?>><?=$rowc['cat_name']?></option> 
								<?php
							}
						} ?>
					</select>					
				</td>
			</tr>
			<tr>
				<td><font size="2" color="#000000" face="verdana,Arial">Subcategory</font></td>
				<td>
					<?php
					$sc = explode(',',$subcategory);
					$get_subcats = mysql_query("SELECT * FROM tblsubcat where cat_id = '".$row['catid']."' order by subcat_name");
					if (mysql_num_rows($get_subcats) > 0)
					{
						while ($srow = mysql_fetch_array($get_subcats))
						{
							$checked = $srow['subcat_id'] == in_array($srow['subcat_id'], $sc) ? 'checked' : '';
							?>
							<div class="text" style="width:180px;float:left;"><input type="checkbox" name="subcats[]" value="<?php echo $srow['subcat_id']; ?>" <?php echo @$checked; ?> /> <?php echo $srow['subcat_name']; ?></div>
							<?php
						}
					}
					else
					{
						echo 'No subcategory return';
					} ?>
					<div style="clear:left;"></div>
				</td>
			</tr>
			<tr>
				<td><font size="2" color="#000000" face="verdana,Arial">Folder</font></td>
				<td><input type="text" name="folder" value="<?=$row['folder']?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="error"><img src="resizeimage.php?w=169&h=129&constrain2=1&img=../images/designer_icon/thumb/<?php echo $icon_img;?>"></td>
			</tr>
			<tr>
				<td valign=top class="text"><font size="2" color="#000000" face="verdana,Arial">Upload New Icon Image : </font></td>
				<td align="left"><input type="file" name="i_image" id="i_image" class="inputbox" />
					<br />
					<span style="color:#FF0000;" class="text">images size should be<br /> 169(w)px X 129(h)px</span>
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
				<td valign=top class="text" align="right">Footer Text:</td>
				<td><textarea name="footer" class="textareabig" style="width:500px;height:180px;"><?=stripslashes($row['footer']);?></textarea></td>
			</tr>
			<tr>
				<td valign=top align=right class="text" >Priority (affects the order in which category is displayed 1-127)</td>
				<td width="55%" align="left"><input type="text" name="priority" class="inputbox" value="<?php echo @$priority; ?>"></td>
			</tr>
			<tr>
				<td colspan="2" align=center><input type="submit" value=" Save " class=button> </td>
			</tr>
		</table>

	</td></tr>
	</table>
	</form>
	<!-------end-------//-->
	
</td></tr>
</table>
