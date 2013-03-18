<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td>
	<table style="border: 1px solid #aaa;" cellspacing="0" cellpadding="0" width="100%">
            <tr>	
              <td width="100%" class="top" style="background:#F0F0F0;"><br /><br />
                  <table width="80%" cellpadding="0" cellspacing="0" align="center"=>
                    <tr>
					<tr>
					  <td class="table_title" style="background: #000000; color: #FFFFFF; font-size:24px; padding:5px 5px 5px 10px;"> RESET PASSWORD </td>
					</tr>
                      <td valign="middle">
					  	<?php if($control == 'reset') { ?>
						<?php echo form_open('register/process_reset_password'); ?>						
						<table width="100%" border="0" cellspacing="2" cellpadding="5" style="background:#ffffff;margin-top:12px;border: 1px solid #DDDDDD;">
						  <tr>
							<td colspan="3" style="font-size:16px;font-weight:bold; padding-left:10px;">
							<strong>ENTER EMAIL ADDRESS</strong>
							</td>
						  </tr>
						  
						  <tr>
							<td colspan="3" style="padding-left:10px;">
							Please enter your email address to retrieve <br/>your forgotten password. <!--You will receive a link to reset your password by email. --><br><br>
							If you do not receive your email please be sure<br/> to check your spam or junk folder or call 212.840.0846 <br>
							<?php echo $this->session->flashdata('flashMsg'); ?></td>
						  </tr>
						  <tr>
							<td width="12%" style="padding-left:10px;">Email address </td>
							<td width="60%"><input type="text" value="" name="email"  id="user_id" maxlength="35" size="35"  style="height:18px; width:250px; font-size:9px;"/></td>
							<td width="28%"><input type="submit" name="sub" value="Reset Password" class="bottonlook2" /></td>
						  </tr>
						  <tr>
						    <td style="padding-left:10px;">&nbsp;</td>
						    <td>&nbsp;</td>
						    <td>&nbsp;</td>
					      </tr>
						</table>
						<?php echo form_close(); ?>
					   <?php } else { ?>
					   <table width="100%" border="0" cellspacing="2" cellpadding="5" style="background:#ffffff;margin-top:12px;border: 1px solid #DDDDDD;">
						  <tr>
							<td colspan="3" style="font-size:16px;font-weight:bold; padding-left:10px;">
							<strong>PASSWORD CHANGED</strong>
							</td>
						  </tr>
						  
						  <tr>
							<td colspan="3" style="padding-left:10px;">
							Your password has been changed. <br><br><br><br><br><br>
							</td>
						  </tr>
						</table>
					   <?php } ?>
                    
                      </td>
                    </tr>
                  </table>  <br><br>
                
              </td>
            </tr>
          </table>
	</td>
</tr>
</table>

