<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Product_Frontend_Controller {
	
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		if ($this->uri->segment(3))
		{
			// get the subcat products
			$this->show_subcat_products($this->uri->segment(3),$this->uri->segment(2));
			$this->load->view('template', $this->data);
		}
		else
		{
			// get the subcats
			$this->show_subcats($this->uri->segment(2));
			$this->load->view('template', $this->data);
		}
	}
	
}
