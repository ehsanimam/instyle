<?php

function update_prod_no($post_ary, $files_ary)
{
	// get all post variables
	$prod_no = $post_ary['prod_no'];
	$prod_name = $post_ary['prod_name'];
	$seque = $post_ary['seque'];
	$des_id = $post_ary['designer'];
	
	$pub_instyle = $post_ary['publish_at_instyle'];
	$pub_designer = $post_ary['publish_at_designer'];
	
	$folder_path = $post_ary['folder'];
	
	$cat_id = $post_ary['cat'];
	$subcat_id = $post_ary['subcat'];
	$subsubcat_id = $post_ary['subsubcat'];
	$new_arrival = $post_ary['new_arrival'];
	$clearance = $post_ary['clearance'];
	$prod_date = $post_ary['add_date'];
	$catalogue_price = $post_ary['catalogue_price'];
	$less_discount = $post_ary['less_discount'];
	$wholesale_price = $post_ary['wholesale_price'];
	$prod_desc = $post_ary['prod_desc'];
	$primary_img_id = isset($post_ary['primary_img_id']) ? $post_ary['primary_img_id'] : '';
	$color_name = isset($post_ary['color_name']) ? $post_ary['color_name'] : '';
	
	$color_id1 = isset($post_ary['color_id1']) ? $post_ary['color_id1'] : '';
	$style_id1 = isset($post_ary['style_id1']) ? $post_ary['style_id1'] : '';
	$material_id1 = isset($post_ary['material_id1']) ? $post_ary['material_id1'] : '';
	$trend_id1 = isset($post_ary['trend_id1']) ? $post_ary['trend_id1'] : '';
	$event_id1 = isset($post_ary['event_id1']) ? $post_ary['event_id1'] : '';
	
	$size_0 = $post_ary['size_0'];
	$size_2 = $post_ary['size_2'];
	$size_4 = $post_ary['size_4'];
	$size_6 = $post_ary['size_6'];
	$size_8 = $post_ary['size_8'];
	$size_10 = $post_ary['size_10'];
	$size_12 = $post_ary['size_12'];
	$size_14 = $post_ary['size_14'];
	$size_16 = $post_ary['size_16'];
	
	$color_stock_date = isset($post_ary['color_stock_date']) ? $post_ary['color_stock_date'] : '';
	
	// -----------------------------------------
	// ---> FACET Modification
	
		// ---> Color Facets
		$stock_qry = "SELECT * FROM tbl_stock WHERE prod_no = '".$prod_no."'";
		$stock_res = mysql_query($stock_qry) or die ('Select table stock error - '.mysql_error());
		$num_stock = mysql_num_rows($stock_res);
		
		// for each color, insert color facet to tbl_stock
		$c = 0;
		while ($stock_color_rec = mysql_fetch_array($stock_res))
		{
			if (isset($color_id1[$stock_color_rec['color_name']]) && ! empty($color_id1[$stock_color_rec['color_name']]))
			{
				$colors = '';
				foreach ($color_id1[$stock_color_rec['color_name']] as $c)
				{
					$colors .= $c.'-';
				}
				$sql_upc[$c] = "UPDATE tbl_stock SET color_facets = '".strtoupper(substr($colors,0,-1))."' WHERE prod_no = '".$prod_no."' AND color_name = '".$stock_color_rec['color_name']."'";
			}
			else
			{
				$sql_upc[$c] = "UPDATE tbl_stock SET color_facets = '' WHERE prod_no = '".$prod_no."' AND color_name = '".$stock_color_rec['color_name']."'";
			}
			$c++;
		}

		// free up mysql memory
		mysql_free_result($stock_res);
		
		// ---> Styles Facets
		if ( ! empty($style_id1))
		{
			$styles = ''; 
			foreach ($style_id1 as $s)
			{
				$styles .= $s.'-';
			}
			$styles_facets = strtoupper(substr($styles, 0, -1));
			//$sql_ups = "UPDATE tbl_product SET styles = '".strtoupper(substr($styles, 0, -1))."' WHERE prod_no = '".$prod_no."'";
			//$qry_styles = mysql_query($sql_ups) or die('Style facet error - '.mysql_error());
		}
		else $styles_facets = '';

		// ---> Materials Facets
		if ( ! empty($material_id1))
		{
			$materials = '';
			foreach ($material_id1 as $m)
			{
				$materials .= $m.'-';
			}
			$materials_facet = strtoupper(substr($materials, 0, -1));
		}
		else $materials_facet = '';

		// ---> Trends Facets
		if ( ! empty($trend_id1))
		{
			$trends = ''; 
			foreach ($trend_id1 as $t)
			{
				$trends .= $t.'-';
			}
			$trends_facets = strtoupper(substr($trends, 0, -1));
		}
		else $trends_facets = '';

		// ---> Events Facets
		if ( ! empty($event_id1))
		{
			$events = ''; 
			foreach ($event_id1 as $e)
			{
				$events .= $e.'-';
			}
			$events_facets = strtoupper(substr($events, 0, -1));
		}
		else $events_facets = '';
	
	// -----------------------------------------
	// ---> Add Color
	
		if ( ! empty($color_name))
		{
			// check if color exists
			$clr_stock_res = mysql_query("
				SELECT * 
				FROM tbl_stock
				WHERE prod_no = '".$prod_no."'
				AND color_name = '".$color_name."'
			") or die('Table Color select error - '.mysql_error());
			$clr_stock_num = mysql_num_rows($clr_stock_res);
			$clr_stock_rec = mysql_fetch_array($clr_stock_res);
			
			// insert new color and the inputted stock qty if any
			if ($clr_stock_num == 0 && ! empty($color_name))
			{
				$import = "
					INSERT INTO tbl_stock (
						prod_no, color_name,
						size_0, size_2, size_4, size_6, size_8, size_10, size_12, size_14, size_16
					) VALUES (
						'".$prod_no."', '".$color_name."',
						'".(int)$size_0."', '".(int)$size_2."', '".(int)$size_4."',
						'".(int)$size_6."', '".(int)$size_8."', '".(int)$size_10."',
						'".(int)$size_12."', '".(int)$size_14."', '".(int)$size_16."'
					)
				";
				
				// -----------------------------------------
				// ---> add new item prod_sku on db table new_items_count status is 1 for every new color added
				// this is for the sales package auto send email after 10 new items (5 - basix only for now)
				if ($des_id == 5)
				{
					$color_code = m_get_color_code($color_name);
					
					// need to put here an error code when get color code returns 0 or the color name doesn't exists
					// chances are slim but it's a good practice
					
					$prod_sku = $prod_no.'_'.$color_code;
					$update_new_items_count = m_add_to_new_items_count($prod_no, $prod_sku, $des_id);
				}
			}
		
			// free up mysql memory
			mysql_free_result($clr_stock_res);
		}
		else $import = '';
		
	// -----------------------------------------
	// ---> Color Stock Date Modification
	
		if ( ! empty($color_stock_date))
		{
			$sel_1 = "
				SELECT *
				FROM tbl_stock
				WHERE prod_no = '".$prod_no."'
			";
			$qry_1 = mysql_query($sel_1) or die('Select stock error: '.mysql_error());
			
			if (mysql_num_rows($qry_1) > 0)
			{
				$stock_date_update_color_count = 0;
				while ($row_1 = mysql_fetch_array($qry_1))
				{
					// update stock date
					$color_string = strtolower(str_replace(' ','_',trim($row_1['color_name'])));
					if (isset($color_stock_date[$color_string]) && $color_stock_date[$color_string] != '')
					{
						$stock_date_update_color_count++;
						$upd_1[$stock_date_update_color_count] = "
							UPDATE tbl_stock
							SET stock_date = '".$color_stock_date[$color_string]."'
							WHERE prod_no = '".$prod_no."'
							AND color_name = '".$row_1['color_name']."'
						";
					}
				}
			}
		
			// free up mysql memory
			mysql_free_result($qry_1);
		}
		else $upd_1 = '';

	// -----------------------------------------
	// ---> Upload and resample images
		update_images($files_ary, $prod_no, $folder_path);
	
	// -----------------------------------------
	// ---> auto-resampling for each color
		$folder_views = array('front', 'side', 'back');
		$qry_ = get_product_colors($prod_no);
		while ($prod_colors = mysql_fetch_array($qry_))
		{
			$img_path = $folder_path;
			$img_name = $prod_no.'_'.$prod_colors['color_code'];
			
			foreach ($folder_views as $fldr_view)
			{
				// resample image
				if ($img_information = @GetImageSize('../'.$img_path.'product_'.$fldr_view.'/'.$img_name.'.jpg'))
				{
					go_and_resample_2($img_information, $fldr_view, $img_path, $img_name);
				}
			}
			
			// break the referrence with the last element
			unset($fldr_view);
		
			// check video
			if (file_exists('../'.$img_path.'product_video/'.$img_name.'.flv'))
			{
				if ( ! file_exists('../../products/'.$img_path.'product_video/'.$img_name.'.flv'))
				{
					@copy('../'.$img_path.'product_video/'.$img_name.'.flv', '../../products/'.$img_path.'product_video/'.$img_name.'.flv');
				}
			}
		}

		// break the referrence with the last element
		unset($prod_colors);
		
		// free up mysql memory and break the reference with variable
		mysql_free_result($qry_);
		unset($qry_);
		
	// -----------------------------------------
	// ---> auto-create product_linesheet per color
		$qry_ = get_product_colors($prod_no);
		while ($prod_colors = mysql_fetch_array($qry_))
		{
			$img_path = $folder_path;
			$img_name = $prod_no.'_'.$prod_colors['color_code'];
			
			// always create product linesheet per product update even if image is already there
			// just in case images were updated via upload or ftp
			if ($img_info = GetImageSize('../'.$img_path.'product_front/'.$img_name.'.jpg'))
			{
				create_linesheet($img_info, $prod_no, $img_path, $img_name);
				
				// -----------------------------------------
				// ---> udpate prod_no on db table new_items_count status is 2 (5 - basix only for now)
				// this is for the sales package auto send email after 10 new items
				if ($des_id == 5)
				{
					$prod_sku = $img_name;
					$update_new_items_count = models_update_new_items_count($prod_sku, $des_id);
				}
			}
		}
		
	// -----------------------------------------
	// ---> Set some variables to input to tbl_product
	
		// ---> $new_color for field 'colors'
		$clr_rows = mysql_query("SELECT color_name FROM tbl_stock WHERE prod_no = '".$prod_no."'") or die('Color field select error - '.mysql_error());
		
		$new_colors = '';
		while ($clr_row = mysql_fetch_array($clr_rows))
		{
			$new_colors .= $clr_row['color_name'].'-';
		}
		$new_colors = substr($new_colors,0,-1);
		
		// free up mysql memory
		mysql_free_result($clr_rows);
		
		// ---> $new_color for field 'colors'
		if ($pub_instyle == 'Y' && $pub_designer == 'Y') $view_status = 'Y';
		elseif ($pub_instyle == 'Y' && $pub_designer == 'N') $view_status = 'Y1';
		elseif ($pub_instyle == 'N' && $pub_designer == 'Y') $view_status = 'Y2';
		else $view_status = 'N';
	
	// -----------------------------------------
	// ---> Update tbl_product
		$prod_date = isset($prod_date) ? @date("Y-m-d",@strtotime($prod_date)) : '';
		$sql = "
			UPDATE tbl_product
			SET 
				prod_name = '".$prod_name."',
				prod_no = '".$prod_no."',
				seque = '".$seque."',
				view_status = '".$view_status."',
				cat_id = '".$cat_id."',
				subcat_id = '".$subcat_id."',
				subsubcat_id = '".(int)$subsubcat_id."',
				prod_date = '".$prod_date."',
				prod_desc = '".$prod_desc."',
				catalogue_price = '".$catalogue_price."',
				less_discount = '".$less_discount."',
				wholesale_price = '".$wholesale_price."',
				designer = '".$des_id."',
				primary_img_id = '".$primary_img_id."',
				colors = '".$new_colors."',
				new_arrival = '".$new_arrival."',
				clearance = '".$clearance."',
				styles = '".$styles_facets."',
				materials = '".$materials_facet."',
				trends = '".$trends_facets."',
				events = '".$events_facets."'
			WHERE
				prod_no = '".$prod_no."'
		";

		// ---> RUN qyery updates locally
		$sql_upc_ary_1 = $sql_upc;
		$sql_upc_ary_2 = $sql_upc;
		while ($clr_facet_qry_string = current($sql_upc_ary_1))
		{
			$qry_color_facet = mysql_query($clr_facet_qry_string) or die('Color facet error - '.mysql_error());
			next($sql_upc_ary_1);
		}
		if (isset($upd_1) && $upd_1 != '')
		{
			for ($i = 1; $i <= $stock_date_update_color_count; $i++)
			{
				$update_tbl_stock = mysql_query($upd_1[$i]) or die('Updating tbl_stock error '.$stock_date_update_color_count.': '.mysql_error()).'<br />'.$upd_1[$i];
			}
			// remove reference to last element
			unset($i);
		}
		if ($import != '')
		{
			$add_color_and_stock = mysql_query($import) or die('Table Stock error - '.mysql_error());
		}
		$update_records = mysql_query($sql) or die('Update records error - '.mysql_error());
		
		// -----------------------------------------
		// ---> Sales package sending
		
			// count all products that are published at instyle (basix only for now)
			// products that are newly added to the database
			function check_new_items_count()
			{
				$sel = "
					SELECT COUNT(*) AS tic_all 
					FROM 
						new_items_count 
					WHERE 
						status = '2' 
						AND des_id = '5'
				";
				$qry = mysql_query($sel) or die('Count New Items With Images Error!<br />'.mysql_error().'<br />'.$sel);
				
				if (mysql_num_rows($qry) > 0)
				{
					$row = mysql_fetch_array($qry);
					$res = $row['tic_all'];
				}
				else $res = 0;
				
				// free up mysql memory
				mysql_free_result($qry);
				
				return $res;
			}
			
			if (check_new_items_count() === '10' && $_SERVER['SERVER_NAME'] !== 'localhost')
			{
				// update new product items status to 3 for sending
				$upd_new_items_count_status_to_3 = "
					UPDATE new_items_count 
					SET
						status = '3'
					WHERE 
						status = '2' 
						AND des_id = '5'
				";
				$qry_new_items_count_status_to_3 = mysql_query($upd_new_items_count_status_to_3) or die('Select from new_items_count Error!<br />'.mysql_error().'<br />'.$upd_new_items_count_status_to_3);
	
				// (Dont ask me but I'm just following those the I see in the internet and it seems to work just fine ">> /dev/null 2>&1"
				$exec = exec('php ./new_items_sending.php >> /dev/null 2>&1 &');
			}

		// ---> RUN qyery updates remotely
		if ($_SERVER['SERVER_NAME'] !== 'localhost') // --> change 'localhost' to your local dev environment server
		{
			if ($_SERVER['SERVER_NAME'] !== 'www.storybookknits.com')
			{
				if ($_SERVER['SERVER_NAME'] === 'www.instylemilan.com')
				{
					// connect config to remote db
					$host_remote="216.70.104.66";
					$username_remote="joe_taveras";
					$password_remote="!@R00+@dm!N";
					$db_remote="joe_moscow";
				}
				elseif ($_SERVER['SERVER_NAME'] === 'www.instylenewyork.com')
				{
					// connect config to remote db
					$host_remote="64.207.150.168";
					$username_remote="joereyrusty_icm";
					$password_remote="!@R00+@dm!N";
					$db_remote="icmbasix_main";
				}

				// connet to remote db
				$conn_remote = mysql_connect($host_remote,$username_remote,$password_remote);
				mysql_select_db($db_remote,$conn_remote);
				
					while ($clr_facet_qry_string = current($sql_upc_ary_2))
					{
						$qry_color_facet = mysql_query($clr_facet_qry_string) or die('Remote color facet error - '.mysql_error());
						next($sql_upc_ary_2);
					}
					if (isset($upd_1) && $upd_1 != '')
					{
						for ($i = 1; $i <= $stock_date_update_color_count; $i++)
						{
							$update_tbl_stock = mysql_query($upd_1[$i]) or die('Updating remote tbl_stock error: '.mysql_error());
						}
						// remove reference to last element
						unset($i);
					}
					if ($import != '')
					{
						$add_color_and_stock = mysql_query($import) or die('Table Stock remote error - '.mysql_error());
						mysql_free_result($add_color_and_stock);
					}
					
					$sql2 = "
						UPDATE tbl_product
						SET 
							prod_name = '".$prod_name."',
							prod_no = '".$prod_no."',
							view_status = '".$view_status."',
							cat_id = '".$cat_id."',
							subcat_id = '".$subcat_id."',
							subsubcat_id = '".(int)$subsubcat_id."',
							prod_date = '".$prod_date."',
							prod_desc = '".$prod_desc."',
							catalogue_price = '".$catalogue_price."',
							less_discount = '".$less_discount."',
							wholesale_price = '".$wholesale_price."',
							designer = '".$des_id."',
							primary_img_id = '".$primary_img_id."',
							colors = '".$new_colors."',
							new_arrival = '".$new_arrival."',
							clearance = '".$clearance."',
							styles = '".$styles_facets."',
							materials = '".$materials_facet."',
							trends = '".$trends_facets."',
							events = '".$events_facets."'
						WHERE
							prod_no = '".$prod_no."'
					";

					$update_records = mysql_query($sql2) or die('Update records error - '.mysql_error());
					
				// close remote db connection
				mysql_close($conn_remote);
			}
		}
		
	// -----------------------------------------
	// ---> End

	$_SESSION['m'] = 3;
	
	echo "
		<script>
			location.href='csv_update.php?cat_id=".$cat_id."&des_id=".$des_id."&subcat_id=".$subcat_id."&prod_no=".$prod_no."';
		</script>
	";
}

function delete_stock($get_ary)
{
	$prod_no = $get_ary['prod_no'];
	$color_name = $get_ary['color'];
	$cat_id = $get_ary['c'];
	$subcat_id = $get_ary['sc'];
	$des_id = $get_ary['d'];
	
	$qry_del_stock = mysql_query("DELETE FROM tbl_stock WHERE prod_no ='".$prod_no."' AND color_name = '".$color_name."'") or die('Delete stock error - '.mysql_error());
	
	// update remote designer
	if ($_SERVER['SERVER_NAME'] !== 'localhost') // --> change 'localhost' to your local dev environment server
	{
		if ($_SERVER['SERVER_NAME'] !== 'www.storybookknits.com')
		{
			if ($_SERVER['SERVER_NAME'] === 'www.instylemilan.com')
			{
				// connect config to remote db
				$host_remote="216.70.104.66";
				$username_remote="joe_taveras";
				$password_remote="!@R00+@dm!N";
				$db_remote="joe_moscow";
			}
			elseif ($_SERVER['SERVER_NAME'] === 'www.instylenewyork.com')
			{
				// connect config to remote db
				$host_remote="64.207.150.168";
				$username_remote="joereyrusty_icm";
				$password_remote="!@R00+@dm!N";
				$db_remote="icmbasix_main";
			}

			// connet to remote db
			$conn = mysql_connect($host_remote,$username_remote,$password_remote);
			mysql_select_db($db_remote,$conn);
			
				$qry_del_stock = mysql_query("DELETE FROM tbl_stock WHERE prod_no ='".$prod_no."' AND color_name = '".$color_name."'") or die('Delete stock error - '.mysql_error());
				
				// free up mysql memory
				mysql_free_result($qry_del_stock);
				
			// close remote db connection
			mysql_close($conn);
		}
	}
	
	$_SESSION['m'] = 3;
	
	echo "
		<script>
			location.href='csv_update.php?cat_id=".$cat_id."&des_id=".$des_id."&subcat_id=".$subcat_id."&prod_no=".$prod_no."';
		</script>
	";
}

function pubunpub_color($get_ary)
{
	$prod_no = $get_ary['prod_no'];
	$prod_color = $get_ary['color'];
	$pub_mode = $get_ary['pub'];
	
	// update color publish mode
	$upd_2 = "
		UPDATE tbl_stock
		SET color_publish = '".$pub_mode."'
		WHERE
			prod_no = '".$prod_no."'
			AND color_name = '".$prod_color."'
	";
	$qry_upd_2 = mysql_query($upd_2) or die('Updating tbl_stock color publish error: '.mysql_error());
	
	// update remote designer
	if ($_SERVER['SERVER_NAME'] !== 'localhost') // --> change 'localhost' to your local dev environment server
	{
		// to remote db config
		$host_remote="216.70.104.66";
		$username_remote="joe_taveras";
		$password_remote="!@R00+@dm!N";
		$db_remote="joe_moscow";

		// connet to remote db
		$conn = mysql_connect($host_remote,$username_remote,$password_remote);
		mysql_select_db($db_remote,$conn);
		
			$qry_upd_2 = mysql_query($upd_2) or die('Updating tbl_stock color publish error: '.mysql_error());
			
			// free up mysql memory
			mysql_free_result($qry_upd_2);
			
		// close remote db connection
		mysql_close($conn);
	}
	
	$_SESSION['m'] = 3;
	
	echo "
		<script>
			window.location.href = 'edit_product_details.php?prod_no=".$prod_no."';
		</script>
	";
}

function update_images($files_ary, $prod_no, $folder_path)
{
	// -----------------------------------------
	// ---> FRONT
	if ($files_ary['front_'.$prod_no]['error'] == 0)
	{
		$filename1 = $files_ary['front_'.$prod_no]['name'];
		$fileatt1 = $files_ary['front_'.$prod_no]['tmp_name'];
		$fileatt_type1 = $files_ary['front_'.$prod_no]['type'];
		
		$path01 = '../'.$folder_path;
		$uploadFilesTo1 = $path01.'product_front/';
		$path06 = '../../products/'.$folder_path;
		$uploadFilesTo6 = $path06.'product_front/';
		
		// move uploaded file to old product_assets folder respective view
		move_uploaded_file($fileatt1, $uploadFilesTo1.'/'.$filename1);
		// resample image
		if ($img_info = @GetImageSize($uploadFilesTo1.'/'.$filename1))
		{
			go_and_resample($img_info, 'front', $path01, $filename1);
		}
		// copy uploaded file to product_assets folder respective view repository
		copy($uploadFilesTo1.'/'.$filename1, $uploadFilesTo6.'/'.$filename1);
		// resample image
		if ($img_info = @GetImageSize($uploadFilesTo6.'/'.$filename1))
		{
			go_and_resample($img_info, 'front', $path06, $filename1);
		}
	}
	
	// -----------------------------------------
	// ---> BACK
	if ($files_ary['back_'.$prod_no]['error'] == 0)
	{
		$filename2 = $files_ary['back_'.$prod_no]['name'];
		$fileatt2 = $files_ary['back_'.$prod_no]['tmp_name'];
		$fileatt_type2 = $files_ary['back_'.$prod_no]['type'];
		
		$path02 = '../'.$folder_path;
		$uploadFilesTo2 = $path02.'product_back/';
		$path07 = '../../products/'.$folder_path;
		$uploadFilesTo7 = $path07.'product_back/';
		
		// move uploaded file to old product_assets folder respective view
		move_uploaded_file($fileatt2, $uploadFilesTo2.'/'.$filename2);
		// resample image
		if ($img_info = @GetImageSize($uploadFilesTo2.'/'.$filename2))
		{
			go_and_resample($img_info, 'back', $path02, $filename2);
		}
		// copy uploaded file to product_assets folder respective view repository
		copy($uploadFilesTo2.'/'.$filename2, $uploadFilesTo7.'/'.$filename2);
		// resample image
		if ($img_info = @GetImageSize($uploadFilesTo7.'/'.$filename2))
		{
			go_and_resample($img_info, 'back', $path07, $filename2);
		}
	}
	
	// -----------------------------------------
	// ---> SIDE
	if ($files_ary['side_'.$prod_no]['error'] == 0)
	{
		$filename3 = $files_ary['side_'.$prod_no]['name'];
		$fileatt3 = $files_ary['side_'.$prod_no]['tmp_name'];
		$fileatt_type3 = $files_ary['side_'.$prod_no]['type'];
		
		$path03 = '../'.$folder_path;
		$uploadFilesTo3 = $path03.'product_side/';
		$path08 = '../../products/'.$folder_path;
		$uploadFilesTo8 = $path08.'product_side/';
		
		// move uploaded file to old product_assets folder respective view
		move_uploaded_file($fileatt3, $uploadFilesTo3.'/'.$filename3);
		// resample image
		if ($img_info = @GetImageSize($uploadFilesTo3.'/'.$filename3))
		{
			go_and_resample($img_info, 'side', $path03, $filename3);
		}
		// copy uploaded file to product_assets folder respective view repository
		copy($uploadFilesTo3.'/'.$filename3, $uploadFilesTo8.'/'.$filename3);
		// resample image
		if ($img_info = @GetImageSize($uploadFilesTo8.'/'.$filename3))
		{
			go_and_resample($img_info, 'side', $path08, $filename3);
		}
	}
	
	// -----------------------------------------
	// ---> COLOR ICON
	if ($files_ary['icon_'.$prod_no]['error'] == 0)
	{
		$filename4 = $files_ary['icon_'.$prod_no]['name'];
		$fileatt4 = $files_ary['icon_'.$prod_no]['tmp_name'];
		$fileatt_type4 = $files_ary['icon_'.$prod_no]['type'];
		
		$path04 = '../'.$folder_path;
		$uploadFilesTo4 = $path04.'product_coloricon/';
		$path09 = '../../products/'.$folder_path;
		$uploadFilesTo9 = $path09.'product_coloricon/';
		
		// move uploaded file to old product_assets folder respective view
		move_uploaded_file($fileatt4, $uploadFilesTo4.'/'.$filename4);
		// resample image
		if ($img_info = @GetImageSize($uploadFilesTo4.'/'.$filename4))
		{
			go_and_resample($img_info, 'product_coloricon', $path04, $filename4);
		}
		// copy uploaded file to product_assets folder respective view repository
		copy($uploadFilesTo4.'/'.$filename4, $uploadFilesTo9.'/'.$filename4);
		// resample image
		if ($img_info = @GetImageSize($uploadFilesTo9.'/'.$filename4))
		{
			go_and_resample($img_info, 'product_coloricon', $path09, $filename4);
		}
	}
	
	// -----------------------------------------
	// ---> VIDEO
	if ($files_ary['video_'.$prod_no]['error'] == 0)
	{
		$filename5 = $files_ary['video_'.$prod_no]['name'];
		$fileatt5 = $files_ary['video_'.$prod_no]['tmp_name'];
		$fileatt_type5 = $files_ary['video_'.$prod_no]['type'];
		
		$path05 = '../'.$folder_path;
		$uploadFilesTo5 = $path05.'product_video/';
		$path10 = '../../products/'.$folder_path;
		$uploadFilesTo10 = $path10.'product_video/';
		
		// move uploaded file to old product_assets folder respective view
		move_uploaded_file($fileatt5, $uploadFilesTo5.'/'.$filename5);
		// copy uploaded file to product_assets folder respective view repository
		copy($uploadFilesTo5.'/'.$filename5, $uploadFilesTo10.'/'.$filename5);
	}
	
	return;
}

function go_and_resample($img_info, $view, $img_path, $img_name)
{
	// add subfolder where necessary
	if ( ! file_exists($img_path.'product_'.$view.'/thumbs'))
	{
		$old = umask(0);
		if ( ! mkdir($img_path.'product_'.$view.'/thumbs', 0777, TRUE)) die('Unable to create "'.$img_path.'product_'.$view.'/thumbs'.'" folder.');
		umask($old);
	}
	
	// image width
	$w = $img_info[0];
	// image height
	$h = $img_info[1];
	
	// new images size as per thumb
	$new_w_1 = 140;
	$new_h_1 = 210;
	$new_w_2 = 60;
	$new_h_2 = 90;
	$new_w_3 = 340;
	$new_h_3 = 510;
	
	$raw_image_at_instyle = $img_path.'product_'.$view.'/'.$img_name.'.jpg';
	$im = @ImageCreateFromJPEG($img_path.'product_'.$view.'/'.$img_name.'.jpg'); // Read JPEG Image
	
	if ( ! $im) echo 'No image for '.$view.' view at '.$raw_image_at_instyle.'.<br />';
	else
	{
		// thumb_1
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($new_w_1, $new_h_1);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_1, $new_h_1, $w, $h);
		// save resized image
		@ImageJPEG ($thumb,$img_path.'product_'.$view.'/thumbs/'.$img_name.'_1'.'.jpg',100);
		
		// free up memory
		imagedestroy($thumb);
		
		// thumb_2
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($new_w_2, $new_h_2);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_2, $new_h_2, $w, $h);
		// save resized image
		@ImageJPEG ($thumb,$img_path.'product_'.$view.'/thumbs/'.$img_name.'_2'.'.jpg',100);
		
		// free up memory
		imagedestroy($thumb);
		
		// thumb_3
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($new_w_3, $new_h_3);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_3, $new_h_3, $w, $h);
		// save resized image
		@ImageJPEG ($thumb,$img_path.'product_'.$view.'/thumbs/'.$img_name.'_3'.'.jpg',100);
		
		// free up memory
		imagedestroy($thumb);
	}
	
	return;
}

