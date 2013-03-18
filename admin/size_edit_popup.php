<?
include("../common.php");
include("security.php");
if(@$action=='edit')
{

 if(@$name!='')
  {

  $update_query="update tblsize
                 set size_name='$name'
                 where size_id='$eid'";

  mysql_query($update_query);


print "<script>opener.location.href='edit_size.php';window.close();</script>";
  }
  else
  {
   $err="Please complete all the entries.";
}
}

$select="select * from tblsize where size_id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


if(@$name=='')
{
 $name=$row['size_name'];
}

?>

<title>7thavenuedirect::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">

<table width="100%" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td >
                    <!-----start-----------//-->
                    <form name="size" action="size_edit_popup.php?eid=<?=$eid;?>&action=edit" method="post">
                    <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
					<tr>
					<td>
                    <input type="hidden" name=eid value="<?=$eid;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><b>
                    <font size=2 color="#000000" face="verdana,Arial">Edit Size</td></tr>
                    <tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=@$err;?></td></tr>
                     <tr><td valign=top><font size=2 color="#000000" face="verdana,Arial">Size Name:</td>
                    <td><input type="text" name="name" class="inputbox" value="<?=@$name;?>"></td></tr>
                    <tr><td colspan=2 align=center><input type="submit" value="edit" class=button> </td></tr>
                     </table>
                    </td></tr></table>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>