<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_products extends Frontend_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		$this->data['designers_ary'] = $this->get_designers();
		
		$search = $this->input->post('search');
		$prod_no_string	= $this->input->post('style_no');
		$c_url_structure = $this->input->post('c_url_structure');
		$sc_url_structure = $this->input->post('sc_url_structure');
		
		if ($search)
		{
			// show the serached product thumbs
			$this->show_search_products($prod_no_string, $c_url_structure, $sc_url_structure);
			$this->load->view($this->config->slash_item('template').'template', $this->data);
		}
		else
		{
			// send back to home
			redirect(site_url(), 'location');
		}
	}
}
