<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="50%" style="padding:0px 14px 14px 0px;">
		<strong>NEW CUSTOMER SHIPPING DETAILS</strong>
		<span style="padding-left:17px;font-size:9px;color:red;">Items marked with an asterisk (*) are required.</span>
	</td>
	<td width="50%" style="border-left:1px solid #aaa; padding-left:20px;">
		<strong>EXISTING CUSTOMER</strong>
		<span style="padding-left:17px;font-size:9px;color:red;">Sign in if you are registered.</span>
	</td>
</tr>
<tr>
	<td>
	<strong>Register:</strong><br>
		<!--bof form========================================================================-->
		<?php echo form_open('register/process_register'); ?>
		<?php echo $this->session->flashdata('flashRegMsg'); ?>
			<input type="hidden" name="control" value="cart" />
			<?php $this->load->view('register_form'); ?>
		<?php echo form_close(); ?>
		<!--eof form========================================================================-->
	</td>
	<td style="border-left:1px solid #aaa; padding:0 0 0 20px;">
	<strong>Sign In:</strong><br /><br />
	<!--bof form========================================================================-->
	<?php echo form_open('signin/authenticate'); ?>
	<?php echo $this->session->flashdata('flashMsg'); ?>
	<input type="hidden" name="control" value="cart" />
	<table border="0" cellspacing="0" cellpadding="5" style="border:1px solid #aaa;">
			<tr>
				<td style="width:80px;">Email Address</td>
				<td><input type="text" class="inputbox" name="username" /></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" class="inputbox" name="password" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Signin" name="btnSignin" /></td>
			</tr>
	</table>
	<?php echo form_close(); ?>
	<!--bof form========================================================================-->
	</td>
</tr>

</table>