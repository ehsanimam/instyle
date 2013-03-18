<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		$this->session->sess_destroy();
		redirect(site_url('login'), 'location');
	}
}
