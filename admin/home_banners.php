<?php
	session_start();
	include("../common.php");
	include 'top.php';
	
	/*
	| ---------------------------------------------------------------------------
	| This file displays all the banners used to display at the sidebar of the home page.
	|
	| This file also displays the active banenrs published at the home page.
	|
	| This file is self serving the form choices and should initially check for
	| varialbes set at the uri.
	|
	*/
	
	// Compare databse with actual files in directory
	$file_array = scandir('../images/banners');
	$query = "SELECT * FROM home_banners";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) != (count($file_array) - 2))
	{
		$notice = "There is a disparity between your database and files in directory.<br/>";
		$notice .= "Database shows ".mysql_num_rows($result)." records.<br />";
		$notice .= "Directory shows ".(count($file_array) - 2)." files.<br /><br />";
		$notice .= "If an image is missing, below table should show the filename without image.";
	}
	
	// Check if banner dispaly is full, half full, empty
	$query = "SELECT * FROM home_banners WHERE is_published = '1'";
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) == 2)
	{
		$ispubfull = 2;
	}
	else if (mysql_num_rows($result) == 1)
	{
		$ispubfull = 1;
	}
	else
	{
		$ispubfull = 0;
	}
	
	// Check if action is set at the url
	if ($_REQUEST['action'] && $_REQUEST['action'] != '')
	{
		$action = $_REQUEST['action'];
	}

	// Action is 'publish'
	if ($action == 'publish')
	{
		$query = "SELECT sequence FROM home_banners WHERE is_published = '1'";
		$result = mysql_query($query) or die (mysql_error());
		if (mysql_num_rows($result) == 0) $sequence = 1;
		else
		{
			$row = mysql_fetch_array($result);
			if ($row['sequence'] == 2) $sequence = 1;
			if ($row['sequence'] == 1) $sequence = 2;
		}
			
		$query = "UPDATE home_banners SET is_published = '1', sequence = '".$sequence."' WHERE banner_id = '".$_GET['id']."'";
		$result = mysql_query($query) or die (mysql_error());
		header("Location: home_banners.php");
	}

	// Action is 'remove'
	if ($action == 'remove')
	{
		$query = "UPDATE home_banners SET is_published = '0', sequence = '0' WHERE banner_id = '".$_GET['id']."'";
		$result = mysql_query($query) or die (mysql_error());
		header("Location: home_banners.php");
	}
		
	// Action is 'movedown'
	if ($action == 'movedown')
	{
		$query = "UPDATE home_banners SET sequence = '2' WHERE sequence = '1'";
		$result = mysql_query($query) or die (mysql_error());
		$query = "UPDATE home_banners SET sequence = '1' WHERE banner_id = '".$_GET['id']."'";
		$result = mysql_query($query) or die (mysql_error());
		header("Location: home_banners.php");
	}
		
	// Action is 'moveup'
	if ($action == 'moveup')
	{
		$query = "UPDATE home_banners SET sequence = '1' WHERE sequence = '2'";
		$result = mysql_query($query) or die (mysql_error());
		$query = "UPDATE home_banners SET sequence = '2' WHERE banner_id = '".$_GET['id']."'";
		$result = mysql_query($query) or die (mysql_error());
		header("Location: home_banners.php");
	}
	
	/*
	*---------------------------------------------------------------------
	* DATABASE functions
	*---------------------------------------------------------------------
	*
	* $db				string		define the database
	*
	* While $db is essential, the rest of the params below must be set to ''
	* if not required for the query
	*
	* $field			string		define where option1 / used as option for select all
	* $value			string		define where option2
	*
	* And then other db functions
	*
	*/
	
	function get_where($idb,$field,$value)
	{
		if ($field == 'all')
		{
			$query = "SELECT * FROM ".$idb." ORDER BY sequence DESC, banner_id DESC";
			$result = mysql_query($query) or die (mysql_error());
			if (mysql_num_rows($result) > 0)
			{
				return $result;
			}
 			else
			{
				return false;
			}
		}
		else
		{
			$query = "SELECT * FROM ".$idb." WHERE ".$field."='".$value."' ORDER BY sequence DESC";
			$result = mysql_query($query) or die (mysql_error());
			if (mysql_num_rows($result) > 0)
			{
				return $result;
			}
			else
			{
				return false;
			}
		}
	}
	
	// Insert to database
	function insert_to_db($idb,$file_name)
	{
		$query = "INSERT INTO ".$idb." (banner_image) VALUES ('".$file_name."')";
		$result = mysql_query($query) or die(mysql_error());
	}
	
	/*
	| ---------------------------------------------------------------------------
	| Start html code
	|
	*/ ?>
	
	<title>Home Banner Details :: Admin Section</title>
	<link href="style.css" rel="stylesheet" type="text/css">
		
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr><td height="300" class="tab" align="center" valign="middle">

		<table style="outline:1px solid #787878;margin: 10px 0 10px;width: 80%;">
		
			<?php
			if ($action == 'add' OR $action == 'upload')
			{ ?>
				
				<tr bgcolor=cccccc valign="middle" height="35"><td align=center><h1>Home Banner Details :: Upload Banners</h1></td></tr>
				
					<tr><td>
					
						<h1><strong>&nbsp; Add Banners</strong></h1>
						
					</td></tr>
					<tr><td width="100%" align="center">
					
						<form action="home_banners.php?action=upload" method="POST" enctype="multipart/form-data">
							<br />
							<label for="file" class="text">Filename:</label>
							<input type="file" name="file" id="file" size="60" />
							<br /><br />
							<input type="submit" name="submit" value="Upload" />
						</form>
						
					</td></tr>
					<tr><td width="100%" align="center" class="text">
						<br>
						<?php
						/*
						| ------------------------------------------------------------------------------
						| Uploading process
						| ------------------------------------------------------------------------------
						*/
						if ($action == 'upload')
						{
							if ((($_FILES["file"]["type"] == "image/gif")
							OR ($_FILES["file"]["type"] == "image/png")
							OR ($_FILES["file"]["type"] == "image/jpeg")
							OR ($_FILES["file"]["type"] == "image/pjpeg"))
							&& ($_FILES["file"]["size"] < 50000))
							{
								if ($_FILES["file"]["error"] > 0)
								{
									/*-html output-*/
									/*-File erro-*/
									echo '<table style="outline:1px solid #F69679;margin: 10px 0 10px;padding: 10px 0;width: 60%;font-size:bold;color:red;text-align: center;"><tr><td>';
									echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
									echo '</td></tr></table>';
								}
								else
								{
									/*-html output-*/
									echo '<table style="outline:1px solid #F69679;margin: 10px 0 10px;padding: 10px 0;width: 60%;font-size:bold;color:red;text-align: center;"><tr><td>';
									echo "<p>Upload: " . $_FILES["file"]["name"] . "<br />";
									echo "Type: " . $_FILES["file"]["type"] . "<br />";
									echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb</p>";

									if (file_exists("../images/banners/" . $_FILES["file"]["name"]))
									{
										/*-html output-*/
										/*-File alrady exists-*/
										echo '<p><img src="../images/red_camp.gif" alt="error" style="vertical-align:middle;" /> &nbsp; ' . $_FILES["file"]["name"] . ' already exists.</p>';
									}
									else
									{
										/*-html output-*/
										/*-Upload Successful-*/
										move_uploaded_file($_FILES["file"]["tmp_name"],"../images/banners/" . $_FILES["file"]["name"]);
										echo '<p><img src="../images/green_camp.gif" alt="error" style="vertical-align:middle;" /> &nbsp; Stored in: ' . '../images/banners/' . $_FILES["file"]["name"] .'</p><br />';
										echo '<p style="color:black;"><em>You may now upload another file, or, select <a href="home_banners.php">banner</a> to display.</em></p>';
										
										/*-Insert file name into database-*/
										insert_to_db('home_banners',$_FILES["file"]["name"]);
									}
									echo '</td></tr></table>';
								}
							}
							else
							{
								/*-html output-*/
								/*-Invalid file-*/
								echo '<table style="outline:1px solid #F69679;margin: 10px 0 10px;padding: 10px 0;width: 60%;font-size:bold;color:red;text-align: center;"><tr><td>';
								echo '<p><img src="../images/red_camp.gif" alt="error" style="vertical-align:middle;" /> &nbsp; Invalid file</p>';
								echo '</td></tr></table>';
							}
						} ?>
					</td></tr>
					<tr><td class="text">
						<p>
							<em>&nbsp; NOTE:
							<br />&nbsp; File size must not exceed 50kb.
							<br />&nbsp; <span style="color:red;">File dimension must be 190 x 94 otherwise warping may occur.</span></em>
							<span style="float:right;">Return to <a href="home_banners.php">View</a> mode&nbsp;</span>
						<p>
					</td></tr>
					<?php
			}
			else
			{
				/*
				| ------------------------------------------------------------------------------
				| Viewing mode
				| ------------------------------------------------------------------------------
				*/ ?>
				<tr bgcolor=cccccc valign="middle" height="35"><td align=center><h1>Home Banner Details :: View</h1></td></tr>
				
				<tr><td>
				
					<h1><strong>&nbsp; Active Banners</strong></h1>
					<p class="text">
						<em>&nbsp; NOTE:
						<br />&nbsp; The order of dispaly below is the dispaly order at home page.</em>
					<p>
					
				<tr><td>
				<tr><td>
				
					<table width="100%" cellpadding="0" cellspacing="2" style="">
					
						<tr bgcolor="#cccccc" height="35">
							<td width="34%" align="center" valign="middle" class="head">Thumbnail</td>
							<td align="center" valign="middle" class="head">File Name</td>
							<td width="30%" align="center" valign="middle" class="head">Sort /<br />Remove from active display</td>
						</tr>
						
						<?php
							/*-records of active banners-*/
							$records = get_where('home_banners','is_published','1');
							
							$i = 0;
							if ($records )
							{
								while ($rows = mysql_fetch_array( $records ))
								{
									/*-sort and remove buttons-*/
									if ($i == 0)
									{
										$move_down = '[ <a href="home_banners.php?action=movedown&id='.$rows['banner_id'].'">Move Down</a> ]<br />';
										$move = $move_down;
									}
									if ($i == 1)
									{
										$move_up = '[ <a href="home_banners.php?action=moveup&id='.$rows['banner_id'].'">Move Up</a> ]<br />';
										$move = $move_up;
									}
									$remove = '[ <a href="home_banners.php?action=remove&id='.$rows['banner_id'].'">Remove</a> ]';
									
									$img = '<img src="../images/banners/'.$rows['banner_image'].'" alt="No image available." height="90" />';
									
									/*-html output-*/
									echo '<tr style="height:40px;">';
									echo '<td align="center" valign="middle" class="text">'.$img.'</td>';
									echo '<td align="center" valign="middle" class="text">'.$rows['banner_image'].'</td>';
									echo '<td align="center" valign="middle" class="text">'.$move.$remove.'</td>';
									echo '</tr>';
									
									$i++;
								}
							}
							while ($i < 2)
							{
								/*-html output-*/
								echo '<tr style="height:40px;">';
								echo '<td align="center" valign="middle" class="text">No banners displayed</td>';
								echo '<td align="center" valign="middle" class="text"></td>';
								echo '<td align="center" valign="middle" class="text"></td>';
								echo '</tr>';
								$i++;
							} ?>
						
						<tr bgcolor=cccccc valign="middle" height="10"><td align=center colspan=3></td></tr>
						<tr><td colspan="3" align="center" class="text">
							<?php
							if ($notice)
							{
								/*-html output-*/
								echo '<table style="outline:1px solid #F69679;margin: 10px 0 10px;padding: 10px 0;width: 60%;font-size:bold;color:red;text-align: center;"><tr><td>';
									echo '<p>'.$notice.'</p>';
								echo '</td></tr></table>';
							} ?>
						</td></tr>
					
					</table>

				<tr><td>
				<tr><td>
				
					<h1><strong>&nbsp; All Banners On Record</strong><span style="float: right;"><a href="home_banners.php?action=add">Add Banner</a> &nbsp;</span></h1>
					<p class="text">
						<em>&nbsp; NOTE:
						<br />&nbsp; If selected, first 2 rows always displays active banners according to secquece.
						<br />&nbsp; Records are sorted from most recent to past.</em>
					<p>
					
				<tr><td>
				<tr><td>
				
					<table width="100%" cellpadding="0" cellspacing="2">
					
						<tr bgcolor="#cccccc" height="35">
							<td width="34%" align="center" valign="middle" class="head">Thumbnail</td>
							<td align="center" valign="middle" class="head">File Name</td>
							<td width="10%" align="center" valign="middle" class="head">Sequence</td>
							<td width="10%" align="center" valign="middle" class="head">Published</td>
							<td width="10%" align="center" valign="middle" class="head">Click to<br />Publish</td>
						</tr>
						
						<?php
							/*-records of banners-*/
							$records = get_where('home_banners','all','');
							
							/*-publish button mode-*/
							$ispub = '<a href="javascript:alert(\'This banner is already dispalyed.\')"><img src="../images/addtoproject.jpg" alt="Publish" height="12" /></a>';
							$pubfull = '<a href="javascript:alert(\'Dispaly is full.\nRemove a published banner first.\')"><img src="../images/addtoproject.jpg" alt="Publish" height="12" /></a>';
							
							if ($records)
							{
								while ($rows = mysql_fetch_array( $records ))
								{
									if ($rows['is_published'] == 1) $pub = $ispub;
									else if ($ispubfull == 2) $pub = $pubfull;
									else $pub = '<a href="home_banners.php?action=publish&id='.$rows['banner_id'].'"><img src="../images/addtoproject.jpg" alt="Publish" height="12" /></a>';
									
									$img = '<img src="../images/banners/'.$rows['banner_image'].'" alt="No image available." height="90" />';
									
									/*-html output-*/
									echo '<tr style="height:40px;">';
									echo '<td align="center" valign="middle" class="text">'.$img.'</td>';
									echo '<td align="center" valign="middle" class="text">'.$rows['banner_image'].'</td>';
									echo '<td align="center" valign="middle" class="text">'.$rows['sequence'].'</td>';
									echo '<td align="center" valign="middle" class="text">'.$rows['is_published'].'</td>';
									echo '<td align="center" valign="middle" class="text">'.$pub.'</td>';
									echo '</tr>';
								}
							}
								/*-html output-*/
								echo '<tr style="height:40px;">';
								echo '<td align="center" valign="middle" class="text" colspan="5" height="50">- End of record (or no record at all) -</td>';
								echo '<td align="center" valign="middle" class="text"></td>';
								echo '<td align="center" valign="middle" class="text"></td>';
								echo '<td align="center" valign="middle" class="text"></td>';
								echo '<td align="center" valign="middle" class="text"></td>';
								echo '</tr>';
								
							 ?>
						
						<tr bgcolor=cccccc valign="middle" height="10"><td align=center colspan=5></td></tr>
					
					</table>
					
				<tr><td>
				<tr><td>
				
					<table style="min-width: 600px;"><tr><td></td></tr></table>
					
				<tr><td>
				<?php
			} ?>
		</table>
	</td></tr>
	</table>

<?php	
	include 'footer.php';

/* End of file - home_banners.php */
/* Location: ./admin/home_banners.php */