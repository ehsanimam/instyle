<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include('security.php');
$select= sprintf("select * from tblcontact_data where contact_id='%s'",$_GET['id']);

$result=mysql_query($select);
$row=mysql_fetch_array($result);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Instyle New York::Admin</title>
<link href='style.css' rel='stylesheet' type='text/css'>
<script language="javascript" type="text/javascript" src="js/function.js"></script>

</head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td >
                    <!-----start-----------//-->
         <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
             <table width=100% align=center cellspacing=2 cellpadding=2>
                <tr bgcolor=cccccc> 
                  <td align=center colspan=2><b> <font size=2 color="#000000" face="verdana,Arial">Contact Detail</font></td>
                </tr>
                 <tr>
                  <td valign=top width="30%"><font size=2 color="#000000" face="verdana,Arial">Contact ID :</font></td>
                  <td><?php echo $row['contact_id']; ?></td>
                </tr>
                 <tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Full Name :</font></td>
                  <td><?php echo $row['fullname']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Company :</font></td>
                  <td><?php echo $row['company']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Address 1 :</font></td>
                  <td><?php echo $row['address1']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Address 2 :</font></td>
                  <td><?php echo $row['address2']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">City :</font></td>
                  <td><?php echo $row['city']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">state :</font></td>
                  <td><?php echo $row['state_province']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Country :</font></td>
                  <td><?php echo $row['country']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Zip :</font></td>
                  <td><?php echo $row['zip_postcode']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Telephone :</font></td>
                  <td><?php echo $row['telephone']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Cell :</font></td>
                  <td><?php echo $row['cellphone']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Email :</font></td>
                  <td><?php echo $row['email']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Best Contact :</font></td>
                  <td><?php echo $row['best_contact']; ?></td>
                </tr>
				<tr>
                  <td valign=top><font size=2 color="#000000" face="verdana,Arial">Receive Product Update :</font></td>
                  <td><?php echo $row['receive_productupd']; ?></td>
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
