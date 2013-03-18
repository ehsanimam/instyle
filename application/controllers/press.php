<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Press extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();	
		$this->load->model('query_page');
	}
	
	function index()
	{
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
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'press.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'				=> 'press',
					  'jscript'				=> $jscript,
					  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'			=> $meta_row->title,
					  'site_keywords'		=> $meta_row->keyword,
					  'site_description'	=> $meta_row->description,
					  'footer_text'			=> $meta_row->dfooter
					 );
		$this->load->view('template',$data);
	}
}
