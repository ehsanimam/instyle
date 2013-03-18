<?php
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/
	include("../common.php");
	include("security.php");
	//require_once("../functionsadmin.php");

	define('MAIN_BODY_TITLE', 'LIST Products');
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
	if (SITE_DOMAIN === 'www.storybookknits.com') $qry5 = get_the_subsubcategories();
	
	$limit = 100; // ---> set manually for now
	$page = isset($_GET['p']) ? $_GET['p'] : 1;
	$offset = ($page * $limit) - $limit;
	
	if (isset($_GET['pn']))
	{
		update_publish($_GET, $_POST['pub'.$_GET['pn']]);

		// reconnet to local db
		$link = mysql_connect($host,$username,$password);
		mysql_select_db($db,$link);
	}

	if (isset($_POST['update_sequence']))
	{
		update_sequence($_POST);
		
		// reconnet to local db
		$link = mysql_connect($host,$username,$password);
		mysql_select_db($db,$link);
	}
	
	if (isset($_POST['filter_list_submit']) OR isset($_GET['sel']) OR isset($_GET['tqs']))
	{
		if (isset($_GET['tqs']))
		{
			// --> Search product number via top menu quick search link
			$like_prod_no = isset($_POST['top_quick_search']) ? trim($_POST['top_quick_search']) : '';
			$sql = "SELECT * FROM tbl_product WHERE prod_no LIKE '%".$like_prod_no."%'";
			$re_tqs = mysql_query($sql) or die('Slect TQS error: '.mysql_error());
			$ro_tqs = mysql_fetch_array($re_tqs);
			
			$cat_id = $ro_tqs['cat_id'];
			$des_id = $ro_tqs['designer'];
			$subcat_id = $ro_tqs['subcat_id'];
			if (SITE_DOMAIN === 'www.storybookknits.com') $subsubcat_id = $ro_tqs['subsubcat_id'];
			
			$search_str = $like_prod_no;
		}
		else
		{
			$des_id = isset($_SESSION['des_id']) ? $_SESSION['des_id'] : $_POST['des_id'];
			$cat_id = isset($_SESSION['cat_id']) ? $_SESSION['cat_id'] : $_POST['cat_id'];
			$subcat_id = isset($_SESSION['subcat_id']) ? $_SESSION['subcat_id'] : $_POST['subcat_id'];
			if (SITE_DOMAIN === 'www.storybookknits.com') 
				$subsubcat_id = isset($_SESSION['subsubcat_id']) ? $_SESSION['subsubcat_id'] : $_POST['subsubcat_id'];
		
			$search_str = '';
		}
		
		if ($des_id == '' && $cat_id == '' && $subcat_id == '' && $subsubcat_id == '')
		{
			// return to first page
			echo '
				<script>
					window.location.href = "list_products.php";
				</script>
			';
			exit;
		}
		
		if (isset($_GET['sel']) && $_GET['sel'] == 'clr') { $sel = 'clr'; $clearance = 1; }
		else { $sel = 'reg'; $clearance = ''; }
		
		$qry4 = count_products($des_id, $cat_id, $subcat_id, $subsubcat_id, $clearance, $search_str);
		$res4 = mysql_fetch_array($qry4); // ---> use $res4['count']
		$items_total = $res4['count'];
		
		// free up mysql memory
		mysql_free_result($qry4);
		
		// pagination
		$pagination = create_pagination($page, $items_total, $limit, $sel);
		
		// get products on regular sale
		$qry5 = get_products($des_id, $cat_id, $subcat_id, $subsubcat_id, $limit, $offset, $clearance, $search_str); // ---> $clearance is '' by default
		
		$display = '';
	}
	else $display = 'dd_menu';
	
/*
| ---------------------------------------------------------------
| Load views
*/
	include('template.php');
	unset($_SESSION['des_id']);
	unset($_SESSION['cat_id']);
	unset($_SESSION['subcat_id']);
	unset($_SESSION['subsubcat_id']);
	