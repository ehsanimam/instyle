<div id="h_quick_search">
	
	<?php
	if (pathinfo($_SERVER['SCRIPT_FILENAME'],PATHINFO_BASENAME) !== 'page_management.php')
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
	
</div>

<div id="h_title">
	<h1><?php echo strtoupper(SITE_NAME); ?> ADMIN</h1>
</div>

<div style="clear:both;"></div>