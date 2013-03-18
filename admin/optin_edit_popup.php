<?
session_start();
include("../common.php");
include('../functionsadmin.php');
if($action=='edit')
{
		 $update_query="update tblemail_subscribe set 
		 email_addr='$email_addr' 
          where email_id='$eid'";

  mysql_query($update_query);

print "<script>opener.location.href='opt_in_list.php';window.close();</script>";
 
}  

$select="select * from tblemail_subscribe where email_id='$eid'";

$result=mysql_query($select);
$row=mysql_fetch_array($result);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Instyle New York::Admin</title>
<link href='style.css' rel='stylesheet' type='text/css'>
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
function _check(){
	if(isEmpty('optinlist','email_addr','Email')==false){
		return false;
	}
	
	if(isEmail('optinlist','email_addr','Email')==false){
		return false;
	}
	
}

</script>
</head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td >
                    <!-----start-----------//-->
                    <form name="optinlist" action="optin_edit_popup.php?eid=<?=$eid;?>&action=edit" method="post" onSubmit="javascript:return _check();">
                    <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <input type="hidden" name=eid value="<?=$eid;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                <tr bgcolor=cccccc> 
                  <td align=center colspan=2><b> <font size=2 color="#000000" face="verdana,Arial">Edit 
                    Email </font></td>
                </tr>
                <tr> 
					<? if(!empty($err)){ ?>
                  <td align=center colspan=2><font size=1 face=verdana color=red> 
                    <?=$err;?>
                    </font></td>
					<? } ?>
                </tr>
           		<tr>
					<td valign=top><font size=2 color="#000000" face="verdana,Arial">E-Mail Address:</font></td>
                     <td><input type="text" name="email_addr" class="textbox" value="<?=$row['email_addr'];?>" size="40"></td>
                 </tr>
				<tr> 
                  <td colspan=2 align=center><input type="submit" value="Update" class=button>                  </td>
                </tr>
              </table>

                    </td></tr></table>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>



</body>
</html>
