<?php
	/*
	| ------------------------------------------------------------------------------------------
	| Top tabs background control and link control
	*/
	if (($this->uri->segment(1) == 'designers') OR 
		in_array($this->uri->segment(1), $designers_ary) OR
		($this->uri->segment(1) == 'new-arrival' && $this->uri->segment(2) == 'designers'))
	{
		$by_designer = 2; // --> active
		$by_category = 1;
		$seg_cat = isset($caturl) ? $caturl : $this->uri->segment(2);
		$seg_des = 'designers/'.$seg_cat;
	}
	else
	{
		$by_designer = 1;
		$by_category = 2; // --> active
		$seg_cat = isset($caturl) ? $caturl : $this->uri->segment(1);
		$seg_des = 'designers/'.$seg_cat;
	}
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar top tabs
	*/
	if ($this->config->item('site_domain') == 'www.storybookknits.com')
	{ ?>
		<tr>
			<td colspan="3" style="background:white;height:25px;">BROWSE BY CATEGORIES</td>
		</tr>
		<?php
	}
	else if ($this->uri->segment(1) != 'clearance')
	{ ?>
		<tr>
			<td><?php echo anchor($seg_cat, img(array('src' => 'images/bu_cat1_'.$by_category.'.gif', 'border' => 0))); ?></td>
			<td><?php echo anchor($seg_des, img(array('src' => 'images/bu_co1_'.$by_designer.'.gif', 'border' => 0))); ?></td>
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
			<?php $this->load->view($this->config->slash_item('template').$left_nav); ?>
		</td>
	</tr>
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar lower mid facetings
	*/
	//if ( ! isset($search_result))
	if (isset($search_result))
	{ ?>
		<tr>
			<td colspan="3" class="left faceted_search" style="padding:8px;">
			<?php
			$init_seg = $this->uri->segment(1);
			
			/*
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
				//$this->load->view('faceted_search',array('cat_id'=>$cat_id, 'subcat_id'=>$subcat_id, 'filter'=>$filter));
				$this->load->view($this->config->slash_item('template').'facets');
			//} */?>
			
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
				<form action="<?php echo site_url('search_products'); ?>" method="POST">
				
				<input type="hidden" name="search" value="TRUE" />
				<input type="hidden" name="c_url_structure" value="<?php echo $c_url_structure; ?>" />
				<input type="hidden" name="sc_url_structure" value="<?php echo $sc_url_structure; ?>" />
				
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