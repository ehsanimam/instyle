<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_original_model extends CI_Model
{
	
	function __Construct()
	{
		parent::__Construct();
	}
	
	/*
	*---------------------------------------------------------------------
	* DATABSE FUNCTIONS FOR ADMIN PANEL
	*---------------------------------------------------------------------
	*/
	
	function admin_validation($u,$p)
	{
		$this->db->where('admin_name',$u);
		$this->db->where('admin_password',$p);
		
		// get the database
		$query = $this->db->get('tbladmin');
		// return result set as an associative array
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

/* End of file admin_original_model.php */
/* Location: ./application/model/admin_original_model.php */