function go_and_resample_2($img_info, $view, $img_path, $img_name)
{
	// add subfolder where necessary
	if ( ! file_exists('../'.$img_path.'product_'.$view.'/thumbs'))
	{
		$old = umask(0);
		if ( ! mkdir('../'.$img_path.'product_'.$view.'/thumbs', 0777, TRUE)) die('Unable to create "'.$img_path.'product_'.$view.'/thumbs'.'" folder.');
		umask($old);
	}
	
	// add subfolder where necessary at the repository
	if ( ! file_exists('../../products/'.$img_path.'product_'.$view.'/thumbs'))
	{
		$old = umask(0);
		if ( ! mkdir('../../products/'.$img_path.'product_'.$view.'/thumbs', 0777, TRUE)) die('Unable to create "'.'../products/'.$img_path.'product_'.$view.'/thumbs'.'" folder.');
		umask($old);
	}
	
	// image width
	$w = $img_info[0];
	// image height
	$h = $img_info[1];
	
	// new images size as per thumb
	$new_w_1 = 140;
	$new_h_1 = 210;
	$new_w_2 = 60;
	$new_h_2 = 90;
	$new_w_3 = 340;
	$new_h_3 = 510;
	
	$raw_image_at_instyle = '../'.$img_path.'product_'.$view.'/'.$img_name.'.jpg';
	$im = @ImageCreateFromJPEG($raw_image_at_instyle); // Read JPEG Image
	
	if ( ! $im) echo 'No image for '.$view.' view at '.$raw_image_at_instyle.'.<br />';
	else
	{
		// copy $im file to product_assets folder respective view repository
		if ( ! copy('../'.$img_path.'product_'.$view.'/'.$img_name.'.jpg', '../../products/'.$img_path.'product_'.$view.'/'.$img_name.'.jpg'))
		{
			echo 'Failed to copy file...\n';
		}
		
		// thumb_1
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($new_w_1, $new_h_1);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_1, $new_h_1, $w, $h);
		// save resized image
		@ImageJPEG ($thumb,'../'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_1'.'.jpg',100);
		
		// free up memory
		imagedestroy($thumb);
			
			// at the repository
			// Create the resized image destination
			$thumb = @ImageCreateTrueColor ($new_w_1, $new_h_1);
			// Copy from image source, resize it, and paste to image destination
			@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_1, $new_h_1, $w, $h);
			// save resized image
			@ImageJPEG ($thumb,'../../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_1'.'.jpg',100);
		
			// free up memory
			imagedestroy($thumb);
		
		// thumb_2
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($new_w_2, $new_h_2);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_2, $new_h_2, $w, $h);
		// save resized image
		@ImageJPEG ($thumb,'../'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_2'.'.jpg',100);
		
		// free up memory
		imagedestroy($thumb);
			
			// at the repository
			// Create the resized image destination
			$thumb = @ImageCreateTrueColor ($new_w_2, $new_h_2);
			// Copy from image source, resize it, and paste to image destination
			@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_2, $new_h_2, $w, $h);
			// save resized image
			@ImageJPEG ($thumb,'../../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_2'.'.jpg',100);
		
			// free up memory
			imagedestroy($thumb);
			
		// thumb_3
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($new_w_3, $new_h_3);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_3, $new_h_3, $w, $h);
		// save resized image
		@ImageJPEG ($thumb,'../'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_3'.'.jpg',100);
		
		// free up memory
		imagedestroy($thumb);
			
			// at the repository
			// Create the resized image destination
			$thumb = @ImageCreateTrueColor ($new_w_3, $new_h_3);
			// Copy from image source, resize it, and paste to image destination
			@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_3, $new_h_3, $w, $h);
			// save resized image
			@ImageJPEG ($thumb,'../../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_3'.'.jpg',100);
		
			// free up memory
			imagedestroy($thumb);
	}
	
	return;
}

