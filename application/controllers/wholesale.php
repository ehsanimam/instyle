<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wholesale extends Frontend_Controller
{
	function __Construct()
	{
		parent::__Construct();	
	}
	
	function signin()
	{
		//$DB3 = $this->load_db();
	
		//  A possibility except for the sidebar menu (must get rid of it)
		//	$this->show_page('wholesale_signin');
		//	$this->load->view('template', $this->data);
		
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'wholesale_signin.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array(
			'file'				=> 'wholesale_signin',
			'page_footer_meta'	=> $meta_row->dfooter, 					// added this variable for the footer text meta
			'site_title'		=> $meta_row->title,
			'site_keywords'		=> $meta_row->keyword,
			'site_description'	=> $meta_row->description,
			'footer_text'		=> $meta_row->dfooter
		);
		
		$this->load->view($this->config->slash_item('template').'template',$data);
	}
	
	function register()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('pword','Password','required');
		$this->form_validation->set_rules('store_name','Store Name','required');
		$this->form_validation->set_rules('firstname','First Name','required');
		$this->form_validation->set_rules('lastname','Last Name','required');
		$this->form_validation->set_rules('fed_tax_id','Federal Tax ID','');
		$this->form_validation->set_rules('address1','Address 1','required');
		$this->form_validation->set_rules('address2','Address 2','');
		$this->form_validation->set_rules('city','City','required');
		$this->form_validation->set_rules('country','Country','required');
		$this->form_validation->set_rules('state','State','required');
		$this->form_validation->set_rules('zipcode','Zip Code','required');
		$this->form_validation->set_rules('telephone','Telephone','required');
		$this->form_validation->set_rules('fax','Fax','');
		
		if ($this->form_validation->run() == FALSE)
		{
			//$DB2 = $this->_load_session_db();
	
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Please fill up all (*) mandatory fields</div>');
			//redirect($return_url, 'location', 301);
		
			$this->show_page('wholesale_register');
			$this->load->view($this->config->slash_item('template').'template', $this->data);
			/*
			| ------------------------------------------------------------------------------
			| Adding a db query to tblmeta pagename = index.php
			| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
			$pagename = 'wholesale_register.php';
			
			// this is the database query which should be eventually transferred at models/query_page.php
			$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
			$meta_row = $q_meta->row();
			
			$data = array(
				'file'				=> 'wholesale_register',
				'page_footer_meta'	=> $meta_row->dfooter, 					// added this variable for the footer text meta
				'site_title'		=> $meta_row->title,
				'site_keywords'		=> $meta_row->keyword,
				'site_description'	=> $meta_row->description,
				'footer_text'		=> $meta_row->dfooter
			);
			$this->load->view('template',$data);
			*/
		}
		else
		{
			$email				= $this->input->post('email');
			$pword				= $this->input->post('pword');
			$store_name			= $this->input->post('store_name');
			$firstname			= $this->input->post('firstname');
			$lastname			= $this->input->post('lastname');
			$fed_tax_id			= $this->input->post('fed_tax_id');
			$address1			= $this->input->post('address1');
			$address2			= $this->input->post('address2');
			$city				= $this->input->post('city');
			$country			= $this->input->post('country');
			$state				= $this->input->post('state');
			$zipcode			= $this->input->post('zipcode');
			$telephone			= $this->input->post('telephone');
			$fax				= $this->input->post('fax');
			
			$return_url = site_url('wholesale/register');
			$redirect	= site_url('wholesale/register_complete');
		
			if ($this->query_users->check_ifemail_exist2($email))
			{
				//$DB2 = $this->_load_session_db();
	
				$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">The email address you entered is already taken</div>');
				redirect($return_url, 'location', 301);
			}
			
			$DB3 = $this->_load_db();
			
			// insert to tbluser_data_wholsale
			$data = array(
				'email'				=> $email,
				'pword'				=> $pword,
				'store_name'		=> $store_name,
				'firstname'			=> $firstname,
				'lastname'			=> $lastname,
				'fed_tax_id'		=> $fed_tax_id,
				'address1'			=> $address1,
				'address2'			=> $address2,
				'city'				=> $city,
				'country'			=> $country,
				'state'				=> $state,
				'zipcode'			=> $zipcode,
				'telephone'			=> $telephone,
				'fax'				=> $fax,
				'create_date'		=> date('Y-m-d', time())
			);
			$this->query_users->insert_wholesale_user($data);
			$user_id = $this->db->insert_id();
			
			// insert or update to tbl_login_detail_wholesale
			$this->query_users->update_login_detail($user_id,'wholesale');
		
			// notification to admin - begin email to admin
				$email_message_to_admin = '
					The following just registered for wholesale info at '.$this->config->item('site_name').'
					<br />
					<table border="0" cellspacing="0" cellpadding="5">
						<tr><td>Username:</td><td>'.$email.'</td></tr>
						<tr><td>Name:</td><td>'.$firstname.' '.$lastname.'</td></tr>
						<tr><td>Store Name:</td><td>'.$store_name.'</td></tr>
					</table>
					<br />
					Click <a href="'.base_url().'admin/user_edit_popup_wholesale.php?eid='.$email.'&control=admin">here</a> to see his profile and activate or deny.
					<br /><br />
					Details are as follows:
					<table border="0" cellspacing="0" cellpadding="5">
						<tr><td>Email:</td><td>'.$email.'</td></tr>
						<tr><td>Password:</td><td>'.$pword.'</td></tr>
						<tr><td>Store Name:</td><td>'.$store_name.'</td></tr>
						<tr><td>First & Lat Names:</td><td>'.$firstname.' '.$lastname.'</td></tr>
						<tr><td>Federal Tax ID:</td><td>'.$fed_tax_id.'</td></tr>
						<tr><td>Address 1:</td><td>'.$address1.'</td></tr>
						<tr><td>Address 2:</td><td>'.$address2.'</td></tr>
						<tr><td>City:</td><td>'.$city.'</td></tr>
						<tr><td>Country:</td><td>'.$country.'</td></tr>
						<tr><td>State:</td><td>'.$state.'</td></tr>
						<tr><td>Zipcode:</td><td>'.$zipcode.'</td></tr>
						<tr><td>Telephone:</td><td>'.$telephone.'</td></tr>
						<tr><td>Fax:</td><td>'.$fax.'</td></tr>
					</table>
				';
				
				$this->load->library('email', $config);
				
			// begin send email info, response to admin
				
				$this->email->from($this->config->item('info_email'), $this->config->item('site_name'));
				
				if (ENVIRONMENT === 'development')
				{
					$this->email->to($this->config->item('dev1_email')); // ----> for debugging purposes
				}
				else
				{
					$this->email->to($this->config->item('info_email'));
					$this->email->bcc($this->config->item('dev1_email'), $this->config->item('dev2_email')); // ----> for debugging purposes
				}
				
				$this->email->subject('Wholesale Registration At '.$this->config->item('site_name'));
				$this->email->message($email_message_to_admin);
				
				if ( ! $this->email->send())
				{
					echo "Email was not sent";
					echo $this->email->print_debugger();
					exit();
				}
			// end send email info
			
			redirect($redirect, 'location');
		}
	}
	
	function authenticate()
	{
		$email		= $this->input->post('username');
		$password	= $this->input->post('password');
		//$control	= $this->input->post('control'); // ---> not present in wholesale/signing
		
		$login_check = $this->query_users->check_login($email,$password,'wholesale');
		
		// if authenticated
		if ($login_check == 1)
		{
			$user = $this->query_users->get_wholesale_user_byemail($email);
			
			//$DB2 = $this->_load_session_db();
			
			$data = array(
				'user_loggedin'		=> true,
				'user_cat'			=> 'wholesale',
				'user_id'			=> $user->user_id,
				'user_firstname'	=> $user->firstname,
				'user_lastname'		=> $user->lastname,
				'user_store_name'	=> $user->store_name,
				'user_email'		=> $user->email,
				'shipping_country'	=> $user->country
			);
			$this->session->set_userdata($data);
			
			// update login details
			$this->query_users->update_login_detail($user->user_id,'wholesale');
			
			redirect(site_url('apparel'), 'location', 301);
		}
		// if not activated
		else if ($login_check == 2)
		{
			$data = array(
				'file'				=> 'inactive',
				'email'				=> $email,
				'pword'				=> $password,
				'site_title'		=> $this->config->item('site_title'),
				'site_keywords'		=> $this->config->item('site_keywords'),
				'site_description'	=> $this->config->item('site_description')
			);
			$this->load->view($this->config->slash_item('template').'template',$data);
		}
		// if not registered
		else
		{
			//$DB2 = $this->_load_session_db();
			
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Invalid email address or password</div>');
			redirect('wholesale/signin', 'location', 301);
		}
	}
	
	function register_complete()
	{
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'wholesale_register.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'					=> 'wholesale_register_complete',
					  'jscript'					=> '',
					  'page_footer_meta'		=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'				=> $this->config->item('site_title'),
					  'site_keywords'			=> $this->config->item('site_keywords'),
					  'site_description'		=> $this->config->item('site_description'),
					  'footer_text'				=> $meta_row->dfooter
					 );
		$this->load->view($this->config->slash_item('template').'template',$data);
	}
	
	function reset_password()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','Email','required|valid_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			$DB2 = $this->_load_session_db();
			
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Please enter your email address.</div>');
			
			/*
			| ------------------------------------------------------------------------------
			| Adding a db query to tblmeta pagename = index.php
			| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
			*/
			$pagename = 'wholesale_reset_password.php';
			
			$DB3 = $this->_load_db();
			
			// this is the database query which should be eventually transferred at models/query_page.php
			$q_meta = $DB3->get_where('tblmeta',array('pagename'=>$pagename));
			$meta_row = $q_meta->row();
			
			$data = array('file'				=> 'wholesale_reset_password',
						  'control'				=> 'reset',
						  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
						  'site_title'			=> $meta_row->title,
						  'site_keywords'		=> $meta_row->keyword,
						  'site_description'	=> $meta_row->description,
						  'footer_text'			=> $meta_row->dfooter
						 );
			$this->load->view($this->config->slash_item('template').'template',$data);
		}
		else
		{
			$email = trim($this->input->post('email'));
			
			$return_url = site_url('wholesale/reset_password');
			$redirect	= site_url('wholesale/recovery_complete');
		
			$check_email = $this->query_users->get_wholesale_user_byemail($email);
			
			if (count($check_email) > 0)
			{
				$login_check = $this->query_users->check_login($email,'reset_password','wholesale');
				
				// if authenticated and active
				if ($login_check == 1)
				{
					$email_message = '
						You have requested to retrieve your password.
						<br /><br />
						<strong>Username:</strong> '.$email.'<br />
						<strong>Password:</strong> '.$check_email->pword.'<br />
						<br />
						Click on link to login: <a href="'.site_url('wholesale/signin.html').'" target="_blank">'.base_url().'wholesale/signin.html</a>
						<br /><br />
						For more information or further assistance, please call us on 212.840.0846  or email '.$this->config->item('info_email').'
					';
				}
				// if authenticated and inactive
				elseif ($login_check == 2)
				{
					$email_message = '
						Dear Wholesale Buyer,
						<br /><br />
						Thank you for your interest.<br />
						Your access priviledges have been suspended due to lack on activity.
						<br /><br />
						To reactivate, you muct call client services at 212.840.0846  or email '.$this->config->item('info_email').'
					';
				}
				// if not registered
				else
				{
					$DB2 = $this->_load_session_db();
			
					$this->session->set_flashdata('flashMsg','<div class="errorMsg">The email address you entered is not in the registered list.</div>');
					redirect('wholesale/signin', 'location', 301);
				}
				
				$this->load->library('email');
				if (ENVIRONMENT === 'development') $this->email->set_newline("\r\n"); // ---> some code to fix the email sending
				
				$this->email->from($this->config->item('info_email'), $this->config->item('site_name'));
				
				if (ENVIRONMENT == 'development') // ---> used for development purposes
				{
					$this->email->to($this->config->item('dev1_email'));
				}
				else
				{
					$this->email->to($email);
				}
		
				$this->email->subject($this->config->item('site_name').' - Reset Password');
				$this->email->message($email_message);
				
				if ( ! $this->email->send())
				{
					echo "Email was not sent!";
					if (ENVIRONMENT == 'development')
					{
						echo br().$this->email->print_debugger();
						die();
					}
				}
				//end sending email
				
				/*
				| ------------------------------------------------------------------------------
				| Adding a db query to tblmeta pagename = index.php
				| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
				*/
				$pagename = 'wholesale_reset_password.php';
				
				$DB3 = $this->_load_db();
			
				// this is the database query which should be eventually transferred at models/query_page.php
				$q_meta = $DB3->get_where('tblmeta',array('pagename'=>$pagename));
				$meta_row = $q_meta->row();
				
				$data = array('file'				=> 'wholesale_reset_password',
							  'control'				=> '',
							  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
							  'site_title'			=> $meta_row->title,
							  'site_keywords'		=> $meta_row->keyword,
							  'site_description'	=> $meta_row->description,
							  'footer_text'			=> $meta_row->dfooter
							 );
				$this->load->view($this->config->slash_item('template').'template',$data);
			}
			else
			{
				$DB2 = $this->_load_session_db();
			
				$this->session->set_flashdata('flashMsg','<div class="errorMsg">We could not find the email address you entered.</div>');
				redirect('wholesale/reset_password', 'location', 301);
			}
		}
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
	
	function _load_db()
	{
		// load the respective database
		switch (ENVIRONMENT)
		{
			case 'development':
				$DB = $this->load->database('local', TRUE);
			break;

			case 'testing';
				$DB = $this->load->database('instyle', TRUE);
			break;
			
			default:
				$DB = $this->load->database('instyle', TRUE);
		}
		
		return $DB;
	}
}
