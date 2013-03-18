<?php
	/*
	| ------------------------------------------------------------------------------
	| Config
	*/
	if ($_SERVER['SERVER_NAME'] === 'localhost')
	{
		error_reporting(E_ALL); // ----> for development use only
		
		$host = "localhost";
		$username = "root";
		$password = "root";
		$db = "verjel_instyle";
	}
	else
	{
		//error_reporting(E_ALL); // ----> for development use only
		
		// ---> local db's
		switch ($_SERVER['SERVER_NAME'])
		{
			case "www.isntylemoscow.com":
				$host = "localhost";
				$username = "joe_taveras";
				$password = "!@R00+@dm!N";
				$db = "joe_moscow";
			break;
			
			case "www.isntylemilan.com":
				$host = "localhost";
				$username = "joe_milan";
				$password = "m1l@n";
				$db = "joe_milan";
			break;
			
			case "www.basixlbacklable.com":
				$host = "localhost";
				$username = "joereyrusty_icm";
				$password = "!@R00+@dm!N";
				$db = "icmbasix_main";
			break;
			
			case "www.instylenewyork.com":
				$host = "localhost";
				$username = "verjel";
				$password = "icmstudio";
				$db = "verjel_instyle";
			break;
		}
	}

	/*
	| ------------------------------------------------------------------------------
	| Connet to db
	*/
	$link = mysql_connect($host,$username,$password);
	mysql_select_db($db,$link);

	/*
	| ------------------------------------------------------------------------------
	| Actual autocomplete code
	*/
	$q = strtolower($_GET["q"]);
	if (!$q) return;

	$sql = "
		SELECT DISTINCT p.prod_no 
		FROM 
			tbl_product p 
			JOIN tbl_stock ts ON ts.prod_no = p.prod_no 
		WHERE 
			p.prod_no LIKE '%$q%' 
			AND (p.view_status = 'Y' OR p.view_status = 'Y2')
	";
	$rsd = mysql_query($sql) or die(mysql_error());
	while ($rs = mysql_fetch_array($rsd))
	{
	    $prod_no = $rs['prod_no'];
	    echo "$prod_no\n";
	}
