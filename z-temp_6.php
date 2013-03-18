<?php
	/*
	| ----------------------------------------------------------
	| THUMB CREATION SCRIPT
	| ----------------------------------------------------------
	| A script to creat thumbs for all images at product_assets folder.
	| This is help in reducing CPU usage.
	| The res.php reads
	| large high quality image and resample it for display.
	| Instead of reading and displaying, we will save the resampled images for use.
	|
	| Save resampled images /thumbs folder of the view folder using below file name structure.
	|
	|	thumbs list page (size = 140 x 210) - <prod-no>_<clr-code>_1
	|		$new_w_1 = 140;
	|		$new_h_1 = 210;
	|
	|	small image product details page (size = 60 x 90) - <prod-no>_<clr-code>_2
	|		$new_w_2 = 60;
	|		$new_h_2 = 90;
	|
	|	view page image product details page (size = 340 x 510) - <prod-no>_<clr-code>_3
	|		$new_w_3 = 340;
	|		$new_h_3 = 510;
	|
	| Retaining large image for cloud zoom getting the actual file on
	| respective products folder
	|
	*/
	include("common.php");
	
	// get all prod_no of a certain designer, category, and subcategory
	$designer_ary = array('basix-black-label', 'issuenewyork', 'jewelry-accessories', 'olavida'); // ---> jewelry is alexa
	$category_ary = array('apparel', 'jewelry');
	$subcat_ary = array('cocktail-dresses', 'evening-dresses', 'skirts', 'shorts', 'jumpsuits', 'tops', 'swimwear', 'bracelets', 'rings', 'pins');
	$designer = $designer_ary[2];
	$category = $category_ary[1];
	$subcategory = $subcat_ary[7];

	$qry1 = "
		SELECT
			p.prod_id, p.prod_no, p.primary_img_id, p.colors, 
			p.cat_id, p.subcat_id, p.designer,
	 
			d.designer, d.folder AS d_folder, d.des_id, d.url_structure AS d_url_structure,
			
			c.folder AS cat_folder, c.cat_name, c.url_structure AS c_url_structure,
			
			sc.folder AS subcat_folder, sc.subcat_name, sc.url_structure AS sc_url_structure, 
			
			tc.color_name, tc.color_code
		FROM
			tbl_product p
			LEFT JOIN tblcat c ON c.cat_id = p.cat_id
			LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			LEFT JOIN designer d ON d.des_id = p.designer
			LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
			LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
		WHERE 
			p.view_status = 'Y'
			AND sc.url_structure = '".$subcategory."'
			AND d.url_structure = '".$designer."'
			AND (
				p.clearance = 'Yes' 
				OR p.clearance = 'yes' 
				OR p.clearance = 'y' 
				OR p.clearance = 'Y' 
				OR p.clearance = 'clearance'
				OR p.clearance = 'Clearance'
			)
		ORDER BY prod_no ASC
		LIMIT 0, 21
	";
	$res1 = mysql_query($qry1) or die('Query 1 error: '.mysql_error());
	
	// process each prod_no
	if (mysql_num_rows($res1))
	{
		echo mysql_num_rows($res1).'<br />';
		
		$i = 1;
		$iii = 0;
		while ($row1 = mysql_fetch_array($res1))
		{
			echo $i.', '.$row1['prod_no'].'<br />';
			// get available colors of the prod_no
			$qry2 = "
				SELECT
					tp.prod_id, tp.prod_no, col.color_code, col.color_name,
					c.folder AS c_folder, c.url_structure AS c_url_structure, sc.folder AS sc_folder,
					sc.subcat_name, d.folder AS des_folder, d.des_id,
					tp.subcat_id, d.url_structure as d_url_structure, sc.url_structure as sc_url_structure,
					ts.color_publish
				FROM
					tbl_product tp
					JOIN tblcat c ON c.cat_id = tp.cat_id
					JOIN tblsubcat sc ON sc.subcat_id = tp.subcat_id
					JOIN designer d ON d.des_id = tp.designer
					JOIN tbl_stock ts ON ts.prod_no = tp.prod_no
					JOIN tblcolor col ON col.color_name = ts.color_name
				WHERE
					tp.prod_no = '".$row1['prod_no']."'
					AND ts.color_publish = 'Y'
			";
			$res2 = mysql_query($qry2) or die('Query 2 error: '.mysql_error());
			
			// process each available color
			if (mysql_num_rows($res2))
			{
				$ii = 0;
				$clr = '';
				while ($row2 = mysql_fetch_array($res2))
				{
					$iii++;
					$img_path = 'product_assets/'.$row1['cat_folder'].'/'.$row1['d_folder'].'/'.$row1['subcat_folder'].'/';
					$img_name = $row1['prod_no'].'_'.$row2['color_code'];
					
						$folder_views = array('front', 'side', 'back');
						
					foreach ($folder_views as $folder_view)
					{
						/*
						echo $folder_view.'<br />';
						echo $img_path.'<br />';
						echo $img_name.'<br />';
						echo $img_path.'product_'.$folder_view.'/'.$img_name.'.jpg';
						die();
						*/
						
						if ($img_info = @GetImageSize($img_path.'product_'.$folder_view.'/'.$img_name.'.jpg'))
						{
							go_and_resample($img_info, $folder_view, $img_path, $img_name);
						}
					}
					
					// break the referrence with the last element
					unset($folder_view);
					
					$ii++;
					$clr .= $row2['color_name'].', ';
				}
			}
			
			$i++;
			echo ' &nbsp; &nbsp; &nbsp; '.$ii.' - '.$clr.'<br />';
		}
	}
	
	echo $iii.' - ';

	//if ($img = @GetImageSize($img_path.'product_front/'.$img_name.'.jpg'))
	function go_and_resample($img, $view, $img_path, $img_name)
	{
		// add subfolder where necessary
		if ( ! file_exists($img_path.'product_'.$view.'/thumbs'))
		{
			$old = umask(0);
			if ( ! mkdir($img_path.'product_'.$view.'/thumbs', 0777, TRUE)) die('Unable to create "'.$img_path.'product_'.$view.'/thumbs'.'" folder.');
			umask($old);
		}
		
		// add subfolder where necessary at the repository
		if ( ! file_exists('../products/'.$img_path.'product_'.$view.'/thumbs'))
		{
			$old = umask(0);
			if ( ! mkdir('../products/'.$img_path.'product_'.$view.'/thumbs', 0777, TRUE)) die('Unable to create "'.'../products/'.$img_path.'product_'.$view.'/thumbs'.'" folder.');
			umask($old);
		}
		
		// image width
		$w = $img[0];
		// image height
		$h = $img[1];
		
		// new images size as per thumb
		$new_w_1 = 140;
		$new_h_1 = 210;
		$new_w_2 = 60;
		$new_h_2 = 90;
		$new_w_3 = 340;
		$new_h_3 = 510;
		
		$im = @ImageCreateFromJPEG($img_path.'product_'.$view.'/'.$img_name.'.jpg'); // Read JPEG Image
		
		if ( ! $im) echo ' [Uh oh] ';
		
		// thumb_1
		if ( ! file_exists($img_path.'product_'.$view.'/thumbs/'.$img_name.'_1'.'.jpg'))
		{
			// Create the resized image destination
			$thumb = @ImageCreateTrueColor ($new_w_1, $new_h_1);
			// Copy from image source, resize it, and paste to image destination
			@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_1, $new_h_1, $w, $h);
			// save resized image
			@ImageJPEG ($thumb,$img_path.'product_'.$view.'/thumbs/'.$img_name.'_1'.'.jpg',100);
		}

			// at the repository
			if ( ! file_exists('../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_1'.'.jpg'))
			{
				// Create the resized image destination
				$thumb = @ImageCreateTrueColor ($new_w_1, $new_h_1);
				// Copy from image source, resize it, and paste to image destination
				@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_1, $new_h_1, $w, $h);
				// save resized image
				@ImageJPEG ($thumb,'../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_1'.'.jpg',100);
			}
			
		// thumb_2
		if ( ! file_exists($img_path.'product_'.$view.'/thumbs/'.$img_name.'_2'.'.jpg'))
		{
			// Create the resized image destination
			$thumb = @ImageCreateTrueColor ($new_w_2, $new_h_2);
			// Copy from image source, resize it, and paste to image destination
			@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_2, $new_h_2, $w, $h);
			// save resized image
			@ImageJPEG ($thumb,$img_path.'product_'.$view.'/thumbs/'.$img_name.'_2'.'.jpg',100);
		}
		
			// at the repository
			if ( ! file_exists('../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_2'.'.jpg'))
			{
				// Create the resized image destination
				$thumb = @ImageCreateTrueColor ($new_w_2, $new_h_2);
				// Copy from image source, resize it, and paste to image destination
				@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_2, $new_h_2, $w, $h);
				// save resized image
				@ImageJPEG ($thumb,'../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_2'.'.jpg',100);
			}
		
		// thumb_3
		if ( ! file_exists($img_path.'product_'.$view.'/thumbs/'.$img_name.'_3'.'.jpg'))
		{
			// Create the resized image destination
			$thumb = @ImageCreateTrueColor ($new_w_3, $new_h_3);
			// Copy from image source, resize it, and paste to image destination
			@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_3, $new_h_3, $w, $h);
			// save resized image
			@ImageJPEG ($thumb,$img_path.'product_'.$view.'/thumbs/'.$img_name.'_3'.'.jpg',100);
		}
		
			// at the repository
			if ( ! file_exists('../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_3'.'.jpg'))
			{
				// Create the resized image destination
				$thumb = @ImageCreateTrueColor ($new_w_3, $new_h_3);
				// Copy from image source, resize it, and paste to image destination
				@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $new_w_3, $new_h_3, $w, $h);
				// save resized image
				@ImageJPEG ($thumb,'../products/'.$img_path.'product_'.$view.'/thumbs/'.$img_name.'_3'.'.jpg',100);
			}
		
	}
	
	//echo '<img src="'.$img_path.'product_front/thumbs/'.$img_name.'_1'.'.jpg'.'" />';
	//echo '<img src="'.$img_path.'product_front/thumbs/'.$img_name.'_2'.'.jpg'.'" />';
	//echo '<img src="'.$img_path.'product_front/thumbs/'.$img_name.'_3'.'.jpg'.'" />';
	
	echo 'DONE!';
	
	// testing