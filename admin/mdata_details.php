<?php
	include("../common.php");
	include('../functionsadmin.php');
	include('security.php');
?>
<script language="javascript">
	function confirm_delete()
	{
	var agree=confirm("Are you sure you wish to delete this record ?");
		if (agree){
			return true;
		}else{
			return false ;
		}
	}	
</script>
<?php
	$rno = 50; // views per page
	$sql = "select * from tblmeta  order by id desc";
	$pr_rs = mysql_query($sql);
	$rnum = mysql_num_rows($pr_rs);
	
	if ($rnum >= 0)
	{
		$mod = $rnum % $rno;
		
		if ($mod > 0)
		{
			$tpage = ($rnum - $mod) / $rno + 1; 
		}
		else
		{
			$tpage = ($rnum - $mod) / $rno;
		}
		
		if (@$cpage == "")
		{
			$cpage = 1; // c for current page
		}

		$skip = ($cpage - 1) * $rno;
		
		if (($skip + $rno) > $rnum)
		{
			$lmt = $rnum - $skip;
		}
		else
		{
			$lmt = $rno;
		}
		
		$start = $skip + 1;
		$end = $skip + $lmt;
	}
	
	$sql = "SELECT * FROM tblmeta ORDER BY id DESC LIMIT ".$skip.", ".$lmt."";
	$pr_rs = mysql_query($sql); // running query again
	
	if (@$action == 'delete')
	{
		$sql = "delete from tblmeta  where id='".$_GET['id']."'";
		$rs = mysql_query($sql);
		header('location:mdata_details.php');
		//delete the related urls!!!!!!!!!!!!!!!!!!
	}
	
	include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="333" class="tab" align="center" valign="middle">
	
	<!--bof form=================================================================-->
	<form name="form1" method="post" action="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top" class="bodytext"><td class="border_color"> 
		
			<table border="0" cellpadding="2" width=100%>
				<tr bgcolor="#CCCCCC">
					<td colspan="7">
						<?php
						if (@$err) echo "Page meta data has been updated."; ?>
					</td>
				</tr>
				<tr bgcolor="#CCCCCC">
					<td height="30"><h1>S.No</h1></td>
					<td><h1>Page</h1></td>
					<td><h1>Title</h1></td>
					<td><h1>Description</h1></td>
					<td><h1>Keyword</h1></td>
					<td><h1>Footer</h1></td>
					<td><h1>Operation</h1></td>
				</tr>
				
				<?php
				$counter = 0;
				while ($pr_row = mysql_fetch_array($pr_rs))
				{
					$counter++; ?>
					<tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
						<td class="headtxt" ><?=$counter;?></td>
						<td class="text"><?=$pr_row['pagename'];?></td>
						<td class="text"><?=$pr_row['title'];?></td>
						<td class="text" ><? echo substr($pr_row['description'],0,50);?></td>
						<td class="text" ><? echo substr($pr_row['keyword'],0,50);?></td>
						<td class="text" ><? echo substr($pr_row['dfooter'],0,50);?></td>
						<td>
							<span class="text">[</span><a href="edit_metadata.php?id=<?=$pr_row['id']?>" class="pagelinks">Edit</a><span class="text">]</span>
								<span class="text">[</span><a href="mdata_details.php?id=<?=$pr_row['id']?>&action=delete" onclick="return confirm_delete()" class="pagelinks">Delete</a><span class="text">]</span>
						</td>
					</tr>
					<?php
				} ?>
				
			</table>
			
		</td></tr>
		
		<tr bgcolor='FFFFFF'>
			<td align="right" height=30>
				<? if($cpage>1){?>
				<a href="mdata_details.php?cpage=<?echo $cpage-1;?>&cat_id=<?echo $cat_id;?>" class="pagelinks">Prev</a><?}?>
				<? if($cpage>2){?>
				<span class="text"> | </span> <?}?>
				<? if($cpage<$tpage){?>
				<a href="mdata_details.php?cpage=<?echo $cpage+1;?>&cat_id=<?echo $cat_id;?>" class="pagelinks">Next</a>
				<? }?>
			</td>
		</tr>
		<tr bgcolor='FFFFFF'>
			<td align="left" height=30>
				<span class="text"> Page :</span>
				<?php
				for ($i = 1; $i <= $tpage; $i++)
				{
					if ($i == $cpage)
					{ ?>
						<span class="text">[<?echo $i;?>]</span>
						<?php
					}
					else
					{ ?>
						<span class="text">[</span><a href="mdata_details.php?cpage=<?echo $i;?>" class="pagelinks"><?echo $i;?></a><span class="text">]</span>
						<?php
					}
				} ?>
			</td>
		</tr>
	</table>
	</form>
	<!--bof form=================================================================-->
	
</td></tr>
</table>
<?php include 'footer.php';
