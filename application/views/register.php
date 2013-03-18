<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 3px 10px;">
		<?php $this->load->view('page_left_menu'); ?>
	</td>
	<td>
		<div id="bodycontent">
			<h3>REGISTER FOR SPECIAL SALE</h3>
			<p>
			For substantial savings on fabulous dresses, gowns, tops and more, complete details in the form. 
			We will e-mail you as soon as promotions occur. 
			<hr>
			Note: These are in stock items not available in all sizes.
			<?php
			//echo form_open('register/process_register');
			echo form_open('registerforsale/process_send');
			?>
			<br>
			<?php echo $this->session->flashdata('flashRegMsg'); ?>
			<input type="hidden" name="control" value="register" />
			<?php $this->load->view('register_form_4'); ?>
			<?php echo form_close(); ?>
			</p>	
		</div>
	</td>
</tr>
</table>
