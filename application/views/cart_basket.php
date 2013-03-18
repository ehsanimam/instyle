<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
	<tr>
		<td>
			<?php
			/*
			| ---------------------------------------------------------------------------------------
			| My Shopping Bag Title and dropdown list
			*/
			?>
			<div style="padding:5px 0px 20px;font-size:13px;text-align:left;"> 
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td align="left">
							<strong>
								<?php
								if ($this->session->userdata('user_cat') == 'wholesale') echo 'WHOLESALE ORDER INQUIRY';
								else echo 'MY SHOPPING BAG';
								?>
							</strong>
						</td>
						
						<?php
						// ---------- (@2012-01-04-rey)
						// Display text and category dropdown list only on wholesale order inquiry process
						if ($this->session->userdata('user_cat') == 'wholesale')
						{ ?>
								<td align="right">
									<strong> Continue shopping </strong> 
									<select id="continue">
										<option value=""> - select category - </option>
										<!--<option value="<?php echo str_replace('https','http',site_url('new-arrival.html')); ?>">New Arrival</option>-->
										<option value="<?php echo str_replace('https','http',site_url('apparel-1.html')); ?>">Womens Apparel</option>
										<option value="<?php echo str_replace('https','http',site_url('jewelry-19.html')); ?>">Jewelry &amp; Accessories</option>
										<!--<option value="<?php echo str_replace('https','http',site_url('clearance-23.html')); ?>">Clearance</option>-->
									</select>
									<script>
										$(function(){
										// bind change event to select
											$('#continue').bind('change', function () {
												var url = $(this).val(); // get selected value
												if (url) { // require a URL
													window.location.href = url; // redirect
												}
												return false;
											});
										});
									</script>
								</td>
							
							</tr>
							<tr>
								<td colspan="2" align="center" style="padding-top:20px;color:gray;font-size:12px;">
									Minimun First Order 8 Units - You will be contacted by sales to complete this order.
								</td>
							<?php
						} ?>
					</tr>
				</table>
			</div>
			<?php
			/*
			| ---------------------------------------------------------------------------------------
			| Flash messages
			*/
			echo $this->session->flashdata('flashRegMsg');
			?>
			
			<?php
			/*
			| ---------------------------------------------------------------------------------------
			| The Cart Table
			|
			<!--bof form==========================================================================-->
			*/
			echo form_open('cart/update_cart'); ?>
			<table cellpadding="0" cellspacing="1" style="width:100%" border="0">
				<col width="80" />
				<col width="120" />
				<col />
				<col width="120" />
				<col width="60" />
				<col width="110" />
				<col width="120" />
				<col width="120" />
			
				<?php
				// Headings
				?>
				<tr>
					<th class="cartHeading">Photo</th>
					<th class="cartHeading">Style Number</th>
					<th class="cartHeading">Item Details</th>
					<th class="cartHeading">Color</th>
					<th class="cartHeading">Size</th>
					<th class="cartHeading">QTY</th>
					<th class="cartHeading">Item Price</th>
					<th class="cartHeading">Sub-Total</th>
				</tr>
			
			<?php $i = 1; ?>

			<?php
			/*
			| ---------------------------------------------------------------------------------------
			| The Cart Items
			*/
			foreach ($this->cart->contents() as $items):
				echo form_hidden($i.'[rowid]', $items['rowid']); ?>
				<tr>
					<td style="border-bottom:1px solid #efefef;"><img src="<?php echo base_url(); ?>res.php?w=60&h=90&constrain2=1&img=<?php echo $items['options']['prod_image']; ?>" alt = "Front" style="border:1px solid #333;" border="0"/></td>
					<td class="cartTd"><?php echo $items['options']['prod_no']; ?></td>
					<td class="cartTd"><?php echo $items['name']; ?></td>
					<td class="cartTd"><?php echo $items['options']['color']; ?></td>
					<td class="cartTd"><?php echo $items['options']['size']; ?></td>
					<td class="cartTd">
						<?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
					</td>
					<td style="text-align:right;" class="cartTd"><?php echo $this->cart->format_number($items['price']); ?></td>
					<td style="text-align:right;" class="cartTd"><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($items['subtotal']); ?></td>
				</tr>
				<?php $i++;
			endforeach; ?>
			
				<tr>
					<td colspan="5" style="padding: 5px;text-align: right;">&nbsp;</td> 
					<td style="padding: 5px;text-align: left;"><?php echo form_submit('', 'Update Qty'); ?> <br><br></td>
					<td style="padding: 5px;text-align: right;">Total</td>
					<td style="padding: 5px;text-align: right;"><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total()); ?></td>
				</tr>
				
			</table>
			
			<?php echo form_close(); ?>
			<!--eof form==========================================================================-->
			
			<!--bof form==========================================================================-->
			<?php
			/*
			| ---------------------------------------------------------------------------------------
			| Cart processing options
			| ---------------------------------------------------------------------------------------
			*/
			if ($this->session->userdata('user_cat') == 'wholesale')
			{
				echo form_open('cart/submit_order',array('id'=>'form_cart_basket'));
				$cur_user_info = $this->query_users->get_single_user_tbluser_wholesale($this->session->userdata('user_id'));
				$hidden_input = array(
					'payment_first_name' 	=> $cur_user_info->firstname,
					'payment_last_name' 	=> $cur_user_info->lastname,
					'email' 				=> $cur_user_info->email,
					'payment_telephone' 	=> $cur_user_info->telephone,
					'payment_store_name'	=> $cur_user_info->store_name,
					
					'payment_address1' 		=> $cur_user_info->address1,
					'payment_address2' 		=> $cur_user_info->address2,
					'payment_city' 			=> $cur_user_info->city,
					'payment_state' 		=> $cur_user_info->state,
					'payment_country' 		=> $cur_user_info->country,
					'payment_zip' 			=> $cur_user_info->zipcode,

					'shipping_address1' 	=> $cur_user_info->address1,
					'shipping_address2' 	=> $cur_user_info->address2,
					'shipping_city' 		=> $cur_user_info->city,
					'shipping_state' 		=> $cur_user_info->state,
					'shipping_country' 		=> $cur_user_info->country,
					'shipping_zipcode'		=> $cur_user_info->zipcode
				);
				echo form_hidden($hidden_input);
				
				$some_session_data = array(
					'shipping_courier'	=> '',
					'shipping_fee'		=> '',
					'shipping_id'		=> ''
				);
				$this->session->unset_userdata($some_session_data);
			}
			else echo form_open('cart/process_cart',array('id'=>'form_cart_basket'));
			
			/*
			| ---------------------------------------------------------------------------------------
			| The Shipping Method Details
			*/
			?>
			<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />
			<input type="hidden" name="ship_ship_country" id="ship_ship_country" />
			<table cellpadding="0" cellspacing="1" style="width:100%" border="0">
				<col />
				<col />
				<col />
				<col />
				<col />
				<col />
				<col />
				<col width="120" />
			
				<?php
				// ---------- (as of 2012-01-04-rey pahabol comment)
				// Check if wholesale or consumer
				// If wholesale, check country and set display already.
				// USA uses the radio buttons, Int'l uses the choose country option
				if ($this->session->userdata('user_cat') == 'wholesale')
				{
					if ($this->session->userdata('shipping_country') == 'United States')
					{
						// For USA Only
						$display_shpping_method = 'style="display: none;"';
						$display_country_options = 'style="display: none;"';
					}
					else
					{
						// For other than USA, no need to dispaly both
						$display_shpping_method = 'style="display: none;"';
						$display_country_options = 'style="display: none;"';
					}
				}
				else
				{
					// Display both for consumers
					$display_shpping_method = '';
					$display_country_options = '';
				}
				
				/*
				| ---------------------------------------------------------------------------------------
				| The Shipping Method Options for USA only
				*/
				?>
				<tr <?php echo $display_shpping_method; ?> id="label_ship">
					<td colspan="7" align="right">
						<strong>Select shipping method</strong> &nbsp;<span style="color:red;">( USA ONLY )</span>
					</td>
					<td>&nbsp;</td>
				</tr>
				
				<?php
				$get_shipmethod = $this->query_product->get_shipping_method();
				if ($get_shipmethod->num_rows() > 0)
				{
					$y = 0;
					foreach ($get_shipmethod->result() as $shipmethod)
					{
						//if ($this->session->userdata('shipping_id')) $shipping_id = $this->session->userdata('shipping_id');
						//else $shipping_id = ''; // --> default is no default
						$shipping_id = ''; // --> default is no default
						?>
						<tr <?php echo $display_shpping_method; ?> id="info_ship_<?php echo $y; ?>">
							<td colspan="7" align="right" style="padding-top: 2px;">
								<div id="text_ship">
									<?php echo $shipmethod->courier.' ('.$shipmethod->fee; ?>)
								</div>
							</td>
							<td align="left" style="padding-left:20px;">
								<div id="input_ship">
									<input type="radio" name="shipmethod" value="<?php echo $shipmethod->ship_id; ?>" <?php echo isset($shipping_id) && $shipping_id == $shipmethod->ship_id ? 'checked="checked"' : ''; ?> onclick="getFee('<?php echo base_url(); ?>cart/update_shipfee/<?php echo $shipmethod->ship_id; ?>')" />
								</div>
							</td>
						</tr>
						<?php
						$y++;
					}
				}
				
				/*
				| ---------------------------------------------------------------------------------------
				| Dropdown menu for countries other than USA
				*/
				?>
				<tr><td colspan="7"></td><td>&nbsp;</td></tr>
				<tr height="20" <?php echo $display_country_options; ?>>
					<td colspan="7" align="right" id="label_select_ship_country"><span style="color:red;">INTERNATIONAL: Choose country&nbsp;</span></td>
					<td>&nbsp;</td>
				</tr>
				<tr <?php echo $display_country_options; ?> id="input_select_ship_country">
					<td colspan="7" align="right">
						Country * &nbsp;
						<select id="select_ship_country" name="ship_country" onchange="remove_ship_options('<?php echo base_url(); ?>cart/remove_ship_options')">
						<option value=""> - select country - </option>
							<?php
							$get_country = $this->query_page->get_country();
							if ($get_country->num_rows() > 0)
							{
								foreach ($get_country->result() as $country)
								{
									if ($country->countries_name != 'United States')
									{
										if ($this->session->userdata('shipping_country')) $sel_country = $this->session->userdata('shipping_country');
										?>
										<option value="<?php echo $country->countries_name; ?>" <?php echo isset($sel_country) && $sel_country == $country->countries_name ? 'selected="selected"' : '' ; ?>><?php echo $country->countries_name; ?></option>
										<?php
									}
								}
							}
							?>
						</select>
					</td>
					<td>&nbsp;</td>
				</tr>
			
				<tr>
					<td colspan="6" class="cartTd">&nbsp;</td>
					<td align="right" class="cartTd"><br><strong>Grand Total</strong></td>
					<td align="right" class="cartTd"><br>
						<div id="shipdiv">
							<?php
							if ($this->session->userdata('shipping_country') == 'United States' OR $this->session->userdata('user_cat') != 'wholesale')
							{
								foreach ($get_shipmethod->result() as $shipmethod)
								{
									if (isset($shipping_id) && $shipmethod->ship_id == $shipping_id)
									{
										$shipping_courier = $shipmethod->courier;
										$shipping_fee = $shipmethod->fix_fee;
									}
									else
									{
										$shipping_id = '';
										$shipping_courier = '';
										$shipping_fee = 0;
									}
								}
							}
							else
							{
								$shipping_courier = '';
								$shipping_fee = 0;
							}
							?>
							<input type="hidden" name="ship_id" value="<?php echo $shipping_id; ?>" />
							<input type="hidden" name="ship_courier" value="<?php echo $shipping_courier; ?>" />
							<input type="hidden" name="ship_fee" value="<?php echo $shipping_fee; ?>" />
							<strong><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total() + $shipping_fee); ?></strong>
						</div>
					</td>
				</tr>
			
			</table>

			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Proceed to checkout button, Submit inquiry button
			*/
			
			// ---------- (2012-01-04-rey)
			// Choice of text and choice of button image for the go to checkout button if wholeslae or consumer
			if ($this->session->userdata('user_cat') == 'wholesale') $proceed_btn_image = 'images/btn_submit_inquiry.jpg';
			else $proceed_btn_image = 'images/huc-proceed_to_checkout.gif';
			?>
			<div align="right">
				<input type="image" src="<?php echo base_url().$proceed_btn_image; ?>" class="addtobag" style="margin:3px 0px 40px;" />
			</div>
			<?php echo form_close(); ?>
			<!--eof form==========================================================================-->
			
		</td>
	</tr>
	<?php
	/*
	| ------------------------------------------------------------------------------------------
	| Recommended items
	|
	| Temporarily removed even from normal user page until new accessory company is found
	|
	if ($this->session->userdata('user_cat') != 'wholesale')
	{ ?>
		<tr>
			<td>
				<div style="padding:5px 0px;font-size:13px;"><strong>Items you may want to add to your bag</strong></div>
				<?php echo $this->load->view('list_productscart',array('product'=>$get_products_oncart)); ?>
			</td>
		</tr>
		<?php
	}
	*/
	?>
</table>
