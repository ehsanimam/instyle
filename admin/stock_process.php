<?php 
session_start();
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
	//$row = 1;
	$columnheadings = 0;
	//$handle = fopen("csv/".strtolower($strFile1), "r");
	$i=0;
	$filecontents = file("$strFile1");
	//print_r($filecontents);
	for($i=$columnheadings; $i<sizeof($filecontents); $i++) {
	//while (($data = fgetcsv($handle, 10000, ",")) !== false) { 	
		    
			if($i == 0)
			{
				 $fields = $filecontents[0];
			}
		   else{
		   	$data =  explode(",", $filecontents[$i]);
			
			$prod_no	= $data[0];
			$color		= $data[1];
			$size		= $data[2];
			$qty		= $data[3];
			$date		= date("Y-m-d",time());
			
					   
		   $sql = "select * from tbl_stock where prod_no='".$prod_no."' and color_name='".$color."'";
		   $sql= mysql_query($sql);
		   $num_rows = mysql_num_rows($sql);
			   if($num_rows != 0)
			   {
					$insert_query="update tbl_stock set  
										size_".$size."		= '".$qty."' 
									where prod_no='".$prod_no."'
									and color_name='".$color."'";
				}
			   else
			   {
				   $insert_query="insert into tbl_stock 
				   					(prod_no,
									 color_name, 
									 stock_date, 
									 size_".$size.") 
								 VALUES ('".$prod_no."',
								 		'".$color."',
										'".$date."',
										'".$qty."'
										)";				 
				 } 
			  mysql_query($insert_query)or die(mysql_error());
			  $affected_rows = mysql_affected_rows();
		  }
		//$i++;
	}
	//fclose($handle);
	$file = strtolower($strFile1);
	unlink("$file");
	$GLOBALS["affected_rows"] = "Affected rows [".$affected_rows."]";
	if($err ==1)
	{
		echo "<script>window.location.href='upload-stock.php?msg=2'</script>"; 
	}
	else
	{
    	echo "<script>window.location.href='upload-stock.php?msg=1'</script>";
	} 
?>
