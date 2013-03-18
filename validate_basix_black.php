<?php 
	
include("common.php");
  
$session_id = session_id();


	//===================================Meta code area==============================================
$thispage = substr($_SERVER["PHP_SELF"],6,strlen($_SERVER["PHP_SELF"]));
list($thisfilename,$thissurname) = explode('[/.-]',$thispage,2);
//list($thisfilename,$thissurname) = split('[/.-]',$thispage,2);
$Strmet = sprintf("SELECT * FROM `tblmeta` WHERE `pagename`='%s' limit 1", $thisfilename);
$aobj =mysql_query($Strmet);
$a = mysql_fetch_array($aobj);

$xemail = $_GET['user_email'];
$xname = $_GET['user_name'];
$xstate = $_GET['user_state'];
$xsize = $_GET['user_size'];
$url = $_GET['url'];
$type = $_GET['type'];
$xupdateemail = $_GET['receive_productupd'];
$recieve_update = $xupdateemail == 1 ? 'Yes' : 'No';
$site = $_GET['from'];


if($type == 'Consumer')
{	
	if ($_GET['user_email'] != "")
	{
		$user_name = $xname;
		$password = 'basix';
		$email = $xemail;
		$access = 'Level 0';

		$query = "select * from tbluser where e_mail = '".$xemail."'";
		$result = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($result);
		$rowss = mysql_fetch_array($result);
	
		if ($num_result == 0)
			{
				// Insert into tbluser
				$isr = '1';
				$sq = "insert into tbluser(uname,user_name,user_password,e_mail,access_level,
		  		create_date,isregistered,received_produpdate) values ('".$user_name."','".$user_name."','".$password."'
		  		,'".$email."','".$access."', now() , ".$isr.",'1')";
				@mysql_query($sq) or die(mysql_error());
			}
		else
			{
				// Update tbluser
				$sq = "update tbluser set isregistered = '1' where e_mail = '".$email."'";
				@mysql_query($sq) or die(mysql_error());		  
			}

		$query = "select * from tbluser_data where email='".$_GET['user_email']."'";
		$result = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($result);
		$rowss = mysql_fetch_array($result);
	
		if ($num_result == 0)
			{
				// Insert into tbluser_data
				$sq = "insert into tbluser_data(firstname,lastname,state_province,email,dresssize,password,receive_productupd,is_active,site_ini) 
				values ('".$xname."','".$xname."','".$xstate."','".$xemail."','".$xsize."','".$password."','1',1,'basix')";
				@mysql_query($sq) or die(mysql_error());
			}

		$query = "select * from tbluser where e_mail='".$_GET['user_email']."' and isregistered=1";
		$result = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($result);
		$rowss = mysql_fetch_array($result);

		if ($num_result > 0)
			{
				$SesId=session_id();
				$admin_id=session_id();
				$session_admin=$admin_id;
				$_SESSION['userid'] = $rowss['user_id'];
				$_SESSION['name']=$rowss['user_name'];
				$_SESSION['username']=$rowss['e_mail'];
		
		
				$sql_log = "INSERT INTO `tbl_login_detail` (`user_id`,`session_id`,`create_date`,`create_time`,`email`) VALUES ('".$rowss['user_id']."','".session_id()."',CURDATE(),CURTIME(),'".$rowss['e_mail']."')";
		mysql_query($sql_log);
			}
  
	if($url == 'registerforsale/sent.html')
		header("Location: http://www.basixblacklabel.com/".$url);
	else
		header("Location: http://www.instylenewyork.com/".$url);
	//header("Location: http://www.basixblacklabel.com/".$url); // ---> temp redirect when instyle was compromised
	
	}
}

else
{
	if ($_GET['user_email'] != "")
	{
		$user_name = $xname;
		$password = 'basix';
		$email = $xemail;
		$access = 'Level 0';

		$query = "select * from tbluser_data_wholesale where email = '".$email."'";
		$result = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($result);
		$rowss = mysql_fetch_array($result);
	
		if ($num_result == 0)
			{
				// Insert into tbluser_data_wholesale
				$isr = '0';
				$sq = "insert into tbluser_data_wholesale(email,pword,firstname,create_date,access_level,is_active) values ('".$email."','".$password."','".$user_name."', now() ,'".$access."', ".$isr.")";
				@mysql_query($sq) or die(mysql_error());
				
				if($site == 'basix')
				{
					$site = 'Basix Black Label';
				}
				
				// start Email...........................
				$subject = "Wholesale Registration At Instyle New York";
				$email1 = "info@instylenewyork.com";
				$message="";
				$message.='The following just registered for wholesale info at Instyle New York
					<br />
					Registration From '.$site.' Inquiry
					<br />
					<table border="0" cellspacing="0" cellpadding="5">	
						<tr><td>Username:</td><td>'.$email.'</td></tr>
						<tr><td>Name:</td><td>'.$user_name.'</td></tr>
						<tr><td>Store Name:</td><td></td></tr>
					</table>
					<br />
					Click <a href="http://localhost/websites/instyle/admin/user_edit_popup_wholesale.php?eid='.$email.'&control=admin">here</a> to see his profile and activate or deny.
					<br /><br />
					Details are as follows:
					<table border="0" cellspacing="0" cellpadding="5">
						<tr><td>Email:</td><td>'.$email.'</td></tr>
						<tr><td>Password:</td><td>'.$password.'</td></tr>
						<tr><td>Store Name:</td><td></td></tr>
						<tr><td>First & Last Names:</td><td>'.$user_name.'</td></tr>
						<tr><td>Federal Tax ID:</td><td></td></tr>
						<tr><td>Address 1:</td><td></td></tr>
						<tr><td>Address 2:</td><td></td></tr>
						<tr><td>City:</td><td></td></tr>
						<tr><td>Country:</td><td></td></tr>
						<tr><td>State:</td><td></td></tr>
						<tr><td>Zipcode:</td><td></td></tr>
						<tr><td>Telephone:</td><td></td></tr>
						<tr><td>Fax:</td><td></td></tr>
					</table> ';
		
				//$headers  = "MIME-Version: 1.0\r\n";
				$headers.= "Content-type: text/html; charset=iso-8859-1\r\n";

				//$headers .= "To: Instyle New York<no-reply@www.instylenewyork.com>\r\n";
				//$headers.= "From: <info@instylenewyork.com>\r\n";
				$headers.= "Bcc: rsbgm@innerconcept.com";
		
				$headers = 'From: info@instylenewyork.com'. "\r\n".
					"Content-Type: text/html; charset=us-ascii\r\n";
			
					
				mail($email1, $subject, $message, $headers);
			// End Email...............................		
			}

		$query = "select * from tbluser_data_wholesale where email='".$email."'";
		$result = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($result);
		$rowss = mysql_fetch_array($result);

		if ($num_result > 0)
			{
				$SesId=session_id();
				$admin_id=session_id();
				$session_admin=$admin_id;
				$_SESSION['userid'] = $rowss['user_id'];
				$_SESSION['name']=$rowss['firstname'];
				$_SESSION['username']=$rowss['email'];
		
		
				$sql_log = "INSERT INTO `tbl_login_detail_wholesale` (`user_id`,`session_id`,`create_date`,`create_time`,`email`) VALUES ('"			.$rowss['user_id']."','".session_id()."',CURDATE(),CURTIME(),'".$rowss['email']."')";
		mysql_query($sql_log);
			}
  
	
	header("Location: http://www.instylenewyork.com/wholesale/register.html");
	
	}	
	
}
?>

