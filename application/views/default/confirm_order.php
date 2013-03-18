<!--bof form=============================================================================-->
<?php echo form_open('cart/submit_order'); ?>
<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr><td><?php echo $this->session->flashdata('flashMsg'); ?></td></tr>
<tr><td style="border-bottom:1px solid #eee;">
		<?php
		/*
		| -------------------------------------------------------------------------------------
		| PAYMENT DETAILS
		*/
		?>
		<div style="padding:5px 0px;font-size:13px;text-align:left;"> 
			<table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td>
				<strong>PAYMENT DETAILS</strong>
			</td></tr></table>
		</div>
		<table border="0" cellspacing="0" cellpadding="5" width="100%">
			<tr>
				<td colspan="2" bgcolor="#efefef">&nbsp;</td>
			</tr>
			<tr><td colspan="2" ></td></tr>
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="2">
						<col width="120" />
						<col />
						<tr>
							<td><label for="payment_card_type">Credit Card Type</label></td>
							<td>
								<select name="payment_card_type">
									<option value=""> - select card type - </option>
									<option value="MC">Master Card</option>
									<option value="VISA">Visa Card</option>
									<option value="DISCOVER">Discovery Card</option>
									<option value="AMEX">American Express Card</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="payment_card_num">Credit Card Number</label></td>
							<td><input type="text" class="inputbox" size="15" name="payment_card_num" /></td>
						</tr>
						<tr>
							<td><label for="payment_exp_date">Expiration</label></td>
							<td><input type="text" class="inputbox" name="payment_exp_date" /></td>
						</tr>
						<tr>
							<td><label for="payment_card_code">CCV</label></td>
							<td><input type="text" class="inputbox" size="4" name="payment_card_code" /></td>
						</tr>
						<tr>
							<td colspan="2"><span style="font-size: 10px;color: red;">&nbsp;</span></td>
						</td>
						<tr>
							<td><label for="payment_first_name">First Name</label></td>
							<td><input type="text" class="inputbox" size="15" name="payment_first_name" value="<?php echo (isset($cur_user_info->firstname)) ? $cur_user_info->firstname : ''; ?>" /></td>
						</tr>
						<tr>
							<td><label for="payment_last_name">Last Name</label></td>
							<td><input type="text" class="inputbox" size="14" name="payment_last_name" value="<?php echo (isset($cur_user_info->lastname)) ? $cur_user_info->lastname : ''; ?>" /></td>
						</tr>
						<tr>
							<td><label for="email">Email</label></td>
							<td><input type="text" class="inputbox" size="14" name="email" value="<?php echo (isset($cur_user_info->email)) ? $cur_user_info->email : ''; ?>" /></td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" cellspacing="0" cellpadding="2">
						<col width="120" />
						<col />
						<tr>
							<td><label for="payment_telephone">Telephone</label></td>
							<td><input type="text" class="inputbox" size="26" name="payment_telephone" value="<?php echo (isset($cur_user_info->telephone)) ? $cur_user_info->telephone : ''; ?>" /></td>
						</td>
						<tr>
							<?php
							if ($this->session->userdata('user_cat') == 'wholesale')
							{ ?>
								<td><label for="payment_storename">Store Name:</label></td>
								<td><input type="text" class="inputbox" size="26" name="payment_storename" value="<?php echo (isset($cur_user_info->store_name)) ? $cur_user_info->store_name : ''; ?>" /></td>
								<?php
							}
							else
							{ ?>
								<td colspan="2">&nbsp;</td>
								<?php
							} ?>
						</td>
						<tr>
							<td><label for="payment_address_1">Address 1</label></td>
							<td><input type="text" class="inputbox" size="26" name="payment_address_1" value="<?php echo (isset($cur_user_info->address1)) ? $cur_user_info->address1 : ''; ?>" /></td>
						</tr>
						<tr>
							<td><label for="payment_address_2">Address 2</label></td>
							<td><input type="text" class="inputbox" size="26" name="payment_address_2" value="<?php echo (isset($cur_user_info->address2)) ? $cur_user_info->address2 : ''; ?>" /></td>
						</tr>
						<tr>
							<td><label for="payment_city">City</label></td>
							<td><input type="text" class="inputbox" size="15" name="payment_city" value="<?php echo (isset($cur_user_info->city)) ? $cur_user_info->city : ''; ?>"/></td>
						</tr>
						<tr>
							<td><label for="payment_state">State</label></td>
							<td>
								<select name="payment_state[]">
									<option value=""> - select state - </option>
									<?php
									$get_states = $this->query_page->get_states();
									if ($get_states->num_rows() > 0)
									{
										foreach ($get_states->result() as $state)
										{
											if ($this->session->userdata('user_cat') == 'wholesale')
											{
												$sel_p_state = (isset($cur_user_info->state) && $state->state_name == $cur_user_info->state) ? 'selected="selected"' : '';
											}
											else
											{
												$sel_p_state = (isset($cur_user_info->state_province) && $state->state_name == $cur_user_info->state_province) ? 'selected="selected"' : '';
											} ?>
											<option value="<?php echo $state->state_name; ?>" <?php echo $sel_p_state; ?>><?php echo $state->state_name; ?></option>
											<?php
										}
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="payment_country">Country</label></td>
							<td>
								<select name="payment_country[]">
									<option value=""> - select country - </option>
									<?php
									$get_country = $this->query_page->get_country();
									if ($get_country->num_rows() > 0)
									{
										foreach ($get_country->result() as $country)
										{ ?>
											<option value="<?php echo $country->countries_name; ?>"<?php if (isset($cur_user_info->country) && $country->countries_name == $cur_user_info->country) echo ' selected="selected"'; ?>><?php echo $country->countries_name; ?></option>
											<?php
										}
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="payment_zip">Zip Code</label></td>
							<td>
								<?php
								if ($this->session->userdata('user_cat') == 'wholesale')
								{
									$p_zip_value = (isset($cur_user_info->zipcode)) ? $cur_user_info->zipcode : '';
								}
								else
								{
									$p_zip_value = (isset($cur_user_info->zip_postcode)) ? $cur_user_info->zip_postcode : '';
								}
								?>
								<input type="text" class="inputbox" size="9" name="payment_zip" value="<?php echo $p_zip_value; ?>" />
							</td>
						</tr>
					</table>
				</tr>
			</tr>
		</table>
		<br />
	</td>
</tr>
<tr>
	<td style="border-bottom:1px solid #eee;">
		<?php
		/*
		| -------------------------------------------------------------------------------------
		| SHIPPING DETAILS
		*/
		?>
		<div style="padding:5px 0px;font-size:13px;text-align:left;"> 
			<br />
			<table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td>
				<strong>SHIPPING ADDRESS</strong>
			</td></tr></table>
		</div>
		<table border="0" cellspacing="0" cellpadding="5" width="100%">
			<tr>
				<td bgcolor="#efefef">&nbsp;</td>
			</tr>
			<tr><td>
				<span style="font-size: 10px;color: red;font-style: italic;">(Please indicate if other than your billing address)</span>
			</td></tr>
			<tr><td>
				<table border="0" cellspacing="0" cellpadding="2">
					<col width="120" />
					<col />
					<tr>
						<td>Address 1 * </td>
						<td><input type="text" value="<?php echo (isset($cur_user_info->address1)) ? $cur_user_info->address1 : ''; ?>" class="inputbox" name="shipping_address1" /></td>
					</tr>
					<tr>
						<td>Address 2</td>
						<td><input type="text" value="<?php echo (isset($cur_user_info->address2)) ? $cur_user_info->address2 : ''; ?>" class="inputbox" name="shipping_address2" /></td>
					</tr>
					<tr>
						<td>City * </td>
						<td><input type="text" value="<?php echo (isset($cur_user_info->city)) ? $cur_user_info->city : ''; ?>" class="inputbox" name="shipping_city" /></td>
					</tr>
					<tr>
						<td>State * </td>
						<td>
							<select name="shipping_state">
								<option value=""> - select state - </option>
								<?php
								$get_states = $this->query_page->get_states();
								if ($get_states->num_rows() > 0)
								{
									foreach ($get_states->result() as $state)
									{
										if ($this->session->userdata('user_cat') == 'wholesale')
										{
											$sel_sh_state = (isset($cur_user_info->state) && $state->state_name == $cur_user_info->state) ? 'selected="selected"' : '';
										}
										else
										{
											$sel_sh_state = (isset($cur_user_info->state_province) && $state->state_name == $cur_user_info->state_province) ? 'selected="selected"' : '';
										} ?>
										<option value="<?php echo $state->state_name; ?>" <?php echo $sel_sh_state; ?>><?php echo $state->state_name; ?></option>
										<?php
									}
								} ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Country * </td>
						<td>
							<select name="shipping_country">
								<option value=""> - select country - </option>
								<?php
								$get_country = $this->query_page->get_country();
								if ($get_country->num_rows() > 0)
								{
									foreach ($get_country->result() as $country)
									{ ?>
										<option value="<?php echo $country->countries_name; ?>"<?php if (isset($cur_user_info->country) && $country->countries_name == $cur_user_info->country) echo ' selected="selected"'; ?>><?php echo $country->countries_name; ?></option>
										<?php
									}
								} ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<?php
							if ($this->session->userdata('user_cat') == 'wholesale')
							{
								$sh_zip_value = (isset($cur_user_info->zipcode)) ? $cur_user_info->zipcode : '';
							}
							else
							{
								$sh_zip_value = (isset($cur_user_info->zip_postcode)) ? $cur_user_info->zip_postcode : '';
							}
							?>
							Zip Code * </td><td><input type="text" value="<?php echo $sh_zip_value; ?>" class="inputbox" name="shipping_zipcode" />
							</td>
					</tr>
				</table>
			</td></tr>
		</table>
		<br />
	</td>
</tr>
<tr>
	<td>
		<?php
		/*
		| -------------------------------------------------------------------------------------
		| CART DETAILS
		*/
		?>
		<br />
		<div style="padding:5px 0px;font-size:13px;text-align:left;"> 
			<table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td>
				<strong>CONFIRM CHECKOUT</strong>
			</td></tr></table>
		</div>
	
		<table border="0" cellspacing="0" cellpadding="5" width="100%">
			<tr>
				<td bgcolor="#efefef">&nbsp;</td>
				<td bgcolor="#efefef"><b>Style Number</b></td>
				<td bgcolor="#efefef"><b>Product Name</b></td>
				<td bgcolor="#efefef"><b>Color</b></td>
				<td bgcolor="#efefef"><b>Size</b></td>
				<td bgcolor="#efefef"><b>Designer</b></td>
				<td bgcolor="#efefef"><b>QTY</b></td>
				<td bgcolor="#efefef" align="center"><b>Price</b></td>
				<td bgcolor="#efefef" align="center"><b>Subtotal</b></td>
			</tr>
			<?php 
			$i = 1; 
			foreach ($this->cart->contents() as $items):
				// ----> These hidden fields are current not used in the next process (was used for alexa payment process)
				echo form_hidden('item-'.$i.'_image',$items['options']['prod_image']);
				echo form_hidden('item-'.$i.'_prod_sku',$items['id']);
				echo form_hidden('item-'.$i.'_name',$items['name']);
				echo form_hidden('item-'.$i.'_color',$items['options']['color']);
				echo form_hidden('item-'.$i.'_size',$items['options']['size']);
				echo form_hidden('item-'.$i.'_designer',$items['options']['designer']);
				echo form_hidden('item-'.$i.'_qty',$items['qty']);
				echo form_hidden('item-'.$i.'_unit_price',$items['price']);
				?>			
				<tr>
					<td style="border-bottom:1px solid #999;width: 80px;"><a href="<?php echo $items['options']['current_url']; ?>"><img src="<?php echo base_url().$items['options']['prod_image']; ?>" width="60" height="90" border="0"></a></td>
					<td style="border-bottom:1px solid #999;"><?php echo $items['options']['prod_no']; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $items['name']; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $items['options']['color']; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $items['options']['size']; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $items['options']['designer']; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $items['qty']; ?></td>
					<td style="border-bottom:1px solid #999;" align="right"><?php echo $this->config->item('currency').$this->cart->format_number($items['price']); ?></td>
					<td style="border-bottom:1px solid #999;" align="right"><?php echo $this->config->item('currency').$this->cart->format_number($items['subtotal']); ?></td>
				</tr>
			<?php
			$i++;
			endforeach;
			echo form_hidden('item-'.$i.'_courier',$this->session->userdata('shipping_courier'));
			echo form_hidden('item-'.$i.'_shipping_fee',$this->session->userdata('shipping_fee'));
			echo form_hidden('item-'.$i.'_grand_total',$this->cart->total()+$this->session->userdata('shipping_fee'));
			?>
			<tr><td colspan="9"><?php echo $this->session->flashdata('flashMsg'); ?></td></tr>
			<tr><td colspan="9"><!--Just a spacer--></td></tr>
			<tr>
				<td colspan="8" align="right">Total</td>
				<td align="right"><?php echo $this->cart->format_number($this->cart->total()); ?></td>
			</tr>
			<tr>
				<td colspan="8" align="right">
					<?php
					if ($this->session->userdata('shipping_country') == 'United States')
					{
						echo $this->session->userdata('shipping_courier');
					}
					else
					{
						echo '<span style="font-style:italic;color:red;">( International Orders Are Shipped Via DHL, Rates vary according to your country. You will be contacted by customer service with full details. )</span>';
					}
					?>
				</td>
				<td align="right"><?php echo $this->cart->format_number($this->session->userdata('shipping_fee')); ?></td>
			</tr>
			<tr>
				<td colspan="8" align="right"><b>Grand Total:</b></td>
				<td align="right"><?php echo $this->config->item('currency').$this->cart->format_number($this->cart->total()+$this->session->userdata('shipping_fee')); ?></td>
			</tr>
			<tr><td colspan="9"><!--Just a spacer--></td></tr>
			<tr><td colspan="9"><!--Just a spacer--></td></tr>
			<?php if ($this->session->userdata('user_cat') === 'user')
			{ ?>
				<tr>
					<td colspan="8" align="right" style="padding-top:8px;">I agree to the <a id="return_policy_agree" href="javascript:void(0);"><u>Return Policy</u></a></td>
					<td align="right"><input type="radio" name="agree_to_return_policy" value="aye" /></td>
				</tr>
				<?php
			} ?>
			<tr><td colspan="9" align="right"><input type="image" src="<?php echo base_url(); ?>images/huc_checkout.gif" class="addtobag" style="margin:3px 0px;"/></td></tr>
		</table>
		<br>
</td></tr>
</table>
<?php echo form_close(); ?>
<!--eof form=============================================================================-->

<div id="dialog_return_policy_agree" title="RETURN POLICY" style="display:none;background:#FAFAD2;">
	<p>
	<?php
		// FAFAD2 is lightgoldenrodyellow
		if ($this->session->userdata('user_cat') == 'wholesale') $this->load->view('wholesale_return_policy');
		else $this->load->view('return_policy');
	?>
	</p>
</div>
