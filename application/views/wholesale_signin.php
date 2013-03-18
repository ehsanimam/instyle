<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr><td>

	<table style="border: 1px solid #aaa;" cellspacing="0" cellpadding="0" width="100%">
	<tr><td width="100%" class="top" style="background:#F0F0F0;">
	<br /><br />
	
		<table width="80%" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="table_title" style="background: #000000; color: #FFFFFF; font-size:24px; padding:5px 5px 5px 10px;"> SIGN IN <span style="font-family:'Arial Narrow';font-weight:normal;">TO PLACE WHOLESALE ORDERS (<span style="color:red;">RETAILERS ONLY</span>)</span></td>
			</tr>
			<tr>
				<td valign="middle">
				  
					<!--bof form===========================================================================-->
					<?php echo form_open('wholesale/authenticate'); ?>
					<table width="100%" border="0" cellspacing="2" cellpadding="5" style="background:#ffffff;margin-top:12px;border: 1px solid #DDDDDD;">
						<tr>
							<td colspan="3" style="font-size:16px;font-weight:bold; padding-left:10px;">
								<strong>WHOLESALE CUSTOMERS</strong>
							</td>
						</tr>
						<tr>
							<td colspan="3" style="padding-left:10px;">
								<span id="signin-note"><strong>If you have already registered with instylenewyork.com, then sign in here.</strong></span>
								<br>
								<span id="newsletter-note">Please note: if you have only subscribed to the weekly newsletter, you are not a registered user and need to register below. </span><?php echo $this->session->flashdata('flashMsg'); ?>
							</td>
						</tr>
						<tr>
							<td width="22%" style="padding-left:10px;">Enter your email </td>
							<td width="60%">
								<input type="text" value="" name="username"  id="user_id" maxlength="35" size="35"  style="height:18px; width:250px; font-size:9px;" />
							</td>
							<td width="18%">&nbsp;</td>
						</tr>
						<tr>
							<td style="padding-left:10px;">Enter your password </td>
							<td>
								<input type="password" name="password" id="user_pwd" maxlength="35" size="35" value="" style="height:18px; width:250px;" />
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
						    <td style="padding-left:10px;visibility:hidden;">Remember my password</td>
						    <td style="visibility:hidden;"><input type="checkbox" name="setcookie" value="1" /></td>
						    <td><input type="submit" name="sub" value="" class="bottonlook2" style="width:148px;height:23px;background:url(../images/signinnow.gif) no-repeat; border:0px; cursor:pointer;"/></td>
						</tr>
						<tr>
						    <td colspan="3" style="font-size:1px;">&nbsp;</td>
						</tr>
					</table>
					
					<input type="hidden" name="LoginForm_RegistrationDomain" maxlength="200" size="25" value="PoliformSpa-Common-Anonymous" class="inputfield_en"/>
					<?php echo form_close(); ?>
					<!--eof form===========================================================================-->
					
					<table width="100%" border="0" cellspacing="2" cellpadding="5" style="background:#ffffff;margin-top:12px;border: 1px solid #DDDDDD;">
						<tr>
							<td colspan="2" style="font-size:16px;font-weight:bold; padding-left:10px;"><strong>NOT REGISTERED FOR WHOLESALE ACCESS? THAT'S OK</strong></td>
						</tr>
						<tr>
						    <td style="padding-left:10px;">If you are new to <?$this->config->item('site_name'); ?>, please click 'Register now'. </td>
						    <td width="18%">
								<a href="<?php echo site_url('wholesale/register.html'); ?>"><img src="../images/registernow.gif" border="0" /></a>
							</td>
						</tr>
						<tr>
						    <td colspan="2" style="font-size:1px;">&nbsp;</td>
						</tr>
					</table>
					
					<table width="100%" border="0" cellspacing="2" cellpadding="5" style="background:#ffffff;margin-top:12px;border: 1px solid #DDDDDD;">
						<tr>
							<td colspan="2" style="font-size:16px;font-weight:bold; padding-left:10px;"><strong>FORGOTTEN YOUR PASSWORD?</strong></td>
						</tr>
						<tr>
						    <td style="padding-left:10px;">If you have forgotten your password, click 'recover password' and follow the instructions on the next page. </td>
						    <td width="18%">
								<a href="<?php echo site_url('wholesale/reset_password.html'); ?>" class="popupwindow"><img src="../images/changepassword.gif" border="0" /></a>
							</td>
						</tr>
						<tr>
						    <td colspan="2" style="font-size:1px;">&nbsp;</td>
						</tr>
					</table>
                    
				</td>
			</tr>
		</table>
				
				<br><br>
	</td></tr>
	</table>
	
</td></tr>
</table>
