<?php
include("../common.php");

if (isset($_POST['cmd_cat_submit']))
{
	$st_id = $_REQUEST['st_id'];
	
	@mysql_query("UPDATE tbl_stock SET size_0 = '".(int)$_POST['size_0']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	@mysql_query("UPDATE tbl_stock SET size_2 = '".(int)$_POST['size_2']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	@mysql_query("UPDATE tbl_stock SET size_4 = '".(int)$_POST['size_4']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	@mysql_query("UPDATE tbl_stock SET size_6 = '".(int)$_POST['size_6']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	@mysql_query("UPDATE tbl_stock SET size_8 = '".(int)$_POST['size_8']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	@mysql_query("UPDATE tbl_stock SET size_10 = '".(int)$_POST['size_10']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	@mysql_query("UPDATE tbl_stock SET size_12 = '".(int)$_POST['size_12']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	@mysql_query("UPDATE tbl_stock SET size_14 = '".(int)$_POST['size_14']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	@mysql_query("UPDATE tbl_stock SET size_16 = '".(int)$_POST['size_16']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
	
	if ($_SERVER['SERVER_NAME'] !== 'localhost') // --> change 'localhost' to your local dev environment server
	{
		switch ($_POST['des_id'])
		{
			case '5':
				// connet to remote db
				$conn = mysql_connect($host_remote,$username_remote,$password_remote);
				mysql_select_db($db_remote,$conn);
				
				@mysql_query("UPDATE tbl_stock SET size_0 = '".(int)$_POST['size_0']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				@mysql_query("UPDATE tbl_stock SET size_2 = '".(int)$_POST['size_2']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				@mysql_query("UPDATE tbl_stock SET size_4 = '".(int)$_POST['size_4']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				@mysql_query("UPDATE tbl_stock SET size_6 = '".(int)$_POST['size_6']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				@mysql_query("UPDATE tbl_stock SET size_8 = '".(int)$_POST['size_8']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				@mysql_query("UPDATE tbl_stock SET size_10 = '".(int)$_POST['size_10']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				@mysql_query("UPDATE tbl_stock SET size_12 = '".(int)$_POST['size_12']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				@mysql_query("UPDATE tbl_stock SET size_14 = '".(int)$_POST['size_14']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				@mysql_query("UPDATE tbl_stock SET size_16 = '".(int)$_POST['size_16']."' WHERE st_id = '".$st_id."'") or die(mysql_error());
				
				// close remote db connection
				mysql_close($conn);
			break;
		}
	}

	echo "
		<script>
			location.href='edit_product_details.php?prod_no=".$_REQUEST['prod_no']."';
		</script>
	";
}

include 'top.php'; 

$row = @mysql_fetch_array(mysql_query("SELECT
														tp.prod_no, tp.prod_id, tp.cat_id, 
														d.folder as designer_folder, subcat.folder AS subcat_folder, tcs.color_name,tcs.color_code,tp.prod_no,
														ts.size_0, ts.size_2, ts.size_4, ts.size_6, ts.size_8, ts.size_10, ts.size_12, ts.size_14, ts.size_16, ts.st_id,
														case cat.cat_id
														  when '1'
															then 'WMANSAPREL'
														  when '19'
															then 'JWLRYACCSRIES'
														  when '22'
															then 'BRIDAL'
														  when '23'
															then 'CLRNCE'
														  else 'WMANSAPREL'
														end as cat_folder,
														cat.cat_name AS category, subcat.subcat_name AS subcategory,
														d.designer, d.des_id
														FROM
														  tbl_product tp
														  LEFT JOIN designer d ON d.des_id=tp.designer
														  LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
														  LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
														  LEFT JOIN tbl_stock ts ON ts.prod_no = tp.prod_no
														  LEFT JOIN tblcolor tcs ON tcs.color_name = ts.color_name
														WHERE
														  ts.st_id ='".$_REQUEST['st_id']."'")) or die(mysql_error());
			
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	<h1>EDIT STOCK </h1>
	
	<form name="faq" action="edit_stock.php?<?=$_SERVER['QUERY_STRING']?>" method="post">
                    <table width=70% border="0" cellspacing=2 cellpadding=2>
                    <tr><td class="text" width="130" align="left"><strong>Product number:</strong> </td><td align="left" class="text"><?=$row['prod_no']?></td></tr>
                    <tr><td class="text" align="left"><strong>Style number:</strong> </td><td class="text" align="left"><?=$row['prod_no']?></td></tr>
                     <tr><td class="text" align="left"><strong>Category:</strong> </td><td class="text" align="left"><?=$row['category']?></td></tr>
                      <tr><td class="text" align="left"><strong>Subcategory:</strong> </td><td class="text" align="left"><?=$row['subcategory']?></td></tr>
                       <tr><td class="text" align="left"><strong>Designer:</strong> </td><td class="text" align="left"><?=$row['designer']?></td></tr>
                        <tr><td class="text" align="left"><strong>Color:</strong> </td><td class="text" align="left"><?=$row['color_name']?></td></tr>
                    <tr><td class="text" colspan="2"><br />
                    <table width="100%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;border:1px solid #999;">
							<tr style="background:#ddd;">
								<?php
								if ($row['cat_id'] != '19')
								{ ?>
                                    <td><strong>Size 0</strong></td>
                                    <td><strong>Size 2</strong></td>
                                    <td><strong>Size 4</strong></td>
                                    <td><strong>Size 6</strong></td>
                                    <td><strong>Size 8</strong></td>
                                    <td><strong>Size 10</strong></td>
                                    <td><strong>Size 12</strong> </td>
                                    <td><strong>Size 14</strong></td>
                                    <td><strong>Size 16</strong></td>
									<?php
								}
								else
								{ ?>
									<td><strong>Qty</strong></td>
									<?php
								} ?>
							</tr>
							<tr>
								<?php
								if ($row['cat_id'] != '19')
								{ ?>
									<td><input type="text" name="size_0" style="width:30px;" maxlength="4" value="<?=$row['size_0']?>" /></td>
                                    <td><input type="text" name="size_2" style="width:30px;" maxlength="4" value="<?=$row['size_2']?>" /></td>
                                    <td><input type="text" name="size_4" style="width:30px;" maxlength="4" value="<?=$row['size_4']?>" /></td>
                                    <td><input type="text" name="size_6" style="width:30px;" maxlength="4" value="<?=$row['size_6']?>" /></td>
                                    <td><input type="text" name="size_8" style="width:30px;" maxlength="4" value="<?=$row['size_8']?>" /></td>
                                    <td><input type="text" name="size_10" style="width:30px;" maxlength="4" value="<?=$row['size_10']?>" /></td>
                                    <td><input type="text" name="size_12" style="width:30px;" maxlength="4" value="<?=$row['size_12']?>" /></td>
                                    <td><input type="text" name="size_14" style="width:30px;" maxlength="4" value="<?=$row['size_14']?>" /></td>
                                    <td><input type="text" name="size_16" style="width:30px;" maxlength="4" value="<?=$row['size_16']?>" /></td>
									<?php
								}
								else
								{ ?>
									<td><input type="text" name="size_0" style="width:30px;" maxlength="2" value="<?=$row['size_0']?>" /></td>
									<?php
								} ?>
							</tr>
					</table><br />
					
					<input type="hidden" name="des_id" value="<?=$row['des_id']?>" />
					
					<input type="submit" name="cmd_cat_submit" value="Update"> 
                    <input type="button" name="cmd_cat_cancel" value="Cancel" onClick="window.location='edit_product_details.php?prod_no=<?=$_REQUEST['prod_no']?>'"> 
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>