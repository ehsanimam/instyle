<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Frontend_Controller {

	function __Construct()
	{
		parent::__Construct();
		$this->load->model('query_page');
	}
	
	function index()
	{
		$this->show_page($this->uri->segment(2));
		$this->load->view('template', $this->data);
	}
}
