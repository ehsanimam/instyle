<?php 
session_start();
//set_time_limit(500);
//ini_set("display_errors",1);

include("../common.php");
include("security.php");
include('../functionsadmin.php');

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
		    $err =0;
			if($i == 0)
			{
				 $fields = $filecontents[0];
			}
		   else{
		   	$data =  explode(",", $filecontents[$i]);
			
			$rancode = 'wait'.RandomNumber(6);
			
			$sql = "select * from tbluser where e_mail='$data[0]'";
			$qry = mysql_query($sql);
			if(mysql_num_rows($qry)==0)
			{
				$uname = $data[4].' ' .$data[5];
				$insert_query="insert into tbluser(`uname`,`user_name`,`user_password`,`e_mail`,`access_level`,`disc_percent`,region,`create_date`,`isregistered`) values('".$uname."','".$uname."','".$data[1]."','".$data[0]."','Level 0','".$data[2]."','".$data[3]."',CURDATE(),'1')";
				
			  	mysql_query($insert_query);
				$user_id= mysql_insert_id();
				
				$insert_query1="insert into tbluser_data(user_id,firstname,lastname,company,telephone,cellphone,fax,address1,address2,country,city,state_province, 	zip_postcode,email,receive_productupd,register_status,dresssize) values('".$user_id."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."','".$data[14]."','".$data[15]."','".$data[0]."','1','".$rancode."','".$data[16]."')";
			  	mysql_query($insert_query1);
				
				
				$insert_query2="insert into tblemail_subscribe(email_addr,create_date) values('".$data[0]."',CURDATE())";
			  	//mysql_query($insert_query2);
				
				
				
 $strbody="";
  $strbody.="
	  <table width='60%' border='0' align='center' cellpadding='0' cellspacing='0'>          
	  <tr>
		  <td width='33%' height='25' >First Name :</td>
		  <td width='67%'>{$data[4]}</td>
		</tr>
		  <tr>
		  <td width='33%' height='25' >Last Name :</td>
		  <td width='67%'>{$data[5]}</td>
		</tr>	
		<tr>
		  <td width='33%' height='25' >Dress Size :</td>
		  <td width='67%'>{$data[6]}</td>
		</tr>
		<tr>
		  <td height='25' >Cell :</td>
		  <td>{$data[7]} </td>
		</tr>
		  <tr>
		  <td height='25' >Cell :</td>
		  <td>{$data[8]} </td>
		</tr>
		<tr>
		  <td height='25' >Fax :</td>
		  <td>{$data[9]}</td>
		</tr>
		<tr>
		  <td height='25' >Address 1 :</td>
		  <td>{$data[10]}</td>
		</tr>
		<tr>
		  <td height='25' >Address 2 :</td>
		  <td>{$data[11]}</td>
		</tr>
		  <tr>
		  <td height='25' >Country :</td>
		  <td>{$data[12]}</td>
		</tr>
		<tr>
		  <td height='25' >City :</td>
		  <td>{$data[13]}</td>
		</tr>
		<tr>
		  <td height='25' >State :</td>
		  <td>{$data[14]}</td>
		</tr>
		<tr>
		  <td height='25' >Zip/Postal Code :</td>
		  <td>{$data[15]}</td>
		</tr>
		<tr>
		  <td height='25' >Email :</td>
		  <td>{$data[0]}</td>
		</tr>
		<tr>
		  <td height='25' >Password :</td>
		  <td>{$data[1]}</td>
		</tr>
		 <tr>
		  <td colspan=2>[$y_n] Would you like to receive email updates from In Style New York ?  </td>
		</tr>
		 <tr bgcolor='#0099FF'>
			  <td colspan=2>Approve (Click Yes or No)</td>
		</tr>
		<tr>
			  <td height='25' >
				<a href='http://www.instylenewyork.com/admin/approve_reg.php?user_id=".$user_id."&say=yes'>Yes</a>			
		  </td>
			  <td>
				<a href='http://www.instylenewyork.com/admin/approve_reg.php?user_id=".$user_id."&say=no'>No</a>			
		  </td>
		</tr>
	  </table>
	  
	  
	  " ;
   $message="";
  $message.="Dear ".$uname.",<div><p>Welcome to Instyle Newyork.You are one step away from completing your registration.<br>Your username and password:<br>Username: ".$data[0]."<br>Password: ".$data[1]."</p><p>Click the link below to activate your account:<a href='http://instylenewyork.com/activate.php?user_id=".$user_id."' target='_blank'>http://instylenewyork.com/activate.php?user_id=".$user_id."</a></p><div><div><p>If the link above is not active, simply copy and paste to your browser address window.</p><p>Thanks,<br>Instyle Newyork Team.<br><br>";
  

  
  
  //echo $strbody;
  	$to="info@instylenewyork.com";
	$subject = "Registration Form";
	$body= $strbody;
	
	
	$to1=$data[0];
	$subject1 = "Automated Response";
	
	
	
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	$headers .= "From:".$to1. "\r\n";
	
	$headers1  = "MIME-Version: 1.0" . "\r\n";
	$headers1 .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	$headers1 .= "From:".$to. "\r\n";
	//mail($to, $subject, $body, $headers);
	//mail($to1, $subject1, $message, $headers1);
	
  	
			}
			else
			{
				$err=1;
			}
		  }
		//$i++;
	}
	//fclose($handle);	
	$file = strtolower($strFile1);
	unlink("$file");
	$GLOBALS["message"] = "User has been successfully added";
    if($err ==1)
	{
		echo "<script>window.location.href='upload-user.php?msg=2'</script>"; 
	}
	else
	{
    	echo "<script>window.location.href='upload-user.php?msg=1'</script>";
	}
?>
