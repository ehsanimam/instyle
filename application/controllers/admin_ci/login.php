<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __Construct()
	{
		parent::__Construct();
		
		$this->load->model('query_users');
	}
	
	function index()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username','Username','trim|required|callback_username_check');
		$this->form_validation->set_rules('password','Password','trim|required|md5|callback_password_check');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->slash_item('template').'admin/login');
		}
		else
		{
			// get admin user info
			$user_admin_info = $this->query_users->get_admin_user_info($this->input->post('username'));
			
			// create cookie
			$cookie = array(
				'name'   => 'users_admin_uname',
				'value'  => $user_admin_info['users_admin_uname'],
				'expire' => '605500'
			);
			$this->input->set_cookie($cookie);
			
			// set session
			$data = array(
				'admin_username' => $user_admin_info['users_admin_fname'].' '.$user_admin_info['users_admin_lname'],
				'admin_type' => ucwords($user_admin_info['users_admin_type']),
				'admin_is_logged_in' => TRUE
			);
			$this->session->set_userdata($data);
			
			// set landing page
			if ($this->input->post('page_being_accessed') && $this->input->post('page_being_accessed') != 'search_products')
				$url = $this->input->post('page_being_accessed');
			else
				$url = site_url('admin_ci');
			
			redirect($url, 'location');
		}
	}
	
	function username_check($str)
	{
		if ($this->query_users->check_users_admin_uname($str))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('username_check', 'The username is invalid.');
			return FALSE;
		}
	}
	
	function password_check($str)
	{
		if ($this->query_users->check_users_admin_pword($str))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('password_check', 'The password is invalid.');
			return FALSE;
		}
	}
}
