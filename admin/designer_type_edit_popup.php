<?
include("../common.php");

if(@$action=='edit')
{

 if(@$designer_type!='')
  {

  $update_query="update designer_type
                 set designer_type='$designer_type', catid='".$_POST['catid']."'
                 where destype_id='$eid'";

  mysql_query($update_query);


 print "<script>opener.location.href='edit_designer_type.php';window.close();</script>";
  }
  else
  {
   $err="Please complete all the entries.";
}
}

$select="select * from designer_type where destype_id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


if(@$designer_type=='')
{
 $designer_type=$row['designer_type'];
 $catid=$row['catid'];
}

?>
<title>Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td >
                    <!-----start-----------//-->
                    <form name="color" action="<?php echo $_SERVER['PHP_SELF'];?>?eid=<?=$eid;?>&action=edit" method="post">
                    <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <input type="hidden" name=eid value="<?=@$eid;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><b>
                    <font size=2 color="#000000" face="verdana,Arial">Edit Designer Type</td></tr>

                    <tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=@$err;?></td></tr>


                     <tr><td valign=top><font size=2 color="#000000" face="verdana,Arial">Designer Type:</td>
                    <td><input type="text" name="designer_type" class="inputbox" value="<?=@$designer_type;?>"></td></tr>
                    <tr>
					<td>Category</td>
					<td>
					<select name="catid">
						<option> - select category - </option>
						<?php
						$cat = mysql_query("select * from tblcat");
						if(mysql_num_rows($cat) > 0) {
							while($row = mysql_fetch_array($cat)) {
								?> <option value="<?=$row['cat_id']?>" <?php echo $row['cat_id']==$catid ? 'selected' : ''; ?>><?=$row['cat_name']?></option> <?php
							}
						}
						?>
					</select>
					</td>
                    <tr><td colspan=2 align=center><input type="submit" value="edit" class=button> </td></tr>
                     </table>

                    </td></tr></table>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>