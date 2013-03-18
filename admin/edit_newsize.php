<?
session_start();
include("../common.php");
include("security.php");
if(@$action=='delete')
{
	 $delete="delete from tblsize where size_id='$eid'";
	 mysql_query($delete);
	 header('location:edit_newsize.php');
 //delete the related urls!!!!!!!!!!!!!!!!!!
}


$select="select * from tblsize";
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
	
	<form name="faq" action="edit_newsize.php" method="post">
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2 >
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><h1>Edit/Delete Size</h1></td></tr>
                    <? while($row=mysql_fetch_array($result)){?>
                    <tr align=center>
                    	<td width="40%" class="text" align="right"><?=$row['size_name'];?> : </td>
						<td width="60%" align="left">
							<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('size_edit_popup.php?eid=<?=@$row['size_id'];?>','','height=150 width=400')">edit</a><span class="text">]</span>
                    		<span class="text">[</span><a href="edit_newsize.php?eid=<?=@$row['size_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span></td>
						</tr>
                     <? }?>
                   </table>
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>