<?php
	include("../common.php");
	/*
	| -----------------------------------------------------------------------------------------
	| This is file loaded and executed after upadting from display_product_new.php and will return
	| to the edit_new_par_product.php after the CSV update
	| After when the specific product number has been selected from the thumbs list and before
	| loading the product detail page edit_new_par_product.php.
	| -----------------------------------------------------------------------------------------
	*/
?>
<html>
<head>
	<title></title>
</head>
<body>
	<center><h1>Please wait... do not refresh this page.</h1></center>
</body>	
</html>

<?php
	$cat_id = $_GET['cat_id'];
	$des_id = $_GET['des_id'];
	$subcat_id = $_GET['subcat_id'];
	
	$cat_select3 = "SELECT * FROM tblcat WHERE cat_id = '".$cat_id."'";
	$cat_result3 = mysql_query($cat_select3) or die ('Else / Select Designer error: '.mysql_error());
	$cat_record3 = mysql_fetch_array($cat_result3);
	$cat_name = $cat_record3['cat_name'];
	
	/*
	| -----------------------------------------------------------------------------------------
	| Query designer & tblsubcat to get the proper word used on csv filename
	*/
	$des_select2 = "SELECT * FROM designer WHERE des_id = '".$des_id."'";
	$des_result2 = mysql_query($des_select2) or die ('Else / Select Designer error: '.mysql_error());
	$des_record2 = mysql_fetch_array($des_result2);
	$des_name = $des_record2['designer'];
	$file_part_des2 = str_replace(array('_','-'),array('','',),$des_record2['folder']);
	
	$subcat_select1 = "SELECT * FROM tblsubcat WHERE subcat_id = '".$subcat_id."'";
	$subcat_result1 = mysql_query($subcat_select1) or die ('Else / Select Subcat error: '.mysql_error());
	$subcat_record1 = mysql_fetch_array($subcat_result1);
	$subcat_name = $subcat_record1['subcat_name'];
	$file_part_subcat1 = str_replace(array('_','-'),array('','',),$subcat_record1['folder']);
	
	// get path to file asumming that file located in datafeed folder
	$csv_basename = "product_master_template_".$file_part_des2."_".$file_part_subcat1;
	$filename = $csv_basename.".csv";
	$path_to_file = "csv/".$filename;
	
	// count number of row data from csv
	if (file_exists($path_to_file))
	{
		$filecontents = file($path_to_file,FILE_IGNORE_NEW_LINES); // ----> file() returns an array of the file on a per line basis
		$csv_count = (sizeof($filecontents) - 1);
	}
	else
	{
		// ----> Create the file
		// set $content variable that is appendable staring with the headers
		// (note the page break '\n' at the end is important!)
		$content = "Product Name,Product Number,Category Name,SubCategory Name,Designer,Product Date,Catalogue Price,Retail Price,Wholesale Price,Product Description,Primary Image Color,Colors,Styles,Events,New Arrival,Clearance,Pre Order,Unpublish,Materials,Trends\n";

		$handle = fopen('csv/'.$filename,'wb');
		fwrite($handle,$content);
		fclose($handle);
		
		$filecontents = file($path_to_file,FILE_IGNORE_NEW_LINES); // ----> file() returns an array of the file on a per line basis
		$csv_count = (sizeof($filecontents) - 1);
		
		$handle = fopen('csv/'.$csv_basename.'.php','wb');
		fwrite($handle,
"<?php
header('Content-disposition: attachment; filename=".$filename."');
header('Content-type: text/plain');
readfile('".$filename."');
?>");
		fclose($handle);
	}
	
	/*
	| -----------------------------------------------------------------------------------------
	| Query tbl_product reference designer & subcat
	*/
	$des_prod_select = "SELECT * FROM tbl_product LEFT JOIN tblcolor ON tblcolor.color_code = tbl_product.primary_img_id WHERE designer = '".$des_id."' AND subcat_id = '".$subcat_id."' AND cat_id = '".$cat_id."'";
	$des_prod_result = mysql_query($des_prod_select) or die ('Select product error: '.mysql_error());
	$prod_count = mysql_num_rows($des_prod_result);
	
	//echo '<br />csv is '.$csv_count.'<br />db is '.$prod_count,'<br />';
	echo 'Consolidating CSV file and database...';
	
	if ($csv_count == $prod_count)
	{
		echo '(=)';
		// ----> Nothing to do. Proced to next page
		echo "<script>window.location.href='edit_new_product_designer.php?cat_id=".$cat_id."&des_id=".$des_id."&subcat_id=".$subcat_id."'</script>";
	}
	if ($csv_count > $prod_count && ! $_GET['updb'])
	{
		echo '(>)';
		// ----> temporarily divert to admin edit product detail
		echo "<script>window.location.href='edit_new_product_designer.php?cat_id=".$cat_id."&des_id=".$des_id."&subcat_id=".$subcat_id."'</script>";
		// ----> Upload CSV
		//echo "<script>window.location.href='product_process.php?cat_id=".$cat_id."&des_id=".$des_id."&subcat_id=".$subcat_id."&csv=1&file=".$filename."'</script>";
	}
	if ($csv_count < $prod_count OR $_GET['updb'] == '1')
	{
		echo '(<)';
		// ----> Update the CSV
		// set $content variable that is appendable staring with the headers
		// (note the page break '\n' at the end is important!)
		$content = "Product Name,Product Number,Category Name,SubCategory Name,Designer,Product Date,Catalogue Price,Retail Price,Wholesale Price,Product Description,Primary Image Color,Colors,Styles,Events,New Arrival,Clearance,Pre Order,Unpublish,Materials,Trends\n";

		// append $content with the data on a per row basis
		// (note the page break '\n' at the end is important!)
		while ($row = mysql_fetch_array($des_prod_result))
		{
			$pub_u = $row['view_status'] == 'N' ? 'Y' : '';
			$content .= "".$row['prod_name'].",".$row['prod_no'].",".$cat_name.",".$subcat_name.",".$des_name.",".$row['prod_date'].",".$row['catalogue_price'].",".$row['less_discount'].",".$row['wholesale_price'].",".$row['prod_desc'].",".$row['color_name'].",".$row['colors'].",".$row['styles'].",".$row['events'].",".$row['new_arrival'].",".$row['clearance'].",".$row['pre_order'].",".$pub_u.",".$row['materials'].",".$row['trends']."\n";
		}
		
		// write the file
		if (is_writable($path_to_file))
		{
			$file_handle = fopen($path_to_file,'wb');
			fwrite($file_handle,$content);
			fclose($file_handle);
		}
		else echo "File is not writable";
		
		// ----------------------------------
		// --> return code to list_products.php using uri string 'sel'
		// returns to the list_products.php pages as oppose to the old edit_new_product_designer.php
		// $sel is passed from list_products.php to edit_new_par_product.php to csv_check.php
		if (isset($_GET['sel']))
		{
			$_SESSION['des_id'] = $des_id;
			$_SESSION['cat_id'] = $cat_id;
			$_SESSION['subcat_id'] = $subcat_id;
			
			$sel_uri = isset($_GET['sel']) ? '?sel='.$_GET['sel'] : '';
			$p_uri =isset($_GET['p']) ? '&p='.$_GET['p'] : '';

			echo '
				<script>
					window.location.href = "list_products.php'.$sel_uri.$p_uri.'";
				</script>
			';
		}
		else
		{
			echo "<script>window.location.href='edit_new_product_designer.php?cat_id=".$cat_id."&des_id=".$des_id."&subcat_id=".$subcat_id."'</script>";
		}
	}
	/*
	*/
