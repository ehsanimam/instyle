<?
include("../common.php");
if($action=='edit')
{
	 if($name!='')
  	{
		 $update_query="update tblmaincat
                 set main_cat_name='$name'
                 where maincat_id='$eid'";

  		mysql_query($update_query);
		 print "<script>opener.location.href='edit_main_category.php';window.close();</script>";
	 }
	 else
	 {
	 	$err="Please enter Main category Name.";
	 }
}

$select="select * from tblmaincat where maincat_id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


if($name=='')
{
 	$name=$row[main_cat_name];
}
?>
<title>ishopdress::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<form name="category" action="maincat_edit_popup.php?eid=<?=$eid;?>&action=edit" method="post">
                    <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <input type="hidden" name=eid value="<?=$eid;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><h1>Edit Main Category</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><?=$err;?></td></tr>
                    <tr>
						<td class="text" align="right" width="50%">Main Category Name : </td>
						<td width="50%" align="left"><input type="text" name="name" class="textbox" value="<?=$name;?>"></td>
					</tr>
                    <tr><td colspan=2 align=center><input type="submit" value="Edit" class=button> </td></tr>
                     </table>
                    </td></tr></table>
                    </form>