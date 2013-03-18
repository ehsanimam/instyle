<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faceted_search extends CI_Controller {
		
	function __Construct() {
		parent::__Construct();
		
		$this->load->model('query_category');
		$this->load->model('query_product');
		$this->load->model('query_page');
		$this->pattern 		= '/-(c|d){1}[0-9]/';
		$this->offset		= $this->config->item('items_per_page');
		$this->uri_prefix	= 'page';
		$this->prefix		= 'page-';
		$this->suffix		= '.html';
		$this->first_url	= 'page-0'.$this->suffix;
		
		$this->jscript 		= $this->set->jquery();
		
		$this->load->helper('file');
		
		$this->product_js		    = '<link href="'.base_url().'style/cloud-zoom.css" rel="stylesheet" type="text/css"/>';
		$this->product_js		   .= '<link href="'.base_url().'style/product.css" rel="stylesheet" type="text/css"/>';
		$this->product_js 	   	   .= '<script type="text/javascript" src="'.base_url().'jscript/cloud-zoom.1.0.2.min.js"></script>';
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
	
	function index()
	{
		$cat			 = $this->input->post('cat_id');
		$subcat			 = $this->input->post('subcat_id');
		$des			 = $this->input->post('des_id');
		$colors			 = $this->input->post('colors');
		$styles			 = $this->input->post('styles');
		$events			 = $this->input->post('events');
		$materials		 = $this->input->post('materials');
		$trends			 = $this->input->post('trends');
		
		$faceted_colors	  	 = '';
		$faceted_styles	 	 = '';
		$faceted_events	  	 = '';
		$faceted_materials 	 = '';
		$faceted_trends	  	 = '';
		
		if ($colors)
		{
			foreach ($colors as $c)
			{
				$faceted_colors .= str_replace(' ','_',$c).'-';
			}
			$faceted_colors = 'c-'.$faceted_colors;
			$this->session->set_userdata('faceted_colors',substr($faceted_colors,0,-1));
		}
		else
		{
			$faceted_colors = '';
			$this->session->unset_userdata('faceted_colors');
		}
		
		if ($styles)
		{
			foreach ($styles as $s)
			{
				$faceted_styles .= str_replace(array(' ','/'),array('_','_'),$s).'-';
			}
			$faceted_styles = 's-'.$faceted_styles;
			$this->session->set_userdata('faceted_styles',substr($faceted_styles,0,-1));
		}
		else
		{
			$faceted_styles = '';
			$this->session->unset_userdata('faceted_styles');
		}
		
		if ($events)
		{
			foreach ($events as $e)
			{
				$faceted_events .= str_replace(' ','_',$e).'-';
			}
			$faceted_events = 'e-'.$faceted_events;
			$this->session->set_userdata('faceted_events',substr($faceted_events,0,-1));
		}
		else
		{
			$faceted_events = '';
			$this->session->unset_userdata('faceted_events');
		}
		
		if ($materials)
		{
			foreach ($materials as $m)
			{
				$faceted_materials .= str_replace(' ','_',$m).'-';
			}
			$faceted_materials = 'm-'.$faceted_materials;
			$this->session->set_userdata('faceted_materials',substr($faceted_materials,0,-1));
		}
		else
		{
			$faceted_materials = '';
			$this->session->unset_userdata('faceted_materials');
		}
		
		if ($trends)
		{
			foreach ($trends as $t)
			{
				$faceted_trends .= str_replace(' ','_',$t).'-';
			}
			$faceted_trends = 't-'.$faceted_trends;
			$this->session->set_userdata('faceted_trends',substr($faceted_trends,0,-1));
		}
		else
		{
			$faceted_trends = '';
			$this->session->unset_userdata('faceted_trends');
		}
		
		$facets = substr($faceted_colors.$faceted_styles.$faceted_events.$faceted_materials.$faceted_trends,0,-1);
		
		$cata = explode('-',$cat);
		if ($cat == 'new-arrival' OR $cat == 'new-arrival-designer' OR $cat == 'new-arrival-facets' OR $cat == 'new-arrival-designer-facets')
		{
			$seg = array_splice($cata,0,2); // ----> This takes out all array items after the second item
		}
		else
		{
			$seg = array_splice($cata,0,1); // ----> This takes out all array items after the first item including clearance
		}
		
		foreach($seg as $s) {
			@$sega .= $s.'-';
		}
		
		// a work around for new arrival and clearance for readying url
		if (
			$cat == 'new-arrival' OR 
			$cat == 'clearance' OR 
			$cat == 'new-arrival-designer' OR 
			$cat == 'clearance-designer' OR 
			$cat == 'new-arrival-facets' OR 
			$cat == 'clearance-facets' OR 
			$cat == 'new-arrival-designer-facets' OR 
			$cat == 'clearance-designer-facets'
			)
			$seg_id = '';
		else $seg_id = $this->set->get_id($cat);
		
		if ($des) // ---> if url has designer
		{
			$new_seg1 	= $sega.'designer-facets-'.$seg_id;
			$new_seg2 	= $sega.'designer-'.$seg_id;
			
			// a work around for new arrival and clearance
			if (
				$cat == 'new-arrival' OR 
				$cat == 'clearance' OR 
				$cat == 'new-arrival-designer' OR 
				$cat == 'clearance-designer' OR 
				$cat == 'new-arrival-facets' OR 
				$cat == 'clearance-facets' OR 
				$cat == 'new-arrival-designer-facets' OR 
				$cat == 'clearance-designer-facets'
				)
			{
				//echo 'In'.'<br />';
				//echo $new_seg1.' or '.$new_seg2.'<br />';
				$new_seg1 = substr($new_seg1,0,-1);
				$new_seg2 = substr($new_seg2,0,-1);
			}
			
			$new_seg1 	= $new_seg1.'/'.$des;
			$new_seg2 	= $new_seg2.'/'.$des;
		}
		else
		{
			$new_seg1 	= $sega.'facets-'.$seg_id;
			$new_seg2 	= $sega.$seg_id;
			
			// a work around for new arrival and clearance
			if (
				$cat == 'new-arrival' OR 
				$cat == 'clearance' OR 
				$cat == 'new-arrival-designer' OR 
				$cat == 'clearance-designer' OR 
				$cat == 'new-arrival-facets' OR 
				$cat == 'clearance-facets' OR 
				$cat == 'new-arrival-designer-facets' OR 
				$cat == 'clearance-designer-facets'
				)
			{
				$new_seg1 = substr($new_seg1,0,-1);
				$new_seg2 = substr($new_seg2,0,-1);
			}
		}
		
		if (empty($facets))
		{
			$url = $new_seg2.'/'.$subcat.'.html';
		} else {
			$url = $new_seg1.'/'.$subcat.'/'.$facets.'.html';
		}
		
		redirect($url,'location',302);
	}
	
	function reset_facet()
	{
		$facet_type = $this->uri->segment(3);
		$cat		= $this->uri->segment(4);
		
		$des 		= explode('-',$cat);
		if(in_array('designer',$des)) {				
			$subcat		= $this->uri->segment(6);
			$designer	= $this->uri->segment(5).'/';
			$prefix		= 'designer-';
		} else {			
			$subcat		= $this->uri->segment(5);
			$designer	= '';
			$prefix		= '';
		}
		
		$colors	  	 = $this->session->userdata('faceted_colors');
		$styles	 	 = $this->session->userdata('faceted_styles');
		$events	  	 = $this->session->userdata('faceted_events');
		$materials 	 = $this->session->userdata('faceted_materials');
		$trends	  	 = $this->session->userdata('faceted_trends');
		
		if($facet_type == 'colors') {
			$colors = '';
			$this->session->unset_userdata('faceted_colors');
		} 
		
		if($facet_type == 'styles') {
			// this if operation is for reseting mid facets, needed '-' for accessories
			// may need to implement on others when they become live
			$styles = $cat == 'jewelry-19' ? '-' : ''; // ----> 
			$this->session->unset_userdata('faceted_styles');
		}
		
		if($facet_type == 'events') {
			$events = '';
			$this->session->unset_userdata('faceted_events');
		}
		
		if($facet_type == 'materials') {
			$materials = '';
			$this->session->unset_userdata('faceted_materials');
		}
		
		if($facet_type == 'trends') {
			$trends = '';
			$this->session->unset_userdata('faceted_trends');
		}
		
		$facets = $colors.$styles.$events.$materials.$trends;
		
		$cata	 	= explode('-',$cat);
		if ($cat == 'new-arrival' OR $cat == 'new-arrival-designer' OR $cat == 'new-arrival-facets' OR $cat == 'new-arrival-designer-facets')
		{
			$seg		= array_splice($cata,0,2); // ----> This takes out all array items after the second item
		}
		else
		{
			$seg		= array_splice($cata,0,1); // ----> This takes out all array items after the first item
		}
		
		foreach($seg as $s) {
			@$sega .= $s.'-';
		}
		
		if (
			$cat == 'new-arrival' OR 
			$cat == 'clearance' OR 
			$cat == 'new-arrival-designer' OR 
			$cat == 'clearance-designer' OR 
			$cat == 'new-arrival-facets' OR 
			$cat == 'clearance-facets' OR 
			$cat == 'new-arrival-designer-facets' OR 
			$cat == 'clearance-designer-facets'
			)
			$seg_id  	= '';
		else $seg_id  	= $this->set->get_id($cat);
		
		$new_seg1 	= $sega.$prefix.'facets-'.$seg_id;
		$new_seg2 	= $sega.$prefix.$seg_id;
		
		if (
			$cat == 'new-arrival' OR 
			$cat == 'clearance' OR 
			$cat == 'new-arrival-designer' OR 
			$cat == 'clearance-designer' OR 
			$cat == 'new-arrival-facets' OR 
			$cat == 'clearance-facets' OR 
			$cat == 'new-arrival-designer-facets' OR 
			$cat == 'clearance-designer-facets'
			)
		{
			$new_seg1 = substr($new_seg1,0,-1);
			$new_seg2 = substr($new_seg2,0,-1);
		}
		
		if(empty($facets)) {
			$url = $new_seg2.'/'.$designer.rtrim($subcat,'.html').'.html';
		} else {
			$url = $new_seg1.'/'.$designer.rtrim($subcat,'.html').'/'.$facets.'.html';
		}
		
		redirect($url,'location',302);
	}
	
	function search()
	{
		$cat			 = $this->uri->segment(1);
		$cat_id 		 = $this->set->get_id($cat);
		$des_arr		 = explode('-',$this->uri->segment(1));
		
		if (in_array('arrival',$des_arr))
		{
			$cat_id = '';
			$filter = 'new-arrival';
		}
		else if (in_array('clearance',$des_arr))
		{
			$cat_id = '';
			$filter = 'clearance';
		}
		else $filter = '';
		
		if(in_array('designer',$des_arr))
		{
			$subcat		 = $this->uri->segment(3);
			$subcat_id 	 = $this->set->get_id($subcat);	
			$des		 = $this->uri->segment(2);
			$des_id		 = $this->set->get_id($des);	
			//$facets		 = rtrim($this->uri->segment(4),'.html');
			$facets		 = str_replace('.html','',$this->uri->segment(4));
			$left_nav	 = 'browse_by_designer';
			if ($filter == 'new-arrival') $subcat_left = $this->query_category->get_designers_newarrival();
			else if ($filter == 'clearance') $subcat_left = $this->query_category->get_designers_clearance();
			else $subcat_left = $this->query_category->get_designers($cat_id);
			$designer	 = $des.'/';
			$paging_num	 = 5;
		}
		else
		{
			$subcat		 = $this->uri->segment(2);
			$subcat_id 	 = $this->set->get_id($subcat);		
			//$facets		 = rtrim($this->uri->segment(3),'.html');
			$facets		 = str_replace('.html','',$this->uri->segment(3));
			$des_id		 = '';
			$left_nav	 = 'browse_by_category';
			if ($filter == 'new-arrival') $subcat_left = $this->query_category->get_newarrival();
			else if ($filter == 'clearance') $subcat_left = $this->query_category->get_clearance();
			else $subcat_left = $this->query_category->get_subcat($cat_id);
			$designer	 = '';
			$paging_num	 = 4;
		}
		
		if ( ! empty($facets))
		{
			$search_terms = str_replace('-',' ',$facets);
		}
		else
		{
			$search_terms = '';
		}
		
		$jscript  		 	= $this->jscript;	
		
		$offset 		    = $this->offset;
		$item_segment	    = '';
		$item			    = '';		
		
		$primary_file	= 'products';
		//$load_file  	= 'list_subcategory';
		$load_file  	= 'list_faceted_search';
		
		$num			= $this->uri->segment($paging_num) ? $this->set->get_id($this->uri->segment($paging_num)) : 0;

		$load_query 	= $this->query_product->get_search_products_new($cat_id, $subcat_id, $des_id, $search_terms, $num, $this->offset, $filter);
		$count			= $this->query_product->get_search_products_count_new($cat_id, $subcat_id, $des_id, $search_terms, $filter)->num_rows();
		$prod			= $load_query->row();
		
		$meta 			= $this->query_category->get_meta('tblsubcat',array('subcat_id'=>$subcat_id));
		$meta 			= $meta->row();
		
		$site_title			= $meta->title;
		$site_keywords		= $meta->keyword;
		$site_description	= $meta->description;
		$alttags			= $meta->alttags;
		$jscript 		   .= $this->set->fade_thumbs_js();
		$footer_text		= $this->set->get_footer_subcategory($subcat_id);
		
		if (in_array('designer',$des_arr))
		{
			$paging_url		= base_url().$cat.'/'.$designer.rtrim($subcat,'.html').'/'.$facets.'/';
		} else {
			$paging_url		= base_url().$cat.'/'.rtrim($subcat,'.html').'/'.$facets.'/';
		}
		
		$paging_uri_segment	= $paging_num;
		
		$subcat 			= $subcat_left;
		
		$this->load->library('pagination');
		$config['base_url'] 	= $paging_url;
		$config['total_rows'] 	= $count;
		$config['uri_segment'] 	= $paging_uri_segment;
		$config['per_page'] 	= $this->offset;
		$config['num_links'] 	= $count;
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
		$config['cur_tag_open'] = '<span class="current" style="background:#AA0000;">';
		$config['cur_tag_close'] = '</span>';
		
		$config['prev_link'] = '&laquo; previous';
		$config['prev_tag_open'] = '';
		$config['prev_tag_close'] = '';
		
		$config['next_link'] = 'next &raquo;';
		$config['next_tag_open'] = '';
		$config['next_tag_close'] = '';
		
		$this->pagination->initialize($config);
		
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
			
		$data = array('file'				=> $primary_file,
					  'product_list'		=> $load_file,
					  'product'				=> $load_query,
					  'prod'				=> $prod,
					  'left_nav'			=> $left_nav,
					  'left_nav_sql'		=> $subcat,
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
}
