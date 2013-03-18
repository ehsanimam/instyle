<?
function uplink_product_iamges($prod_id, $cnt)
{
	$nam='prod_image'.$cnt;
	$sel="select * from tblproduct where prod_id='$prod_id'";
	$result=mysql_query($sel);
	$row=mysql_fetch_array($result);
	$img=$row[$nam];

	if($img!='')
	{
		echo $file_name1="product_picture/$img";
		$file_name2="product_picture/medium/$img";
		$file_name3="product_picture/thumb/$img";
		$file_name4="product_picture/zoom/$img";
		$file_name5="product_picture/mini_thumb/$img";


		if(@file_exists($file_name1)) {unlink($file_name1);}
		if(@file_exists($file_name2)) {unlink($file_name2);}
		if(@file_exists($file_name3)) {unlink($file_name3);}
		if(@file_exists($file_name4)) {unlink($file_name4);}
		if(@file_exists($file_name5)) {unlink($file_name5);}
	}

}
?>