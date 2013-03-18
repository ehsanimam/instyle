<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Frontend_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		// old storybookknits.com site redirects
		$ary_old_urls = array(
			'cust_service.html',
			'cust_service',
			'personal_shopper.htm',
			'personal_shopper',
			'faq.htm',
			'faq',
			'sizing.html',
			'sizing',
			'calendar.htm',
			'calendar',
			'glimpses.htm',
			'glimpses',
			'conitnuity.htm',
			'conitnuity',
			'tell_me.htm',
			'tell_me',
			'design_your_sweater.htm',
			'design_your_sweater',
			'mailist.htm',
			'mailist',
			'oldindex.htm',
			'oldindex',
			'shopping.html',
			'shopping',
			'2002_catalog'
		);
		
		if ($this->uri->segment(1) == '2002_catalog')
		{
			redirect(site_url(), 'location', 301);
		}
		
		$this->data['designers_ary'] = $this->get_designers();
		
		/*if ($this->uri->segment(4) && ! is_numeric($this->uri->segment(4)))
		{
			// show the product detail page
			$this->show_product_detail($this->uri->segment(2), $this->uri->segment(3), $this->uri->segment(4));
			$this->load->view($this->config->slash_item('template').'template', $this->data);
		}
		else*/ if ($this->uri->segment(3) && ! is_numeric($this->uri->segment(3)))
		{
			/*if (in_array($this->uri->segment(3), $this->get_subsubcategories()))
			{
				// show the subsubcategory product thumbs (including by designer)
				$this->show_subsubcat_products($this->uri->segment(1), $this->uri->segment(2), $this->uri->segment(3));
				$this->load->view($this->config->slash_item('template').'template', $this->data);
			}
			else
			{
				// process 3nd segment for possible faceted search
				$explode_seg3 = explode('-', $this->uri->segment(3));
				$cnt = count($explode_seg3);
				
				if (in_array($explode_seg3[$cnt - 1], $this->get_subsubcategories()))
				{
					$url_facets = str_replace('-'.$explode_seg3[$cnt - 1], '', $this->uri->segment(3));
					
					// show the subcategory faceted product thumbs (including by designer)
					$this->show_subsubcat_faceted_products($this->uri->segment(1), $this->uri->segment(2), $explode_seg3[$cnt - 1], $url_facets);
					$this->load->view($this->config->slash_item('template').'template', $this->data);
				}
				elseif (in_array($explode_seg3[$cnt - 2].'-'.$explode_seg3[$cnt - 1], $this->get_subsubcategories()))
				{
					$url_facets = str_replace('-'.$explode_seg3[$cnt - 2].'-'.$explode_seg3[$cnt - 1], '', $this->uri->segment(3));
					
					// show the subcategory faceted product thumbs (including by designer)
					$this->show_subsubcat_faceted_products($this->uri->segment(1), $this->uri->segment(2), $explode_seg3[$cnt - 2].'-'.$explode_seg3[$cnt - 1], $url_facets);
					$this->load->view($this->config->slash_item('template').'template', $this->data);
				}
				elseif (in_array($this->uri->segment(1), $this->get_designers()))
				{*/
					// show the product detail page
					$this->show_product_detail($this->uri->segment(2), $this->uri->segment(3));
					$this->load->view($this->config->slash_item('template').'template', $this->data);
				/*}
				else
				{
					// if all else fails
					show_404();
				}
			}*/
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
				if ($this->config->item('site_domain') === 'www.yourdomain.com')
				{
					// show the browse by subcategory page
					$this->show_subsubcats($this->uri->segment(1), $this->uri->segment(2));
					$this->load->view($this->config->slash_item('template').'template', $this->data);
				}
				else
				{
					// show the subcategory product thumbs (including by designer)
					$this->show_subcat_products($this->uri->segment(1), $this->uri->segment(2));
					$this->load->view($this->config->slash_item('template').'template', $this->data);
				}
			}
			elseif (in_array($this->uri->segment(1), $this->get_designers()) && is_numeric($this->uri->segment(2)))
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
			elseif (in_array($this->uri->segment(1), $ary_old_urls))
			{
				redirect(site_url(), 'location', 301);
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
