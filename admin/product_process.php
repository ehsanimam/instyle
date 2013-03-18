<?php
 	include("../common.php");
	include("security.php");
?>
<html>
	<head>
		<title></title>
	</head>
<body>
	<center><h1>Please wait ... do not refresh this page.</h1></center>
</body>	
</html>
<?php
	$uri_cat_id = $_GET['cat_id'];
	$uri_des_id = $_GET['des_id'];
	$uri_subcat_id = $_GET['subcat_id'];

	$strFile1 = 'csv/'.str_replace('csv/','',$_GET['file']);
	$columnheadings = 0;
	$i=0;
	$filecontents = file($strFile1,FILE_IGNORE_NEW_LINES); // ----> file() returns an array of the file on a per line basis

	echo (sizeof($filecontents) - 1).' rows<br />';

	// for each row $i
	for ($i = $columnheadings; $i < sizeof($filecontents); $i++)
	{
		if ($i == 0) // ----> first row are headings. do nothing.
		{
			$fields = $filecontents[0];
			
			/*
			| --------------------------------------------------------------------------------------
			| This code here does the following:
			| Assign an associative $key to the CSV fields for easier association
			| Check for any possible errors on CSV heading 
			*/
			$fields = explode(',',$filecontents[0]);
			$column_name = array();
			while ($field_item = current($fields))
			{
				// allows to trim possible whitespaces on column headers
				$column_name[key($fields)] = trim($field_item);
				next($fields);
			}
			
			function is_empty($var, $allow_false = false, $allow_ws = false) {
				if (!isset($var) || is_null($var) || ($allow_ws == false && trim($var) == "" && !is_bool($var)) || ($allow_false === false && is_bool($var) && $var === false) || (is_array($var) && empty($var))) {   
					return true;
				} else {
					return false;
				}
			}
			
			$csv_key_prod_name = array_search('Product Name',$column_name);
				if (is_empty($csv_key_prod_name)) $field_empty_err = TRUE;
			$csv_key_prod_no = array_search('Product Number',$column_name);
				if (is_empty($csv_key_prod_no)) $field_empty_err = TRUE;
			$csv_key_cat_name = array_search('Category Name',$column_name);
				if (is_empty($csv_key_cat_name)) $field_empty_err = TRUE;
			$csv_key_subcat_name = array_search('SubCategory Name',$column_name);
				if (is_empty($csv_key_subcat_name)) $field_empty_err = TRUE;
			$csv_key_designer = array_search('Designer',$column_name);
				if (is_empty($csv_key_designer)) $field_empty_err = TRUE;
			$csv_key_prod_date = array_search('Product Date',$column_name);
				if (is_empty($csv_key_prod_date)) $field_empty_err = TRUE;
			$csv_key_catalog_price = array_search('Catalogue Price',$column_name);
				if (is_empty($csv_key_catalog_price)) $field_empty_err = TRUE;
			$csv_key_retail_price = array_search('Retail Price',$column_name);
				if (is_empty($csv_key_retail_price)) $field_empty_err = TRUE;
			$csv_key_wholesale_price = array_search('Wholesale Price',$column_name);
				if (is_empty($csv_key_wholesale_price)) $field_empty_err = TRUE;
			$csv_key_prod_desc = array_search('Product Description',$column_name);
				if (is_empty($csv_key_prod_desc)) $field_empty_err = TRUE;
			$csv_key_primary_img_color = array_search('Primary Image Color',$column_name);
				if (is_empty($csv_key_primary_img_color)) $field_empty_err = TRUE;
			$csv_key_colors = array_search('Colors',$column_name);
				if (is_empty($csv_key_colors)) $field_empty_err = TRUE;
			$csv_key_styles = array_search('Styles',$column_name);
				if (is_empty($csv_key_styles)) $field_empty_err = TRUE;
			$csv_key_events = array_search('Events',$column_name);
				if (is_empty($csv_key_events)) $field_empty_err = TRUE;
			$csv_key_new_arrival = array_search('New Arrival',$column_name);
				if (is_empty($csv_key_new_arrival)) $field_empty_err = TRUE;
			$csv_key_clearance = array_search('Clearance',$column_name);
				if (is_empty($csv_key_clearance)) $field_empty_err = TRUE;
			$csv_key_pre_order = array_search('Pre Order',$column_name);
				if (is_empty($csv_key_pre_order)) $field_empty_err = TRUE;
			$csv_key_unpublish = array_search('Unpublish',$column_name);
				if (is_empty($csv_key_unpublish)) $field_empty_err = TRUE;
			$csv_key_materials = array_search('Materials',$column_name);
				if (is_empty($csv_key_materials)) $field_empty_err = TRUE;
			$csv_key_trends = array_search('Trends',$column_name);
				if (is_empty($csv_key_trends)) $field_empty_err = TRUE;
			
			echo '<br />Product Name: '.$csv_key_prod_name;
			echo '<br />Product Number: '.$csv_key_prod_no;
			echo '<br />Category Name: '.$csv_key_cat_name;
			echo '<br />SubCategory Name: '.$csv_key_subcat_name;
			echo '<br />Designer: '.$csv_key_designer;
			echo '<br />Product Date: '.$csv_key_prod_date;
			echo '<br />Catalogue Price: '.$csv_key_catalog_price;
			echo '<br />Retail Price: '.$csv_key_retail_price;
			echo '<br />Wholesale Price: '.$csv_key_wholesale_price;
			echo '<br />Product Description: '.$csv_key_prod_desc;
			echo '<br />Primary Image Color: '.$csv_key_primary_img_color;
			echo '<br />Colors: '.$csv_key_colors;
			echo '<br />Styles: '.$csv_key_styles;
			echo '<br />Events: '.$csv_key_events;
			echo '<br />New Arrival: '.$csv_key_new_arrival;
			echo '<br />Clearance: '.$csv_key_clearance;
			echo '<br />Pre Order: '.$csv_key_pre_order;
			echo '<br />Unpublish: '.$csv_key_unpublish;
			echo '<br />Materials: '.$csv_key_materials;
			echo '<br />Trends: '.$csv_key_trends;
			
			$leave_page = FALSE;
			
			if (isset($field_empty_err))
			{
				unset($field_empty_err);
				echo '
					<script>
						alert("There is an error with one of your CSV column headings."+"\n"+"Please fix then upload again.");
					</script>'
				;
				$leave_page = TRUE;
			}
			
			if ($leave_page)
			{
				echo '
					<script>
						window.location.href="upload-product.php?cat_id='.$_GET['cat_id'].'&des_id='.$_GET['des_id'].'&subcat_id='.$_GET['subcat_id'].'"
					</script>
				';
			}
			
			?>
			<!--
			<script>
				alert('Continue...');
			</script>
			-->
			<?php
		}
		else
		{
			/*
			| ----------------------------------------------------------------------------------
			| These first four queries define the cat, subcat, designer, and primay color code
			*/
		   	$data = explode(",", $filecontents[$i]); // ----> exploding each comma separated line
			// ----> I suppose we know that cat_id is in 3rd colum of csv ergo index number [2]
			// ----> trim() is removing any whitespaces in front and at end
			
			// get cat_id
			$cat = "select cat_id from tblcat where cat_name='".trim($data[2])."'";
			$catqry = mysql_query($cat) or die('Cat error: '.mysql_error());
			$cat_row = mysql_fetch_array($catqry);
			$cat_id = $cat_row['cat_id']; 
			
			// get subcat_id
			$subcat = "select subcat_id, subcat_name, folder from tblsubcat where subcat_name='".trim($data[3])."' and cat_id='".$cat_id."'";
			$subcatqry = mysql_query($subcat) or die('Subcat error: '.mysql_error());
			$subcat_row = mysql_fetch_array($subcatqry);
			$subcat_id = $subcat_row['subcat_id'];
			$subcat_name = $subcat_row['folder'];
			
			// get designer_id
			$designer = "select des_id from designer where designer = '".trim($data[4])."' and catid='$cat_id'";
			$designerqry = mysql_query($designer) or die('Desinger error: '.mysql_error());
			$designer_row = mysql_fetch_array($designerqry);
			$designer_id = $designer_row['des_id'];
			
			// get color code for primary_img_id
			$primary_code = "select * from tblcolor where color_name='".trim($data[10])."'";
			$primary_code_qry = @mysql_query($primary_code) or die('Color error: '.mysql_error());
			$primary_rec = @mysql_fetch_array($primary_code_qry);
			$primary_img_code = $primary_rec['color_code'];
			
			// process styles and make style with string length of 3 with '1' at the end
			$array_styles = explode('-',trim($data[12]));
			while ($s_item = current($array_styles))
			{
				if (strlen($s_item) == 3) $s_item = $s_item.'1';
				$styles_ary[key($array_styles)] = $s_item;
				next($array_styles);
			}
			if ($styles_ary) $styles = implode('-',$styles_ary);
			else $styles = '';
	
			/*
			| ------------------------------------------------------------------------------
			| This code queries for prod_no and prod_color
			| This is only for one product one color per row
			|
			$sqlp1 = "select * from tbl_product where prod_no='".trim($data[1])."' and prod_color='".$primary_img_code."'";
			$qryp1 = mysql_query($sqlp1) or die('Table product error: '.mysql_error());
			$num_rows1 = mysql_num_rows($qryp1);
			*/

			/*
			| ------------------------------------------------------------------------------
			| This code queries for prod_no only
			| This is for one product multiple color per row
			|
			*/
			$sqlp1 = "select * from tbl_product where prod_no='".$data[1]."'";
			$qryp1 = mysql_query($sqlp1) or die('Table product error: '.mysql_error());
			$num_rows1 = mysql_num_rows($qryp1);
			
			// set empty prices to zero
			$data[6] = trim($data[6]) == '' ? 0 : trim($data[6]);
			$data[7] = trim($data[7]) == '' ? 0 : trim($data[7]);
			$data[8] = trim($data[8]) == '' ? 0 : trim($data[8]);
			
			if ($num_rows1 > 0)
			{
				//echo 'Updating-';
				$mode = 'Updating';
				
				// Set publish mode
				if (trim($data[17]) == 'y' OR trim($data[17]) == 'Y')
					$pub_u = 'N';
				else
					$pub_u = 'Y';
				
				$prod_date = date("Y-m-d",strtotime($data[5]));
				$insert_query = "UPDATE tbl_product SET 
										prod_name		= '".trim($data[0])."', 
										prod_no			= '".trim($data[1])."',
										
										view_status		= '".$pub_u."', 
										hide_sketch		= 'N', 
										cat_id			= '".(int)$cat_id."', 
										subcat_id		= '".(int)$subcat_id."',
										
										designer		= '".(int)$designer_id."',
										prod_date		= '".$prod_date."', 
										prod_desc		= '".trim($data[9])."', 
										
										catalogue_price	= '".trim($data[6])."', 
										less_discount	= '".trim($data[7])."', 
										wholesale_price	= '".(float)trim($data[8])."', 
										
										primary_img_id	= '".$primary_img_code."',
										colors			= '".trim($data[11])."',
										
										events			= '".trim($data[13])."',
										styles			= '".$styles."',
										new_arrival		= '".trim($data[14])."',
										clearance		= '".trim($data[15])."',
										pre_order		= '".trim($data[16])."'
									WHERE prod_no='".$data[1]."'";
			}
			else
			{
				//echo 'Inserting-';
				$mode = 'Inserting';
				
				// Set publish mode
				if (trim($data[17]) == 'y' OR trim($data[17]) == 'Y')
					$pub_i = 'N';
				else
					$pub_i = 'Y';
				
				$prod_date = date("Y-m-d",strtotime($data[5]));
				$insert_query = "INSERT INTO tbl_product 
									(
									 prod_name, 
									 prod_no, 
									 
									 view_status, 
									 hide_sketch, 
									 cat_id, 
									 subcat_id,
									 
									 designer,
									 prod_date, 
									 prod_desc, 
									 
									 catalogue_price, 
									 less_discount, 
									 wholesale_price, 
									 primary_img_id,
									 colors,
									 
									 events,
									 styles,
									 new_arrival,
									 clearance,
									 pre_order
									) 
								 VALUES ('".trim($data[0])."',
										'".trim($data[1])."',
										
										'".$pub_i."',
										'N',
										'".(int)$cat_id."',
										'".(int)$subcat_id."',
										
										'".(int)$designer_id."',
										'".$prod_date."',
										'".trim($data[9])."',			/* description */
										
										'".trim($data[6])."',			/* catalogue price */
										'".trim($data[7])."',			/* less discount */
										'".trim($data[8])."',			/* wholesale price */
										'".$primary_img_code."',
										'".trim($data[11])."',
										
										'".trim($data[13])."',
										'".$styles."',
								 		'".trim($data[14])."',
										'".trim($data[15])."',
								 		'".trim($data[16])."'
										)";
				 
			}
			mysql_query($insert_query) or die($mode.' error:'.mysql_error());
			
			/*
			| ------------------------------------------------------------------------------
			| This code is to assign a default stock to products temporarily for new items
			|
			*/
			
			if ($mode == 'Updating')
			{
				$explode_u = explode('-',trim($data[11]));
				foreach ($explode_u as $color_u)
				{
					$sqlstock = "select * from tbl_stock where color_name='".trim($color_u)."' and prod_no='".trim($data[1])."'";
					$qrypstock = mysql_query($sqlstock) or die('Table product error: '.mysql_error());
					$num_stock = mysql_num_rows($qrypstock);
					
					if($num_stock > 0)
					{
					$qry_u = mysql_query("
						UPDATE tbl_stock
						SET 
							size_0 = '30', size_2 = '30', size_4 = '30', size_6 = '30', 
							size_8 = '30', size_10 = '30', size_12 = '30', size_14 = '30', size_16 = '30',
							size_xs = '30', size_s = '30', size_m = '30', size_l = '30', size_xl = '30', size_fs = '30',
							size_j0 = '30', size_j0_1 = '30', size_j0_2 = '30', size_j0_3 = '30',
							size_j1 = '30', size_j1_1 = '30', size_j1_2 = '30', size_j1_3 = '30', 
							size_j2 = '30', size_j2_1 = '30', size_j2_2 = '30', size_j2_3 = '30', 
							size_j3 = '30', size_j3_1 = '30', size_j3_2 = '30', size_j3_3 = '30', 
							size_j4 = '30', size_j4_1 = '30', size_j4_2 = '30', size_j4_3 = '30', 
							size_j5 = '30', size_j5_1 = '30', size_j5_2 = '30', size_j5_3 = '30', 
							size_j6 = '30', size_j6_1 = '30', size_j6_2 = '30', size_j6_3 = '30', 
							size_j7 = '30', size_j7_1 = '30', size_j7_2 = '30', size_j7_3 = '30', 
							size_j8 = '30', size_j8_1 = '30', size_j8_2 = '30', size_j8_3 = '30', 
							size_j9 = '30', size_j9_1 = '30', size_j9_2 = '30', size_j9_3 = '30'
						WHERE 
							prod_no = '".trim($data[1])."'
						AND
							color_name = '".trim($color_u)."'
					") or die ('Table stock update error: '.mysql_error());
					}
					else
					{
						$qry_i = mysql_query("
						INSERT INTO tbl_stock
							(
							prod_no, color_name, 
							size_0, size_2, size_4, size_6, size_8, size_10, size_12, size_14, size_16,
							size_xs, size_s, size_m, size_l, size_xl, size_fs,
							size_j0, size_j0_1, size_j0_2, size_j0_3,
							size_j1, size_j1_1, size_j1_2, size_j1_3, 
							size_j2, size_j2_1, size_j2_2, size_j2_3, 
							size_j3, size_j3_1, size_j3_2, size_j3_3, 
							size_j4, size_j4_1, size_j4_2, size_j4_3, 
							size_j5, size_j5_1, size_j5_2, size_j5_3, 
							size_j6, size_j6_1, size_j6_2, size_j6_3, 
							size_j7, size_j7_1, size_j7_2, size_j7_3, 
							size_j8, size_j8_1, size_j8_2, size_j8_3, 
							size_j9, size_j9_1, size_j9_2, size_j9_3
							)
						VALUES
							(
							'".trim($data[1])."', '".trim($color_u)."',
							30, 20, 30, 30, 30, 30, 30, 30, 30, 
							30, 20, 30, 30, 30, 30, 
							30, 20, 30, 30, 
							30, 10, 30, 30, 
							30, 15, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30
							)
					") or die ('Table stock insert error: '.mysql_error());
					}
				}
			}
			elseif ($mode == 'Inserting')
			{
				$explode_i = explode('-',trim($data[11]));
				foreach ($explode_i as $color_i)
				{
					$qry_i = mysql_query("
						INSERT INTO tbl_stock
							(
							prod_no, color_name, 
							size_0, size_2, size_4, size_6, size_8, size_10, size_12, size_14, size_16,
							size_xs, size_s, size_m, size_l, size_xl, size_fs,
							size_j0, size_j0_1, size_j0_2, size_j0_3,
							size_j1, size_j1_1, size_j1_2, size_j1_3, 
							size_j2, size_j2_1, size_j2_2, size_j2_3, 
							size_j3, size_j3_1, size_j3_2, size_j3_3, 
							size_j4, size_j4_1, size_j4_2, size_j4_3, 
							size_j5, size_j5_1, size_j5_2, size_j5_3, 
							size_j6, size_j6_1, size_j6_2, size_j6_3, 
							size_j7, size_j7_1, size_j7_2, size_j7_3, 
							size_j8, size_j8_1, size_j8_2, size_j8_3, 
							size_j9, size_j9_1, size_j9_2, size_j9_3
							)
						VALUES
							(
							'".trim($data[1])."', '".trim($color_i)."',
							30, 20, 30, 30, 30, 30, 30, 30, 30, 
							30, 20, 30, 30, 30, 30, 
							30, 20, 30, 30, 
							30, 10, 30, 30, 
							30, 15, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30, 
							30, 30, 30, 30
							)
					") or die ('Table stock insert error: '.mysql_error());
				}
			}
		}
	}
	
	$file = strtolower($strFile1);
	//unlink("$file");
	$GLOBALS["message"] = "Product ".strtoupper($_REQUEST['subcat'])." has been successfully added";
	
	if ($_GET['csv'] == 1)
	{
		echo "<script>window.location.href='edit_new_product_designer.php?cat_id=".$uri_cat_id."&des_id=".$uri_des_id."&subcat_id=".$uri_subcat_id."'</script>";
	}
	elseif ($_GET['upcsv'] == 1)
	{
		header("Location: ".SITE_URL."admin/edit_csv.php?dmsg=1");
	}
	else
	{
		if ($err ==1)
		{
			echo "<script>window.location.href='upload-product.php?msg=2'</script>"; 
		}
		else
		{
			echo "<script>window.location.href='upload-product.php?msg=1'</script>";
		} 
	}
	
	