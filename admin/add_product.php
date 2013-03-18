<?php
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/
	//ob_implicit_flush(); // ---> for debuggin purposes
	include("../common.php");
	include("security.php");
	//require_once("../functionsadmin.php");

	define('MAIN_BODY_TITLE', 'ADD Product');
	define('FILE_NAME_EXT', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('FILE_NAME', str_replace('.php', '', pathinfo(__FILE__, PATHINFO_BASENAME)));

/*
| ---------------------------------------------------------------
| Load models
*/
	include(FILE_NAME."_models.php");

/*
| ---------------------------------------------------------------
| Load controllers
*/
	$jscript = load_jscript();
	
	$qry1 = get_the_designers();
	$qry2 = get_the_categories();
	$qry3 = get_the_subcategories();
	$qry4 = get_the_colors();
	$qry5 = get_the_subsubcategories();

	if (isset($_POST['submit']))
	{
		$exploded_cs = explode('-',$_POST['cs']);
		$primary_img_id = $exploded_cs[1]; // ---> color_code
		$color = $exploded_cs[0]; // ---> color_name

		// check if prod_no exists
		$check_prodid = check_prod_no($_POST['prod_no']);

		// add prod_no if non existent
		if ($check_prodid === FALSE)
		{
			// check if there is date. if none, create today
			if ($add_date == '') $add_date = @date('m/d/Y',time());
			
			// set view status
			if ($_POST['publish_at_instyle'] === 'Y' && $_POST['publish_at_designer'] === 'Y') $view_status = 'Y'; // --> both by default
			elseif ($_POST['publish_at_instyle'] === 'Y' && $_POST['publish_at_designer'] === 'N') $view_status = 'Y1'; // --> instyle only
			elseif ($_POST['publish_at_instyle'] === 'N' && $_POST['publish_at_designer'] === 'Y') $view_status = 'Y2'; // --> designer only
			elseif ($_POST['publish_at_instyle'] === 'N' && $_POST['publish_at_designer'] === 'N') $view_status = 'N'; // --> not publish anywhere
			
			// add product to storybook
			$add_product = add_product(
				$_POST['prod_name'], 
				$_POST['prod_no'], 
				$view_status, 
				$_POST['designer'], 
				$_POST['cat'], 
				$_POST['subcat'], 
				$_POST['subsubcat'], 
				$add_date, 
				$_POST['prod_desc'], 
				$_POST['catalogue_price'], // --> sale price
				$_POST['less_discount'], // --> retail price
				$primary_img_id, // --> color code
				$_POST['new_arrival'], 
				$color, // --> color name
				$_POST['put_stock']
			);
	
			// add prod_no to db table new_items_count with status as 1 (5 - basix only for now)
			// this is for the sales package auto send email after 10 new items
			if ($_POST['designer'] == 5)
			{
				$add_to_new_items_count = models_add_to_new_items_count($_POST['prod_no'], $_POST['prod_no'].'_'.$primary_img_id, $_POST['designer']);
			}
			
			// add product to designer (5 - basix only for now)
			// --> 'localhost' is dev environment server, contact project manager if otherwise
			if ($_POST['designer'] == 5 && $_SERVER['SERVER_NAME'] !== 'localhost')
			{
				$add_product_at_designer = add_product_at_designer(
					$_POST['prod_name'], 
					$_POST['prod_no'], 
					$view_status, 
					$_POST['designer'], 
					$_POST['cat'], 
					$_POST['subcat'], 
					$_POST['subsubcat'], 
					$add_date, 
					$_POST['prod_desc'], 
					$_POST['catalogue_price'], // --> sale price
					$_POST['less_discount'], // --> retail price
					$primary_img_id, // --> color code
					$_POST['new_arrival'], 
					$color, // --> color name
					$_POST['put_stock']
				);
			}
			
			// send to edit product details page
			/* Redirect to a different page in the current directory that was requested */
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'edit_product_details.php?prod_no='.$_POST['prod_no'];
			header("Location: http://$host$uri/$extra");

			exit;
		}
		else
		{
			$_SESSION['m'] = 1; // 1 = "This style number already exists."
			$_SESSION['style_no'] = $_POST['prod_no'];
			echo "
				<script>
					window.location = 'add_product.php';
				</script>
			";
			exit;
		}
	}
/*
| ---------------------------------------------------------------
| Load views
*/
	include('template.php');
	if (isset($_SESSION['m'])) unset($_SESSION['m']);
	if (isset($_SESSION['style_no'])) unset($_SESSION['style_no']);
	