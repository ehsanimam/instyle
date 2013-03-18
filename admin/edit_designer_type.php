<?
session_start();
include("../common.php");

if(@$action=='delete')
{
	 $delete="delete from designer_type where destype_id='$eid'";
	 mysql_query($delete);
	 header('location:edit_designer_type.php');
 //delete the related urls!!!!!!!!!!!!!!!!!!
}


$select="SELECT
		   dt.*, t.cat_name
		FROM
		   designer_type dt
		   LEFT JOIN tblcat t ON t.cat_id = dt.catid";
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
	<td height="400" class="tab" align="center" valign="middle">
	
	<form name="faq" action="edit_designer.php" method="post">
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2 >
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><h1>Edit/Delete Designer Type</h1></td></tr>
                    <? while($row=mysql_fetch_array($result)){?>
                    <tr align=center>
                    	<td width="69%" class="text" align="right"><?=$row['designer_type'];?> (<?=$row['cat_name']?>) : </td>
						<td width="31%" align="left">
							<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('designer_type_edit_popup.php?eid=<?=@$row['destype_id'];?>','','height=150 width=250')">edit</a><span class="text">]</span>
                    		<span class="text">[</span><a href="<?php echo $_SERVER['PHP_SELF'];?>?eid=<?=@$row['destype_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span></td>
					  </tr>
                     <? }?>
                   </table>
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>