<?php
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/
	//ob_implicit_flush(); // ---> for debuggin purposes
	include("../common.php");
	include("security.php");
	//require_once("../functionsadmin.php");

	define('MAIN_BODY_TITLE', 'SALES Package Log');
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

	// count total logs
	$log_count = m_count_logs();
	
	// pagination
	$limit = 20; // ---> set manually for now
	$page = isset($_GET['p']) ? $_GET['p'] : 1;
	$offset = ($page * $limit) - $limit;
	$pagination = l_create_pagination($page, $user_count, $limit, $l = '');

	// get log
	$qry1 = m_get_log();
	
/*
| ---------------------------------------------------------------
| Load views
*/
	include('template.php');
	unset($_SESSION['des_id']);
	