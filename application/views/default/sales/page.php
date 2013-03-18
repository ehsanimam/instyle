<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="200" style="background:#f0f0f0;">
		<?php $this->load->view($this->config->slash_item('template').'sales/sidebar'); ?>
	</td>
	<td>
		<div id="bodycontent">
			<?php if ( ! isset($page)): ?>
			
			<h3><?php echo strtoupper($page_title); ?></h3>
			<p><?php echo $page_text; ?></p>
			
			<?php else:
			
			$this->load->view($this->config->slash_item('template').'sales/'.$page);
			
			endif; ?>
		</div>
	</td>
</tr>
</table>
