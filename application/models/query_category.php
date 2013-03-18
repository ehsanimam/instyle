<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_category extends CI_Model {
	
	/*
	| -----------------------------------------------------------------------------------
	| Changing the get meta info by table and cat_id to by table and category url structure
	*/
	function get_meta_new($table, $id)
	{
		foreach ($id as $c => $i)
		{
			$field  = $c;
			$value	= $i;
		}
		
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where($table, array($field => $value));
		return $q->row_array();
	}
	// above to change below (below is original code)
	function get_meta($table, $id)
	{
		foreach ($id as $c => $i)
		{
			$column  = $c;
			$id		 = $i;
		}
		
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where($table,array($column=>$id));
		return $q;
	}
	/*-----------------------------------------------------------------------------------*/
	
	function get_random_meta()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT
				sc.title, sc.description, sc.keyword, sc.alttags, sc.footer 
			FROM
				tbl_product p
				JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			WHERE
				p.new_arrival = 'yes'
				OR p.new_arrival = 'y'
			ORDER BY
				rand()
		");
		return $q;
	}
	
	/*
	/  category
	*/
	
	function check_category($str)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tblcat',array('url_structure' => $str));
		return $q;
	}
	
	function just_categories()
	{
		//$DB3 = $this->_load_db();
		$this->db->select('url_structure');
		$this->db->from('tblcat');
		$q = $this->db->get();
		return $q->result_array();
	}
	
	/*
	/  subcategory
	*/
	
	function check_subcategory($str)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tblsubcat',array('url_structure' => $str));
		return $q;
	}
	
	function just_subcategories()
	{
		//$DB3 = $this->_load_db();
		$this->db->select('url_structure');
		$this->db->from('tblsubcat');
		$q = $this->db->get();
		return $q->result_array();
	}
	
	/*
	| -----------------------------------------------------------------------------------
	| Changing the get subcat by cat_id to by category url structure
	*/
	function get_subcat_new($c_url_structure, $d_url_strucutre = '')
	{
		if ($d_url_strucutre)
		{
			$and_d_url_strucutre = "AND d.url_structure = '".$d_url_strucutre."'";
		}
		else $and_d_url_strucutre = '';

		$q = $this->db->query("
			SELECT
				c.cat_id, c.cat_name, c.url_structure AS c_url_structure,
				sc.subcat_id, sc.subcat_name, sc.icon_img, sc.folder, sc.styling,
				sc.title, sc.description, sc.keyword, sc.alttags, sc.footer, sc.url_structure AS sc_url_structure,
				d.designer, d.url_structure AS d_url_structure
			FROM
				tbl_product p
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN designer d ON d.des_id = p.designer
			WHERE
				sc.view_status = 'Y'
				AND c.url_structure = '".$c_url_structure."'
				".$and_d_url_strucutre."
			GROUP BY sc.subcat_name
			ORDER BY
				sc.ordering
		");
		return $q;
	}
	// above to change below (below is original code)
	function get_subcat($cat_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT
				sc.subcat_id, sc.subcat_name, sc.icon_img, sc.folder, sc.styling,
				sc.title, sc.description, sc.keyword, sc.alttags, sc.url_structure AS sc_url_structure,
				c.cat_id, c.cat_name, c.url_structure AS c_url_structure
			FROM
				tblsubcat sc
				JOIN tblcat c ON c.cat_id = sc.cat_id
			WHERE
				sc.view_status = 'Y'
				AND c.cat_id = '".$cat_id."'
			ORDER BY
				sc.ordering
		");
		return $q;
	}
	/*-----------------------------------------------------------------------------------*/
	
	/*
	/  sub sub category
	*/
	
	function get_subsubcat_new($sc_url_structure, $d_url_strucutre = '')
	{
		if ($d_url_strucutre)
		{
			$and_d_url_strucutre = "AND d.url_structure = '".$d_url_strucutre."'";
		}
		else $and_d_url_strucutre = '';

		$q = $this->db->query("
			SELECT
				c.cat_id, c.cat_name, c.url_structure AS c_url_structure,
				sc.subcat_id, sc.subcat_name, sc.icon_img, sc.folder, sc.styling,
				sc.title, sc.description, sc.keyword, sc.alttags, sc.footer, sc.url_structure AS sc_url_structure,
				ssc.id AS subsubcat_id, ssc.name AS subsubcat_name, ssc.icon_img AS ssc_icon_img, ssc.folder AS ssc_folder, 
				ssc.title AS ssc_title, ssc.description AS ssc_description, ssc.keyword AS ssc_keywor, 
				ssc.alttags AS ssc_alttags, ssc.url_structure AS ssc_url_structure,
				d.designer, d.url_structure AS d_url_structure
			FROM
				tbl_product p
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN tblsubsubcat ssc ON ssc.subcat_id = p.subcat_id
				LEFT JOIN designer d ON d.des_id = p.designer
			WHERE
				sc.view_status = 'Y'
				AND p.subsubcat_id != '0'	
				AND sc.url_structure = '".$sc_url_structure."'
				".$and_d_url_strucutre."
			GROUP BY ssc.name
			ORDER BY
				ssc.ordering
		");
		return $q;
	}
	
	function get_subsubcat($subcat_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tblsubsubcat',array('subcat_id'=>$subcat_id));
		return $q;
	}
	
	function just_subsubcategories()
	{
		//$DB3 = $this->_load_db();
		$this->db->select('url_structure');
		$this->db->from('tblsubsubcat');
		$q = $this->db->get();
		return $q->result_array();
	}
	
	/*
	/  designer
	*/
	
	function check_designer($str)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('designer',array('url_structure' => $str));
		return $q;
	}
	
	function just_designers()
	{
		//$DB3 = $this->_load_db();
		$this->db->select('url_structure');
		$this->db->from('designer');
		$q = $this->db->get();
		return $q->result_array();
	}
	
	/*
	| -----------------------------------------------------------------------------------
	| Changing the get designers by cat_id to by category url structure
	*/
	function get_designers_new($c_url_structure)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT
				d.des_id, d.designer, d.icon_img, d.folder, d.title, d.description, d.keyword, d.alttags,
				d.url_structure AS d_url_structure, 
				c.cat_id, c.cat_name, c.url_structure AS c_url_structure
			FROM
				designer d
				JOIN tblcat c ON c.cat_id = d.catid
			WHERE
				d.view_status = 'Y'
			ORDER BY
				d.ordering
		");
		return $q;
	}
	// above to change below (below is original code)
	function get_designers($cat_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query(
			"SELECT
				d.des_id, d.designer, d.icon_img, d.folder, d.title, d.description, d.keyword, d.alttags,
				d.url_structure AS d_url_structure, c.cat_id, c.cat_name, c.url_structure AS c_url_structure
			FROM
				designer d
				JOIN tblcat c ON c.cat_id = d.catid
			WHERE
				d.view_status = 'Y'
				AND c.cat_id = '".$cat_id."'
			ORDER BY
				d.ordering
		");
		return $q;
	}
	/*-----------------------------------------------------------------------------------*/
	
	/*
	| -----------------------------------------------------------------------------------
	| Changing the get designers by cat_id to by category url structure
	*/
	function get_category_bydesigner_new($d_url_structure, $c_url_structure)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT 
				p.designer, p.subcat_id, 
				s.subcat_name, s.url_structure AS sc_url_structure, s.icon_img, s.description,
				d.url_structure AS d_url_structure, d.designer AS designer_name
			FROM 
				tbl_product p, tblsubcat s, tblcat c, designer d
			WHERE 
				p.cat_id = c.cat_id
				AND c.url_structure = '".$c_url_structure."'
				AND p.subcat_id = s.subcat_id
				AND s.view_status = 'Y' and p.view_status='Y' 
				AND p.designer = d.des_id
				AND d.url_structure = '".$d_url_structure."'
			GROUP BY 
				p.designer, p.subcat_id
		");
		return $q;
	}
	// above to change below (below is original code)
	function get_category_bydesigner($des_id, $cat_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT 
				p.designer, p.subcat_id, s.subcat_name, s.url_structure
			FROM 
				`tbl_product` p, tblsubcat s
			WHERE 
				p.cat_id = '".$cat_id."'
				AND p.subcat_id = s.subcat_id
				AND s.view_status = 'Y' and p.view_status='Y' 
				AND p.designer='".$des_id."'
			GROUP BY 
				p.designer, p.subcat_id
		");
		return $q;
	}
	/*-----------------------------------------------------------------------------------*/
	
	/*
	/  new arrival
	*/
	
	function get_newarrival()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT DISTINCT
				sc.subcat_id, sc.subcat_name, sc.icon_img, sc.folder, sc.styling,
				sc.title, sc.description, sc.keyword, sc.alttags, sc.url_structure AS sc_url_structure,
				c.cat_id, c.cat_name, c.url_structure AS c_url_structure
			FROM
				tbl_product p
				JOIN tblcat c ON c.cat_id = p.cat_id
				JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			WHERE
				sc.view_status = 'Y'
				AND (p.new_arrival = 'yes' OR p.new_arrival = 'y')
			ORDER BY
				sc.ordering
		");
		return $q;
	}
	
	function get_designers_newarrival()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT  DISTINCT
				d.des_id, d.designer, d.icon_img, d.folder, d.title, d.description, d.keyword, d.alttags,
				d.url_structure AS d_url_structure, c.cat_id, c.cat_name, c.url_structure AS c_url_structure
			FROM
				tbl_product p
				JOIN designer d ON d.des_id = p.designer
				JOIN tblcat c ON c.cat_id = d.catid
			WHERE
				d.view_status = 'Y'
				AND (p.new_arrival='yes' OR p.new_arrival='y')
			ORDER BY
				d.ordering
		");
		return $q;
	}
	
	function get_newarrival_bydesigner($des_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT DISTINCT
				p.designer, p.subcat_id, sc.subcat_name, sc.url_structure
			FROM
				tbl_product p
				JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			WHERE
				p.designer = '".$des_id."'
				AND (p.new_arrival = 'yes' OR p.new_arrival = 'y')
		");
		return $q;
	}
	
	/*
	/  clearance
	*/
	
	/*
	| -----------------------------------------------------------------------------------
	| Get clearance subcats
	*/
	function get_clearance_subcat()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT
				c.cat_id, c.cat_name, c.url_structure AS c_url_structure,
				sc.subcat_id, sc.subcat_name, sc.icon_img, sc.folder, sc.styling,
				sc.title, sc.description, sc.keyword, sc.alttags, sc.footer, sc.url_structure AS sc_url_structure
			FROM
				tbl_product p
				LEFT JOIN tblcat c ON c.cat_id = p.cat_id
				LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
				LEFT JOIN designer d ON d.des_id = p.designer
			WHERE
				sc.view_status = 'Y'
				AND (
					p.clearance = 'yes' 
					OR p.clearance = 'y' 
					OR p.clearance = 'Yes' 
					OR p.clearance = 'Y'
					OR p.clearance = 'clearance'
					OR p.clearance = 'Clearance'
					OR p.clearance = '1'
				)
			GROUP BY sc.subcat_name
			ORDER BY
				sc.ordering
		");
		return $q;
	}
	
	function get_clearance()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT DISTINCT
				sc.subcat_id, sc.subcat_name, sc.icon_img, sc.folder, sc.styling,
				sc.title, sc.description, sc.keyword, sc.alttags, sc.url_structure AS sc_url_structure,
				c.cat_id, c.cat_name, c.url_structure AS c_url_structure
			FROM
				tbl_product p
				JOIN tblcat c ON c.cat_id = p.cat_id
				JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			WHERE
				sc.view_status = 'Y'
				AND (p.clearance = 'yes' OR p.clearance = 'y')
			ORDER BY
				sc.ordering
		");
		return $q;
	}
	
	function get_designers_clearance()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT  DISTINCT
				d.des_id, d.designer, d.icon_img, d.folder, d.title, d.description, d.keyword, d.alttags,
				d.url_structure AS d_url_structure, c.cat_id, c.cat_name, c.url_structure AS c_url_structure
			FROM
				tbl_product p
				JOIN designer d ON d.des_id = p.designer
				JOIN tblcat c ON c.cat_id = d.catid
			WHERE
				d.view_status = 'Y'
				AND (p.clearance='yes' OR p.clearance='y')
			ORDER BY
				d.ordering
		");
		return $q;
	}
	
	function get_clearance_bydesigner($des_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT DISTINCT
				p.designer, p.subcat_id, sc.subcat_name, sc.url_structure
			FROM
				tbl_product p
				JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			WHERE
				p.designer = '".$des_id."'
				AND (p.clearance = 'yes' OR p.clearance = 'y')
		");
		return $q;
	}
	
	function get_available_colors($prod_no)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
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
				tp.prod_no = '".$prod_no."'
				AND ts.color_publish = 'Y'
		");
		return $q;
	}

	function get_sizes($cat_id)
	{
		//$DB3 = $this->_load_db();
		
		if ($cat_id == 19) //---> 19 is Accessories category
		{
			$q = $this->db->get_where('tblsize',array('bust'=>1));
		}
		else
		{
			$q = $this->db->query("SELECT * FROM tblsize WHERE bust <> 0");
		}
		
		return $q;	
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

			default:
				$DB = $this->load->database('instylemoscow', TRUE);
		}
		
		return $DB;
	}
*/
}
