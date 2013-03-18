<!--
<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 3px 10px;">
		<?php //$this->load->view('page_left_menu'); ?>
	</td>
	<td>
	<div id="bodycontent">
-->
		<p>
			<span style="font-size:14px;font-weight:bold;">REGISTER FOR WHOLESALE PRICING INFO <span style="color:red;">(STORES ONLY)</span></span>
		</p>
		<p>
			<hr>
			Complete the form below and press submit. (Fields with * are mandatory.) Federal Tax ID required for USA only.
			<!--bof form=============================================================================-->
			<?php echo form_open('wholesale/register'); ?>
			<br />
			<?php echo $this->session->flashdata('flashRegMsg'); ?>
			<?php $this->load->view('register_form_3'); ?>
			<?php echo form_close(); ?>
			<!--eof form=============================================================================-->
		</p>
<!--
	</div>
	</td>
</tr>
</table>
-->