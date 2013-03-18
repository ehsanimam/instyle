<?php
/*
| ---------------------------------------------------------------------------------------------
| Error and prompt messages
*/
if (isset($_SESSION['m']) && $_SESSION['m'] == 1)
	$msg = '<span class="error new_error" style="position:relative;top:-5px;">Delete image Successful.</span>';
if (isset($_SESSION['m']) && $_SESSION['m'] == 2)
	$msg = '<span class="error new_error" style="position:relative;top:-5px;">Images & Stock Added Successfully.</span>';
if (isset($_SESSION['m']) && $_SESSION['m'] == 3)
	$msg = '<span class="error new_error" style="position:relative;top:-5px;">Product Updated.</span>';
?>
	
<h2><?php echo MAIN_BODY_TITLE.' &nbsp; - &nbsp; '.$prod_no; ?> &nbsp; <?php echo isset($msg) ? $msg : ''; ?></h1>

<!--bof form============================================================================-->
<form name="prod_frm" method="post" action="<?php echo FILE_NAME_EXT.'?'.$_SERVER['QUERY_STRING']; ?>" enctype="multipart/form-data" onsubmit="return check_required_fields();">
	
<div id="content_wrapper">
	
<?php
// --------------------------------------------------------------------------
// ---> CONTENT 1
?>
<div id="content1" class="content">

	<ul class="view_tabs">
		<li class="selected"><a href="javascript: void();" onclick="select_me('content1')">Product Details</a></li>
	</ul>

	<br />
	
	<table>
		<col width="200" />
		<col />
		
		<?php
		// -----------------------------------------
		// ---> Product Name and Number
		?>
		<tr>
			<td class="common">
				<label class="form_label">Product name</label> :
			</td>
			<td class="common">
				<input type="text" id="prod_name" name="prod_name" class="inputbox" value="<?php echo $prod_detail['prod_name']; ?>" style="width: 300px;" />
				<input type="hidden" id="prod_no" name="prod_no" value="<?php echo $prod_detail['prod_no']; ?>" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Sequence
		?>
		<tr>
			<td class="common">
				<label class="form_label">Sequence</label> :
			</td>
			<td class="common">
				<input type="text" id="seque" name="seque" class="inputbox" value="<?php echo $prod_detail['seque']; ?>" style="width: 80px;" />
			</td>
		</tr>
		<tr><td><br /></td><td></td></tr>
		<?php
		// -----------------------------------------
		// ---> Publish at Instyle
		switch ($prod_detail['view_status'])
		{
			case "Y":
				$ch1 = 'checked="checked"';
				$ch1n = '';
				$ch2 = 'checked="checked"';
				$ch2n = '';
			break;
			
			case "Y1":
				$ch1 = 'checked="checked"';
				$ch1n = '';
				$ch2 = '';
				$ch2n = 'checked="checked"';
			break;
			
			case "Y2":
				$ch1 = '';
				$ch1n = 'checked="checked"';
				$ch2 = 'checked="checked"';
				$ch2n = '';
			break;
			
			default:
				$ch1 = '';
				$ch1n = 'checked="checked"';
				$ch2 = '';
				$ch2n = 'checked="checked"';
		}
		
		if (SITE_DOMAIN == 'www.storybookknits.com') $ref_site = 'Storybook';
		else $ref_site = 'Instyle';
		?>
		<tr>
			<td class="common">
				<label class="form_label">Publish at <?php echo $ref_site; ?></label> :
			</td>
			<td class="common">
				<input type="radio" name="publish_at_instyle" value="Y" <?php echo $ch1; ?> /> Yes 
				&nbsp; 
				<input type="radio" name="publish_at_instyle" value="N" <?php echo $ch1n; ?>/> No
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Designer
		?>
		<tr>
			<td class="common">
				<label class="form_label">Designer</label> :
			</td>
			<td class="common">
				<select id="designer" name="designer">
					<option value=""></option>
					<?php
					// used $qry1 variable
					if (mysql_num_rows($qry1) > 0)
					{
						while ($row1 = mysql_fetch_array($qry1))
						{ ?>
							<option value="<?php echo $row1['des_id']; ?>" <?php echo $row1['des_id'] == $prod_detail['designer'] ? 'selected' : ''; ?>><?php echo $row1['designer']; ?></option>
							<?php
						}
					} ?>
				</select>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Publish at Designer
		?>
		<tr>
			<td class="common">
				<label class="form_label">Publish at Designer</label> :
			</td>
			<td class="common">
				<input type="radio" name="publish_at_designer" value="Y" <?php echo $ch2; ?> /> Yes 
				&nbsp; 
				<input type="radio" name="publish_at_designer" value="N" <?php echo $ch2n; ?> /> No
			</td>
		</tr>
		<tr><td><br /></td><td></td></tr>
		<?php
		// -----------------------------------------
		// ---> Category name
		?>
		<tr>
			<td class="common">
				<label class="form_label">Category name</label> :
			</td>
			<td class="common">
				<select id="cat" name="cat">
					<option value=""></option>
					<?php
					if (mysql_num_rows($qry2) > 0)
					{
						while ($row2 = mysql_fetch_array($qry2))
						{
							if ($row2['cat_id'] != '23')
							{ ?>
								<option value="<?php echo $row2['cat_id']; ?>" <?php echo $row2['cat_id'] == $prod_detail['cat_id'] ? 'selected' : ''; ?>><?php echo $row2['cat_name']; ?></option>
								<?php
							}
						}
					} ?>
				</select>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Subcategory name
		?>
		<tr>
			<td class="common">
				<label class="form_label">SubCategory name</label> :
			</td>
			<td class="common">
				<select id="subcat" name="subcat">
					<option value=""></option>
					<?php
					if (mysql_num_rows($qry3) > 0)
					{
						while ($row3 = mysql_fetch_array($qry3))
						{ ?> 
							<option value="<?php echo $row3['subcat_id']; ?>" <?php echo $row3['subcat_id'] == $prod_detail['subcat_id'] ? 'selected' : ''; ?>><?php echo $row3['subcat_name']; ?></option>
							<?php
						}
					} ?>
				</select>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Subsubcategory name
		if (SITE_DOMAIN == 'www.storybookknits.com')
		{ ?>
			<tr>
				<td class="common">
					<label class="form_label">SubSubCategory name</label> :
				</td>
				<td class="common">
					<select id="subsubcat" name="subsubcat">
						<option value=""></option>
						<?php
						if (mysql_num_rows($qry10) > 0)
						{
							while ($row10 = mysql_fetch_array($qry10))
							{ ?> 
								<option value="<?php echo $row10['id']; ?>" <?php echo $row10['id'] == $prod_detail['subsubcat_id'] ? 'selected' : ''; ?>><?php echo $row10['name']; ?></option>
								<?php
							}
						} ?>
					</select>
				</td>
			</tr>
			<?php
		}
		else
		{ ?>
			<tr>
				<td><br /></td>
				<td><input type="hidden" name="subsubcat" value="0" /></td>
			</tr>
			<?php
		}
		// -----------------------------------------
		// ---> New Arrival
		if ($prod_detail['new_arrival'] == 'Y' OR
			$prod_detail['new_arrival'] == 'y' OR
			$prod_detail['new_arrival'] == 'Yes' OR
			$prod_detail['new_arrival'] == 'yes')
		{
			$chnay = 'checked="checked"';
			$chnan = '';
		}
		else
		{
			$chnay = '';
			$chnan = 'checked="checked"';
		}
		?>
		<tr>
			<td class="common">
				<label class="form_label">New Arrival</label> :
			</td>
			<td class="common">
				<input type="radio" name="new_arrival" value="yes" <?php echo $chnay; ?> /> Yes 
				&nbsp; 
				<input type="radio" name="new_arrival" value="no" <?php echo $chnan; ?> /> No
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Clearance
		if ($prod_detail['clearance'] == 'Y' OR
			$prod_detail['clearance'] == 'y' OR
			$prod_detail['clearance'] == 'Yes' OR
			$prod_detail['clearance'] == 'yes')
		{
			$chcy = 'checked="checked"';
			$chcn = '';
		}
		else
		{
			$chcy = '';
			$chcn = 'checked="checked"';
		}
		?>
		<tr>
			<td class="common">
				<label class="form_label">Clearance</label> :
			</td>
			<td class="common">
				<input type="radio" name="clearance" value="yes" <?php echo $chcy; ?> /> Yes 
				&nbsp; 
				<input type="radio" name="clearance" value="no" <?php echo $chcn; ?> /> No
			</td>
		</tr>
		<tr><td><br /></td><td></td></tr>
		<?php
		// -----------------------------------------
		// ---> Date
		?>
		<tr>
			<td class="common">
				<label class="form_label">Product Date</label> :
			</td>
			<td class="common">
				<input type="text" name="add_date" id="add_date" class="date-pick" value="<?php echo $prod_detail['prod_date']; ?>" /><span class="text">&nbsp;(format:mm/dd/yyyy)</span>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Sale Price
		?>
		<tr>
			<td class="common">
				<label class="form_label">Our sale price</label> :
			</td>
			<td class="common">
				<input type="text" name="catalogue_price" class="inputbox" value="<?php echo $prod_detail['catalogue_price']; ?>" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Retail Price
		?>
		<tr>
			<td class="common">
				<label class="form_label">Retail price</label> :
			</td>
			<td class="common">
				<input type="text" name="less_discount" class="inputbox" value="<?php echo $prod_detail['less_discount']; ?>" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Wholesale Price
		?>
		<tr>
			<td class="common">
				<label class="form_label">Wholesale price</label> :
			</td>
			<td class="common">
				<input type="text" name="wholesale_price" class="inputbox" value="<?php echo $prod_detail['wholesale_price']; ?>" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Description
		?>
		<tr>
			<td class="common">
				<label class="form_label">Description</label> :
			</td>
			<td class="common">
				<textarea name="prod_desc" rows="3" cols="70"><?php echo $prod_detail['prod_desc']; ?></textarea>
			</td>
		</tr>
	</table>
	<br />
	
	<?php
	// -----------------------------------------
	// ---> SUBMIT
	?>
	<input type="button" name="cmd_cat_cancel" class="button" value="Cancel" onClick="back_display();" style="float:right;" />
	<input type="submit" name="cmd_cat_submit" class="button" value="Update" onClick="show_loder_gif();" style="float:right;width:100px;" />
	
