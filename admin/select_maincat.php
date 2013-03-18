<?
session_start();
include("../common.php");

$select="select * from tblmaincat";
$result=mysql_query($select);

include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2 >
	<tr bgcolor=cccccc>
	<td align=center colspan=2><h1>Select Main Category</h1></td></tr>
	
	<?while($row=mysql_fetch_array($result)){?>
		<tr align=center>
			<td align=center colspan=2><a href="edit_category.php?eid=<?=$row[maincat_id];?>" class="pagelinks"><?=$row[main_cat_name];?></a></td>
		</tr>
	<?}?>
</table>
</td></tr></table>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>