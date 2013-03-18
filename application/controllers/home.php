<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller
{
	function __Construct()
	{
		parent::MY_Users();
		$this->load->model('query_users');
	}
	
	function index()
	{
		$orders = $this->query_users->get_user_orders($this->session->userdata('user_id'));
		$data = array(
			'file'				=> 'users/home',
			'orders'			=> $orders,
			'site_title'		=> $this->config->item('site_title'),
			'site_keywords'		=> $this->config->item('site_keywords'),
			'site_description'	=> $this->config->item('site_description')
		);
		$this->load->view('template',$data);
	}
	
	function order_detail()
	{
		$order_log_id = $this->uri->segment(3);
		$orders  	  = $this->query_users->get_user_order_details($order_log_id );		
		$order_log    = $this->query_users->get_single_order($order_log_id );		
		
		$data = array(
			'file'				=> 'users/order_detail',
			'orders'			=> $orders,
			'log'				=> $order_log,
			'site_title'		=> $this->config->item('site_title'),
			'site_keywords'		=> $this->config->item('site_keywords'),
			'site_description'	=> $this->config->item('site_description')
		);
		$this->load->view('template',$data);
	}
	
	function activation()
	{
		$data = array(
			'file'				=> 'users/activation',
			'site_title'		=> $this->config->item('site_title'),
			'site_keywords'		=> $this->config->item('site_keywords'),
			'site_description'	=> $this->config->item('site_description')
		);
		$this->load->view('template',$data);
	}
	
}
