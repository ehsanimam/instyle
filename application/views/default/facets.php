<?php echo form_open('facet_search'); ?>
<input type="hidden" name="url_structure" value="<?php echo $this->uri->segment(1); ?>" />
<?php if ($this->uri->segment(1) !== 'clearance')
echo '<input type="hidden" name="sc_url_structure" value="'.$sc_url_structure.'" />'; ?>

<table cellspacing="0" cellpadding="0" border="0">
	<?php
	/*
	| ------------------------------------------------------------------------------------
	| Common Facets
	| ------------------------------------------------------------------------------------
	*/
	
	// Get the facets from url for checking on list of facets per type
	if (isset($url_facets))
	{
		$url_faceted_type = str_replace('_',' ',$url_facets);
		$exploded_type_facets = explode('-',$url_faceted_type);
	}
	else $exploded_type_facets = '';
	
	/*
	| ------------------------------------------------------------------------------------
	| COLORS
	*/
	?>
	<tr>
		<td align="left">&nbsp;<strong>REFINE BY COLORS</strong></td>
	</tr>
	<tr>
		<td>	
			<table border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr><td colspan="2">
					
					<?php
					echo $this->facets->show_facets($qry_color_facet, $facet_field_name_color, $exploded_type_facets);
					?>
					
				</td></tr>
			</tbody>
			</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php
				if (isset($url_facets))
					echo anchor('facet_search/reset/colors/'.$url_facets.'/'.$this->uri->segment(1).'/'.$sc_url_structure.'/'.$subcat_id.'/'.$des_id.'/'.$filter, 'click to reset all color facets', array('style' => 'color:#ff0000;'));
				else
					echo '<a href="javascript:void(0)" style="color:#ff0000;">click to reset all color facets</a>';
				?>
			</div>
			<br /><br />
		</td>
	</tr>
	<?php
	/*
	| ------------------------------------------------------------------------------------
	| STYLES
	*/
	?>
	<tr>
		<td align="left">&nbsp;<strong>REFINE BY STYLING</strong></td>
	</tr>
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr><td colspan="2">
					
					<?php
					/*
					if ($this->session->userdata('faceted_styles'))
					{
						$session_faceted_styles = str_replace('_',' ',$this->session->userdata('faceted_styles'));
						$exploded_style_facets = explode('-',$session_faceted_styles);
					}
					else $exploded_style_facets = '';
					
					if ($url_facets)
					{
						$session_faceted_styles = str_replace('_',' ',$url_facets);
						$exploded_style_facets = explode('-',$session_faceted_styles);
					}
					*/
					
					echo $this->facets->show_facets($qry_style_facet, $facet_field_name_style, $exploded_type_facets/*exploded_style_facets*/);
					?>
					
				</td></tr>
        </tbody>
		</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php
				if (isset($url_facets))
					echo anchor('facet_search/reset/styles/'.$url_facets.'/'.$this->uri->segment(1).'/'.$sc_url_structure.'/'.$subcat_id.'/'.$des_id.'/'.$filter, 'click to reset all style facets', array('style' => 'color:#ff0000;'));
				else
					echo '<a href="javascript:void(0)" style="color:#ff0000;">click to reset all style facets</a>';
				?>
			</div>
        <br><br />
		</td>
	</tr>
	<?php
	/*
	| ------------------------------------------------------------------------------------
	| Facets specific to the category
	| ------------------------------------------------------------------------------------
	*/
	/*
	| ------------------------------------------------------------------------------------
	| EVENTS
	*/
	//if ($cat_id == '1 not to display yet')
	if ($c_url_structure == 'apparel - not for display yet')
	{ ?>
	<tr>
		<td align="left">&nbsp;<strong>REFINE BY EVENTS</strong></td>
	</tr>
	<tr>
		<td>	
			<table border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr><td colspan="2">
					
					<?php
					/*
					if ($this->session->userdata('faceted_events'))
					{
						$session_faceted_events = str_replace('_',' ',$this->session->userdata('faceted_events'));
						$exploded_event_facets = explode('-',$session_faceted_events);
					}
					else $exploded_event_facets = '';
					*/
					
					echo $this->facets->show_facets($qry_event_facet, $facet_field_name_event, $exploded_type_facets);
					?>
					
				</td></tr>
			</tbody>
			</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php
				if (isset($url_facets))
					echo anchor('facet_search/reset/events/'.$url_facets.'/'.$this->uri->segment(1).'/'.$sc_url_structure.'/'.$subcat_id.'/'.$des_id.'/'.$filter, 'click to reset all event facets', array('style' => 'color:#ff0000;'));
				else
					echo '<a href="javascript:void(0)" style="color:#ff0000;">click to reset all event facets</a>';
				?>
			</div>
			<br /><br />
		</td>
	</tr>
	<?php
	}
	/*
	| ------------------------------------------------------------------------------------
	| MATERIALS
	*/
	//if ($cat_id == '19 not to display yet')
	if ($c_url_structure == 'accessories')
	{ ?>
	<tr>
		<td align="left">&nbsp;<strong>REFINE BY MATERIALS</strong></td>
	</tr>
	<tr>
		<td>	
			<table border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr><td colspan="2">
					
					<?php
					/*
					if ($this->session->userdata('faceted_materials'))
					{
						$session_faceted_materials = str_replace('_',' ',$this->session->userdata('faceted_materials'));
						$exploded_material_facets = explode('-',$session_faceted_materials);
					}
					else $exploded_material_facets = '';
					*/
					
					echo $this->facets->show_facets($qry_material_facet, $facet_field_name_material, $exploded_type_facets);
					?>
					
				</td></tr>
			</tbody>
			</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php
				if (isset($url_facets))
					echo anchor('facet_search/reset/materials/'.$url_facets.'/'.$this->uri->segment(1).'/'.$sc_url_structure.'/'.$subcat_id.'/'.$des_id.'/'.$filter, 'click to reset all material facets', array('style' => 'color:#ff0000;'));
				else
					echo '<a href="javascript:void(0)" style="color:#ff0000;">click to reset all material facets</a>';
				?>
			</div>
			<br /><br />
		</td>
	</tr>
	<?php
	}
	/*
	| ------------------------------------------------------------------------------------
	| TRENDS
	*/
	//if ($cat_id == '19 not to display yet')
	if ($c_url_structure == 'accessories - not to display yet')
	{ ?>
	<tr>
		<td align="left">&nbsp;<strong>REFINE BY TRENDS</strong></td>
	</tr>
	<tr>
		<td>	
			<table border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr><td colspan="2">
					
					<?php
					/*
					if ($this->session->userdata('faceted_trends'))
					{
						$session_faceted_trends = str_replace('_',' ',$this->session->userdata('faceted_trends'));
						$exploded_trend_facets = explode('-',$session_faceted_trends);
					}
					else $exploded_trend_facets = '';
					*/
					
					echo $this->facets->show_facets($qry_trend_facet, $facet_field_name_trend, $exploded_type_facets);
					?>
					
				</td></tr>
			</tbody>
			</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php
				if (isset($url_facets))
					echo anchor('facet_search/reset/trends/'.$url_facets.'/'.$this->uri->segment(1).'/'.$sc_url_structure.'/'.$subcat_id.'/'.$des_id.'/'.$filter, 'click to reset all trend facets', array('style' => 'color:#ff0000;'));
				else
					echo '<a href="javascript:void(0)" style="color:#ff0000;">click to reset all trend facets</a>';
				//echo anchor($this->uri->segment(1).'/'.$sc_url_structure, 'click to reset all trend facets', array('style' => 'color:#ff0000;'));
				//echo anchor('faceted_search/reset_facet/trends/'.str_replace('facets-','',$this->uri->segment(1)).'/'.$designer.$subcategory,'click to reset all trend facets',array('style'=>'color:#ff0000;'));
				?>
			</div>
			<br /><br />
		</td>
	</tr>
	<?php
	} ?>
	<tr>
		<td></td>
	</tr>
</table>
<?php
	echo form_close();