<?php
	include("../common.php");
	include('../functionsadmin.php');
	include('security.php');

	$q = strtolower($_GET["q"]);
	if ( ! $q) return;
	
	$u = strtolower($_GET["u"]);
	
	if ($u === 'active_consumer')
	{
		$sql = "
			SELECT 
				email, firstname, lastname 
			FROM 
				tbluser_data 
			WHERE 
				is_active = '1'
				AND (
					email LIKE '%$q%'
					OR firstname LIKE '%$q%'
					OR lastname LIKE '%$q%'
				)
		";
		$rsd = mysql_query($sql);
		while ($rs = mysql_fetch_array($rsd))
		{
			$list = $rs['firstname'].' '.$rs['lastname'].' - '.$rs['email'];
			echo "$list\n";
		}
	}
	
	if ($u === 'inactive_consumer')
	{
		$sql = "
			SELECT 
				email, firstname, lastname 
			FROM 
				tbluser_data 
			WHERE 
				is_active = '0'
				AND (
					email LIKE '%$q%'
					OR firstname LIKE '%$q%'
					OR lastname LIKE '%$q%'
				)
		";
		$rsd = mysql_query($sql);
		while ($rs = mysql_fetch_array($rsd))
		{
			$list = $rs['firstname'].' '.$rs['lastname'].' - '.$rs['email'];
			echo "$list\n";
		}
	}
	
	if ($u === 'active_wholesale')
	{
		$sql = "
			SELECT 
				email, firstname, lastname, store_name 
			FROM 
				tbluser_data_wholesale 
			WHERE 
				is_active = '1'
				AND (
					email LIKE '%$q%'
					OR firstname LIKE '%$q%'
					OR lastname LIKE '%$q%'
					OR store_name LIKE '%$q%'
				)
		";
		$rsd = mysql_query($sql);
		while ($rs = mysql_fetch_array($rsd))
		{
			$list = $rs['firstname'].' '.$rs['lastname'].' - '.$rs['email'].' - '.$rs['store_name'];
			echo "$list\n";
		}
	}
	
	if ($u === 'inactive_wholesale')
	{
		$sql = "
			SELECT 
				email, firstname, lastname 
			FROM 
				tbluser_data_wholesale 
			WHERE 
				is_active = '0'
				AND (
					email LIKE '%$q%'
					OR firstname LIKE '%$q%'
					OR lastname LIKE '%$q%'
				)
		";
		$rsd = mysql_query($sql);
		while ($rs = mysql_fetch_array($rsd))
		{
			$list = $rs['firstname'].' '.$rs['lastname'].' - '.$rs['email'];
			echo "$list\n";
		}
	}
	
?>