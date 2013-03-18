<?php
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/
	ob_implicit_flush(); // ---> for debuggin purposes
	include("../common.php");
	include("security.php");
	//require_once("../functionsadmin.php");

	define('MAIN_BODY_TITLE', 'EDIT Product');
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
	
	$qry1 = get_the_designers();
	$qry2 = get_the_categories();
	$qry3 = get_the_subcategories();
	$qry4 = get_the_colors();
	$qry6 = get_styles_facets();
	$qry7 = get_events_facets();
	$qry8 = get_materials_facets();
	$qry9 = get_trends_facets();
	$qry10 = get_the_subsubcategories();

	/* NOTES:
	We need to put an option where someone accidentally puts the url with a variable string on it.
	Just the script. 
	*/
	$prod_no = isset($_GET['prod_no']) ? $_GET['prod_no'] : '000-001';
	
	// check if prod_no is existing and load the details
	$prod_details_qry = check_prod_no($prod_no);
	if ($prod_details_qry === FALSE)
	{
		// return the user to list products first page
		echo 'Uh oh';
	}
	else $prod_detail = mysql_fetch_array($prod_details_qry);
	
	// get different colors and stocks
	$prod_colors_qry = get_product_colors($prod_no);
	
	// -----------------------------------------
	// ---> DELETE stocks
	if (isset($_GET['act']) && $_GET['act'] == 'del_stock')
	{
		delete_stock($_GET);
		exit;
	}
	
	// -----------------------------------------
	// ---> PUBLISH/UNPUBLISH colors
	if (isset($_GET['act']) && $_GET['act'] == 'color_pub')
	{
		pubunpub_color($_GET);
		exit;
	}
	
	// -----------------------------------------
	// ---> UPDATE database
	if (isset($_POST['cmd_cat_submit']))
	{
		//echo '<br />Updating product. Please wait...<br />';
		update_prod_no($_POST, $_FILES);
		exit;
	}
	
/*
| ---------------------------------------------------------------
| Load views
*/
	include('template.php');
	unset($_SESSION['m']);
	