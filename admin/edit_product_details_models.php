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
		$qry = mysql_query($sel) or die('Get Subsubcategories Error - '.mysql_error());
		
		return $qry;
	}

	function get_the_colors()
	{
		$sel = "SELECT * FROM tblcolor ORDER BY color_name ASC";
		$qry = mysql_query($sel) or die('Get Colors Error - '.mysql_error());
		
		return $qry;
	}
	
	function get_colors_facets()
	{
		$sel = "SELECT color_name from tblcolors ORDER BY color_name ASC";
		$qry = mysql_query($sel) or die('Get Color Facets Error - '.mysql_error());
		
		return $qry;
	}
	
	function get_styles_facets()
	{
		$sel = "SELECT style_name FROM tblstyle ORDER BY style_name ASC";
		$qry = mysql_query($sel) or die('Get Facets Error - '.mysql_error());
		
		return $qry;
	}
	
	function get_events_facets()
	{
		$sel = "SELECT event_name FROM tblevent ORDER BY event_name ASC";
		$qry = mysql_query($sel) or die('Get Facets Error - '.mysql_error());
		
		return $qry;
	}
	
	function get_materials_facets()
	{
		$sel = "SELECT material_name FROM tblmaterial ORDER BY material_name ASC";
		$qry = mysql_query($sel) or die('Get Facets Error - '.mysql_error());
		
		return $qry;
	}
	
	function get_trends_facets()
	{
		$sel = "SELECT trend_name FROM tbltrend ORDER BY trend_name ASC";
		$qry = mysql_query($sel) or die('Get Facets Error - '.mysql_error());
		
		return $qry;
	}
	
	function load_jscript()
	{
		$jscript = '
			<link type="text/css" href="js/datePicker.css" rel="stylesheet" />
			<link type="text/css" href="'.FILE_NAME.'_styles.css" rel="stylesheet" />
			<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
			<script type="text/javascript" src="js/date.js"></script>
			<script type="text/javascript" src="'.FILE_NAME.'_js.js"></script>
		';
		
		return $jscript;
	}
	
	function check_prod_no($prod_no)
	{
		$sel = "
			SELECT 
				p.*, 
				d.folder AS d_folder,
				c.folder AS c_folder,
				sc.folder AS sc_folder,
				ssc.folder AS ssc_folder
			FROM 
				tbl_product p
				LEFT JOIN designer d ON d.des_id = p.designer
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
			WHERE prod_no = '".$prod_no."'
		";
		$qry = mysql_query($sel) or die('Check Prod No error - '.mysql_error());
		
		if (mysql_num_rows($qry) > 0) return $qry;
		else return FALSE;
	}
	
	function get_product_colors($prod_no)
	{
		$sel = "
			SELECT
				p.prod_no, p.primary_img_id, p.cat_id, 
				d.folder AS d_folder,
				c.folder AS c_folder,
				sc.folder AS sc_folder,
				ssc.folder AS ssc_folder,
				ts.size_0, ts.size_2, ts.size_4, ts.size_6, ts.size_8, ts.size_10, ts.size_12, ts.size_14, ts.size_16, 
				ts.color_name, ts.color_facets, ts.stock_date, ts.color_publish, ts.st_id, 
				tc.color_code
			FROM
				tbl_product p
				LEFT JOIN designer d ON d.des_id = p.designer
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
				LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
				LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
			WHERE p.prod_no = '".$prod_no."'
		";
		$qry = mysql_query($sel) or die('Select colors error - '.mysql_error());
		return $qry;
	}
	
	function models_update_new_items_count($prod_sku, $des_id)
	{
		$sel = "SELECT * FROM new_items_count WHERE prod_sku = '".$prod_sku."'";
		$qry = mysql_query($sel) or die('Select From new_items_count Error!<br />'.mysql_error().'<br /><br />'.$sel);
		
		if (mysql_num_rows($qry) > 0)
		{
			while ($row = mysql_fetch_array($qry))
			{
				if ($row['status'] === '3') return 0; // --> nothing to do
				else
				{
					// update item status
					$upd = "
						UPDATE new_items_count
						SET 
							status = '2'
						WHERE
							prod_sku = '".$row['prod_sku']."'
					";
					$q_ins = mysql_query($upd) or die('Update New Items Count Error!<br />'.mysql_error().'<br /><br />'.$upd);
				}
			}
			
			return 1;
		}
		else
		{
			return 0; // --> nothing to do
		}
	}
	
	function m_get_color_code($color_name)
	{
		$sel = "SELECT * FROM tblcolor WHERE color_name = '".strtoupper($color_name)."'";
		$qry = mysql_query($sel) or die('Select From tblcolor Error!<br />'.mysql_error().'<br />'.$sel);
		
		if (mysql_num_rows($qry) > 0)
		{
			while ($row = mysql_fetch_array($qry))
			{
				return $row['color_code'];
			}
		}
		else return 0;
	}
	
	function m_add_to_new_items_count($prod_no, $prod_sku, $des_id)
	{
		$sel = "SELECT * FROM new_items_count WHERE prod_sku = '".$prod_sku."'";
		$qry = mysql_query($sel) or die('Select From new_items_count Error!<br />'.mysql_error().'<br /><br />'.$sel);
		
		if (mysql_num_rows($qry) > 0)
		{
			// nothing to do here
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
