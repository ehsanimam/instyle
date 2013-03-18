<?php
	session_start();
	include("../common.php");

	$select="select * from tblsubcat where cat_id='".$_REQUEST['catid']."' and view_status='Y' order by ordering";
	$result=mysql_query($select);


	$select1="select * from tblcat where cat_id='".$_REQUEST['catid']."' and view_status='Y'";
	$result1=mysql_query($select1);
	$row1=mysql_fetch_array($result1);

	include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="333" class="tab" align="center" valign="middle">
	
	<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2 >
		<!--DWLayoutTable-->
			<tr bgcolor=cccccc><td width="609" height="29" align=center><h1><?=$row1['cat_name']?></h1></td></tr>
			
			<?php
			while ($row=mysql_fetch_array($result))
			{ ?>
				<tr align=center>
					<td valign="top" align="center"><a href="edit_new_product.php?cat_id=<?=$row1['cat_id']?>&subcat_id=<?=@$row[subcat_id] ?>" class="pagelinks"><?=$row['subcat_name'];?></a></td>
				</tr>
				<?php
			} ?>
		</table>
		
	</td></tr>
	</table>
	
</td></tr>
</table>
<? include 'footer.php'; ?>