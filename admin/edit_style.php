<?php
	include("../common.php");
	include("security.php");
	if(@$action=='delete')
	{
	 $delete="delete from tblstyle where style_id='$eid' AND heading_id = '1'";
	 mysql_query($delete);

	}

	if(isset($_POST['btnSeq'])) {
			$get_seq = @mysql_query("select style_id from tblstyle") or die(mysql_error());
			while($row = @mysql_fetch_array($get_seq)) {
				@mysql_query("update tblstyle set ordering='".$_POST[$row['style_id']]."' where style_id='".$row['style_id']."'");
			}
			$msg = '<center><span style="color:#ff0000;"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sequence has been updated</font></span></center>';
		}

	if(empty($_GET['act']) == false){
		$sql_ = "select * from tblstyle where style_id='".$_GET['pid']."' AND heading_id = '1'";
		$res_ = mysql_query($sql_);
		$rows_ = mysql_fetch_array($res_);
		if($rows_['view_status']=='Y'){
			$val = 'N';
		}
		if($rows_['view_status']=='N'){
			$val = 'Y';
		}

		$sql_up = "update tblstyle set view_status='$val' where style_id='".$_GET['pid']."' AND heading_id = '1'";
		$res_up= mysql_query($sql_up);
	}

	$select="select * from tblstyle WHERE heading_id = '1' order by style_name";
	$result=mysql_query($select);

	include 'top.php'; 
?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
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
<tr><td height="333" class="tab" align="center" valign="middle">
	
	<!--bof form=================================================================================-->
	<form name="faq" action="edit_style.php" method="post">
<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2 >
	<tr bgcolor=cccccc>
		<td align="center" colspan="2"><h1>Edit/Delete Styles Facet for <span style="color:red;">Womens Apparel</span></h1></td></tr>
          <tr bgcolor=cccccc>
		<td align="right"></td><td ><table width="287">
		  <tr><td width="25"></td>
		  <td width="25"></td>
		  <td width="141"></td>
		  <td width="76"><h1>Sequence</h1></td></tr></table></td></tr>
        <?php if($msg!=''){ ?>
        <tr bgcolor=cccccc>
		<td align=center colspan=2><?=$msg?></td></tr>
        <?php } ?>
        
		<?php
			 while($row=mysql_fetch_array($result)){
			  $sql_ = "select * from `tblstyle` where `style_id`='".$row['style_id']."' AND heading_id = '1'";
			  $res_ = mysql_query($sql_);
			  $row_ = mysql_fetch_array($res_);
			  if($row_['view_status'] == "Y"){ $checked="checked"; }else{ $checked=''; }
		?>
		<tr align=center>
			<td width="41%" class="text" align="right"><?php echo $row['style_name'];?> : </td>
			<td width="59%" align="left">
				<span class="text">[</span><a href="#" onclick="javascript:window.open('style_edit_popup.php?eid=<?php echo $row[style_id];?>','','height=700 width=520 scrollbars')" class="pagelinks">edit</a><span class="text">]</span>
				<span class="text">[</span><a href="edit_style.php?eid=<?php echo $row[style_id];?>&action=delete" onclick="return confirm_delete()" class="pagelinks">delete</a><span class="text">]</span>
				<span class="text">[</span><a href="#" class="pagelinks">Publish/Unpublish</a>
				<input name="publish" id="publish" type="checkbox" value="" onclick="javascript: _do('<?php echo $row['style_id'];?>');" <?php echo $checked;?>/><span class="text">]</span>
				<input  type="text" name="<?=$row['style_id']?>" value="<?=$row['ordering']?>" size="1"/>
			</td>
		</tr>
		<?}?>
        <tr bgcolor=cccccc>
		<td align=center colspan=2><input type="submit" name="btnSeq" value="Update Sequence" style="margin-top:5px;"></td></tr>
</table>
</td></tr></table>
</form>
	
	</td>
</tr>
</table>
<?php include 'footer.php'; ?>