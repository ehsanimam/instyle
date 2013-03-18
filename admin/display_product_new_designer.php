<?php
	include("../common.php");
	
	/*
	| -----------------------------------------------------------------------------------------
	| Query for product subcategories given the desinger
	*/
	$select1 = "SELECT * FROM `designer` WHERE des_id = '".$_GET['des_id']."'";
	$result1 = mysql_query($select1);
	$row1 = mysql_fetch_array($result1);
		$exp_subs = explode(',',substr($row1['subcats'],0,-1));
		$where = '';
		while ($sub = current($exp_subs))
		{
			$where .= 'subcat_id LIKE \'%'.$sub.'%\' OR ';
			next($exp_subs);
		}
	$where = substr($where,0,-4);
	$select = "SELECT * FROM tblsubcat WHERE ".$where." AND view_status = 'Y' ORDER BY subcat_name";
	$result = mysql_query($select);

	include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="333" class="tab" align="center" valign="middle">
	
	<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td>
	
		<table width=100% align=center cellspacing=2 cellpadding=2 >
		<!--DWLayoutTable-->
		<tr bgcolor=cccccc><td width="609" height="29" align=center><h1><?=$row1['designer']?></h1></td></tr>
		
			<?php
			while ($row = mysql_fetch_array($result))
			{ ?>
				<tr align=center>
				<!--
				<td valign="top" align="center"><a href="edit_new_product_designer.php?cat_id=<?=$_GET['cat_id']?>&des_id=<?=$row1['des_id']?>&subcat_id=<?=@$row[subcat_id] ?>" class="pagelinks"><?=$row['subcat_name'];?></a></td>
				-->
				<td valign="top" align="center"><a href="csv_check.php?cat_id=<?=$_GET['cat_id']?>&des_id=<?=$row1['des_id']?>&subcat_id=<?=@$row[subcat_id] ?>" class="pagelinks"><?=$row['subcat_name'];?></a></td>
				</tr>
				<?php
			} ?>
			
		</table>
		
	</td></tr>
	</table>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>