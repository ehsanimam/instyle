<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller
{
	public $pages_ary = array();
	public $categories_ary = array();
	public $subcategories_ary = array();
	public $desginers_ary = array();
	
    function __construct ()
    {
        parent::__construct();
		
		$this->load->model('query_category');
		$this->load->model('query_product');
		$this->load->model('query_users');
		$this->load->model('query_page');
		$this->load->helper('file');
		
		$this->offset = $this->config->item('items_per_page');
		
		$pages_ary = $this->get_pages();
		$this->categories_ary = $this->get_categories();
		$this->subcategories_ary = $this->get_subcategories();
		$this->subsubcategories_ary = $this->get_subsubcategories();
		$this->desginers_ary = $this->get_designers();
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
		$subcats = $this->query_category->get_subcat_new($c_url_structure);
		
		// Get the categories meta information (@return string - associative array)
		$meta_tags = $this->query_category->get_meta_new('tblcat',array('url_structure'=>$c_url_structure));
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']   		= 'thumbs_list_subcategories';
		$this->data['view_pane_sql'] 	= $subcats;
		$this->data['left_nav'] 		= 'sidebar_browse_by_category';
		$this->data['left_nav_sql'] 	= $subcats;
		$this->data['search_by_style'] 	= FALSE;
		//$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $this->set->jquery();
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the subsubcategory thumbs list (general categories)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_subsubcats($c_url_structure, $sc_url_structure)
	{
		// Get the categories using url structure (@return string - query)
		$subcats = $this->query_category->get_subcat_new($c_url_structure);
		
		// Get the subsubcategories using url structure (@return string - query)
		$subsubcats = $this->query_category->get_subsubcat_new($sc_url_structure);
		
		// Get the subcategories meta information (@return string - associative array)
		$meta_tags = $this->query_category->get_meta_new('tblsubcat',array('url_structure'=>$sc_url_structure));
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']   		= 'thumbs_list_subsubcategories';
		$this->data['view_pane_sql'] 	= $subsubcats;
		$this->data['left_nav'] 		= 'sidebar_browse_by_category';
		$this->data['left_nav_sql'] 	= $subcats;
		$this->data['search_by_style'] 	= FALSE;
		//$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $this->set->jquery();
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
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
	public function show_subcat_products($url_structure, $sc_url_structure, $ssc_url_structure = '')
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
		
		// Get the products using url structure (@return string - query)
		// Get the products count using url structure (@return string - query)
		$num = ($this->uri->segment(3) !== FALSE) ? $this->uri->segment(3) : 0;
		$products = $this->query_product->get_products_new($c_url_structure, $d_url_structure, $sc_url_structure, $ssc_url_structure, $num, $this->offset);
		$product_count = $this->query_product->get_products_count_new($c_url_structure, $d_url_structure, $sc_url_structure, $ssc_url_structure);
		
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
	 * Generate the product thumbs list (by categories / by designer)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_subsubcat_products($url_structure, $sc_url_structure, $ssc_url_structure)
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
		
		// Get the products using url structure (@return string - query)
		// Get the products count using url structure (@return string - query)
		$num = ($this->uri->segment(4) !== FALSE) ? $this->uri->segment(4) : 0;
		$products = $this->query_product->get_products_new($c_url_structure, $d_url_structure, $sc_url_structure, $ssc_url_structure, $num, $this->offset);
		$product_count = $this->query_product->get_products_count_new($c_url_structure, $d_url_structure, $sc_url_structure, $ssc_url_structure);
		
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
		
		// added autocomplete.js for search queries
		$jscript .= $this->set->autocomplete().$this->set->fade_thumbs_js();

		// add ui scripts
		$jscript .= $this->set->jquery_ui();
		
		// Include the pagination class
		$this->_include_pagination($product_count);
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'products_new';
		$this->data['view_pane']	 	= 'thumbs_list_subsubcategory_products';
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
		$this->data['ssc_url_structure']= $ssc_url_structure;
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
	public function show_designer_subcat_products($url_structure, $paginate = '')
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
		if ($paginate != '') $num = $this->uri->segment(2) ? $this->uri->segment(2) : 0;
		else $num = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
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
		$this->_include_pagination($product_count, $paginate);
		
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
	 * Generate the faceted product thumbs list (by categories / by designer)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_subsubcat_faceted_products($url_structure, $sc_url_structure, $ssc_url_structure, $url_facets = '')
	{
		// Load facets
		$this->load->library('myfacets', '', 'facets');
		
		// get subcat_id of subcategory & subsubcatergoy, filter = new-arrival/clearance
		$subcat_id = $this->set->get_id_of('subcat', $sc_url_structure);
		$subsubcat_id = $this->set->get_id_of('subsubcat', $ssc_url_structure);
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
		$num = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
		$products = $this->query_product->get_search_products_new($cat_id, $subcat_id, $des_id, $search_terms, $num, $this->offset, $filter, $subsubcat_id);
		$product_count = $this->query_product->get_search_products_count_new($cat_id, $subcat_id, $des_id, $search_terms, $filter, $subsubcat_id)->num_rows();
		
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
		$this->data['ssc_url_structure']= $ssc_url_structure;
		$this->data['subsubcat_id'] = $subsubcat_id;
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
		// Load facets
		$this->load->library('myfacets', '', 'facets');
		
		// Get the subcategories meta information (@return string - associative array)
		$meta_tags = $this->query_category->get_meta_new('tblsubcat',array('url_structure' => $sc_url_structure));
		
		// Get the subcategories using url structure (@return string - query)
		$sidebar_qry = $this->query_category->get_subcat_new($c_url_structure);
	
		$browse_by = 'sidebar_browse_by_category';
		
		// Get the products using product number on search string (@return string - query)
		// Get the products count using product number on search string (@return string - query)
		$num = $this->uri->segment(2) ? $this->uri->segment(2) : 0;
		$products = $this->query_product->get_search_by_style($prod_no_string, $num, $this->offset);
		$product_count = $this->query_product->get_search_by_style($prod_no_string, '', '')->num_rows();
		
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
		$this->data['view_pane']	 	= 'thumbs_list_search_by_style_no';
		$this->data['view_pane_sql'] 	= $products;
		$this->data['left_nav'] 		= 'sidebar_browse_by_category';
		$this->data['left_nav_sql'] 	= $sidebar_qry;
		$this->data['search_by_style'] 	= FALSE;
		//$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $jscript;
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
		
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
	public function show_clearance($sc_url_structure = '', $d_url_structure = '')
	{
		// get subcat_id of subcategory, filter = new-arrival/clearance
		$subcat_id = $this->set->get_id_of('subcat', $sc_url_structure);
		$filter = 'clearance'; // --> as this has been removed from front end (special access only)
		$des_id = '';
		
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
		
		$this->data['c_url_structure']	= '';
		$this->data['d_url_structure']	= $d_url_structure;
		$this->data['sc_url_structure']	= $sc_url_structure;
		$this->data['subcat_id'] = $subcat_id;
		$this->data['cat_id'] = '';
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
			
			<script type="text/javascript" src="'.base_url().'js/stayontop.js"></script>
			
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
				
				// this code is for the intro image to let users know that
				// they can zoom on the left pane image to view details
				// commentting it for now as this needs further fixing
				/*
				alwaysOnTop.init({ // for internal div
					targetid: "prod_detail_intro",
					orientation: 1,
					hideafter: 3000,
					position: [-508, 93],
					fadeduration: [300, 3000]
				})
				*/
		
			</script>
			
			<style>
				/* style for product detail intro image */
				/*
				#div_loader {
					position: fixed;
					z-index: 10000;
					top: 0px;
					left: 0px;
					background-color: black;
					width: 100%;
					height: 100%;
					filter: Alpha(Opacity=40);
					opacity: 0.6;
					-moz-opacity: 0.6;
					text-align: center;
				}
				*/
				#prod_detail_intro {
					position: relative;
					margin: 0 50% 0;
					z-index: 10001;
					padding: 20px;
					width: 976px;
				}
			</style>
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
	 * Generate an array of subcategories' url structure
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	function get_subsubcategories()
	{
		$q = $this->query_category->just_subsubcategories();
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
	function _include_pagination($product_count, $designer_paginate = '')
	{
		// Prep pagination for the page along with the set style
		$this->load->library('pagination');
		
		if ($designer_paginate != '') $config['base_url'] = base_url($this->uri->segment(1)).'/';
		else $config['base_url'] = base_url($this->uri->segment(1).'/'.$this->uri->segment(2)).'/';

		//$config['base_url'] = base_url($this->uri->segment(1).'/'.$this->uri->segment(2)).'/';
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
	
}