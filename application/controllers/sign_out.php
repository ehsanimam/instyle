<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sign_out extends CI_Controller
{
	function index()
	{
		$DB2 = $this->_load_session_db();
		
		//$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		//$this->cache->clean();
		$this->cart->destroy();
		$data = array(
			'user_loggedin'		=> false,
			'user_id'			=> '',
			'user_cat'			=> '',
			'user_firstname'	=> '',
			'user_lastname'		=> '',
			'user_email'		=> '',
			'user_store_name'	=> '',
			'shipping_courier'	=> '',
			'shipping_fee'		=> '',
			'shipping_id'		=> '',
			'shipping_country'	=> ''
		);
		$this->session->unset_userdata($data);
		redirect(site_url(),'location');
	}
	
	function _load_session_db()
	{
		// load the respective session database
		switch (ENVIRONMENT)
		{
			case 'development':
				$DB = $this->load->database('localmilan', TRUE);
			break;

			case 'testing';
				$DB = $this->load->database('milan', TRUE);
			break;
			
			default:
				$DB = $this->load->database('instyle', TRUE);
		}
		
		return $DB;
	}
}
