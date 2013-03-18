<?php
	function load_jscript()
	{
		$jscript = '
			<link type="text/css" href="js/datePicker.css" rel="stylesheet" />
			<link type="text/css" href="'.FILE_NAME.'_styles.css" rel="stylesheet" />
			<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
			<script type="text/javascript" src="js/date.js"></script>
			<script type="text/javascript" src="js/spin.js"></script>
			<script type="text/javascript" src="'.FILE_NAME.'_js.js"></script>
		';
		
		return $jscript;
	}
	
	function m_count_user($user_choice)
	{
		$sel = "SELECT COUNT(*) AS user_count FROM tbladmin_sales WHERE is_active = '".$user_choice."' ORDER BY admin_sales_user ASC";
		$qry = mysql_query($sel) or die('Select COUNT error at list_salse_user_models.php line 19 - '.mysql_error().'<br />'.$sel);
		$res = mysql_fetch_array($qry);
		
		return $res['user_count'];
	}

	function m_get_users($user_choice)
	{
		$sel = "SELECT * FROM tbladmin_sales WHERE is_active = '".$user_choice."' ORDER BY admin_sales_user ASC";
		$qry = mysql_query($sel) or die('Check Prod No error at list_salse_user_models.php line 28 - '.mysql_error().'<br />'.$sel);
		
		return $qry;
	}
	
	function m_del_user($ed)
	{
		$sel = "SELECT * FROM tbladmin_sales";
		$qry = mysql_query($sel) or die('Select users error at list_salse_user_models.php line 36 - '.mysql_error().'<br />'.$sel);
		
		while ($row = mysql_fetch_array($qry))
		{
			if ($ed === md5($row['admin_sales_email']))
			{
				$del = "
					DELETE FROM tbladmin_sales
					WHERE admin_sales_email = '".$row['admin_sales_email']."'
				";
				// delete record
				$q_del1 = mysql_query($del) or die('First delete user error at list_salse_user_models.php line 47 - '.mysql_error().'<br />'.$del);
				
				// free up mysql memory
				mysql_free_result($q_del1);
				
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
					
					// delete record
					$q_del2 = mysql_query($del) or die('Second delete user error at list_salse_user_models.php line 65 - '.mysql_error().'<br />'.$del);
				
					// free up mysql memory
					mysql_free_result($q_del2);
			
					// close remote db connection
					mysql_close($conn);
				}
				
				break;
			}
		}
	}
	
	function m_deactivate_user($de)
	{
		$sel = "SELECT * FROM tbladmin_sales";
		$qry = mysql_query($sel) or die('Select users error at list_salse_user_models.php line 82 - '.mysql_error().'<br />'.$sel);
		
		while ($row = mysql_fetch_array($qry))
		{
			if ($de === md5($row['admin_sales_email']))
			{
				$upd = "
					UPDATE tbladmin_sales
					SET is_active = '0'
					WHERE admin_sales_email = '".$row['admin_sales_email']."'
				";
				// delete record
				$q_upd = mysql_query($upd) or die('Update user error at list_salse_user_models.php line 94 - '.mysql_error().'<br />'.$upd);
				
				if ($_SERVER['SERVER_NAME'] !== 'localhost') // --> change 'localhost' to your local dev environment server
				{
					if ($_SERVER['SERVER_NAME'] === 'www.instylemilan.com')
					{
						// remote db config
						$host_remote="216.70.104.66";
						$username_remote="joe_taveras";
						$password_remote="!@R00+@dm!N";
						$db_remote="joe_moscow";
					}
					else
					{
						// remote db config
						$host_remote="216.70.104.66";
						$username_remote="joe_taveras";
						$password_remote="!@R00+@dm!N";
						$db_remote="joe_moscow";
					}

					// connet to remote db
					$conn = mysql_connect($host_remote,$username_remote,$password_remote);
					mysql_select_db($db_remote,$conn);
					
					// delete record
					$q_del2 = mysql_query($del) or die('Second delete user error at list_salse_user_models.php line 120 - '.mysql_error().'<br />'.$sel);
				
					// free up mysql memory
					mysql_free_result($q_del2);
			
					// close remote db connection
					mysql_close($conn);
				}
				
				break;
			}
		}
	}
	
	
