<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller
{
	function __Construct()
	{
		parent::__Construct();
		$this->load->model('query_page');
		$this->load->model('admin_original_model','admin');
	}
	
	function index()
	{
		if ($this->uri->segment(2))
		{
			switch ($this->uri->segment(2))
			{
				case 'login':
					$this->_validate_login();
					break;
				case 'admin_home':
					$this->load->view('admin/original/admin_home');
					break;
				case 'change_password':
					$this->load->view('admin/original/change_password');
					break;
				default:
					redirect('page_not_found','location');
			}
		}
		else
		{
			$this->data['admin_username'] = $this->session->userdata('admin_username');
			$this->data['admin_type'] = $this->session->userdata('admin_type');
			
			$this->load->view($this->config->slash_item('template').'admin/template', $this->data);
		}
	}
	
	function _validate_login() {
	
		$admin_id = $_POST['admin_id'];
		$admin_pwd = $_POST['admin_pwd'];
		
		if ($admin_id != "" || $admin_pwd != "")
		{
			$validate = $this->admin->admin_validation($admin_id,$admin_pwd);
			echo $validate;
			
			if ($validate == TRUE)
			{
			   session_start();
			   $SesId=session_id();
			   $admin_id=session_id();
			   $session_admin=$admin_id;
			   $_SESSION['session_admin'] = $session_admin;
				redirect('admin/admin_home','location');
			}
			else
			{
			   //$GLOBALS["message"]=$GLOBALS["message"]."Admin Id/Password is Invalid!!"."<br>";
				$data['err_msg'] = "Admin Id/Password is Invalid!!"."<br>";
				$this->load->view('admin/original/index',$data);
			}
		}
		else
		{
			   //$GLOBALS["message"]=$GLOBALS["message"]."Admin Id/Password cannot be Blank !!!"."<br>";
				$data['err_msg'] = "Admin Id/Password cannot be Blank !!!"."<br>";
				$this->load->view('admin/original/index',$data);
		}
	}
}

