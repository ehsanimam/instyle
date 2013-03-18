<?php
if(@$act=="logout")
{
	session_unregister("session_admin");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<title>Admin Panel</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="icon" href="<?php echo SITE_URL; ?>favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="<?php echo SITE_URL; ?>favicon.ico" type="image/x-icon" /> 
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

	<script type="text/javascript" src="js/jquery-autocomplete/jquery.autocomplete.min.js">
		/******************************
		* jQuery Autocomplete Plugin
		* http://docs.jquery.com/Plugins/Autocomplete
		*******************************/
	</script>
	<link rel="stylesheet" type="text/css" href="js/jquery-autocomplete/jquery.autocomplete.css" />
	<script type="text/javascript">
		// This is for the quick search at the top
		$().ready(function() {
			$("#top_quick_search").autocomplete("get_style_list.php", {
				width: 100,
				matchContains: true,
				max: 20,
				selectFirst: false
			});
		});
	</script>
	<script type="text/javascript">
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
					position: absolute;
					left: -140px;
					z-index: 200;
					margin: 350px 50% 0 50%;
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

<?php echo isset($div_loader) ? $div_loader.$img_loader : ''; ?>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#666666" style="min-width:1000px;">
<!--DWLayoutTable-->
<tr><td width="100%" height="182" valign="top" bgcolor="#FFFFFF">

	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<!--DWLayoutTable-->
	<tr bgcolor=gray><td width="100%" height="50" valign="top">
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<!--DWLayoutTable-->
		<tr>
			<td height="50" align="center" valign="middle">
				<table width="100%"><tr>
					<td width="33%"></td>
					<td width="33%" align="center"><div><h1><?php echo strtoupper(SITE_NAME); ?> ADMIN</h1></div></td>
					<td width="34%" align="right">
					
						<?php
						if (pathinfo($_SERVER['SCRIPT_FILENAME'],PATHINFO_BASENAME) != 'page_management.php')
						{ ?>
							<div class="text" style="padding-right:20px;">
								<!--bof form=============================================================================-->
								<form name="quick_search_frm" action="" method="POST">
								<h1 style="display:inline;color:#aa0000;padding-right:20px;">QUICK SEARCH </h1>
								<input type="text" name="top_quick_search" id="top_quick_search" value="<?php echo isset($_POST['top_quick_search']) ? $_POST['top_quick_search'] : '';?>" />
								<input type="image" src="../images/icon_go_black.jpg" alt="Go Icon" name="submit_search" value="submit" style="vertical-align:middle;position:relative;top:-2px;margin-left:5px;" onclick="javascript: do_quick_search();" />
								</form>
								<!--eof form=============================================================================-->
							</div>
							<?php
						} ?>
						
					</td>
				</tr></table>
				<div style="clear:both;"></div>
			</td>
        </tr>
		</table>
		
	</td></tr>
	<tr><td valign="top">
	
		<table width="100%" border="0" cellpadding="0" cellspacing="4" bgcolor="#FFFFFF">
		<!--DWLayoutTable-->
		<tr><td width="350" valign="top">
			<div style="min-width:370px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#DCDCDC">
			<!--DWLayoutTable-->
			<tr>
				<td valign="top" class="tab"><? include 'admin_left_menu.php'; ?></td>
			</tr>
			</table>
			</div>
		</td>
		<td valign="top">