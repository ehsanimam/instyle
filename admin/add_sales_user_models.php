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

	function m_check_sales_user($email)
	{
		$sel = "SELECT * FROM tbladmin_sales WHERE admin_sales_email = '".$email."'";
		$qry = mysql_query($sel) or die('Check Prod No error - '.mysql_error());
		
		if (mysql_num_rows($qry) > 0) return TRUE;
		else return FALSE;
	}
	
	