</div> <!-- #content1 -->

<?php
// --------------------------------------------------------------------------
// ---> CONTENT 2
?>
<div id="content2" class="content">

	<ul class="view_tabs">
		<li class="selected"><a href="javascript: void();" onclick="select_me('content2')">Images, Colors, Facets, &amp; Others</a></li>
	</ul>

	<br />
	
	<table>
		<col width="400" />
		<col />
		
		<?php
		// -----------------------------------------
		// ---> Present image color/sizes/stocks:
		
		// for each color
		while ($prod_colors = mysql_fetch_array($prod_colors_qry))
		{ ?>
			<tr>
				<td class="text">
					<?php
					// referring the $img_url to product repositoy (commenting original referrence)
					if (SITE_DOMAIN == 'www.storybookknits.com')
						$img_url = IMG_REPO_URL.'product_assets/'.$prod_colors['c_folder'].'/'.$prod_colors['d_folder'].'/'.$prod_colors['sc_folder'].'/'.$prod_colors['ssc_folder'].'/';
					else
						$img_url = IMG_REPO_URL.'product_assets/'.$prod_colors['c_folder'].'/'.$prod_colors['d_folder'].'/'.$prod_colors['sc_folder'].'/';
					$color_name = trim($prod_colors['color_name']);
					
					// There is an error in color name when data at tbl_product is with trailing whitespaces
					// Circumventing it here
					if ($prod_colors['color_code'] == '')
					{
						$q_color_code = "SELECT color_code FROM tblcolor WHERE color_name = '".trim($color_name)."'";
						$r_color_code = mysql_query($q_color_code) or die('Select color error: '.mysql_error());
						$c_row = mysql_fetch_array($r_color_code);
						$color_code = $c_row['color_code'];
					}
					else $color_code = $prod_colors['color_code'];
					
					// set the image and video source
					$img_thumb 	     = $img_url.'product_front/thumbs/'.$prod_detail['prod_no'].'_'.$color_code.'_2.jpg';
					$img_thumb_back  = $img_url.'product_back/thumbs/'.$prod_detail['prod_no'].'_'.$color_code.'_2.jpg';
					$img_thumb_side  = $img_url.'product_side/thumbs/'.$prod_detail['prod_no'].'_'.$color_code.'_2.jpg';
					$video			 = $img_url.'product_video/'.$prod_detail['prod_no'].'_'.$color_code.'.flv';
					
					$imgchecked = $color_code == $prod_detail['primary_img_id'] ? 'checked="checked"' : '';
					
					// ---------------------------------------------------------------------------------
					// ---> Color Name [delete] [edit stock] [(un)publish]			<> Primary Image
					?>
					<table border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;background:#DDDDDD;">
						<tr>
							<td colspan="2" width="200">
								<?php
								if ($imgchecked != 'checked="checked"')
								{
									$java01 = "return confirm_del()";
								}
								else
								{
									$java01 = "return del_primary_alert()";
								}
								// -----------------------------------------
								// Color Name [delete] [edit stock] [publish]
								?>
								<strong><?php echo strtoupper($color_name); ?></strong>
								<br />
								[<a href="edit_product_details.php?act=del_stock&prod_no=<?php echo $prod_detail['prod_no']; ?>&color=<?php echo $prod_colors['color_name']; ?>&c=<?php echo $prod_detail['cat_id']; ?>&sc=<?php echo $prod_detail['subcat_id']; ?>&d=<?php echo $prod_detail['designer']; ?>" onclick="<?php echo $java01; ?>">delete</a>]
								[<a href="edit_stock.php?<?php echo $_SERVER['QUERY_STRING']?>&st_id=<?=$prod_colors['st_id']?>">edit stock</a>]
								[<a href="edit_product_details.php?act=color_pub&prod_no=<?php echo $prod_no; ?>&color=<?php echo $prod_colors['color_name']; ?>&pub=<?php echo $prod_colors['color_publish'] == 'Y' ? 'N' : 'Y'; ?>"><?php echo $prod_colors['color_publish'] == 'Y' ? 'unpublish' : 'publish'; ?></a>]
							</td>
							<td colspan="2" width="200">
								<?php
								// -----------------------------------------
								// <> Primary Image			[publish color mode notification]
								?>
								<input type="radio" name="primary_img_id" value="<?php echo $color_code; ?>" <?php echo $imgchecked; ?> /> Primary Image
								<br />
								<?php
								// Added publish color mode notification
								if ($prod_colors['color_publish'] == 'N')
								{ ?>
									&nbsp;<span style="color:red;">This color is NOT published.</span>
									<?php
								}
								else echo '&nbsp;'; ?>
							</td>
						</tr>
						<?php
						// -----------------------------------------
						// ---> Images area
						?>
						<tr height="110">
							<td width="70">
								<?php
								if ($img = @GetImageSize($img_thumb))
								{ ?>
									Front
									<br />
									<img src="<?php echo $img_thumb; ?>" width="63">
									<?php
								}
								else echo 'Front<br />Image';
								?>
							</td>
							<td width="70">
								<?php
								if ($img = @GetImageSize($img_thumb_back))
								{ ?>
									Back
									<br />
									<img src="<?php echo $img_thumb_back; ?>" width="63">
									<?php
								}
								else echo 'Back<br />Image';
								?>
							</td>
							<td width="70">
								<?php
								if ($img = @GetImageSize($img_thumb_side))
								{ ?>
									Side
									<br />
									<img src="<?php echo $img_thumb_side; ?>" width="63">
									<?php
								}
								else echo 'Side<br />Image';
								?>
							</td>
							<td width="70">
								<?php
								if ($img = @GetImageSize($video))
								{ ?>
									Video
									<br />
									<img src="<?php echo $video; ?>" width="63">
									<?php
								}
								else echo 'Video';
								?>
							</td>
						</tr>
						<?php
						// -----------------------------------------
						// ---> Size and stocks area
						?>
						<tr>
							<td colspan="4" style="font-size:10px;">
								<br />
								Size stock availability
								<table width="100%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;border:1px solid #999;">
									<tr style="background:#ddd;">
										<?php
										if ($prod_colors['cat_id'] != '19') // --> if not accessories
										{ 
											if (SITE_DOMAIN === 'www.storybookknits.com')
											{ 
												// Size in view differs but same at database - just cross reference them
												?>
												<td>Size XS</td>
												<td>Size S</td>
												<td>Size M</td>
												<td>Size L</td>
												<td>Size XL</td>
												<td>Size 1X</td>
												<td>Size 2X</td>
												<td>Size 3X</td>
												<td style="display:none;">Size 16</td>
												<?php
											}
											else
											{ ?>
												<td>Size 0</td>
												<td>Size 2</td>
												<td>Size 4</td>
												<td>Size 6</td>
												<td>Size 8</td>
												<td>Size 10</td>
												<td>Size 12 </td>
												<td>Size 14</td>
												<td>Size 16</td>
												<?php
											}
										}
										else
										{ ?>
											<td>Stock</td>
											<?php
										} ?>
									</tr>
									<tr>
										<?php
										if ($prod_colors['cat_id'] != '19')
										{ 
											if (SITE_DOMAIN === 'www.storybookknits.com')
											{ 
												// Size in view differs but same at database - just cross reference them
												?>
												<td style="font-weight:bold;"><?=$prod_colors['size_0']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_2']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_4']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_6']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_8']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_10']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_12']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_14']?></td>
												<td style="font-weight:bold;display:none;"><?=$prod_colors['size_16']?></td>
												<?php
											}
											else
											{ ?>
												<td style="font-weight:bold;"><?=$prod_colors['size_0']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_2']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_4']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_6']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_8']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_10']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_12']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_14']?></td>
												<td style="font-weight:bold;"><?=$prod_colors['size_16']?></td>
												<?php
											}
										}
										else
										{ ?>
											<td style="font-weight:bold;"><?=$prod_colors['size_0']?></td>
											<?php
										} ?>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="border:1px solid #ddd;">
								<?php
								/*
								| -----------------------------------------------------------------------
								| Availability Date
								| 
								| NOTES:
								| 1.0 present and past dates are open to sell
								| 2.0 future dates are for PRE-ORDER
								*/
								$exp_now = explode('/',@date('m/d/Y',time()));
								$time_now = @mktime(0,0,0,$exp_now[0],$exp_now[1],$exp_now[2]);
								if ($prod_colors['stock_date'] != '' && $prod_colors['stock_date'] != NULL)
									$time_db = @strtotime($prod_colors['stock_date']);
								else $time_db = '';
								if ($time_db > $time_now) $pre_order = TRUE;
								else $pre_order = '';
								?>
							
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr bgcolor="#eeeeee">
										<td align="right" class="text" style="padding:5px 0;">Available Date: </td>
										<td align="left" style="padding:5px 0;">
											<input name="color_stock_date[<?php echo strtolower(str_replace(' ','_',trim($prod_colors['color_name']))); ?>]" id="add_date_<?php echo strtolower(str_replace(' ','_',trim($prod_colors['color_name']))).$pre_order; ?>" class="date-pick" value="<?php echo $prod_colors['stock_date']; ?>" onblur="check_date_availability('add_date_<?php echo strtolower(str_replace(' ','_',trim($prod_colors['color_name']))).$pre_order; ?>')" />&nbsp;
											<span class="text">(format:mm/dd/yyyy)</span>
										</td>
										</tr>
											<?php
											if (isset($pre_order) && $pre_order == TRUE)
											{ ?>
												<tr bgcolor="#ddd">
													<td colspan="2" align="center" style="padding:5px 0;">
														<strong>This product is on Pre-Order</strong>
													</td>
												</tr>
												<?php
												unset($pre_order);
												} ?>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<?php
				// -----------------------------------------
				// ---> The color alliasing (facet) section on a per image color area
				?>
				<td class="text" style="background:white;padding: 0 0 60px 20px;">
					<div class="text"><b>COLORS FACET :</b></div>
					<?php
					$qry5 = get_colors_facets();
					if (mysql_num_rows($qry5) > 0)
					{
						while ($crow = mysql_fetch_array($qry5))
						{ ?>
							<div class="text" style="width:130px;float:left;">
								<?php
								$clr_name_1 = strlen($crow['color_name']) == 3 ? $crow['color_name'].'1' : $crow['color_name'];
								$checked = in_array(strtoupper($clr_name_1), explode('-', strtoupper($prod_colors['color_facets']))) ? 'checked="checked"' : '' ;
								?>
								<input type="checkbox" name="color_id1[<?php echo $prod_colors['color_name']; ?>][]" value="<?=$clr_name_1?>" <?php echo $checked; ?> /><?=$crow['color_name']?>
							</div>
							<?php
						} ?>
						<div style="clear:both;"></div>
						<?php
					}
					?>
				</td>
			</tr>
			<?php
		}
		/*
		| -----------------------------------------------------------------------
		| Faceting Area
		| -----------------------------------------------------------------------
		*/
		
		// -----------------------------------------
		// ---> The STYLES Facets
		?>
		<tr>
			<td colspan="2">
				<div class="text"><b>STYLES FACET :</b></div>
				<?php
				if (mysql_num_rows($qry6) > 0)
				{
					while ($crow5 = mysql_fetch_array($qry6))
					{ ?>
						<div class="text" style="width:130px;float:left;">
							<?php
							$style_name_1 = strlen($crow5['style_name']) == 3 ? $crow5['style_name'].'1' : $crow5['style_name'];
							if (stristr($prod_detail['styles'], $style_name_1) != '')
							{ ?>
								<input type="checkbox" name="style_id1[]" value="<?=$style_name_1?>" checked="checked" /> <?=$crow5['style_name']?>
								<?php
							}
							else
							{ ?>
								<input type="checkbox" name="style_id1[]" value="<?=$style_name_1?>"/> <?=$crow5['style_name']?>
								<?php
							} ?>
						</div>
						<?php
					} ?>
					<div style="clear:left;"></div>
					<?php
				} ?>
				<br />
			</td>
		</tr>
		
		<?php
		if (isset($cat) && $cat == '1' && $cat == 'this is temporarily not displayed')
		{
		// -----------------------------------------
		// ---> The EVENTS Facets (only for womens apparels)
		?>
			<tr>
				<td colspan="2">
					<div class="text"><b>EVENTS FACET:</b></div>
					<?php
					if (@mysql_num_rows($qry7) > 0)
					{
						while ($crow = @mysql_fetch_array($qry7))
						{ ?>
							<div class="text" style="width:130px;float:left;">
								<?php
								$event_name_1 = strlen($crow['event_name']) == 3 ? $crow['event_name'].'1' : $crow['event_name'];
								if (stristr($product_detail['events'],$event_name_1) != '')
								{ ?>
									<input type="checkbox" name="event_id1[]" value="<?=$event_name_1?>" checked="checked" /> <?=$crow['event_name']?>
									<?php
								}
								else
								{ ?>
									<input type="checkbox" name="event_id1[]" value="<?=$event_name_1?>" /> <?=$crow['event_name']?>
									<?php
								} ?>
							</div>
							<?php
						} ?>
						<div style="clear:left;"></div>
						<?php
					} ?>
					<br />
				</td>
			</tr>
			<?php
		}

		if (isset($cat) && $cat == '19')
		{
		// -----------------------------------------
		// ---> The MTERIALS Facets (only for accessories)
		?>
			<tr>
				<td colspan="2">
					<div class="text"><b>MATERIALS FACET:</b></div>
					<?php
					if (mysql_num_rows($qry8) > 0)
					{
						while ($crow = mysql_fetch_array($qry8))
						{ ?>
							<div class="text" style="width:130px;float:left;">
							<?php
							$material_name_1 = strlen($crow['material_name']) == 3 ? $crow['material_name'].'1' : $crow['material_name'];
							if (stristr($product_detail['materials'],$material_name_1) != '')
							{ ?>
								<input type="checkbox" name="material_id1[]" value="<?=$material_name_1?>" checked="checked" /> <?=$crow['material_name']?>
								<?php
							}
							else
							{ ?>
								<input type="checkbox" name="material_id1[]" value="<?=$material_name_1?>" /> <?=$crow['material_name']?>
								<?php
							} ?>
							</div>
							<?php
						} ?>
						<div style="clear:left;"></div>
						<?php
					} ?>
					<br />
				</td>
			</tr>
			
			<?php
			// -----------------------------------------
			// The TERNDS Facets (only for accessories)
			?>
			<tr>
				<td colspan="2">
					<div class="text"><b>TRENDS FACET:</b></div>
					<?php
					if (mysql_num_rows($qry9) > 0)
					{
						while ($crow = mysql_fetch_array($qry9))
						{ ?>
							<div class="text" style="width:130px;float:left;">
							<?php
							$trend_name_1 = strlen($crow['trend_name']) == 3 ? $crow['trend_name'].'1' : $crow['trend_name'];
							if (stristr($product_detail['trends'],$trend_name_1) != '')
							{ ?>
								<input type="checkbox" name="trend_id1[]" value="<?=$trend_name_1?>" checked="checked" /> <?=$crow['trend_name']?>
								<?php
							}
							else
							{ ?>
								<input type="checkbox" name="trend_id1[]" value="<?=$trend_name_1?>" /> <?=$crow['trend_name']?>
								<?php
							} ?>
							</div>
							<?php
						} ?>
						<div style="clear:left;"></div>
						<?php
					} ?>
					<br />
				</td>
			</tr>
			<?php
		} ?>
	</table>
	
	<?php
	// -----------------------------------------
	// ---> SUBMIT
	?>
	<input type="button" name="cmd_cat_cancel" class="button" value="Cancel" onClick="back_display();" style="float:right;" />
	<input type="submit" name="cmd_cat_submit" class="button" value="Update" onClick="show_loder_gif();" style="float:right;width:100px;" />
	
