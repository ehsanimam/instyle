<?
include("../common.php");
include("../functionsadmin.php");

if($action=='edit')
{

 if(!datecheck($shipdate))
  {

  echo $update_query="update tblshipping_det
                 set shipping_date ='$shipdate'
                 where shipping_id='$id'";

  mysql_query($update_query);

 print "<script>opener.location.href='admin_order_details.php?transaction_id=$orderid&cart_id=$cart_id&option=o';window.close();</script>";
  }
  else
  {
   $err=$GLOBALS["message"];
}
}


?>

<title>7thavenuedirect::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">


<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td >
                    <!-----start-----------//-->
                    <form name="color" action="editdate.php?id=<?=$id;?>&action=edit" method="post">
                    <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <input type="hidden" name=eid value="<?=$id;?>">
					 <input type="hidden" name="orderid" value="<?=$orderid;?>">
					  <input type="hidden" name="cart_id" value="<?=$cart_id;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><b>
                    <font size=2 color="#000000" face="verdana,Arial">Edit Shipping Date</td></tr>

                    <tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=$err;?></td></tr>


                     <tr align="center"><td valign=top><font size=2 color="#000000" face="verdana,Arial">Date:</td>
                    <td class="text"><input type="text" name="shipdate" class="inputbox" value="<?=$shipdate;?>"> (yyyy-mm-dd format)e.g.<?= date("Y-m-d")?></td></tr>
                    <tr><td colspan =2 align=center><input type="submit" value="Edit" class=button> </td></tr>
                     </table>

                    </td></tr></table>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>