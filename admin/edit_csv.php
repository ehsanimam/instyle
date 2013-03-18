<?php
	include("../common.php");
	
	/*
	| -----------------------------------------------------------------------------------------
	| If mode = 'update', process the update CSV request
	*/
	if (isset($_GET['mode']) && $_GET['mode'] === 'update')
	{
			/*
			| -----------------------------------------------------------------------------------------
			| Query designer & tblsubcat to get the proper word used on csv filename
			*/
			$des_select2 = "SELECT * FROM designer WHERE des_id = '".$_GET['des_id']."'";
			$des_result2 = mysql_query($des_select2) or dei ('Else / Select Designer error: '.mysql_error());
			$des_record2 = mysql_fetch_array($des_result2);
			$file_part_des2 = str_replace(array('_','-'),array('','',),$des_record2['folder']);
			
			$subcat_select1 = "SELECT * FROM tblsubcat WHERE subcat_id = '".$_GET['subcat_id']."'";
			$subcat_result1 = mysql_query($subcat_select1) or dei ('Else / Select Subcat error: '.mysql_error());
			$subcat_record1 = mysql_fetch_array($subcat_result1);
			$file_part_subcat1 = str_replace(array('_','-'),array('','',),$subcat_record1['folder']);
			
		// get path to file asumming that file located in datafeed folder
		$path_to_file = "csv/product_master_template_".$file_part_des2."_".$file_part_subcat1.".csv";
		
		// set $content variable that is appendable staring with the headers
		// (note the page break '\n' at the end is important!)
		$content = "Product Name,Product Number,Category Name,SubCategory Name,Designer,Product Date,Catalogue Price,Retail Price,Wholesale Price,Product Description,Primary Image Color,Colors,Styles,Events,New Arrival,Clearance,Pre Order,Unpublish,Materials,Trends\n";

		// append $content with the data on a per row basis
		// (note the page break '\n' at the end is important!)
		for ($ii = 1; $ii <= $_POST['last_i']; $ii++)
		{
			$content .= "".$_POST['index_'.$ii.'_0'].",".$_POST['index_'.$ii.'_1'].",".$_POST['index_'.$ii.'_2'].",".$_POST['index_'.$ii.'_3'].",".$_POST['index_'.$ii.'_4'].",".$_POST['index_'.$ii.'_5'].",".$_POST['index_'.$ii.'_6'].",".$_POST['index_'.$ii.'_7'].",".$_POST['index_'.$ii.'_8'].",".$_POST['index_'.$ii.'_9'].",".$_POST['index_'.$ii.'_10'].",".$_POST['index_'.$ii.'_11'].",".$_POST['index_'.$ii.'_12'].",".$_POST['index_'.$ii.'_13'].",".$_POST['index_'.$ii.'_14'].",".$_POST['index_'.$ii.'_15'].",".$_POST['index_'.$ii.'_16'].",".$_POST['index_'.$ii.'_17'].",".$_POST['index_'.$ii.'_18'].",".$_POST['index_'.$ii.'_19']."\n";
		}
		
		// write the file
		if (is_writable($path_to_file))
		{
			$file_handle = fopen($path_to_file,'wb');
			fwrite($file_handle,$content);
			fclose($file_handle);
		}
		else echo "File is not writable";
		
		$filename = str_replace('csv/','',$path_to_file);
		
		echo "
			<script>
				window.location.href='product_process.php?cat_id=".$_GET['cat_id']."&des_id=".$_GET['des_id']."&subcat_id=".$_GET['subcat_id']."&upcsv=1&file=".$filename."'
			</script>
		";
		
		// redirect user
		//header("Location: ".SITE_URL."admin/edit_csv.php?dmsg=1");
	}

	// just a success message to display after updating of CSV file
	if (isset($_GET['dmsg']) && $_GET['dmsg'] == '1')
	{
		$err = '<br />CSV file has been updated. <h1 style="color:blue;">Select another designer.</h1><br />';
	}
	
	// Header
	include 'top.php';
