<?
session_start();
include("security.php");

include("../common.php");
if($action=='delete')
{
 	$delete="delete from tblmaincat where maincat_id='$eid'";
 	mysql_query($delete);
 	$delete_subcat="delete from tblsubcat  where maincat_id='$eid'";
 	mysql_query($delete_subcat);
 	$delete_product="delete * from tblproduct where maincat_id='$eid'";
 	mysql_query($delete_product);
 	header('location:edit_main_category.php');
 	//delete the related urls!!!!!!!!!!!!!!!!!!
}


$select="select * from tblmaincat";
$result=mysql_query($select);

include 'top.php'; 
?>
<script>
function confirm_delete()
{
var agree=confirm("Are you sure you wish to delete the record?");
if (agree)
return true ;
else
return false ;
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<form name="faq" action="edit_main_category.php" method="post">
<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2 >
	<tr bgcolor=cccccc>
	<td align=center colspan=2><h1>Edit/Delete Main Category</h1></td></tr>
	
	<?while($row=mysql_fetch_array($result)){?>
		<tr align=center>
			<td class="text" align="right" width="50%"><?=$row[main_cat_name];?> : </td>
			<td width="50%" align="left">
				<span class="text">[</span><a href="#" onclick="javascript:window.open('maincat_edit_popup.php?eid=<?=$row[maincat_id];?>','','height=350 width=400')" class="pagelinks">edit</a><span class="text">]</span>
				<span class="text">[</span><a href="edit_main_category.php?eid=<?=$row[maincat_id];?>&action=delete" onclick="return confirm_delete()" class="pagelinks">delete</a><span class="text">]</span>
			</td>
		</tr>
	<?}?>
</table>
</td></tr></table>
</form>
	
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>