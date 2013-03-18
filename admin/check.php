<?
include("../common.php");
$lat=13;
echo $sql1="select * from tblright where which_page ='0' order by img_date DESC limit 1";
   $r=mysql_query($sql1);
	$idc=mysql_result($r,0,0);
	$d=date('Y-m-d');
echo "<br>";

echo   $sql="update tblright set img_name='$strFile1',
   			img_date='$d',
   			cat_id='$lat',
   			where Id='$idc'";
  //mysql_query($sql) or die("Error updating tbright");

  ?>