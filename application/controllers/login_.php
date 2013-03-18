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
			$this->load->view('login');
		}
		else
		{
			$data = array(
				'admin_username' => $this->input->post('username'),
				'admin_is_logged_in' => TRUE
			);
			$this->session->set_userdata($data);
			redirect(site_url(),'location',302);
		}
	}
	
	function username_check($str)
	{
		$site_uname = array('joe', 'rey', 'rusty');
		
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
		$site_pword = md5('inner@8775784000');
		
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
