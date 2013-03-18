<?php
	//$this->load->view('includes/original/common.php');
	$GLOBALS["message"]="";
	
	if (@$act == "logout")
	{ 
		unset($_SESSION['session_admin']);
	}

	if (@$action == "login")
	{
		if ($admin_id != "" || $admin_pwd != "")
		{
			$query = "select * from tbladmin where admin_name = '$admin_id' and admin_password = '$admin_pwd'";
			$result = mysql_query($query) or die("ERROR");
			$num_result = mysql_num_rows($result);

			if ($num_result > 0)
			{
			   session_start();
			   $SesId=session_id();
			   $admin_id=session_id();
			   $session_admin=$admin_id;
			   $_SESSION['session_admin'] = $session_admin;
			   header("Location:admin_home.php");
			   exit();
			}
			else
			{
			   $GLOBALS["message"]=$GLOBALS["message"]."Admin Id/Password is Invalid!!"."<br>";
			}
		}
		else
		{
			   $GLOBALS["message"]=$GLOBALS["message"]."Admin Id/Password cannot be Blank !!!"."<br>";
			   //echo $GLOBALS["message"];
		}
	}
?>
<html>
<head>

	<meta http-equiv="Content-Language" content="en-us">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	
	<title>Designer Area :: Admin Login</title>
	
	<link href="<?php echo css_url('admin/original/style.css'); ?>" rel="stylesheet" type=text/css>
	
</head>
<body bottommargin="0" leftmargin="0" topmargin="0"  rightmargin="0" onLoad="javascript:document.adminFrm.admin_id.focus();" >

<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table>

<table width="70%" border="0" cellspacing="1" cellpadding="1" align=center>

	<form name=adminFrm method=post action='admin/login'>
		<tr><td bgcolor="gray">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr><td colspan="2" rowspan=2 align="center"  bgcolor="gray">
					<h1>Alexa Starr Jewelry Administrator Login</h1>
				</td></tr>
				<tr><td bgcolor="#ffffff">
					<div align="center">
						<table border="0">
							<tr>
								<td colspan="2" align="center" > <br> </td>
							</tr>
							
							<?php
								if (isset($err_msg) && $err_msg != '')
								{ ?>
								
									<tr>
										<!--
										<td bgcolor="#FFFFFF" colspan=2 align=center class="error"><?php echo $GLOBALS["message"];?></td>
										-->
										<td bgcolor="#FFFFFF" colspan=2 align=center class="error"><?php echo $err_msg; ?></td>
									</tr>
									<tr>
										<td align=right colspan=2>&nbsp;</td>
									</tr>
									<?php
								} ?>
								
							<tr>
								<td class=text align=right>Admin:</td>
								<td>
									<input type="text" name="admin_id" class="inputbox" value="<? echo @$admin_id;?>">
								</td>
							</tr>
							<tr>
								<td class=text align=right>Password:</td>
								<td>
									<input type="password" name="admin_pwd" class="inputbox">
								</td>
							</tr>
							<tr>
								<td class=text align=right>&nbsp;</td>
								<td colspan="0" align="left">
									<input type="submit" name="sub" value="Login" class=button>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
						</table>
					</div>
				</td></tr>
			</table>
		</td></tr>
	</form>
	
</table>

</body>
</html>

<?php
// End of admin/index.php