<?php
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/
	//ob_implicit_flush(); // ---> for debuggin purposes
	include("../common.php");
	include("security.php");
	//require_once("../functionsadmin.php");

	define('MAIN_BODY_TITLE', 'Add Sales User');
	define('FILE_NAME_EXT', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('FILE_NAME', str_replace('.php', '', pathinfo(__FILE__, PATHINFO_BASENAME)));

/*
| ---------------------------------------------------------------
| Load models
*/
	include(FILE_NAME."_models.php");

/*
| ---------------------------------------------------------------
| Load libraries
*/
	include(FILE_NAME."_libraries.php");

/*
| ---------------------------------------------------------------
| Load controllers
*/
	$jscript = load_jscript();

	if (isset($_POST['submit']))
	{
		$_SESSION['sa_user'] = $_POST['sa_user'];
		$_SESSION['sa_lname'] = $_POST['sa_lname'];
		$_SESSION['sa_email'] = $_POST['sa_email'];
		$_SESSION['sa_pword'] = $_POST['sa_pword'];
		
		// validate email
		if (validate_email($_POST['sa_email']) == FALSE)
		{
			$_SESSION['m'] = 2;
			// return to first page
			echo '
				<script>
					window.location.href = "add_sales_user.php";
				</script>
			';
			exit;
		}
		
		// confirm password match
		if ($_POST['sa_pword'] !== $_POST['sa_pword2'])
		{
			$_SESSION['m'] = 3;
			// return to first page
			echo '
				<script>
					window.location.href = "add_sales_user.php";
				</script>
			';
			exit;
		}
		
		// check if email exists
		if (m_check_sales_user($_POST['sa_email']))
		{
			$_SESSION['m'] = 1;
			// return to first page
			echo '
				<script>
					window.location.href = "add_sales_user.php";
				</script>
			';
			exit;
		}
		
		// insert new user
		l_add_user($_POST);
		
		// go to sales user list page
		header("Location: list_sales_user.php");
	}
	
/*
| ---------------------------------------------------------------
| Load views
*/
	include('template.php');
	if (isset($_SESSION['m'])) unset($_SESSION['m']);
	if (isset($_SESSION['sa_user'])) unset($_SESSION['sa_user']);
	if (isset($_SESSION['sa_lname'])) unset($_SESSION['sa_lname']);
	if (isset($_SESSION['sa_email'])) unset($_SESSION['sa_email']);
	if (isset($_SESSION['sa_pword'])) unset($_SESSION['sa_pword']);
	