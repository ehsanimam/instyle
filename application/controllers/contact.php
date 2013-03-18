<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {
	function __Construct() {
		parent::__Construct();	
		$this->load->model('query_page');
	}
	
	function index() {
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'contact.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'				=> 'contact',
					  'view'				=> 'contact_form',
					  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'			=> $meta_row->title,
					  'site_keywords'		=> $meta_row->keyword,
					  'site_description'	=> $meta_row->description,
					  'footer_text'			=> $meta_row->dfooter
					 );
		$this->load->view('template',$data);
	}
	
	function process_send() {
		
		
		$the_spinner = $this->input->post(md5('the_spinner')); // ---> used to identify the random hashed fields
		$the_time = $this->input->post(md5($the_spinner.'the_time'));
		$the_honeypot = $this->input->post(md5($the_spinner.'the_honeypot'));
		
		$name			= $this->input->post(md5($the_spinner.'the_name'));
		$state			= $this->input->post(md5($the_spinner.'the_state'));
		$country		= $this->input->post(md5($the_spinner.'the_country'));		
		$telephone		= $this->input->post(md5($the_spinner.'the_telephone'));
		$email			= $this->input->post(md5($the_spinner.'the_email'));
		$comment		= $this->input->post(md5($the_spinner.'the_comment'));
		$recieveupdate	= $this->input->post(md5($the_spinner.'the_recieveupdate'));
		
		$recieve_update = $recieveupdate == 1 ? 'Yes' : 'No';
		
		if ($the_time < (time() - 180) // to far in the past (more than 3 mins (180 secs))
				OR $the_time > time() // in the future
				OR $the_time == '' // if empty (a clear sign of manipulation by a bot)
				OR $the_honeypot != '' // if honeypot is not empty (a clear sign of bot filling up form)
				OR $name == '' 
				OR $state == ''
				OR $country == ''
				OR $telephone == ''
				OR $email == '')
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please fill up all (*) required fields.</div>');								redirect('contact', 'location', 301);
			
		}
		else if ( ! preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please enter a valid email address.</div>');
			redirect('contact', 'location', 301);
		}
		//check if theres a url in name or comment fields
		else if (  preg_match("%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i",$name)||  preg_match("%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i",$comment))
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please do not use url on name or comment fields.</div>');
			redirect('contact', 'location', 301);
		}
		else {
			//sending email
			$email_message = '<table border="0" cellspacing="0" cellpadding="5">
								<tr><td>Name:</td><td>'.$name.'</td></tr>
								<tr><td>State:</td><td>'.$state.'</td></tr>
								<tr><td>Country:</td><td>'.$country.'</td></tr>
								<tr><td>Telephone:</td><td>'.$telephone.'</td></tr>
								<tr><td>Email:</td><td>'.$email.'</td></tr>
								<tr><td>Questions/Comments:</td><td>'.$comment.'</td></tr>
								<tr><td>Recieve update</td><td>'.$recieve_update.'</td></tr>		
							</table>
							 ';
			
			$this->load->library('email');
			
			$this->email->initialize($config);
			
			$this->email->from($email, $this->config->item('site_name'));
			$this->email->to($this->config->item('info_email'));  // info@instylenewyork.com
			$this->email->bcc($this->config->item('dev2_email')); // for debugging purpose only - rusty email
			//$this->email->cc($this->config->item('info_email'));
			//$this->email->bcc('them@their-example.com');
			
			$this->email->subject($this->config->item('site_name').' - Contact Us Inquiry');
			$this->email->message($email_message);
			
			$this->email->send();
			
			//echo $this->email->print_debugger();
			//end sending email			
			
			redirect('contact/sent', 'location', 301);
			
		}
	}
	
	function sent() {
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'contact.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array('file'				=> 'contact',
					  'view'				=> 'sent',
					  'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
					  'site_title'			=> $meta_row->title,
					  'site_keywords'		=> $meta_row->keyword,
					  'site_description'	=> $meta_row->description,
					  'footer_text'			=> $meta_row->dfooter
					 );
		$this->load->view('template',$data);
	}

}

?>