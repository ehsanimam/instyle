<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designers extends Frontend_Controller {
	
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		if ($this->uri->segment(3))
		{
			if ($this->uri->segment(4))
			{
				// get the designer subcat products
				$this->show_subcat_products_bydesigner($this->uri->segment(4), $this->uri->segment(3), $this->uri->segment(2));
				$this->load->view('template', $this->data);
			}
			else
			{
				// get the designer subcats
				$this->show_designer_subcats($this->uri->segment(3), $this->uri->segment(2));
				$this->load->view('template', $this->data);
			}
		}
		else
		{
			// get the designers and show icons
			$this->show_designers($this->uri->segment(2));
			$this->load->view('template', $this->data);
		}
	}

}

