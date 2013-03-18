<?php
include("../common.php");
if ($_GET['d'] == '')
{
	$sel2_xml = "SELECT * FROM tblcat";
}
else
{
	$sel_xml = "SELECT catid FROM designer WHERE des_id = '".$_GET['d']."'";
	$qry_xml = mysql_query($sel_xml) or die('Get Categories Error - '.mysql_error());
	$res_xml = mysql_fetch_array($qry_xml);
	
	$sel2_xml = "SELECT * FROM tblcat WHERE cat_id = '".$res_xml['catid']."'";
}

$qry2_xml = mysql_query($sel2_xml) or die('Get Categories Error - '.mysql_error());
?>
<select id="cat" name="cat_id" onchange="getSubcat('<?php echo $url_pre; ?>', 'admin/list_products_subcategories_option.php'); goSpin();">
	<?php
	echo $_GET['d'] == '' ? '<option value="all">All</option>' : '';
	if (mysql_num_rows($qry2_xml) > 0)
	{
		while ($row2_xml = mysql_fetch_array($qry2_xml))
		{
			if ($row2_xml['cat_id'] != '23')
			{ ?>
				<option value="<?php echo $row2_xml['cat_id']; ?>"><?php echo $row2_xml['cat_name']; ?></option>
				<?php
			}
		}
	} ?>
</select>
