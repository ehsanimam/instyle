<?php
include("../common.php");
if (isset($_GET['d']))
{
	if ($_GET['d'] == '')
	{
		$sel2_xml = "SELECT * FROM tblsubsubcat";
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

		$sel = "SELECT subsubcats FROM tblsubcat WHERE ".$where;
		$qry = mysql_query($sel) or die('Selecting from tblsubcat Error - '.mysql_error());
		$res = mysql_fetch_array($qry);
		
		$where2 = 'id = ';
		$subsubcats_exp = explode(',', $res['subsubcats']);
		$c = count($subsubcats_exp);
		$i = 1;
		while ($subsubcat = current($subsubcats_exp))
		{
			if ($i < ($c - 1)) $where2 .= "'".$subsubcat."' OR id = ";
			else $where2 .= "'".$subsubcat."'";
			$i++;
			next($subsubcats_exp);
		}

		$sel2_xml = "SELECT * FROM tblsubsubcat WHERE ".$where2;
	}
}

if (isset($_GET['c']))
{
	if ($_GET['c'] == '')
	{
		$sel2_xml = "SELECT * FROM tblsubsubcat";
	}
	else
	{
		$sel2_xml = "SELECT * FROM tblsubsubcat WHERE cat_id = '".$_GET['c']."'";
	}
}

if (isset($_GET['s']))
{
	if ($_GET['s'] == '')
	{
		$sel2_xml = "SELECT * FROM tblsubsubcat";
	}
	else
	{
		$sel2_xml = "SELECT * FROM tblsubsubcat WHERE subcat_id = '".$_GET['s']."'";
	}
}

$qry2_xml = mysql_query($sel2_xml) or die('Get SubSubCategories Error - '.mysql_error());
?>
<select id="subcat" name="subcat_id">
	<option value="">All</option>
	<?php
	if (mysql_num_rows($qry2_xml) > 0)
	{
		while ($row2_xml = mysql_fetch_array($qry2_xml))
		{ ?>
			<option value="<?php echo $row2_xml['id']; ?>"><?php echo $row2_xml['name']; ?></option>
			<?php
		}
	} ?>
</select>
