<?
session_start();
include("../common.php");

if(@$action=='delete')
{
	 $delete="delete from tbl_type_headings where id='$eid'";
	 mysql_query($delete);
	 header('location:edit_typeheading.php');
 //delete the related urls!!!!!!!!!!!!!!!!!!
}


$select="select * from tbl_type_headings";
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
	
	<form name="faq" action="edit_typeheading.php" method="post">
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2 >
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><h1>Edit/Delete Category</h1></td></tr>
                    <?php if($_GET['msg']==1){?>
                    <tr>
                  <td align=center colspan=2 class=error>Type Category has been added.</td></tr>
                <?php } ?>
                    <? while($row=mysql_fetch_array($result)){?>
                    <tr align=center>
                    	<td width="40%" class="text" align="right"><?=$row['headings'];?> : </td>
						<td width="60%" align="left">
							<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('heading_edit_popup.php?eid=<?=@$row['id'];?>','','height=400 width=400')">edit</a><span class="text">]</span>
                    		<span class="text">[</span><a href="<?php echo $_SERVER['PHP_SELF'];?>?eid=<?=@$row['id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span></td>
						</tr>
                     <? }?>
                   </table>
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>