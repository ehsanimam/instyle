<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send extends Frontend_Controller
{
	function __Construct()
	{
		parent::__Construct();		
	}
	
	function index()
	{
		$the_spinner = $this->input->post(md5('the_spinner')); // ---> used to identify the random hashed fields
		$the_time = $this->input->post(md5($the_spinner.'the_time'));
		$the_honeypot = $this->input->post(md5($the_spinner.'the_honeypot'));
		// send photo to friend
		
		$from		= $this->input->post(md5($the_spinner.'the_from'));
		$to			= $this->input->post(md5($the_spinner.'the_to'));
		$comment	= $this->input->post(md5($the_spinner.'the_comment'));
		
		$prod_no	= $this->input->post(md5($the_spinner.'the_prod_no'));
		$image		= $this->input->post(md5($the_spinner.'the_image'));
		$backurl	= $this->input->post(md5($the_spinner.'the_backurl'));
		$des_url	= $this->input->post(md5($the_spinner.'the_des_url'));
		
		if ($the_time < (time() - 180) // to far in the past (more than 3 mins (180 secs))
				OR $the_time > time() // in the future
				OR $the_time == '' // if empty (a clear sign of manipulation by a bot)
				OR $the_honeypot != '' // if honeypot is not empty (a clear sign of bot filling up form)
				OR $from == '' 
				OR $to == '' 
				OR $comment == '')
		{
				$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please enter all fields when sending photo to a friend.</div>');
				redirect($backurl, 'location', 301);
		}
		
		else if ( ! preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$from))
		{
				$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please enter a valid email address.</div>');
				redirect($backurl, 'location', 301);
		}
		
		else if ( ! preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$to))
		{
				$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please enter a valid email address.</div>');
				redirect($backurl, 'location', 301);
		}
		else
		{
			//sending email
			$email_message = '<table width="624" border="0" cellspacing="0" cellpadding="5">
							  <tbody>
							  <tr>
								<td bgcolor="#000000">'.anchor(site_url(),img(array('src'=>'images/instyle_logo.gif','style'=>'border:none'))).'</td>
								<td bgcolor="#000000">'.anchor($des_url,'view more from this designer','style="font-family:Arial;font-size:14px;color:white;text-decoration:none;"').'</td>
							  </tr>
							  <tr>
								<td width="340" rowspan="2" style="border: 1px solid #efefef;">'.anchor($backurl,img(array('src'=>$image,'style'=>'border:none'))).'</td>
								<td bgcolor="#efefef" valign="top" style="font-family:Arial;font-size:14px;">
									TO: '.$to.' <br><br>
									FROM: '.$from.' <br><br><br>
									Style Number: '.$prod_no.' <br><br><br>
									MESSAGE: '.$comment.' <br><br>
								</td>
							  </tr>
							  <tr>
								<td bgcolor="#efefef" valign="bottom" style="font-family:Arial;font-size:14px;">Powered by: '.$this->config->item('site_name').' </td>
							  </tr>
							  </tbody>
							</table>
							 ';
			
			$this->load->library('email');			
			$this->email->reply_to($from);
			$this->email->from($this->config->item('info_email'), $from);
			$this->email->to($to);
			$this->email->bcc($this->config->item('info_email')); 
			$this->email->bcc($this->config->item('dev2_email')); //dev2_email for debugging purposes only
			//$this->email->bcc('them@their-example.com');
			
			$this->email->subject($this->config->item('site_name').' - Fabulous Dress at '.$this->config->item('site_domain'));
			$this->email->message($email_message);
			
			$this->email->send();
			
			//echo $this->email->print_debugger();
			//end sending email
			
			$this->session->set_flashdata('flashMsg','<div class="successMsg">Your message along with the photo has been sent to your friend.</div>');
			
			redirect($backurl, 'location', 301);
		}
	}
}
