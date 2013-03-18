<?php
	include("../common.php");
	include('../functionsadmin.php');
	
	/*
	| -----------------------------------------------------------------------
	| Process - SHOW
	| -----------------------------------------------------------------------
	*/
	if (@$act == "show")
	{   
		/*
		| ------------------------------------------------------------------------------------
		| Query product number
		*/
		$sql = "select * from tbl_product where prod_no='$prod_no'";
		$p_rs = mysql_query($sql);
		$p_row = mysql_fetch_array($p_rs);
		
		$cat = $p_row['cat_id'];
		//$type = $p_row['type_id'];
		$des = $p_row['designer'];
		$subcat1 = $p_row['subcat_id'];
		$subsubcat1 = $p_row['subsubcat_id'];
		
		/*if(@$type)
		{
			$type1 =$type;
		}
		else $type1 = $p_row['type_id'];*/
		
		if (@$manuf == '')
		{
			if (isset($p_row['manufacturer_id']) && $p_row['manufacturer_id'] != '0')
			{
			$manuf = $p_row['manufacturer_id'];
			}
		}
		
		if (@$subcat_manu == '')
		{
			if (isset($p_row['manu_sub_id']) && $p_row['manu_sub_id'] != "") $subcat_manu=$p_row['manu_sub_id'];
			else $subcat_manu = 0;
		}
		
		if (@$tosale == '')
		{
			if ($p_row['on_sale'] != "") $tosale = $p_row['on_sale'];
			else $tosale=1;
		}
	}
	
	/*
	| -----------------------------------------------------------------------
	| Process - MODIFY
	| -----------------------------------------------------------------------
	*/
	if (@$act == "modi")
	{
		/*
		| -----------------------------------------------------------------------
		| Query product row where prod_no is given
		*/
		$prod_qry = mysql_query("SELECT * FROM tbl_product WHERE prod_no = '".$_POST['prod_no']."'") or die('Select tbl_product 1 error - '.mysql_error());
		//$prod_row = mysql_fetch_array($prod_qry);
		$get_img1 = mysql_fetch_array($prod_qry);
		
		$cat_id = $get_img1['cat_id'];
		$des_id = $get_img1['designer'];
		$subcat_id = $get_img1['subcat_id'];
		
		/*
		| -----------------------------------------------------------------------
		| Get color row used for adding new images on image modifications
		| This is only when a new color_name is chosen
		*/
		$getpic = mysql_query("SELECT * FROM tblcolor WHERE color_name = '".$_REQUEST['color_name']."'") or die('Select tblcolor 1 error - '.mysql_error());
		$irow = mysql_fetch_array($getpic);	
		
		/*
		| -----------------------------------------------------------------------
		| Facet Modification
		*/
		$stock_qry = "select * from tbl_stock WHERE prod_no = '".$_POST['prod_no']."'";
		$stock_res = mysql_query($stock_qry) or die ('Select table stock error - '.mysql_error());
		$num_stock = mysql_num_rows($stock_res);
		
		//echo $_POST['prod_no'].'<br />';
		//echo $stock_color_rec['color_name'].'<br />';
		//echo $color_id1[$stock_color_rec['color_name']].'<br />';
		//print_r($color_id1); die();
		
		// insert color facet to tbl_stock
		while ($stock_color_rec = mysql_fetch_array($stock_res))
		{
			if (isset($color_id1[$stock_color_rec['color_name']]) && ! empty($color_id1[$stock_color_rec['color_name']]))
			{
				$colors = '';
				foreach ($color_id1[$stock_color_rec['color_name']] as $c)
				{
					echo 'You selected color facet ',$c,'<br />';
					$colors .= $c.'-';
				}
				$sql_upc = "UPDATE tbl_stock SET color_facets = '".strtoupper(substr($colors,0,-1))."' WHERE prod_no = '".$prod_no."' AND color_name = '".$stock_color_rec['color_name']."'";
				mysql_query($sql_upc) or die('Color facet error - '.mysql_error());
			}
			else
			{
				$sql_upc = "UPDATE tbl_stock SET color_facets = '' WHERE prod_no = '".$prod_no."' AND color_name = '".$stock_color_rec['color_name']."'";
				mysql_query($sql_upc) or die('Color facet error - '.mysql_error());
			}
		}
	
		// insert style facet to tbl_product
		$color_id1 = $_POST['style_id1'];
		if (isset($style_id1) && ! empty($style_id1))
		{
			$styles = ''; 
			foreach ($style_id1 as $s)
			{
				echo 'You selected style facet ',$s,'<br />';
				$styles .= $s.'-';
			}
			$sql_ups = "update tbl_product set styles='".strtoupper(substr($styles,0,-1))."' where prod_no='".$prod_no."'";
			mysql_query($sql_ups) or die('Style facet error - '.mysql_error());
		}

		// insert material facet to tbl_product
		$material_id1 = $_POST['material_id1'];
		if (isset($material_id1) && ! empty($material_id1))
		{
			$materials = '';
			foreach ($material_id1 as $m)
			{
				echo 'You selected material facet ',$m,'<br />';
				$materials .= $m.'-';
			}
			$sql_upm = "update tbl_product set materials='".strtoupper(substr($materials,0,-1))."' where prod_no='".$prod_no."'";
			mysql_query($sql_upm) or die('Material facet error - '.mysql_error());
		}
	
		// insert trend facet to tbl_product
		$trend_id1 = $_POST['trend_id1'];
		if (isset($trend_id1) && ! empty($trend_id1))
		{
			$trends = ''; 
			foreach ($trend_id1 as $t)
			{
				echo 'You selected trend facet ',$t,'<br />';
				$trends .= $t.'-';
			}
			$sql_upt = "update tbl_product set trends='".strtoupper(substr($trends,0,-1))."' where prod_no='".$prod_no."'";
			mysql_query($sql_upt) or die('Trend facet error - '.mysql_error());
		}
	
		// insert events facet to tbl_product
		$event_id1 = $_POST['event_id1'];
		if (isset($event_id1) && ! empty($event_id1))
		{
			$events = ''; 
			foreach ($event_id1 as $e)
			{
				echo 'You selected event facet ',$e,'<br />';
				$events .= $e.'-';
			}
			$sql_upe = "update tbl_product set events='".strtoupper(substr($events,0,-1))."'  where prod_no='".$prod_no."'";
			mysql_query($sql_upe) or die('Events facet error - '.mysql_error());
		}
		
		echo '<br />';
		echo '-'.$_FILES["front_".$get_img1['prod_no']]['error'];
		echo '<br />';
		echo $_REQUEST['color_name'];
		echo '<br />';
		//die('die');
		
		/*
		| -----------------------------------------------------------------------
		| Image Modifications
		*/
		//if ($_FILES["front_".$get_img1['prod_no']] !="" && !empty($_REQUEST['color_name']))
		if ($_FILES["front_".$get_img1['prod_no']]['error'] == 0 && ! empty($_REQUEST['color_name']))
		{
			$file_product1 = $_POST['folder']."product_front/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
			//unlink($file_product1);
		
			/*
			| Must have been placed for debug pusposes...
			echo "Upload: " . $_FILES["front_".$get_img1['prod_no']]["name"] . "<br />";
			echo "Type: " . $_FILES["front_".$get_img1['prod_no']]["type"] . "<br />";
			echo "Size: " . ($_FILES["front_".$get_img1['prod_no']]["size"] / 1024) . " Kb<br />";
			echo "Stored in: " . $_FILES["front_".$get_img1['prod_no']]["tmp_name"];
			*/
  
			$img_front1=$_FILES["front_".$get_img1['prod_no']]['name'];
			$uploadFilesTo1 = $_POST['folder'].'product_front/';
			$fileatt1 =$_FILES["front_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type1 =$_FILES["front_".$get_img1['prod_no']]['type'];
			
			$img1=explode(".",$img_front1);
			
			$fileatt_name1 = $get_img1['prod_no']."_".$irow['color_code'].".".$img1[1];
			
			$fp1 = @fopen($fileatt1, 'rb');
			$data1 = @fread($fp1, filesize($fileatt1));
			@fclose($fp1);
			$data1 = @chunk_split(base64_encode($data1));
			@move_uploaded_file($fileatt1, $uploadFilesTo1.'/'.$fileatt_name1);
			
			/*
			echo "<pre>";
			print_r($_FILES);
			print_r($get_img1);
			echo "</pre>";
			*/
			//exit;
		}
		
		/*
		| -----------------------------------------------------------------------
		| Image Modifications
		*/
		//if ($_FILES["back_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		if ($_FILES["back_".$get_img1['prod_no']]['error'] == 0 && !empty($_REQUEST['color_name']))
		{
			$file_product2=$_POST['folder']."product_back/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
			//unlink($file_product2);
		
		    $img_front2=$_FILES["back_".$get_img1['prod_no']]['name'];
			$uploadFilesTo2 = $_POST['folder'].'product_back';
			$fileatt2 =$_FILES["back_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type2 =$_FILES["back_".$get_img1['prod_no']]['type'];
			
			$img2=explode(".",$img_front2);
			
			$fileatt_name2=$get_img1['prod_no']."_".$irow['color_code'].".".$img2[1];
			$fp2 = @fopen($fileatt2, 'rb');
			$data2 = @fread($fp2, filesize($fileatt2));
			@fclose($fp2);
			$data2 = @chunk_split(base64_encode($data2));
			@move_uploaded_file($fileatt2, $uploadFilesTo2.'/'.$fileatt_name2);
		}
		
		/*
		| -----------------------------------------------------------------------
		| Image Modifications
		*/
		//if ($_FILES["side_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		if ($_FILES["side_".$get_img1['prod_no']]['error'] == 0 && !empty($_REQUEST['color_name']))
		{
			$file_product2=$_POST['folder']."product_side/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
			//unlink($file_product3);
			
		    $img_front3=$_FILES["side_".$get_img1['prod_no']]['name'];
			$uploadFilesTo3 = $_POST['folder'].'product_side';
			$fileatt3 =$_FILES["side_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type3 =$_FILES["side_".$get_img1['prod_no']]['type'];
			
			$img3=explode(".",$img_front3);
			
			$fileatt_name3=$get_img1['prod_no']."_".$irow['color_code'].".".$img3[1];
			$fp3 = fopen($fileatt3, 'rb');
			$data3 = fread($fp3, filesize($fileatt3));
			fclose($fp3);
			$data3 = chunk_split(base64_encode($data3));
			move_uploaded_file($fileatt3, $uploadFilesTo3.'/'.$fileatt_name3);
		}

		/*
		| -----------------------------------------------------------------------
		| Image Modifications
		*/
		//if ($_FILES["icon_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		if ($_FILES["icon_".$get_img1['prod_no']]['error'] == 0 && !empty($_REQUEST['color_name']))
		{
			$file_product4=$_POST['folder']."product_coloricon/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
			//unlink($file_product4);
		
		    $img_front4=$_FILES["icon_".$get_img1['prod_no']]['name'];
			$uploadFilesTo4 = $_POST['folder'].'product_coloricon';
			$fileatt4 =$_FILES["icon_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type4 =$_FILES["icon_".$get_img1['prod_no']]['type'];
			
			$img4=explode(".",$img_front4);
			
			$fileatt_name4=$get_img1['prod_no']."_".$irow['color_code'].".".$img4[1];
			$fp4 = fopen($fileatt4, 'rb');
			$data4 = fread($fp4, filesize($fileatt4));
			fclose($fp4);
			$data4 = chunk_split(base64_encode($data4));
			move_uploaded_file($fileatt4, $uploadFilesTo4.'/'.$fileatt_name4);
		}
	
		/*
		| -----------------------------------------------------------------------
		| Video Modifications
		*/
		//if ($_FILES["video_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		if ($_FILES["video_".$get_img1['prod_no']]['error'] == 0 && !empty($_REQUEST['color_name']))
		{
			$file_product5=$_POST['folder']."product_video/".$get_img1["prod_no"]."_".$irow["color_code"].".flv" ;
			//unlink($file_product5);
		
		    $img_front5=$_FILES["video_".$get_img1['prod_no']]['name'];
			$uploadFilesTo5 = $_POST['folder'].'product_video';
			$fileatt5 =$_FILES["video_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type5 =$_FILES["video_".$get_img1['prod_no']]['type'];
			
			$img5=explode(".",$img_front5);
			
			$fileatt_name5=$get_img1['prod_no']."_".$irow['color_code'].".".$img5[1];
			$fp5 = fopen($fileatt5, 'rb');
			$data5 = fread($fp5, filesize($fileatt5));
			fclose($fp5);
			$data5 = chunk_split(base64_encode($data5));
			move_uploaded_file($fileatt5, $uploadFilesTo5.'/'.$fileatt_name5);
		}
		
		/*
		| -----------------------------------------------------------------------
		| Add color_name to stock and stock if new color and/or images were added
		| Stock Modifications
		*/
		
		// adding new colors (with or without images)
		$clr_stock_res = mysql_query("SELECT * 
								FROM 
									tbl_stock
								WHERE
									prod_no = '".$_POST['prod_no']."'
								AND
									color_name='".$_POST['color_name']."'") or die('Table Color select error - '.mysql_error());
		$clr_stock_num = mysql_num_rows($clr_stock_res);
		$clr_stock_rec = mysql_fetch_array($clr_stock_res);
		
		if ($clr_stock_num == 0 && ! empty($_POST['color_name']))
		{
			$import="INSERT INTO tbl_stock (
									prod_no,color_name,
									size_0,size_2,size_4,size_6,size_8,size_10,size_12,size_14,size_16,size_fs
							) 
							VALUES (
									'".$_REQUEST['prod_no']."','".$_REQUEST['color_name']."',
									'".(int)$_REQUEST['size_0']."','".(int)$_REQUEST['size_2']."','".(int)$_REQUEST['size_4']."',
									'".(int)$_REQUEST['size_6']."','".(int)$_REQUEST['size_8']."','".(int)$_REQUEST['size_10']."',
									'".(int)$_REQUEST['size_12']."','".(int)$_REQUEST['size_14']."','".(int)$_REQUEST['size_16']."',
									'".(int)$_REQUEST['size_fs']."'									
			)";
			$res_imp = mysql_query($import) or die('Table Stock error - '.mysql_error());
		}
		
		// updating stock date for existing colors
		$sel_1 = "
			SELECT *
			FROM tbl_stock
			WHERE prod_no = '".$_POST['prod_no']."'
		";
		$qry_1 = mysql_query($sel_1) or die('Select stock error: '.mysql_error());
		
		if (mysql_num_rows($qry_1) > 0)
		{
			while ($row_1 = mysql_fetch_array($qry_1))
			{
				$add_date_string = 'add_date_'.strtolower(str_replace(' ','_',trim($row_1['color_name'])));
				if (isset($_POST[$add_date_string]) && $_POST[$add_date_string] != '')
				{
					$upd_1 = "
						UPDATE tbl_stock
						SET stock_date = '".$_POST[$add_date_string]."'
						WHERE prod_no = '".$_POST['prod_no']."'
						AND color_name = '".$row_1['color_name']."'
					";
					$qry_upd_1 = mysql_query($upd_1) or die('Updating tbl_stock error: '.mysql_error());
				}
			}
		}
		
		/*
		| -----------------------------------------------------------------------
		| Add new color to colors for the update on tbl_product, or, retain current colors
		*/
		$clr_rows = mysql_query("select * from tbl_stock where prod_no='$prod_no'") or die (mysql_error());
		
		$new_colors = '';
		while ($clr_row = mysql_fetch_array($clr_rows))
		{
			$new_colors .= $clr_row['color_name'].'-';
		}
		$new_colors = substr($new_colors,0,-1);
		
		/*
		| -----------------------------------------------------------------------
		| Update the record at tbl_products
		*/
		if (empty($_REQUEST['cat']) || empty($_REQUEST['subcat']) || empty($_REQUEST['designer']))
		{
		    $global_message = 'Error:Category , sub-category or designer has no entry';
			echo $global_message.'<br />Hit BACK on browser';
		}
		else
		{
			$prod_return = admin_edit_new_product(
				$prod_id, 
				$prod_name, 
				$prod_no, 
				$_REQUEST['cat'], 
				$_REQUEST['subcat'], 
				$subsubcat, 
				$_POST['new_arrival'], 
				$_POST['clearance'], 
				$_POST['catalogue_price'], 
				$_POST['less_discount'], 
				$_POST['wholesale_price'], 
				$_POST['prod_desc'], 
				$_REQUEST['designer'], 
				$primary_img, 
				$_REQUEST['primary_img_id'], 
				$new_colors
			);
			$global_message = 'Product has been updated';
			
			echo "<script>
                location.href='csv_update.php?cat_id=".$cat_id."&des_id=".$des_id."&subcat_id=".$subcat_id."&prod_no=".$_POST['prod_no']."&err=".$global_message."'
				</script>";
		}
	}

	/*
	| -----------------------------------------------------------------------
	| Process - DEL_STOCK
	| -----------------------------------------------------------------------
	*/
	if ($act == "del_stock")
	{
		$getp = mysql_query("SELECT
							tp.prod_no, tp.prod_id,
							d.folder as designer_folder, subcat.folder AS subcat_folder, tcs.color_name, tcs.color_code, 
							case cat.cat_id
							  when '1'
								then 'WMANSAPREL'
							  when '19'
								then 'JWLRYACCSRIES'
							  when '22'
								then 'BRIDAL'
							  when '23'
								then 'WMANSAPREL'
							  else 'WMANSAPREL'
							end as cat_folder
							FROM
							  tbl_product tp
							  LEFT JOIN designer d ON d.des_id = tp.designer
							  LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
							  LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
							  LEFT JOIN tbl_stock ts ON ts.prod_no = tp.prod_no
							  LEFT JOIN tblcolor tcs ON tcs.color_name = ts.color_name
							WHERE
							  tp.prod_no = '".$_GET['prod_no']."'
							AND ts.color_name = '".$_GET['color']."'") 
		or die(mysql_error());
		
		if (@mysql_num_rows($getp))
		{
			$prow = @mysql_fetch_array($getp);
		 
		 	$x1 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_front/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x2 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_side/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x3 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_back/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x4 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_coloricon/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x5 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_video/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			
			/*
			@unlink($x1);
			@unlink($x2);
			@unlink($x3);
			@unlink($x4);
			@unlink($x5);
			*/
		 
			@mysql_query("DELETE FROM tbl_stock WHERE prod_no ='".$_GET['prod_no']."' AND color_name = '".$_GET['color']."'") or die(mysql_error());

			echo "<script>
                location.href='csv_update.php?cat_id=".$prow['cat_id']."&des_id=".$prow['designer']."&subcat_id=".$prow['subcat_id']."&prod_no=".$_GET['prod_no']."&err=stock has been deleted'
				</script>";
			/*
			| ----> original code prior to csv_update.php
			echo "<script>
                location.href='edit_new_par_product.php?act=show&prod_no=".$_GET['prod_no']."&mode=e&prod_return=1&err=stock has been deleted'
				</script>";
			*/
		}					  
	}

	/*
	| -----------------------------------------------------------------------
	| Process - PUBLISH/UNPUBLISH colors (from table stock)
	| -----------------------------------------------------------------------
	*/
	if ($_GET['act'] == "color_pub")
	{
		$prod_no = $_GET['prod_no'];
		$prod_color = $_GET['color'];
		$pub_mode = $_GET['pub'];
		
		// update color publish mode
		$upd_2 = "
			UPDATE tbl_stock
			SET color_publish = '".$pub_mode."'
			WHERE prod_no = '".$prod_no."'
			AND color_name = '".$prod_color."'
		";
		$qry_upd_2 = mysql_query($upd_2) or die('Updating tbl_stock color publish error: '.mysql_error());
		
		echo "
			<script>
                window.location.href = 'edit_new_par_product.php?act=show&prod_no=".$prod_no."&mode=e&msg=4';
			</script>
		";
	}
	
	/*
	| -----------------------------------------------------------------------
	| Process - DELETE (from thumbs list view)
	| -----------------------------------------------------------------------
	*/
	if ($act == "del")
	{
		$get_img1 = mysql_fetch_array(mysql_query("select * from tbl_product where prod_no='".$_REQUEST['prod_no']."'"));

		$cat_id = $_REQUEST['cat_id'];
		$des_id = $_REQUEST['des_id'];
		$subcat_id = $_REQUEST['subcat_id'];
		$prod_no = $_REQUEST['prod_no'];
		
		$getp = mysql_query("SELECT
							tp.prod_no, tp.prod_id, tp.designer,
							d.folder as designer_folder, subcat.folder AS subcat_folder, tcs.color_name, tcs.color_code,
							case cat.cat_id
							  when '1'
								then 'WMANSAPREL'
							  when '19'
								then 'JWLRYACCSRIES'
							  when '22'
								then 'BRIDAL'
							  when '23'
								then 'WMANSAPREL'
							  else 'WMANSAPREL'
							end as cat_folder
							FROM
							  tbl_product tp
							  LEFT JOIN designer d ON d.des_id=tp.designer
							  LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
							  LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
							  LEFT JOIN tbl_stock ts ON ts.prod_no = tp.prod_no
							  LEFT JOIN tblcolor tcs ON tcs.color_name = ts.color_name
							WHERE
							  tp.prod_no ='".$prod_no."'
							")
		or die(mysql_error());
		
		if (@mysql_num_rows($getp) > 0)
		{
			while($prow = @mysql_fetch_array($getp))
			{
				$x1 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_front/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
				$x2 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_side/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
				$x3 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_back/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
				$x4 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_coloricon/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
				$x5 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_video/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';

				/*
				@unlink($x1);
				@unlink($x2);
				@unlink($x3);
				@unlink($x4);
				@unlink($x5);
				*/
				$des_id = $prow['designer'];
			}
		}
		
		@mysql_query("delete from tbl_product where prod_no = '".$prod_no."'") or die(mysql_error());
		@mysql_query("DELETE from tbl_stock where prod_no = '".$prod_no."'") or die(mysql_error());

		?>
		<script type="text/javascript">
			<!--
			window.location = "csv_check.php?cat_id=<?=$cat_id?>&des_id=<?=$des_id?>&subcat_id=<?=$subcat_id?>&updb=1";
			//-->
		</script>
		<?php 
		/*
		| ----> original code when there was no csv_check.php
		<script type="text/javascript">
			<!--
			window.location = "edit_new_product_designer.php?cat_id=<?=$cat_id?>&des_id=<?=$des_id?>&subcat_id=<?=$subcat_id?>";
			//-->
		</script>
		*/
	}

	include 'top.php';
?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
   // document.prod_frm.subcat.value=0;
    document.prod_frm.method="post";
    document.prod_frm.action="edit_new_par_product.php?act=show&mode=e";
    document.prod_frm.submit();
}
function confirmLink(theLink,msg)
{
    // Confirmation is not required in the configuration file
    var is_confirmed = confirm(msg);
    return is_confirmed;
}
function confirm_del()
{
	return confirm('Are you sure you want to delete this color and its stocks?');
}
function del_primary_alert()
{
	alert("You cannot delete a Primary Color."+'\n\n'+"Please add another primary color, or, set another primary color before deleting old primary color.");
	return false;
}
function back_display()
{
    location.href="edit_new_product_designer.php?cat_id=<?=$cat;?>&des_id=<?=$des?>&subcat_id=<?=$subcat1?>"
}
function check_new_arrival(param)
{
	if (param == 'Y')
	{
		alert("You cannot assign this to 'CLEARANCE'."+'\n\n'+"Please unset it from 'New Arrival' and update the product detail first.");
		return false;
	}
	return true;
}
function check_clearance(param)
{
	if (param == 'Y')
	{
		alert("You cannot assign this to 'NEW ARRIVAL'."+'\n\n'+"Please unset it from 'Clearance' and update the product detail first.");
		return false;
	}
	return true;
}
</script>

    <link type="text/css" href="js/datePicker.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
	<script type="text/javascript" src="js/date.js"></script>

	<script type="text/javascript">
	$(function()
	{
		$('.date-pick').datePicker()
		$('#add_date').bind(
			'dpClosed',
			function(e, selectedDates)
			{
				var d = selectedDates[0];
				if (d) {
					d = new Date(d);
					//$('#add_date').dpSetStartDate(d.addDays(1).asString());
				}
			}
		);
	});
	</script>
    
<script type="text/javascript">
function showsubcat(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getsubcat.php?q="+str,true);
xmlhttp.send();
}
</script>    
    
<script>
	function check_date_availability(id) // ----> on blur of product availability input box
	{
		var preOrder = id.slice(id.length - 1);
		
		var d = document.getElementById(id).value;
		var yyyy = d.slice(6);
		var mm = d.slice(0,2);
		var dd = d.slice(3,5);
		var db_date = Date.UTC(yyyy,mm,dd);
		
		var d_today = new Date();
		var month = new Array(12);
		month[0] = "01";
		month[1] = "02";
		month[2] = "03";
		month[3] = "04";
		month[4] = "05";
		month[5] = "06";
		month[6] = "07";
		month[7] = "08";
		month[8] = "09";
		month[9] = "10";
		month[10] = "11";
		month[11] = "12";
		var d_mm = month[d_today.getMonth()];
		var d_dd = d_today.getDate();
		var d_yyyy = d_today.getFullYear();
		var today = Date.UTC(d_yyyy,d_mm,d_dd);
		
		if (preOrder == 1)
		{
			if (db_date <= today) alert('The availability date set is no longer in the future.' + "\n\n" + 'This makes product on regular sale upon update.');
		}
		else
		{
			if (db_date > today) alert('The avalability date set is in the future.' + "\n\n" + 'This makes product on PRE-ORDER upon update.');
		}
	}
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td class="tab" align="center" valign="middle">

	<?php
	if (@$mode == "e")
	{ ?>
		<!--bof form=============================================================================-->
		<form name="prod_frm" method="post" action="edit_new_par_product.php?act=modi" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top"><td class="border_color">
		
			<table border="0" cellpadding="5" cellspacing="1" width=100%  valign = "top">
                <!--DWLayoutTable-->
                <input type="hidden" name="prod_id" value="<? echo @$prod_id?>">
				<input type="hidden" name="prod_no" value="<? echo $p_row['prod_no']; ?>">
                <input type="hidden" name="hidOldFile1" value="<?PHP print $p_row['prod_image'] ; ?>">
				
                <?php
				/*
				| ---------------------------------------------------------------------------------------------
				| Error and prompt messages
				*/
				if(@$prod_return==1){?>
                <tr bgcolor="#eeeeee"> 
                  <td class="error" colspan=2><? echo @$err;?>&nbsp;</td>
                </tr>
                <? }?>
                <?php if(isset($_GET['msg']) && $_GET['msg']==1){?>
                <tr>
                  <td align=center colspan=2 class="error">Delete image Successful.</td>
                </tr>
                <?php } ?>
                <?php if(isset($_GET['msg']) && $_GET['msg']==3){?>
                <tr>
                  <td align=center colspan=2 class="error">Images & Stock Added Successfully.</td>
                </tr>
                <?php } ?>
                <?php if(isset($_GET['msg']) && $_GET['msg']==4){?>
                <tr>
                  <td align=center colspan=2 class="error">Product Updated.</td>
                </tr>
                <?php }
				
				/*
				| ---------------------------------------------------------------------------------------------
				| The HTML view
				| ---------------------------------------------------------------------------------------------
				*/
				?>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Product Name
				*/
				?>
				<tr bgcolor="#eeeeee"> 
					<td width="403" align="right" class="text">Product name : </td>
					<td width="946" align="left"><input type="text" name="prod_name" class="inputbox" value="<? echo $p_row['prod_name'];?>"></td>
                </tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Style Number (Product Number)
				*/
				?>
				<tr bgcolor="#eeeeee"> 
					<td width="403" align="right" class="text">Style Number : </td>
					<td width="946" align="left"><input type="text" name="prod_no" class="inputbox" value="<? echo $p_row['prod_no'];?>" readonly="readonly"></td>
                </tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Categories
				*/
				?>
                <tr bgcolor="#eeeeee"> 
					<td align="right" class="text">Category Name : </td>
					<td align="left"> 
						<select name="cat" onchange="showsubcat(this.value)">
							<?php
							$_SESSION['subcat']=$p_row['subcat_id'];;
							$sq = "select * from tblcat";
							$get_category = @mysql_query($sq);
							if (mysql_num_rows($get_category) > 0)
							{
								while ($row = mysql_fetch_array($get_category))
								{ ?> 
									<option value="<?=$row['cat_id']?>" <?php echo $row['cat_id']==$p_row['cat_id'] ? 'selected' : ''; ?>><?=$row['cat_name']?></option>
									<?php
								}
							}
							?>
						</select>
					</td>
                </tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Sub-categories
				*/
				?>
                <tr  bgcolor="#eeeeee">
					<td align="right" class="text">SubCategory name : </td>
					<td align="left"> <div id="txtHint">
						<select name="subcat">
							<?php
							$sq = "select * from tblsubcat where cat_id='".$p_row['cat_id']."'";
							$get_subcategory = @mysql_query($sq);
							if (mysql_num_rows($get_subcategory) > 0)
							{
								while ($rowx1 = mysql_fetch_array($get_subcategory))
								{ ?> 
									<option value="<?=$rowx1['subcat_id']?>" <?php echo $rowx1['subcat_id']==$p_row['subcat_id'] ? 'selected' : ''; ?>><?=$rowx1['subcat_name']?></option>
									<?php
								}
							}
							?>
					   </select> </div>
					</td>
                </tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Sub-sub-categories
				*/
				?>
                <tr  bgcolor="#eeeeee">
					<td align="right" class="text"> Sub SubCategory name : </td>
					<td align="left"> 
						<?php get_subsubcategories($subcat1); ?>
						<script>document.prod_frm.subsubcat.value="<?=$subsubcat1;?>"</script>
					</td>
                </tr>
				<!--
				<tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text">Type Category name : </td>
                  <td align="left"> 
                    <? get_typecategories_edit();?>
                    <script>document.prod_frm.type.value="<?=$type;?>"</script> 
                  </td>
                </tr>
				-->
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Designer
				*/
				?>
				<tr  bgcolor="#eeeeee"> 
					<td class="text" align="right">Designer : </td>
					<td align="left"> 
						<select name="designer">
							<option value=""></option>
							<?php
							$get_designer = @mysql_query("select * from designer where des_id='".$p_row['designer']."'");
							if (mysql_num_rows($get_designer) > 0)
							{
								while ($row = mysql_fetch_array($get_designer))
								{ ?>
									<option value="<?=$row['des_id']?>" <?php echo $row['des_id']==$p_row['designer'] ? 'selected' : ''; ?>><?=$row['designer']?></option>
									<?php
								}
							}
							?>
						</select>
					</td>
                </tr>
				<?php
				$nc = array('New Arrival','new arrival','Clearance','clearance','Yes','yes','Y','y');
				$new_a = in_array($p_row['new_arrival'],$nc) ? 'Y' : 'N';
				$clear = in_array($p_row['clearance'],$nc) ? 'Y' : 'N';
				
				/*
				| -----------------------------------------------------------------------
				| New Arrival
				*/
				?>
				<tr  bgcolor="#eeeeee">
					<td class="text" align="right">New Arrival?:</td>
					<td align="left" class="text">
						<input type="radio" name="new_arrival" value="yes" <?php echo in_array($p_row['new_arrival'],$nc) ? 'checked' : ''; ?> onclick="return check_clearance('<?php echo $clear; ?>')" /> Yes &nbsp; 
						<input type="radio" name="new_arrival" value="" <?php echo ( ! in_array($p_row['new_arrival'],$nc)) ? 'checked' : ''; ?> /> No
					</td>
				</tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Clearance
				*/
				?>
				<tr  bgcolor="#eeeeee">
					<td class="text" align="right">Clearance?:</td>
					<td align="left" class="text">
						<input type="radio" name="clearance" value="yes" <?php echo in_array($p_row['clearance'],$nc) ? 'checked' : ''; ?> onclick="return check_new_arrival('<?php echo $new_a; ?>')" /> Yes &nbsp; 
						<input type="radio" name="clearance" value="" <?php echo ( ! in_array($p_row['clearance'],$nc)) ? 'checked' : ''; ?> /> No
					</td>
				</tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Original Product Availability Date (temporarily commented as date is now
				| on a per color stock basis)
				|
                <tr  bgcolor="#eeeeee"> 
					<td align="right" class="text">Product Available Date : </td>
					<td align="left">
						<input name="add_date" id="add_date" class="date-pick" value="<?php echo date('m/d/Y',strtotime($p_row['prod_date']));?>" onblur="check_date_availability('add_date')" />&nbsp;
						<span class="text">(format:mm/dd/yyyy)
						<?php
						if (isset($pre_order) && $pre_order == TRUE)
						{ ?>
							<br />
							<strong>This product is on Pre-Order</strong>
							<?php
						} ?>
						</span>
					</td>
                </tr>
				*/
				?>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| The "Present images color/sizes:" section
				*/
				?>
				<tr bgcolor="#eeeeee"> 
					<td align="right" class="text">Present images color/sizes: </td>
					<td></td>
				</tr>
				
                <tr bgcolor="#eeeeee"> 
					<td align="left" colspan="2">
					<?php
					/*
					| -----------------------------------------------------------------------
					| Present image color/sizes:
					| -----------------------------------------------------------------------
					*/
					?>
				  	<table border="0" width="100%" cellspacing="0">
						<?php
						$getpic = mysql_query(
							"SELECT
								tp.prod_no, tp.prod_id, tp.primary_img_id, tp.colors, tp.cat_id,
								d.folder as designer_folder, 
								subcat.folder AS subcat_folder, 
								ts.size_0, ts.size_2, ts.size_4, ts.size_6, ts.size_8, ts.size_10, ts.size_12, ts.size_14, ts.size_16,ts.size_fs, ts.st_id, ts.color_name AS stock_color_name, ts.color_facets AS stock_color_facets, ts.stock_date, ts.color_publish,
								tcs.color_name AS tcs_color_name, tcs.color_code,
								case cat.cat_id
									when '1'
										then 'WMANSAPREL'
									when '19'
										then 'JWLRYACCSRIES'
									when '22'
										then 'BRIDAL'
									when '23'
										then 'CLRNCE'
									else 'WMANSAPREL'
									end as cat_folder
								FROM
									tbl_product tp
									LEFT JOIN designer d ON d.des_id = tp.designer
									LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
									LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
									LEFT JOIN tbl_stock ts ON ts.prod_no = tp.prod_no
									LEFT JOIN tblcolor tcs ON tcs.color_name = ts.color_name
								WHERE
									tp.prod_no ='".$_REQUEST['prod_no']."'"
						) or die(mysql_error());
						
						$base_site_url = SITE_URL;
						
						/*
						| -----------------------------------------------------------------------
						| The images and size stock section
						*/
						if (@mysql_num_rows($getpic))
						{
							/*
							| -----------------------------------------------------------------------
							| For each color item of the product number based from tbl_stock
							*/
							$i = 1;
							while ($irow = @mysql_fetch_array($getpic))
							{ ?>
								<tr>
								<td class="text">
									<table border="0" cellspacing="0" cellpadding="3" width="400" style="margin-bottom:10px;">
									<?php
										$img_url		 = $base_site_url.'product_assets/'.$irow['cat_folder'].'/'.$irow['designer_folder'].'/'.$irow['subcat_folder'].'/';
										$upload_folder	 = 'product_assets/'.$irow['cat_folder'].'/'.$irow['designer_folder'].'/'.$irow['subcat_folder'].'/';
										
										// If the beginning of it all, there will be only the primary color as tbl_stock record for the prod_no
										// If errors have happened, let the user insert a color again.
										$color_name = ($irow['stock_color_name'] != '') ? trim($irow['stock_color_name']) : '- pls select color -';
										
										// There is an error in color name when data at tbl_product is with trailing whitespaces
										// Circumventing it here using trim()
										$q_color_code = "SELECT color_code FROM tblcolor WHERE color_name = '".trim($color_name)."'";
										$r_color_code = mysql_query($q_color_code) or die('Select color error: '.mysql_error());
										$c_row = mysql_fetch_array($r_color_code);
										$color_code = $c_row['color_code'];
										
										$img_thumb 	     = $img_url.'product_front/'.$irow['prod_no'].'_'.$color_code.'.jpg';
										$img_thumb_back  = $img_url.'product_back/'.$irow['prod_no'].'_'.$color_code.'.jpg';
										$img_thumb_side  = $img_url.'product_side/'.$irow['prod_no'].'_'.$color_code.'.jpg';
										$video			 = $img_url.'product_video/'.$irow['prod_no'].'_'.$color_code.'.flv';
										
										$imgchecked = $color_code == $p_row['primary_img_id'] ? 'checked' : '';
										//echo '>>'.$img_thumb; // ---> for debuggin purposes
										
										/*
										| -----------------------------------------------------------------------
										| COLOR [delete][edit stock]			<> Primary Image
										*/
										?>
										<tr style="background:#ddd;">
											<td colspan="4">
												<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="200">
														<?php
														if (mysql_num_rows($getpic) >  1 && $irow['stock_color_name'] != '' && $imgchecked != 'checked')
														{
															$java01 = "return confirm_del()";
														}
														else
														{
															$java01 = "return del_primary_alert()";
														}
														/*
														| -----------------------------------------------------------------------
														| Color Name [delete] [edit stock] [publish]
														*/
														?>
														<strong><?php echo strtoupper($color_name); ?></strong>
														<br />
														[<a href="edit_new_par_product.php?act=del_stock&prod_no=<?=$prod_no?>&color=<?=$irow['stock_color_name']?>" onclick="<?php echo $java01; ?>">delete</a>]&nbsp;[<a href="edit_stock.php?<?=$_SERVER['QUERY_STRING']?>&st_id=<?=$irow['st_id']?>">edit&nbsp;stock</a>] [<a href="edit_new_par_product.php?act=color_pub&prod_no=<?=$prod_no?>&color=<?=$irow['stock_color_name']?>&pub=<?php echo $irow['color_publish'] == 'Y' ? 'N' : 'Y'; ?>"><?php echo $irow['color_publish'] == 'Y' ? 'unpublish' : 'publish'; ?></a>]
													</td>
													<td>
														<?php
														/*
														| -----------------------------------------------------------------------
														| <> Primary Image			[publish color mode notification]
														*/
														?>
														<input type="radio" name="primary_img_id" value="<?=$color_code?>" <?=$imgchecked?> /> Primary Image
														<br />
														<?php
														// Added publish color mode notification
														if ($irow['color_publish'] == 'N')
														{ ?>
															&nbsp;<span style="color:red;">This color is NOT published.</span>
															<?php
														}
														else echo '&nbsp;'; ?>
													</td>
												</tr>
												</table>
											</td>
										</tr>
										<?php
										/*
										| -----------------------------------------------------------------------
										| Images area
										*/
										?>
										<tr style="background:#ddd;">
											<td width="70">                                
											<?php
											if($img = @GetImageSize($img_thumb)) {
												?> Front<br /> <img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?php echo $img_thumb;?>" width=63> <?php
											}
											else echo 'Front<br />Image';
											?>                                </td>
										<td width="70">                                
											<?php
											if($img = @GetImageSize($img_thumb_back)) {
												?> Back<br /><img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?php echo $img_thumb_back;?>" width=63> <?php
											}
											else echo 'Back<br />Image';
											?>                                </td>
										<td width="70">                                
											<?php
											if($img = @GetImageSize($img_thumb_side)) {
												?> Side<br /><img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?php echo $img_thumb_side;?>" width=63> <?php
											}
											else echo 'Side<br />Image';
											?>                                </td>
										<td width="70">                                
											<?php
											if($img = @GetImageSize($video)) {
												?> Video<br /><img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?=$base_site_url?>'images/instylelnylogo.jpg'" width=63> <?php
											}
											else echo 'Video';
											?>                                </td>
										</tr>
										<?php
										/*
										| -----------------------------------------------------------------------
										| Size and stocks area
										*/
										?>
										<tr style="background:#ddd;"><td colspan="4" style="font-size:10px;">
											<table width="100%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;border:1px solid #999;">
												<tr style="background:#ddd;">
													<?php
													if ($irow['cat_id'] != '19')
													{ ?>
														<td>Size 0</td>
														<td>Size 2</td>
														<td>Size 4</td>
														<td>Size 6</td>
														<td>Size 8</td>
														<td>Size 10</td>
														<td>Size 12 </td>
														<td>Size 14</td>
														<td>Size 16</td>
													<?php
													}
													else
													{ ?>
														<td>Stock</td>
														<?php
													} ?>
												</tr>
												<tr>
													<?php
													if ($irow['cat_id'] != '19')
													{ ?>
														<td style="font-weight:bold;"><?=$irow['size_0']?></td>
														<td style="font-weight:bold;"><?=$irow['size_2']?></td>
														<td style="font-weight:bold;"><?=$irow['size_4']?></td>
														<td style="font-weight:bold;"><?=$irow['size_6']?></td>
														<td style="font-weight:bold;"><?=$irow['size_8']?></td>
														<td style="font-weight:bold;"><?=$irow['size_10']?></td>
														<td style="font-weight:bold;"><?=$irow['size_12']?></td>
														<td style="font-weight:bold;"><?=$irow['size_14']?></td>
														<td style="font-weight:bold;"><?=$irow['size_16']?></td>                                  
													<?php
													}
													else
													{ ?>
														<td style="font-weight:bold;"><?=$irow['size_0']?></td>
														<?php
													} ?>
												</tr>
											</table>
										</td></tr>
										<tr><td colspan="4" style="border:1px solid #ddd;">
											<?php
											/*
											| -----------------------------------------------------------------------
											| Availability Date
											| 
											| NOTES:
											| 1.0 present and past dates are open to sell
											| 2.0 future dates are for PRE-ORDER
											*/
											$exp_now = explode('/',date('m/d/Y',time()));
											$time_now = mktime(0,0,0,$exp_now[0],$exp_now[1],$exp_now[2]);
											if ($irow['stock_date'] != '' && $irow['stock_date'] != NULL)
												$time_db = strtotime($irow['stock_date']);
											else $time_db = '';
											if ($time_db > $time_now) $pre_order = TRUE;
											else $pre_order = '';
											?>
											
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr bgcolor="#eeeeee">
													<td align="right" class="text" style="padding:5px 0;">Available Date: </td>
													<td align="left" style="padding:5px 0;">
														<input name="add_date_<?php echo strtolower(str_replace(' ','_',trim($irow['stock_color_name']))); ?>" id="add_date_<?php echo strtolower(str_replace(' ','_',trim($irow['stock_color_name']))).$pre_order; ?>" class="date-pick" value="<?php echo $irow['stock_date']; ?>" onblur="check_date_availability('add_date_<?php echo strtolower(str_replace(' ','_',trim($irow['stock_color_name']))).$pre_order; ?>')" />&nbsp;
														<span class="text">(format:mm/dd/yyyy)
														</span>
													</td>
												</tr>
												<?php
												if (isset($pre_order) && $pre_order == TRUE)
												{ ?>
													<tr bgcolor="#ddd">
														<td colspan="2" align="center" style="padding:5px 0;">
															<strong>This product is on Pre-Order</strong>
														</td>
													</tr>
													<?php
													unset($pre_order);
												} ?>
											</table>
										</td></tr>
									</table>
								</td>
								<?php
								/*
								| -----------------------------------------------------------------------
								| The color alliasing (facet) section on a per image color area
								*/
								?>
								<td class="text" style="background:white;padding: 0 0 0 20px;">
									<div class="text"><b>COLORS FACET :</b></div>
									<?php
									$get_colors = @mysql_query("select * from `tblcolors` WHERE heading_id = '".$cat."' order by color_name");
									if (@mysql_num_rows($get_colors) > 0)
									{
										while ($crow = @mysql_fetch_array($get_colors))
										{ ?>
											<div class="text" style="width:130px;float:left;">
												<?php
												$clr_name_1 = strlen($crow['color_name']) == 3 ? $crow['color_name'].'1' : $crow['color_name'];
												$checked = in_array(strtoupper($clr_name_1),explode('-',strtoupper($irow['stock_color_facets']))) ? 'checked="checked"' : '' ;
												$clr_value = strlen($crow['color_name']) == 3 ? $crow['color_name'].'1' : $crow['color_name'];
												?>
												<input type="checkbox" name="color_id1[<?php echo $irow['stock_color_name']; ?>][]" value="<?=$clr_value?>" <?php echo $checked; ?> /><?=$crow['color_name']?>
											</div>
											<?php
										} ?>
										<div style="clear:both;"></div>
										<?php
									}
									?>
								</td>
								</tr>
								<?php
								$i++;
							}
						}
						?>       
					</table>
					</td>
				</tr>
                <tr bgcolor="#eeeeee">
					<td></td>
					<?php
					/*
					| -----------------------------------------------------------------------
					| Add Product Images (new or edit)
					| -----------------------------------------------------------------------
					*/
					?>
					<td class="text">
						<b>Add Product Images</b> for any of above current colors or new colors
						<br />
						[ Skip if no need to add more or edit product images/colors ]<br />
						<table border="0" cellspacing="0" style="background:#ccc;border:1px solid #999999;">
                            <tr><td class="text" align="right">Select color : </td>
                            <td>
                            <?php
							$get_color = @mysql_query("select * from `tblcolor` order by color_name");
							if(@mysql_num_rows($get_color)>0) {
								?> <select name="color_name" style="font-size:11px;"> <option value=""> - select color - </option> <?php
								while($crow = @mysql_fetch_array($get_color)) {
									?>
                                    <option value="<?=$crow['color_name']?>" ><?=$crow['color_name']?> - <?=$crow['color_code']?></option>
                                    <?
								}
								?> </select> <?php
							}
							?>
                            <input type="hidden" name="folder" value="../<?=$upload_folder?>" />                            </td></tr>
                            <tr> 
                              <td width="100" align="right" class="text">Front Image : </td>
                              <td align="left" class="error"><input type="file" name="front_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                            </tr>
                            <tr> 
                              <td align="right" class="text">Back Image : </td>
                              <td align="left" class="error"><input type="file" name="back_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                            </tr>
                             <tr> 
                              <td align="right" class="text">Side Image : </td>
                              <td align="left" class="error"><input type="file" name="side_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                            </tr>
                            <tr> 
                              <td align="right" class="text">Color Icon Image : </td>
                              <td align="left" class="error"><input type="file" name="icon_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 40 px x 40 px</td>
                            </tr>
                             <tr> 
                              <td align="right" class="text">Runway Video : </td>
                              <td align="left" class="error"><input type="file" name="video_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;video must be minimum 327 px x 589 px</td>
                            </tr>
                            <tr>
                            <td class="text" align="right">Stock : </td>
                            <td>
                            <table width="100%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;border:1px solid #999;">
								<tr>
									<?php
									if ($p_row['cat_id'] != '19')
									{ ?>
										<td>Size 0</td>
										<td>Size 2</td>
										<td>Size 4</td>
										<td>Size 6</td>
										<td>Size 8</td>
										<td>Size 10</td>
										<td>Size 12 </td>
										<td>Size 14</td>
										<td>Size 16</td>										
										<?php
									}
									else
									{ ?>
										<td>Qty</td>
										<?php
									} ?>
								</tr>
								<tr>
									<?php
									if ($p_row['cat_id'] != '19')
									{ ?>
										<td><input type="text" name="size_0" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_2" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_4" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_6" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_8" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_10" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_12" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_14" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_16" style="width:30px;" maxlength="4" /></td>
										<?php
									}
									else
									{ ?>
										<td><input type="text" name="size_0" style="width:30px;" maxlength="4" /></td>
										<?php
									} ?>
								</tr>
                            </table>                            </td></tr>
						</table>
					</td>
                </tr>
                
				<?php
				/*
				| -----------------------------------------------------------------------
				| Sale Price (csv catalogue price)
				*/
				?>
				<tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Our sale price : </td>
                  <td align="left"><input type="text" name="catalogue_price" class="inputbox" value="<? echo @$p_row['catalogue_price'];?>"></td>
                </tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Retail Price (csv retail price)
				*/
				?>
				<tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Retail price : </td>
                  <td align="left"><input type="text" name="less_discount" class="inputbox" value="<? echo @$p_row['less_discount'];?>"></td>
                </tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Wholesale Price (csv wholesale price)
				*/
				?>
				<tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Wholesale price : </td>
                  <td align="left"><input type="text" name="wholesale_price" class="inputbox" value="<? echo @$p_row['wholesale_price'];?>"></td>
                </tr>
				
				<!--<tr bgcolor="#eeeeee"> 
                  <td class="text" align="right">Shipping Cost : </td>
                  <td align="left"><input type="text" name="shipping_cost" class="inputbox" value="<? echo @$p_row['shipping_cost'];?>"></td>
                </tr>-->
				<tr bgcolor="#eeeeee">
					<td class="text" align="right">Description : </td>
						<td align="left">
							<textarea name="prod_desc" rows="5" cols="40"><? echo @$p_row['prod_desc'];?></textarea>						</td>
				</tr>
				
				<tr>
				<td colspan="2">
					<br />
				</td>
				</tr>
				
				<?php
				/*
				| -----------------------------------------------------------------------
				| Faceting Area
				| -----------------------------------------------------------------------
				*/
				/*
				| -----------------------------------------------------------------------
				| The STYLES Facets
				*/
				?>
				<tr>
				<td colspan="2">
					<div class="text"><b>STYLES FACET :</b></div>
					<?php
					$get_style = @mysql_query("select * from `tblstyle` WHERE heading_id = '".$cat."' order by style_name");
					if (@mysql_num_rows($get_style) > 0)
					{
						while ($crow = @mysql_fetch_array($get_style))
						{ ?>
							<div class="text" style="width:130px;float:left;">
								<?php
								$style_name_1 = strlen($crow['style_name']) == 3 ? $crow['style_name'].'1' : $crow['style_name'];
								if (stristr($p_row['styles'],$style_name_1) != '')
								{ ?>
									<input type="checkbox" name="style_id1[]" value="<?=$style_name_1?>" checked="checked" /> <?=$crow['style_name']?>
									<?php
								}
								else
								{ ?>
									<input type="checkbox" name="style_id1[]" value="<?=$style_name_1?>"/> <?=$crow['style_name']?>
									<?php
								} ?>
							</div>
							<?php
						} ?>
						<div style="clear:left;"></div>
						<?php
					} ?>
				<br />
				</td>
				</tr>
				
				<?php
				if ($cat == '1')
				{
					/*
					| -----------------------------------------------------------------------
					| The EVENTS Facets (only for apparels)
					*/
					?>
					<tr>
					<td colspan="2">
						<div class="text"><b>EVENTS FACET:</b></div>
						<?php
						$get_event = @mysql_query("select * from `tblevent` WHERE heading_id = '".$cat."'  order by event_name");
						if (@mysql_num_rows($get_event) > 0)
						{
							while ($crow = @mysql_fetch_array($get_event))
							{ ?>
								<div class="text" style="width:130px;float:left;">
									<?php
									$event_name_1 = strlen($crow['event_name']) == 3 ? $crow['event_name'].'1' : $crow['event_name'];
									if (stristr($p_row['events'],$event_name_1) != '')
									{ ?>
										<input type="checkbox" name="event_id1[]" value="<?=$event_name_1?>" checked="checked" /> <?=$crow['event_name']?>
										<?php
									}
									else
									{ ?>
										<input type="checkbox" name="event_id1[]" value="<?=$event_name_1?>" /> <?=$crow['event_name']?>
										<?php
									} ?>
								</div>
								<?php
							} ?>
							<div style="clear:left;"></div> <?php
						} ?>
					<br />
					</td>
					</tr>
					<?php
				}

				if ($cat == '19')
				{
					/*
					| -----------------------------------------------------------------------
					| The EVENTS Facets (only for apparels)
					*/
					?>
					<tr>
					<td colspan="2">
						<div class="text"><b>MATERIALS FACET:</b></div>
						<?php
						$get_material = @mysql_query("select * from `tblmaterial` WHERE heading_id = '".$cat."'  order by material_name");
						if (@mysql_num_rows($get_material) > 0)
						{
							while ($crow = @mysql_fetch_array($get_material))
							{ ?>
								<div class="text" style="width:130px;float:left;">
									<?php
									$material_name_1 = strlen($crow['material_name']) == 3 ? $crow['material_name'].'1' : $crow['material_name'];
									if (stristr($p_row['materials'],$material_name_1) != '')
									{ ?>
										<input type="checkbox" name="material_id1[]" value="<?=$material_name_1?>" checked="checked" /> <?=$crow['material_name']?>
										<?php
									}
									else
									{ ?>
										<input type="checkbox" name="material_id1[]" value="<?=$material_name_1?>" /> <?=$crow['material_name']?>
										<?php
									} ?>
								</div>
								<?php
							} ?>
							<div style="clear:left;"></div>
							<?php
						} ?>
					<br />
					</td>
					</tr>
					
					<?php
					/*
					| -----------------------------------------------------------------------
					| The TERNDS Facets (only for accessories)
					*/
					?>
					<tr>
					<td colspan="2">
						<div class="text"><b>TRENDS FACET:</b></div>
						<?php
						$get_trend = @mysql_query("select * from `tbltrend` WHERE heading_id = '".$cat."'  order by trend_name");
						if (@mysql_num_rows($get_trend) > 0)
						{
							while ($crow = @mysql_fetch_array($get_trend))
							{ ?>
								<div class="text" style="width:130px;float:left;">
									<?php
									$trend_name_1 = strlen($crow['trend_name']) == 3 ? $crow['trend_name'].'1' : $crow['trend_name'];
									if (stristr($p_row['trends'],$trend_name_1) != '')
									{ ?>
										<input type="checkbox" name="trend_id1[]" value="<?=$trend_name_1?>" checked="checked" /> <?=$crow['trend_name']?>
										<?php
									}
									else
									{ ?>
										<input type="checkbox" name="trend_id1[]" value="<?=$trend_name_1?>" /> <?=$crow['trend_name']?>
										<?php
									} ?>
								</div>
								<?php
							} ?>
							<div style="clear:left;"></div>
							<?php
						} ?>
					<br />
					</td>
					</tr>
				<?php
				} ?>
				
                <tr bgcolor="#eeeeee">
						<td  colspan="2" class="error" align="center">
                        NOTE :Please Upload Image with name &lt;style number&gt;_&lt;color code&gt;.jpg <br />
                        <?php if($p_row['primary_img_id']!=''){?>
                        For Ex : <?=$p_row['prod_no']?>_&lt;color_code&gt;.jpg
                        <?php }else{ ?>
                        For Ex : <?=$p_row['prod_no']?>_&lt;color_code&gt;.jpg
                        <?php } ?>										</td>
				</tr>
                <input type="hidden" name="prod_id" value="<? echo $p_row['prod_id'];?>">
                <tr bgcolor="#eeeeee">
					<td colspan="2" align="center">
						<input type="submit" name="cmd_cat_submit" class="button" value="Update">
						<input type="button" name="cmd_cat_cancel" class="button" value="Cancel" onClick="back_display();">
					</td>
                </tr>
			</table>
			  
	  </td></tr>
		</table>
		</form>
		<!--eof form=============================================================================-->

      <? }?>
 <!--Close for Edit Product..**************************************-->
 
 <!--This part for Delete Product..**************************************-->
     <? if($mode=="d"){?>

		<!--bof form=============================================================================-->
          <form name="prod_del_frm" method="post" action="edit_new_par_product.php?act=del&cat_id=<?=$_GET['cat_id']?>&des_id=<?=$_GET['des_id']?>&subcat_id=<?=$_GET['subcat_id']?>" enctype="MULTIPART/FORM-data">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top" class="bodytext">
					<td class="text">
						<table border="0" cellpadding="5" cellspacing="1" width=100%>
                <tr bgcolor="#eeeeee"> 
                  <td width="30%" align="right">Category name : </td>
                  <td width="70%" align="left"> 
                    <? get_catname($cat);?>
                  </td>
                </tr>
                
                <tr bgcolor="#eeeeee"> 
                  <td align="right">Product name : </td>
                  <td align="left"><? echo $p_row['prod_name'];?></td>
                </tr>
                
                <input type="hidden" name="prod_no" value="<? echo $p_row['prod_no'];?>">
                <input type="hidden" name="prod_id" value="<? echo $p_row['prod_id'];?>">
                <input type="hidden" name="image_name" value="<? echo $p_row['prod_image'];?>">
                <tr bgcolor="#eeeeee"> 
                  <td colspan=2 align=center> <span style="color:#FF0000; font-weight:bold">Do 
                    you want to delete?<br>
                    &nbsp;<br>
                    </span> <input type="submit" name="cmd_prod_del" class="button" value="Yes"> 
                    <input type="button" name="cmd_prod_cancel" class="button" value="No" onClick="back_display();"> 
                  </td>
                </tr>
              </table>
					</td>
				</tr>
			</table>
          </form>
		<!--eof form=============================================================================-->

      <? }?>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>