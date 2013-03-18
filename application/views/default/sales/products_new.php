<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0px;">
	<tr>
		<?php
		/*
		| --------------------------------------------------------------------------------------
		| Left sidebar
		*/
		?>
		<td width="200" style="background:#F0F0F0;">
			<?php $this->load->view($this->config->slash_item('template').'sales/sidebar'); ?>
		</td>
		<?php
		/*
		| --------------------------------------------------------------------------------------
		| Right content area - spans two (2) rows
		*/
		?>
		<td rowspan="2" style="padding-left:5px;">
			<div style="color:red;margin:0 0 0 15px;font-size:1.1em;">
			add items to the package by going to each subcategory and checking items boxes to send a line sheet<br />your email address will receive a cc mail automatically for your records
			</div>
			<br />
			<?php $this->load->view($this->config->slash_item('template').'sales/'.$view_pane); ?>
		</td>
	</tr>
</table>

