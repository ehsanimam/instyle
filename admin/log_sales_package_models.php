<?php
	function load_jscript()
	{
		$jscript = '
			<link type="text/css" href="'.FILE_NAME.'_styles.css" rel="stylesheet" />
			<script type="text/javascript" src="js/spin.js"></script>
			<script type="text/javascript" src="'.FILE_NAME.'_js.js"></script>
		';
		
		return $jscript;
	}
	
	function m_count_logs()
	{
		$sel = "SELECT COUNT(*) AS log_count FROM tbladmin_sales_log";
		$qry = mysql_query($sel) or dei('Select COUNT error - '.mysql_error());
		$res = mysql_fetch_array($qry);
		
		return $res['log_count'];
	}

	function m_get_log()
	{
		$sel = "
			SELECT log.*, adbk.*, sales.* 
			FROM tbladmin_sales_log log
			LEFT JOIN tbladmin_sales_addbook adbk ON adbk.email = log.sent_to
			LEFT JOIN tbladmin_sales sales ON sales.admin_sales_email = log.from
			ORDER BY log.date_sent DESC, log.id DESC
			LIMIT 20
		";
		$qry = mysql_query($sel) or die('Check Prod No error - '.mysql_error());
		
		return $qry;
	}
	
	
	
