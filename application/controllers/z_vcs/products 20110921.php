<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {
		
	function __Construct() {
		parent::__Construct();
		
		$this->load->model('query_category');
		$this->load->model('query_product');
		$this->load->model('query_page');
		$this->pattern 		= '/-(c|d){1}[0-9]/';
		$this->offset		= $this->config->item('items_per_page');
		$this->uri_prefix	= 'page';
		$this->prefix		= 'page-p';
		$this->suffix		= '.html';
		$this->first_url	= 'page-p2'.$this->suffix;
		
		$this->jscript 		= $this->set->jquery();
		
		$this->load->helper('file');
		
		$this->product_js		    = '<link href="'.base_url().'style/cloud-zoom.css" rel="stylesheet" type="text/css"/>';
		$this->product_js		   .= '<link href="'.base_url().'style/product.css" rel="stylesheet" type="text/css"/>';
		$this->product_js 	   	   .= '<script type="text/javascript" src="'.base_url().'jscript/cloud-zoom.1.0.2.min.js"></script>';
		// added flowplayer js to play flv videos at product details
		$this->product_js 	   	   .= '<script type="text/javascript" src="'.base_url().'jscript/flowplayer/flowplayer-3.2.2.min.js"></script>';
		$this->product_js		   .= $this->query_page->get_qty();
		$this->product_js		   .= '<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
										<script type="text/javascript" src="'.base_url().'jscript/external/jquery.bgiframe-2.1.1.js"></script>
										<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.core.js"></script>					
										<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.widget.js"></script>
										<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.mouse.js"></script>
										<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.button.js"></script>
										<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.draggable.js"></script>
										<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.position.js"></script>
										<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.dialog.js"></script>
										
										<script>
										// increase the default animation speed to exaggerate the effect
										$.fx.speeds._default = 1000;
										$(function() {
											$( "#dialog" ).dialog({
												autoOpen: false,
												show: "blind",
												hide: "explode",
												width: 600,
												position: "center",
												zIndex: 9999
											});
									
											$( "#opener" ).click(function() {
												$( "#dialog" ).dialog( "open" );
												return false;
											});
											
											$( "#dialogsendfriend" ).dialog({
												autoOpen: false,
												show: "blind",
												hide: "explode",
												width: 500,
												position: "center",
												zIndex: 9999
											});
											$( "#sendfriend" ).click(function() {
												$( "#dialogsendfriend" ).dialog( "open" );
												return false;
											});
										});
										</script>									
									  ';
	}
	
	function index() {
		
		$uri_subsubcat 	 = $this->uri->segment(3);
		$uri_subcat 	 = $this->uri->segment(2);
		$uri_cat 	 	 = $this->uri->segment(1);
		
		$jscript  		 = $this->jscript;
		
		$offset 		 	 = $this->offset;
		$item_segment	 	 = '';
		$item				 = '';
		$show_product_detail = false;
		
		if ($this->set->ifproduct())
		{
			$show_product_detail = true;
			
		} else {
			$show_product_detail = false;
		}
		
		if ($show_product_detail)
		{					
			$prod_id 	= $this->set->get_prod_id();
			$color_code	= $this->set->get_color_code();
						
			$prod_query = $this->query_product->get_product_detail($prod_id, $color_code);
			$prod_query = $prod_query->row();
							
			$count			= 0;
			$num			= 0;
			$primary_file	= 'product_detail';
			$load_file  	= '';
			$load_query 	= $prod_query;
						
			$site_title			= $prod_query->sc_title;
			$site_keywords		= $prod_query->sc_keyword;
			$site_description	= $prod_query->sc_description;
			$alttags			= $prod_query->sc_alttags;
			$jscript		   .= $this->product_js;
			
			$paging_url			= '';
			$paging_uri_segment	= '';
							
		}
		elseif ($uri_cat && preg_match($this->pattern, $uri_cat) && $uri_subcat && preg_match($this->pattern, $uri_subcat) && $uri_subsubcat && preg_match($this->pattern, $uri_subsubcat))
		{
			$cat_id 	  	= $this->set->get_id($this->uri->segment(1));
			$subcat_id	  	= $this->set->get_id($this->uri->segment(2));
			$subsubcat_id 	= $this->set->get_id($this->uri->segment(3));
			$primary_file	= 'products';
			$load_file    	= 'list_subcategory';
			
			$num			= $this->uri->segment(4) ? $this->set->get_id($this->uri->segment(4)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, '', $subcat_id, $subsubcat_id, $num, $this->offset);
			$count 			= $this->query_product->get_products_count($cat_id, '', $subcat_id,$subsubcat_id)->num_rows();
			
			$meta 			= $this->query_category->get_meta('tblsubsubcat',array('id'=>$subsubcat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			$paging_url			= base_url().$uri_cat.'/'.$uri_subcat.'/'.substr($uri_subsubcat,0,-5).'/';
			$paging_uri_segment	= 4;
						
		}
		elseif ($uri_cat && preg_match($this->pattern, $uri_cat) && $uri_subcat && preg_match($this->pattern, $uri_subcat))
		{
		
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$subcat_id		= $this->set->get_id($this->uri->segment(2));
			$primary_file	= 'products';
			$load_file  	= 'list_subcategory';
			
			$num			= $this->uri->segment(3) ? $this->set->get_id($this->uri->segment(3)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, '', $subcat_id, '', $num, $this->offset);
			$count			= $this->query_product->get_products_count($cat_id, '', $subcat_id,'')->num_rows();
			
			$meta 			= $this->query_category->get_meta('tblsubcat',array('subcat_id'=>$subcat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			$isSubcat			= explode('.',$uri_subcat);
			$uri_subcat			= isset($isSubcat) ? $isSubcat[0].'.html' : 'html';
			$paging_url			= base_url().$uri_cat.'/'.substr($uri_subcat,0,-5).'/';
			$paging_uri_segment	= 3;
			
		}
		else
		{
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$subcat_id		= '';
			$count			= 0;
			$num			= 0;
			$primary_file	= 'products';
			$load_file  	= 'list_category';
			$load_query 	= '';
			
			$meta 			= $this->query_category->get_meta('tblcat',array('cat_id'=>$cat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			
			$paging_url			= '';
			$paging_uri_segment	= '';
			
		}
		
		$unset_data = array('faceted_colors'	=> '',
								'faceted_styles'	=> '',
								'faceted_price'		=> '',
								'faceted_designer'	=> '',
								'faceted_all_colors'=> '',
								'faceted_all_styles'=>'',
								'faceted_all_prices'=>''
							   );
		$this->session->unset_userdata($unset_data);
		
		$cat_id = $this->set->get_id($this->uri->segment(1));
		$subcat = $this->query_category->get_subcat($cat_id);
		
		$this->load->library('pagination');
		$config['base_url'] 	= $paging_url;
		$config['total_rows'] 	= $count;
		$config['uri_segment'] 	= $paging_uri_segment;
		$config['per_page'] 	= $this->offset;
		$config['num_links'] 	= 3;
		$config['prefix'] 		= $this->prefix;
		$config['suffix'] 		= $this->suffix;
		$config['first_url']	= $this->first_url;
		$config['first_link'] 	= false;
		$config['last_link'] 	= false;
		
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';		
		
		$config['num_tag_open'] = '';
		$config['num_tag_close'] = '';
		
		/*
		| --------------------------------------------------------------
		| Have set style.css for .pagination .current background color to goldenrod
		| but it seemed not working. Setting inline style here to compensate
		*/
		$config['cur_tag_open'] = '<span class="current" style="background:goldenrod;">';
		$config['cur_tag_close'] = '</span>';
		
		$config['prev_link'] = '&laquo; previous';
		$config['prev_tag_open'] = '';
		$config['prev_tag_close'] = '';
		
		$config['next_link'] = 'next &raquo;';
		$config['next_tag_open'] = '';
		$config['next_tag_close'] = '';

		$this->pagination->initialize($config);
		
		$data = array('file'				=> $primary_file,
					  'product_list'		=> $load_file,
					  'product'				=> $load_query,
					  'left_nav'			=> 'browse_by_category',
					  'left_nav_sql'		=> $subcat,
					  'jscript'				=> $jscript,
					  'site_title'			=> $site_title,
					  'site_keywords'		=> $site_keywords,
					  'site_description'	=> $site_description,
					  'alttags'				=> $alttags
					 );
		$this->load->view('template',$data);
	}
	
	function designer() {
		
		$uri_subcat 	 = $this->uri->segment(3);
		$uri_des	 	 = $this->uri->segment(2);
		$uri_cat 	 	 = $this->uri->segment(1);
		
		$jscript  = $this->jscript;		
		
		$offset 		 	 = $this->offset;
		$item_segment	 	 = '';
		$item				 = '';
		$show_product_detail = false;
		
		if ($this->set->ifproduct())
		{
			$show_product_detail = true;
			
		} else {
			$show_product_detail = false;
		}
		
		if($show_product_detail) {
			
			$prod_id 	= $this->set->get_prod_id();
			$color_code	= $this->set->get_color_code();
				
			$prod_query = $this->query_product->get_product_detail($prod_id, $color_code);
			$prod_query = $prod_query->row();
							
			$count			= 0;
			$num			= 0;
			$primary_file	= 'product_detail';
			$load_file  	= '';
			$load_query 	= $prod_query;
						
			$site_title			= $prod_query->sc_title;
			$site_keywords		= $prod_query->sc_keyword;
			$site_description	= $prod_query->sc_description;
			$alttags			= $prod_query->sc_alttags;
			$jscript		   .= $this->product_js;
			
			$paging_url			= '';
			$paging_uri_segment	= '';
							
		} elseif($uri_cat && preg_match($this->pattern, $uri_cat) && $uri_des && preg_match($this->pattern, $uri_des) && $uri_subcat && preg_match($this->pattern, $uri_subcat)) {
			
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$des_id	  		= $this->set->get_id($this->uri->segment(2));
			$subcat_id 		= $this->set->get_id($this->uri->segment(3));
			$primary_file 	= 'products';
			$load_file  	= 'list_subcategory';
			
			$num			= $this->uri->segment(4) ? $this->set->get_id($this->uri->segment(4)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, $des_id, $subcat_id, '', $num, $this->offset);
			$count			= $this->query_product->get_products_count($cat_id, $des_id, $subcat_id,'')->num_rows();
			
			$meta 			= $this->query_category->get_meta('tblsubcat',array('subcat_id'=>$subcat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			$get_uri_subcat		= substr($uri_subcat,-5) == $this->suffix ? substr($uri_subcat,0,-5) : $uri_subcat;
			
			$paging_url			= base_url().$uri_cat.'/'.$uri_des.'/'.$get_uri_subcat.'/';
			$paging_uri_segment	= 4;
			
			
		} elseif($uri_cat && preg_match($this->pattern, $uri_cat) && $uri_des && preg_match($this->pattern, $uri_des)) {
			
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$des_id			= $this->set->get_id($this->uri->segment(2));
			$primary_file 	= 'products';
			$load_file  	= 'list_subcategory';
			
			$num			= $this->uri->segment(3) ? $this->set->get_id($this->uri->segment(3)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, $des_id, '', '', $num, $this->offset);
			$count			= $this->query_product->get_products_count($cat_id, $des_id, '','')->num_rows();
			
			$meta 			= $this->query_category->get_meta('designer',array('des_id'=>$des_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			$get_uri_des		= substr($uri_des,-5) == $this->suffix ? substr($uri_des,0,-5) : $uri_des;
			
			$paging_url			= base_url().$uri_cat.'/'.$get_uri_des.'/';
			$paging_uri_segment	= 3;
			
		} else {
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$subcat_id		= '';
			$count			= 0;
			$num			= 0;
			$primary_file 	= 'products';
			$load_file  	= 'list_designer';
			$load_query 	= '';
			
			$meta = $this->query_category->get_meta('tblcat',array('cat_id'=>$cat_id));
			$meta = $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			
			$paging_url			= '';
			$paging_uri_segment	= '';
			
		}
		
		$unset_data = array('faceted_colors'	=> '',
								'faceted_styles'	=> '',
								'faceted_price'		=> '',
								'faceted_designer'	=> '',
								'faceted_all_colors'=> '',
								'faceted_all_styles'=>'',
								'faceted_all_prices'=>''
							   );
		$this->session->unset_userdata($unset_data);
		
		$cat_id 	= $this->set->get_id($this->uri->segment(1));
		$designer   = $this->query_category->get_designers($cat_id);
		
		$this->load->library('pagination');
		$config['base_url'] 	= $paging_url;
		$config['total_rows'] 	= $count;
		$config['uri_segment'] 	= $paging_uri_segment;
		$config['per_page'] 	= $this->offset;
		$config['num_links'] 	= 3;
		$config['prefix'] 		= $this->prefix;
		$config['suffix'] 		= $this->suffix;
		$config['first_url']	= $this->first_url;
		$config['first_link'] 	= false;
		$config['last_link'] 	= false;
		
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';		
		
		$config['num_tag_open'] = '';
		$config['num_tag_close'] = '';
		
		/*
		| --------------------------------------------------------------
		| Have set style.css for .pagination .current background color to goldenrod
		| but it seemed not working. Setting inline style here to compensate
		*/
		$config['cur_tag_open'] = '<span class="current" style="background:goldenrod;">';
		$config['cur_tag_close'] = '</span>';
		
		$config['prev_link'] = '&laquo; previous';
		$config['prev_tag_open'] = '';
		$config['prev_tag_close'] = '';
		
		$config['next_link'] = 'next &raquo;';
		$config['next_tag_open'] = '';
		$config['next_tag_close'] = '';
		
		$this->pagination->initialize($config);
		
		$data = array('file'				=> $primary_file,
					  'product_list'		=> $load_file,
					  'product'				=> $load_query,
					  'left_nav'			=> 'browse_by_designer',
					  'left_nav_sql'		=> $designer,
					  'jscript'				=> $jscript,
					  'site_title'			=> $site_title,
					  'site_keywords'		=> $site_keywords,
					  'site_description'	=> $site_description,
					  'alttags'				=> $alttags
					 );
		$this->load->view('template',$data);
		
	}
	

}

?>