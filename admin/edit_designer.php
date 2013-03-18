<?php
	include("../common.php");
	//include("security.php");
	
	if (@$action == 'delete')
	{
		$delete = "delete from designer where des_id='$eid'";
		mysql_query($delete);
		header('location:edit_designer.php');
	}

	if (empty($_GET['act']) == false)
	{
		$sql_ = "select * from designer where des_id='".$_GET['pid']."'";
		$res_ = mysql_query($sql_);
		$rows_ = mysql_fetch_array($res_);
		if ($rows_['view_status'] == 'Y')
		{
			$val = 'N';
		}
		if ($rows_['view_status'] == 'N')
		{
			$val = 'Y';
		}

		$sql_up = "update designer set view_status='$val' where des_id='".$_GET['pid']."'";
		$res_up = mysql_query($sql_up);
	}

	if(isset($_POST['btnSeq'])) {
			$get_seq = @mysql_query("select des_id from designer") or die(mysql_error());
			while($row = @mysql_fetch_array($get_seq)) {
				@mysql_query("update designer set ordering='".$_POST[$row['des_id']]."' where des_id='".$row['des_id']."'");
			}
			$msg = '<center><span style="color:#ff0000;"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sequence has been updated</font></span></center>';
		}
	$select="SELECT
			   d.*, t.cat_name
			FROM
			   designer d
			   LEFT JOIN tblcat t ON t.cat_id = d.catid order by ordering,cat_id";
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
	
	<form name="faq" action="edit_designer.php" method="post">
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2 >
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><h1>Edit/Delete Designer</h1></td></tr>
                    <tr bgcolor=cccccc>
		<td align="right"></td><td ><table width="287">
		  <tr><td width="25"></td>
		  <td width="25"></td>
		  <td width="141"></td>
		  <td width="76"><h1>Sequence</h1></td></tr></table></td></tr>
			<?php if(isset($msg) && $msg!=''){ ?>
        <tr bgcolor=cccccc>
		<td align=center colspan=2><?=$msg?></td></tr>
        <?php } ?>
                    <? while($row=mysql_fetch_array($result)){
					if($row['view_status'] == "Y"){ $checked="checked"; }else{ $checked=''; }
					?>
                    <tr align=center>
                    	<td width="50%" class="text" align="right"><?=$row['designer'];?> (<?=$row['cat_name']?>) : </td>
						<td width="50%" align="left">
							<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('designer_edit_popup.php?eid=<?=@$row['des_id'];?>','','height=650, width=600, scrollbars=1')">edit</a><span class="text">]</span>
                    		<span class="text">[</span><a href="<?php echo $_SERVER['PHP_SELF'];?>?eid=<?=@$row['des_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span>
                            <span class="text">[</span><a href="#" class="pagelinks">Publish/unpublish</a>
				<input name="publish" id="publish" type="checkbox" value="" onclick="javascript: _do('<?php echo $row['des_id'];?>');" <?php echo $checked;?>/><span class="text">]</span>
                            <input  type="text" name="<?=$row['des_id']?>" value="<?=$row['ordering']?>" size="1"/></td>
					  </tr>
                     <? }?>
                     <tr bgcolor=cccccc>
		<td align=center colspan=2><input type="submit" name="btnSeq" value="Update Sequence" style="margin-top:5px;"></td></tr>
                   </table>
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>