<?php

	function get_the_designers()
	{
		$sel = "SELECT * FROM designer";
		$qry = mysql_query($sel) or die('Get Designers Error - '.mysql_error());
		
		return $qry;
	}

	function get_the_categories()
	{
		$sel = "SELECT * FROM tblcat";
		$qry = mysql_query($sel) or die('Get Categories Error - '.mysql_error());
		
		return $qry;
	}

	function get_the_subcategories()
	{
		$sel = "SELECT * FROM tblsubcat";
		$qry = mysql_query($sel) or die('Get Subcategories Error - '.mysql_error());
		
		return $qry;
	}

	function get_the_subsubcategories()
	{
		$sel = "SELECT * FROM tblsubsubcat";
		$qry = mysql_query($sel) or die('Get Subcategories Error - '.mysql_error());
		
		return $qry;
	}

	function get_the_colors()
	{
		$sel = "SELECT * FROM tblcolor ORDER BY color_name ASC";
		$qry = mysql_query($sel) or die('Get Colors Error - '.mysql_error());
		
		return $qry;
	}
	
	function check_prod_no($prod_no)
	{
		$sel = "SELECT prod_no FROM tbl_product WHERE prod_no = '".$prod_no."'";
		$qry = mysql_query($sel) or die('Check Prod No error - '.mysql_error());
		
		if (mysql_num_rows($qry) > 0) return TRUE;
		else return FALSE;
	}
	
	function add_product(
		$prod_name, 
		$prod_no, 
		$view_status, 
		$designer, 
		$cat, 
		$subcat, 
		$subsubcat, 
		$add_date, 
		$prod_desc, 
		$catalogue_price, // --> sale price
		$less_discount, // --> retail price
		$primary_img_id, // --> color code
		$new_arrival, 
		$color, // --> color name
		$put_stock
	)
	{
		$ins1 = "
			INSERT INTO tbl_product (
				prod_name, 
				prod_no, 
				view_status,
				designer, 
				cat_id,
				subcat_id, 
				subsubcat_id, 
				prod_date, 
				prod_desc, 
				catalogue_price, 
				less_discount, 
				primary_img_id, 
				new_arrival,
				colors,
				events,
				styles,
				suggestions
			) VALUES (
				'".$prod_name."', 
				'".$prod_no."', 
				'".$view_status."', 
				'".$designer."', 
				'".$cat."', 
				'".$subcat."', 
				'".(int)$subsubcat."', 
				'".$add_date."', 
				'".$prod_desc."', 
				'".(float)$catalogue_price."', 
				'".(float)$less_discount."', 
				'".$primary_img_id."', 
				'".$new_arrival."', 
				'".$color."', 
				'',
				'',
				''
			)
		";
		
		$qry1 = mysql_query($ins1) or die('Add product to local db error:<br />'.mysql_error().'<br /><br />'.$ins1);
		
		// check if to put stock
		$stock_qty = $put_stock === 'yes' ? 30 : 0;
		
		// check if prod_no and color is in stock already by previous or accidental upload
		$sel3 = "SELECT * FROM tbl_stock WHERE prod_no = '".$prod_no."' AND color_name = '".$color."'";
		$qry3 = mysql_query($sel3) or die('Check stock exists error - '.mysql_error());
		
		if (mysql_num_rows($qry3) > 0)
		{
			$ins2 = "
				UPDATE tbl_stock
				SET 
					size_0 = ".(int)$stock_qty.",
					size_2 = ".(int)$stock_qty.",
					size_4 = ".(int)$stock_qty.",
					size_6 = ".(int)$stock_qty.",
					size_8 = ".(int)$stock_qty.",
					size_10 = ".(int)$stock_qty.",
					size_12 = ".(int)$stock_qty.",
					size_14 = ".(int)$stock_qty.",
					size_16 = ".(int)$stock_qty."
				WHERE
					prod_no = '".$prod_no."'
					AND color_name = '".$color."'
			";
		}
		else
		{
			$ins2 = "
				INSERT INTO tbl_stock (
					prod_no, 
					color_name, 
					size_0, size_2, size_4, size_6, size_8, size_10, size_12, size_14, size_16 
				) VALUES (
					'".$prod_no."', 
					'".$color."', 
					".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty.", 
					".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty."
				)
			";
		}
		
		// free up mysql memory
		mysql_free_result($qry3);
		
		$qry2 = mysql_query($ins2) or die('Insert of Update into stock error - '.mysql_error());
		
		return 1;
	}
	
	function add_product_at_designer(
		$prod_name, 
		$prod_no, 
		$view_status, 
		$designer, 
		$cat, 
		$subcat, 
		$subsubcat, 
		$add_date, 
		$prod_desc, 
		$catalogue_price, // --> sale price
		$less_discount, // --> retail price
		$primary_img_id, // --> color code
		$new_arrival, 
		$color, // --> color name
		$put_stock
	)
	{
		if ($_SERVER['SERVER_NAME'] !== 'localhost') // --> 'localhost' is dev environment server, contact project manager if otherwise
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
				
				$ins1 = "
					INSERT INTO tbl_product (
						prod_name, 
						prod_no, 
						view_status,
						designer, 
						cat_id,
						subcat_id, 
						subsubcat_id, 
						prod_date, 
						prod_desc, 
						catalogue_price, 
						less_discount, 
						primary_img_id, 
						new_arrival,
						colors
					) VALUES (
						'".$prod_name."', 
						'".$prod_no."', 
						'".$view_status."', 
						'".$designer."', 
						'".$cat."', 
						'".$subcat."', 
						'".$subsubcat."', 
						'".$add_date."', 
						'".$prod_desc."', 
						'".(float)$catalogue_price."', 
						'".(float)$less_discount."', 
						'".$primary_img_id."', 
						'".$new_arrival."', 
						'".$color."' 
					)
				";
				
				$qry1 = mysql_query($ins1) or die('Add product error - '.mysql_error());
				
				// check if to put stock
				$stock_qty = $put_stock === 'yes' ? 30 : 0;
				
				// check if prod_no and color is in stock already by previous or accidental upload
				$sel3 = "SELECT * FROM tbl_stock WHERE prod_no = '".$prod_no."' AND color_name = '".$color."'";
				$qry3 = mysql_query($sel3) or die('Check stock exists error - '.mysql_error());
				
				if (mysql_num_rows($qry3) > 0)
				{
					$ins2 = "
						UPDATE tbl_stock
						SET 
							size_0 = ".(int)$stock_qty.",
							size_2 = ".(int)$stock_qty.",
							size_4 = ".(int)$stock_qty.",
							size_6 = ".(int)$stock_qty.",
							size_8 = ".(int)$stock_qty.",
							size_10 = ".(int)$stock_qty.",
							size_12 = ".(int)$stock_qty.",
							size_14 = ".(int)$stock_qty.",
							size_16 = ".(int)$stock_qty."
						WHERE
							prod_no = '".$prod_no."'
							AND color_name = '".$color."'
					";
				}
				else
				{
					$ins2 = "
						INSERT INTO tbl_stock (
							prod_no, 
							color_name, 
							size_0, size_2, size_4, size_6, size_8, size_10, size_12, size_14, size_16 
						) VALUES (
							'".$prod_no."', 
							'".$color."', 
							".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty.", 
							".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty.", ".(int)$stock_qty."
						)
					";
				}
				
				// free up mysql memory
				mysql_free_result($qry3);
				
				$qry2 = mysql_query($ins2) or die('Insert of Update into stock error - '.mysql_error());
				
				// close remote db connection
				mysql_close($conn);
			}
		}
		
		return 1;
	}
	
	function load_jscript()
	{
		$jscript = '
			<link type="text/css" href="js/datePicker.css" rel="stylesheet" />
			<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
			<script type="text/javascript" src="js/date.js"></script>
			<script type="text/javascript" src="'.FILE_NAME.'_js.js"></script>
		';
		
		return $jscript;
	}
	
	function models_add_to_new_items_count($prod_no, $prod_sku, $des_id)
	{
		$sel = "SELECT * FROM new_items_count WHERE prod_sku = '".$prod_sku."'";
		$qry = mysql_query($sel) or die('Select From new_items_count Error!<br />'.mysql_error().'<br /><br />'.$sel);
		
		if (mysql_num_rows($qry) > 0)
		{
			// update new item
			return 0;
		}
		else
		{
			// insert new item
			$ins = "
				INSERT INTO new_items_count (
					status, prod_no, prod_sku, des_id
				) VALUES (
					'1', '".$prod_no."', '".$prod_sku."', '".$des_id."'
				)
			";
			$q_ins = mysql_query($ins) or die('Insert New Items Count Error!<br />'.mysql_error().'<br /><br />'.$ins);
			
			return 1;
		}
	}
	
	