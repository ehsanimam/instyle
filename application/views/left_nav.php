<?php
	if ($this->uri->segment(1) == 'new-arrival' OR $this->uri->segment(1) == 'new-arrival-designer' OR $this->uri->segment(1) == 'new-arrival-facets' OR $this->uri->segment(1) == 'new-arrival-designer-facets')
	{
		$filter = 'new-arrival';
		$cat_id = '';
	}
	else if ($this->uri->segment(1) == 'clearance' OR $this->uri->segment(1) == 'clearance-designer' OR $this->uri->segment(1) == 'clearance-facets' OR $this->uri->segment(1) == 'clearance-designer-facets')
	{
		$filter = 'clearance';
		$cat_id = '';
	}
	else
	{
		$cat_id = $this->set->get_id($this->uri->segment(1));
		$filter = '';
	}
	$cat = explode('-',rtrim($this->uri->segment(1),'.html'));
	
	/*
	| ------------------------------------------------------------------------------------------
	| Top tabs of the left side bar
	*/
	if (str_replace('.html','',$this->uri->segment(1)) == 'new-arrival' OR str_replace('.html','',$this->uri->segment(1)) == 'new-arrival-designer' OR str_replace('.html','',$this->uri->segment(1)) == 'new-arrival-facets' OR str_replace('.html','',$this->uri->segment(1)) == 'new-arrival-designer-facets')
	{
		$new_seg_des = 'new-arrival-designer';
	}
	elseif (str_replace('.html','',$this->uri->segment(1)) == 'clearance' OR str_replace('.html','',$this->uri->segment(1)) == 'clearance-designer' OR str_replace('.html','',$this->uri->segment(1)) == 'clearance-facets' OR str_replace('.html','',$this->uri->segment(1)) == 'clearance-designer-facets')
	{
		$new_seg_des = 'clearance-designer';
	}
	elseif (str_replace('.html','',$this->uri->segment(1)) == 'products')
	{
		$new_seg_des = 'apparel-designer-1';
	}
	else
	{
		$seg_des 	 = array_splice($cat,0,1);
		
		foreach ($seg_des as $des)
		{
			@$seg .= $des.'-';
		}
		
		$seg_id  	 = $this->set->get_id($this->uri->segment(1));
		$new_seg_des = $seg.'designer-'.$seg_id;
	}
	
	if (in_array('designer',$cat))
	{
		$by_designer = 2;
		$by_category = 1;
		$new_seg_cat 	= str_replace(array('-designer','-facets'),array('',''),rtrim($this->uri->segment(1),'.html'));
		$subcat_id		= $this->set->get_id(rtrim($this->uri->segment(3),'.html'));
	}
	elseif (in_array('products',$cat))
	{
		$by_designer = 1;
		$by_category = 2;
		$new_seg_cat 	= 'apparel-1';
		$subcat_id		= $this->set->get_id(rtrim($this->uri->segment(2),'.html'));
	}
	else
	{
		$by_designer = 1;
		$by_category = 2;
		$new_seg_cat 	= str_replace(array('-facets','.html'),array('',''),$this->uri->segment(1));
		$subcat_id		= $this->set->get_id(rtrim($this->uri->segment(2),'.html'));
	}
	
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar top tabs
	*/
	if (str_replace('.html','',$this->uri->segment(1)) != 'clearance' 
		AND str_replace('.html','',$this->uri->segment(1)) != 'clearance-designer' 
		AND str_replace('.html','',$this->uri->segment(1)) != 'clearance-facets' 
		AND str_replace('.html','',$this->uri->segment(1)) != 'clearance-designer-facets')
	{ ?>
		<tr>
			<td><?php echo anchor($new_seg_cat.'.html',img(array('src'=>'images/bu_cat1_'.$by_category .'.gif','border'=>0))); ?></td>
			<td><?php echo anchor($new_seg_des.'.html',img(array('src'=>'images/bu_co1_'.$by_designer .'.gif','border'=>0))); ?></td>
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