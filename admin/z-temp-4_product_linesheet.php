<?php
	/*
	| ----------------------------------------------------------
	| Product Line Sheet for Basix Sales Staff
	| ----------------------------------------------------------
	|
	*/

	/*
	| ----------------------------------------------------------
	| FILE CREATION
	| ----------------------------------------------------------
	| A script to creat flyer files for sales to send to clients
	| 1 email
	| Single to Multiple Files attached
	| With price list for items in the sell sheet
	| Contents on the comment box
	|
	| Save sell sheet images at designer/subcat/prodcut_linesheet folder
	|
	|	linesheet (size = 830 x 680) - <prod-no>_<clr-code>_1
	|		283 x 29 Basix logo (encompassed in a header with height of 50)
	|		400 x 600 per view
	|		2 views (front and back/side)
	|
	|		over all image dimension
	|		$new_w_1 = 830;
	|		$new_h_1 = 680;
	|
	*/
	include("../common.php");
	//error_reporting(E_ALL);
	
	// get all prod_no of a certain designer, category, and subcategory
	$designer_ary = array('basix-black-label');
	$category_ary = array('apparel');
	$subcat_ary = array('cocktail-dresses', 'evening-dresses', 'skirts', 'shorts', 'jumpsuits', 'tops', 'swimwear', 'jackets', 'pants', 'tops');
	$designer = $designer_ary[0];
	$category = $category_ary[0];
	$subcategory = $subcat_ary[9];
	
	$sel1 = "
		SELECT
			p.prod_id, p.prod_no, p.primary_img_id, p.colors, 
			p.cat_id, p.subcat_id, p.designer,
	 
			d.designer, d.folder AS d_folder, d.des_id, d.url_structure AS d_url_structure,
			
			c.folder AS cat_folder, c.cat_name, c.url_structure AS c_url_structure,
			
			sc.folder AS subcat_folder, sc.subcat_name, sc.url_structure AS sc_url_structure, 
			
			tc.color_name, tc.color_code,
			
			ts.color_publish
		FROM
			tbl_product p
			LEFT JOIN tblcat c ON c.cat_id = p.cat_id
			LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			LEFT JOIN designer d ON d.des_id = p.designer
			LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
			LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
		WHERE 
			(p.view_status = 'Y' OR p.view_status = 'Y1' OR p.view_status = 'Y2')
			AND ts.color_publish = 'Y'
			AND sc.url_structure = '".$subcategory."'
			AND d.url_structure = '".$designer."'
		ORDER BY prod_no ASC
		LIMIT 0, 41
	";
	$res1 = mysql_query($sel1) or die('Query 1 error: '.mysql_error());
	
	$view = '';
	if (mysql_num_rows($res1) > 0)
	{
		echo mysql_num_rows($res1).'<br />';
		
		while ($row1 = mysql_fetch_array($res1))
		{
			// the paths
			$img_path = 'product_assets/'.$row1['cat_folder'].'/'.$row1['d_folder'].'/'.$row1['subcat_folder'].'/';
			$img_name = $row1['prod_no'].'_'.$row1['color_code'];
			
			/*
			echo $img_path.'<br />';
			echo $img_name.'<br />';
			*/
			
			// create linesheet
			if ($img_info = GetImageSize('../'.$img_path.'product_front/'.$img_name.'.jpg'))
			{
				create_linesheet($img_info, $row1['prod_no'], $img_path, $img_name);
			}
			
			echo '<div style="display:inline;float:left;margin-right:10px;">';
			echo $img_name.'<br />';
			echo '<img src="../'.$img_path.'product_linesheet/'.$img_name.'.jpg" height="140" />';
			echo '</div>';
		}
	}
	else echo 'No data';
	
	function create_linesheet($img_info, $prod_no, $img_path, $img_name)
	{
		// add subfolder where necessary
		if ( ! file_exists('../'.$img_path.'product_linesheet'))
		{
			$old = umask(0);
			if ( ! mkdir('../'.$img_path.'product_linesheet', 0777, TRUE)) die('Unable to create "'.'../'.$img_path.'product_linesheet'.'" folder.');
			umask($old);
		}
		
		// add subfolder where necessary at the repository
		if ( ! file_exists('../../products/'.$img_path.'product_linesheet'))
		{
			$old = umask(0);
			if ( ! mkdir('../../products/'.$img_path.'product_linesheet', 0777, TRUE)) die('Unable to create "'.'../../products/'.$img_path.'product_linesheet'.'" folder.');
			umask($old);
		}
		
		// Create image instances
		$src = imagecreatefromjpeg('../images/basix_logo.jpg'); // --> logo
		$dest = imagecreatetruecolor(830, 680); // --> backdrop

		// Copy basix logo at top left portion of image backdrop
		imagecopy($dest, $src, 10, 20, 0, 0, 283, 29);

		// save image linesheet (1st temp)
		imagejpeg($dest, '../'.$img_path.'0001.jpg', 100);

		// free up memmory
		imagedestroy($dest);
		imagedestroy($src);

		// resample front and back/side and save in temp files
		$w = $img_info[0];
		$h = $img_info[1];
		$src = imagecreatefromjpeg('../'.$img_path.'product_front/'.$img_name.'.jpg');
		$dest = imagecreatetruecolor(400, 600);
		imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
		imagejpeg($dest, '../'.$img_path.'front.jpg', 100);
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
		imagejpeg($dest, '../'.$img_path.'back.jpg', 100);
		imagedestroy($dest);
		imagedestroy($src);

		// paste front and back temp files on linesheet image (2nd temp)
		$src = imagecreatefromjpeg('../'.$img_path.'front.jpg');
		$dest = imagecreatefromjpeg('../'.$img_path.'0001.jpg');
		imagecopy($dest, $src, 10, 70, 0, 0, 400, 600);
		imagejpeg($dest, '../'.$img_path.'0002.jpg', 100);
		imagedestroy($dest);
		imagedestroy($src);

		$src = imagecreatefromjpeg('../'.$img_path.'back.jpg');
		$dest = imagecreatefromjpeg('../'.$img_path.'0002.jpg');
		imagecopy($dest, $src, 420, 70, 0, 0, 400, 600);
		imagejpeg($dest, '../'.$img_path.'0003.jpg', 100);
		imagedestroy($dest);
		imagedestroy($src);

		// add product number at top right of final linesheet image
		$dest = imagecreatefromjpeg('../'.$img_path.'0003.jpg');
		$text_color = imagecolorallocate($dest, 255, 255, 255);
		imagestring($dest, 4, 700, 30, $prod_no, $text_color);
		imagejpeg($dest, '../'.$img_path.'product_linesheet/'.$img_name.'.jpg', 100);
		
		@copy('../'.$img_path.'product_linesheet/'.$img_name.'.jpg', '../../products/'.$img_path.'product_video/'.$img_name.'.jpg');
		
		imagedestroy($dest);
	}
	
	//echo $view ? $view : '<img src="'.$img_path.'product_linesheet/'.$img_name.'.jpg" /><br />';
	echo '<br style="clear:both;" />DONE';