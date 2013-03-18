<?
session_start();
include("../common.php");

if(@$action=='delete')
{
	 $delete="delete from tbl_stock where st_id='$eid'";
	 mysql_query($delete);
	 header('location:edit_color_size.php');
}


$select="SELECT s.*, d.designer,c.color_name,p.prod_name FROM tbl_stock s LEFT JOIN designer d ON d.des_id = s.des_id LEFT JOIN tblcolor c ON c.color_id = s.cs_id LEFT JOIN tbl_product p ON p.prod_id = s.prod_id";
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
	
	<form name="faq" action="edit_color_size.php" method="post">
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2 >
                    <tr bgcolor=cccccc>
                    <td align=center colspan=4><h1>Edit/Delete Designer</h1></td></tr>
                    <tr align=center>
                    	<td width="37%" class="text" align="right"><strong>Designer</strong> </td>
                    	<td width="16%" class="text" align="right"><strong>Product</strong></td>
                    	<td width="15%" class="text" align="right"><strong>Color</strong></td>
						<td width="32%" align="left"></td>
					  </tr>
                    <? while($row=mysql_fetch_array($result)){?>
                    <tr align=center>
                    	<td width="37%" class="text" align="right"><?=$row['designer'];?></td>
                    	<td width="16%" class="text" align="right"><?=$row['prod_name'];?></td>
                    	<td width="15%" class="text" align="right"><?=$row['color_name'];?></td>
						<td width="32%" align="left">
							<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('designer_stock_popup.php?eid=<?=@$row['st_id'];?>','','height=350 width=400')">edit</a><span class="text">]</span>
                    		<span class="text">[</span><a href="<?php echo $_SERVER['PHP_SELF'];?>?eid=<?=@$row['st_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span></td>
					  </tr>
                     <? }?>
                   </table>
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>