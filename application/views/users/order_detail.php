<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 10px 10px;">
		<?php $this->load->view('users/left_menu'); ?>
	</td>
	<td>
	<div id="bodycontent">
	<h3>ORDER DETAIL</h3>
	<p>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" style="border:1px solid #999;">
			<tr>
				<td style="background:#999;color:#000;">Order ID</td>
				<td style="background:#999;color:#000;">Date Ordered</td>
				<td style="background:#999;color:#000;">Courier</td>
				<td style="background:#999;color:#000;">Shipping Fee</td>
				<td style="background:#999;color:#000;">Amount</td>
				<td style="background:#999;color:#000;">Status</td>
			</tr>
			<tr>
				<td><?php echo $log->order_log_id; ?></td>
				<td><?php echo $log->date_ordered; ?></td>
				<td><?php echo $log->courier; ?></td>
				<td><?php echo $log->shipping_fee; ?></td>
				<td><?php echo $log->amount; ?></td>
				<td><?php echo $log->is_confirmed == 0 ? 'In progress' : 'Completed'; ?></td>
			</tr>
		</table>
		<br>
		<strong>SHIPPING ADDRESS</strong>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" style="border:1px solid #999;">
			<tr>
				<td style="background:#999;color:#000;">Address</td>
			</tr>
			<tr>
				<td><?php echo $log->ship_address1; ?>, 
					<?php echo $log->ship_address2; ?>,
					<?php echo $log->ship_city; ?>,
					<?php echo $log->ship_state; ?>,
					<?php echo $log->ship_country; ?>,
					<?php echo $log->ship_zipcode; ?>
				</td>
			</tr>
		</table>
		<br><br>
		
		<strong>ITEMS ORDERED</strong>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" style="border:1px solid #999;">
		<?php
		if($orders->num_rows()>0) {
			?>
			<tr>
				<td style="background:#999;color:#000;">&nbsp; </td>
				<td style="background:#999;color:#000;">Product Number</td>
				<td style="background:#999;color:#000;">Product Name</td>
				<td style="background:#999;color:#000;">Color</td>
				<td style="background:#999;color:#000;">Size</td>
				<td style="background:#999;color:#000;">Designer</td>
				<td style="background:#999;color:#000;">QTY</td>
			</tr>
			<?php
			foreach($orders->result() as $order) {
			?>
			<tr>
				<td><img src="<?php echo base_url(); ?>res.php?w=60&h=90&constrain2=1&img=<?php echo $order->image; ?>"></td>
				<td><?php echo $order->prod_no; ?></td>
				<td><?php echo $order->prod_name; ?></td>
				<td><?php echo $order->color; ?></td>
				<td><?php echo $order->size; ?></td>
				<td><?php echo $order->designer; ?></td>
				<td><?php echo $order->qty; ?></td>
			</tr>
			<?php
			}
		} else {
			?> <tr><td>No order details return</td></tr> <?php
		}
		?>
		</table>
		<?php echo anchor('home','&laquo; Back'); ?>
	</p>	
	</div>
	</td>
</tr>
</table>