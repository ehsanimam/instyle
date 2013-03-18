<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_users extends CI_Model {
	
	function get_users()
	{
		$q = $this->db->get('tbluser_data');
		return $q;
	}
	
	function insert_user($data)
	{
		$this->db->insert('tbluser_data',$data);
		return $this;
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| INSERTing wholesale users into tbluser_data_wholesale
	*/
	function insert_wholesale_user($data)
	{
		$this->db->insert('tbluser_data_wholesale',$data);
		return $this;
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Inserting new record on tbluser_data_2011 and tbluser_data (if doesn't exist yet)
	| _np - meaning 'new process'
	*/
	function insert_user_np($data,$tbluser_data_exists,$tbluser_data_2011_exists,$tbluser_exists)
	{
		if ($tbluser_data_exists != '' && $tbluser_data_exists == 'N') $this->db->insert('tbluser_data',$data);
		if ($tbluser_data_2011_exists != '' && $tbluser_data_2011_exists == 'N') $this->db->insert('tbluser_data_2011',$data);
		if ($tbluser_exists != '' && $tbluser_exists == 'N') $this->db->insert('tbluser',$data);
		return $this;
	}
	
	function get_single_user($user_id)
	{
		$q = $this->db->get_where('tbluser_data',array('user_id'=>$user_id));
		return $q->row();
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| User info from order_catalog.html (for basix only)
	*/
	function insert_order_catalog_data($data) {
		$this->db->insert('tbl_order_catalog_data',$data);
		return $this;
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Getting the shipping info from tbluser_data
	| Using tbluser.user_id stored in session during register/process_customer_info
	*/
	function get_single_user_tbluser($user_id)
	{
		$q = $this->db->get_where('tbluser',array('user_id'=>$user_id));
		if ($q && $q->num_rows() > 0)
		{
			$row = $q->row();
			$q2 = $this->db->get_where('tbluser_data',array('email'=>$row->e_mail));
			return $q2->row();
		}
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Getting the shipping info from tbluser_data_wholesale if wholesale
	| Using tbluser.user_id stored in session during register/process_customer_info (for instyle wholesale login)
	*/
	function get_single_user_tbluser_wholesale($user_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tbluser_data_wholesale',array('user_id'=>$user_id));
		return $q->row();
	}
	
	function get_single_user_byemail($email)
	{
		$q = $this->db->get_where('tbluser_data',array('email'=>$email,'is_active'=>1));
		return $q->row();
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Getting the password and other data from tbluser_data_wholesale given email only (instyle only)
	| has different query statement at basix
	|
	*/
	function get_wholesale_user_byemail($email)
	{
		$q = $this->db->get_where('tbluser_data_wholesale',array('email'=>$email));
		return $q->row();
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Getting the user_id and other data from tbluser_data given email only
	*/
	function get_single_userid_byemail($email)
	{
		$q = $this->db->get_where('tbluser_data',array('email'=>$email));
		return $q->row();
	}
	
	function update_user($data, $user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('tbluser_data',$data);
		return $this;
	}
	
	//added by rusty for whole forgot password (for basix only)
	function update_user_wholesale($data, $user_id) {
		$this->db->where('user_id', $user_id);
		$this->db->update('tbluser_data_wholesale',$data);
		return $this;
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Check login for wholesale/authenticate and signin/authenticaet but with latter bypassed
	| (Different from basix)
	*/
	function check_login($username, $password, $param)
	{
		if ($password === 'reset_password')
		{
			if ($param == 'consumer') $c_pword_clause = '';
			if ($param == 'wholesale') $w_pword_clause = '';
		}
		else
		{
			$c_pword_clause = "AND password='".$password."' ";
			$w_pword_clause = "AND pword='".$password."' ";
		}
		
		if ($param == 'consumer') $q = $this->db->query("SELECT * FROM tbluser_data WHERE email='".$username."' ".$c_pword_clause."AND is_active='1'");
		if ($param == 'wholesale') $q = $this->db->query("SELECT * FROM tbluser_data_wholesale WHERE email='".$username."' ".$w_pword_clause."AND is_active='1'");
		if ($q->num_rows() > 0)
		{
			// authenticated and active
			return 1;
		}
		else
		{
			if ($param == 'consumer') $q2 = $this->db->query("SELECT * FROM tbluser_data WHERE email='".$username."' ".$c_pword_clause."AND is_active='0'");
			if ($param == 'wholesale') $q2 = $this->db->query("SELECT * FROM tbluser_data_wholesale WHERE email='".$username."' ".$w_pword_clause."AND is_active='0'");
			if ($q2->num_rows() > 0)
			{
				// authenticated and inactive
				return 2;
			}
			else
			{
				return false;
			}
		}
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Check login for admin sales (for basix)
	*/
	function check_admin_sales_login($username, $password)
	{
		$this->db->where('admin_sales_email', $username);
		$this->db->where('admin_sales_password', $password);
		$q = $this->db->get('tbladmin_sales');
		return $q;
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Check if sales admin user logged in at basix is in record array (for instyle)
	*/
	function just_admin_sales_users()
	{
		$this->db->select('admin_sales_user, admin_sales_email, admin_sales_lname');
		$this->db->from('tbladmin_sales');
		$q = $this->db->get();
		return $q->result_array();
	}
	
	function get_user_orders($user_id)
	{
		$q = $this->db->query("SELECT * FROM tbl_order_log WHERE user_id='".$user_id."' ORDER BY order_log_id DESC");
		return $q;
	}
	
	function get_single_order($order_log_id)
	{
		$q = $this->db->query("SELECT * FROM  tbl_order_log WHERE order_log_id='".$order_log_id."'");
		return $q->row();
	}
	
	function get_user_order_details($order_log_id)
	{
		$q = $this->db->get_where('tbl_order_log_details',array('order_log_id'=>$order_log_id));
		return $q;
	}
	
	function check_ifemail_exist($email)
	{
		$q = $this->db->get_where('tbluser_data',array('email'=>$email));
		if($q->num_rows()>0) {
			return 1;
		} else {
			return 0;
		}
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Check email existence for tbluser_data_wholesale - WHOLESALE data
	*/
	function check_ifemail_exist2($email)
	{
		$q = $this->db->get_where('tbluser_data_wholesale',array('email'=>$email));
		
		if ($q->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Added this email present query for new tbluser_data_2011
	*/
	function check_ifemail_exist_2011($email)
	{
		$q = $this->db->get_where('tbluser_data_2011',array('email'=>$email));
		
		if ($q->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	/*
	| --------------------------------------------------------------------------------------
	| Added this email present query for new tbluser
	*/
	function check_ifemail_exist_tbluser($email)
	{
		$q = $this->db->get_where('tbluser',array('e_mail'=>$email));
		
		if ($q->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Added this query for user from tbluser
	| (This should not be empty anymore as it went through email present query and inserting if not present)
	*/
	function get_user_info($email)
	{
		$q = $this->db->get_where('tbluser',array('e_mail'=>$email));

		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			return $row;
		}
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| Updating tbl_loding_details (basix users retailer, instyle uses wholesale)
	*/
	function update_login_detail($user_id, $param)
	{
		if ($param == 'consumer') $q = $this->db->get_where('tbluser',array('user_id'=>$user_id));
		if ($param == 'wholesale') $q = $this->db->get_where('tbluser_data_wholesale',array('user_id'=>$user_id));
		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			if ($param == 'consumer') $email = $row->e_mail;
			if ($param == 'wholesale') $email = $row->email;
			$data = array(
				'user_id' => $user_id,
				'session_id' => $this->session->userdata('session_id'),
				'create_date' => date('Y-m-d', time()),
				'create_time' => date('H:i:s', time()),
				'email' => $email
			);
			if ($param == 'consumer') $this->db->insert('tbl_login_detail',$data);
			if ($param == 'wholesale') $this->db->insert('tbl_login_detail_wholesale',$data);
		}
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| In amendment of the register/process_customer_info, this insert or update table is created (for instyle only)
	*/
	function update_table($data, $email, $table)
	{
		if ($table == 'tbluser') $field_email = 'e_mail';
		else $field_email = 'email';
		
		$q = $this->db->get_where($table,array($field_email=>$email));
		
		if ($q->num_rows() > 0)
		{
			// Update only
			$this->db->where($field_email,$email);
			$this->db->update($table,$data);
		}
		else
		{
			// Insert
			$this->db->insert($table,$data);
		}
	}

	/*
	| --------------------------------------------------------------------------------------
	| Check if recipients email used in sending product linesheet already exists
	*/
	function check_sa_recipients_email($email)
	{
		$q = $this->db->get_where('tbladmin_sales_addbook',array('email' => $email));

		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			return $row;
		}
		else return false;
	}
	
	/*
	| --------------------------------------------------------------------------------------
	| User Admin Models
	*/
		function check_users_admin_uname($str)
		{
			$q = $this->db->get_where('users_admin', array('users_admin_uname' => $str));
			
			if ($q->num_rows() > 0)
			{
				return TRUE;
			}
			else return FALSE;
		}
		
		function check_users_admin_pword($str)
		{
			$q = $this->db->get_where('users_admin', array('users_admin_pword' => $str));
			
			if ($q->num_rows() > 0)
			{
				return TRUE;
			}
			else return FALSE;
		}
		
		function get_admin_user_info($str)
		{
			$q = $this->db->get_where('users_admin', array('users_admin_uname' => $str));
			
			if ($q->num_rows() > 0)
			{
				$row = $q->row_array();
				return $row;
			}
			else return FALSE;
		}
}
