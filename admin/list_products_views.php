<?php
// -----------------------------------------
// ---> Set title description
$designer = isset($des_id) ? get_designer_name($des_id) : 'All Designers';
$subcategory = isset($subcat_id) ? get_subcat_name($subcat_id) : 'All Subcategories';
?>
<h2><?php echo MAIN_BODY_TITLE.' &nbsp; &nbsp; '; ?><span class="common" style="color:black;font-style:bold;"><?php echo $designer.' &raquo; '.$subcategory; ?></span></h1>

<div id="content_wrapper">

<?php if ($display === 'dd_menu') { ?>
	
	<!--bof form============================================================================-->
	<form name="prod_frm" method="post" action="<?php echo FILE_NAME_EXT; ?>?sel=reg" enctype="multipart/form-data" onsubmit="return check_required_fields();">
		
	<?php
	// --------------------------------------------------------------------------
	// ---> CONTENT 1
	?>
	<div id="content1" class="content">

		<ul class="view_tabs">
			<li class="selected"><a href="javascript: void();">Filter Product Search</a></li>
		</ul>

		<br />
		
		<table>
			<col width="200" />
			<col />
			
			<?php
			// -----------------------------------------
			// ---> Designer
			$url_pre = $_SERVER['SERVER_NAME'] === 'localhost' ? 'http://localhost/MyWeb/joetaveras/milan/' : 'http://'.$_SERVER['SERVER_NAME'].'/';
			?>
			<tr>
				<td class="common">
					<label class="form_label">Designer</label> :
				</td>
				<td class="common">
					<select id="designer" name="des_id" onchange="getCat('<?php echo $url_pre; ?>', 'admin/list_products_categories_option.php'); goSpin();">
						<option value="">All</option>
						<?php
						// used $qry1 variable
						if (mysql_num_rows($qry1) > 0)
						{
							while ($row1 = mysql_fetch_array($qry1))
							{ ?>
								<option value="<?php echo $row1['des_id']; ?>"><?php echo $row1['designer']; ?></option>
								<?php
							}
						} ?>
					</select>
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
					<div id="categories_option">
						<select id="cat" name="cat_id" onchange="getSubcat('<?php echo $url_pre; ?>', 'admin/list_products_subcategories_option.php'); goSpin();">
							<option value="">All</option>
							<?php
							if (mysql_num_rows($qry2) > 0)
							{
								while ($row2 = mysql_fetch_array($qry2))
								{
									if ($row2['cat_id'] != '23')
									{ ?>
										<option value="<?php echo $row2['cat_id']; ?>"><?php echo $row2['cat_name']; ?></option>
										<?php
									}
								}
							} ?>
						</select>
					</div>
				</td>
			</tr>
			<tr><td><br /></td><td></td></tr>
			<?php
			// -----------------------------------------
			// ---> Subcategory name
			if (SITE_DOMAIN == 'www.youdomain.com') // --> where subsubcat is needed
				$java = '
					onchange="getSubsubcat(\''.$url_pre.'\', \'admin/list_products_subsubcategories_option.php\'); goSpin();"
				';
			else $java = '';
			?>
			<tr>
				<td class="common">
					<label class="form_label">SubCategory name</label> :
				</td>
				<td class="common">
					<div id="subcategories_option">
						<select id="subcat" name="subcat_id" <?php echo $jave; ?>>
							<option value="">All</option>
							<?php
							if (mysql_num_rows($qry3) > 0)
							{
								while ($row3 = mysql_fetch_array($qry3))
								{ ?> 
									<option value="<?php echo $row3['subcat_id']; ?>"><?php echo $row3['subcat_name']; ?></option>
									<?php
								}
							} ?>
						</select>
					</div>
				</td>
			</tr>
			<tr><td><br /></td><td></td></tr>
			<?php
			// -----------------------------------------
			// ---> Subsubcategory name
			if (SITE_DOMAIN == 'www.yourdomain.com') // --> where subsubcat is needed
			{ ?>
				<tr>
					<td class="common">
						<label class="form_label">SubSubCategory name</label> :
					</td>
					<td class="common">
						<div id="subsubcategories_option">
							<select id="subsubcat" name="subsubcat_id">
								<option value="">All</option>
								<?php
								if (mysql_num_rows($qry5) > 0)
								{
									while ($row5 = mysql_fetch_array($qry5))
									{ ?> 
										<option value="<?php echo $row5['id']; ?>"><?php echo $row5['name']; ?></option>
										<?php
									}
								} ?>
							</select>
						</div>
					</td>
				</tr>
				<?php
			} ?>
		</table>
		<br />
		
		<?php
		// -----------------------------------------
		// ---> SUBMIT
		?>
		<input type="submit" name="filter_list_submit" class="button" value="GO >>" style="float:right;width:100px;" />
		
	</div> <!-- #content1 -->

	</form>
	<!--eof form============================================================================-->
	
<?php } else { ?>

	<div id="content2" class="content">
	
		<!--bof form============================================================================-->
		<form name="menu_tab_frm" method="post" action="">

			<input type="hidden" name="des_id" value="<?php echo $des_id; ?>" />
			<input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />
			<input type="hidden" name="subcat_id" value="<?php echo $subcat_id; ?>" />
			<input type="hidden" name="subsubcat_id" value="<?php echo $subsubcat_id; ?>" />
			
		<ul class="view_tabs">
			<?php
			if ($sel == 'clr')
			{
				$select_clearance = 'class="selected"';
				$select_regular_sale = '';
				$text1 = 'Show Regular Sale Products';
				$text2 = 'Products on Clearance';
			}
			else
			{
				$select_clearance = '';
				$select_regular_sale = 'class="selected"';
				$text1 = 'Regular Sale Products';
				$text2 = 'Show Products on Clearance';
			}
			?>
			<li <?php echo $select_regular_sale; ?>><a href="javascript: void();" onclick="select_me('reg')"><?php echo $text1; ?></a></li>
			<li <?php echo $select_clearance; ?>><a href="javascript: void();" onclick="select_me('clr')"><?php echo $text2; ?></a></li>
			<li><a href="javascript: void();" onclick="window.location.href='list_products.php'">Filter Product List</a></li>
		</ul>
		
		</form>
		<!--eof form============================================================================-->
		
		<!--bof form============================================================================-->
		<form name="prod_list_disp_frm" method="post" action="list_products.php?sel=<?php echo $sel; ?><?php echo isset($_GET['p']) ? '&p='.$_GET['p'] : ''; ?>">

			<input type="hidden" name="des_id" value="<?php echo $des_id; ?>" />
			<input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />
			<input type="hidden" name="subcat_id" value="<?php echo $subcat_id; ?>" />
			<input type="hidden" name="subsubcat_id" value="<?php echo $subsubcat_id; ?>" />
			
			<input type="submit" name="update_sequence" value="Update Sequence" style="margin-top: 10px;" />
			
			<br /><br />
			
			<div class="common" style="float:left;"><?php echo $items_total; ?> items total</div>
			<div class="common" style="float:right;">Number of entries per page: 100</a>
			</div>
			<div class="common" style="text-align:center;">
				<?php echo $pagination; ?>
			</div>
			<div style="clear:both;"></div>
			
			<table width="100%" border="0" cellspacing="2" cellpadding="0" style="margin: 10px 0;">
				<col width="70" />
				<col width="60" />
				<col width="120" />
				<col width="40" />
				<col width="75" />
				<col width="80" />
				<col width="80" />
				<col width="80" />
				<col />
				<col width="60" />
				<tr bgcolor="#CCCCCC" height="30">
					<?php
					// -----------------------------------------
					// ---> Headings
					?>
					<td align="center"><h1>Sequence</h1></td>
					<td align="center"><h1>Image</h1></td>
					<td align="center"><h1>Publish</h1></td>
					<td align="center"><h1>On<br />Sale</h1></td>
					<td align="center"><h1>Style#</h1></td>
					<td align="center"><h1>Category</h1></td>
					<td align="center"><h1>Sub<br />Category</h1></td>
					<td align="center"><h1>Designer</h1></td>
					<td align="center"><h1>Product Name</h1></td>
					<td align="center"><h1>Actions</h1></td>
				</tr>
				
				<?php
				$counter = 0;
				if (mysql_num_rows($qry5) > 0)
				{
					while ($prod_row = mysql_fetch_array($qry5))
					{
						$counter++; ?>
					<tr bgcolor="#eeeeee" onMouseOver="this.bgColor='#cccccc'" onMouseOut="this.bgColor='#eeeeee'" class="text">
					
						<!--1 Sequence-->
						<td align="center">
							<input type="text" size="3" maxlength="5" name='seq<?php echo $prod_row['prod_no']?>' id="seq<?php echo $prod_row['prod_no']?>" value="<?php echo $prod_row['seque']; ?>" />
						</td>
					
						<!--2 Image-->
						<td align="center" class="headtxt">
							<?php
							// referring the $img_url to product repositoy (commenting original referrence)
							//$base_site_url = SITE_URL;  // ----> Using defined SITE_URL at ../common.php
							
							if (SITE_DOMAIN == 'www.storybookknits.com')
								$img_url = 'product_assets/'.$prod_row['c_folder'].'/'.$prod_row['d_folder'].'/'.$prod_row['sc_folder'].'/'.$prod_row['ssc_folder'].'/';
							else
								$img_url = 'product_assets/'.$prod_row['c_folder'].'/'.$prod_row['d_folder'].'/'.$prod_row['sc_folder'].'/';
							$img_thumb = $img_url.'product_front/thumbs/'.$prod_row['prod_no'].'_'.$prod_row['primary_img_id'].'_2.jpg';
							$img_thumb_back = $img_url.'product_back/thumbs/'.$prod_row['prod_no'].'_'.$prod_row['primary_img_id'].'_2.jpg';
							$img_thumb_side = $img_url.'product_side/thumbs/'.$prod_row['prod_no'].'_'.$prod_row['primary_img_id'].'_2.jpg';

							// check images and set default logo where necessary
							/*
							$local_path = '../';
							$img = $_SERVER['SERVER_NAME'] === 'localhost' ? @GetImageSize($local_path.$img_thumb) : @GetImageSize($base_site_url.$img_thumb);
							$img2 = $_SERVER['SERVER_NAME'] === 'localhost' ? @GetImageSize($local_path.$img_thumb_back) : @GetImageSize($base_site_url.$img_thumb_back);
							$img3 = $_SERVER['SERVER_NAME'] === 'localhost' ? @GetImageSize($local_path.$img_thumb_side) : @GetImageSize($base_site_url.$img_thumb_side);
							if ($img) $thumb = $img_thumb;
							elseif ($img2) $thumb = $img_thumb_side;
							elseif ($img3) $thumb = $img_thumb_back;
							else $thumb = 'images/instylelnylogo_2.jpg';
							*/
							
							if (@GetImageSize(IMG_REPO_URL.$img_thumb)) $thumb = IMG_REPO_URL.$img_thumb;
							elseif (@GetImageSize(IMG_REPO_URL.$img_thumb_back)) $thumb = IMG_REPO_URL.$img_thumb_side;
							elseif (@GetImageSize(IMG_REPO_URL.$img_thumb_side)) $thumb = IMG_REPO_URL.$img_thumb_back;
							else $thumb = IMG_REPO_URL.'images/instylelnylogo_2.jpg';
							?>
							<img src="<?php echo $thumb; ?>" width="60">
						</td>
					
						<!--3 Publish-->
						<td id="row<?php echo $prod_row['prod_no']?>" style="text-align:left;padding-left:5px;">
							<?php
							if ($prod_row['view_status'] == 'Y') { $checked1 = 'checked="checked"'; $checked2 = 'checked="checked"'; }
							elseif ($prod_row['view_status'] == 'Y1') { $checked1 = 'checked="checked"'; $checked2 = ''; }
							elseif ($prod_row['view_status'] == 'Y2') { $checked1 = ''; $checked2 = 'checked="checked"'; }
							?>
							<input name="pub1<?php echo $prod_row['prod_no']?>" id="pub1<?php echo $prod_row['prod_no']?>" type='checkbox' value='Y' <?php echo $checked1; ?> onclick="javascript: _do('1<?php echo $prod_row['prod_no']?>', '<?php echo $page; ?>', '<?php echo $sel; ?>'); goSpin('row<?php echo $prod_row['prod_no']?>');" />at <?php echo ucfirst(SITE_SHORT_NAME); ?>
							<br />
							<input name="pub2<?php echo $prod_row['prod_no']?>" id="pub2<?php echo $prod_row['prod_no']?>" type='checkbox' value='Y' <?php echo $checked2; ?> onclick="javascript: _do('2<?php echo $prod_row['prod_no']?>', '<?php echo $page; ?>', '<?php echo $sel; ?>'); goSpin('row<?php echo $prod_row['prod_no']?>');" />at Designer

						</td>
						
						<!--4 On Sale-->
						<td align="center">
							<input name='skc<?php echo $prod_row['prod_id']?>' id="skc<?php echo $prod_row['prod_id']?>" type='checkbox' value='<?php echo $prod_row['hide_sketch']?>' onclick="javascript: _do_sketch('<?php echo $prod_row['prod_id']?>');" />
						</td>
						
						<!--5 Style#-->
						<td style="text-align:left;padding:2px;">
							<?php echo $prod_row['prod_no']; ?>
						</td>
						
						<!--6 Category-->
						<td style="text-align:left;padding:2px;">
							<?php echo $prod_row['cat_name']; ?>
						</td>
						
						<!--7 SubCategory-->
						<td style="text-align:left;padding:2px;">
							<?php echo $prod_row['subcat_name']; ?>
						</td>
						
						<!--8 Designer-->
						<td style="text-align:left;padding:2px;">
							<?php echo $prod_row['designer_name']; ?>
						</td>
						
						<!--9 Product Name-->
						<td style="text-align:left;padding:2px;">
							<?php echo $prod_row['prod_name']; ?>
						</td>
						
						<!--10 Actions-->
						<td style="text-align:left;padding-left:5px;">
							<?php
							$add_uri_string = isset($_GET['p']) ? '&sel='.$sel.'&p='.$_GET['p'] : '&sel='.$sel;
							?>
							<span class="text">[</span><a href="edit_product_details.php?prod_no=<? echo $prod_row['prod_no']; ?>" class="pagelinks">Edit</a><span class="text">]</span>
							<br />
							<span class="text">[</span><a href="edit_new_par_product.php?act=show&prod_no=<? echo $prod_row['prod_no'];?>&mode=d&cat_id=<?=$cat_id?>&subcat_id=<?=$subcat_id?>&des_id=<?=$des_id.$add_uri_string?>" class="pagelinks">Delete</a><span class="text">]</span>
						</td>
						
					</tr>
						<?php
					}
				}
				else
				{ ?>
					<tr bgcolor="#eeeeee" onMouseOver="this.bgColor='#cccccc'" onMouseOut="this.bgColor='#eeeeee'" class="text">
						<td colspan="10" align="center"><h3>No Products</h3></td>
					</tr>
					<?php
				}
				
				// free up mysql memory
				mysql_free_result($qry5);
				?>
				
			</table>
			
			<div class="common" style="float:left;"><?php echo $items_total; ?> items total</div>
			<div class="common" style="float:right;">Number of entries per page: 100 <a href="#">150</a> <a href="#">300</a> <a href="#">500</a> <a href="#">All</a></div>
			<div class="common" style="text-align:center;">
				<?php echo $pagination; ?>
			</div>
			<br style="clear:both;" />

			<input type="submit" name="update_sequence" value="Update Sequence" style="margin-top: 10px;" />
			
		</form>
		<!--eof form============================================================================-->
		
	</div>
	
<?php } ?>

</div> <!-- #content_wrapper -->

