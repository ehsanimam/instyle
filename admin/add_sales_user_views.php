	<?php
	// -----------------------------------------
	// --> Error and prompt messages
	//if (isset($_SESSION['m']) && $_SESSION['m'] == 1)
	if (isset($_SESSION['m']))
	{
		switch ($_SESSION['m'])
		{
			case 1:
				$email_error = '<span class="error new_error"><-- This email address already exists.</span>';
			break;
			
			case 2:
				$email_error = '<span class="error new_error"><-- Invalid email address.</span>';
			break;
			
			case 3:
				$pword = '<span class="error new_error"><-- Password do not match.</span>';
			break;
		}
	}
	?>
	
	<h2 style="clear:both;"><?php echo MAIN_BODY_TITLE; ?></h1>
	
	<span style="color:red; font-size:12px; font-style: italic; text-align:center;">NOTE: Please fill up all fields.</span>
	
	<br /><br />

	<!--bof form============================================================================-->
	<form name="frm_add_sales_user" method="post" action="<?php echo FILE_NAME_EXT; ?>" onsubmit="return check_form();">
	<table>
		<col width="200" />
		<col />
		
		<?php
		// -----------------------------------------
		// ---> First/User Name
		?>
		<tr>
			<td class="common">
				<label class="form_label">First Name</label> :
			</td>
			<td class="common">
				<input type="text" id="sa_user" name="sa_user" class="inputbox" value="<?php echo isset($_SESSION['sa_user']) ? $_SESSION['sa_user'] : ''; ?>" style="width: 300px;" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Last Name
		?>
		<tr>
			<td class="common">
				<label class="form_label">Last Name</label> :
			</td>
			<td class="common">
				<input type="text" id="sa_lname" name="sa_lname" class="inputbox" value="<?php echo isset($_SESSION['sa_lname']) ? $_SESSION['sa_lname'] : ''; ?>" style="width: 300px;" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Email Address
		?>
		<tr>
			<td class="common">
				<label class="form_label">Email Address</label> :
			</td>
			<td class="common">
				<input type="text" id="sa_email" name="sa_email" class="inputbox" value="<?php echo isset($_SESSION['sa_email']) ? $_SESSION['sa_email'] : ''; ?>" style="width: 300px;" />&nbsp; <?php echo isset($email_error) ? $email_error : ''; ?>
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
				<input type="password" id="sa_pword" name="sa_pword" class="inputbox" value="<?php echo isset($_SESSION['sa_pword']) ? $_SESSION['sa_pword'] : ''; ?>" />
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
				<input type="password" id="sa_pword2" name="sa_pword2" class="inputbox" value="<?php echo isset($_SESSION['sa_pword2']) ? $_SESSION['sa_pword2'] : ''; ?>" />&nbsp; <?php echo isset($pword) ? $pword : ''; ?>
			</td>
		</tr>
		
	</table>
	<br /><br />
	<?php
	// -----------------------------------------
	// ---> SUBMIT
	?>
	<input type="submit" name="submit" class="button" value="Add Sales User" style="cursor:pointer;margin:0;width:150px;" />
	
	</form>
	<!--eof form============================================================================-->
	
