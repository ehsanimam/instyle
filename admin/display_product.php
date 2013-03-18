<?
session_start();
include("../common.php");

$select="select * from tblcat";
$result=mysql_query($select);

include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2 >
	  <!--DWLayoutTable-->
	<tr bgcolor=cccccc>
		<td width="609" height="29" align=center><h1>Select Category</h1></td></tr>
		<? while($row=mysql_fetch_array($result)){?>
		<tr align=center>
			<td valign="top"><a href="edit_product.php?cat_id=<?=@$row[cat_id] ?>" class="pagelinks"><?=$row['cat_name'];?></a></td>
			</tr>
		<? }?>
</table>
</td></tr></table>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>