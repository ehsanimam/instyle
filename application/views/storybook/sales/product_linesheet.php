<?php
	if ($this->data['summary_view'] === 'summary')
	{ ?>
		<h3><?php echo strtoupper($page_title); ?> SUMMARY</h3>
		<br />
		<div align="left" style="font-size:14px;">CLICK ON IMAGE TO VIEW LINE SHEET</div>
		<br /><br />
		<div style="border:1px solid gray;padding:5px 10px;">
			<div style="width:350px;float:left;">
				<span style="float:left;position:relative;top:5px;">OPTIONS:</span>
				<span style="float:right;">Send with prices? <?php echo nbs(5); ?> <input type="radio" name="send_w_prices" value="Y" checked="checked" onclick="ungray_e_prices()" /> Yes <input type="radio" name="send_w_prices" value="N" onclick="gray_e_prices()" /> No</span>
				<br />
				<span id="span_e_prices" style="float:right;">Edit prices? <?php echo nbs(5); ?> <input type="radio" id="yes_e_prices" name="e_prices" value="Y" onclick="edit_prices()" /> Yes <input type="radio" id="no_e_prices" name="e_prices" value="N" checked="checked" onclick="unedit_prices()" /> No</span>
				<br style="clear:both;" />
			</div>
			<span style="float:right;position:relative;top:5px;">NOTES:<br />To deselect an item, simply untick the respective checkbox.</span>
			<br style="clear:both;" />
		</div>
		
		<!--bof form==================================================================================-->
		<form id="product_linesheet_summary" name="product_linesheet_summary" action="<?php echo site_url('sa/update_summary'); ?>" method="POST">
			<input type="hidden" id="is_edit_price" name="is_edit_price" value="N" />
		
		<?php
		if ($this->cart->total_items() != 0)
		{
			// --> smaller thumbs 2 columns multiple row view
			?>
			<br /><br />
			<div>
				<?php
				$ii = 1;
				$ii_thumb = 1;
				$btn_series = 0;
				foreach ($this->cart->contents() as $items)
				{
					echo form_hidden($ii.'[rowid]', $items['rowid']);
					
					if (fmod($ii_thumb, 2) == 1) $imarg = 'width:373px;margin-bottom:5px;float:left;';
					else $imarg = 'width:373px;margin-bottom:5px;float:right;';
					?>

					<div style="<?php echo $imarg; ?>">
					
						<?php
						// assign the primary images
						$img_url		= $items['options']['image_url'];
						$img_thumb 	    = $img_url.'product_front/thumbs/'.$items['id'].'_2.jpg';
						$img_thumb_back = $img_url.'product_back/thumbs/'.$items['id'].'_2.jpg';
						$img_thumb_side = $img_url.'product_side/thumbs/'.$items['id'].'_2.jpg';
						
						// check images and set default logo where necessary
						if (get_http_response_code(PROD_IMG_URL.$img_thumb) === '200')
						{
							$thumbnail = PROD_IMG_URL.$img_thumb;
							if (get_http_response_code(PROD_IMG_URL.$img_thumb_back) === '200')
							{
								$back = PROD_IMG_URL.$img_thumb_back;
							}
							else
							{
								if (get_http_response_code(PROD_IMG_URL.$img_thumb_side) === '200')
								{
									$back = PROD_IMG_URL.$img_thumb_side;
								}
								else
								{
									$back = PROD_IMG_URL.$img_thumb;
								}
							}
						}
						else
						{
							$thumbnail  = PROD_IMG_URL.'images/instylelnylogo_2.jpg';
							$back  		= PROD_IMG_URL.'images/instylelnylogo_2.jpg';
						}
						
						$alt = $items['name'];
						
						// The link for the product line sheet image
						$seg = $img_url.'product_linesheet/';
						
						/*
						| -------------------------------------------------------------------------------------------
						| The Thumbnail and details
						*/
						?>
						<!-- THUMBNAIL Div -->
						<div  style="height:90px;width:60px;margin-right:1px;float:left;">
							<div id="<?php echo $items['id']; ?>" class="fadehover">
							
								<?php
								/*
								| ---------------------------
								| Using fancybox to popup product line sheet image
								*/
								$href_text = base_url($seg.$items['id'].'.jpg');
								if (file_exists($seg.$items['id'].'.jpg'))
								{
									// with product line image
									$class_text = 'sa_thumbs_group';
									$java_01 = '';
								}
								else
								{
									// if no product line sheet image yet
									$class_text = '';
									$java_01 = 'onclick="alert(\'Product has no line sheet image yet.\');"';
								}
								?>
								<!--placeholder for product images with fadehover effect-->
								<a class="<?php echo $class_text; ?>" href="<?php echo $class_text != '' ? $href_text : 'javascript:void();' ; ?>" <?php echo $java_01; ?>>
									<img class="a" src="<?php echo $thumbnail; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
									<img class="b" src="<?php echo $back; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
								</a>
								
							</div>
						</div> <!-- End THUMBNAIL Div -->
						
						<!-- Details Div -->
						<div style="width:205px;height:85px;background-color:#dfdfdf;margin-right:1px;padding:5px 5px 0 5px;float:left;">
								<?php
								/*
								| -------------------------------------------------------------------------------------------
								| The Product No, Pricing, and Product Name
								*/
								?>
								<?php echo $items['options']['prod_no']; ?>
								<br />
								<br />
								<?php echo $items['name'].' ('.$items['options']['product_color'].')'; ?>
								
						</div> <!-- End Details Div -->
						
						<!-- Price Div -->
						<div id="price_div<?php echo $ii; ?>" style="width:53px;height:85px;background-color:#dfdfdf;margin-right:1px;padding:5px 5px 0 5px;float:left;">
							<?php
							// set price to $0 again if record indicates $1 else use actual record
							$price = $items['price'] == 1 ? number_format(0, 2) : number_format($items['price'], 2);
							echo '<div id="the_price_'.$ii.'"><span style="float:left;">'.$this->config->item('currency').'</span><span style="float:right;">'.$price.'</span></div>';
							?>
							<div id="edited_price_<?php echo $ii; ?>">
								<input type="hidden" id="cart_val_<?php echo $ii; ?>" name="cart_val_<?php echo $ii; ?>" value="<?php echo $items['options']['val']; ?>" />
								<input type="text" id="price_<?php echo $ii; ?>" name="price_<?php echo $ii; ?>" value="<?php echo $items['price']; ?>" size="5" style="float:right;text-align:right;display:none;" />
							</div>
						</div> <!-- End Price Div -->
						
						<!-- Selection Box Div -->
						<div style="height:88px;background-color:#dfdfdf;padding:2px 6px 0 5px;float:left;">
							<input type="hidden" id="<?php echo $ii.'[qty]'; ?>" name="<?php echo $ii.'[qty]'; ?>" value="<?php echo $items['qty']; ?>" />
							<input type="checkbox" name="package_item[]" id="<?php echo $ii.'package_item'; ?>" value="<?php echo $items['qty']; ?>" style="float:right;" checked="checked" onclick="update_form('<?php echo $ii.'[qty]'; ?>')" />
							<!--
							<br /><br />
							<img src="<?php echo base_url().'images/question-mark-20.png'; ?>" alt="" width="12" height="12" style="position:relative;left:4px;top:5px;" />
							-->
						</div> <!-- End Selection Box Div -->
						
					</div>
					
					<?php
					// set count for div id for javascript to work
					if (fmod($ii, 6) == 0)
					{
						$btn_series = $ii / 6;
						?>
					
						<!-- Series of Update Price Button -->
						<div id="upd_price_btn_<?php echo $btn_series; ?>" style="padding:15px 0;clear:both;display:none;">
							<input type="button" name="upd_price_btn" value="Update Prices Before Submitting" style="position:relative;left:265px;" onclick="update_form()" />
						</div>
					
						<?php
					}
					
					// increase count and set thumb variable used for floating left or right
					if ($ii_thumb < 2) $ii_thumb++;
					else
					{
						$ii_thumb = 1;
					}
					$ii++;
				} ?>
	
				<div style="clear:both;"></div>
				
				<!-- LAST Update Price Button -->
				<?php $btn_series++; ?>
				<div id="upd_price_btn_<?php echo $btn_series; ?>" style="padding:15px 0;display:none;">
					<input type="button" name="upd_price_btn" value="Update Prices Before Submitting" style="position:relative;left:265px;" onclick="update_form()" />
				</div>
				
			</div>
			
			<?php // commenting this old view layout
			/*
			$i = 1;
			$i_thumb = 1;
			foreach ($this->cart->contents() as $items):
			
				echo form_hidden($i.'[rowid]', $items['rowid']);
				
				// --> original thumbs view summary style
				// this is just to remove margin of the left most thumb
				if (fmod($i_thumb, 5) == 1) $marg = 'margin:2px 0px 15px 0px;';
				else $marg = 'margin:2px 0px 15px 13px;';
				?>
				
				<div style="width:141px;float:left;<?php echo $marg; ?>">
				<div>
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr><td colspan="2" style="height:210px;">
					
							<?php
							// assign the primary images
							$img_url		= $items['options']['image_url'];
							$img_thumb 	    = $img_url.'product_front/thumbs/'.$items['id'].'_1.jpg';
							$img_thumb_back = $img_url.'product_back/thumbs/'.$items['id'].'_1.jpg';
							$img_thumb_side = $img_url.'product_side/thumbs/'.$items['id'].'_1.jpg';
							
							// check images and set default logo where necessary
							$local_path = 'D:\www\joetaveras\instylenewyork\httpdocs\\';
							$img = ENVIRONMENT == 'development' ? @GetImageSize($local_path.$img_thumb) : @GetImageSize(PROD_IMG_URL.$img_thumb);
							$img2 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.$img_thumb_back) : @GetImageSize(PROD_IMG_URL.$img_thumb_back);
							$img3 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.$img_thumb_side) : @GetImageSize(PROD_IMG_URL.$img_thumb_side);
							if ($img)
							{
								$thumbnail = PROD_IMG_URL.$img_thumb;
								if ($img2)
								{
									$back = PROD_IMG_URL.$img_thumb_back;
								}
								else
								{
									if ($img3)
									{
										$back = PROD_IMG_URL.$img_thumb_side;
									}
									else
									{
										$back = PROD_IMG_URL.$img_thumb;
									}
								}
							}
							else
							{
								$thumbnail  = PROD_IMG_URL.'images/instylelnylogo_1.jpg';
								$back  		= PROD_IMG_URL.'images/instylelnylogo_1.jpg';
							}
							
							$alt = $items['name'];
							
							// The link for the product line sheet image
							$seg = $img_url.'product_linesheet/';
							
							/*
							| -------------------------------------------------------------------------------------------
							| The Thumbnail
							*/
							/*?>
							<div id="<?php echo $items['id']; ?>" class="fadehover" style="width:140px;height:210px;">
							
								<?php
								/*
								| ---------------------------
								| Using fancybox to popup product line sheet image
								//
								$href_text = base_url($seg.$items['id'].'.jpg');
								if (file_exists($seg.$items['id'].'.jpg'))
								{
									// with product line image
									$class_text = 'sa_thumbs_group';
									$java_01 = '';
								}
								else
								{
									// if no product line sheet image yet
									$class_text = '';
									$java_01 = 'onclick="alert(\'Product has no line sheet image yet.\');"';
								}
								?>
								<!--placeholder for product images with fadehover effect-->
								<a class="<?php echo $class_text; ?>" href="<?php echo $class_text != '' ? $href_text : 'javascript:void();' ; ?>" style="z-index:10;" <?php echo $java_01; ?>>
									<img class="a" src="<?php echo $thumbnail; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
									<img class="b" src="<?php echo $back; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
								</a>
								
							</div>
							
						</td></tr>
						<tr><td colspan="2">
							<?php
							/*
							| ---------------------------
							| The selection check box
							*/
							/*?>
							<input type="hidden" id="<?php echo $i.'[qty]'; ?>" name="<?php echo $i.'[qty]'; ?>" value="<?php echo $items['qty']; ?>" />
							<span style="color:red;">Deselect To Remove</span> <input type="checkbox" name="package_item[]" id="" value="<?php echo $items['qty']; ?>" style="float:right;" checked="checked" onclick="update_form('<?php echo $i.'[qty]'; ?>')" />
						</td></tr>
						<tr>
							<?php
							/*
							| -------------------------------------------------------------------------------------------
							| The Product No, Pricing, and Product Name
							*/
							/*?>
							<td width="50%" style="text-align:left;">
								<span style="font-size:10px;"><?php echo $items['options']['prod_no']; ?></span>
							</td>
							<td width="50%" style="text-align:right;">
								<span style="font-size:10px;">
									<?php
									// set price to $0 again if record indicates $1 else use actual record
									$price = $items['price'] == 1 ? number_format(0, 2) : number_format($items['price'], 2);
									echo $this->config->item('currency').$price;
									?>
								</span>
							</td>
						</tr>
						<tr><td colspan="2"><?php echo $items['name'].'<br />('.$items['options']['product_color'].')'; ?></td></tr>
					</table>
					
				</div>
				</div>
				
				<?php
				if ($i_thumb < 5) $i_thumb++;
				else
				{
					$i_thumb = 1;
					echo '<div style="clear:both;">&nbsp;</div>';
				}
				$i++;
			endforeach;
			*/
			echo '<div style="clear:both;">&nbsp;</div>';
		}
		else echo '<br />Please select items again.';
		?>
		
		</form>
		<!--eof form==================================================================================-->
		<?php
	}
	elseif ($this->data['summary_view'] === 'sent')
	{ ?>
		<h3><?php echo strtoupper($page_title); ?> SUMMARY</h3>
			<br />
			<br />
			<br />
			<div align="left" style="font-size:14px;color:red;"><u>PRODUCT LINE SHEET SENT</u></div>
			<br />
			<br />
			Please select items again.
			<br />
			<input type="button" class="search_head submit" name="add_more_items" value="SELECT NEW ITEMS" style="width:175px;text-align:center;" onclick="window.location.href='<?php echo site_url('sa/apparel'); ?>';" />
		<?php
	}
	elseif ($this->data['summary_view'] === 'multi_search')
	{ ?>
		<h3><?php echo strtoupper($page_title); ?></h3>
			<br />
			<br />
			<br />
			<div align="left" style="font-size:14px;color:red;"><u>SEARCH MULTIPLE ITEMS</u></div>
			<br />
			<br />
			Please enter one STYLE NUMBER per box for as many as 40 items only. <span style="color:red;font-style:italic;">(Sylte Numbers only please.)</span>
			<br /><br />
			<!--bof form==========================================================================-->
			<form action="<?php echo site_url('sa/search_multi_products'); ?>" method="POST">
			
				<input type="hidden" name="search" value="TRUE" />
				
				&nbsp; 1. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp; &nbsp;
				2. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				&nbsp; 3. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				&nbsp; 4. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				&nbsp; 5. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp; &nbsp;
				6. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				&nbsp; 7. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				&nbsp; 8. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				&nbsp; 9. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				10. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				11. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				12. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				13. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				14. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				15. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				16. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				17. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				18. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				19. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				20. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				21. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				22. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				23. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				24. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				25. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				26. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				27. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				28. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				29. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				30. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				31. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				32. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				33. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				34. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				35. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				36. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				37. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				38. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				39. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				40. <input type="text" name="style_ary[]" style="height:22px;background-color:white;color:black;font-size:12px;margin:3px 0;border:1px solid gray;" /> &nbsp; &nbsp;
				<br />
				<br />
				<input type="submit" class="search_head submit" name="multi_items" value="SEARCH ITEMS" style="width:175px;text-align:center;cursor:pointer;" />
				
			</form>
			<!--eof form==========================================================================-->
		<?php
	}
	elseif ($this->data['summary_view'] === 'empty_cart')
	{ ?>
		<h3><?php echo strtoupper($page_title); ?> SUMMARY</h3>
			<br />
			<br />
			<br />
			<div align="left" style="font-size:14px;">ITEMS CLEARED.</div>
			<br />
			<br />
			Please select items again.
			<br />
			<input type="button" class="search_head submit" name="add_more_items" value="SELECT NEW ITEMS" style="width:175px;text-align:center;" onclick="window.location.href='<?php echo site_url('sa/apparel'); ?>';" />
		<?php
	}
	
	/*
	| ----------------------------------------
	| A quick function to get the 3-digit HTTP response code
	| Taken from http://www.php.net/manual/en/function.get-headers.php#97684
	| Works to check for files in order servers
	*/
	function get_http_response_code($theURL)
	{
		$headers = @get_headers($theURL);
		return substr($headers[0], 9, 3);
	}
