<?php
	echo form_open('faceted_search/index');

	$seg = explode('-',$this->uri->segment(1));
	//$cat_id = $this->set->get_id($this->uri->segment(1)); // ----> this $cat_id variable is passed as string already by the parent view
	
	if (in_array('designer',$seg))
	{ ?>
		<input type="hidden" name="des_id" value="<?php echo $this->uri->segment(2); ?>" />
		<?php
		$subcategory 	= rtrim($this->uri->segment(3),'.html');
		$subcat_id 		= $this->set->get_id($subcategory);
		$designer 		= rtrim($this->uri->segment(2),'.html').'/';
		$des_id 		= $this->set->get_id($designer);
		//$search_terms	= explode('-',rtrim($this->uri->segment(4),'.html'));
	}
	else
	{
		$subcategory 	= rtrim($this->uri->segment(2),'.html');
		$subcat_id 		= $this->set->get_id($subcategory);
		$designer		= '';
		$des_id 		= '';
		//$search_terms	= explode('-',rtrim($this->uri->segment(3),'.html'));
	}
?>
<input type="hidden" name="cat_id" value="<?php echo $this->uri->segment(1); ?>" />
<input type="hidden" name="subcat_id" value="<?php echo	$subcategory; ?>" />

<table cellspacing="0" cellpadding="0" border="0">
	<?php
	/*
	| ------------------------------------------------------------------------------------
	| Common Facets
	| ------------------------------------------------------------------------------------
	*/
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
				//$colors = $this->set->get_color_facets($subcat_id, $des_id, $filter);
				$colors = $this->set->get_color_facets('75', '', '');
				if ($colors && $colors->num_rows() > 0)
				{
					/*
					| ------------------------------------------------------------------------------------
					| As far as viewing the facets, just follow the steps: set an array to collect all
					| facets, explode factes where necessary, if not in array, store in array, then display
					| each sorted array
					*/
					// set an array to collect all facets
					$array_color_facet = array();
					$i = 0;
					foreach ($colors->result_array() as $facet_data):
						if ($facet_data['color_facets'] != NULL)
						{
							// explode where necessary
							$exploded_1 = explode('-',$facet_data['color_facets']);
							foreach ($exploded_1 as $facet)
							{
								// clean facets for unwanted characters if entered via CSV
								$facet = str_replace(
									array('"','&'),
									array('','and'),
									$facet
								);
								
								// check for two worded facets and replace underscore with space
								$facet = str_replace('_',' ',$facet);
								
								// check for 4 chars facets with #1 at the end and remove it
								$pos = strpos($facet,'1');
								if (strlen($facet) == 4 && $pos == 3) $facet = substr($facet,0,-1);
								
								// use lower caps in array
								if ( ! in_array(trim(strtolower($facet)),$array_color_facet))
								{
									// if not in array, store in array
									$array_color_facet[$i] = trim(strtolower($facet));
									$i++;
								}
							}
						}
					endforeach;
					// sort array alphabetically
					sort($array_color_facet);
					// display each facet in the sorted array
					foreach ($array_color_facet as $facet):
						if ($this->session->userdata('faceted_colors'))
						{
							$session_faceted_colors = str_replace('_',' ',$this->session->userdata('faceted_colors'));
							$exploded_color_facets = explode('-',$session_faceted_colors);
							$checked = in_array(strtolower($facet),$exploded_color_facets) ? 'checked="checked"' : '' ;
						}
						?>
						<div style="float:left;width:87px;font-size:8px;font-family:arial;">
							<input name="colors[]" class="color_group" value="<?php echo strtolower($facet); ?>" onclick="submit();" type="checkbox" <?php echo @$checked; ?> /><?php echo strtoupper($facet); ?>
						</div>
						<?php
					endforeach;
					// unset variable $checked to avoid carry over to next faceting
					$checked = '';
				}
				else
				{
					echo '<br /><span style="font-family:arial;margin-left:3px;">';
					echo 'No Color Facets';
					echo '</span>';
				}
				?>		  
				</td></tr>
			</tbody>
			</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php echo anchor('faceted_search/reset_facet/colors/'.str_replace('facets-','',$this->uri->segment(1)).'/'.$designer.$subcategory,'click to reset all colors',array('style'=>'color:#ff0000;')); ?>
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
				<tr>
				<tr><td colspan="2">
				<?php
				$styles = $this->set->get_styling($subcat_id, $des_id, $filter); // ---> get styles
				if ($styles && $styles->num_rows() > 0)
				{
					/*
					| ------------------------------------------------------------------------------------
					| As far as viewing the facets, just follow the steps: set an array to collect all
					| facets, explode factes where necessary, if not in array, store in array, then display
					| each sorted array
					|
					*/
					// set an array to collect all facets
					$array_style_facet = array();
					$i = 0;
					foreach ($styles->result_array() as $facet_data):
					
						if ($facet_data['styles'] != NULL && $facet_data['styles'] != '')
						{
							// explode where necessary
							$exploded_1 = explode('-',$facet_data['styles']);
							foreach ($exploded_1 as $facet)
							{
								// clean facets for unwanted characters if entered via CSV
								$facet = str_replace(
									array('"','&'),
									array('','and'),
									$facet
								);
								
								// check for two worded facets and replace underscore with space
								$facet = str_replace('_',' ',$facet);
								
								// check for 4 chars facets with #1 at the end and remove it
								$pos = strpos($facet,'1');
								if (strlen($facet) == 4 && $pos == 3) $facet = substr($facet,0,-1);
								
								// use lower caps in array
								if ( ! in_array(trim(strtolower($facet)),$array_style_facet))
								{
									// if not in array, store in array
									$array_style_facet[$i] = trim(strtolower($facet));
									$i++;
								}
							}
						}
					endforeach;
					// sort array alphabetically
					sort($array_style_facet);
					// display each facet in the sorted array
					foreach ($array_style_facet as $facet):
						// cross check facet with style names
						$xcheck = $this->set->x_check('style',$facet);
						if ($xcheck)
						{
							if ($this->session->userdata('faceted_styles'))
							{
								$session_faceted_styles = str_replace('_',' ',$this->session->userdata('faceted_styles'));
								$exploded_style_facets = explode('-',$session_faceted_styles);
								$checked = in_array(strtolower($facet),$exploded_style_facets) ? 'checked="checked"' : '' ;
								// for 3/4 sleeve
								if ($facet == '3/4 Sleeve' && in_array('3 4 sleeve',$exploded_style_facets)) $checked = 'checked="checked"';
							}
							?>
							<div style="float:left;width:87px;font-size:8px;font-family:arial;">
							<input name="styles[]" class="color_group" value="<?php echo strtolower($facet); ?>" onclick="submit();" type="checkbox" <?php echo @$checked; ?> /><?php echo strtoupper($facet); ?>
							</div>
							<?php
						}
					endforeach;
					// unset variable $checked to avoid carry over to next faceting
					$checked = '';
				}
				else
				{
					echo '<br /><span style="font-family:arial;margin-left:3px;">';
					echo 'No Styles Facets';
					echo '</span>';
				}
				?>
			</td></tr>
        </tbody>
		</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
			<?php echo anchor('faceted_search/reset_facet/styles/'.str_replace('facets-','',$this->uri->segment(1)).'/'.$designer.$subcategory,'click to reset all styling option',array('style'=>'color:#ff0000;')); ?>
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
	if ($cat_id == '1 no to display yet')
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
				$events = $this->set->get_events($subcat_id, $des_id, $filter);
				if ($events && $events->num_rows() > 0)
				{
					/*
					| ------------------------------------------------------------------------------------
					| As far as viewing the facets, just follow the steps: set an array to collect all
					| facets, explode factes where necessary, if not in array, store in array, then display
					| each sorted array
					|
					*/
					// set an array to collect all facets
					$array_event_facet = array();
					$i = 0;
					foreach ($events->result_array() as $facet_data):
						if ($facet_data['events'] != NULL)
						{
							// explode where necessary
							$exploded_1 = explode('-',$facet_data['events']);
							foreach ($exploded_1 as $facet)
							{
								// clean facets for unwanted characters if entered via CSV
								$facet = str_replace(
									array('"','&'),
									array('','and'),
									$facet
								);
								
								// check for two worded facets and replace underscore with space
								$facet = str_replace('_',' ',$facet);
								
								// check for 4 chars facets with #1 at the end and remove it
								$pos = strpos($facet,'1');
								if (strlen($facet) == 4 && $pos == 3) $facet = substr($facet,0,-1);
								
								// use lower caps in array
								if ( ! in_array(trim(strtolower($facet)),$array_event_facet))
								{
									// if not in array, store in array
									$array_event_facet[$i] = trim(strtolower($facet));
									$i++;
								}
							}
						}
					endforeach;
					// sort array alphabetically
					sort($array_event_facet);
					// display each facet in the sorted array
					foreach ($array_event_facet as $facet):
						// cross check facet with style names
						$xcheck = $this->set->x_check('event',$facet);
						if ($xcheck)
						{
							if ($this->session->userdata('faceted_events'))
							{
								$session_faceted_events = str_replace('_',' ',$this->session->userdata('faceted_events'));
								$exploded_event_facets = explode('-',$session_faceted_events);
								$checked = in_array(strtolower($facet),$exploded_event_facets) ? 'checked="checked"' : '' ;
							}
							?>
							<div style="float:left;width:87px;font-size:8px;font-family:arial;">
								<input name="events[]" class="color_group" value="<?php echo strtolower($facet); ?>" onclick="submit();" type="checkbox" <?php echo @$checked; ?> /><?php echo strtoupper($facet); ?>
							</div>
							<?php
						}
					endforeach;
					// unset varialbe $checked to avoid carry over to next faceting
					$checked = '';
				}
				else
				{
					echo '<br /><span style="font-family:arial;margin-left:3px;">';
					echo 'No Event Facets';
					echo '</span>';
				}
				?>		  
				</td></tr>
			</tbody>
			</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php echo anchor('faceted_search/reset_facet/events/'.str_replace('facets-','',$this->uri->segment(1)).'/'.$designer.$subcategory,'click to reset all event facets',array('style'=>'color:#ff0000;')); ?>
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
	if ($cat_id == '19')
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
				$materials = $this->set->get_materials($subcat_id, $des_id, $filter);
				if ($materials && $materials->num_rows() > 0)
				{
					/*
					| ------------------------------------------------------------------------------------
					| As far as viewing the facets, just follow the steps: set an array to collect all
					| facets, explode factes where necessary, if not in array, store in array, then display
					| each sorted array
					|
					*/
					// set an array to collect all facets
					$array_material_facet = array();
					$i = 0;
					foreach ($materials->result_array() as $facet_data):
						if ($facet_data['materials'] != NULL)
						{
							// explode where necessary
							$exploded_1 = explode('-',$facet_data['materials']);
							foreach ($exploded_1 as $facet)
							{
								// clean facets for unwanted characters if entered via CSV
								$facet = str_replace(
									array('"','&'),
									array('','and'),
									$facet
								);
								
								// check for two worded facets and replace underscore with space
								$facet = str_replace('_',' ',$facet);
								
								// check for 4 chars facets with #1 at the end and remove it
								$pos = strpos($facet,'1');
								if (strlen($facet) == 4 && $pos == 3) $facet = substr($facet,0,-1);
								
								// use lower caps in array
								if ( ! in_array(trim(strtolower($facet)),$array_material_facet))
								{
									// if not in array, store in array
									$array_material_facet[$i] = trim(strtolower($facet));
									$i++;
								}
							}
						}
					endforeach;
					// sort array alphabetically
					sort($array_material_facet);
					// display each facet in the sorted array
					foreach ($array_material_facet as $facet):
						// cross check facet with style names
						$xcheck = $this->set->x_check('material',$facet);
						if ($xcheck)
						{
							if ($this->session->userdata('faceted_materials'))
							{
								$session_faceted_materials = str_replace('_',' ',$this->session->userdata('faceted_materials'));
								$exploded_material_facets = explode('-',$session_faceted_materials);
								$checked = in_array(strtolower($facet),$exploded_material_facets) ? 'checked="checked"' : '' ;
							}
							?>
							<div style="float:left;width:87px;font-size:8px;font-family:arial;">
								<input name="materials[]" class="color_group" value="<?php echo strtolower($facet); ?>" onclick="submit();" type="checkbox" <?php echo @$checked; ?> /><?php echo strtoupper($facet); ?>
							</div>
							<?php
						}
					endforeach;
					// unset varialbe $checked to avoid carry over to next faceting
					$checked = '';
				}
				else
				{
					echo '<br /><span style="font-family:arial;margin-left:3px;">';
					echo 'No Material Facets';
					echo '</span>';
				}
				?>		  
				</td></tr>
			</tbody>
			</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php echo anchor('faceted_search/reset_facet/materials/'.str_replace('facets-','',$this->uri->segment(1)).'/'.$designer.$subcategory,'click to reset all material facets',array('style'=>'color:#ff0000;')); ?>
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
	if ($cat_id == '19 not to display yet')
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
				$trends = $this->set->get_trends($subcat_id, $des_id, $filter);
				if ($trends && $trends->num_rows() > 0)
				{
					/*
					| ------------------------------------------------------------------------------------
					| As far as viewing the facets, just follow the steps: set an array to collect all
					| facets, explode factes where necessary, if not in array, store in array, then display
					| each sorted array
					|
					*/
					// set an array to collect all facets
					$array_trend_facet = array();
					$i = 0;
					foreach ($trends->result_array() as $facet_data):
						if ($facet_data['trends'] != NULL)
						{
							// explode where necessary
							$exploded_1 = explode('-',$facet_data['trends']);
							foreach ($exploded_1 as $facet)
							{
								// clean facets for unwanted characters if entered via CSV
								$facet = str_replace(
									array('"','&'),
									array('','and'),
									$facet
								);
								
								// check for two worded facets and replace underscore with space
								$facet = str_replace('_',' ',$facet);
								
								// check for 4 chars facets with #1 at the end and remove it
								$pos = strpos($facet,'1');
								if (strlen($facet) == 4 && $pos == 3) $facet = substr($facet,0,-1);
								
								// use lower caps in array
								if ( ! in_array(trim(strtolower($facet)),$array_trend_facet))
								{
									// if not in array, store in array
									$array_trend_facet[$i] = trim(strtolower($facet));
									$i++;
								}
							}
						}
					endforeach;
					// sort array alphabetically
					sort($array_trend_facet);
					// display each facet in the sorted array
					foreach ($array_trend_facet as $facet):
						// cross check facet with style names
						$xcheck = $this->set->x_check('trend',$facet);
						if ($xcheck)
						{
							if ($this->session->userdata('faceted_trends'))
							{
								$session_faceted_trends = str_replace('_',' ',$this->session->userdata('faceted_trends'));
								$exploded_trend_facets = explode('-',$session_faceted_trends);
								$checked = in_array(strtolower($facet),$exploded_trend_facets) ? 'checked="checked"' : '' ;
							}
							?>
							<div style="float:left;width:87px;font-size:8px;font-family:arial;">
								<input name="trends[]" class="color_group" value="<?php echo strtolower($facet); ?>" onclick="submit();" type="checkbox" <?php echo @$checked; ?> /><?php echo strtoupper($facet); ?>
							</div>
							<?php
						}
					endforeach;
					// unset varialbe $checked to avoid carry over to next faceting
					$checked = '';
				}
				else
				{
					echo '<br /><span style="font-family:arial;margin-left:3px;">';
					echo 'No Trend Facets';
					echo '</span>';
				}
				?>		  
				</td></tr>
			</tbody>
			</table>
			<div style="text-transform:uppercase;font-size:8px;padding:5px 0px 0px 4px;font-weight:bold;">
				<?php echo anchor('faceted_search/reset_facet/trends/'.str_replace('facets-','',$this->uri->segment(1)).'/'.$designer.$subcategory,'click to reset all trend facets',array('style'=>'color:#ff0000;')); ?>
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