<!--
<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 3px 10px;">
		<?php //$this->load->view('page_left_menu'); ?>
	</td>
	<td>
		<div id="bodycontent">
-->
			<h3><?php echo strtoupper($page_title); ?></h3>
			<p>
				Register to receive our weekly newsletter with new arrivals and savings up to 60% on clearance items as well as eligibility for member rewards programs.
				<hr>
				<?php
				//echo form_open('register/process_register');
				echo form_open('register/process_customer_info');
				?>
				<br>
				<?php echo $this->session->flashdata('flashRegMsg'); ?>
				<input type="hidden" name="control" value="register" />
				<?php $this->load->view('register_form_2'); ?>
				<?php echo form_close(); ?>
			</p>
<!--
		</div>
	</td>
</tr>
</table>
-->