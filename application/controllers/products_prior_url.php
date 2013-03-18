<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {
		
	function __Construct()
	{
		parent::__Construct();
		
		$this->load->model('query_category');
		$this->load->model('query_product');
		$this->load->model('query_page');
		$this->pattern 		= '/-(c|d|n|r){1}[0-9]/';
		$this->offset		= $this->config->item('items_per_page');
		$this->uri_prefix	= 'page';
		// removing the prefix for the pagination to work properly
		//$this->prefix		= 'page-';
		//$this->suffix		= '.html';
		$this->prefix		= '';
		$this->suffix		= '';
		$this->first_url	= 'page-0'.$this->suffix;
		
		$this->jscript 		= $this->set->jquery();
		
		$this->load->helper('file');
		
		$this->product_js		    = '<link href="'.base_url().'style/cloud-zoom.css" rel="stylesheet" type="text/css"/>';
		$this->product_js		   .= '<link href="'.base_url().'style/product.css" rel="stylesheet" type="text/css"/>';
		$this->product_js 	   	   .= '<script type="text/javascript" src="'.base_url().'jscript/cloud-zoom.1.0.2.min.js"></script>';
		
		// added flowplayer js to play flv videos at product details
		$this->product_js 	   	   .= '<script type="text/javascript" src="'.base_url().'jscript/flowplayer/flowplayer-3.2.6.min.js"></script>';
		// added jstools.js and css for the color mouseover at product details
		$this->product_js 	   	   .= '<script type="text/javascript" src="'.base_url().'assets/js/jstools.js"></script>';
		// added stickytooltip.js and css for the pre-order mouseover at product details
		$this->product_js 	   	   .= '<script type="text/javascript" src="'.base_url().'jscript/stickytooltip/stickytooltip.js"></script>';
		$this->product_js		   .= '<link href="'.base_url().'jscript/stickytooltip/stickytooltip.css" rel="stylesheet" type="text/css"/>';
		
		$this->product_js		   .= $this->query_page->get_qty(); //---> XML script
		$this->product_js		   .= '<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
										<script type="text/javascript" src="'.base_url().'jscript/external/jquery.bgiframe-2.1.3.js"></script>
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
												width: 510,
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
	
	function index()
	{
		/*
		| ------------------------------------------------------------------------------
		| Set and complete uri variables
		*/
		$uri_cat 	= $this->uri->segment(1);		
		
		// for browse by designer
		$exp_uri_cat = explode('-',$this->uri->segment(1));
		if (in_array('designer',$exp_uri_cat))
		{
			$uri_des		 = true;
			$uri_designer	 = $this->uri->segment(2);
			$uri_subcat 	 = $this->uri->segment(3);
			$uri_subsubcat 	 = $this->uri->segment(4);
			
			// This checks if the 3rd segment is for paging
			if (is_numeric($uri_subcat))
			{
				$uri_subcat = '';
			}
			else
			{
				$uri_subcat = $uri_subcat;
			}
		}
		else
		{
			$uri_des		 = false;
			$uri_subcat 	 = $this->uri->segment(2);
			$uri_subsubcat 	 = $this->uri->segment(3);
			
			// This checks if the 3rd segment is for paging
			if (is_numeric($uri_subsubcat))
			{
				$uri_subsubcat = '';
			}
			else
			{
				$uri_subsubcat = $uri_subsubcat;
			}
		}
		
		$jscript  		 	 = $this->jscript;
		
		$offset 		 	 = $this->offset; // ---> items per page
		$item_segment	 	 = '';
		$item				 = '';
		$show_product_detail = false;
		
		/*
		| ------------------------------------------------------------------------------
		| Check to see if url is pointing to a product
		*/
		if ($this->set->ifproduct())
		{
			$show_product_detail = true;
		}
		else
		{
			$show_product_detail = false;
		}
		
		/*
		| ------------------------------------------------------------------------------
		| Product Detail function
		*/
		if ($show_product_detail)
		{
			//echo 'if-1 '; // ---> for debugging purposes
			
			$cat_id 	= $this->set->get_id($this->uri->segment(1));
			$prod_no 	= $this->uri->segment(4);
			$color_code	= $this->set->get_color_code();
			
			$prod_query = $this->query_product->get_product_detail($prod_no, $color_code);
			$prod_query = $prod_query->row();
			
			$count			= 0;
			$num			= 0;
			$prod			= '';
			$primary_file	= 'product_detail';
			$load_file  	= '';
			$load_query 	= $prod_query;
			
			$facet_colors	= strtolower($prod_query->colors);
			$facet_styles	= strtolower($prod_query->styles);
			
			$site_title			= $prod_query->prod_no.' &nbsp; '.str_replace('-',' - ',ucwords($facet_colors).'-'.ucwords($facet_styles).' '.$prod_query->subcat_name);
			$site_keywords		= $prod_query->sc_keyword;
			$site_description	= $prod_query->sc_description;
			$alttags			= $prod_query->sc_alttags;
			$footer_text		= '.';
			$jscript		   .= $this->product_js;
			
			$paging_url			= '';
			$paging_uri_segment	= '';
			
			$search_by_style	= FALSE;
		} 
		elseif ($uri_des && $uri_designer && $uri_subcat) 
		{
			/*
			| ------------------------------------------------------------------------------
			| Browse by designer/subcategory
			*/
			//echo 'If-2 ';
			
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$des_id			= $this->set->get_id($this->uri->segment(2));
			$subcat_id		= $this->set->get_id($this->uri->segment(3));
			
			$primary_file	= 'products';
			$load_file  	= 'list_subcategory';
			$left_nav 		= 'browse_by_designer';
			
			$new_arrival = '';
			$clearance	 = '';
			
			$num			= $this->uri->segment(4) ? $this->set->get_id($this->uri->segment(4)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, $des_id, $subcat_id, '', $new_arrival, $clearance, $num, $this->offset);
			$count			= $this->query_product->get_products_count($cat_id, $des_id, $subcat_id, '', $new_arrival, $clearance)->num_rows();
			$prod			= $load_query->row();
			
			$subcat 		= $this->query_category->get_designers($cat_id);
			$meta 			= $this->query_category->get_meta('tblcat',array('cat_id'=>$cat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$footer_text		= $this->set->get_footer_subcategory($subcat_id);
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			$uri_des			= $this->uri->segment(2);
			$uri_subcat			= $this->uri->segment(3);
			
			// for pagination to work ($paging_uri_segment	= 4;)
			$paging_url			= base_url().$uri_cat.'/'.$uri_des.'/'.rtrim($uri_subcat,'.html').'/';
			$paging_uri_segment = 4;
			
			// added autocomplete.js for search queries
			$jscript .= '<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.css" />';
			$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.min.js"></script>';
			$jscript .= '
				<script type="text/javascript">
					$().ready(function() {
						$("#search_by_style").autocomplete("'.base_url().'jscript/jquery-autocomplete/get_style_list.php?c='.$cat_id.'&d='.$des_id.'&s='.$subcat_id.'", {
							width: 158,
							matchContains: true,
							max: 20,
							selectFirst: false
						});
					});
				</script>
			';

			$search_by_style	= TRUE;
		}
		elseif ($uri_des && $uri_designer) 
		{
			/*
			| ------------------------------------------------------------------------------
			| Browse by designer/category
			*/
			//echo 'If-3 ';
			
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$des_id			= $this->set->get_id($this->uri->segment(2));
			$subcat_id		= '';
			
			$primary_file	= 'products';
			$load_file  	= 'list_subcategory';
			$left_nav 		= 'browse_by_designer';
			
			$new_arrival = '';
			$clearance	 = '';
			
			$num			= $this->uri->segment(3) ? $this->set->get_id($this->uri->segment(3)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, $des_id, '', '', $new_arrival, $clearance, $num, $this->offset);
			$count			= $this->query_product->get_products_count($cat_id, $des_id, '', '', $new_arrival, $clearance)->num_rows();
			$prod			= $load_query->row();
						
			$subcat 		= $this->query_category->get_designers($cat_id);
			$meta 			= $this->query_category->get_meta('tblcat',array('cat_id'=>$cat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$footer_text		= $this->set->get_footer_designer($des_id);
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			$uri_des			= $this->uri->segment(2);
			
			// for pagination to work ($paging_uri_segment	= 3;)
			$paging_url			= base_url().$uri_cat.'/'.rtrim($uri_des,'.html').'/';
			$paging_uri_segment = 3;
			
			// added autocomplete.js for search queries
			$jscript .= '<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.css" />';
			$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.min.js"></script>';
			$jscript .= '
				<script type="text/javascript">
					$().ready(function() {
						$("#search_by_style").autocomplete("'.base_url().'jscript/jquery-autocomplete/get_style_list.php?c='.$cat_id.'&d='.$des_id.'&s='.$subcat_id.'", {
							width: 158,
							matchContains: true,
							max: 20,
							selectFirst: false
						});
					});
				</script>
			';
			
			$search_by_style	= TRUE;
		}
		elseif ($uri_des)
		{
			/*
			| ------------------------------------------------------------------------------
			| Browse by designer
			*/
			//echo 'If-4 ';
			
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$des_id			= '';
			$subcat_id		= '';
			
			$primary_file	= 'products';
			$load_file  	= 'list_designer';
			$left_nav 		= 'browse_by_designer';
			
			$new_arrival = '';
			$clearance	 = '';
			
			$num			= $this->uri->segment(2) ? $this->set->get_id($this->uri->segment(2)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, '', '', '', $new_arrival, $clearance, $num, $this->offset);
			$count			= $this->query_product->get_products_count($cat_id, '', '', '', $new_arrival, $clearance)->num_rows();
			$prod			= $load_query->row();
						
			$subcat 		= $this->query_category->get_designers($cat_id);
			$meta 			= $this->query_category->get_meta('tblcat',array('cat_id'=>$cat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$footer_text		= $this->set->get_footer_category($cat_id);
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			// for pagination to work ($paging_uri_segment	= 2;)
			$paging_url			= base_url().$uri_cat.'/'.rtrim($uri_subcat,'.html').'/';
			$paging_uri_segment = 2;
		
			$search_by_style	= FALSE;
		}
		elseif ( ! $uri_des && $uri_cat && $uri_subcat && $uri_subsubcat)
		{	
			/*		
			| ------------------------------------------------------------------------------
			|  Browse by category/subcategory/subsubcategory
			*/
			//echo 'If-5 ';
			
			$des_id			= '';
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$subcat_id		= $this->set->get_id($this->uri->segment(2));
			$subsubcat_id	= $this->set->get_id($this->uri->segment(3));
			$primary_file	= 'products';
			$load_file  	= 'list_subcategory';
			$left_nav 		= 'browse_by_category';
			
			$new_arrival = '';
			$clearance	 = '';
			
			$num			= $this->uri->segment(4) ? $this->set->get_id($this->uri->segment(4)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, '', $subcat_id, $subsubcat_id, $new_arrival, $clearance, $num, $this->offset);
			$count			= $this->query_product->get_products_count($cat_id, '', $subcat_id, $subsubcat_id, $new_arrival, $clearance)->num_rows();
			$prod			= $load_query->row();
			
			$subcat 		= $this->query_category->get_subcat($cat_id);
			$meta 			= $this->query_category->get_meta('tblsubcat',array('subcat_id'=>$subcat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$footer_text		= $this->set->get_footer_subcategory($subcat_id);
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			$uri_subcat			= $this->uri->segment(2);
			$uri_subsubcat		= $this->uri->segment(3);
			
			// for pagination to work ($paging_uri_segment	= 4;)
			$paging_url			= base_url().$uri_cat.'/'.$uri_subcat.'/'.rtrim($uri_subsubcat,'.html').'/';
			$paging_uri_segment = 4;
			
			// added autocomplete.js for search queries
			$jscript .= '<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.css" />';
			$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.min.js"></script>';
			$jscript .= '
				<script type="text/javascript">
					$().ready(function() {
						$("#search_by_style").autocomplete("'.base_url().'jscript/jquery-autocomplete/get_style_list.php?c='.$cat_id.'&d='.$des_id.'&s='.$subcat_id.'", {
							width: 158,
							matchContains: true,
							max: 20,
							selectFirst: false
						});
					});
				</script>
			';
			
			$search_by_style	= TRUE;
		}
		elseif( ! $uri_des && $uri_cat && $uri_subcat)
		{
			/*
			| ------------------------------------------------------------------------------
			|  Browse by category/subcategory
			*/
			//echo 'If-6 ';
			
			$des_id			= '';
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$subcat_id		= $this->set->get_id($this->uri->segment(2));
			$primary_file	= 'products';
			$load_file  	= 'list_subcategory';
			$left_nav 		= 'browse_by_category';
			
			$new_arrival = '';
			$clearance	 = '';
			
			$num			= $this->uri->segment(3) ? $this->set->get_id($this->uri->segment(3)) : 0;
			
			$load_query 	= $this->query_product->get_products($cat_id, '', $subcat_id, '', $new_arrival, $clearance, $num, $this->offset);
			$count			= $this->query_product->get_products_count($cat_id, '', $subcat_id,'', $new_arrival, $clearance)->num_rows();
			$prod			= $load_query->row();
		
			$subcat 		= $this->query_category->get_subcat($cat_id);
			$meta 			= $this->query_category->get_meta('tblsubcat',array('subcat_id'=>$subcat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$footer_text		= $this->set->get_footer_subcategory($subcat_id);
			$jscript 		   .= $this->set->fade_thumbs_js();
			
			$uri_subcat			= $this->uri->segment(2);
			
			// for pagination to work ($paging_uri_segment	= 3;)
			$paging_url			= base_url().$uri_cat.'/'.rtrim($uri_subcat,'.html').'/';
			$paging_uri_segment = 3;
			
			// added autocomplete.js for search queries
			$jscript .= '<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.css" />';
			$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.min.js"></script>';
			$jscript .= '
				<script type="text/javascript">
					$().ready(function() {
						$("#search_by_style").autocomplete("'.base_url().'jscript/jquery-autocomplete/get_style_list.php?c='.$cat_id.'&d='.$des_id.'&s='.$subcat_id.'", {
							width: 158,
							matchContains: true,
							max: 20,
							selectFirst: false
						});
					});
				</script>
			';
			
			$search_by_style	= TRUE;
		}
		else
		{
			/*
			| ------------------------------------------------------------------------------
			|  Browse by category
			*/
			
			$des_id			= '';
			$cat_id 		= $this->set->get_id($this->uri->segment(1));
			$subcat_id		= '';
			$count			= 0;
			$num			= 0;
			$primary_file	= 'products';
			$load_file  	= 'list_category';
			$left_nav 		= 'browse_by_category';
			$load_query 	= '';
			$prod			= '';
			
			$subcat 		= $this->query_category->get_subcat($cat_id);		
			$meta 			= $this->query_category->get_meta('tblcat',array('cat_id'=>$cat_id));
			$meta 			= $meta->row();
			
			$site_title			= $meta->title;
			$site_keywords		= $meta->keyword;
			$site_description	= $meta->description;
			$alttags			= $meta->alttags;
			$footer_text		= $this->set->get_footer_category($cat_id);
			
			$paging_url			= '';
			$paging_uri_segment	= '';
			
			$search_by_style	= FALSE;
		}
			//echo 'else-7 ';
		
		$unset_data = array('faceted_colors'	=> '',
								'faceted_styles'	=> '',
								'faceted_price'		=> '',
								'faceted_designer'	=> '',
								'faceted_all_colors'=> '',
								'faceted_all_styles'=>'',
								'faceted_all_prices'=>''
							   );
		$this->session->unset_userdata($unset_data);
		
		$this->load->library('pagination');
		$config['base_url'] 	= $paging_url;
		$config['total_rows'] 	= $count;
		$config['uri_segment'] 	= $paging_uri_segment;
		$config['per_page'] 	= $this->offset;
		$config['num_links'] 	= 3;
		/*
		----> Needed to remove this prefix and suffix for the pagination to work
		----> this is set at the construct too
		$config['prefix'] 		= $this->prefix;
		$config['suffix'] 		= $this->suffix;
		$config['first_url']	= $this->first_url;
		*/
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
		$config['cur_tag_open'] = '<span class="current" style="background:#AA0000;">';
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
					  'prod'				=> $prod,
					  'left_nav'			=> @$left_nav,
					  'left_nav_sql'		=> @$subcat,
					  'search_by_style'		=> $search_by_style,
					  'jscript'				=> $jscript,
					  'site_title'			=> $site_title,
					  'site_keywords'		=> $site_keywords,
					  'site_description'	=> $site_description,
					  'alttags'				=> $alttags,
					  'footer_text'			=> $footer_text
					 );
		$this->load->view('template',$data);
	}

	function search_product()
	{
		$search = $this->input->post('search');
		$prod_no_string	= $this->input->post('style_no');
		
		/*
		| ------------------------------------------------------------------------------
		|  Browse by search query
		*/
		
		$primary_file	= 'products';
		$load_file  	= 'list_search_by_style_no';
		$left_nav 		= 'browse_by_category';
		
		$num			= $this->uri->segment(3) ? $this->set->get_id($this->uri->segment(3)) : 0;
		
		$load_query		= $this->query_product->get_search_by_style($prod_no_string, $num, $this->offset);
		$count			= $this->query_product->get_search_by_style($prod_no_string, '', '')->num_rows();
		$prod			= $load_query->row();
		
		$subcat 		= $this->query_category->get_subcat('1');
		$meta 			= $this->query_category->get_meta('tblcat',array('cat_id'=>'1'));
		$meta 			= $meta->row();
		
		$site_title			= $meta->title;
		$site_keywords		= $meta->keyword;
		$site_description	= $meta->description;
		$alttags			= $meta->alttags;
		$footer_text		= $this->set->get_footer_category('1');
		$jscript 			= $this->jscript.$this->set->fade_thumbs_js();
		
		//$uri_subcat			= $this->uri->segment(2);
		
		// for pagination to work ($paging_uri_segment	= 3;)
		//$paging_url			= base_url().$uri_cat.'/'.rtrim($uri_subcat,'.html').'/';
		//$paging_uri_segment = 3;
		
		// added autocomplete.js for search queries
		$jscript .= '<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.css" />';
		$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.min.js"></script>';
		$jscript .= '
			<script type="text/javascript">
				$().ready(function() {
					$("#search_by_style").autocomplete("'.base_url().'jscript/jquery-autocomplete/get_style_list.php", {
						width: 158,
						matchContains: true,
						max: 20,
						selectFirst: false
					});
				});
			</script>
		';
		
		$search_by_style	= TRUE;
		$search_result		= TRUE;
		
		$data = array('file'				=> $primary_file,
					  'product_list'		=> $load_file,
					  'product'				=> $load_query,
					  'prod_no_string'		=> $prod_no_string,
					  'prod'				=> $prod,
					  'left_nav'			=> @$left_nav,
					  'left_nav_sql'		=> @$subcat,
					  'search_by_style'		=> $search_by_style,
					  'search_result'		=> $search_result,
					  'jscript'				=> $jscript,
					  'site_title'			=> $site_title,
					  'site_keywords'		=> $site_keywords,
					  'site_description'	=> $site_description,
					  'alttags'				=> $alttags,
					  'footer_text'			=> $footer_text
					 );
		$this->load->view('template',$data);
	}
}