</div> <!-- #content2 -->

<?php
// --------------------------------------------------------------------------
// ---> CONTENT 3
?>
<div id="content3" class="content">

	<ul class="view_tabs">
		<li class="selected"><a href="javascript: void();" onclick="select_me('content2')">Upload Images &amp; Add Colors</a></li>
	</ul>

	<br />
	
	<table>
		<tr bgcolor="#eeeeee">
			<?php
			// -----------------------------------------
			// ---> Add Product Images (new or edit)
			if (SITE_DOMAIN == 'www.storybookknits.com')
				$upload_folder = 'product_assets/'.$prod_detail['c_folder'].'/'.$prod_detail['d_folder'].'/'.$prod_detail['sc_folder'].'/'.$prod_detail['ssc_folder'].'/';
			else
				$upload_folder = 'product_assets/'.$prod_detail['c_folder'].'/'.$prod_detail['d_folder'].'/'.$prod_detail['sc_folder'].'/';
			?>
			<td class="text" style="padding:10px;">
				<b>Add Product Images</b> for any of above current colors, or, for new colors<br />
				[ Skip if no need to add or edit product images/colors ]<br style="margin-bottom:15px;" />
				<table border="0" cellspacing="0" style="background:#ccc;border:1px solid #999999;">
					<col width="200" />
					<col />
					<tr>
						<td class="text" align="right" style="padding-right:20px;">Select color : </td>
						<td>
							<?php
							if (mysql_num_rows($qry4) > 0)
							{ ?>
								<select name="color_name" style="font-size:11px;"> <option value=""> - select color - </option>
								<?php
								while ($crow = @mysql_fetch_array($qry4))
								{ ?>
									<option value="<?=$crow['color_name']?>" ><?=$crow['color_name']?> - <?=$crow['color_code']?></option>
									<?php
								} ?>
								</select>
								<?php
							} ?>
							<input type="hidden" name="folder" value="<?php echo $upload_folder; ?>" />
						</td>
					</tr>
					<tr> 
						<td width="100" align="right" class="text" style="padding-right:20px;">Front Image : </td>
						<td align="left" class="error"><input type="file" name="front_<?=$prod_detail['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
					</tr>
					<tr>
						<td align="right" class="text" style="padding-right:20px;">Back Image : </td>
						<td align="left" class="error"><input type="file" name="back_<?=$prod_detail['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
					</tr>
					<tr> 
						<td align="right" class="text" style="padding-right:20px;">Side Image : </td>
						<td align="left" class="error"><input type="file" name="side_<?=$prod_detail['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
					</tr>
					<tr> 
						<td align="right" class="text" style="padding-right:20px;">Color Icon Image : </td>
						<td align="left" class="error"><input type="file" name="icon_<?=$prod_detail['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 40 px x 40 px</td>
					</tr>
					<tr> 
						<td align="right" class="text" style="padding-right:20px;">Runway Video : </td>
						<td align="left" class="error"><input type="file" name="video_<?=$prod_detail['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;video must be minimum 327 px x 589 px</td>
					</tr>
					<tr>
						<td class="text" align="right" style="padding-right:20px;">Stock : </td>
						<td>
                            <table width="100%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;border:1px solid #999;">
								<tr>
									<?php
									if ($prod_detail['cat_id'] != '19')
									{ ?>
										<td>Size 0</td>
										<td>Size 2</td>
										<td>Size 4</td>
										<td>Size 6</td>
										<td>Size 8</td>
										<td>Size 10</td>
										<td>Size 12 </td>
										<td>Size 14</td>
										<td>Size 16</td>										
										<?php
									}
									else
									{ ?>
										<td>Qty</td>
										<?php
									} ?>
								</tr>
								<tr>
									<?php
									if ($prod_detail['cat_id'] != '19')
									{ ?>
										<td><input type="text" name="size_0" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_2" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_4" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_6" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_8" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_10" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_12" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_14" style="width:30px;" maxlength="4" /></td>
										<td><input type="text" name="size_16" style="width:30px;" maxlength="4" /></td>
										<?php
									}
									else
									{ ?>
										<td><input type="text" name="size_0" style="width:30px;" maxlength="4" /></td>
										<?php
									} ?>
								</tr>
                            </table>
							</td></tr>
						</table>
					</td>
                </tr>
	</table>
		
	<?php
	// -----------------------------------------
	// ---> SUBMIT
	?>
	<input type="button" name="cmd_cat_cancel" class="button" value="Cancel" onClick="back_display();" style="float:right;" />
	<input type="submit" name="cmd_cat_submit" class="button" value="Update" onClick="show_loder_gif();" style="float:right;width:100px;" />
	
	<hr style="clear:both;border-width:1px 0 0 0;border-color:black;border-style:solid;" />
	
