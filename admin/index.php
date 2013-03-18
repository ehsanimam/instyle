<?php
include("../common.php");
$GLOBALS["message"]="";

if (isset($_SESSION['session_admin']) && $_SESSION['session_admin'] === session_id())
{
	header("Location:admin_home.php");
	exit;
}

if (@$action == "login")
{
	if ($admin_id != "" || $admin_pwd != "")
	{
    // prevent sql injection
    // mysql_real_escape_string - Escapes special characters in a string
    $admin_id = mysql_real_escape_string($admin_id);
    $admin_pwd = mysql_real_escape_string(md5($admin_pwd));
    
		$query = "select * from tbladmin where admin_name='$admin_id' and admin_password='$admin_pwd'";
		$result = mysql_query($query) or die("ERROR");
		$num_result = mysql_num_rows($result);
		
		if ($num_result > 0)
		{
			$_SESSION['session_admin'] = session_id();
			header("Location:admin_home.php");
			exit();
		}
		else
		{
			$GLOBALS["message"] = $GLOBALS["message"]."Admin Id/Password is Invalid!!"."<br>";
		}
	}
	else
	{
		$GLOBALS["message"] = $GLOBALS["message"]."Admin Id/Password cannot be Blank !!!"."<br>";
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link href="style.css" rel="stylesheet" type=text/css>
<title><?php echo SITE_NAME; ?> - Admin Panel</title>
	<link rel="icon" href="<?php echo SITE_URL; ?>favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="<?php echo SITE_URL; ?>favicon.ico" type="image/x-icon" /> 
</head>
<body bottommargin="0" leftmargin="0" topmargin="0"  rightmargin="0" onLoad="javascript:document.adminFrm.admin_id.focus();">
<table><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table>

<table width="70%" border="0" cellspacing="1" cellpadding="1" align=center>
<form name=adminFrm method=post action='index.php?action=login'>
  <tr>
    <td bgcolor="gray">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
								<td colspan="2" rowspan=2 align="center"  bgcolor="gray">
				  <h1><?php echo SITE_NAME; ?> - Administrator Login</h1>
				  </td>
							</tr>

		<tr>
          <td bgcolor="#ffffff"><div align="center">
              <table border="0">
                <tr>
                  <td colspan="2" align="center" > <br> </td>
                </tr>
                <?
                   if($GLOBALS["message"]!='')
                   { ?>
                    <tr>
                       <td bgcolor="#FFFFFF" colspan=2 align=center class="error"><? echo $GLOBALS["message"];?></td>
                    </tr>
                    <tr>
                       <td align=right colspan=2>&nbsp;</td>
                    </tr>
                <? } ?>
                <tr>
                  <td class=text align=right>Admin:</td>
                  <td><input type="text" name="admin_id" class="inputbox" value="<? echo @$admin_id;?>"></td>
                </tr>
                <tr>
                  <td class=text align=right>Password:</td>
                  <td><input type="password" name="admin_pwd" class="inputbox"></td>
                </tr>
                <tr>
                  <td class=text align=right>&nbsp;</td>
                  <td colspan="0" align="left">
                     <input type="submit" name="sub" value="Login" class=button>
                  </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
              </table>
            </div></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>
</body>
</html>
