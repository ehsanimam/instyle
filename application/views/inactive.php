<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 10px 10px;">
		<?php $this->load->view('users/left_menu'); ?>
	</td>
	<td>
	<div id="bodycontent">
	<h3>INACTIVE STATE</h3>
	<p>
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border:0px solid #999;">
			<tr><td>
				Your account is in an inactive state.
				<br />
				<br />
				Please contact <?php echo safe_mailto($this->config->item('info_email'),$this->config->item('info_email')); ?> to reset your access rights.
				<br />
				<br />
				<?php echo br(3); ?>
			</td></tr>
		</table>
	</p>	
	</div>
	</td>
</tr>
</table>
