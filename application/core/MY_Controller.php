<?php if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');
	
class MY_Controller extends CI_Controller
{
    public $data = array();
	
    function __construct()
    {
        parent::__construct();
		
		// site access switch
		switch ($this->config->item('site_access'))
		{
			case "ADMIN_ONLY":
				if ( ! $this->session->userdata('site_log_in') && ENVIRONMENT === 'production')
				{
					$this->session->set_flashdata('logErr', $this->set->errorMsg('Login required'));
					$this->session->set_flashdata('page_being_accessed', $this->uri->uri_string());
					redirect(site_url('login'), 'location');
				}
			break;
			
			case "DEFAULT":
			default:
				// login for beta site - to prevent being crawled or indexed by search engines
				if ( ! $this->session->userdata('site_log_in') && ENVIRONMENT === 'testing')
				{
					$this->session->set_flashdata('logErr', $this->set->errorMsg('Login required'));
					$this->session->set_flashdata('page_being_accessed', $this->uri->uri_string());
					redirect(site_url('login'), 'location');
				}
		}
		
		// login for admin panel if first visit or cookie/session expired
		/*
		if ( ! $this->input->cookie('users_admin_uname') && $this->uri->segment(1) === 'admin_ci')
		{
			// cookie not set, first visit
			// send to login page and create cookie tehre
			if ( ! $this->session->userdata('admin_is_logged_in'))
			{
				$this->session->set_flashdata('logErr', $this->set->errorMsg('Login required'));
				$this->session->set_flashdata('page_being_accessed', $this->uri->uri_string());
				redirect(site_url('admin_ci/login'), 'location');
			}
			else
			{
				$this->load->model('query_users');
				
				$user_admin_info = $this->query_users->get_admin_user_info($this->input->cookie('users_admin_uname'));
				
				$data = array(
					'admin_username' => $user_admin_info['users_admin_fname'].' '.$user_admin_info['users_admin_lname'],
					'admin_type' => ucwords($user_admin_info['users_admin_type']),
					'admin_is_logged_in' => TRUE
				);
				$this->session->set_userdata($data);
				
				if ($this->uri->uri_string() && $this->uri->uri_string() != 'admin_ci/login')
					$url = $this->uri->uri_string();
				else
					$url = site_url('admin_ci');
				
				redirect($url, 'location');
			}
		}
		*/
		
        if (ENVIRONMENT != 'development') $this->output->enable_profiler(FALSE);
		else $this->output->enable_profiler(FALSE);
		$sections = array(
			'benchmarks' => FALSE,
			'get' => FALSE,
			'memory_usage' => FALSE,
			'post' => FALSE,
			'http_headers' => FALSE,
			'config' => FALSE,
		);
		$this->output->set_profiler_sections($sections);
    }
}