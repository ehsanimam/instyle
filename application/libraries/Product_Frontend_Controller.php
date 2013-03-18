<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Frontend_Controller extends MY_Controller
{
    function __construct ()
    {
        parent::__construct();
		$this->load->model('query_category');
		$this->load->model('query_product');
		$this->load->model('query_page');
		$this->load->helper('file');
    }
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the subcategory thumbs list (general categories and designer categories)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_subcats($c_url_structure)
	{
		/*
		| ------------------------------------------------------------------------------
		| Get the categories using url structure (@return string - query)
		*/
		$subcat = $this->query_category->get_subcat_new($c_url_structure);
		
		/*
		| ------------------------------------------------------------------------------
		| Get the categories meta information (@return string - associative array)
		*/
		$meta_tags = $this->query_category->get_meta_new('tblcat',array('url_structure'=>$c_url_structure));
		
		/*
		| ------------------------------------------------------------------------------
		| Set other variables to pass to the view files
		*/
		$this->data['file'] 			= 'products_new';
		$this->data['product_list'] 	= 'thumbs_list_category';
		$this->data['left_nav'] 		= 'sidebar_browse_by_category';
		$this->data['left_nav_sql'] 	= $subcat;
		//$this->data['subcats'] 			= $subcat;
		$this->data['search_by_style'] 	= FALSE;
		$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= $this->set->jquery();
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the designer thumbs list (general categories and designer categories)
	 *
	 * @access	public
	 * @params	string
	 * @return	string
	 */
	public function show_designer_subcats($d_url_structure, $filter = '')
	{
		/*
		| ------------------------------------------------------------------------------
		| Get the categories using url structure (@return string - query)
		*/
		$subcat = $this->query_category->get_designers_new($d_url_structure);
		
		/*
		| ------------------------------------------------------------------------------
		| Get the categories meta information (@return string - associative array)
		*/
		$meta_tags = $this->query_category->get_meta_new('tblcat',array('url_structure'=>$d_url_structure));
		
		/*
		| ------------------------------------------------------------------------------
		| Set other variables to pass to the view files
		*/
		$this->data['file'] 			= 'products_new';
		$this->data['product_list'] 	= 'thumbs_list_designer';
		$this->data['left_nav'] 		= 'sidebar_browse_by_designer';
		$this->data['left_nav_sql'] 	= $subcat;
		$this->data['search_by_style'] 	= FALSE;
		$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= '';
		$this->data['site_title']		= $meta_tags['title'];
		$this->data['site_keywords']	= $meta_tags['keyword'];
		$this->data['site_description']	= $meta_tags['description'];
		$this->data['alttags']			= $meta_tags['alttags'];
		$this->data['footer_text']		= $meta_tags['footer'];
	}
	
	// Create the product thumbs list (general prroducts and desginer products)
	
	// Create the product detail

}