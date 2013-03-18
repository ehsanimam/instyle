<?php
	/*
	| ------------------------------------------------------------------------------------------
	| Top tabs background controll
	*/
	if (($this->uri->segment(1) == 'designers') OR ($this->uri->segment(1) == 'new-arrival' && $this->uri->segment(2) == 'designers'))
	{
		$by_designer = 2;
		$by_category = 1;
	}
	else
	{
		$by_designer = 1;
		$by_category = 2;
	}
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar top tabs
	*/
	if ($this->uri->segment(1) != 'clearance')
	{ ?>
		<tr>
			<td><?php echo anchor('products/'.$this->uri->segment(2), img(array('src' => 'images/bu_cat1_'.$by_category.'.gif', 'border' => 0))); ?></td>
			<td><?php echo anchor('designers/'.$this->uri->segment(2), img(array('src' => 'images/bu_co1_'.$by_designer.'.gif', 'border' => 0))); ?></td>
			<td style="width:70px;background:#fff;">&nbsp;</td>
		</tr>
		<?php
	}
	else
	{ ?>
		<tr>
			<td colspan="3" style="background:white;color:red;height:30px;">CLEARANCE CATEGORIES</td>
		</tr>
		<?php
	}
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar upper mid nav contents where categories and subcats are displayed
	*/
	?>
	<tr>
		<td colspan="3" class="left" style="padding:12px;">
			<?php $this->load->view($left_nav); ?>
		</td>
	</tr>
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar lower mid facetings
	*/
	if ( ! isset($search_result))
	{ ?>
		<tr>
			<td colspan="3" class="left faceted_search" style="padding:8px;">
			<?php
			$init_seg = $this->uri->segment(1);
			
			if ($subcat_id)
			{
				/*
				| --------------------------------------------------------------------------------------
				| This is remove faceting on new-arrival and clearance
				if ($init_seg != 'new-arrival' && $init_seg != 'new-arrival-designer' && $init_seg != 'clearance' && $init_seg != 'clearance-designer')
				{
					$this->load->view('faceted_search',array('cat_id'=>$cat_id, 'subcat_id'=>$subcat_id, 'filter'=>$filter));
				}
				*/
				$this->load->view('faceted_search',array('cat_id'=>$cat_id, 'subcat_id'=>$subcat_id, 'filter'=>$filter));
			} ?>
			
			</td>
		</tr>	
		<?php
	}
	/*
	| --------------------------------------------------------------------------------------
	| Serach By Style # area
	*/
	if (isset($search_by_style) && $search_by_style)
	{ ?>
		<tr>
			<td colspan="3" class="left" style="padding:9px;">
				<!--bof form==========================================================================-->
				<form action="<?php echo site_url('products/search_product'); ?>" method="POST">
				<input type="hidden" name="search" value="TRUE" />
				<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td>
							<span style="font-size:8px;line-height:10px;">&nbsp;SEARCH BY STYLE NUMBER</span>
							<input type="text" name="style_no" id="search_by_style" value="" style="width:110px;height:12px;font-size:10px;" />
							<input type="image" src="<?php echo base_url(); ?>images/icon_go.jpg" alt="Go Icon" name="submit_search" value="SEARCH" height="16" style="position:relative;top:5px;margin:0 0 0 4px;" />
						</td>
					</tr>
					<!--
					<tr>
						<td class="normal_txt txtleft"><input type="submit" class="search_head submit" name="submit_search" value="SEARCH"/></td>
					</tr>
					-->
				</table>
				</form>
				<!--eof form==========================================================================-->
			</td>
		</tr>
		<?php
	} ?>
</table>