</div> <!-- #content3 -->

</form>
<!--eof form============================================================================-->
	
</div> <!-- #content_wrapper -->

<?php
// -----------------------------------------
// ---> Cancel button form action aided by javascript
// to circumvent the form and use only the following data to submit during cancel
?>
<div id="hidden_form" style="display:none;">
	<!--bof form============================================================================-->
	<form name="cancel_button_form" method="POST" action="list_products.php">
		<input type="hidden" name="filter_list_submit" value="GO" />
		<input type="hidden" name="des_id" value="<?php echo $prod_detail['designer']; ?>" />
		<input type="hidden" name="cat_id" value="<?php echo $prod_detail['cat_id']; ?>" />
		<input type="hidden" name="subcat_id" value="<?php echo $prod_detail['subcat_id']; ?>" />
		<input type="hidden" name="subsubcat_id" value="<?php echo $prod_detail['subsubcat_id']; ?>" />
	</form>
</div>	

	<?php
	/*
	| -------------------------------------------------
	| ---> Loader GIF image
	| used on as need basis
	| currently used by edit_product_details_view.php javascript of onclick function of submit button
	*/
	?>
	<div style="display:none" id="div_loader"></div>
	<div style="display:none" id="img_loader">
		<span>
			<img src="<?php echo SITE_URL; ?>images/loadingAnimation.gif" />
			<p>Processing request...</p>
			<p>In some cases, this may take several minutes. Please do not refresh page or close browser.</p>
		</span>
	</div>

