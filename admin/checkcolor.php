<?
include("../common.php");
$color_id  = $_GET['color_id'];
$color_id1=explode("_",$color_id);
$cs2 = mysql_query("select * from tbl_product where FIND_IN_SET(".$color_id1[1].",colors)") or die(mysql_error());

				  
				  if(mysql_num_rows($cs2) == 0) {
				  
				  	echo 'You need to add images as per updated color.';
					  
				  }
				  ?>
