<?php 
//session_start();
echo "START0"; 
include("../common.php");
//include("security.php");

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
	$strFile1 = 'csv/ring_sizes.csv';
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
 // $data = fgetcsv($file_handle, 1024);	
while (!feof($file_handle) )
 {
			$i = $i + 1;
            $pubx = 'Y';
		    echo $i."<br>";

					   //$data =  explode(",", $filecontents[$i]);
			   $data = fgetcsv($file_handle, 1024);
			   if(!empty($data[0])) {						
						$dia_in   	= @$data[0];
						$dia_mm  	= @$data[1];
						$cir_in 	= @$data[2];
						$cir_mm		= @$data[3];
						$awan		= @$data[4];
						$size_name	= @$data[5];

						$sq = "INSERT INTO tblsize (size_name, bust, waist, hip, dia_in, dia_mm,cir_in,cir_mm)
				VALUES ('".$size_name."','0','0','0','".$dia_in."','".$dia_mm."','".$cir_in."','".$cir_mm."')";
							echo $sq;
							//exit;										
							@mysql_query($sq);
							}
}							
						
?>
