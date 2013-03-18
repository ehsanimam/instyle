<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
//ob_implicit_flush(); // ---> for debuggin purposes

class Admin_Sales_Controller extends MY_Controller
{
	//public $pages_ary = array();
	public $categories_ary = array();
	public $subcategories_ary = array();
	public $designers_ary = array();
	
	public $sa_users_ary = array();
	
	public $default_designer;
	
    function __construct ()
    {
        parent::__construct();
		
		$this->load->model('query_category');
		$this->load->model('query_product');
		$this->load->model('query_users');
		$this->load->model('query_page');
		//$this->load->helper('file');
		
		// ------------------------------------
		// --> currently defaulting to Basix but will need a designer universal code
		//$this->offset = $this->config->item('items_per_page');
		$this->offset = '';
		
		//$pages_ary = $this->get_pages();
		$this->categories_ary = $this->get_categories();
		$this->subcategories_ary = $this->get_subcategories();
		$this->designers_ary = $this->get_designers();
		
		// default designer for admin sales tools
		$this->default_designer = 'basix-black-label';
		$this->sa_users_ary = $this->get_admin_sales_users();
    }
	
	// --------------------------------------------------------------------

	/**
	 * Check if sales admin is logged in
	 *
	 * @access	public
	 * @return	string
	 */
	function check_sales_admin_logged_in($log_out = '')
	{
		if ( ! $this->session->userdata('admin_sales_loggedin'))
		{
			if ($log_out === 'log_out')
			{
				// --> log out
				$html = '
					<script>
						window.location.href="http://www.basixblacklabel.com/sign_in.html";
					</script>
				';
			}
			else
			{
				// --> access not allowed when not logged in
				$html = '
					<script>
						alert("Login required to access the page.");
						window.location.href="http://www.basixblacklabel.com/sign_in.html";
					</script>
				';
			}
			
			echo $html;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Generate the static and static editable pages
	 *
	 * @access	public
	 * @return	string
	 */
	public function show_page($page_title_code)
	{
		/*
		| ------------------------------------------------------------------------------
		| Get the page content using uri segment 2 a reference
		*/
		$get_page = $this->query_page->get_page($page_title_code);
		$row = $get_page->row();
		
		/*
		| ------------------------------------------------------------------------------
		| Get meta data from tblmeta 
		*/
		//$q_meta = $this->db->get_where('tblmeta',array('pagename' => $page_title_code . '.php'));
		$q_meta = $this->query_page->get_page_meta($page_title_code);
		$meta_row = $q_meta->row();
		
		/*
		| ------------------------------------------------------------------------------
		| Set some pertinent scripts for specific pages
		*/
		$jscript = '
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/fancybox/jquery.fancybox-1.3.1.js"></script>
			<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
					$("a.press_group").fancybox({
						"padding"			: 20,
						"cyclic"			: true,
						"autoScale"			: false,
						"showCloseButton"	: true,
						"showNavArrows"		: true,
						"width"				: 750,
						"height"			: "auto",
						"transitionIn"		: "fade",
						"transitionOut"		: "fade"
					});
				});
			</script>
		';
		
		/*
		| ------------------------------------------------------------------------------
		| Set the variables to pass to the view files
		*/
		// Content for other static pages such as Press, Sitemap, Register, & Contact
		$get_page->num_rows() != 0 || $this->data['page'] = $page_title_code;
		$page_title_code !== 'press' || $this->data['jscript'] = $jscript;
		$page_title_code !== 'sitemap' || $this->load->model('query_category');
		$page_title_code !== 'contact' || $this->data['view'] = 'contact_form';
		
		// Content for pages with editable content
		! isset($row->text) || $this->data['page_text'] = $row->text;
		
		// Common content variables
		$this->data['file']				= 'page';
		$this->data['page_title'] 		= isset($row->title) ? $row->title : $meta_row->title;
		$this->data['site_title']		= $meta_row->title;
		$this->data['site_keywords']	= $meta_row->keyword;
		$this->data['site_description']	= $meta_row->description;
		$this->data['footer_text']		= $meta_row->dfooter;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the subcategory thumbs list (general categories)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_subcats($c_url_structure)
	{
		// Get the categories using url structure (@return string - query)
		$subcats = $this->query_category->get_subcat_new($c_url_structure, $this->default_designer);
		
		// Get the categories meta information (@return string - associative array)
		$meta_tags = $this->query_category->get_meta_new('tblcat',array('url_structure'=>$c_url_structure));
		
		// Set some pertinent scripts for the pages
		// Set some pertinent scripts for the pages
		$jscript = $this->set->jquery();
		$jscript .= $this->set->autocomplete().$this->set->jscript_sa_input_field_sessions_1();
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']   		= 'thumbs_list_subcategories';
		$this->data['view_pane_sql'] 	= $subcats;
		$this->data['left_nav'] 		= 'sidebar_browse_by_category';
		$this->data['left_nav_sql'] 	= $subcats;
		$this->data['search_by_style'] 	= TRUE;
		//$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $this->set->jquery();
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
		
		$this->data['c_url_structure']	= $c_url_structure;
		$this->data['sc_url_structure']	= '';
		$this->data['search_by_style']	= TRUE;
		$this->data['jscript'] 			= $jscript;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the designer thumbs list (designer categories)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_designers($c_url_structure)
	{
		// Get the designers using url structure (@return string - query)
		$subcats = $this->query_category->get_designers_new($c_url_structure);
		
		// Get the categories meta information (@return string - associative array)
		$meta_tags = $this->query_category->get_meta_new('tblcat',array('url_structure'=>$c_url_structure));
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']	 	= 'thumbs_list_designers';
		$this->data['view_pane_sql'] 	= $subcats;
		$this->data['left_nav'] 		= 'sidebar_browse_by_designer';
		$this->data['left_nav_sql'] 	= $subcats;
		$this->data['search_by_style'] 	= FALSE;
		//$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= '';
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the product thumbs list (by categories / by designer)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_subcat_products($url_structure, $sc_url_structure)
	{
		// get subcat_id of subcategory, filter = new-arrival/clearance
		$subcat_id = $this->set->get_id_of('subcat', $sc_url_structure);
		$filter = ''; // --> as this has been removed from front end
		
		if (in_array($url_structure, $this->get_categories())) // ---> browse by category
		{
			$c_url_structure = $url_structure;
			$d_url_structure = '';
			
			$cat_id = $this->set->get_id_of('cat', $url_structure);
			$des_id = '';
		
			// Get the subcategories meta information (@return string - associative array)
			$meta_tags = $this->query_category->get_meta_new('tblsubcat',array('url_structure' => $sc_url_structure));
			
			// Get the subcategories using url structure (@return string - query)
			$sidebar_qry = $this->query_category->get_subcat_new($c_url_structure, $this->default_designer);
		
			$browse_by = 'sidebar_browse_by_category';
		}
		
		if (in_array($url_structure, $this->get_designers())) // ---> browse by designer
		{
			$c_url_structure = '';
			$d_url_structure = $url_structure;
		
			$cat_id = '';
			$des_id = $this->set->get_id_of('des', $url_structure);
			
			// Get the designers meta information (@return string - associative array)
			$meta_tags = $this->query_category->get_meta_new('designer',array('url_structure' => $d_url_structure));
			
			$browse_by = 'sidebar_browse_by_designer';
		}
		
		// ------------------------------------
		// --> currently defaulting to Basix but will need a designer universal code
		$d_url_structure = 'basix-black-label';
		
		// Get the products using url structure (@return string - query)
		// Get the products count using url structure (@return string - query)
		$num = ($this->uri->segment(4) !== FALSE) ? $this->uri->segment(4) : 0;
		$products = $this->query_product->get_products_new_for_sa($c_url_structure, $d_url_structure, $sc_url_structure, $num, $this->offset);
		$product_count = $this->query_product->get_products_new_for_sa($c_url_structure, $d_url_structure, $sc_url_structure)->num_rows();
		
		if (in_array($url_structure, $this->get_designers())) // ---> browse by category
		{
			// Get the designer using category url structure (@return string - query)
			$row1 = $products->row_array();
			$url = $this->set->get_caturl($row1['cat_id']);
			$row2 = $url->row_array();
			$c_url_structure = $row2['url_structure'];
			$sidebar_qry = $this->query_category->get_designers_new($c_url_structure);
			$this->data['caturl'] = $c_url_structure;
		}
		
		// Set some pertinent scripts for the pages
		$jscript = $this->set->jquery();
		
		// add the flowplayer javascript
		$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/flowplayer/flowplayer-3.2.6.min.js"></script>';
		$jscript .= '<script type="text/javascript" src="'.base_url().'assets/js/jstools.js"></script>';
		
		// added autocomplete.js for search queries
		$jscript .= $this->set->autocomplete().$this->set->fade_thumbs_js();

		// add ui scripts
		$jscript .= $this->set->jquery_ui();
		
		// add fancybox scripts
		$jscript .= $this->set->jquery_fancybox();
		
		// add xml script
		$jscript .= $this->set->jscript_sa_add_to_cart();
		
		// session sets for input field
		$jscript .= $this->set->jscript_sa_input_field_sessions_2();
		
		// Include the pagination class
		$this->_include_pagination($product_count);
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']	 	= 'thumbs_list_subcategory_products';
		$this->data['view_pane_sql'] 	= $products;
		$this->data['left_nav'] 		= $browse_by;
		$this->data['left_nav_sql'] 	= $sidebar_qry;
		$this->data['search_by_style'] 	= TRUE;
		$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $jscript;
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
		
		$this->data['c_url_structure']	= $c_url_structure;
		$this->data['d_url_structure']	= $d_url_structure;
		$this->data['sc_url_structure']	= $sc_url_structure;
		$this->data['subcat_id'] = $subcat_id;
		$this->data['cat_id'] = $cat_id;
		$this->data['des_id'] = $des_id;
		$this->data['filter'] = $filter;

		// Load facets with variables to pass to the view file
		$this->load->library('myfacets', '', 'facets');
		
		$this->data['qry_color_facet'] = $this->set->get_facets('colors', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_color'] = 'color_facets';
		$this->data['qry_style_facet'] = $this->set->get_facets('styles', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_style'] = 'styles';
		$this->data['qry_material_facet'] = $this->set->get_facets('materials', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_material'] = 'materials';
		$this->data['qry_event_facet'] = $this->set->get_facets('events', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_event'] = 'events';
		$this->data['qry_trend_facet'] = $this->set->get_facets('trends', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_trend'] = 'trends';
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate all product thumbs list of designer
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_designer_subcat_products($url_structure)
	{
		// get subcat_id of subcategory, filter = new-arrival/clearance
		$subcat_id = '';
		$filter = ''; // --> as this has been removed from front end
		
		if (in_array($url_structure, $this->get_designers())) // ---> browse by designer
		{
			$c_url_structure = '';
			$sc_url_structure = '';
			$d_url_structure = $url_structure;
		
			$cat_id = '';
			$des_id = $this->set->get_id_of('des', $url_structure);
			
			// Get the designers meta information (@return string - associative array)
			$meta_tags = $this->query_category->get_meta_new('designer',array('url_structure' => $d_url_structure));
			
			$browse_by = 'sidebar_browse_by_designer';
		}
		
		// Get the products using url structure (@return string - query)
		// Get the products count using url structure (@return string - query)
		$num = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
		$products = $this->query_product->get_products_new($c_url_structure, $d_url_structure, $sc_url_structure, $num, $this->offset);
		$product_count = $this->query_product->get_products_count_new($c_url_structure, $d_url_structure, $sc_url_structure);
		
		if (in_array($url_structure, $this->get_designers())) // ---> browse by designer
		{
			// Get the designer using category url structure (@return string - query)
			$row1 = $products->row_array();
			$url = $this->set->get_caturl($row1['cat_id']);
			$row2 = $url->row_array();
			$c_url_structure = $row2['url_structure'];
			$sidebar_qry = $this->query_category->get_designers_new($c_url_structure);
			$this->data['caturl'] = $c_url_structure;
		}
		
		// Set some pertinent scripts for the pages
		$jscript = $this->set->jquery();
		
		// add the flowplayer javascript
		$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/flowplayer/flowplayer-3.2.6.min.js"></script>';
		
		// added autocomplete.js for search queries
		$jscript .= $this->set->autocomplete().$this->set->fade_thumbs_js();

		// add ui scripts
		$jscript .= $this->set->jquery_ui();
		
		// Include the pagination class
		$this->_include_pagination($product_count);
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']	 	= 'thumbs_list_subcategory_products';
		$this->data['view_pane_sql'] 	= $products;
		$this->data['left_nav'] 		= $browse_by;
		$this->data['left_nav_sql'] 	= $sidebar_qry;
		$this->data['search_by_style'] 	= TRUE;
		$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $jscript;
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
		
		$this->data['c_url_structure']	= $c_url_structure;
		$this->data['d_url_structure']	= $d_url_structure;
		$this->data['sc_url_structure']	= $sc_url_structure;
		$this->data['subcat_id'] = '';
		$this->data['cat_id'] = $cat_id;
		$this->data['des_id'] = $des_id;
		$this->data['filter'] = $filter;

		// Load facets with variables to pass to the view file
		$this->load->library('myfacets', '', 'facets');
		
		$this->data['qry_color_facet'] = $this->set->get_facets('colors', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_color'] = 'color_facets';
		$this->data['qry_style_facet'] = $this->set->get_facets('styles', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_style'] = 'styles';
		$this->data['qry_material_facet'] = $this->set->get_facets('materials', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_material'] = 'materials';
		$this->data['qry_event_facet'] = $this->set->get_facets('events', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_event'] = 'events';
		$this->data['qry_trend_facet'] = $this->set->get_facets('trends', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_trend'] = 'trends';
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the faceted product thumbs list (by categories / by designer)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_subcat_faceted_products($url_structure, $sc_url_structure, $url_facets = '')
	{
		// Load facets
		$this->load->library('myfacets', '', 'facets');
		
		// get subcat_id of subcategory, filter = new-arrival/clearance
		$subcat_id = $this->set->get_id_of('subcat', $sc_url_structure);
		$filter = ''; // --> as this has been removed from front end
		
		if (in_array($url_structure, $this->get_categories())) // ---> browse by category
		{
			$c_url_structure = $url_structure;
			$d_url_structure = '';
			
			$cat_id = $this->set->get_id_of('cat', $url_structure);
			$des_id = '';
		
			// Get the subcategories meta information (@return string - associative array)
			$meta_tags = $this->query_category->get_meta_new('tblsubcat',array('url_structure' => $sc_url_structure));
			
			// Get the subcategories using url structure (@return string - query)
			$sidebar_qry = $this->query_category->get_subcat_new($c_url_structure);
		
			$browse_by = 'sidebar_browse_by_category';
		}
		
		if (in_array($url_structure, $this->get_designers())) // ---> browse by designer
		{
			$c_url_structure = '';
			$d_url_structure = $url_structure;
		
			$cat_id = '';
			$des_id = $this->set->get_id_of('des', $url_structure);
			
			// Get the designers meta information (@return string - associative array)
			$meta_tags = $this->query_category->get_meta_new('designer',array('url_structure' => $d_url_structure));
			
			$browse_by = 'sidebar_browse_by_designer';
		}
		
		// Check url facets against facets
		if ($url_facets != '')
		{
			$url_faceted_colors = 'c-';
			$url_faceted_styles = 's-';
			$url_faceted_events = 'e-';
			$url_faceted_materials = 'm-';
			$url_faceted_trends = 't-';
			
			$exploded_url_facets = explode('-', $url_facets);
			foreach ($exploded_url_facets as $facet)
			{
				if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('colors', $subcat_id, $des_id, $filter), 'color_facets')))
					$url_faceted_colors .= $facet.'-';
				if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('styles', $subcat_id, $des_id, $filter), 'styles')))
					$url_faceted_styles .= $facet.'-';
				if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('events', $subcat_id, $des_id, $filter), 'events')))
					$url_faceted_events .= $facet.'-';
				if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('materials', $subcat_id, $des_id, $filter), 'materials')))
					$url_faceted_materials .= $facet.'-';
				if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('trends', $subcat_id, $des_id, $filter), 'trends')))
					$url_faceted_trends .= $facet.'-';
			}
			
			$facets = substr($url_faceted_colors.$url_faceted_styles.$url_faceted_events.$url_faceted_materials.$url_faceted_trends, 0, -1);
			$search_terms = str_replace('-',' ',$facets);
		}
		
		// Get the products using url structure (@return string - query)
		// Get the products count using url structure (@return string - query)
		$num = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
		$products = $this->query_product->get_search_products_new($cat_id, $subcat_id, $des_id, $search_terms, $num, $this->offset, $filter);
		$product_count = $this->query_product->get_search_products_count_new($cat_id, $subcat_id, $des_id, $search_terms, $filter)->num_rows();
		
		if (in_array($url_structure, $this->get_designers())) // ---> browse by category
		{
			// Get the designer using category url structure (@return string - query)
			$row1 = $products->row_array();
			$url = $this->set->get_caturl($row1['cat_id']);
			$row2 = $url->row_array();
			$c_url_structure = $row2['url_structure'];
			$sidebar_qry = $this->query_category->get_designers_new($c_url_structure);
			$this->data['caturl'] = $c_url_structure;
		}
		
		// Set some pertinent scripts for the pages
		$jscript = $this->set->jquery().$this->set->fade_thumbs_js();
		
		// add the flowplayer javascript
		$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/flowplayer/flowplayer-3.2.6.min.js"></script>';
		
		// added autocomplete.js for search queries
		$jscript .= $this->set->autocomplete();
		
		// Include the pagination class
		$this->_include_pagination($product_count);
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']	 	= 'thumbs_list_search_by_facets';
		$this->data['view_pane_sql'] 	= $products;
		$this->data['left_nav'] 		= $browse_by;
		$this->data['left_nav_sql'] 	= $sidebar_qry;
		$this->data['search_by_style']	= TRUE;
		$this->data['search_result']	= TRUE;
		$this->data['jscript'] 			= $jscript;
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
		
		$this->data['c_url_structure']	= $c_url_structure;
		$this->data['d_url_structure']	= $d_url_structure;
		$this->data['sc_url_structure']	= $sc_url_structure;
		$this->data['subcat_id'] = $subcat_id;
		$this->data['cat_id'] = $cat_id;
		$this->data['des_id'] = $des_id;
		$this->data['filter'] = $filter;

		// facet variables to pass to the view file
		$this->data['url_facets'] = $url_facets;
		$this->data['qry_color_facet'] = $this->set->get_facets('colors', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_color'] = 'color_facets';
		$this->data['qry_style_facet'] = $this->set->get_facets('styles', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_style'] = 'styles';
		$this->data['qry_material_facet'] = $this->set->get_facets('materials', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_material'] = 'materials';
		$this->data['qry_event_facet'] = $this->set->get_facets('events', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_event'] = 'events';
		$this->data['qry_trend_facet'] = $this->set->get_facets('trends', $subcat_id, $des_id, $filter);
		$this->data['facet_field_name_trend'] = 'trends';
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the product thumbs list (by categories / by designer)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_search_products($prod_no_string, $c_url_structure, $sc_url_structure)
	{
		// Get the subcategories meta information (@return string - associative array)
		if ($sc_url_structure != '')
		$meta_tags = $this->query_category->get_meta_new('tblsubcat',array('url_structure' => $sc_url_structure));
		
		// Get the subcategories using url structure (@return string - query)
		// this is for sidebar subcat list
		$sidebar_qry = $this->query_category->get_subcat_new($c_url_structure, $this->default_designer);
	
		$browse_by = 'sidebar_browse_by_category';
		
		// Get the products using product number on search string (@return string - query)
		// Get the products count using product number on search string (@return string - query)
		$products = $this->query_product->get_search_by_style_sa($prod_no_string);
		$product_count = $this->query_product->get_search_by_style_sa($prod_no_string, '', '')->num_rows();
		
		// Set some pertinent scripts for the pages
		$jscript = $this->set->jquery().$this->set->fade_thumbs_js();
		
		// add the flowplayer javascript
		$jscript .= '<script type="text/javascript" src="'.base_url().'jscript/flowplayer/flowplayer-3.2.6.min.js"></script>';
		
		// added autocomplete.js for search queries
		$jscript .= $this->set->autocomplete();
		
		// add fancybox scripts
		$jscript .= $this->set->jquery_fancybox();
		
		// add xml script
		$jscript .= $this->set->jscript_sa_add_to_cart();
		
		// session sets for input field
		$jscript .= $this->set->jscript_sa_input_field_sessions_2();
		
		// Include the pagination class
		$this->_include_pagination($product_count);
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']	 	= 'thumbs_list_search_by_style_no';
		$this->data['view_pane_sql'] 	= $products;
		$this->data['left_nav'] 		= 'sidebar_browse_by_category';
		$this->data['left_nav_sql'] 	= $sidebar_qry;
		$this->data['search_by_style'] 	= FALSE;
		//$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $jscript;
		if ($sc_url_structure != '')
		{
			$this->data['site_title']		= $meta_tags['title'];
			$this->data['site_keywords']	= $meta_tags['keyword'];
			$this->data['site_description']	= $meta_tags['description'];
			$this->data['alttags']			= $meta_tags['alttags'];
			$this->data['footer_text']		= $meta_tags['footer'];
		}
		
		$this->data['caturl'] = $c_url_structure;
		$this->data['search_by_style']	= TRUE;
		$this->data['prod_no_string']	= $prod_no_string;
		$this->data['c_url_structure']	= $c_url_structure;
		$this->data['sc_url_structure']	= $sc_url_structure;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the product thumbs list (by clearance subcategories)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_clearance($sc_url_structure = '')
	{
		// Get meta data of clearance from tblmeta
		$q_meta = $this->query_page->get_page_meta('clearance');
		$meta_row = $q_meta->row();
		
		// Get the clearance subcategories (@return string - query)
		$sidebar_qry = $this->query_category->get_clearance_subcat();
		
		$browse_by = 'sidebar_browse_by_clearance';
		
		if ($sc_url_structure) // ---> browse by clearance's subcategory
		{
			// Get the subcategories meta information (@return string - associative array)
			$meta_tags = $this->query_category->get_meta_new('tblsubcat',array('url_structure' => $sc_url_structure));

			$meta_tags_title = ' - '.$meta_tags['title'];
			$meta_tags_keyword = ' - '.$meta_tags['keyword'];
			$meta_tags_description = ' - '.$meta_tags['description'];
			$meta_tags_alttags = ' - '.$meta_tags['alttags'];
			$meta_tags_footer = ' - '.$meta_tags['footer'];
		}
		else
		{
			$meta_tags_title = '';
			$meta_tags_keyword = '';
			$meta_tags_description = '';
			$meta_tags_alttags = '';
			$meta_tags_footer = '';
		}
		
		// Get the products (@return string - query)
		// Get the products count (@return string - query)
		$num = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
		$products = $this->query_product->get_products_new('', '', $sc_url_structure, $num, $this->offset, $this->uri->segment(1));
		$product_count = $this->query_product->get_products_count_new('', '', $sc_url_structure, $this->uri->segment(1));
		
		// Set some pertinent scripts for page
		$jscript = $this->set->jquery().$this->set->fade_thumbs_js();
		
		// add xml script
		$jscript .= $this->set->jscript_sa_add_to_cart();
		
		// session sets for input field
		$jscript .= $this->set->jscript_sa_input_field_sessions_2();
		
		// Include the pagination class
		$this->_include_pagination($product_count);
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']	 	= 'thumbs_list_subcategory_products';
		$this->data['view_pane_sql'] 	= $products;
		$this->data['left_nav'] 		= $browse_by;
		$this->data['left_nav_sql'] 	= $sidebar_qry;
		$this->data['search_by_style'] 	= FALSE;
		$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $jscript;
		
		$this->data['site_title']		= $meta_row->title.$meta_tags_title;
		$this->data['site_keywords']	= $meta_row->keyword.$meta_tags_keyword;
		$this->data['site_description']	= $meta_row->description.$meta_tags_description;
		$this->data['alttags']			= $meta_tags_alttags;
		$this->data['footer_text']		= $meta_row->dfooter.$meta_tags_footer;
	}
	
	// --------------------------------------------------------------------
	
	// Create the product detail
	/**
	 * Generate the product detail page
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function show_product_detail($prod_no, $color_name)
	{
		// Set some pertinent scripts for specific pages
		$jscript = $this->set->jquery();
		$jscript .= '
			<link href="'.base_url().'style/cloud-zoom.css" rel="stylesheet" type="text/css"/>
			<link href="'.base_url().'style/product.css" rel="stylesheet" type="text/css"/>
			<script type="text/javascript" src="'.base_url().'jscript/cloud-zoom.1.0.2.min.js"></script>
			
			<script type="text/javascript" src="'.base_url().'jscript/flowplayer/flowplayer-3.2.6.min.js"></script>
			
			<script type="text/javascript" src="'.base_url().'assets/js/jstools.js"></script>
			
			<script type="text/javascript" src="'.base_url().'jscript/stickytooltip/stickytooltip.js"></script>
			<link href="'.base_url().'jscript/stickytooltip/stickytooltip.css" rel="stylesheet" type="text/css"/>
		';
		$jscript .= $this->query_page->get_qty(); //---> XML script
		$jscript .= '
			<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
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

					$( "#opener" ).click(function(){
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
		
		if ($this->uri->segment(5) && $this->uri->segment(5) == 'runway-video')
		{
			$color_name = '';
			$this->data['runway_mode']	= TRUE;
		}
		else $this->data['runway_mode']	= FALSE;
		
		// Get the details of the product (@return string - query)
		$prod_qry = $this->query_product->get_product_detail_new($prod_no, $color_name);
		$product = $prod_qry->row_array();
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'product_detail';
		$this->data['product']		 	= $prod_qry->row();
		$this->data['search_by_style'] 	= FALSE;
		$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $jscript;
		$this->data['site_title']		= $product['prod_no'].' - '.ucwords(strtolower($product['color_name'])).' '.$product['prod_name'];
		$this->data['site_keywords']	= '';
		$this->data['site_description']	= $product['prod_desc'];
		$this->data['alttags']			= $product['prod_no'].' - '.$product['prod_name'];
		$this->data['footer_text']		= $product['prod_no'].' - '.ucwords(strtolower($product['color_name'])).' '.$product['prod_name'];;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate an array of pages' url structure
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function get_pages()
	{
		$q = $this->query_page->just_pages();
		$i = 0;
		foreach ($q as $item)
		{
			$ary[$i] = str_replace('.php', '', $item['pagename']);
			$i++;
		}
		return $ary;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate an array of categories' url structure
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function get_categories()
	{
		$q = $this->query_category->just_categories();
		$i = 0;
		foreach ($q as $item)
		{
			$ary[$i] = $item['url_structure'];
			$i++;
		}
		return $ary;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate an array of subcategories' url structure
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function get_subcategories()
	{
		$q = $this->query_category->just_subcategories();
		$i = 0;
		foreach ($q as $item)
		{
			$ary[$i] = $item['url_structure'];
			$i++;
		}
		return $ary;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate an array of designers' url structure
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function get_designers()
	{
		$q = $this->query_category->just_designers();
		$i = 0;
		foreach ($q as $item)
		{
			$ary[$i] = $item['url_structure'];
			$i++;
		}
		return $ary;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the pagiantion config items (common to all product thumbs list)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function _include_pagination($product_count)
	{
		// Prep pagination for the page along with the set style
		$this->load->library('pagination');

		$config['base_url'] = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)).'/';
		$config['total_rows'] = $product_count;
		$config['per_page'] = $this->offset;
		$config['num_links'] 	= 3;
		$config['first_link'] 	= false;
		$config['last_link'] 	= false;
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';		
		$config['cur_tag_open'] = '<span class="current" style="background:#AA0000;">';
		$config['cur_tag_close'] = '</span>';
		$config['prev_link'] = '&laquo; previous';
		$config['next_link'] = 'next &raquo;';

		$this->pagination->initialize($config);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate an array of designers' url structure
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function get_admin_sales_users()
	{
		$q = $this->query_users->just_admin_sales_users();
		$i = 0;
		foreach ($q as $item)
		{
			$ary[$i] = strtolower($item['admin_sales_user']);
			$i++;
			$ary[$i] = strtolower($item['admin_sales_lname']);
			$i++;
			$ary[$i] = $item['admin_sales_email'];
			$i++;
		}
		return $ary;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Display Summary Of Product Line Sheet
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function show_product_linesheet($post_ary, $view_mode = 'summary')
	{
		$this->data['recipients_name'] = isset($post_ary['recipients_name']) ? $post_ary['recipients_name'] : '';
		$this->data['email'] = isset($post_ary['email']) ? $post_ary['email'] : '';
		$this->data['bcc_email'] = isset($post_ary['bcc_email']) ? $post_ary['bcc_email'] : '';
		$thie->data['comments_overall'] = isset($post_ary['comments_overall']) ? $post_ary['comments_overall'] : '';
		
		/*
		| ------------------------------------------------------------------------------
		| Get meta data from tblmeta 
		*/
		//$q_meta = $this->db->get_where('tblmeta',array('pagename' => $page_title_code . '.php'));
		$q_meta = $this->query_page->get_page_meta('product_linesheet');
		$meta_row = $q_meta->row();
		
		/*
		| ------------------------------------------------------------------------------
		| Set some pertinent scripts for specific pages
		*/
		$jscript = $this->set->jquery().'
			<script type="text/javascript" src="'.base_url().'js/spin.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/fancybox/jquery.fancybox-1.3.1.js"></script>
			<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
					$("a.sa_thumbs_group").fancybox({
						"padding"			: 20,
						"cyclic"			: true,
						"autoScale"			: false,
						"showCloseButton"	: true,
						"showNavArrows"		: true,
						"width"				: 750,
						"height"			: "auto",
						"transitionIn"		: "fade",
						"transitionOut"		: "fade"
					});
				});
				function goSpin(id)
				{
					var opts = {
						lines: 13, // The number of lines to draw
						length: 8, // The length of each line
						width: 4, // The line thickness
						radius: 10, // The radius of the inner circle
						rotate: 0, // The rotation offset
						color: \'#000\', // #rgb or #rrggbb
						speed: 1, // Rounds per second
						trail: 60, // Afterglow percentage
						shadow: false, // Whether to render a shadow
						hwaccel: false, // Whether to use hardware acceleration
						className: \'spinner\', // The CSS class to assign to the spinner
						zIndex: 2e9, // The z-index (defaults to 2000000000)
						top: \'auto\', // Top position relative to parent in px
						left: \'auto\' // Left position relative to parent in px
					};
					if (typeof id == "string") target = document.getElementById(id);
					var spinner = new Spinner(opts).spin(target);
				}
				function update_form(qtyID)
				{
					if (document.getElementById(qtyID)) document.getElementById(qtyID).value = 0;
					document.getElementById("product_linesheet_summary").submit();
				}
				function check_product_linesheet_form()
				{
					var alert_msg = "";
					if (document.getElementById("recipients_name").value == "") alert_msg = "Please enter Recipient\'s Name.\n";
					if (document.getElementById("recipients_email").value == "") alert_msg = alert_msg + "Please enter Recipient\'s Email address.\n";
					if (document.getElementById("comments_overall").value == "") alert_msg = alert_msg + "Please enter a message at the Comments field.\n";
					if (alert_msg)
					{
						alert(alert_msg);
						return false;
					}
					
					//var r = confirm("Send package without prices?\n\n(Clicking \"Cancel\" will send package with prices)");
					//if (r)
					//{
						//document.getElementById("w_prices").value = "N";
					//}
					
					return true;
				}
				function gray_e_prices()
				{
					document.getElementById("yes_e_prices").disabled = true;
					document.getElementById("no_e_prices").disabled = true;
					document.getElementById("span_e_prices").style.color = "#d0d0d0";
					document.getElementById("w_prices").value = "N";
					var i = 1;
					while (i != null)
					{
						id_str = "price_div" + i;
						if (document.getElementById(id_str))
						{
							document.getElementById(id_str).innerHTML = "<span style=\"position:relative;left:25px;\">-</span>";
							
							id_upd_btn = "upd_price_btn_" + i;
							if (document.getElementById(id_upd_btn)) document.getElementById(id_upd_btn).style.display = "none";
							
							i++;
						}
						else
						{
							i = null;
						}
					}
				}
				function ungray_e_prices()
				{
					document.getElementById("yes_e_prices").disabled = false;
					document.getElementById("no_e_prices").disabled = false;
					document.getElementById("span_e_prices").style.color = "inherit";
					window.location.href = "product_linesheet_summary.html";
				}
				function edit_prices()
				{
					document.getElementById("is_edit_price").value = "Y";
					
					var i = 1;
					var ii = 1;
					while (i != null)
					{
						id_price_field = "the_price_" + i;
						if (document.getElementById(id_price_field))
						{
							document.getElementById(id_price_field).style.display = "none";
							document.getElementById("price_" + i).style.display = "block";
							document.getElementById(id_price_field).style.display = "none";
							document.getElementById(i + "package_item").style.visibility = "hidden";
							
							var iii = i / 6;
							if (ii == iii)
							{
								id_upd_btn = "upd_price_btn_" + iii;
								document.getElementById(id_upd_btn).style.display = "block";
								ii++
							}
							
							i++;
						}
						else
						{
							if ((i - 1) != (6 * Math.floor(iii)))
							{
								id_upd_btn = "upd_price_btn_" + ii;
								document.getElementById(id_upd_btn).style.display = "block";
							}
							i = null;
						}
					}
				}
				function unedit_prices()
				{
					window.location.href = "product_linesheet_summary.html";
				}
			</script>
		';
		
		// Set some pertinent scripts for the pages
		$jscript .= $this->set->fade_thumbs_js();
		
		/*
		| ------------------------------------------------------------------------------
		| Set the variables to pass to the view files
		*/
		// Content for other static pages such as Press, Sitemap, Register, & Contact
		$this->data['page'] = 'product_linesheet';
		$this->data['jscript'] = $jscript;
		
		// Common content variables
		$this->data['file']				= 'page';
		$this->data['page_title'] 		= isset($row->title) ? $row->title : $meta_row->title;
		$this->data['site_title']		= $meta_row->title;
		$this->data['site_keywords']	= $meta_row->keyword;
		$this->data['site_description']	= $meta_row->description;
		$this->data['footer_text']		= $meta_row->dfooter;
		
		// Variable for prouct line sheet summary view
		$this->data['summary_view']		= $view_mode;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Eamil Sending Of Product Line Sheet
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function send_product_linesheet($post_ary)
	{
		$recipients_name = $post_ary['recipients_name'];
		$email = $post_ary['email'];
		$bcc_email = $post_ary['bcc_email'];
		$comments_overall = $post_ary['comments_overall'];
		$w_prices = $post_ary['w_prices'];
		
		$sales_agent = ucfirst($this->session->userdata('admin_sales_user')).' '.ucfirst($this->session->userdata('admin_sales_lname'));
		$sales_email = $this->session->userdata('admin_sales_email');
		$from_email = 'info@basixblacklabel.com';
		
		if (ENVIRONMENT !== 'development')
		{
			// load library
			$this->load->library('email', $config);
			
			if (ENVIRONMENT === 'development')
			{
				$this->email->set_crlf("\r\n"); // ---> some code to fix the email sending
				$this->email->set_newline("\r\n"); // ---> some code to fix the email sending
			}
			
			// from site info email
			//$this->email->from($from_email, 'Basix Black Label');
			$this->email->from($sales_email, $sales_agent);
			
			// from site info email
			$this->email->reply_to($sales_email, $sales_agent);
			
			// subject
			$this->email->subject('Basix Black Label Products');
			
			$this->email->to($email); // ----> recipients email
			//$this->email->to($this->config->item('dev1_email')); // ----> for debugging purposes
			
			$this->email->cc($sales_email); // copy of sender
			
			$bcc_list = array($bcc_email, $this->config->item('dev1_email'), $this->config->item('dev2_email'), 'joe@innerconcept.com');
			$this->email->bcc($bcc_list);
			
			// access default message content
			require ('sa_email_template.php');
			
			// content
			$this->email->message($email_content);
			
			// attachment
			foreach ($this->cart->contents() as $item):
				$item_no = $item['id'];
				$this->email->attach($item['options']['image_url'].'product_linesheet/'.$item_no.'.jpg');
			endforeach;
			
			if ( ! $this->email->send())
			{
				echo "Email was not sent!";
				if (ENVIRONMENT == 'development')
				{
					echo br().$this->email->print_debugger();
					die();
				}
			}
		}
		else
		{
			// --> debugging purposes
			
			// access default message content
			require ('sa_email_template.php');
			echo $w_prices.'<br />';
			echo $email_content;
			die();
		}
		
		// will need to add a log function before destroying cart
		$this->log_sales_package($post_ary);
		
		// destroy cart
		$this->cart->destroy();
	}
	
	// --------------------------------------------------------------------
	
	function log_sales_package($post_ary)
	{
		// --> this loggin is only for instyle server database
		
		$recipients_name = $post_ary['recipients_name'];
		$email = $post_ary['email'];
		$bcc_email = $post_ary['bcc_email'];
		$comments_overall = $post_ary['comments_overall'];
		
		$sales_agent = ucfirst($this->session->userdata('admin_sales_user')).' '.ucfirst($this->session->userdata('admin_sales_lname'));
		$sales_email = $this->session->userdata('admin_sales_email');
		$from_email = 'info@basixblacklabel.com';
		
		// check if recipient exist already
		$row = $this->query_users->check_sa_recipients_email($email);
		
		if ($row === FALSE)
		{
			// log recipient
			$data = array(
				'email' => $email,
				'name' => $recipients_name
			);
			$this->db->insert('tbladmin_sales_addbook', $data);
			
			// remove reference to last element
			unset($data);
		}
		
		// log items
		$items = '';
		foreach ($this->cart->contents() as $item):
			$items .= $item['id'].', ';
		endforeach;
		$items = substr($items, 0, -2);
		
		$data = array(
			'sent_to' => $email,
			'from' => $sales_email,
			'items' => $items,
			'date_sent' => @date('Y-m-d', time())
		);
		$this->db->insert('tbladmin_sales_log', $data);
		
		// remove reference to last element
		unset($data);
	}
	
	// --------------------------------------------------------------------
	
}