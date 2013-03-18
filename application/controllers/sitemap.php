<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends CI_Controller {

	function __Construct()
	{
		parent::__Construct();
		$this->load->model('query_category');
	}
	
	function index()
	{
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'sitemap.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'				=> 'sitemap',
					  'page_title'			=> 'Site Map',
					  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'			=> $meta_row->title,
					  'site_keywords'		=> $meta_row->keyword,
					  'site_description'	=> $meta_row->description,
					  'footer_text'			=> $meta_row->dfooter
					 );
		$this->load->view('template',$data);
	}
}
