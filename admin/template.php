<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<title>Admin Panel <?php echo isset($page_title) ? '| '.$page_title : ''; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	<link rel="icon" href="<?php echo SITE_URL; ?>favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="<?php echo SITE_URL; ?>favicon.ico" type="image/x-icon" /> 
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/spin.js"></script>
	<script type="text/javascript" src="js/stayontop.js"></script>
	
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="style_default.css" rel="stylesheet" type="text/css" />
	
	<?php echo $jscript; ?>
	
	<script type="text/javascript" src="js/jquery-autocomplete/jquery.autocomplete.min.js">
		/******************************
		* jQuery Autocomplete Plugin
		* http://docs.jquery.com/Plugins/Autocomplete
		*******************************/
	</script>
	<link rel="stylesheet" type="text/css" href="js/jquery-autocomplete/jquery.autocomplete.css" />
	
	<script type="text/javascript">
		/******************************
		* Quick Search Plugin
		*******************************/
		$().ready(function() {
			$("#top_quick_search").autocomplete("get_style_list.php", {
				width: 100,
				matchContains: true,
				max: 20,
				selectFirst: false
			});
		});
		function do_quick_search(){
			var x = window.document.getElementById('top_quick_search').value;
			if(x != ''){
				//window.document.quick_search_frm.action="edit_new_product_designer.php?tqs=1";
				window.document.quick_search_frm.action="list_products.php?tqs=1";
				window.document.quick_search_frm.method = "POST";
				window.quick_search_frm.submit();
			}
		}

		
	</script>
	
	<?php
	if (pathinfo($_SERVER['SCRIPT_FILENAME'],PATHINFO_BASENAME) == 'page_management.php')
	{
		/*
		| ------------------------------------------------------------------------
		| Wysiwyg script
		| Used by: Page Management,
		*/
		?>
		<script language="JavaScript" type="text/javascript" src="../jscript/openwysiwyg/scripts/wysiwyg.js"></script>
		<script language="JavaScript" type="text/javascript" src="../jscript/openwysiwyg/scripts/wysiwyg-settings.js"></script>
		<script type="text/javascript">
			// attach the editor to the textarea with the identifier.
			WYSIWYG.attach('textarea_pages',my_settings);
		</script>
		<?php
	}
	
	if (pathinfo($_SERVER['SCRIPT_FILENAME'],PATHINFO_BASENAME) == 'edit_user_wholesale.php')
	{
		/*
		| ------------------------------------------------------------------------
		| Div loader - loader gif
		| Used by: Page Management,
		*/
		?>
		<style>
			#dvloader {
				position: fixed;
				z-index: 99;
				top: 0px;
				left: 0px;
				background-color: black;
				width: 100%;
				height: 100%;
				filter: Alpha(Opacity=40);
				opacity: 0.4;
				-moz-opacity: 0.4;
				text-align: center;
			}
			#imgloader {
				position: relative;
				z-index: 200;
				margin: auto;
				padding: 20px;
				background-color: #353535;
				border: 1px solid #9a9a9a;
				width: 220px;
				text-align: center;
				color: white;
			}
			#imgloader p {
				margin: 0;
				padding: 10px 0 0;
				font-size: 12px;
			}
		</style>
		<script>
			function clear_loader_gif() {
				document.getElementById("dvloader").style.display="none";
				document.getElementById("imgloader").style.display="none";
			}
		</script>
		
		<?php
		$clear_loader_gif = 'onload="clear_loader_gif()"';
		$div_loader = '<div style="display:block" id="dvloader"></div>';
		$img_loader = '<div style="display:block" id="imgloader"><span><img src="'.SITE_URL.'images/loadingAnimation.gif" /><p>Please wiat while loading...</p></span></div>';
	}
	?>
</head>
<body <?php echo isset($clear_loader_gif) ? $clear_loader_gif : ''; ?>>

	<?php
	/*
	| -------------------------------------------------
	| Div loader used by Page_Management.php
	*/
	echo isset($div_loader) ? $div_loader.$img_loader : '';
	?>

	<div id="header">
		<?php include('header.php'); ?>
	</div>
	
	<div id="body_wrapper">
	
		<table width="100%">
			<tr>
				<col width="350" />
				<col />
				<td valign="top">
					<div id="left_sidebar">
						<?php include('left_sidebar.php'); ?>
					</div>
				</td>
				<td valign="top">
					<div id="main_content">
						<?php include(FILE_NAME.'_views.php'); ?>
					</div>
				</td>
			</tr>
		</table>
	
	</div>
	
	<div id="footer">
		<?php include('footer_new.php'); ?>
	</div>
	
</body>
</html>
