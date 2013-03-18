<?php
	include("../common.php");
	include("security.php");
	
	if(@$action=='delete')
	{
		$qry_col="select * from designer_color where FIND_IN_SET(".$eid.",color_id)";
		$res_col=mysql_query($qry_col);

		while($rec_col=mysql_fetch_array($res_col))
		{
			$col_color=explode(",",$rec_col['color_id']);

			if (in_array($eid, $col_color)) 
			{
				array_unshift($col_color,$eid);
				$result = array_unique($col_color);

				$col_result = array_shift($result);
				$col_result1=implode(",",$result); 

				$update="update designer_color set color_id='".$col_result1."' where des_id='".$rec_col['des_id']."'";
				$res_update=mysql_query($update);
			}
		}

		$delete="delete from tblcolor where color_id='$eid'";
		mysql_query($delete);
		header('location:edit_color.php');
		//delete the related urls!!!!!!!!!!!!!!!!!!
	}

	$select="select * from tblcolor order by color_name";
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
<tr><td height="333" class="tab" align="center" valign="middle">

	<!--bof form============================================================================-->
	<form name="faq" action="edit_color.php" method="post">
	<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2>
			<tr bgcolor=cccccc><td align=center colspan=2><h1>Edit/Delete Color</h1></td></tr>
			<tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>
			<?php
			while ($row=mysql_fetch_array($result))
			{ ?>
				<tr align=center>
					<td width="50%" class="text" align="right"><?=$row['color_name'];?> </td> <td class="text" width="10%" align="right"><?=$row['color_code'];?> : </td>
					<td width="40%" align="left">
						<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('color_edit_popup.php?eid=<?=@$row['color_id'];?>','','height=150 width=400')">edit</a><span class="text">]</span>
						<span class="text">[</span><a href="edit_color.php?eid=<?=@$row['color_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span>
					</td>
				</tr>
				<?php
			} ?>
		</table>
	</td></tr>
	</table>
	</form>
	<!--eof form============================================================================-->
	
</td></tr>
</table>
<?php include 'footer.php';