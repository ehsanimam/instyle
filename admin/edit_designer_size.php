<?
session_start();
include("../common.php");
include('../functionsadmin.php');
if(@$_GET['action']=='delete')
{
	
 $delete_subcat="delete from designer_size where desize_id='$eid'";
 mysql_query($delete_subcat);
 header('location:edit_designer_size.php');
}

$select="select * from designer_size";
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

function _do(ss){
	window.document.faq.action="<?php echo $_SERVER['PHP_SELF'];?>?act=10&pid="+ss;
	window.document.faq.method = "post";
	window.document.faq.submit();
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<form name="faq" action="" method="post">
                    <table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2 >
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><h1>Edit/Delete Designer Size</h1></td></tr>
					<tr align=center>
                    <td width="50%" height="30" class="text" align="center" colspan="2">(Designer) <b>Size</b> &nbsp;&nbsp;&nbsp;</td>
					</tr>

                    <?php
						 while($row=mysql_fetch_array($result)){
						 $sql_ = "select * from `tblsize` where `size_id`='".$row['sizet_id']."'";
						 $res_ = mysql_query($sql_);
						 $row_ = mysql_fetch_array($res_);
						
					?>
                    <tr align=center>
                    <td width="50%" class="text" align="right">(<? get_designername($row['des_id']);?>) <b><?=$row['size_name'];?></b>  : </td>
					<td width="50%" align="left">
						<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('sizedes_edit_popup.php?eid=<?=@$row[desize_id];?>','','height=150 width=400')">edit</a><span class="text">]</span>
						<span class="text">[</span><a href="edit_designer_size.php?eid=<?=@$row['desize_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text"></span>
						<span class="text">]</span>
					</td></tr>
                     <? }?>


                   </table>

                    </td></tr></table>
                    </form>
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>