<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 10px 10px;">
		<?php $this->load->view($this->config->slash_item('template').'page_left_menu'); ?>
	</td>
	<td>
		<div id="bodycontent">
			<?php if ( ! isset($page)): ?>
			
			<h3><?php echo strtoupper($page_title); ?></h3>
			<p><?php echo $page_text; ?></p>
			
			<?php else:
			
			$this->load->view($this->config->slash_item('template').$page);
			
			endif; ?>
		</div>
	</td>
</tr>
</table>
