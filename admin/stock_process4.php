<?php 
session_start();
echo "START5"; 
include("../common.php");
include("security.php");

?>
<html>
	<head>
		<title></title>
	</head>
<body>
	<center><h1>Please wait ... do not refresh this page.</h1></center>
</body>	
</html>
<?php
	$strFile1 = 'csv/'.$_GET['file'];
//	$strfile1 = 'csv/  
	//$row = 1;
	$columnheadings = 0;
	echo ">>>".$strFile1;
	//$handle = fopen("csv/".strtolower($strFile1), "r");
	$i=0;
	//$filecontents = file("$strFile1");
	//print_r($filecontents);
	
$filename = $strFile1;

if (file_exists($filename)) {
    //echo "The file $filename exists";
} else {
    echo "The file $filename does not exist";
	exit;
}	
	
	
	
	$file_handle = fopen($strFile1, "r");
$i=0;
  $data = fgetcsv($file_handle, 1024);	
while (!feof($file_handle) )
 {
			$i = $i + 1;

		    echo $i."<br>";

		   {
			   //$data =  explode(",", $filecontents[$i]);
			   $data = fgetcsv($file_handle, 1024);
			   if(!empty($data[0])) {						
						$product_no   	= @$data[0];
						$product_name	= @$data[1];
						$designer		= @$data[2];
						$category		= @$data[3];
						$date			= @$data[5];
						$catalogue		= @$data[6];
						$retail			= @$data[7];
						$primary_img_id	= @$data[8];
						$subcategory	= @$data[9];
						$size			= @$data[10];
						$qty			= @$data[11];						
						$color		  	= @$data[8];
						$product_desc   = @$data[13];

echo "#".$i.">>>".$product_name.":".$product_no.":".$view_status.":".$cat_id.":".$subcat_id.":".$date.":".$product_desc.":".$catalogue.":".$retail.":".$des_id.":".$cs_code.":<br>";

if ($i>10) { exit;}
						
						
						$get_color    	 = @mysql_fetch_array(mysql_query("SELECT * FROM tblcolor WHERE color_name = '".$color."'")) or die(mysql_error());
						$cs_id		 	 = $get_color['color_id'];	
						$cs_code		 = $get_color['color_code'];	
						
						$get_product     = mysql_query("SELECT * FROM tbl_product WHERE prod_no = '".$product_no."'") or die(mysql_error());
						if(@mysql_num_rows($get_product)>0) {
							$get_product 	= @mysql_fetch_array($get_product);
							$prod_id	 	= $get_product['prod_id'];	
						} else {
							$prod_id	 	= '';
						}
						
						$get_designer    = @mysql_fetch_array(mysql_query("SELECT * FROM designer WHERE designer = '".$designer."'")) or die(mysql_error());
						$des_id		 	 = $get_designer['des_id'];	
						
						$get_category    = @mysql_fetch_array(mysql_query("SELECT * FROM tblcat WHERE cat_name = '".$category."'")) or die(mysql_error());
						$cat_id		 	 = $get_category['cat_id'];					
						
						$get_subcategory = @mysql_fetch_array(mysql_query("SELECT * FROM tblsubcat WHERE subcat_name = '".$subcategory."'")) or die(mysql_error());
						$subcat_id		 = $get_subcategory['subcat_id'];	
						
						
						



						// PRODUCTS
						$chk_product  = @mysql_query("SELECT * FROM tbl_product WHERE prod_no='".$product_no."'") or die(mysql_error()); 
						
						if(@mysql_num_rows($chk_product) > 0) {
							//update	
							$product_number = @mysql_fetch_array($chk_product);					
							@mysql_query("UPDATE tbl_product SET prod_no      	 = '".$product_no."',
																 prod_name    	 = '".$product_name."',
																 view_status  	 = '".$view_status."',
																 prod_date	  	 = '".$date."',
																 prod_desc    	 = '".$product_desc."',
																 catalogue_price = '".$catalogue."',
																 less_discount   = '".$retail."',
																 designer		 = '".$des_id."'
										  WHERE
										  	prod_no = '".$product_number['prod_no']."'
																");
						} else {
							//insert
							$view_status = empty($catalogue) ? 'N' : 'Y';
							@mysql_query("INSERT INTO tbl_product (prod_name,prod_no,view_status,cat_id,subcat_id,
																	prod_date,prod_desc,catalogue_price,less_discount,
																	designer,primary_img_id) 
																VALUES 
																  ('".$product_name."','".$product_no."','".$view_status."','".$cat_id."','".$subcat_id."',
																  	'".$date."','".$product_desc."','".$catalogue."','".$retail."',
																	'".$des_id."','".$cs_code."')
																  ");
						}
						
						// STOCKS										
						$chk_stock	  = @mysql_query("SELECT * FROM tbl_stock WHERE prod_id = '".$prod_id."' AND cs_id='".$cs_id."'") or die(mysql_error());
						
						if(empty($prod_id)) {
							$prod_id = @mysql_insert_id();
						} else {
							$prod_id = $prod_id;
						}
																							
						if(@mysql_num_rows($chk_stock) > 0) {
							//update
							if($size == 0) {
								@mysql_query("UPDATE tbl_stock SET size_0='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							} elseif($size == 2) {
								@mysql_query("UPDATE tbl_stock SET size_2='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							} elseif($size == 4) {
								@mysql_query("UPDATE tbl_stock SET size_4='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							} elseif($size == 6) {
								@mysql_query("UPDATE tbl_stock SET size_6='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							} elseif($size == 8) {
								@mysql_query("UPDATE tbl_stock SET size_8='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							} elseif($size == 10) {
								@mysql_query("UPDATE tbl_stock SET size_10='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							} elseif($size == 12) {
								@mysql_query("UPDATE tbl_stock SET size_12='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							} elseif($size == 14) {
								@mysql_query("UPDATE tbl_stock SET size_14='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							} elseif($size == 16) {
								@mysql_query("UPDATE tbl_stock SET size_16='".$qty."' WHERE prod_id='".$prod_id."' AND cs_id='".$cs_id."'");
							}
							
						} else {
							//insert
							if($size == 0) {
								@mysql_query("INSERT INTO tbl_stock (size_0, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							} elseif($size == 2) {
								@mysql_query("INSERT INTO tbl_stock (size_2, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							} elseif($size == 4) {
								@mysql_query("INSERT INTO tbl_stock (size_4, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							} elseif($size == 6) {
								@mysql_query("INSERT INTO tbl_stock (size_6, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							} elseif($size == 8) {
								@mysql_query("INSERT INTO tbl_stock (size_8, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							} elseif($size == 10) {
								@mysql_query("INSERT INTO tbl_stock (size_10, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							} elseif($size == 12) {
								@mysql_query("INSERT INTO tbl_stock (size_12, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							} elseif($size == 14) {
								@mysql_query("INSERT INTO tbl_stock (size_14, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							} elseif($size == 16) {
								@mysql_query("INSERT INTO tbl_stock (size_16, prod_id, cs_id) VALUES ('".$qty."', '".$prod_id."', '".$cs_id."')");
							}
						}
						
			   }
			   
			  
			}
	}
	 
	 
	//=============
	// STOCKS 
	//=============
	
	 
	 
	//$file = strtolower($strFile1);
	//unlink("$file");
	fclose($file_handle);
	//die('end');
	if($err ==1)
	{
		echo "<script>window.location.href='upload-stock.php?msg=2'</script>"; 
	}
	else
	{
    	echo "<script>window.location.href='upload-stock.php?msg=1'</script>";
	}
?>
