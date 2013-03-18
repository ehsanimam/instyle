<div id="header_wrapper">
	<div id="header">
	
		<div style="float:right;">
			<?php
			/*
			| --------------------------------------------------------------------------------------
			| Serach By Style # area
			*/
			if (isset($search_by_style) && $search_by_style)
			{ ?>
				<!--bof form==========================================================================-->
				<form action="<?php echo site_url('sa/search_products'); ?>" method="POST" style="float:right;">
				
				<input type="hidden" name="search" value="TRUE" />
				<input type="hidden" name="c_url_structure" value="<?php echo $c_url_structure; ?>" />
				<input type="hidden" name="sc_url_structure" value="<?php echo $sc_url_structure; ?>" />
	
				<input type="text" name="style_no" id="search_by_style" value="" style="width:102px;font-size:12px;margin-bottom:2px;" />
				<input type="image" src="<?php echo base_url(); ?>images/icon_go.jpg" alt="Go Icon" name="submit_search" value="SEARCH" height="23" style="position:relative;top:7px;" />
				</form>
				<!--eof form==========================================================================-->
				<br style="clear:both;" />
				SEARCH BY STYLE NUMBER
				<?php
			} ?>
		</div>
		
		<?php
		/*
		| --------------------------------------------------------------------------------------
		| Multi item search link
		*/
		if (isset($search_by_style) && $search_by_style)
		{ ?>
			<div style="float:right;padding:17px 30px 0 0;">
				<a href="<?php echo site_url('sa/multi_search'); ?>" id="sa_searchmulti" style="color:white;">SEARCH MULTIPLE ITEMS</a>
			</div>
			<?php
		} ?>
	
		<div style="color:white;font-size:24px;padding-top:8px;font-family:'Arial Narrow';font-weight:normal;">
			SEND IMAGES AND PRICES TO CUSTOMERS
		</div>
		
	</div> <!--eof header-->
</div> <!--eof header_wrapper-->
