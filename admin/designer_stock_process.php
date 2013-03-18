<?php 
session_start();
//set_time_limit(500);
//ini_set("display_errors",1);

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
	
			if($i == 0)
			{
				 $fields = $filecontents[0];
			}
		   else 
		   {
		   $data =  explode(",", $filecontents[$i]);
		   $sqlp2 = "select * from tblcolor where color_name='$data[2]'";
		   $qryp2= mysql_query($sqlp2);
		   $row2 = mysql_fetch_array($qryp2);
		   $color_id = $row2['color_id'];
		   
		   $sqlp3 = "select * from tbl_product where prod_no='$data[1]'";
		   $qryp3= mysql_query($sqlp3);
		   $row3 = mysql_fetch_array($qryp3);
		   $prod_id= $row3['prod_id'];
		   
		   $sqlp1 = "select * from tbl_stock where prod_id='$prod_id'";
		   $qryp1= mysql_query($sqlp1);
		    $num_rows1 = mysql_num_rows($qryp1);
			   if($num_rows1!=0)
			   {
					 $import="update tbl_stock set size_0='".$data[3]."',size_2='".$data[4]."',size_4='".$data[5]."',size_6='".$data[6]."',size_8='".$data[7]."',size_10='".$data[8]."',size_12='".$data[9]."',size_14='".$data[10]."',size_16='".$data[11]."',size_xs='".$data[12]."',size_s='".$data[13]."',size_m='".$data[14]."',size_l='".$data[15]."',size_xl='".$data[16]."' where prod_id='$prod_id' and cs_id='$color_id'";
				}
			 
			  mysql_query($import);
		  }
		//$i++;
	}
	//fclose($handle);	
	$file = strtolower($strFile1);
	unlink("$file");
	$GLOBALS["message"] = "Stock has been successfully updated";
    if($err ==1)
	{
		echo "<script>window.location.href='upload_designer_stock.php?msg=2'</script>"; 
	}
	else
	{
    	echo "<script>window.location.href='upload_designer_stock.php?msg=1'</script>";
	}
?>
