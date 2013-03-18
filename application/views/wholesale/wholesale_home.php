<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 10px 10px;">
		<?php $this->load->view('wholesale/left_menu'); ?>
	</td>
	<td>
	<div id="bodycontent">
	<h3>ORDERS</h3>
	<p>
		<table border="0" cellspacing="0" cellpadding="3" width="100%" style="border:1px solid #999;">
		<?php
		if($orders->num_rows()>0) {
			?>
			<tr>
				<td style="background:#999;color:#000;">Order ID</td>
				<td style="background:#999;color:#000;">Date Ordered</td>
				<td style="background:#999;color:#000;">Courier</td>
				<td style="background:#999;color:#000;">Shipping Fee</td>
				<td style="background:#999;color:#000;">Amount</td>
				<td style="background:#999;color:#000;">Status</td>
			</tr>
			<?php
			foreach($orders->result() as $order) {
			?>
			<tr>
				<td><?php echo anchor('home/order_detail/'.$order->order_log_id,$order->order_log_id); ?></td>
				<td><?php echo $order->date_ordered; ?></td>
				<td><?php echo $order->courier; ?></td>
				<td><?php echo $order->shipping_fee; ?></td>
				<td><?php echo $order->amount; ?></td>
				<td><?php echo $order->is_confirmed == 0 ? 'In progress' : 'Completed'; ?></td>
			</tr>
			<?php
			}
		} else {
			?> <tr><td>No order(s) return</td></tr> <?php
		}
		?>
		</table>
	</p>	
	</div>
	</td>
</tr>
</table>
