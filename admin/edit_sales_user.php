<?php
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/
	//ob_implicit_flush(); // ---> for debuggin purposes
	include("../common.php");
	include("security.php");
	//require_once("../functionsadmin.php");

	define('MAIN_BODY_TITLE', 'Edit Sales User');
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
		
		// validate email
		if (l_validate_email($_POST['sa_email']) == FALSE)
		{
			$_SESSION['m'] = 2;
			// return to first page
			echo '
				<script>
					window.location.href = "'.$_SERVER['REQUEST_URI'].'";
				</script>
			';
			exit;
		}
		
		// confirm password match
		if ($_POST['sa_pword'] != '')
		{
			if ($_POST['sa_pword'] !== $_POST['sa_pword2'])
			{
				$_SESSION['m'] = 3;
				// return to first page
				echo '
					<script>
						window.location.href = "'.$_SERVER['REQUEST_URI'].'";
					</script>
				';
				exit;
			}
		}
		
		// insert new user
		m_update_user($_GET['ee'], $_POST);
		
		// return to first page
		$_SESSION['m'] = 1;
		echo '
			<script>
				window.location.href = "'.$_SERVER['REQUEST_URI'].'";
			</script>
		';
		exit;
	}
	
	// get users
	$sel_user = mysql_fetch_array(m_get_user($_GET['ee']));
	
/*
| ---------------------------------------------------------------
| Load views
*/
	include('template.php');
	if (isset($_SESSION['m'])) unset($_SESSION['m']);
