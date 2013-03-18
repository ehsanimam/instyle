<?php
	include("../common.php");
	include('../functionsadmin.php');
	//4include('security.php');
	
	if (@$_GET['action'] == 'delete')
	{
		$imgn = "no_img.jpg";
		$dat = @date('Y-m-d');
		$sbid = 0;
		
		// delete subsubcat from tblsubsubcat
		$delete_subsubcat = "delete from tblsubsubcat where id ='$eid'";
		mysql_query($delete_subsubcat);

		// delete subsubcat id from subsubcats from tblsubcat table of all or one subcat
		$sel_sc = "SELECT * FROM tblsubcat";
		$qry_sc = mysql_query($sel_sc) or die('Select error: '.mysql_error());
		
		while ($ary_sc = mysql_fetch_array($qry_sc))
		{
			$subsubcats_ary = explode(',',$ary_sc['subsubcats']);
			$subsubcats = '';
			
			while ($subsubcat = current($subsubcats_ary))
			{
				if ($subsubcat != $_GET['eid'] AND $subsubcat != '') $subsubcats .= $subsubcat.',';
				next($subsubcats_ary);
			}
			
			$upd_qry = mysql_query("
				UPDATE tblsubcat
				SET subsubcats  = '".$subsubcats."'
				WHERE subcat_id = '".$ary_sc['subcat_id']."'
			") or die('Update error: '.mysql_error());
		}
		
		echo '
			<script>
				alert("Record deleted." + "\n" + "Subcat directory may only be deleted manually.");
				window.location.href = "'.SITE_URL.'admin/edit_subsubcategory.php";
			</script>
		';
 
		/*$delete_right="update tblright set img_name='$imgn', img_date='$dat', cat_id='$sbid' where cat_id='$eid'";
		mysql_query($delete_right)or die("eror deleting $eid");*/
		//header('location:edit_subcategory.php');
		//delete the related urls!!!!!!!!!!!!!!!!!!
	}

if(empty($_GET['act']) == false){
	$sql_ = "select * from tblsubsubcat where id='".$_GET['pid']."'";
	$res_ = mysql_query($sql_);
	$rows_ = mysql_fetch_array($res_);
	if($rows_['view_status']=='Y'){
		$val = 'N';
	}
	if($rows_['view_status']=='N'){
		$val = 'Y';
	}

	$sql_up = "update tblsubsubcat set view_status='$val' where id='".$_GET['pid']."'";
	$res_up= mysql_query($sql_up);
}

if(isset($_POST['btnSeq'])) {
		$get_seq = @mysql_query("select id from tblsubsubcat") or die(mysql_error());
		while($row = @mysql_fetch_array($get_seq)) {
			@mysql_query("update tblsubsubcat set ordering='".$_POST[$row['id']]."' where id='".$row['id']."'");
		}
		$msg = '<center><span style="color:#ff0000;"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sequence has been updated</font></span></center>';
	}


$select="select * from tblsubsubcat order by cat_id,subcat_id,ordering";
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
                    <td align=center colspan=2><h1>Edit/Delete Sub SubCategory</h1></td></tr>
                    <?php if(isset($msg) && $msg!=''){ ?>
        <tr bgcolor=cccccc>
		<td align=center colspan=2><?=$msg?></td></tr>
        <?php } ?>
					<tr align=center>
                    <td width="50%" height="30" class="text" align="right">(Category) &nbsp;&nbsp; ( Sub Category)&nbsp;&nbsp;<b>Sub Sub-category Name</b> &nbsp;&nbsp;&nbsp;</td><td align=center><table><tr><td width="72">&nbsp;</td>
                    <td width="10">&nbsp;</td>
                    <td width="109">&nbsp;</td>
                    <td width="199"><h1> Sequence</h1></td></tr></table></td>
					</tr>

                    <?php
						 while($row=mysql_fetch_array($result)){
						 $sql_ = "select * from `tblsubsubcat` where `id`='".$row['id']."'";
						 $res_ = mysql_query($sql_);
						 $row_ = mysql_fetch_array($res_);
						 if($row_['view_status'] == "Y"){ $checked="checked"; }else{ $checked=''; }
					?>
                    <tr align=center>
                    <td width="50%" class="text" align="right">(<? get_catname($row['cat_id']);?>) &nbsp;&nbsp; (<? get_subcatname($row['subcat_id']);?>)&nbsp;&nbsp;<b><?=$row['name'];?></b>  : </td>
					<td width="50%" align="left">
                    <table><tr><td>
						<span class="text">[</span><a href="#" class="pagelinks" onClick="javascript:window.open('subsubcat_edit_popup.php?eid=<?=@$row[id];?>','','height=850,width=800,scrollbars=yes')">edit</a><span class="text">]</span></td><td>
						<span class="text">[</span><a href="edit_subsubcategory.php?eid=<?=@$row['id'];?>&action=delete" class="pagelinks" onClick="return confirm_delete()">delete</a><span class="text">]</span></td><td>
						<span class="text">[</span><a href="#" class="pagelinks">Publish/Unpublish</a><input name="publish" id="publish" type="checkbox" value="" onClick="javascript: _do('<?php echo $row['id'];?>');" <?php echo $checked;?>/><span class="text">]</span></td><td><input  type="text" name="<?=$row['id']?>" value="<?=$row['ordering']?>" size="1"/></td></tr></table>
					</td></tr>
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