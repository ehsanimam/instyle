<?php
	function get_the_designers()
	{
		$sel = "SELECT * FROM designer ORDER BY designer ASC";
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
	
	function get_designer_name($des_id)
	{
		$sel = "SELECT designer FROM designer WHERE des_id = '".$des_id."'";
		$qry = mysql_query($sel) or die('Get Designers Error - '.mysql_error());
		$res = mysql_fetch_array($qry);
		return $res['designer'];
	}

	function get_subcat_name($subcat_id)
	{
		$sel = "SELECT subcat_name FROM tblsubcat WHERE subcat_id = '".$subcat_id."'";
		$qry = mysql_query($sel) or die('Get Subcategories Error - '.mysql_error());
		$res = mysql_fetch_array($qry);
		return $res['subcat_name'];
	}

	function load_jscript()
	{
		$jscript = '
			<link type="text/css" href="js/datePicker.css" rel="stylesheet" />
			<link type="text/css" href="'.FILE_NAME.'_styles.css" rel="stylesheet" />
			<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
			<script type="text/javascript" src="js/date.js"></script>
			<script type="text/javascript" src="js/spin.js"></script>
			<script type="text/javascript" src="'.FILE_NAME.'_js.js"></script>
		';
		
		return $jscript;
	}
	
	function count_products($des_id = '', $cat_id = '', $subcat_id = '', $subsubcat_id = '', $clearance = '', $search_str = '')
	{
		if ($search_str != '')
		{
			$where = "WHERE prod_no LIKE '%".$search_str."%'";
		}
		elseif ($des_id == '' && $cat_id == '' && $subcat_id == '' && $subsubcat_id == '')
		{
			$where = '';
		}
		else
		{
			$where = "WHERE ";
			if ($search_str != '') $where .= "cat_id = '".$cat_id."' AND ";
			if ($des_id != '') $where .= "designer = '".$des_id."' AND ";
			if ($cat_id != '') $where .= "cat_id = '".$cat_id."' AND ";
			if ($subcat_id != '') $where .= "subcat_id = '".$subcat_id."' AND ";
			if ($subsubcat_id != '') $where .= "subsubcat_id = '".$subsubcat_id."' AND ";
			$where = substr($where, 0, -5);
		}
		
		if ($clearance == 1)
		{
			if ($where == '') $clr_pre = "WHERE ";
			else $clr_pre = "AND (";
			$clearance = $clr_pre."
					clearance = 'Y' OR 
					clearance = 'y' OR 
					clearance = 'Yes' OR 
					clearance = 'yes' OR 
					clearance = 'Clearance' OR 
					clearance = 'clearance'
			";
			if ($where == '') $clr_suf = '';
			else $clr_suf = ")";
			$clearance .= $clr_suf;
		}
		else
		{
			if ($where == '') $clr_pre = "WHERE ";
			else $clr_pre = "AND (";
			$clearance = $clr_pre."
				clearance != 'Y' AND 
				clearance != 'y' AND 
				clearance != 'Yes' AND 
				clearance != 'yes' AND 
				clearance != 'Clearance' AND 
				clearance != 'clearance'
			";
			if ($where == '') $clr_suf = '';
			else $clr_suf = ")";
			$clearance .= $clr_suf;
		}
		
		$sel = "
			SELECT COUNT(*) AS count
			FROM tbl_product 
			".$where."
			".$clearance."
		";
		$qry = mysql_query($sel) or die('Count Products Error - <br />'.$sel.' - <br />'.mysql_error());
		
		return $qry;
	}
	
	function get_products($des_id = '', $cat_id = '', $subcat_id = '', $subsubcat_id = '', $limit = 100, $offset = 0, $clearance = '', $search_str = '')
	{
		// clearance filter 1 for ON and empty ('' - default) for OFF
		
		if ($search_str != '')
		{
			$where = "WHERE prod_no LIKE '%".$search_str."%'";
		}
		elseif ($des_id == '' && $cat_id == '' && $subcat_id == '')
		{
			$where = '';
		}
		else
		{
			$where = "WHERE ";
			if ($des_id != '') $where .= "p.designer = '".$des_id."' AND ";
			if ($cat_id != '') $where .= "p.cat_id = '".$cat_id."' AND ";
			if ($subcat_id != '') $where .= "p.subcat_id = '".$subcat_id."' AND ";
			if ($subsubcat_id != '') $where .= "p.subsubcat_id = '".$subsubcat_id."' AND ";
			$where = substr($where, 0, -5);
		}
		
		if ($clearance == 1)
		{
			if ($where == '') $clr_pre = "WHERE ";
			else $clr_pre = "AND (";
			$clearance = $clr_pre."
				clearance = 'Y' OR 
				clearance = 'y' OR 
				clearance = 'Yes' OR 
				clearance = 'yes' OR 
				clearance = 'Clearance' OR 
				clearance = 'clearance'
			";
			if ($where == '') $clr_suf = '';
			else $clr_suf = ")";
			$clearance .= $clr_suf;
		}
		else
		{
			if ($where == '') $clr_pre = "WHERE ";
			else $clr_pre = "AND (";
			$clearance = $clr_pre."
				clearance != 'Y' AND 
				clearance != 'y' AND 
				clearance != 'Yes' AND 
				clearance != 'yes' AND 
				clearance != 'Clearance' AND 
				clearance != 'clearance'
			";
			if ($where == '') $clr_suf = '';
			else $clr_suf = ")";
			$clearance .= $clr_suf;
		}
		
		$sel = "
			SELECT
				p.prod_id, p.prod_no, p.primary_img_id, p.seque, p.view_status, p.prod_name, p.hide_sketch, 
				d.folder AS d_folder, d.designer AS designer_name,
				c.folder AS c_folder, c.cat_name,
				sc.folder AS sc_folder, sc.subcat_name,
				ssc.folder AS ssc_folder, ssc.name
			FROM
				tbl_product p
				LEFT JOIN designer d ON d.des_id = p.designer
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
			".$where."
			".$clearance."
			ORDER BY seque, prod_no ASC
			LIMIT ".$offset.", ".$limit."
		";
		$qry = mysql_query($sel) or die('Get Products Error - '.mysql_error().'<br />'.$sel);
		
		return $qry;
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
				LEFT JOIN tblsubsubcat sc ON ssc.id = p.subsubcat_id
				LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
				LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
			WHERE p.prod_no = '".$prod_no."'
		";
		$qry = mysql_query($sel) or die('Select colors error - '.mysql_error());
		return $qry;
	}