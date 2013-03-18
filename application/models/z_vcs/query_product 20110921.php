<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_product extends CI_Model {
	
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
								  d.designer, d.folder, sc.folder AS subcat_folder,
								  d.des_id, d.url_structure AS des_url_structure,
								  sc.url_structure AS sc_url_structure,
								  ssc.id AS ssc_subsubcat_id, ssc.url_structure AS ssc_url_structure
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								  LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
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
	
	function get_search_products_count($cat_id, $subcat_id, $price, $designer, $keywords) {
		
		$and_price    = '';
		$and_designer = '';
		
		if($price) {
			foreach($price as $p) {				
				$p = explode('-',$p);
				$and_price  .= ' OR p.catalogue_price >= '.$p[0];
				$and_price  .= ' AND p.catalogue_price <= '.$p[1];
			}
		} else {
			$and_price = '';
		}
		
		if($designer) {
			foreach($designer as $d) {
				@$and_designer .= $d.'-';
			}
			$and_designer = ' OR p.designer IN('.substr($and_designer,0,-1).')';
		} else {
			$and_designer = '';
		}
		
		$q = $this->db->query("SELECT
								  p.prod_id, p.prod_no, p.prod_name, p.prod_desc, p.catalogue_price, p.less_discount,
								  p.primary_img_id, p.subsubcat_id,
									MATCH(p.colors,p.styles,p.events)
									AGAINST('".$keywords."') as keywords
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								WHERE
								  MATCH (p.colors,p.styles,p.events)
								  AGAINST('".$keywords."')
								AND
								  c.cat_id = '".$cat_id."'
								AND
								  sc.subcat_id = '".$subcat_id."'
								AND
								  p.view_status = 'Y'
								".$and_price."  
								".$and_designer."
								");
		return $q;
	}
	
	function get_search_products($cat_id, $subcat_id, $price, $designer, $keywords, $num, $offset) {
		
		$and_price    = '';
		$and_designer = '';
		
		if($price) {
			foreach($price as $p) {				
				$p = explode('-',$p);
				$and_price  .= ' OR p.catalogue_price >= '.$p[0];
				$and_price  .= ' AND p.catalogue_price <= '.$p[1];
			}
		} else {
			$and_price = '';
		}
		
		if($designer) {
			foreach($designer as $d) {
				@$and_designer .= $d.'-';
			}
			$and_designer = ' OR p.designer IN('.substr($and_designer,0,-1).')';
		} else {
			$and_designer = '';
		}
		
		$q = $this->db->query("SELECT
								  p.cat_id, p.subcat_id, p.prod_id, p.prod_no, c.folder AS cat_folder, 
								  p.prod_name, p.prod_desc, p.catalogue_price, 
								  p.less_discount,p.primary_img_id, p.subsubcat_id,
								  d.designer, d.folder, sc.folder AS subcat_folder,
									MATCH(p.colors,p.styles,p.events)
									AGAINST('".$keywords."') as keywords
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								WHERE
								  MATCH (p.colors,p.styles,p.events)
								  AGAINST('".$keywords."')
								AND
								  c.cat_id = '".$cat_id."'
								AND
								  sc.subcat_id = '".$subcat_id."'
								AND
								  p.view_status = 'Y'
								".$and_price."  
								".$and_designer."
								LIMIT ".$num.",".$offset."
							  ");
		return $q;
	}
	
	function get_product_detail($prod_id, $color_code) {
		$q = $this->db->query("SELECT
								  p.prod_id, p.prod_name, p.prod_no, tc.color_id, tc.color_name, tc.color_code, p.prod_date, p.prod_desc, p.on_sale,
								  p.catalogue_price, p.less_discount, p.primary_img, p.primary_img_id,
								  c.cat_name, c.cat_id, c.title AS c_title, c.description AS c_description, c.folder AS c_folder, 
								  c.keyword AS c_keyword, c.alttags AS c_alttags, c.url_structure AS c_url_structure,
								  sc.subcat_name, sc.folder AS sc_folder, sc.subcat_id, sc.title AS sc_title, sc.description AS sc_description, 
								  sc.keyword AS sc_keyword, sc.alttags AS sc_alttags, sc.url_structure AS sc_url_structure,
								  d.designer, d.folder AS d_folder, d.des_id,
								  tc.color_name, ssc.name AS subsubcat_name
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
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
	
	function get_products_oncart($cat_id) {
		$q = $this->db->query("SELECT
								  p.cat_id, p.subcat_id, p.prod_id, p.prod_no, c.folder AS cat_folder, 
								  p.prod_name, p.prod_desc, p.catalogue_price, 
								  p.less_discount,p.primary_img_id, p.subsubcat_id,
								  d.designer, d.folder, sc.folder AS subcat_folder,
								  c.url_structure AS c_url_structure,
								  sc.url_structure As sc_url_structure
								FROM
								  tbl_product p
								  JOIN tblcat c ON c.cat_id = p.cat_id
								  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
								  JOIN designer d ON d.des_id = p.designer
								WHERE
								  c.cat_id = '".$cat_id."'
								AND
								  p.view_status = 'Y'								
								ORDER BY 
								  rand()
								LIMIT 6
							  ");
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
	
	function insert_order_log($data) {
		$this->db->insert('tbl_order_log',$data);
		return $this;
	}
	
	function insert_order_log_detail($data) {
		$this->db->insert('tbl_order_log_details',$data);
		return $this;
	}
	
}
?>