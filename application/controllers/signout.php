<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signout extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();	
		$this->load->model('query_users');
	}
	
	function index()
	{
		$data = array('user_loggedin'	=> false,
					  'user_id'			=> '',
					  'user_firstname'	=> '',
					  'user_lastname'	=> '',
					  'user_email'		=> ''
					  );
		$this->session->unset_userdata($data);
		redirect(base_url(),'location',301);
	}
}
