<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td>
	<br />
	Thank You : Your order number is <?php echo $order_log->order_log_id; ?> <br><br>

	Your order has been sent. <br>	
	A representative will be contacting you with confirmation of product availability, at that time we will process your payment information.
	<br /><br /><br />
	</td>
</tr>
<tr>
	<td>    
    Order Summary<br /> <br /> 
    </td>
</tr>
<tr>
<td>
	<div style="padding:5px 0px;font-size:13px;text-align:left;"> 
			<table border="0" cellspacing="0" cellpadding="0" width="100%"></table>
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
			foreach ($order_log_details->result() as $details):
			?>
				<tr>
					<td style="border-bottom:1px solid #999;width: 80px;"><a href="<?php ?>"><img src="<?php echo base_url(); ?>res.php?w=60&h=90&constrain2=1&img=<?php echo $details->image; ?>" width="60" height="90" border="0"></a></td>
					<td style="border-bottom:1px solid #999;"><?php echo $details->prod_no; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $details->prod_name; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $details->color; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $details->size; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $details->designer; ?></td>
					<td style="border-bottom:1px solid #999;"><?php echo $details->qty; ?></td>
					<td style="border-bottom:1px solid #999;" align="right"><?php echo $this->config->item('currency').$this->cart->format_number($details->unit_price); ?></td>
					<td style="border-bottom:1px solid #999;" align="right"><?php echo $this->config->item('currency').$this->cart->format_number($details->subtotal); ?></td>
				</tr>
			<?php
			$i++;
			endforeach;
			
			?>
			<tr><td colspan="9"><?php echo $this->session->flashdata('flashMsg'); ?></td></tr>
			<tr><td colspan="9"><!--Just a spacer--></td></tr>
			<tr>
				<td colspan="8" align="right">Total</td>
				<td align="right"><?php echo $this->cart->format_number($order_log->amount-$order_log->shipping_fee); ?></td>
			</tr>
			<tr>
				<td colspan="8" align="right">
					<?php
					if ( $order_log->ship_country == 'United States')
					{
						echo $order_log->courier;
					}
					else
					{
						echo '<span style="font-style:italic;color:red;">( International Orders Are Shipped Via DHL, Rates vary according to your country. You will be contacted by customer service with full details. )</span>';
					}
					?>
				</td>
				<td align="right"><?php echo $this->cart->format_number($order_log->shipping_fee); ?></td>
			</tr>
			<tr>
				<td colspan="8" align="right"><b>Grand Total:</b></td>
				<td align="right"><?php echo $this->config->item('currency').$this->cart->format_number($order_log->amount); ?></td>
			</tr>
			<tr><td colspan="8"></td></tr>
			<tr><td colspan="9" align="right"><br />Please check your email for an order confirmation<br /> 
            please email: info@instylenewyork.com if your have further questions. </td></tr>
		</table>
		<br>
	</td>
</tr>
<?php echo form_close(); ?>
<!--eof form=============================================================================-->
           
        </td>
</tr>

</table>
