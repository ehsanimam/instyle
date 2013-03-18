<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_category extends CI_Model {
	
	function get_meta($table, $id) {
		
		foreach($id as $c=>$i) {			
			$column  = $c;
			$id		 = $i;
		}
		
		$q = $this->db->get_where($table,array($column=>$id));
		return $q;
	}
	
	function get_subcat($cat_id) {
		$q = $this->db->query("SELECT
								  sc.subcat_id, sc.subcat_name, sc.icon_img, sc.folder, sc.styling,
								  sc.title, sc.description, sc.keyword, sc.alttags, sc.url_structure AS sc_url_structure,
								  c.cat_id, c.cat_name, c.url_structure AS c_url_structure
								FROM
								  tblsubcat sc
								  JOIN tblcat c ON c.cat_id = sc.cat_id
								WHERE
								  sc.view_status = 'Y'
								AND
								  c.cat_id = '".$cat_id."'
								ORDER BY
								  sc.ordering
							  ");
		return $q;
	}
	
	function get_subsubcat($subcat_id) {
		$q = $this->db->get_where('tblsubsubcat',array('subcat_id'=>$subcat_id));
		return $q;
	}
	
	function get_designers($cat_id) {
		$q = $this->db->query("SELECT
								  d.des_id, d.designer, d.icon_img, d.folder, d.title, d.description, d.keyword, d.alttags,
								  d.url_structure AS d_url_structure, c.cat_id, c.cat_name, c.url_structure AS c_url_structure
								FROM
								  designer d
								  JOIN tblcat c ON c.cat_id = d.catid
								WHERE
								  d.view_status = 'Y'
								AND
								  c.cat_id = '".$cat_id."'
								ORDER BY
								  d.ordering
							  ");
		return $q;
	}
	
	function get_category_bydesigner($des_id, $cat_id) {
		$q = $this->db->query("SELECT 
									p.designer, p.subcat_id, s.subcat_name, s.url_structure
							    FROM 
									`tbl_product` p, tblsubcat s
								WHERE 
									p.cat_id = '".$cat_id."'
								AND 
									p.subcat_id = s.subcat_id
								AND 
									s.view_status = 'Y' and p.view_status='Y' 
								AND 
									p.designer='".$des_id."'
								GROUP 
									BY p.designer, p.subcat_id
							  ");
		return $q;
	}
	
	function get_products_count($cat_id, $des_id, $subcat_id, $subsubcat_id) {
		if(!empty($subsubcat_id)) {
			$subsub = "AND p.subsubcat_id='".$subsubcat_id."'";
		} else {
			$subsub = "";
		}
		
		if(!empty($subcat_id)) {
			$sub = "AND sc.subcat_id = '".$subcat_id."'";
		} else {
			$sub = "";
		}
		
		if(!empty($des_id)) {
			$des = "AND d.des_id='".$des_id."'";
		} else {
			$des = "";
		}
		
		$q = $this->db->query("SELECT
								  p.prod_id, p.prod_no, p.prod_name, p.prod_desc, p.catalogue_price, p.less_discount,
								  p.primary_img_id, p.subsubcat_id
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								WHERE
								  c.cat_id = '".$cat_id."'
								".$sub."
								".$des."
								".$subsub."
								AND
								  p.view_status = 'Y'
							  ");
		return $q;
	}
	
	function get_products($cat_id, $des_id, $subcat_id, $subsubcat_id, $num, $offset) {
		if(!empty($subsubcat_id)) {
			$subsub = "AND p.subsubcat_id='".$subsubcat_id."'";
		} else {
			$subsub = "";
		}
		
		if(!empty($subcat_id)) {
			$sub = "AND sc.subcat_id = '".$subcat_id."'";
		} else {
			$sub = "";
		}
		
		if(!empty($des_id)) {
			$des = "AND d.des_id='".$des_id."'";
		} else {
			$des = "";
		}
		
		$q = $this->db->query("SELECT
								  p.cat_id, p.subcat_id, p.prod_id, p.prod_no, c.folder AS cat_folder, 
								  p.prod_name, p.prod_desc, p.catalogue_price, 
								  p.less_discount,p.primary_img_id, p.subsubcat_id,
								  d.designer, d.folder, sc.folder AS subcat_folder
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								WHERE
								  c.cat_id = '".$cat_id."'
								".$sub."
								".$des."
								".$subsub."
								AND
								  p.view_status = 'Y'
								LIMIT ".$num.",".$offset."
							  ");
		return $q;
	}
	
	function get_product_detail($prod_id, $color_code) {
		$q = $this->db->query("SELECT
								  p.prod_id, p.prod_name, p.prod_no, tc.color_id, tc.color_code, p.prod_date, p.prod_desc, p.on_sale,
								  p.catalogue_price, p.less_discount, p.primary_img, p.primary_img_id,
								  c.cat_name, c.cat_id, c.title AS c_title, c.description AS c_description, c.folder AS c_folder, 
								  c.keyword AS c_keyword, c.alttags AS c_alttags, c.url_structure AS c_url_structure,
								  sc.subcat_name, sc.folder AS sc_folder, sc.subcat_id, sc.title AS sc_title, sc.description AS sc_description, 
								  sc.keyword AS sc_keyword, sc.alttags AS sc_alttags, sc.url_structure AS sc_url_structure,
								  d.designer, d.folder AS d_folder, d.des_id,
								  tc.color_name
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								  JOIN tbl_stock ts ON ts.prod_id = p.prod_id
								  JOIN tblcolor tc ON tc.color_id = ts.cs_id
								WHERE
								  p.prod_id ='".$prod_id."'
								AND
								  tc.color_code = '".$color_code."'
							  ");
		return $q;
	}	
	
	function get_available_colors($prod_id) {
		$q = $this->db->query("SELECT
									tp.prod_id, tp.prod_no, col.color_code, col.color_name,
									c.folder AS c_folder, c.url_structure AS c_url_structure, sc.folder AS sc_folder,
									sc.subcat_name, d.folder AS des_folder, d.des_id,
									tp.subcat_id, d.url_structure as d_url_structure, sc.url_structure as sc_url_structure
								FROM
									tbl_product tp
									JOIN tblcat c ON c.cat_id = tp.cat_id
									JOIN tblsubcat sc ON sc.subcat_id = tp.subcat_id
									JOIN designer d ON d.des_id = tp.designer
									JOIN tbl_stock ts ON ts.prod_id = tp.prod_id
									JOIN tblcolor col ON col.color_id = ts.cs_id
								WHERE
									tp.prod_id =".$prod_id);
		return $q;
	}
	
	function get_sizes($cat_id) {
		
		if($cat_id == 19) {
			$q = $this->db->get_where('tblsize',array('bust'=>1));
		} else {
			$q = $this->db->query("SELECT * FROM tblsize WHERE bust <> 0");
		}
		
		return $q;	
	}
	
	function get_shipping_method() {
		$q = $this->db->get('tbl_shipmethod');
		return $q;
	}
	
	function get_single_shipping($ship_id) {
		$q = $this->db->get_where('tbl_shipmethod',array('ship_id'=>$ship_id));
		return $q->row();
	}
	
	function get_default_ship_fee() {
		$q = $this->db->get_where('tbl_shipmethod',array('default'=>1));
		return $q->row();
	}
	
}

?>