<?php

session_start();
include("../common.php");
$q=$_GET["q"];



$sql="select * from tblsubcat where cat_id='".$q."'";

$result = mysql_query($sql);
?>

<select name="subcat">
				  	<option value=""></option>
                    <?php
					$sq = "select * from tblsubcat where cat_id='".$q."'";
					$get_subcategory = @mysql_query($sq);
					if(mysql_num_rows($get_subcategory) > 0) {
						while($rowx1 = mysql_fetch_array($get_subcategory)) {
							?> 
							<option value="<?=$rowx1['subcat_id']?>" <?php echo $rowx1['subcat_id']==$_SESSION['subcat'] ? 'selected' : ''; ?>><?=$rowx1['subcat_name']?></option>
							<?
						}
					}
					?>
				   </select>
<?php
mysql_close($con);
?>