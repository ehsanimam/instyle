<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include 'top.php'; 
$flg=0;
if(@$prod_name=='')
{
    $prod_name=0;
}
if(@$prod_det_name=='')
{
    $prod_det_name=0;
}

if(@$eid!="")
{
	$sel="delete from tblproduct_size where p_id='$eid' ";
	mysql_query($sel);
	echo "
             <script>
                location.href='edit_size_product.php'
             </script>
             ";
}
if(@$prod_id!='')
{
	$prod_name=$prod_id;	
}
?>
<script>
function submit_form()
{
    document.prod_frm.method="post";
    document.prod_frm.action="edit_size_product.php";
    document.prod_frm.submit();
    
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="prod_frm" method="post" action="edit_size_product.php?action=editit">
		<table width=98% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td align="left">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                      <!--DWLayoutTable-->
                    <tr bgcolor=cccccc><td align=center colspan=3><h1>Edit Product Stock</h1></td></tr>
                    <tr><td align=center colspan=3 class="error"><?=@$err;?></td></tr>
						<tr>
						  <td width="453" align="right" class="text">Select Product : </td>
						  <td width="466" colspan="2" align="left"><?php get_prod_submit();?>
					      <script>document.prod_frm.prod_name.value="<?=$prod_name;?>"</script></td>
					  </tr>
					  <tr>
					    
                  <td class="text" align="right">Select# : </td>
					    <td colspan="2" align="left"><?php get_prod_det_submit($prod_name);?><script>document.prod_frm.prod_det_name.value="<?=$prod_det_name;?>"</script><input type="hidden" name="act1" value="show"></td>
				      </tr>
					  <? if(@$act1=="show") {
					  $sel="select * from tblproduct_size where prod_id='$prod_name' and part_id='$prod_det_name' ";
					  $res=mysql_query($sel);
					  ?>
					  <tr>
							<td colspan="3" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1">
							  <!--DWLayoutTable-->
							  <tr bgcolor=cccccc>
							  	<td width="16%" height="25" align="center" valign="middle"><h1>Wood Type</h1></td>
							    <td width="16%" height="25" align="center" valign="middle"><h1>Size1</h1></td>
								<td width="16%" height="25" align="center" valign="middle"><h1>Size2</h1></td>
								<td width="16%" height="25" align="center" valign="middle"><h1>Size3</h1></td>
							    <td width="12%" align="center" valign="middle"><h1>Color</h1></td>
							    <td width="11%" align="center" valign="middle"><h1>Stock</h1></td>
							    <td width="11%" align="center" valign="middle">&nbsp;</td>
							  </tr>
							  <? while($row=mysql_fetch_array($res))
	    						{
									/*$str="select * from tblsize where size_id='$row[size_id]'";
									$res1=mysql_query($str);
									$siz=mysql_result($res1,0,1);
									
									$str="select * from tblcolor where color_id='$row[color_id]'";
									$res1=mysql_query($str);
									$colo=mysql_result($res1,0,1);*/
									
									$det=$row['p_id'];
							?>
							  <tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
							  	<td height="25" align="center" valign="middle" class="text"><?=$row['wood_type'];?></td>
							    <td height="25" align="center" valign="middle" class="text"><?=$row['size_id1'];?></td>
								<td height="25" align="center" valign="middle" class="text"><?=$row['size_id2'];?></td>
								<td height="25" align="center" valign="middle" class="text"><?=$row['size_id3'];?></td>
							    <td align="center" valign="middle" class="text"><?=$row['color_id'];?></td>
							    <td align="center" valign="middle" class="text"><?=$row['stock'];?></td>
							    <td align="center" valign="middle">
								<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('stock_edit_popup.php?eid=<?=@$det;?>','','height=500 width=400')">edit</a><span class="text">]</span>
								<span class="text">[</span><a href="edit_size_product.php?eid=<?=@$det;?>" class="pagelinks">delete</a><span class="text">]</span></td>
						      </tr>
							  <? }?>							  
						    </table></td>
					  </tr>
						<? }?>						
			  </table>
</td></tr>
</table>
	</form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>