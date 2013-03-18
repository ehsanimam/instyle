<?
include("../common.php");
$cs_id = $_GET['cs_id'];
$query=mysql_query("select * from tbl_color_size where cs_id=".$cs_id);
if(@mysql_num_rows($query)>0) {
$csrow=mysql_fetch_array($query);

?>
 <table width="576" border="0" cellspacing="5" cellpadding="0" class="text">
					  <tr>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>0</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>2</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>4</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>6</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>8</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>10</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>12</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>14</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>16</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>XS</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>S</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>M</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>L</strong> </td>
						<td width="7%" style="border-bottom:1px solid #999;"><strong>XL</strong> </td>
					  </tr>
					  <tr>
						<td><?=$csrow['size_0']?></td>
						<td><?=$csrow['size_2']?></td>
						<td><?=$csrow['size_4']?></td>
						<td><?=$csrow['size_6']?></td>
						<td><?=$csrow['size_8']?></td>
						<td><?=$csrow['size_10']?></td>
						<td><?=$csrow['size_12']?></td>
						<td><?=$csrow['size_14']?></td>
						<td><?=$csrow['size_16']?></td>
						<td><?=$csrow['size_xs']?></td>
						<td><?=$csrow['size_s']?></td>
						<td><?=$csrow['size_m']?></td>
						<td><?=$csrow['size_l']?></td>
						<td><?=$csrow['size_xl']?></td>
					  </tr>
					</table>
<?php } else { ?>
No stock/sizes selected
<?php } ?>