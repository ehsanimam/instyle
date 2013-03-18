<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username','Username','required|callback_username_check');
		$this->form_validation->set_rules('password','Password','required|callback_password_check');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->slash_item('template').'login');
		}
		else
		{
			$this->session->set_userdata('site_log_in', TRUE);
			
			if ($this->input->post('page_being_accessed') && $this->input->post('page_being_accessed') != 'search_products')
				$url = $this->input->post('page_being_accessed');
			else
				$url = site_url();
			
			redirect($url, 'location');
		}
	}
	
	function username_check($str)
	{
		$site_uname = array('joe', 'rey', 'rusty', 'admin');
		
		if (in_array($str,$site_uname))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('username_check','The username is invalid.');
			return FALSE;
		}
	}
	
	function password_check($str)
	{
		$site_pword = md5('8775784000');
		
		if (md5($str) == $site_pword)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('password_check','The password is invalid.');
			return FALSE;
		}
	}
}
