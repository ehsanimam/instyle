<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Frontend_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		$this->data['designers_ary'] = $this->get_designers();
		
		if ($this->uri->segment(3) && ! is_numeric($this->uri->segment(3)))
		{
			// show the product detail page
			$this->show_product_detail($this->uri->segment(2), $this->uri->segment(3));
			$this->load->view($this->config->slash_item('template').'template', $this->data);
		}
		else if ($this->uri->segment(2) !== FALSE)
		{
			if ($this->uri->segment(1) === 'clearance')
			{
				// show the browse by clearance subcategory page
				$this->show_clearance($this->uri->segment(2));
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			else if ($this->uri->segment(1) === 'designers' && in_array($this->uri->segment(2), $this->get_categories()))
			{
				// show the browse by designer page
				$this->show_designers($this->uri->segment(2));
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			else if (in_array($this->uri->segment(2), $this->get_subcategories()))
			{
				// show the subcategory product thumbs (including by designer)
				$this->show_subcat_products($this->uri->segment(1), $this->uri->segment(2));
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			elseif (in_array($this->uri->segment(1), $this->get_designers()))
			{
				// show the designer all thumbs page
				$this->show_designer_subcat_products($this->uri->segment(1), 'paginate');
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			else
			{
				// process 2nd segment for possible faceted search
				$explode_seg2 = explode('-', $this->uri->segment(2));
				$cnt = count($explode_seg2);
				
				if (in_array($explode_seg2[$cnt - 1], $this->get_subcategories()))
				{
					$url_facets = str_replace('-'.$explode_seg2[$cnt - 1], '', $this->uri->segment(2));
					
					// show the subcategory faceted product thumbs (including by designer)
					$this->show_subcat_faceted_products($this->uri->segment(1), $explode_seg2[$cnt - 1], $url_facets);
					$this->load->view($this->config->slash_item('template').'template', $this->data);
				}
				elseif (in_array($explode_seg2[$cnt - 2].'-'.$explode_seg2[$cnt - 1], $this->get_subcategories()))
				{
					$url_facets = str_replace('-'.$explode_seg2[$cnt - 2].'-'.$explode_seg2[$cnt - 1], '', $this->uri->segment(2));
					
					// show the subcategory faceted product thumbs (including by designer)
					$this->show_subcat_faceted_products($this->uri->segment(1), $explode_seg2[$cnt - 2].'-'.$explode_seg2[$cnt - 1], $url_facets);
					$this->load->view($this->config->slash_item('template').'template', $this->data);
				}
				else
				{
					// if all else fails
					show_404();
				}
			}
		}
		elseif ($this->uri->segment(1))
		{
			if ($this->uri->segment(1) === 'clearance')
			{
				// show the browse by clearance subcategory page
				$this->show_clearance();
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			elseif (in_array($this->uri->segment(1), $this->get_pages()))
			{
				// show the static page
				$this->show_page($this->uri->segment(1));
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			elseif (in_array($this->uri->segment(1), $this->get_categories()))
			{
				// show the browse by category page
				$this->show_subcats($this->uri->segment(1));
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			elseif (in_array($this->uri->segment(1), $this->get_designers()))
			{
				// show the designer all thumbs page
				$this->show_designer_subcat_products($this->uri->segment(1));
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			else
			{
				// if all else fails
				show_404();
			}
		}
		else
		{
			echo 'Nothing to do here.';
		}
	}
}
