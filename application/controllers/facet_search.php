<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facet_search extends Frontend_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		$url_structure	 	= $this->input->post('url_structure');
		$sc_url_structure	= $this->input->post('sc_url_structure');
		$ssc_url_structure	= $this->input->post('ssc_url_structure');
		
		$faceted_colors		= $this->_set_facets($this->input->post('color_facets'), 'colors');
		$faceted_styles		= $this->_set_facets($this->input->post('styles'), 'styles');
		$faceted_events		= $this->_set_facets($this->input->post('events'), 'events');
		$faceted_materials 	= $this->_set_facets($this->input->post('materials'), 'materials');
		$faceted_trends		= $this->_set_facets($this->input->post('trends'), 'trends');

		$facets = $faceted_colors.$faceted_styles.$faceted_events.$faceted_materials.$faceted_trends;
		
		//if ($facet == '') $this->session->unset_userdata('facet_search');
		
		// set url to include facets as prefix to subcat
		switch ($this->config->item('site_domain'))
		{
			case 'www.youdomain.com': // --> for domains with subsubcats
				$url = $url_structure.'/'.$sc_url_structure.'/'.$facets.$ssc_url_structure;;
			break;
			
			default:
				$url = $url_structure.'/'.$facets.$sc_url_structure;
		}
		
		redirect($url,'location');
	}
	
	function reset($facet_type, $url_facets, $url_structure, $sc_url_structure, $subcat_id = '', $des_id = '', $filter = '')
	{
		// Load facets
		$this->load->library('myfacets', '', 'facets');
		
		$exploded_url_facets = explode('-', $url_facets);
		foreach ($exploded_url_facets as $facet)
		{
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('colors', $subcat_id, $des_id, $filter), 'color_facets')))
			{
				if ($facet_type == 'colors')
					$url_faceted_colors = '';
				else
					$url_faceted_colors .= $facet.'-';
			}
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('styles', $subcat_id, $des_id, $filter), 'styles')))
			{
				if ($facet_type == 'styles')
					$url_faceted_styles = '';
				else
					$url_faceted_styles .= $facet.'-';
			}
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('events', $subcat_id, $des_id, $filter), 'events')))
			{
				if ($facet_type == 'events')
					$url_faceted_events = '';
				else
					$url_faceted_events .= $facet.'-';
			}
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('materials', $subcat_id, $des_id, $filter), 'materials')))
			{
				if ($facet_type == 'materials')
					$url_faceted_materials = '';
				else
					$url_faceted_materials .= $facet.'-';
			}
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('trends', $subcat_id, $des_id, $filter), 'trends')))
			{
				if ($facet_type == 'trends')
					$url_faceted_trends = '';
				else
					$url_faceted_trends .= $facet.'-';
			}
		}
		
		$facets = $url_faceted_colors.$url_faceted_styles.$url_faceted_events.$url_faceted_materials.$url_faceted_trends;
		
		// set url to include facets as prefix to subcat
		switch ($this->config->item('site_domain'))
		{
			case 'www.youdomain.com': // --> for domains with subsubcats
				$url = $url_structure.'/'.$sc_url_structure.'/'.$facets.$ssc_url_structure;;
			break;
			
			default:
				$url = $url_structure.'/'.$facets.$sc_url_structure;
		}
		
		redirect($url,'location');
	}
	
	function resets($facet_type, $url_facets, $url_structure, $sc_url_structure, $ssc_url_structure, $subsubcat_id = '', $subcat_id = '', $des_id = '', $filter = '')
	{
		// Load facets
		$this->load->library('myfacets', '', 'facets');
		
		$exploded_url_facets = explode('-', $url_facets);
		foreach ($exploded_url_facets as $facet)
		{
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('colors', $subcat_id, $des_id, $filter), 'color_facets')))
			{
				if ($facet_type == 'colors')
					$url_faceted_colors = '';
				else
					$url_faceted_colors .= $facet.'-';
			}
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('styles', $subcat_id, $des_id, $filter), 'styles')))
			{
				if ($facet_type == 'styles')
					$url_faceted_styles = '';
				else
					$url_faceted_styles .= $facet.'-';
			}
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('events', $subcat_id, $des_id, $filter), 'events')))
			{
				if ($facet_type == 'events')
					$url_faceted_events = '';
				else
					$url_faceted_events .= $facet.'-';
			}
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('materials', $subcat_id, $des_id, $filter), 'materials')))
			{
				if ($facet_type == 'materials')
					$url_faceted_materials = '';
				else
					$url_faceted_materials .= $facet.'-';
			}
			if (in_array(str_replace('_', ' ', $facet), $this->facets->extract_facets($this->set->get_facets('trends', $subcat_id, $des_id, $filter), 'trends')))
			{
				if ($facet_type == 'trends')
					$url_faceted_trends = '';
				else
					$url_faceted_trends .= $facet.'-';
			}
		}
		
		$facets = $url_faceted_colors.$url_faceted_styles.$url_faceted_events.$url_faceted_materials.$url_faceted_trends;
		
		// set url to include facets as prefix to subcat
		switch ($this->config->item('site_domain'))
		{
			case 'www.youdomain.com': // --> for domains with subsubcats
				$url = $url_structure.'/'.$sc_url_structure.'/'.$facets.$ssc_url_structure;;
			break;
			
			default:
				$url = $url_structure.'/'.$facets.$sc_url_structure;
		}
		
		redirect($url,'location');
	}
	
	function _set_facets($facet_array, $facet_type)
	{
		//$DB2 = $this->load_session_db();
		
		$faceted_string = '';
		if ($facet_array)
		{
			foreach ($facet_array as $facet)
			{
				$faceted_string .= str_replace(array(' ','/'),array('_','_'),trim($facet)).'-';
			}
			//$this->session->set_userdata('faceted_'.$facet_type, substr($faceted_string,0,-1));
		}
		else
		{
			$faceted_string = '';
			//$this->session->unset_userdata('faceted_'.$facet_type);
		}
		
		return $faceted_string;
	}
}
