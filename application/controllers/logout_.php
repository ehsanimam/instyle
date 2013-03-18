<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller {
	
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		$data = array(
			'admin_logged_in' => FALSE,
		);
		$this->session->unset_userdata($data);
		redirect(site_url(),'location',302);
	}
}
