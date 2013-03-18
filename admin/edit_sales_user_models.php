<?php
	function load_jscript()
	{
		$jscript = '
			<link type="text/css" href="js/datePicker.css" rel="stylesheet" />
			<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
			<script type="text/javascript" src="js/date.js"></script>
			<script type="text/javascript" src="'.FILE_NAME.'_js.js"></script>
		';
		
		return $jscript;
	}

	function m_get_user($ee)
	{
		$sel = "SELECT * FROM tbladmin_sales";
		$qry = mysql_query($sel) or die('Select users error - '.mysql_error());
		
		while ($row = mysql_fetch_array($qry))
		{
			if ($ee === md5($row['admin_sales_email']))
			{
				$sel_user = "
					SELECT * FROM tbladmin_sales
					WHERE admin_sales_email = '".$row['admin_sales_email']."'
				";
				$qry_user = mysql_query($sel_user) or die('Delete user error - '.mysql_error());
				
				return $qry_user;
				break;
			}
		}
	}
	
	function m_check_sales_user($email)
	{
		$sel = "SELECT * FROM tbladmin_sales WHERE admin_sales_email = '".$email."'";
		$qry = mysql_query($sel) or die('Check Prod No error - '.mysql_error());
		
		if (mysql_num_rows($qry) > 0) return TRUE;
		else return FALSE;
	}
	
	function m_update_user($ee, $post_ary)
	{
		$sa_user = $post_ary['sa_user'];
		$sa_lname = $post_ary['sa_lname'];
		$sa_email = $post_ary['sa_email'];
		$sa_pword = $post_ary['sa_pword'] != '' ? "admin_sales_password = '".md5($post_ary['sa_pword'])."'," : '';
		
		$sel = "SELECT * FROM tbladmin_sales";
		$qry = mysql_query($sel) or die('Select users error - '.mysql_error());
		
		while ($row = mysql_fetch_array($qry))
		{
			if ($ee === md5($row['admin_sales_email']))
			{
				$upd = "
					UPDATE tbladmin_sales
					SET
						".$sa_pword."
						admin_sales_user = '".$sa_user."',
						admin_sales_lname = '".$sa_lname."',
						admin_sales_email = '".$sa_email."'
					WHERE
						admin_sales_email = '".$row['admin_sales_email']."'
				";
				// update record
				$q_upd1 = mysql_query($upd) or die('Updating records error - '.mysql_error());
				
				// free up mysql memory
				mysql_free_result($q_upd1);
			
				if ($_SERVER['SERVER_NAME'] !== 'localhost') // --> change 'localhost' to your local dev environment server
				{
					// remote db config
					$host_remote="216.70.104.66";
					$username_remote="joe_taveras";
					$password_remote="!@R00+@dm!N";
					$db_remote="joe_moscow";

					// connet to remote db
					$conn = mysql_connect($host_remote,$username_remote,$password_remote);
					mysql_select_db($db_remote,$conn);
					
					// update record
					$q_upd2 = mysql_query($upd) or die('Updating records error - '.mysql_error());
				
					// free up mysql memory
					mysql_free_result($q_upd2);
			
					// close remote db connection
					mysql_close($conn);
				}
				
				break;
			}
		}
	}
	
	
