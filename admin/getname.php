<?
include("../common.php");
include('uplink.php');
if($action=="show")
{
    //echo $prod_name;
	uplink_product_iamges($prod_id, 0);
	uplink_product_iamges($prod_id, 1);
	uplink_product_iamges($prod_id, 2);
	uplink_product_iamges($prod_id, 3);	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="getname.php?action=show" name="form" method="post">
<table width="496" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="118" height="48">&nbsp;</td>
    <td width="234">&nbsp;</td>
    <td width="56">&nbsp;</td>
    <td width="88">&nbsp;</td>
  </tr>
  <tr>
    <td height="24"><input type="hidden" name="prod_id" value="7"></td>
    <td valign="top"><input type="text" name="prod_name" class="inputbox" value=""></td>
    <td valign="top"><input type="submit" name="cmd_cat_submit" class=button value="Submit"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
