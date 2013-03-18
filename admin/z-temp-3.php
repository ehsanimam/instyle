<?php
/*
| ----------------------------------------------------------
| Getting the seque and making it the same for instyle and basix
*/
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	define('DESIGNER', 'Basix Black Lable');
	define('DES_ID', '5');
	define('SUBCAT_ID' ,'132');
	
	$host="localhost";
	$username="verjel";
	$password="icmstudio";
	$db="verjel_instyle";

$conn = mysql_connect($host,$username,$password);
mysql_select_db($db,$conn);

	$sel1 = "
		SELECT p.seque, p.primary_img_id, p.prod_no 
		FROM tbl_product p
			LEFT JOIN tblcat c ON c.cat_id = p.cat_id
			LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			LEFT JOIN designer d ON d.des_id = p.designer
			LEFT JOIN tblcolor tc ON tc.color_code = p.primary_img_id
			LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
		WHERE 
			(p.view_status = 'Y' OR p.view_status = 'Y1')
			AND p.cat_id = '1'
			AND p.designer = '".DES_ID."' 
			AND p.subcat_id = '".SUBCAT_ID."' 
			AND (
				p.clearance != 'Yes' 
				AND p.clearance != 'yes' 
				AND p.clearance != 'y' 
				AND p.clearance != 'Y' 
				AND p.clearance != 'clearance'
				AND p.clearance != 'Clearance'
			)
		ORDER BY prod_no
	";
	$qry1 = mysql_query($sel1);
	
	$i = 0;
	while ($res1 = mysql_fetch_array($qry1))
	{
		$instyle_ary[$i] = $res1['prod_no'];
		$i++;
		$instyle_ary[$i] = $res1['seque'];
		$i++;
	}
	unset($i);
	
mysql_close($conn);

	$host_remote="216.70.104.66";
	$username_remote="joe_taveras";
	$password_remote="!@R00+@dm!N";
	$db_remote="joe_moscow";

$conn = mysql_connect($host,$username,$password);
mysql_select_db($db,$conn);

	// update seque or primary_img_id at basix
	/*
	while($prod_no = current($instyle_ary))
	{
		$upd3 = "
			UPDATE tbl_product
			SET seque = '".next($instyle_ary)."'
			WHERE prod_no = '".$prod_no."'
		";
		$qry3 = mysql_query($upd3);
		next($instyle_ary);
	}
	*/
	
	$sel2 = "
		SELECT p.seque, p.primary_img_id, p.prod_no 
		FROM tbl_product p
			LEFT JOIN tblcat c ON c.cat_id = p.cat_id
			LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
			LEFT JOIN designer d ON d.des_id = p.designer
			LEFT JOIN tblcolor tc ON tc.color_code = p.primary_img_id
			LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
		WHERE 
			(p.view_status = 'Y' OR p.view_status = 'Y2')
			AND p.cat_id = '1'
			AND p.designer = '".DES_ID."' 
			AND p.subcat_id = '".SUBCAT_ID."' 
			AND (
				p.clearance != 'Yes' 
				AND p.clearance != 'yes' 
				AND p.clearance != 'y' 
				AND p.clearance != 'Y' 
				AND p.clearance != 'clearance'
				AND p.clearance != 'Clearance'
			)
		ORDER BY prod_no
	";
	$qry2 = mysql_query($sel2);
	
	$i = 0;
	while ($res2 = mysql_fetch_array($qry2))
	{
		$basix_ary[$i] = $res2['prod_no'];
		$i++;
		$basix_ary[$i] = $res2['seque'];
		$i++;
	}
	unset($i);
	
mysql_close($conn);

?>

	<table>
	<tr>
		<td>
		</td>
		<td>
			INSTYLE
		</td>
		<td>
			BASIX
		</td>
	</tr>
		<?php
		$a = count($instyle_ary); // 236
		$b = count($basix_ary); // 260
		$x = 0;
		$y = 0;
		$z = 1;
		while ($x < $a && $y < $b)
		{
			while ($instyle_ary[$x] !== $basix_ary[$y])
			{
				while ($instyle_ary[$x] < $basix_ary[$y])
				{
					if ($x < (236 - 1))
					echo '
						<tr>
						<td>'.$z.'</td>
						<td>'.$instyle_ary[$x].' - '.$instyle_ary[$x + 1].'</td>
						<td></td>
						</tr>
					';
					$x = $x + 2;
					$z++;
				}
				while ($instyle_ary[$x] > $basix_ary[$y])
				{
					echo '
						<tr>
						<td>'.$z.'</td>
						<td></td>
						<td>'.$basix_ary[$y].' - '.$basix_ary[$y + 1].'</td>
						</tr>
					';
					$y = $y + 2;
					$z++;
				}
			}
			
			echo '
				<tr>
				<td>'.$z.'</td>
				<td>'.$instyle_ary[$x].' - '.$instyle_ary[$x + 1].'</td>
				<td>'.$basix_ary[$y].' - '.$basix_ary[$y + 1].'</td>
				</tr>
			';
			$x = $x + 2;
			$y = $y + 2;
			$z++;
		}
		?>
	</table>
	