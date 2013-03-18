<?php
session_start();
include("../common.php");

if(@$action=='delete')
{
 $delete="delete from tblmajcat where cat_id='$eid'";
 mysql_query($delete);
 $delete_subcat="delete from tblsubcat  where cat_id='$eid'";
 mysql_query($delete_subcat);
 $delete_product="delete from tblproduct where cat_id='$eid'";
 mysql_query($delete_product);
 $delete_right="delete from tblmright where which_page='$eid'";
 mysql_query($delete_right);
 //$delete_right="update tblindex set main_img='0', cat_id='0' where cat_id ='$eid'";
 //mysql_query($delete_right);
 header('location:edit_majcategory.php');
 //delete the related urls!!!!!!!!!!!!!!!!!!
}

if(empty($_GET['act']) == false){
	$sql_ = "select * from tblmajcat where cat_id='".$_GET['pid']."'";
	$res_ = mysql_query($sql_);
	$rows_ = mysql_fetch_array($res_);
	if($rows_['view_status']=='Y'){
		$val = 'N';
	}
	if($rows_['view_status']=='N'){
		$val = 'Y';
	}

	$sql_up = "update tblmajcat set view_status='$val' where cat_id='".$_GET['pid']."'";
	$res_up= mysql_query($sql_up);
}

$select="select * from tblmajcat";
$result=mysql_query($select);

include 'top.php'; 
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function confirm_delete()
{
var agree=confirm("Are you sure you wish to delete this record ?");
	if (agree){
		return true;
	}else{
		return false ;
	}
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
	
	<form name="faq" action="edit_majcategory.php" method="post">
<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2 >
	<tr bgcolor=cccccc>
		<td align=center colspan=2><h1>Edit/Delete Category</h1></td></tr>
		<?php
			 while($row=mysql_fetch_array($result)){
			  $sql_ = "select * from `tblmajcat` where `cat_id`='".$row['cat_id']."'";
			  $res_ = mysql_query($sql_);
			  $row_ = mysql_fetch_array($res_);
			  if($row_['view_status'] == "Y"){ $checked="checked"; }else{ $checked=''; }
		?>
		<tr align=center>
			<td width="41%" class="text" align="right"><?php echo $row['cat_name'];?> : </td>
			<td width="59%" align="left">
				<span class="text">[</span><a href="#" onclick="javascript:window.open('mcat_edit_popup.php?eid=<?php echo $row[cat_id];?>','','height=700 width=520 scrollbars')" class="pagelinks">edit</a><span class="text">]</span>
				<span class="text">[</span><a href="edit_majcategory.php?eid=<?php echo $row[cat_id];?>&action=delete" onclick="return confirm_delete()" class="pagelinks">delete</a><span class="text">]</span>
				<span class="text">[</span><a href="#" class="pagelinks">Publish/Unpublish</a>
				<input name="publish" id="publish" type="checkbox" value="" onclick="javascript: _do('<?php echo $row['cat_id'];?>');" <?php echo $checked;?>/><span class="text">]</span>
			</td>
		</tr>
		<?}?>
</table>
</td></tr></table>
</form>
	
	</td>
</tr>
</table>
<?php include 'footer.php'; ?>