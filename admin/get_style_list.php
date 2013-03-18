<?php
	include("../common.php");
	include('../functionsadmin.php');
	include('security.php');

	$q = strtolower($_GET["q"]);
	if (!$q) return;

	$sql = "SELECT DISTINCT prod_no FROM tbl_product WHERE prod_no LIKE '%$q%'";
	$rsd = mysql_query($sql);
	while ($rs = mysql_fetch_array($rsd))
	{
	    $prod_no = $rs['prod_no'];
	    echo "$prod_no\n";
	}
	?>