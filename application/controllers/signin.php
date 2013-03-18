<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();	
		$this->load->model('query_users');
	}
	
	function index()
	{
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'login.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'				=> 'signin',
					  'page_footer_meta'	=> $meta_row->dfooter, 					// added this variable for the footer text meta
					  'site_title'			=> $meta_row->title,
					  'site_keywords'		=> $meta_row->keyword,
					  'site_description'	=> $meta_row->description,
					  'footer_text'			=> $meta_row->dfooter
					 );
		$this->load->view('template',$data);
		
	}
	
	function authenticate()
	{
		$email		= $this->input->post('username');
		$password	= $this->input->post('password');
		$control	= $this->input->post('control');
		
		$login_check = $this->query_users->check_login($email,md5($password));
		
		// if authenticated
		if ($login_check == 1)
		{
			$user = $this->query_users->get_single_user_byemail($email);
			$data = array(
				'user_loggedin'		=> true,
				'user_id'			=> $user->user_id,
				'user_firstname'	=> $user->firstname,
				'user_lastname'		=> $user->lastname,
				'user_email'		=> $user->email
			);
			$this->session->set_userdata($data);
			
			if ($control == 'cart')
			{
				$redirect = 'cart/submit_order';
			}
			else
			{
				$redirect = 'home';
			}
			
			redirect($redirect, 'location', 301);
		}
		// if not activated
		else if ($login_check == 2)
		{
			$data = array(
				'file'				=> 'activate',
				'email'				=> $email,
				'pword'				=> $password,
				'site_title'		=> $this->config->item('site_title'),
				'site_keywords'		=> $this->config->item('site_keywords'),
				'site_description'	=> $this->config->item('site_description')
			);
			$this->load->view('template',$data);
		}
		else
		{
			if ($control == 'cart')
			{
				$redirect = 'cart/signin_register';
			}
			else
			{
				$redirect = 'signin';
			}
			
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Invalid email address or password</div>');
			redirect($redirect, 'location', 301);
		}
	}
}