function create_linesheet($img_info, $prod_no, $img_path, $img_name)
{
	// add subfolder where necessary
	if ( ! file_exists('../'.$img_path.'product_linesheet'))
	{
		$old = umask(0);
		if ( ! mkdir('../'.$img_path.'product_linesheet', 0777, TRUE)) die('Unable to create "'.$img_path.'product_linesheet'.'" folder.');
		umask($old);
	}
	
	// add subfolder where necessary at the repository
	if ( ! file_exists(IMG_REPO_URL_VAR.$img_path.'product_linesheet'))
	{
		$old = umask(0);
		if ( ! mkdir(IMG_REPO_URL_VAR.$img_path.'product_linesheet', 0777, TRUE)) die('Unable to create "'.IMG_REPO_URL_VAR.$img_path.'product_linesheet'.'" folder.');
		umask($old);
	}
	
	// -----------------------------------------
	// ---> Step 1
	// Create image instances
	switch (SITE_DOMAIN)
	{
		case 'www.instylenewyork.com':
			$logo = 'basix_logo.jpg';
		break;
		
		case 'www.storybookknits.com':
			$logo = 'storybook/storybook_logo.jpg';
		break;
		
		default:
			$logo = 'basix_logo.jpg';
	}
	$src = imagecreatefromjpeg('../images/'.$logo); // --> logo
	$dest = imagecreatetruecolor(830, 680); // --> backdrop

	// Copy basix logo at top left portion of image backdrop
	imagecopy($dest, $src, 10, 20, 0, 0, 283, 29);

	// save image linesheet (1st temp)
	imagejpeg($dest, '../'.$img_path.'product_linesheet/z_temp_0001.jpg', 100);

	// free up memmory
	imagedestroy($dest);
	imagedestroy($src);

	// -----------------------------------------
	// ---> Step 2
	// resample front and back/side and save in temp files
	$w = $img_info[0];
	$h = $img_info[1];
	$src = imagecreatefromjpeg('../'.$img_path.'product_front/'.$img_name.'.jpg');
	$dest = imagecreatetruecolor(400, 600);
	imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
	imagejpeg($dest, '../'.$img_path.'product_linesheet/z_temp_front.jpg', 100);
	imagedestroy($dest);
	imagedestroy($src);

	// if no back image, use side, else use front again
	if (file_exists('../'.$img_path.'product_back/'.$img_name.'.jpg')) $img = '../'.$img_path.'product_back/'.$img_name.'.jpg';
	elseif (file_exists('../'.$img_path.'product_side/'.$img_name.'.jpg')) $img = '../'.$img_path.'product_side/'.$img_name.'.jpg';
	else $img = '../'.$img_path.'product_front/'.$img_name.'.jpg';
	$img_info_2 = GetImageSize($img);
	$w = $img_info_2[0];
	$h = $img_info_2[1];
	$src = imagecreatefromjpeg($img);
	$dest = imagecreatetruecolor(400, 600);
	imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
	imagejpeg($dest, '../'.$img_path.'product_linesheet/z_temp_back.jpg', 100);
	imagedestroy($dest);
	imagedestroy($src);

	// -----------------------------------------
	// ---> Step 3
	// paste front temp files on linesheet image (left side)
	$src = imagecreatefromjpeg('../'.$img_path.'product_linesheet/z_temp_front.jpg'); // --> front image
	$dest = imagecreatefromjpeg('../'.$img_path.'product_linesheet/z_temp_0001.jpg'); // --> backdrop from step 1
	imagecopy($dest, $src, 10, 70, 0, 0, 400, 600);
	imagejpeg($dest, '../'.$img_path.'product_linesheet/z_temp_0002.jpg', 100);
	imagedestroy($dest);
	imagedestroy($src);

	// -----------------------------------------
	// ---> Step 4
	// paste back/side temp files on linesheet image (right side)
	$src = imagecreatefromjpeg('../'.$img_path.'product_linesheet/z_temp_back.jpg'); // --> back/side/front image
	$dest = imagecreatefromjpeg('../'.$img_path.'product_linesheet/z_temp_0002.jpg'); // --> backdrop from step 3
	imagecopy($dest, $src, 420, 70, 0, 0, 400, 600);
	imagejpeg($dest, '../'.$img_path.'product_linesheet/z_temp_0003.jpg', 100);
	imagedestroy($dest);
	imagedestroy($src);

	// -----------------------------------------
	// ---> Step 5
	// add product number at top right of final linesheet image
	$dest = imagecreatefromjpeg('../'.$img_path.'product_linesheet/z_temp_0003.jpg');
	$text_color = imagecolorallocate($dest, 255, 255, 255);
	imagestring($dest, 4, 700, 30, $prod_no, $text_color);
	imagejpeg($dest, '../'.$img_path.'product_linesheet/'.$img_name.'.jpg', 100);
	
	// -----------------------------------------
	// ---> Step 5
	// copy product_linesheet to repository
	imagejpeg($dest,IMG_REPO_URL_VAR.$img_path.'product_linesheet/'.$img_name.'.jpg',100);
}
