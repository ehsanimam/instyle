<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_detail extends Product_Frontend_Controller {
	
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		// get the product details
		$this->show_product_detail($this->uri->segment(3), $this->uri->segment(4));
		$this->load->view('template', $this->data);
	}
	
}
