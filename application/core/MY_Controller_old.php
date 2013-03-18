<?php if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

class MY_Controller extends CI_Controller
{  
	function MY_Administrator()
	{
		parent::__Construct();
		if ( ! $this->session->userdata('admin_loggedin'))
        {
			$this->session->set_flashdata('logErr', $this->set->errorMsg('Login required'));
			redirect('login','location','301');
			return;
        }
 	}
	
	function MY_Users()
	{
		parent::__Construct();
		if ( ! $this->session->userdata('user_loggedin'))
        {
			$this->session->set_flashdata('flashMsg', $this->set->errorMsg('You are trying to access a private page. This page requires login information. <br> Signin or '.anchor('register','Register').' to get a FREE account!'));
			redirect('signin','location','301');
			return;
        }
 	}
}
