<?php
	include("../common.php");

	include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="333" class="tab" align="center" valign="middle">
	
	
	<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td>
	
		<?php
		if ( ! isset($_GET['cat_id']))
		{ ?>
			<table width=100% align=center cellspacing=2 cellpadding=2 >
			<!--DWLayoutTable-->
				<tr bgcolor=cccccc><td width="609" height="29" align=center><h1>Select Category</h1></td></tr>
				
				<?php 
				$select = "select * from tblcat where cat_name != 'New Arrivals' and cat_name != 'Clearance'";
				$result = mysql_query($select);
				
				while ($row = mysql_fetch_array($result))
				{ ?>
					<tr align=center>
						<td valign="top"><a href="display_new_product.php?cat_id=<?=@$row['cat_id'] ?>" class="pagelinks"><?=$row['cat_name'];?></a></td>
					</tr>
					<?php
				} ?>
			</table>
			<?php
		} ?>
		
	</td></tr>

	<tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2 >
		<!--DWLayoutTable-->
			<tr bgcolor=cccccc><td width="609" height="29" align=center><h1>Select Designer</h1></td></tr>
			
			<?php
			$select = "SELECT * FROM `designer` order by designer asc";
			if (isset($_GET['cat_id']) && $_GET['cat_id'] <> '')
			{
				$select = "SELECT * FROM `designer` where catid = '".$_REQUEST['cat_id']."' order by designer asc";
			}
			//echo $select;   
			$result = mysql_query($select);
			while ($row = mysql_fetch_array($result))
			{ ?>
				<tr align=center>
					<td valign="top"><a href="display_product_new_designer.php?cat_id=<?=@$row['catid']?>&des_id=<?=@$row['des_id'] ?>" class="pagelinks"><?=$row['designer'];?></a></td>
				</tr>
				<?php
			} ?>
			
		</table>
		
	</td></tr>
	</table>
	
</td></tr>
</table>
<? include 'footer.php'; ?>