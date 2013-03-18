	<?php
	// -----------------------------------------
	// --> Error and prompt messages
	//if (isset($_SESSION['m']) && $_SESSION['m'] == 1)
	if (isset($_SESSION['m']))
	{
		switch ($_SESSION['m'])
		{
			case 1:
				$update_success = '<span class="error new_error">The record has been updated.</span>';
			break;
			
			case 2:
				$email_error = '<span class="error new_error">&lt;-- Invalid email address. No changes were made.</span>';
			break;
			
			case 3:
				$pword = '<span class="error new_error"><-- Password do not match.</span>';
			break;
		}
	}
	?>
	
	<h2 style="clear:both;"><?php echo MAIN_BODY_TITLE; ?></h1>
	
	<?php echo isset($update_success) ? $update_success : ''; ?>
	
	<br /><br />

	<!--bof form============================================================================-->
	<form name="frm_edit_sales_user" method="post" action="<?php echo FILE_NAME_EXT.'?'.$_SERVER['QUERY_STRING']; ?>" onsubmit="return check_form();">
	<table>
		<col width="200" />
		<col />
		
		<?php
		// -----------------------------------------
		// ---> First/User Name
		?>
		<tr>
			<td class="common">
				<label class="form_label">First Name</label> : <span class="error">*</span>
			</td>
			<td class="common">
				<input type="text" id="sa_user" name="sa_user" class="inputbox" value="<?php echo ucfirst($sel_user['admin_sales_user']); ?>" style="width: 300px;" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Last Name
		?>
		<tr>
			<td class="common">
				<label class="form_label">Last Name</label> : <span class="error">*</span>
			</td>
			<td class="common">
				<input type="text" id="sa_lname" name="sa_lname" class="inputbox" value="<?php echo ucfirst($sel_user['admin_sales_lname']); ?>" style="width: 300px;" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Email Address
		?>
		<tr>
			<td class="common">
				<label class="form_label">Email Address</label> : <span class="error">*</span>
			</td>
			<td class="common">
				<input type="text" id="sa_email" name="sa_email" class="inputbox" value="<?php echo $sel_user['admin_sales_email']; ?>" style="width: 300px;" />&nbsp; <?php echo isset($email_error) ? $email_error : ''; ?>
			</td>
		</tr>
		<tr><td><br /></td><td></td></tr>
		<?php
		// -----------------------------------------
		// ---> Password
		?>
		<tr>
			<td class="common">
				<label class="form_label">Password</label> :
			</td>
			<td class="common">
				<input type="password" id="sa_pword" name="sa_pword" class="inputbox" />&nbsp; <span class="error">&lt;-- Leave blank if you don't want to change passwords.</span>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Confirm Password
		?>
		<tr>
			<td class="common">
				<label class="form_label">Confirm Password</label> :
			</td>
			<td class="common">
				<input type="password" id="sa_pword2" name="sa_pword2" class="inputbox" />
			</td>
		</tr>
		
	</table>
	<br /><br />
	<?php
	// -----------------------------------------
	// ---> SUBMIT
	?>
	<input type="submit" name="submit" class="button" value="Update" style="cursor:pointer;margin:0;" />
	&nbsp;
	<input type="button" class="button" value="Return to list" style="cursor:pointer;margin:0;" onclick="return_to_list()" />
	
	</form>
	<!--eof form============================================================================-->
	
