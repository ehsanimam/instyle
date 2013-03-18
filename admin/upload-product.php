<?php
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php"); 
	include 'top.php'; 
	
	if (isset($_GET['msg']) && $_GET['msg'] == 1)
	{
		$msg = "Product has been successfully added";
	}
	
	if (isset($_GET['msg']) && $_GET['msg'] == 2)
	{
		$msg = "Entered style number is already existing!";
	}
	
	if (empty($_POST['cmd_cat_submit']) == false)
	{
		if ($_FILES["csv_"]["error"] > 0)
		{
			echo "File Upload Error Code: " . $_FILES["csv_"]["error"] . "<br />";
		}
		$strFile1 = strtolower($_FILES["csv_"]["name"]);
		$strTempFile1 = $_FILES["csv_"]["tmp_name"];	
		move_uploaded_file($strTempFile1,"csv/".$strFile1);
		
		// make the csv downloadable by creating a php equivalent filename with the following contents
		$handle = fopen('csv/'.substr($strFile1,0,-4).'.php','wb');
		fwrite($handle,
"<?php
header('Content-disposition: attachment; filename=".$strFile1."');
header('Content-type: text/plain');
readfile('".$strFile1."');
?>");
		fclose($handle);
		
		echo "<script>window.location.href='product_process.php?cat_id=".$_POST['cat_id']."&des_id=".$_POST['des_id']."&subcat_id=".$_POST['subcat_id']."&file=".$strFile1."'</script>";
	}
	
	/*
	| ---------------------------------------------------------------------------------------
	| Filename of CSV to be uploaded;
	| Will only execute when at the upload screen already when subcat has been selected
	*/
	$select2 = "SELECT * FROM `designer` WHERE des_id = '".@$_GET['des_id']."'";
	$result2 = mysql_query($select2);
	$row2 = mysql_fetch_array($result2);
	$select1 = "SELECT * FROM `tblsubcat` WHERE subcat_id = '".@$_GET['subcat_id']."'";
	$result1 = mysql_query($select1);
	$row1 = mysql_fetch_array($result1);
	
	$filename = 'product_master_template_'.$row2['folder'].'_'.$row1['folder'].'.csv';
?>

	<script>
		function submit_form()
		{
			document.prod_frm.method="post";
			document.prod_frm.action="<?php echo $_SERVER['PHP_SELF'];?>";
			document.prod_frm.submit();
		}

		function _check()
		{
			var file_=window.document.frm.csv_.value;
			if (file_ != "")
			{
				var ext=file_.substr(file_.lastIndexOf(".")).toLowerCase();		
				if (ext == '.csv')
				{
					if (file_ == "<?php echo $filename; ?>")
					{
						return true
					}
					else
					{
						alert(" Please upload the correct filename ! ");
						return false;
					}
				}
				else
				{
					alert(" Please upload only .CSV file ! ");			
					return false;
				}
			}
			else
			{
				alert(' Upload path should not empty ! ');		
				return false;
			}
		}	
	</script>
	
	<link href="style.css" rel="stylesheet" type="text/css">

	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
		<tr><td height="620" class="tab" valign="top" align="center">
		
			<br><br><br><br>
		
			<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
				<tr><td align="left">
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
								<?php echo $msg;?>
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
											<td valign="top"><a href="upload-product.php?cat_id=<?php echo $row['cat_id']; ?>" class="pagelinks"><?php echo $row['cat_name']; ?></a></td>
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
					| Select Designer
					*/
					elseif ( ! isset($_REQUEST['des_id']))
					{ ?>
					
						<table width=100% align=center cellspacing=2 cellpadding=2 >
							<!--DWLayoutTable-->
							<tr bgcolor=cccccc><td width="609" height="29" align=center><h1>Select Designer To Upload Products With</h1></td></tr>
							<tr><td align=center class="error">
								<?php echo $msg;?>
							</td></tr>
							<tr><td height="20"></td></tr> <!--added as spcer-->
								<?php 
								/*
								| -----------------------------------------------------------------------------------------
								| Query for Designers but get cat_id from tblcat first
								*/
								$select = "SELECT * FROM `designer` WHERE catid = '".$_GET['cat_id']."' ORDER BY designer ASC";
								$result = mysql_query($select);
								
								while ($row = mysql_fetch_array($result))
								{ ?>
									<tr align=center>
										<td valign="top"><a href="upload-product.php?cat_id=<?php echo $_GET['cat_id']; ?>&des_id=<?php echo $row['des_id']; ?>" class="pagelinks"><?php echo $row['designer']; ?></a></td>
									</tr>
								<? }?>
							<tr><td height="20"></td></tr> <!--added as spcer-->
						</table>
						<?php
					}
					/*
					| -----------------------------------------------------------------------------------------
					| Select Subcategory
					*/
					elseif ( ! isset($_REQUEST['subcat_id']))
					{
						$select2 = "SELECT designer FROM `designer` WHERE des_id = '".$_GET['des_id']."'";
						$result2 = mysql_query($select2);
						$row2 = mysql_fetch_array($result2);
						?>
					
						<table width=100% align=center cellspacing=2 cellpadding=2 >
							<!--DWLayoutTable-->
							<tr bgcolor=cccccc><td width="609" height="29" align=center><h1>Select Product Category To Upload For "<span style="color:red;"><?php echo strtoupper($row2['designer']); ?></span>"</h1></td></tr>
							<tr><td align=center class="error">
								<?php echo $msg;?>
							</td></tr>
							<tr><td height="20"></td></tr> <!--added as spcer-->
								<?php 
								/*
								| -----------------------------------------------------------------------------------------
								| Query for product categories given the desinger
								*/
								$select1 = "SELECT * FROM `designer` WHERE des_id = '".$_GET['des_id']."'";
								$result1 = mysql_query($select1);
								$row1 = mysql_fetch_array($result1);
									$exp_subs = explode(',',substr($row1['subcats'],0,-1));
									$where = '';
									while ($sub = current($exp_subs))
									{
										$where .= 'subcat_id LIKE \'%'.$sub.'%\' OR ';
										next($exp_subs);
									}
									$where = substr($where,0,-4);
								$select = "SELECT * FROM tblsubcat WHERE ".$where." AND view_status = 'Y' ORDER BY subcat_name";
								$result = mysql_query($select);
								
								while($row = mysql_fetch_array($result))
								{ ?>
									<tr align=center>
										<td valign="top"><a href="upload-product.php?cat_id=<?php echo $_GET['cat_id']; ?>&des_id=<?php echo $_GET['des_id']; ?>&subcat_id=<?php echo $row['subcat_id']; ?>" class="pagelinks"><?php echo $row['subcat_name']; ?></a></td>
									</tr>
								<? }?>
							<tr><td height="20"></td></tr> <!--added as spcer-->
						</table>
						<?php
					}
					/*
					| -----------------------------------------------------------------------------------------
					| Upload CSV
					*/
					else
					{ ?>
					
						<!--bof form=======================================================================-->
						<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?act=add" enctype="MULTIPART/FORM-data" onsubmit="return  _check();">
						<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
							<tr><td align="left">
							
								<table width=100% align=center cellspacing=2 cellpadding=2>
									<!--DWLayoutTable-->
									<tr bgcolor=cccccc><td align=center colspan=2>
										<h1>UPLOAD PRODUCT via CSV for "<?php echo strtoupper($row2['designer']).' - '.strtoupper(trim($row1['subcat_name'])); ?>"</h1>
									</td></tr>
									<tr><td align=center colspan=2 class="error">
										<?php echo $msg;?>
									</td></tr>
									<tr>
										<td width="310" class="text" align="right">Upload CSV: </td>
										<td width="470"><input type="file" name="csv_" id="csv_"  ></td>							
									</tr>
									<tr>
										<td colspan=2 align="center" style="color:red;font-size: 11px;">
											Please ensure CSV file is for "<b><?php echo strtoupper($row2['designer']).' - '.strtoupper(trim($row1['subcat_name'])); ?></b>" products only!
											<br />
											<?php
											// ----> $filename variable set prior to js scripts
											?>
											FILENAME: &nbsp; <?php echo $filename; ?>
										</td>
									</tr>
									<tr><td colspan=2 align=center>
									
										<input type="hidden" name="cat_id" value="<?php echo $_GET['cat_id']; ?>" />
										<input type="hidden" name="des_id" value="<?php echo $_GET['des_id']; ?>" />
										<input type="hidden" name="subcat_id" value="<?php echo $_GET['subcat_id']; ?>" />
										
										<input type="submit" name="cmd_cat_submit" class="button" value=" Upload ">
									</td></tr>
								</table>
								
							</td></tr>
						</table>
						</form>
						<!--eof form=======================================================================-->
		
						<?php
					} ?>
		
				</td></tr>
			</table>
	
		</td></tr>
	</table>
	
<?php $GLOBALS["message"]="";?>
<?php include 'footer.php'; ?>