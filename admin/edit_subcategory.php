<?php
	include("../common.php");
	include('../functionsadmin.php');
	//include('security.php');
	
	if (@$_GET['action'] == 'delete')
	{
		$imgn = "no_img.jpg";
		$dat = date('Y-m-d');
		$sbid = 0;
		
		// delete subcat from tblsubcat
		$delete_subcat = "delete from tblsubcat where subcat_id='$eid'";
		mysql_query($delete_subcat);

		// delete subcat id from subcats from designer table of all or one designers
		$sel_des = "SELECT * FROM designer";
		$qry_des = mysql_query($sel_des) or die('Select error: '.mysql_error());
		
		while ($ary_des = mysql_fetch_array($qry_des))
		{
			$subcats_ary = explode(',',$ary_des['subcats']);
			$subcats = '';
			
			while ($subcat = current($subcats_ary))
			{
				if ($subcat != $_GET['eid'] AND $subcat != '') $subcats .= $subcat.',';
				next($subcats_ary);
			}
			
			$upd_qry = mysql_query("
				UPDATE designer
				SET subcats  = '".$subcats."'
				WHERE des_id = '".$ary_des['des_id']."'
			") or die('Update error: '.mysql_error());
		}
		
		echo '
			<script>
				alert("Record deleted." + "\n" + "Subcat directory may only be deleted manually.");
				window.location.href = "'.SITE_URL.'admin/edit_subcategory.php";
			</script>
		';
	}

	if (empty($_GET['act']) == false)
	{
		$sql_ = "select * from tblsubcat where subcat_id='".$_GET['pid']."'";
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

		$sql_up = "update tblsubcat set view_status='$val' where subcat_id='".$_GET['pid']."'";
		$res_up = mysql_query($sql_up);
	}

	if (isset($_POST['btnSeq']))
	{
		$get_seq = @mysql_query("select subcat_id from tblsubcat") or die(mysql_error());
		while ($row = @mysql_fetch_array($get_seq))
		{
			@mysql_query("update tblsubcat set ordering='".$_POST[$row['subcat_id']]."' where subcat_id='".$row['subcat_id']."'");
		}
		$msg = '<center><span style="color:#ff0000;"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sequence has been updated</font></span></center>';
	}

	$select = "select * from tblsubcat order by cat_id,ordering";
	$result = mysql_query($select);

	include 'top.php'; 
?>
<script>
function confirm_delete()
{
	var agree = confirm("Are you sure you wish to delete the record?");
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
<tr><td height="333" class="tab" align="center" valign="middle">
	
	<!--bof form============================================================================-->
	<form name="faq" action="" method="post">
	<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2 >
			<tr bgcolor=cccccc>
				<td align=center colspan=2><h1>Edit/Delete SubCategory</h1></td>
			</tr>
			<?php
			if (isset($msg) && $msg != '')
			{ ?>
				<tr bgcolor=cccccc><td align=center colspan=2><?=$msg?></td></tr>
				<?php
			} ?>
			<tr align=center>
				<td width="50%" height="30" class="text" align="right">(Category) <b>Sub-category Name</b> &nbsp;&nbsp;&nbsp;</td>
				<td align=center>
				
					<table>
					<tr>
						<td width="72">&nbsp;</td>
						<td width="10">&nbsp;</td>
						<td width="109">&nbsp;</td>
						<td width="199"><h1> Sequence</h1></td>
					</tr>
					</table>
				</td>
			</tr>
			<?php
			while ($row = mysql_fetch_array($result))
			{
				$sql_ = "select * from `tblsubcat` where `subcat_id`='".$row['subcat_id']."'";
				$res_ = mysql_query($sql_);
				$row_ = mysql_fetch_array($res_);
				if ($row_['view_status'] == "Y"){ $checked="checked"; }else{ $checked=''; }
				?>
				<tr align=center>
                    <td width="50%" class="text" align="right">(<? get_catname($row['cat_id']);?>) <b><?=$row['subcat_name'];?></b>  : </td>
					<td width="50%" align="left">
						<table>
						<tr>
							<td>
								<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('subcat_edit_popup.php?eid=<?=@$row[subcat_id];?>','','height=850,width=800,scrollbars=yes')">edit</a><span class="text">]</span>
							</td>
							<td>
								<span class="text">[</span><a href="edit_subcategory.php?eid=<?=@$row['subcat_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span>
							</td>
							<td>
								<span class="text">[</span><a href="#" class="pagelinks">Publish/Unpublish</a><input name="publish" id="publish" type="checkbox" value="" onclick="javascript: _do('<?php echo $row['subcat_id'];?>');" <?php echo $checked;?>/><span class="text">]</span>
							</td>
							<td>
								<input  type="text" name="<?=$row['subcat_id']?>" value="<?=$row['ordering']?>" size="1"/>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				<?php
			} ?>
			<tr bgcolor=cccccc>
				<td align=center colspan=2><input type="submit" name="btnSeq" value="Update Sequence" style="margin-top:5px;"></td>
			</tr>
		</table>
		
	</td></tr>
	</table>
	</form>
	<!--eof form============================================================================-->
	
</td></tr>
</table>
<?php include 'footer.php';