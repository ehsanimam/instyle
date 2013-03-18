<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends Frontend_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'register.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		//$DB3 = $this->load_db();
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'				=> 'register',
					  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'			=> $meta_row->title,
					  'site_keywords'		=> $meta_row->keyword,
					  'site_description'	=> $meta_row->description,
					  'footer_text'			=> $meta_row->dfooter
					 );
		$this->load->view($this->config->slash_item('template').'template',$data);
	}
	
	function process_register() {
		
		$control			= $this->input->post('control');
		$email				= $this->input->post('email');
		$firstname			= $this->input->post('firstname');
		$lastname			= $this->input->post('lastname');
		$dressize			= $this->input->post('dressize');
		$telephone			= $this->input->post('telephone');
		$fax				= $this->input->post('fax');
		$address1			= $this->input->post('address1');
		$address2			= $this->input->post('address2');
		$country			= $this->input->post('country');
		$city				= $this->input->post('city');
		$state				= $this->input->post('state');
		$zipcode			= $this->input->post('zipcode');
		$howhearabout		= $this->input->post('howhearabout');
		$receive_productupd	= $this->input->post('receive_productupd');
		
		if ($control == 'cart') {
			$return_url = 'cart/signin_register';
			$redirect	= 'register/complete';
		} else {
			$return_url = 'register';
			$redirect	= 'register/complete';
		}
		
		//$DB2 = $this->load_session_db();
		
		$this->load->library('form_validation');
		
		if (!$email || !$firstname || !$lastname || !$telephone || !$address1 || !$country || !$city || !$state || !$zipcode) {
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Please fill up all (*) mandatory fields</div>');
			redirect($return_url, 'location', 301);
		}		
		
		// Changed iregi() deprecated already - made some adjustments on the regex
		if( ! preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i', $email)) {
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">You have entered an invalid email address</div>');
			redirect($return_url, 'location', 301);
		}
		
		if($this->query_users->check_ifemail_exist($email)) {
			//$DB2 = $this->load_session_db();
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">The email address you entered is already taken</div>');
			redirect($return_url, 'location', 301);
		}
		
		$default_password = 'instyle2011';
		
		// insert to tbluser_data
		$data = array('email'				=> $email,
					  'password'			=> md5($default_password),
					  //'company'				=> $company,
					  'firstname'			=> $firstname,
					  'lastname'			=> $lastname,
					  'dresssize'			=> $dressize,
					  'telephone'			=> $telephone,
					  'fax'					=> $fax,
					  'address1'			=> $address1,
					  'address2'			=> $address2,
					  'country'				=> $country,
					  'city'				=> $city,
					  'state_province'		=> $state,
					  'zip_postcode'		=> $zipcode,
					  'how_hear_about'		=> $howhearabout,
					  'receive_productupd'	=> $receive_productupd
					 );
		$this->query_users->insert_user($data);
		$user_id = $this->db->insert_id();
		
		// begin send email confirmation
			$receive_productupdate = $receive_productupd == 1 ? 'Yes' : 'No';
			$email_message_admin = '<table border="0" cellspacing="2" cellpadding="2">
									<tr><td style="width:200px;">E-mail Address </td><td>'.$email.'</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>First Name </td><td>'.$firstname.'</td></tr>
									<tr><td>Last Name </td><td>'.$lastname.'</td></tr>
									<tr><td>Dress Size</td><td>'.$dressize.'</td></tr>
									<tr><td>Telephone </td><td>'.$telephone.'</td></tr>
									<tr><td>Fax</td><td>'.$fax.'</td></tr>
									<tr><td>Address 1 </td><td>'.$address1.'</td></tr>
									<tr><td>Address 2</td><td>'.$address2.'</td></tr>
									<tr><td>Country </td><td>'.$country.'</td></tr>				
									<tr><td>State/Province *</td><td>'.$state.'</td></tr>
									<tr><td>City </td><td>'.$city.'</td></tr>
									<tr><td>Postal/Zip Code </td><td>'.$zipcode.'</td></tr>
									<tr><td>How did you hear <br/>about '.$this->config->item('site_name').'?</td><td>'.$howhearabout.'</td></tr>
									<tr><td>Would you like to receive product updates from '.$this->config->item('site_name').' by Email?</td><td>'.$receive_productupdate.'</td></tr>
									</table>';
									
			$email_message_user = 'Dear '.$firstname.' '.$lastname.',<br /><br />
										<p>Welcome to '.$this->config->item('site_name').'.<br /><br />
										Your username and password:<br>
										Username: '.$email.'<br>
										Password: '.$default_password.'
										</p>
										
										<p>Click the link below to activate your account in order to receive special offers and discounts:<br />
										<br />
										<a href="'.base_url().'register/activate/'.$user_id.'" target="_blank">
											'.base_url().'register/activate/'.$user_id.'
										</a>
										<br />
										<br />
										</p>
										
										<p>If the link above is not active, simply copy and paste to your browser address window.</p>
										<p>Thanks,<br>'.$this->config->item('site_name').' Team.</p><br><br>';
			
			$this->load->library('email');
			
		// send email to customer's email address
			$this->email->from($this->config->item('info_email'), $this->config->item('site_name'));
			$this->email->to($email);
			
			$this->email->subject('Automated Response from '.$this->config->item('site_domain'));
			$this->email->message($email_message_user);
			
			$this->email->send();
		// end send email confirmation
		
		// begin send email info, response to admin
			$this->email->initialize($config);
			
			$this->email->from($this->config->item('info_email'), $this->config->item('site_name'));
			$this->email->to($this->config->item('info_email'));
			
			$this->email->subject('Registration Form');
			$this->email->message($email_message_admin);
			
			$this->email->send();
		// end send email info
		
		redirect($redirect, 'location', 301);
	}
	
	function complete()
	{
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'register.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		//$DB3 = $this->_load_db();
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'					=> 'register_complete',
					  'jscript'					=> '',
					  'page_footer_meta'		=> $meta_row->dfooter, // added this variable for the footer text meta
					  'page_title'				=> 'register',
					  'site_title'				=> $this->config->item('site_title'),
					  'site_keywords'			=> $this->config->item('site_keywords'),
					  'site_description'		=> $this->config->item('site_description')
					 );
		$this->load->view($this->config->slash_item('template').'template',$data);
	}
	
	function activate()
	{
		$user_id = $this->uri->segment(3);
		
		if ( ! $user_id)
		{
			$message = 'Error: We could not find your account.';
		}
		else
		{
			$this->query_users->update_user(array('is_active'=>1), $user_id);
			$message = 'Thank You. Your account has been activated.';
			
			$qry = $this->query_users->get_single_user($user_id);
			if ($qry->firstname == $qry->lastname) $name = $qry->firstname;
			else $name = $qry->firstname.' '.$qry->lastname;
		
			// notification to admin - begin email to admin
			$email_message_to_admin = '
				The following just activated their account at '.$this->config->item('site_name').'
				<table border="0" cellspacing="0" cellpadding="5">
					<tr><td>Username:</td><td>'.$qry->email.'</td></tr>
					<tr><td>Name:</td><td>'.$name.'</td></tr>
				</table>
			';
			
			$this->load->library('email');
			
			// send email to admin
			$this->email->from($this->config->item('info_email'), $this->config->item('site_name'));
			$this->email->to($this->config->item('info_email'));
			
			$this->email->subject('Automated Response from '.$this->config->item('site_name'));
			$this->email->message($email_message_to_admin);
			
			$this->email->send();
			// end send email confirmation
		}
		
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'register.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		//$DB3 = $this->load_db();
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'					=> 'register_activated',
					  'jscript'					=> '',
					  'message'					=> $message,
					  'page_footer_meta'		=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'				=> $this->config->item('site_title'),
					  'site_keywords'			=> $this->config->item('site_keywords'),
					  'site_description'		=> $this->config->item('site_description')
					 );
		$this->load->view($this->config->slash_item('template').'template',$data);
	}
	
	function reset_password() {
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'register.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		//$DB3 = $this->_load_db();
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'				=> 'reset_password',
					  'control'				=> 'reset',
					  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'			=> $meta_row->title,
					  'site_keywords'		=> $meta_row->keyword,
					  'site_description'	=> $meta_row->description,
					  'footer_text'			=> $meta_row->dfooter
					 );
		$this->load->view($this->config->slash_item('template').'template',$data);
	}
	
	function process_reset_password()
	{
		$email = $this->input->post('email');
		
		$check_email = $this->query_users->get_single_user_byemail($email);
		
		if ($check_email)
		{
			$random_code	= random_string('alnum', 8);
			//update tbl_use_data
			$this->query_users->update_user(array('password'=>md5($random_code)),$check_email->user_id);
			//sending email
			$email_message = 'You have requested to reset your password.<br>
							<table border="0" cellspacing="0" cellpadding="5">
								<tr><td>Username:</td><td>'.$email.'</td></tr>
								<tr><td>New Password:</td><td>'.$random_code.'</td></tr>		
							</table>
							 ';
			
			$this->load->library('email');

			$this->email->from($this->config->item('info_email'), $this->config->item('site_name'));
			$this->email->to($email);
			
			$this->email->subject($this->config->item('site_name').' - Reset Password');
			$this->email->message($email_message);
			
			$this->email->send();			
			//end sending email	
			redirect('register/password_changed', 'location', 301);
			
		}
		else
		{
			//$DB2 = $this->load_session_db();
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">We could not find the email address you entered.</div>');
			redirect('register/reset_password', 'location', 301);
		}		
	}
	
	function password_changed() {
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'register.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		//$DB3 = $this->_load_db();
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'				=> 'reset_password',
					  'control'				=> '',
					  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'			=> $this->config->item('site_title'),
					  'site_keywords'		=> $this->config->item('site_keywords'),
					  'site_description'	=> $this->config->item('site_description')
					 );
		$this->load->view($this->config->slash_item('template').'template',$data);
	}
	
	function process_customer_info()
	{
		$the_spinner = $this->input->post(md5('the_spinner')); // ---> used to identify the random hashed fields
		$the_time = $this->input->post(md5($the_spinner.'the_time'));
		$the_honeypot = $this->input->post(md5($the_spinner.'the_honeypot'));
		
		$control			= $this->input->post('control'); // ----> either (cart for cart basket or register for register)
		$email				= $this->input->post(md5($the_spinner.'the_email'));
		$firstname			= $this->input->post(md5($the_spinner.'the_firstname'));
		$lastname			= $this->input->post(md5($the_spinner.'the_lastname'));
		$telephone			= $this->input->post(md5($the_spinner.'the_telephone'));
		$address1			= $this->input->post(md5($the_spinner.'the_address1'));
		$address2			= $this->input->post(md5($the_spinner.'the_address2'));
		$country			= $this->input->post(md5($the_spinner.'the_country'));
		$city				= $this->input->post(md5($the_spinner.'the_city'));
		$state				= $this->input->post(md5($the_spinner.'the_state'));
		$zipcode			= $this->input->post(md5($the_spinner.'the_zipcode'));
		$howhearabout		= $this->input->post(md5($the_spinner.'the_howhearabout'));
		$receive_productupd	= $this->input->post(md5($the_spinner.'the_receive_productupd'));
		
		// Used to control redirect
		if ($control == 'cart')
		{
			$return_url = 'cart/customer_info';
			$redirect	= 'cart/confirm_order';
		}
		else
		{
			$return_url = 'register';
			$redirect	= 'register/complete';
		}
		
		// Validate form
		$this->load->library('form_validation');
		
		//$DB2 = $this->load_session_db();
		
		if ($the_time < (time() - 180) // to far in the past (more than 3 mins (180 secs))
				OR $the_time > time() // in the future
				OR $the_time == '' // if empty (a clear sign of manipulation by a bot)
				OR $email == '' 
				OR $firstname == '' 
				OR $lastname == '' 
				OR $telephone == ''
				OR $address1 == ''
				OR $country == ''
				OR $city == ''
				OR $state == ''
				OR $zipcode == ''
				AND $the_honeypot != '') // if honeypot is not empty (a clear sign of bot filling up form)
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Please fill up all (*) required fields</div>');
			redirect($return_url, 'location', 301);
		}
		
		if ( ! preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Please enter a valid email address.</div>');
			redirect($return_url, 'location', 301);
		}
		//check if theres a url in firstname or lastname fields
		if (  preg_match("%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i",$firstname) || preg_match("%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i",$lastname))
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Please do not use url on name fields.</div>');
			redirect($return_url, 'location', 301);
		}
		
		// The 1st if is a more stringent check on validity of email address. But, Joe wants to check '@' sign only.
		// Or better yet, remove this for now.
		/*
		if ( ! preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i', $email))
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">You have entered an invalid email address</div>');
			redirect($return_url, 'location', 301);
		}
		
		// This is as how it explains itself on the error message
		if($this->query_users->check_ifemail_exist($email)) {
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">The email address you entered is already taken</div>');
			redirect($return_url, 'location', 301);
		}
		*/
		
		if ($this->config->item('site_domain') === 'www.storybookknits.com') $default_password = 'storybook2012';
		else $default_password = 'instyle2011';
		
		/*
		| --------------------------------------------------------------------------------------
		| Inserting or Updating on tbluser_data_2011 and tbluser_data (if email is present or not)
		*/
		$data = array('email'				=> $email,
					  'password'			=> $default_password,
					  'firstname'			=> $firstname,
					  'lastname'			=> $lastname,
					  'telephone'			=> $telephone,
					  'address1'			=> $address1,
					  'address2'			=> $address2,
					  'country'				=> $country,
					  'city'				=> $city,
					  'state_province'		=> $state,
					  'zip_postcode'		=> $zipcode,
					  'how_hear_about'		=> $howhearabout,
					  'receive_productupd'	=> $receive_productupd
		);
		$this->query_users->update_table($data,$email,'tbluser_data');
		$this->query_users->update_table($data,$email,'tbluser_data_2011');
		
		/*
		| --------------------------------------------------------------------------------------
		| Inserting or Updating tbluser (if email is present or not)
		*/
		$data2 = array('e_mail'				=> $email,
					  'user_name'			=> $email,
					  'user_password'		=> $default_password,
					  'uname'				=> $firstname.' '.$lastname,
					  'access_level'		=> 0, // ----> default
					  'create_date'			=> @date('Y-m-d', @time()),
					  'isregistered'		=> 1, // ----> default
					  'received_produpdate'	=> $receive_productupd
		);
		$this->query_users->update_table($data2,$email,'tbluser');
		
		/*
		| --------------------------------------------------------------------------------------
		| Using tbluser user_id for session
		*/
		$tbluser = $this->query_users->get_user_info($email);
		
		//$DB2 = $this->_load_session_db();
	
		$this->session->set_userdata('user_id',$tbluser->user_id);
		$this->session->set_userdata('user_cat','user');
		
		/*
		| --------------------------------------------------------------------------------------
		| Enter info on tbl_login_detail
		*/
		$this->query_users->update_login_detail($tbluser->user_id,'consumer');
		
		redirect($redirect, 'location', 301);
	}
	
	function activation() {
		
		$control			= $this->input->post('control');
		$email				= $this->input->post('email');
		$pword				= $this->input->post('pword');
		
		$return_url = 'signin';
		$redirect	= 'register/complete';
		
		$qry = $this->query_users->get_single_userid_byemail($email);
		
		// begin send email confirmation
			$email_message = 'Dear '.$qry->firstname.',<br /><br />
								<p>Welcome to '.$this->config->item('site_name').'.<br /><br />
								Your username and password:<br>
								Username: '.$email.'<br>
								Password: '.$pword.'
								</p>
								
								<p>Click the link below to activate your account in order to receive special offers and discounts:<br />
								<br />
								<a href="'.base_url().'register/activate/'.$qry->user_id.'" target="_blank">
									'.base_url().'register/activate/'.$qry->user_id.'
									</a>
								<br />
								<br />
								</p>
								
								<p>If the link above is not active, simply copy and paste to your browser address window.</p>
								<p>Thanks,<br>'.$this->config->item('site_name').' Team.</p><br><br>';

			$this->load->library('email');
			
		// send email to customer's email address
			$this->email->from($this->config->item('info_email'), $this->config->item('site_name'));
			$this->email->to($email);
			
			$this->email->subject('Automated Response from '.$this->config->item('site_domain'));
			$this->email->message($email_message);
			
			$this->email->send();
		// end send email confirmation
		
		redirect($redirect, 'location', 301);
	}
	
	function opt_out()
	{
		$opt_out_email = $this->uri->segment(3);
		
		if ($opt_out_email === 'complete')
		{
			/*
			| ------------------------------------------------------------------------------
			| Adding a db query to tblmeta pagename = index.php
			| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
			*/
			$pagename = 'opt_out_complete.php';
			
			// this is the database query which should be eventually transferred at models/query_page.php
			//$DB3 = $this->load_db();
			$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
			$meta_row = $q_meta->row();
			
			$data = array('file'					=> 'opt_out_complete',
						  'jscript'					=> '',
						  'page_footer_meta'		=> $meta_row->dfooter, // added this variable for the footer text meta
						  'site_title'				=> $this->config->item('site_title'),
						  'site_keywords'			=> $this->config->item('site_keywords'),
						  'site_description'		=> $this->config->item('site_description')
						 );
			$this->load->view($this->config->slash_item('template').'template',$data);
		}
		else
		{
			$get_users = $this->query_users->get_users();
			
			foreach ($get_users->result() as $row)
			{
				if (md5($this->config->item('a_secret_1').'-'.$row->email) === $opt_out_email)
				{
					$data = array('receive_productupd'	=> '0');
					$this->query_users->update_table($data,$row->email,'tbluser_data');
					$data = array('received_produpdate'	=> '0');
					$this->query_users->update_table($data,$row->email,'tbluser');
					redirect('register/opt_out/complete', 'location', 302);
				}
			}
		}
	}
}
