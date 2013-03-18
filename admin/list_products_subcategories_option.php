<?php
include("../common.php");
if (isset($_GET['d']))
{
	if ($_GET['d'] == '')
	{
		$sel2_xml = "SELECT * FROM tblsubcat";
	}
	else
	{
		$sel_xml = "SELECT subcats FROM designer WHERE des_id = '".$_GET['d']."'";
		$qry_xml = mysql_query($sel_xml) or die('Get Categories Error - '.mysql_error());
		$res_xml = mysql_fetch_array($qry_xml);

		$where = 'subcat_id = ';
		$subcats_exp = explode(',', $res_xml['subcats']);
		$c = count($subcats_exp);
		$i = 1;
		while ($subcat = current($subcats_exp))
		{
			if ($i < ($c - 1)) $where .= "'".$subcat."' OR subcat_id = ";
			else $where .= "'".$subcat."'";
			$i++;
			next($subcats_exp);
		}

		$sel2_xml = "SELECT * FROM tblsubcat WHERE ".$where;
	}
}

if (isset($_GET['c']))
{
	if ($_GET['c'] == '')
	{
		$sel2_xml = "SELECT * FROM tblsubcat";
	}
	else
	{
		$sel2_xml = "SELECT * FROM tblsubcat WHERE cat_id = '".$_GET['c']."'";
	}
}

$qry2_xml = mysql_query($sel2_xml) or die('Get Categories Error - '.mysql_error());
?>
<select id="subcat" name="subcat_id">
	<option value="">All</option>
	<?php
	if (mysql_num_rows($qry2_xml) > 0)
	{
		while ($row2_xml = mysql_fetch_array($qry2_xml))
		{ ?>
			<option value="<?php echo $row2_xml['subcat_id']; ?>"><?php echo $row2_xml['subcat_name']; ?></option>
			<?php
		}
	} ?>
</select>
