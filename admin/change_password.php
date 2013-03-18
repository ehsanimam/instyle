<?php
	include("../common.php");
	include("security.php");

	if (isset($action) && $action == 'update')
	{
		if ($pass != '')
		{
			if ($pass == $c_pass)
			{
				$update_query = "UPDATE tbladmin SET admin_password = '".md5($pass)."' WHERE admin_name = 'admin'";
				mysql_query($update_query) or die('Admin pwd update error - '.mysql_error());
				$err = "Changed.";
				header('location:change_password.php?err='.$err);
			}
			else
			{
				$err = "Both the password should be same.";
			}
		}
		else
		{
			$err = "Please enter the password.";
		}
	}
	
	include 'top.php';
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center">
	
	<form name="pass_form" action="change_password.php?action=update" method="post">
<table width=70% border=1 bordercolor="cccccc" cellspacing=0 cellpadding=0>
<tr>
	<td>
		<table width=100% align=center cellspacing=2 cellpadding=2>
			<tr bgcolor="cccccc"><td align=center colspan=2><h1>Change Password</h1></td></tr>
			<tr><td align=center colspan=2><span class="error"><?=@$err;?></span></td></tr>
			<tr>
				<td class="text" align="right">New Password:&nbsp;</td>
				<td align="left"><input type="password" class="inputbox" name="pass"></td>
			</tr>
			<tr>
				<td class="text" align="right">Confirm Password:&nbsp;</td>
				<td align="left"><input type="password" class="inputbox" name="c_pass"></td>
			</tr>
			<tr><td></td><td><input type="submit" value="Submit" class="inputbox" name="Submit"> </td></tr>
		</table>
	</td>
</tr>
</table>
</form></td>
</tr>
</table>
<? include 'footer.php'; ?>