<?php
/*
| ----------------------------------------------------------
| Getting the seque and making it the same for instyle and basix
*/
	include("../common.php");
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	//define('DESIGNER', 'Basix Black Lable');
	define('DES_ID', '5');
	define('SUBCAT_ID' ,'132');
	
$conn = mysql_connect($host,$username,$password);
mysql_select_db($db,$conn);

	$sel1 = "
		SELECT p.seque, p.primary_img_id, p.prod_no, p.view_status
		FROM tbl_product p
		WHERE prod_no = 'D5929A'
	";
	$qry1 = mysql_query($sel1);
	
	$res1 = mysql_fetch_array($qry1);
	
	print_r($res1);
	echo '<br />';
	
mysql_close($conn);

$conn_remote = mysql_connect($host_remote,$username_remote,$password_remote);
mysql_select_db($db_remote,$conn_remote);

	$sel2 = "
		SELECT p.seque, p.primary_img_id, p.prod_no, p.view_status
		FROM tbl_product p
		WHERE prod_no = 'D5929A'
	";
	$qry2 = mysql_query($sel2);
	
	$res2 = mysql_fetch_array($qry2);
	
	print_r($res2);
	echo '<br />';
	
mysql_close($conn_remote);

$conn = mysql_connect($host,$username,$password);
mysql_select_db($db,$conn);

	$s1 = "UPDATE tbl_product SET view_status = 'Y' WHERE prod_no = 'D5929A'";
	$r1 = mysql_query($s1);

	$sel1 = "
		SELECT p.seque, p.primary_img_id, p.prod_no, p.view_status
		FROM tbl_product p
		WHERE prod_no = 'D5929A'
	";
	$qry1 = mysql_query($sel1);
	
	$res1 = mysql_fetch_array($qry1);
	
	print_r($res1);
	echo '<br />';
	
mysql_close($conn);

$conn_remote = mysql_connect($host_remote,$username_remote,$password_remote);
mysql_select_db($db_remote,$conn_remote);

	$r2 = mysql_query($s1);

	$sel2 = "
		SELECT p.seque, p.primary_img_id, p.prod_no, p.view_status
		FROM tbl_product p
		WHERE prod_no = 'D5929A'
	";
	$qry2 = mysql_query($sel2);
	
	$res2 = mysql_fetch_array($qry2);
	
	print_r($res2);
	echo '<br />';
	
mysql_close($conn_remote);

