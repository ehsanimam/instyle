<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 10px 10px;">
		<?php $this->load->view('users/left_menu'); ?>
	</td>
	<td>
	<div id="bodycontent">
	<h3>ACTIVATION</h3>
	<p>
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border:0px solid #999;">
			<tr><td>
				Your account is not yet activated.
				<br />
				<br />
				To activate your account, please click the button below:
				<br />
				<br />
				<?php
				echo form_open('register/activation');
				echo form_hidden('email',$email);
				echo form_hidden('pword',$pword);
				echo form_hidden('control','signin');
				?>
				<input type="submit" value="Activate my account!" name="submit" />
				<?php echo form_close(); ?>
			</td></tr>
		</table>
	</p>	
	</div>
	</td>
</tr>
</table>
