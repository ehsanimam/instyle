<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resize extends CI_Controller {
	function __Construct() {
		parent::__Construct();		
		$this->load->helper('image');	
		$this->load->helper('directory');
		$this->load->helper('file');

		$this->load->model('query_category');
		$this->load->model('query_product');
		$this->load->model('query_page');
	}
	
	function index() {
		// Define the path as relative
		$this->load->helper('directory');
		$this->load->helper('file');
		
		$map = directory_map('./product_assets/',3);
		
		foreach($map as $dir1=>$dirValue1) {
			 
			 foreach($dirValue1 as $dir2=>$dirValue2) {
			 	
			 	foreach($dirValue2 as $dir3=>$dirValue3) {
			 		$dir 		 = './product_assets/'.$dir1.'/'.$dir2.'/'.$dirValue3.'/';					
					$thumbs		 = 'thumbs';
					
					// product front
					$source 	 = $dir.'product_front/';
					$destination = $dir.'product_front/';
					$images 	 = directory_map($source);
					
						foreach($images as $image)
						{														
							if(!file_exists($source.$thumbs)) {
								mkdir($source.$thumbs,777);
							}
								$thumb = file_exists($source.$thumbs.'/'.$image);
								
								if(!$thumb) {
									ImageCR($source.$image, 'null', '327*', $destination.$thumbs.'/'.$image);
								}
						}
					
							
					/*	
					// product side
					$source 	 = $dir.'product_side/';
					$destination = $dir.'product_side/';
					$images 	 = directory_map($source);
					
						foreach($images as $image)
						{
							if(!directory_map($source.$thumbs)) {
								mkdir($source.$thumbs,0777);
							}
								$thumb = file_exists($source.$thumbs.'/'.$image);
								
								if(!$thumb) {
									ImageCR($source.$image, 'null', '327*', $destination.$thumbs.'/'.$image);
								}
						}	
					
					// product back				
					$source 	 = $dir.'product_back/';
					$destination = $dir.'product_back/';
					$images 	 = directory_map($source);
					
						foreach($images as $image)
						{
							if(!directory_map($source.$thumbs)) {
								mkdir($source.$thumbs,0777);
							}
								$thumb = file_exists($source.$thumbs.'/'.$image);
								
								if(!$thumb) {
									ImageCR($source.$image, 'null', '327*', $destination.$thumbs.'/'.$image);
								}
						}	
					*/
					
			 	}
			 }
		}
				
		
		echo '<p>Generating thumbs done!</p>';
	}
	
	function single() {
		// Define the path as relative
		
		$thumbs		 = 'thumbs';
		$source 	 = "./product_assets/WMANSAPREL/issuenewyork/evening/product_front/";
		$images = directory_map($source);
 
			//print each file name
			foreach($images as $image)
			{
				if(!directory_map($source.$thumbs)) {
					mkdir($source.$thumbs,0777);
				}
					$thumb = file_exists($source.$thumbs.'/'.$image);
					
					if(!$thumb) {
						ImageCR($source.$image, 'null', '327*', $source.$thumbs.'/'.$image);
					}
			}
		echo '<p>Generating thumbs done...</p>';
	}
	
	function image() {	
				
		$this->load->view('image_resize');
	}
	
	function load_stocks1() {
		$cat_id	= 1;
		$stocks	= 20;
		$get_product = $this->db->get_where('tbl_product',array('cat_id'=>$cat_id));
		
		if($get_product->num_rows() > 0) {
			foreach($get_product->result() as $prod) {
				$get_stock = $this->db->get_where('tbl_stock',array('prod_no'=>$prod->prod_no));
				if($get_stock->num_rows() > 0) {
					//update stock (sizes)
					$st = $get_stock->row();
					  $size_0	= $st->size_0;
					  $size_2	= $st->size_2;
					  $size_4	= $st->size_4;
					  $size_6	= $st->size_6;
					  $size_8	= $st->size_8;
					  $size_10	= $st->size_10;
					  $size_12	= $st->size_12;
					  $size_14	= $st->size_14;
					  $size_16	= $st->size_16;
					  $size_xs	= $st->size_xs;
					  $size_s	= $st->size_s;
					  $size_m	= $st->size_m;
					  $size_l	= $st->size_l;
					  $size_xl	= $st->size_xl;
					  $size_fs	= $st->size_fs;
					  
					  !$size_0 ? $this->db->query("UPDATE tbl_stock SET size_0='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_2 ? $this->db->query("UPDATE tbl_stock SET size_2='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_4 ? $this->db->query("UPDATE tbl_stock SET size_4='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_6 ? $this->db->query("UPDATE tbl_stock SET size_6='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_8 ? $this->db->query("UPDATE tbl_stock SET size_8='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_10 ? $this->db->query("UPDATE tbl_stock SET size_10='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_12 ? $this->db->query("UPDATE tbl_stock SET size_12='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_14 ? $this->db->query("UPDATE tbl_stock SET size_14='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_16 ? $this->db->query("UPDATE tbl_stock SET size_16='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_xs ? $this->db->query("UPDATE tbl_stock SET size_xs='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_s ? $this->db->query("UPDATE tbl_stock SET size_s='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_m ? $this->db->query("UPDATE tbl_stock SET size_m='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_l ? $this->db->query("UPDATE tbl_stock SET size_l='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_xl ? $this->db->query("UPDATE tbl_stock SET size_xl='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  !$size_fs ? $this->db->query("UPDATE tbl_stock SET size_fs='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';
					  
					echo 'updated | ';
				} else {
					//insert new stock
					$colors = explode('-',$prod->colors);
					foreach($colors as $col) {
						$data = array('prod_no'		=> $prod->prod_no,
									  'color_name'	=> $col,
									  'size_0'		=> $stocks,
									  'size_2'		=> $stocks,
									  'size_4'		=> $stocks,
									  'size_6'		=> $stocks,
									  'size_8'		=> $stocks,
									  'size_10'		=> $stocks,
									  'size_12'		=> $stocks,
									  'size_14'		=> $stocks,
									  'size_16'		=> $stocks,
									  'size_xs'		=> $stocks,
									  'size_s'		=> $stocks,
									  'size_m'		=> $stocks,
									  'size_l'		=> $stocks,
									  'size_xl'		=> $stocks,
									  'size_fs'		=> $stocks
									 );
						$this->db->insert('tbl_stock',$data);
					}
					echo 'inserted | ';
				}				
			}
		} else {
			echo 'no product return';
		}
		
	}
	
	function load_stocks19() {
		$cat_id	= 19;
		$stocks	= 20;
		$get_product = $this->db->get_where('tbl_product',array('cat_id'=>$cat_id));
		
		if($get_product->num_rows() > 0) {
			foreach($get_product->result() as $prod) {
				$get_stock = $this->db->get_where('tbl_stock',array('prod_no'=>$prod->prod_no));
				if($get_stock->num_rows() > 0) {
					//update stock (sizes)
						$st 	= $get_stock->row();
					    $size_0	= $st->size_0;
					  
					    !$size_0 ? $this->db->query("UPDATE tbl_stock SET size_0='".$stocks."' WHERE prod_no='".$prod->prod_no."'") : '';					  
					  
					echo 'updated | ';
				} else {
					//insert new stock
					$colors = explode('-',$prod->colors);
					foreach($colors as $col) {
						$data = array('prod_no'		=> $prod->prod_no,
									  'color_name'	=> $col,
									  'size_0'		=> $stocks
									 );
						$this->db->insert('tbl_stock',$data);
					}
					echo 'inserted | ';
				}				
			}
		} else {
			echo 'no product return';
		}
		
	}
}

?>