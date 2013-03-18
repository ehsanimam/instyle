<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller {
	
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		$this->load->view('maintenance');
	}
}
