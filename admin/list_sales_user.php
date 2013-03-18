<?php
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/
	//ob_implicit_flush(); // ---> for debuggin purposes
	include("../common.php");
	include("security.php");
	//require_once("../functionsadmin.php");

	define('MAIN_BODY_TITLE', 'SALES Users Edit');
	define('FILE_NAME_EXT', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('FILE_NAME', str_replace('.php', '', pathinfo(__FILE__, PATHINFO_BASENAME)));

/*
| ---------------------------------------------------------------
| Load models
*/
	include(FILE_NAME."_models.php");

/*
| ---------------------------------------------------------------
| Load library
*/
	include(FILE_NAME."_libraries.php");

/*
| ---------------------------------------------------------------
| This is where the fucntions and other controllers scripts are
*/
	$jscript = load_jscript();
	
	// check url options
	if (isset($_GET['sel']) && $_GET['sel'] === 'inact')
	{
		$user_choice = '0';
		$l = 'inact';
	}
	else
	{
		$user_choice = '1';
		$l = '';
	}

	// count total users for pagination
	$user_count = m_count_user($user_choice);
	
	// pagination
	$limit = 1500; // ---> set manually for now
	$page = isset($_GET['p']) ? $_GET['p'] : 1;
	$offset = ($page * $limit) - $limit;
	$pagination = l_create_pagination($page, $user_count, $limit, $l);

	// delete user
	if (isset($_GET['ed']) && $_GET['ed'] != '')
	{
		// delete user
		m_del_user($_GET['ed']);
		
		// return to first page
		echo '
			<script>
				window.location.href = "list_sales_user.php";
			</script>
		';
		exit;
	}
	
	// deactivate user
	if (isset($_GET['de']) && $_GET['de'] != '')
	{
		// delete user
		m_deactivae_user($_GET['de']);
		
		// return to first page
		echo '
			<script>
				window.location.href = "list_sales_user.php?sel=inact";
			</script>
		';
		exit;
	}
	
	// get users
	$qry1 = m_get_users($user_choice);
	
/*
| ---------------------------------------------------------------
| Load views
*/
	include('template.php');
	//unset($_SESSION['des_id']);
	