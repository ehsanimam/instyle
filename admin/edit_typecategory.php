<?
session_start();
include("../common.php");
include('../functionsadmin.php');
if(@$_GET['action']=='delete')
{
	
 $delete_typecat="delete from tbltypecat where type_id='$eid'";
 mysql_query($delete_typecat);
 //$delete_product="delete from tblproduct where type_id='$eid'";
 //mysql_query($delete_product);
  //header('location:edit_subcategory.php');
 //delete the related urls!!!!!!!!!!!!!!!!!!
}

if(empty($_POST['up'])==false){
	$sql = "select * from tbltypecat";
	$res = mysql_query($sql);
	
	while($row = mysql_fetch_array($res)){
		 $t_id = $row['type_id'];
		 $box = $_POST["squ$t_id"];
		 
		 $sql_up = "update tbltypecat set sequ_order=".$box." where type_id=".$row['type_id'];
		 mysql_query($sql_up);
	}
	
	
}

$select="select * from tbltypecat order by sequ_order";
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
	
	<form name="faq" action="edit_typecategory.php" method="post">
                    <table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2 >
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><h1>Edit/Delete Type Sub Category</h1></td></tr>
                    <?php if($_GET['msg']==1){?>
                    <tr>
                  <td align=center colspan=2 class=error>Type Sub Category has been added.</td></tr>
                <?php } ?>
					<tr align=center>
                    <td width="50%" height="30" class="text" align="center" colspan="2">(Type-Sub Category Name) <b>Type Category</b> &nbsp;&nbsp;&nbsp;</td>
					</tr>

                    <? while($row=mysql_fetch_array($result)){  
					
					
					
					
					?>
                    <tr align=center>
                    <td width="50%" class="text" align="right">(<?=get_subcatname($row['type_name']);?>) <b><?=get_type_heading($row['heading_id']);?></b>  : </td>
					<td width="50%" align="left">
						<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('typecat_edit_popup.php?eid=<?=@$row[type_id];?>','','height=400 width=400')">edit</a><span class="text">]</span>
						<span class="text">[</span><a href="edit_typecategory.php?eid=<?=@$row['type_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span>
						<span style="padding-left:10px;"><input type="text" name="squ<?php echo $row['type_id'];?>" id="squ<?php echo $row['type_id'];?>" value="<?php echo $row['sequ_order'];?>" size="4" maxlength="4"/></span>
					</td>
					
					</tr>
                     <? }?>
					<tr>
						<td colspan="2" height="10"></td>
					</tr> 
					<tr align=center>
                    <td width="50%" height="30" class="text" align="center" colspan="2"><input type="submit" value="Update Sequence" name="up" id="up" /></td>
					</tr>

                   </table>

                    </td></tr></table>
                    </form>
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>