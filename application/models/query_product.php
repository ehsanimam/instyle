<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_product extends CI_Model
{
	/*
	| -----------------------------------------------------------------------------------
	| Changing the get products count by id's to by url structures
	*/
	function get_products_count_new($c_url_structure, $d_url_structure, $sc_url_structure, $ssc_url_structure, $clearance = '')
	{
		//$DB3 = $this->_load_db();
		if ( ! empty($c_url_structure))
		{
			$cat = " AND c.url_structure = '".$c_url_structure."'";
		} else {
			$cat = "";
		}
		
		if ( ! empty($d_url_structure))
		{
			$des = " AND d.url_structure = '".$d_url_structure."'";
		} else {
			$des = "";
		}
		
		if ( ! empty($sc_url_structure))
		{
			$sub = " AND sc.url_structure = '".$sc_url_structure."'";
		} else {
			$sub = "";
		}
		
		if ( ! empty($ssc_url_structure))
		{
			$subsub = " AND sc.url_structure = '".$ssc_url_structure."'";
		} else {
			$subsub = "";
		}
		
		if ($clearance)
			$clr_filter = "
				AND (
					p.clearance = 'Yes' 
					OR p.clearance = 'yes' 
					OR p.clearance = 'y' 
					OR p.clearance = 'Y' 
					OR p.clearance = 'clearance'
					OR p.clearance = 'Clearance'
				)
			";
		else
			$clr_filter = "
				AND (
					p.clearance != 'Yes' 
					AND p.clearance != 'yes' 
					AND p.clearance != 'y' 
					AND p.clearance != 'Y' 
					AND p.clearance != 'clearance'
					AND p.clearance != 'Clearance'
				)
			";
		
		$q = $this->db->query("
			SELECT *
			FROM
				tbl_product p
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN designer d ON d.des_id = p.designer
				LEFT JOIN tblcolor tc ON tc.color_code = p.primary_img_id
				LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
			WHERE 
				p.view_status = 'Y'
				".$cat."
				".$sub."
				".$subsub."
				".$des."
				".$clr_filter."
		");
		return $q->num_rows();
	}
	// above to change below (below is original code)
	function get_products_count($cat_id, $des_id, $subcat_id, $subsubcat_id, $new_arrival, $clearance)
	{
		if (!empty($subsubcat_id))
		{
			$subsub = " AND p.subsubcat_id='".$subsubcat_id."'";
		} else {
			$subsub = "";
		}
		
		if	(!empty($subcat_id))
		{
			$sub = " AND sc.subcat_id = '".$subcat_id."'";
		} else {
			$sub = "";
		}
		
		if (!empty($des_id))
		{
			$des = " AND d.des_id='".$des_id."'";
		} else {
			$des = "";
		}
		
		$and_facets = '';
		
		if($new_arrival) {
			$and_new_arrival = "WHERE (p.new_arrival='yes' OR p.new_arrival='y' OR p.new_arrival='Y')";
		} elseif($clearance) {
			$and_new_arrival = "WHERE (p.clearance='yes' OR p.clearance='y' OR p.clearance='Y')";
		} else {
			$and_new_arrival = "WHERE c.cat_id = '".$cat_id."'";
			$and_facets .= " AND new_arrival <> 'yes'";
			$and_facets .= " AND clearance <> 'yes'";
		}
			
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT
								  p.prod_id, p.prod_no, p.prod_name, p.prod_desc, p.catalogue_price, p.less_discount,
								  p.primary_img_id, p.subsubcat_id
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								".$and_new_arrival."
								".$sub."
								".$and_facets."
								".$des."
								".$subsub."
								AND
								  p.view_status = 'Y'
							  ");
		return $q;
	}
	
	/*-----------------------------------------------------------------------------------*/
	
	/*
	| -----------------------------------------------------------------------------------
	| Changing the get products by id's to by url structures
	*/
	function get_products_new($c_url_structure = '', $d_url_structure = '', $sc_url_structure = '', $ssc_url_structure = '', $num, $offset, $clearance = '')
	{
		if ( ! empty($c_url_structure))
		{
			$cat = " AND c.url_structure = '".$c_url_structure."'";
		} else {
			$cat = "";
		}
		
		if ( ! empty($d_url_structure))
		{
			$des = " AND d.url_structure = '".$d_url_structure."'";
		} else {
			$des = "";
		}
		
		if ( ! empty($sc_url_structure))
		{
			$sub = " AND sc.url_structure = '".$sc_url_structure."'";
		} else {
			$sub = "";
		}
		
		if ( ! empty($ssc_url_structure))
		{
			$subsub = " AND ssc.url_structure = '".$ssc_url_structure."'";
		} else {
			$subsub = "";
		}
		
		if ($clearance)
			$clr_filter = "
				AND (
					p.clearance = 'Yes' 
					OR p.clearance = 'yes' 
					OR p.clearance = 'y' 
					OR p.clearance = 'Y' 
					OR p.clearance = 'clearance'
					OR p.clearance = 'Clearance'
				)
			";
		else
			$clr_filter = "
				AND (
					p.clearance != 'Yes' 
					AND p.clearance != 'yes' 
					AND p.clearance != 'y' 
					AND p.clearance != 'Y' 
					AND p.clearance != 'clearance'
					AND p.clearance != 'Clearance'
				)
			";
		
		$q = $this->db->query("
			SELECT
				p.cat_id, p.seque, p.subcat_id, p.prod_id, p.prod_no, p.prod_name, p.prod_desc, 
				p.catalogue_price, p.less_discount, p.wholesale_price, p.primary_img_id, p.subsubcat_id, 
				p.styles, p.colors, 
			 
				d.designer, d.folder, d.des_id, d.url_structure AS d_url_structure,
				
				c.folder AS cat_folder, c.cat_name, sc.subcat_name, ssc.name AS subsubcat_name, c.url_structure AS c_url_structure,
				
				sc.folder AS subcat_folder, sc.url_structure AS sc_url_structure,
				ssc.id AS ssc_subsubcat_id, ssc.folder AS ssc_folder, ssc.url_structure AS ssc_url_structure,
				tc.color_name
			FROM
				tbl_product p
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN designer d ON d.des_id = p.designer
				LEFT JOIN tblcolor tc ON tc.color_code = p.primary_img_id
				LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
			WHERE 
				(p.view_status = 'Y' OR p.view_status = 'Y1')
				".$cat."
				".$sub."
				".$subsub."
				".$des."
				".$clr_filter."
				
			ORDER BY seque, p.prod_no ASC
			LIMIT ".$num.",".$offset."
		");
		return $q;
	}
	// above to change below (below is original code)
	function get_products($cat_id, $des_id, $subcat_id, $subsubcat_id,  $new_arrival, $clearance, $num, $offset)
	{
		if (!empty($subsubcat_id))
		{
			$subsub = " AND p.subsubcat_id='".$subsubcat_id."'";
		} else {
			$subsub = "";
		}
		
		if (!empty($subcat_id))
		{
			$sub = " AND sc.subcat_id = '".$subcat_id."'";
		} else {
			$sub = "";
		}
		
		if (!empty($des_id))
		{
			$des = " AND d.des_id='".$des_id."'";
		} else {
			$des = "";
		}
		
		$and_facets = '';
		
		if($new_arrival) {
			$and_new_arrival = "WHERE (p.new_arrival='yes' OR p.new_arrival='y' OR p.new_arrival='Y')";
		} elseif($clearance) {
			$and_new_arrival = "WHERE (p.clearance='yes' OR p.clearance='y' OR p.clearance='Y')";
		} else {
			$and_new_arrival  = "WHERE c.cat_id = '".$cat_id."'";
			//$and_facets .= " AND new_arrival <> 'yes'";
			$and_facets .= " AND clearance <> 'yes'";
		}
		
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT
								  p.cat_id, p.seque, p.subcat_id, p.prod_id, p.prod_no, 
								  p.prod_name, p.prod_desc, p.catalogue_price, p.less_discount, 
								  p.wholesale_price, p.primary_img_id, p.subsubcat_id, p.styles, p.colors, 
								  
								  d.designer, d.folder, sc.folder AS subcat_folder,
								  d.des_id, d.url_structure AS des_url_structure,
								  
								  c.folder AS cat_folder, c.cat_name, sc.subcat_name, ssc.name AS subsubcat_name, c.url_structure AS c_url_structure,
								  
								  sc.url_structure AS sc_url_structure,
								  ssc.id AS ssc_subsubcat_id, ssc.url_structure AS ssc_url_structure,
								  tc.color_name
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								  LEFT JOIN tblcolor tc ON tc.color_code = p.primary_img_id
								  LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
								".$and_new_arrival."
								".$sub."
								".$and_facets."
								".$des."
								".$subsub."
								
								AND
								  p.view_status = 'Y'
								  
								ORDER BY seque ASC
								
								LIMIT ".$num.",".$offset."
							  ");
		return $q;
	}
	
	/*-----------------------------------------------------------------------------------*/
	// the $this->offset variable is actually the limit (number of rows returned)
	
	function get_products_new_for_sa($c_url_structure = '', $d_url_structure = '', $sc_url_structure = '', $num = '', $offset = '', $clearance = '')
	{
		if ( ! empty($c_url_structure))
		{
			$cat = " AND c.url_structure = '".$c_url_structure."'";
		} else {
			$cat = "";
		}
		
		if ( ! empty($d_url_structure))
		{
			$des = " AND d.url_structure = '".$d_url_structure."'";
		} else {
			$des = "";
		}
		
		if ( ! empty($sc_url_structure))
		{
			$sub = " AND sc.url_structure = '".$sc_url_structure."'";
		} else {
			$sub = "";
		}
		
		if ($clearance)
		{
			$clr_filter = "
				AND (
					p.clearance = 'Yes' 
					OR p.clearance = 'yes' 
					OR p.clearance = 'y' 
					OR p.clearance = 'Y' 
					OR p.clearance = 'clearance'
					OR p.clearance = 'Clearance'
				)
			";
		}
		else
		{
			$clr_filter = "
				AND (
					p.clearance != 'Yes' 
					AND p.clearance != 'yes' 
					AND p.clearance != 'y' 
					AND p.clearance != 'Y' 
					AND p.clearance != 'clearance'
					AND p.clearance != 'Clearance'
				)
			";
		}	
		
		if ($offset)
		{
			if ($num) $limits = "LIMIT ".$num.",".$offset;
			else $limits = "LIMIT ".$offset;
		}
		else
		{
			$limits = "";
		}
		
		$q = $this->db->query("
			SELECT
				p.cat_id, p.seque, p.subcat_id, p.prod_id, p.prod_no, p.prod_name, p.prod_desc, 
				p.catalogue_price, p.less_discount, p.wholesale_price, p.primary_img_id, p.subsubcat_id, 
				p.styles, p.colors, 
			 
				d.designer, d.folder, sc.folder AS subcat_folder, d.des_id, d.url_structure AS d_url_structure,
				
				c.folder AS cat_folder, c.cat_name, c.url_structure AS c_url_structure,
				
				sc.url_structure AS sc_url_structure, sc.subcat_name, sc.folder AS sc_folder, 
				ssc.id AS ssc_subsubcat_id, ssc.url_structure AS ssc_url_structure, ssc.name AS subsubcat_name, 
				
				ts.color_publish,
				
				tc.color_name, tc.color_code
			FROM
				tbl_product p
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN designer d ON d.des_id = p.designer
				LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
				LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
				LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
			WHERE 
				ts.color_publish = 'Y'
				AND (p.view_status = 'Y' OR p.view_status = 'Y1' OR p.view_status = 'Y2')
				".$cat."
				".$sub."
				".$des."
				".$clr_filter."
			ORDER BY seque ASC, prod_no ASC
			".$limits."
		");
		return $q;
	}
	
	/*-----------------------------------------------------------------------------------*/
	
	function get_search_products_count($cat_id, $subcat_id, $des_id, $search_terms)
	{
		if(@$search_terms) {
			$where = "WHERE
						  MATCH (p.colors,p.styles,p.events)
						  AGAINST('".@$search_terms."')";
		} elseif(@$search_terms == 'Red') {
			$where = "WHERE colors like '%Red%'";
		} else {			
			$where = "WHERE c.cat_id='".$cat_id."'";
		}
		
		if($des_id) {
			$and_designer = "AND d.des_id='".$des_id."'";
		} else {
			$and_designer = "";
		}	
		
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT
								  p.prod_id, p.prod_no, p.prod_name, p.prod_desc, p.catalogue_price, p.less_discount,
								  p.primary_img_id, p.subsubcat_id
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								".$where."
								AND
								  c.cat_id = '".$cat_id."'
								AND
								  sc.subcat_id = '".$subcat_id."'
								AND
								  p.view_status = 'Y'
								".$and_designer."  
								");
		return $q;
	}
	
	function get_search_products($cat_id, $subcat_id, $des_id, $search_terms, $num, $offset)
	{
		if (@$search_terms)
		{
			$where = "WHERE
						  MATCH (ts.color_facets,p.styles,p.events)
						  AGAINST ('".@$search_terms."')";
		} elseif(@$search_terms == 'Red') {
			$where = "WHERE colors like '%Red%'";
		} else {			
			$where = "WHERE c.cat_id='".$cat_id."'";
		}
		
		if($des_id) {
			$and_designer = "AND d.des_id='".$des_id."'";
		} else {
			$and_designer = "";
		}						
		
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT
								  p.cat_id, p.subcat_id, p.prod_id, p.prod_no, c.folder AS cat_folder, 
								  p.prod_name, p.prod_desc, p.catalogue_price, p.styles, p.colors, 
								  p.less_discount,p.primary_img_id, p.subsubcat_id,
								  d.url_structure AS des_url_structure, d.des_id, d.designer, d.folder, sc.folder AS subcat_folder,
								  c.cat_name, sc.subcat_name, sc.url_structure AS sc_url_structure, c.url_structure AS c_url_structure,
								  tc.color_name
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								  LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
								  JOIN tblcolor tc ON tc.color_name = ts.color_name
								".$where."
								AND
								  c.cat_id = '".$cat_id."'
								AND
								  sc.subcat_id = '".$subcat_id."'
								AND
								  p.view_status = 'Y'
								".$and_designer." 
								LIMIT ".$num.",".$offset."
							  ");
		return $q;
	}
	
	/*
	| ------------------------------------------------------------------------------
	| This is the total count of the query search product by facet query using Where field IN ('item','item')
	*/
	function get_search_products_count_new($cat_id, $subcat_id, $des_id, $search_terms, $filter, $subsubcat_id = '')
	{
		if ($cat_id) $and_cat_id = "AND p.cat_id = '".$cat_id."'";
		else $and_cat_id = '';
		
		if ($des_id) $and_designer = "AND d.des_id='".$des_id."'";
		else $and_designer = '';
		
		if ($subsubcat_id) $and_subsubcat = "AND ssc.id='".$subsubcat_id."'";
		else $and_subsubcat = '';
		
		if ($filter && $filter == 'new-arrival')
		{
			$and_filter = "AND (p.new_arrival='Yes' OR p.new_arrival='yes' OR p.new_arrival='y' OR p.new_arrival='Y' OR p.new_arrival='New Arrival')";
		}
		elseif ($filter && $filter == 'clearance')
		{
			$and_filter = "AND (p.clearance='Yes' OR p.clearance='yes' OR p.clearance='y' OR p.clearance='Y' OR p.clearance='Clearance')";
		}
		else
		{
			$and_filter = "AND (p.clearance!='Yes' AND p.clearance!='yes' AND p.clearance!='y' AND p.clearance!='Y' AND p.clearance!='Clearance')";
		}
		
		if (@$search_terms)
		{
			$match = '';
			$in = '';
			$new_prefix = '';
			$cur_prefix = '';
			$search_items = explode(' ',$search_terms);
			$xi = count($search_items) - 1;
			while ($item = current($search_items))
			{
				if (strlen($item) == 1) $new_prefix = $item;
				else
				{
					$cur_prefix = $new_prefix;
					if ($item == '3_4_sleeve') $item = '3/4_sleeve'; // ----> work around for 3/4 sleeve style facet
					$item = str_replace('_',' ',$item);
					if (strlen($item) == 3) $item = $item.'1';
					$in = $item;

					if ( ! empty($in))
					{
						if ( ! isset($key))
						{
							$key = key($search_items);
							$and_or = "AND (";
						}
						else $and_or = "OR";
						
						switch ($cur_prefix)
						{
							case 'c':
								$match .= $and_or." ts.color_facets LIKE '%".$in."%' ";
								break;
							case 's':
								$match .= $and_or." p.styles LIKE '%".$in."%' ";
								break;
							case 'e':
								$match .= $and_or." p.events LIKE '%".$in."%' ";
								break;
							case 'm':
								$match .= $and_or." p.materials LIKE '%".$in."%' ";
								break;
							case 't':
								$match .= $and_or." p.trends LIKE '%".$in."%' ";
						}
						$in = '';
					}
				}
				next($search_items);
			}
			$match = $match.")";
		}
		else $match = '';
		
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT
								  p.cat_id, p.subcat_id, p.prod_id, p.prod_no, p.primary_img_id, 
								  p.prod_name, p.prod_desc, p.catalogue_price, p.styles, p.colors,
								  p.less_discount,p.primary_img_id, p.subsubcat_id,
								  d.url_structure AS d_url_structure, d.des_id, d.designer, d.folder AS d_folder, 
								  sc.folder AS subcat_folder, sc.subcat_name, sc.url_structure AS sc_url_structure, 
								  c.cat_name, c.url_structure AS c_url_structure, c.folder AS cat_folder, 
								  ts.color_facets, ts.color_name AS ts_color_name,
								  tc.color_code
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
								  JOIN designer d ON d.des_id = p.designer
								  LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
								  LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
								WHERE
								  p.view_status = 'Y'
								".$and_cat_id." 
								AND
								  sc.subcat_id = '".$subcat_id."'
								".$and_subsubcat."
								".$and_designer." 
								".$match."
								".$and_filter." 
							  ");
		return $q;
	}
	
	/*
	| ------------------------------------------------------------------------------
	| Had to create a new search product by facet query using Where field IN ('item','item')
	| considering filter
	*/
	function get_search_products_new($cat_id, $subcat_id, $des_id, $search_terms, $num, $offset, $filter, $subsubcat_id = '')
	{
		if ($cat_id) $and_cat_id = "AND p.cat_id = '".$cat_id."'";
		else $and_cat_id = '';
		
		if ($des_id) $and_designer = "AND d.des_id='".$des_id."'";
		else $and_designer = '';
		
		if ($subsubcat_id)
		{
			$and_subsubcat = "AND ssc.id='".$subsubcat_id."'";
			$join_ssc = "JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id";
		}
		else
		{
			$and_subsubcat = '';
			$join_ssc = '';
		}
		
		if ($filter && $filter == 'new-arrival')
		{
			$and_filter = "AND (p.new_arrival='Yes' OR p.new_arrival='yes' OR p.new_arrival='y' OR p.new_arrival='Y' OR p.new_arrival='New Arrival')";
		}
		elseif ($filter && $filter == 'clearance')
		{
			$and_filter = "AND (p.clearance='Yes' OR p.clearance='yes' OR p.clearance='y' OR p.clearance='Y' OR p.clearance='Clearance')";
		}
		else
		{
			$and_filter = "AND (p.clearance!='Yes' AND p.clearance!='yes' AND p.clearance!='y' AND p.clearance!='Y' AND p.clearance!='Clearance')";
		}
		
		if (@$search_terms)
		{
			$match = '';
			$in = '';
			$new_prefix = '';
			$cur_prefix = '';
			$search_items = explode(' ',$search_terms);
			$xi = count($search_items) - 1;
			while ($item = current($search_items))
			{
				if (strlen($item) == 1) $new_prefix = $item;
				else
				{
					$cur_prefix = $new_prefix;
					if ($item == '3_4_sleeve') $item = '3/4_sleeve'; // ----> work around for 3/4 sleeve style facet
					$item = str_replace('_',' ',$item);
					if (strlen($item) == 3) $item = $item.'1';
					$in = $item;

					if ( ! empty($in))
					{
						if ( ! isset($key))
						{
							$key = key($search_items);
							$and_or = "AND (";
						}
						else $and_or = "OR";
						
						switch ($cur_prefix)
						{
							case 'c':
								$match .= $and_or." ts.color_facets LIKE '%".$in."%' ";
								break;
							case 's':
								$match .= $and_or." p.styles LIKE '%".$in."%' ";
								break;
							case 'e':
								$match .= $and_or." p.events LIKE '%".$in."%' ";
								break;
							case 'm':
								$match .= $and_or." p.materials LIKE '%".$in."%' ";
								break;
							case 't':
								$match .= $and_or." p.trends LIKE '%".$in."%' ";
						}
						$in = '';
					}
				}
				next($search_items);
			}
			$match = $match.")";
		}
		else $match = '';
		
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT
								  p.cat_id, p.subcat_id, p.prod_id, p.prod_no, p.primary_img_id, 
								  p.prod_name, p.prod_desc, p.catalogue_price, p.styles, p.colors,
								  p.less_discount, p.primary_img_id, p.subsubcat_id, p.new_arrival, p.clearance,
								  d.url_structure AS d_url_structure, d.des_id, d.designer, d.folder AS folder, 
								  ssc.folder AS ssc_folder,
								  sc.folder AS subcat_folder, sc.subcat_name, sc.url_structure AS sc_url_structure, 
								  c.cat_name, c.url_structure AS c_url_structure, c.folder AS cat_folder, 
								  ts.color_facets, ts.color_name,
								  tc.color_code
								FROM
								  tbl_product p
								  LEFT JOIN tblcat c ON c.cat_id = p.cat_id
								  LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
								  LEFT JOIN designer d ON d.des_id = p.designer
								  LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
								  LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
								WHERE
								  (p.view_status = 'Y' OR p.view_status = 'Y1')
								".$and_cat_id." 
								AND
								  sc.subcat_id = '".$subcat_id."'
								".$and_subsubcat."
								".$and_designer." 
								".$match."
								".$and_filter." 
								LIMIT ".$num.",".$offset."
							  ");
		return $q;
	}
	
	/*
	| -----------------------------------------------------------------------------------
	| Changing the get product details as follows
	*/
	function get_product_detail_new($prod_no, $color_name = '')
	{
		if ($color_name != '')
		{
			$color_name = str_replace('-',' ',strtoupper($color_name));
			$clr = " AND tc.color_name = '".$color_name."'";
		}
		else $clr = '';
		
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT
				p.prod_id, p.prod_name, p.prod_no, p.prod_date, p.prod_desc, p.on_sale, p.catalogue_price, p.less_discount, 
				p.wholesale_price, p.primary_img, p.primary_img_id, p.new_arrival, p.clearance, p.colors, p.styles, 
				
				c.cat_name, c.cat_id, c.title AS c_title, c.description AS c_description, c.folder AS c_folder, 
				c.keyword AS c_keyword, c.alttags AS c_alttags, c.url_structure AS c_url_structure,
				
				sc.subcat_name, sc.folder AS sc_folder, sc.subcat_id, sc.title AS sc_title, sc.description AS sc_description, 
				sc.keyword AS sc_keyword, sc.alttags AS sc_alttags, sc.url_structure AS sc_url_structure,
				
				ssc.name AS subsubcat_name, ssc.folder AS ssc_folder, ssc.url_structure AS ssc_url_structure, ssc.id AS subsubcat_id, 
				
				d.designer, d.folder AS d_folder, d.des_id, d.url_structure AS d_url_structure,
				
				ts.stock_date,
				
				tc.color_id, tc.color_name, tc.color_code, 
				
				ssc.name AS subsubcat_name
			FROM
				tbl_product p
				JOIN tblcat c ON c.cat_id = p.cat_id
				JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
				JOIN designer d ON d.des_id = p.designer
				LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
				LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
			WHERE
				p.prod_no = '".$prod_no."'
				".$clr."
		");
		
		return $q;
	}
	// above to change below (below is original code)
	function get_product_detail($prod_no, $color_code)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT
				p.prod_id, p.prod_name, p.prod_no, p.prod_date, p.prod_desc, p.on_sale, p.catalogue_price, p.less_discount, 
				p.wholesale_price, p.primary_img, p.primary_img_id, p.new_arrival, p.clearance, p.colors, p.styles, 
				
				c.cat_name, c.cat_id, c.title AS c_title, c.description AS c_description, c.folder AS c_folder, 
				c.keyword AS c_keyword, c.alttags AS c_alttags, c.url_structure AS c_url_structure,
				
				sc.subcat_name, sc.folder AS sc_folder, sc.subcat_id, sc.title AS sc_title, sc.description AS sc_description, 
				sc.keyword AS sc_keyword, sc.alttags AS sc_alttags, sc.url_structure AS sc_url_structure,
				
				d.designer, d.folder AS d_folder, d.des_id, d.url_structure AS d_url_structure,
				
				ts.stock_date,
				
				tc.color_id, tc.color_name, tc.color_code, 
				
				ssc.name AS subsubcat_name
			FROM
				tbl_product p
				JOIN tblcat c ON c.cat_id = p.cat_id
				JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
				JOIN designer d ON d.des_id = p.designer
				LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
				LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
			WHERE
				p.prod_no = '".$prod_no."'
			AND
				tc.color_code = '".$color_code."'
		");
		
		if ($q->num_rows() == 0)
		{
			//$DB3 = $this->_load_db();
			$q = $this->db->query("
				SELECT
					p.prod_id, p.prod_name, p.prod_no, p.prod_date, p.prod_desc, p.on_sale, p.catalogue_price, p.less_discount, 
					p.wholesale_price, p.primary_img, p.primary_img_id, p.new_arrival, p.clearance,  p.colors, p.styles, 
					
					c.cat_name, c.cat_id, c.title AS c_title, c.description AS c_description, c.folder AS c_folder, 
					c.keyword AS c_keyword, c.alttags AS c_alttags, c.url_structure AS c_url_structure,
					
					sc.subcat_name, sc.folder AS sc_folder, sc.subcat_id, sc.title AS sc_title, sc.description AS sc_description, 
					sc.keyword AS sc_keyword, sc.alttags AS sc_alttags, sc.url_structure AS sc_url_structure,
					
					d.designer, d.folder AS d_folder, d.des_id, d.url_structure AS d_url_structure,
					
					ts.stock_date,
					
					tc.color_id, tc.color_name, tc.color_code, ssc.name AS subsubcat_name
				FROM
					tbl_product p
					JOIN tblcat c ON c.cat_id = p.cat_id
					JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
					LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
					JOIN designer d ON d.des_id = p.designer
					LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
					LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
				WHERE
					p.prod_no ='".$prod_no."'
			");
		}
		return $q;
	}
	/*-----------------------------------------------------------------------------------*/
	
	function get_products_oncart($cat_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT
								  p.cat_id, p.subcat_id, p.prod_id, p.prod_no, c.folder AS cat_folder, 
								  p.prod_name, p.prod_desc, p.catalogue_price, 
								  p.less_discount,p.primary_img_id, p.subsubcat_id,
								  d.des_id, d.designer, d.folder, sc.folder AS subcat_folder, d.url_structure AS des_url_structure,
								  c.url_structure AS c_url_structure,
								  sc.url_structure As sc_url_structure, tc.color_name
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								  JOIN tblcolor tc ON tc.color_code = p.primary_img_id
								WHERE
								  c.cat_id = '".$cat_id."'
								AND
								  p.view_status = 'Y'
								AND
								  sc.view_status = 'Y'								
								ORDER BY 
								  rand()
								LIMIT 6
							  ");
		return $q;
	}
	
	/*
	| ----------------------------------------------------------------------------------------
	| Serach By Style query
	*/
	function get_search_by_style($string)
	{
		//$DB3 = $this->_load_db();
		$select_string = "
			tbl_product.*, tblcat.*, designer.*, tblsubcat.*, tbl_stock.*, tblcolor.*,
			tblcat.folder AS cat_folder,
			tblcat.url_structure AS c_url_structure,
			designer.folder AS folder,
			designer.url_structure AS d_url_structure,
			tblsubcat.folder AS subcat_folder,
			tblsubcat.url_structure AS sc_url_structure,
			tbl_stock.color_name AS ts_color_name,
			tblcolor.color_code AS color_code
		";
		$this->db->select($select_string);
		$this->db->from('tbl_product');
		$this->db->join('tblcat','tblcat.cat_id = tbl_product.cat_id');
		$this->db->join('designer','designer.des_id = tbl_product.designer');
		$this->db->join('tblsubcat','tblsubcat.subcat_id = tbl_product.subcat_id');
		$this->db->join('tbl_stock','tbl_stock.prod_no = tbl_product.prod_no','left');
		$this->db->join('tblcolor','tblcolor.color_name = tbl_stock.color_name','left');
		$where1 = "(tbl_product.view_status = 'Y' OR tbl_product.view_status = 'Y1' OR tbl_product.view_status = 'Y2')";
		$this->db->where($where1);
		$this->db->where('tbl_stock.color_publish','Y');
		//$this->db->where('u','p');
		$this->db->like('tbl_product.prod_no',$string);
		$this->db->order_by('tbl_product.seque ASC, tbl_product.prod_no ASC');
		return $this->db->get();
	}
	
	/*
	| ----------------------------------------------------------------------------------------
	| Serach By Style query for sales package
	*/
	function get_search_by_style_sa($string)
	{
		// Check if $string is an array
		if (is_array($string))
		{
			$like = '(';
			$count = count($string);
			for ($i = 0; $i < $count; $i++)
			{
				if ($string[$i] <> '')
				{
					if ($i == 0) $like .= "tbl_product.prod_no LIKE '%".trim($string[$i])."%'";
					else $like .= " OR tbl_product.prod_no LIKE '%".trim($string[$i])."%'";
				}
			}
			$like .= ')';
		}
		else $like = "tbl_product.prod_no LIKE '%".trim($string)."%'";
		
		$q = "
			SELECT
				tbl_product.*, tblcat.*, designer.*, tblsubcat.*, tbl_stock.*, tblcolor.*,
				tblcat.folder AS cat_folder,
				tblcat.url_structure AS c_url_structure,
				designer.folder AS folder,
				designer.url_structure AS d_url_structure,
				tblsubcat.folder AS subcat_folder,
				tblsubcat.url_structure AS sc_url_structure,
				tbl_stock.color_name AS ts_color_name,
				tblcolor.color_code AS color_code
			FROM
				tbl_product
				LEFT JOIN tblcat ON tblcat.cat_id = tbl_product.cat_id
				LEFT JOIN designer ON designer.des_id = tbl_product.designer
				LEFT JOIN tblsubcat ON tblsubcat.subcat_id = tbl_product.subcat_id
				LEFT JOIN tbl_stock ON tbl_stock.prod_no = tbl_product.prod_no
				LEFT JOIN tblcolor ON tblcolor.color_name = tbl_stock.color_name
			WHERE
				tbl_stock.color_publish = 'Y'
				AND (tbl_product.view_status = 'Y' OR tbl_product.view_status = 'Y1' OR tbl_product.view_status = 'Y2')
				AND ".$like."
			ORDER BY
				tbl_product.seque ASC, tbl_product.prod_no ASC
		";
		
		return $this->db->query($q);
	}
	
	function get_shipping_method() {
		//$DB3 = $this->_load_db();
		$q = $this->db->get('tbl_shipmethod');
		return $q;
	}
	
	function get_single_shipping($ship_id) {
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tbl_shipmethod',array('ship_id'=>$ship_id));
		return $q->row();
	}
	
	function get_default_ship_fee() {
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tbl_shipmethod',array('default_fee'=>1));
		return $q->row();
	}
	
	function insert_order_log($data) {
		//$DB3 = $this->_load_db();
		$this->db->insert('tbl_order_log',$data);
		return $this;
	}
	
	function insert_order_log_detail($data) {
		//$DB3 = $this->_load_db();
		$this->db->insert('tbl_order_log_details',$data);
		return $this;
	}
	
	/*
	| ----------------------------------------------------------------------------------------
	| Minimum 8 units orders for wholesale user
	*/
	function check_first_order($user_id) 
	{	
		$this->db->select_sum('tbl_order_log_details.qty');
		$this->db->from('tbluser_data_wholesale');
		$this->db->join('tbl_order_log','tbl_order_log.user_id = tbluser_data_wholesale.user_id');
		$this->db->join('tbl_order_log_details','tbl_order_log_details.order_log_id = tbl_order_log.order_log_id');
		$this->db->where('tbluser_data_wholesale.user_id', intval($user_id));
		$this->db->where('tbl_order_log.store_name !=' , '');
		return $this->db->get();
	}
	
	/*
	| ----------------------------------------------------------------------------------------
	| Check stock of products per size
	*/
	function check_stock($prod_no,$color_name)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tbl_stock',array('prod_no'=>$prod_no,'color_name'=>$color_name));
		return $q->row_array();
	}

/*	
	function _load_db()
	{
		// load the respective database
		switch (ENVIRONMENT)
		{
			case 'development':
				$DB = $this->load->database('local', TRUE);
			break;

			case 'testing':
			default:
				$DB = $this->load->database('instylemoscow', TRUE);
		}
		
		return $DB;
	}
*/
}