?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td class="tab" align="center" valign="middle" style="padding: 10px 2px;">

	<table width=95% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
    <tr><td align=center class="error"><?php echo isset($err) ? $err : ''; ?></td></tr>
	<tr><td align="center">
	
	<?php
	/*
	| -----------------------------------------------------------------------------------------
	| Select Category
	*/
	if ( ! isset($_REQUEST['cat_id']))
	{ ?>
		<table width=100% align=center cellspacing=2 cellpadding=2 >
			<!--DWLayoutTable-->
			<tr bgcolor=cccccc><td width="609" height="29" align=center><h1>Select Category of Products</h1></td></tr>
			<tr><td align=center class="error">
				<?php echo isset($err) ? $err : ''; ?>
			</td></tr>
			<tr><td height="20"></td></tr> <!--added as spcer-->
				<?php 
				/*
				| -----------------------------------------------------------------------------------------
				| Query for Designers
				*/
				$select = "SELECT * FROM `tblcat` ORDER BY ordering ASC";
				$result = mysql_query($select);
				
				while($row = mysql_fetch_array($result))
				{
					if ($row['cat_name'] != 'New Arrivals' && $row['cat_name'] != 'Clearance')
					{ ?>
						<tr align=center>
							<td valign="top"><a href="edit_csv.php?cat_id=<?php echo $row['cat_id']; ?>" class="pagelinks"><?php echo $row['cat_name']; ?></a></td>
						</tr>
						<?php
					}
				} ?>
			<tr><td height="20"></td></tr> <!--added as spcer-->
		</table>
		<?php
	}
	/*
	| -----------------------------------------------------------------------------------------
	| Initial state for edit_csv page. - User has to select the desginer
	*/
	elseif ( ! isset($_REQUEST['des_id']))
	{ ?>
				
		<table width=100% align=center cellspacing=2 cellpadding=2 >
			<!--DWLayoutTable-->
			<tr bgcolor=cccccc><td width="609" height="29" align=center><h1>Select Desinger To Edit CSV</h1></td></tr>
			<tr><td align=center class="error">
				<?php echo isset($err) ? $err : '';?>
			</td></tr>
			<tr><td height="20"></td></tr> <!--added as spcer-->
				<?php 
				/*
				| -----------------------------------------------------------------------------------------
				| Query for Designers
				*/
				$select = "SELECT * FROM `designer` ORDER BY designer";
				$result = mysql_query($select);
				
				while($row = mysql_fetch_array($result))
					{ ?>
						<tr align=center>
							<td valign="top"><a href="edit_csv.php?cat_id=<?php echo $_GET['cat_id']; ?>&des_id=<?php echo $row['des_id']; ?>" class="pagelinks"><?php echo $row['designer']; ?></a></td>
						</tr>
						<?php
				} ?>
			<tr><td height="20"></td></tr> <!--added as spcer-->
		</table>
		<?php
	}
	/*
	| -----------------------------------------------------------------------------------------
	| 2nd state for edit_csv page. - User has to select the CSV file to edit or download (per category basis)
	*/
	else if ( ! isset($_GET['subcat_id']))
	{
		/*
		| -----------------------------------------------------------------------------------------
		| Query designer
		*/
		$des_select = "SELECT * FROM designer WHERE des_id = '".$_GET['des_id']."'";
		$des_result = mysql_query($des_select) or die('If subcat error: '.mysql_error());
		$des_row = mysql_fetch_array($des_result);
		
		$file_part_des1 = str_replace(array('_','-'),array('',''),$des_row['folder']);
		?>
		<table width=100% align=center cellspacing=2 cellpadding=2 >
		  <!--DWLayoutTable-->
			<tr bgcolor=cccccc><td width="609" colspan="2" height="29" align=center><h1>Select CSV Subcategory under "<span style="color:red"><?php echo $des_row['designer']; ?></span>"</h1></td></tr>
			<tr bgcolor=cccccc>
				<td height="29" align=center><h1>Edit CSV</h1></td>
				<td height="29" align=center><h1>Download CSV</h1></td>
			</tr>
			<tr><td height="20" colspan="2"></td></tr> <!--added as spacer-->
				<?php 
				/*
				| -----------------------------------------------------------------------------------------
				| Query sub categories under the designer considerin posiblity of two categories in one designer
				*/
				$exp_subs = explode(',',substr($des_row['subcats'],0,-1));
				$where = '';
				while ($sub = current($exp_subs))
				{
					$where .= 'subcat_id LIKE \'%'.$sub.'%\' OR ';
					next($exp_subs);
				}
				if ($where != '')
				{
					$where = substr($where,0,-4);
					$where = 'WHERE '.$where.' AND';
					
					$select1 = "SELECT * FROM tblsubcat ".$where." view_status = 'Y' ORDER BY subcat_name";
					$result1 = mysql_query($select1) or die('If subcat query error: '.mysql_error());
				
					while($row1 = mysql_fetch_array($result1))
					{
						$csv_filename = 'product_master_template_'.$file_part_des1.'_'.str_replace(array('_','-'),array('',''),$row1['folder']);
						if ( ! file_exists('csv/'.$csv_filename.'.csv'))
						{
							$no_file = '(No CSV file exists)';
						}
						else $no_file = '';
						$href_link = 'edit_csv.php?cat_id='.$_GET['cat_id'].'&des_id='.$_GET['des_id'].'&subcat_id='.$row1['subcat_id'];
						?>
						<tr align=center>
							<td valign="top" class="text" align="left" style="padding-left:50px;">Edit CSV for &nbsp; <a href="<?php echo $href_link; ?>" class="pagelinks"><?php echo $row1['subcat_name']; ?></a> &nbsp; <span style="font-size:9px;"><?php echo $no_file; ?></span></td>
							<td valign="top" class="text" align="left" style="padding-left:50px;">Download CSV of &nbsp; <a href="csv/<?php echo $csv_filename; ?>.php" class="pagelinks"><?php echo $row1['subcat_name']; ?></a> &nbsp; <span style="font-size:9px;"><?php echo $no_file; ?></span></td>
						</tr>
						<?php
					}
				}
				else
				{ ?>
					<tr><td class="text" colspan="2" align="center">There are currenly no subcats associated with the designer.</td></tr> <!--added as spacer-->
					<?php
				} ?>
			<tr><td height="20"></td></tr> <!--added as spcer-->
		</table>
		<?php
	}
	/*
	| -----------------------------------------------------------------------------------------
	| 3rd state for edit_csv page. - Edit page of the selected CSV file with option to download it
	*/
	else
	{ ?>
		
		<!--bof form============================================================================-->
		<form name="form_edit_csv" action="edit_csv.php?cat_id=<?php echo $_GET['cat_id']; ?>&des_id=<?php echo $_GET['des_id']; ?>&subcat_id=<?php echo $_GET['subcat_id']; ?>&mode=update" method="POST">
		
			<?php
			/*
			| -----------------------------------------------------------------------------------------
			| Query designer & tblsubcat to get the proper word used on csv filename
			*/
			$des_select1 = "SELECT * FROM designer WHERE des_id = '".$_GET['des_id']."'";
			$des_result1 = mysql_query($des_select1) or die ('Else / Select Designer error: '.mysql_error());
			$des_record1 = mysql_fetch_array($des_result1);
			$file_part_des3 = $des_record1['folder'];
			
			$subcat_select3 = "SELECT * FROM tblsubcat WHERE subcat_id = '".$_GET['subcat_id']."'";
			$subcat_result3 = mysql_query($subcat_select3) or die ('Else / Select Subcat error: '.mysql_error());
			$subcat_record3 = mysql_fetch_array($subcat_result3);
			$file_part_subcat3 = $subcat_record3['folder'];
			
			// declare variable to count records
			$rowcount = 0;

			// get path to file asumming that file located in datafeed folder
			$csv_basename = "product_master_template_".$file_part_des3."_".$file_part_subcat3;
			$path_to_file = "csv/".$csv_basename.".csv";
			
			if (file_exists($path_to_file))
			{
				// create table with header and column names
				print('<table width=100% align=center cellspacing=1 cellpadding=0>');
				print('<tr bgcolor=cccccc><td colspan="20" align="center" style="vertical-align:middle; height:30px;"><h1>CSV File Edit For '.$des_record1['designer'].' - '.$subcat_record3['subcat_name'].'</h1></td></tr>');
				print('<tr bgcolor=cccccc>
						<td style="vertical-align:middle;"><h1>Prod Name</h1></td>
						<td style="vertical-align:middle;"><h1>Prod No</h1></td>
						<td style="vertical-align:middle;"><h1>Category</h1></td>
						<td style="vertical-align:middle;"><h1>Subcat</h1></td>
						<td style="vertical-align:middle;"><h1>Designer</h1></td>
						<td style="vertical-align:middle;"><h1>Prod Date</h1></td>
						<td style="vertical-align:middle;"><h1>Catalog Price</h1></td>
						<td style="vertical-align:middle;"><h1>Retail Price</h1></td>
						<td style="vertical-align:middle;"><h1>Wholesale Price</h1></td>
						<td style="vertical-align:middle;"><h1>Prod Desc</h1></td>
						<td style="vertical-align:middle;"><h1>Primary Img Color</h1></td>
						<td style="vertical-align:middle;"><h1>Colors</h1></td>
						<td style="vertical-align:middle;"><h1>Styles</h1></td>
						<td style="vertical-align:middle;"><h1>Events</h1></td>
						<td style="vertical-align:middle;"><h1>New Arrivals</h1></td>
						<td style="vertical-align:middle;"><h1>Clearance</h1></td>
						<td style="vertical-align:middle;"><h1>Pre Order</h1></td>
						<td style="vertical-align:middle;"><h1>Unpublish</h1></td>
						<td style="vertical-align:middle;"><h1>Materials</h1></td>
						<td style="vertical-align:middle;"><h1>Trends</h1></td>
						</tr>');

				// open file for reading "r"
				$filecontents = file($path_to_file,FILE_IGNORE_NEW_LINES); // ----> file() returns an array of the file on a per line basis
				
				//read file line by line.
				for ($i = 0; $i < sizeof($filecontents); $i++) // ----> sizeof() is an alias of count()
				{
					if ($i == 0)
					{
						$fields = $filecontents[0];
					}
					else
					{
						$record = explode(",", $filecontents[$i]); // ----> exploding each comma separated line
					
						//read field values in variable

						$prod_name = trim($record[0]);
						$prod_no = trim($record[1]);
						$cat = trim($record[2]);
						$subcat = trim($record[3]);
						$designer = trim($record[4]);
						$prod_date = trim($record[5]);
						$catalog_price = trim($record[6]);
						$retail_price = trim($record[7]);
						$wholesale_price = trim($record[8]);
						$prod_desc = trim($record[9]);
						$primary_img_color = trim($record[10]);
						$colors = trim($record[11]);
						$style = trim($record[12]);
						$events = trim($record[13]);
						$new_arrivals = trim($record[14]);
						$clearance = trim($record[15]);
						$pre_order = trim($record[16]);
						$unpublish = trim($record[17]);
						$materials = trim($record[18]);
						$trends = trim($record[19]);

						//skipped the first record since it has field headers only
						print('
						<tr>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_0" value="'.$prod_name.'" style="width:200px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_1" value="'.$prod_no.'" style="width:65px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_2" value="'.$cat.'" style="width:120px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_3" value="'.$subcat.'" style="width:120px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_4" value="'.$designer.'" style="width:120px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_5" value="'.$prod_date.'" style="width:70px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_6" value="'.$catalog_price.'" style="width:50px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_7" value="'.$retail_price.'" style="width:50px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_8" value="'.$wholesale_price.'" style="width:60px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_9" value="'.$prod_desc.'" style="width:200px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_10" value="'.$primary_img_color.'" style="width:100px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_11" value="'.$colors.'" style="width:150px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_12" value="'.$style.'" style="width:350px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_13" value="'.$events.'" style="width:65px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_14" value="'.$new_arrivals.'" style="width:65px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_15" value="'.$clearance.'" style="width:65px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_16" value="'.$pre_order.'" style="width:65px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_17" value="'.$unpublish.'" style="width:65px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_18" value="'.$materials.'" style="width:65px;"/></td>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_19" value="'.$trends.'" style="width:65px;"/></td>
						</tr>
						');
					}
				}
				print('</table>');
				?>
				<br />
				<input type="hidden" name="last_i" value="<?php echo (sizeof($filecontents) - 1); ?>" />
				<input type="submit" name="save_csv" value="Update CSV" /> &nbsp; &nbsp; <span class="text">OR</span> &nbsp; &nbsp; 
				<a href="csv/<?php echo $csv_basename; ?>.php"><span class="text">Download it here</span></a>
				<br /><br />
				<?php
			}
			else echo '<h1 style="color:red;">CSV file does not exist. Please load file first.</h1><h1>Please select another category instead.</h1><a href="edit_csv.php"><h1 style="color:blue;text-decoration:underline;">Select here</h1></a>';
			?>
		</form>
		<!--eof form============================================================================-->
		<?php
	} ?>
		
	</td></tr>
	</table>
	
</td></tr>
</table>
<? include 'footer.php';