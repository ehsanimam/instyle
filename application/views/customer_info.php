<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="410" style="padding:0px 14px 14px 0px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:15px 0;">
		<tr>
			<td style="padding:0px 14px 14px 0px;">
				<strong>CUSTOMER SHIPPING DETAILS</strong>
				<span style="font-size:9px;color:red;float: right;">Items marked with an asterisk (*) are required.</span>
				<div style="clear:both;"></div>
			</td>
		</tr>
		<tr>
			<td>
				<br />
				<!--bof form========================================================================-->
				<?php echo form_open('register/process_customer_info'); ?>
				<?php echo $this->session->flashdata('flashRegMsg'); ?>
					<input type="hidden" name="control" value="cart" />
					<?php $this->load->view('register_form'); ?>
				<?php echo form_close(); ?>
				<!--eof form========================================================================-->
			</td>
		</tr>
		</table>
	</td>
	<?php
	/*
	| ------------------------------------------------------------------------------------------
	| Order Details
	*/
	?>
	<td style="border-left:1px solid #aaa; padding:0px 14px 14px 20px;">
	
		<?php
		/*
		| ---------------------------------------------------------------------------------------
		| Title
		*/
		?>
		<div style="padding:15px 0px 20px;text-align:left;"> 
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td>
						<strong>ORDER SUMMARY</strong>
					</td>
				</tr>
			</table>
		</div>
		<?php
		/*
		| ---------------------------------------------------------------------------------------
		| Flash messages
		*/
		echo $this->session->flashdata('flashMsg');

		/*
		| ---------------------------------------------------------------------------------------
		| The Order Cart Table
		|
		*/
		?>
		<table cellpadding="0" cellspacing="1" style="width:100%" border="0">
		
			<?php
			// Headings
			?>
			<tr>
				<th width="53" class="cartHeading">Photo</th>
				<th width="53" class="cartHeading">Style#</th>
				<th width="155" class="cartHeading">Item Details</th>
				<th class="cartHeading">Color</th>
				<th width="20" class="cartHeading">Size</th>
				<th width="20" class="cartHeading">QTY</th>
				<th width="65" class="cartHeading" style="text-align:center">Item Price</th>
				<th width="60" class="cartHeading" style="text-align:center">Sub-Total</th>
			</tr>
		
			<?php $i = 1;
			/*
			| ---------------------------------------------------------------------------------------
			| The Cart Items
			*/
			foreach ($this->cart->contents() as $items):
				echo form_hidden($i.'[rowid]', $items['rowid']); ?>
				<tr>
					<td style="border-bottom:1px solid #efefef;"><img src="<?php echo base_url(); ?>res.php?w=60&h=90&constrain2=1&img=<?php echo $items['options']['prod_image']; ?>" alt = "Front" style="border:1px solid #333;" border="0"/></td>
					<td class="cartTd"><?php echo $items['options']['prod_no']; ?></td>
					<td class="cartTd">
						<?php echo $items['name']; ?><br />
					</td>
					<td class="cartTd"><?php echo $items['options']['color']; ?></td>
					<td class="cartTd" style="text-align:center;"><?php echo $items['options']['size']; ?></td>
					<td class="cartTd" style="text-align:center;"><?php echo $items['qty']; ?></td>
					<td style="text-align:right;" class="cartTd"><?php echo $this->cart->format_number($items['price']); ?></td>
					<td style="text-align:right;" class="cartTd"><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($items['subtotal']); ?></td>
				</tr>
				<?php $i++;
			endforeach;
			
			/*
			| ---------------------------------------------------------------------------------------
			| The Cost Summary
			*/
			?>
			<tr>
				<td colspan="7" style="padding: 5px;text-align: right;">Total</td>
				<td  style="padding: 5px;text-align: right;"><?php echo $this->config->item('currency').' '.$this->cart->format_number($this->cart->total()); ?></td>
			</tr>
			<tr>
				<td colspan="7" style="padding: 5px;text-align: right;">
					Shipping via <?php echo $this->session->userdata('shipping_courier'); ?>
				</td>
				<td  style="padding: 5px;text-align: right;">
					<?php echo $this->session->userdata('shipping_fee') ? $this->config->item('currency').' '.number_format($this->session->userdata('shipping_fee'),2) : 'T.B.A.'; ?>
				</td>
			</tr>
			<tr>
				<td colspan="7" style="padding: 5px;text-align: right;"><strong>Grand Total</strong></td>
				<td  style="padding: 5px;text-align: right;"><strong><?php echo $this->config->item('currency').' '.number_format(($this->cart->total() + $this->session->userdata('shipping_fee')),2); ?></strong></td>
			</tr>
			
		</table>
		
	</td>
</tr>
</table>