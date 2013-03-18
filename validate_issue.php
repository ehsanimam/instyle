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
$xupdateemail = $_GET['receive_productupd'];
$recieve_update = $xupdateemail == 1 ? 'Yes' : 'No';

if ($_GET['user_email'] != "")
{
	$user_name = $xname;
	$password = 'instyle2011';
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
		  create_date,isregistered) values ('".$user_name."','".$user_name."','".$password."'
		  ,'".$email."','".$access."', now() , ".$isr.")";
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
		$sq = "insert into tbluser_data(firstname,lastname,state_province,email,dresssize,password) 
			values ('".$xname."','".$xname."','".$xstate."','".$xemail."','".$xsize."','".$password."')";
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
		
		///////////////header("Location: collection.php?log=1");
		$sql_log = "INSERT INTO `tbl_login_detail` (`user_id`,`session_id`,`create_date`,`create_time`,`email`) VALUES ('".$rowss['user_id']."','".session_id()."',CURDATE(),CURTIME(),'".$rowss['e_mail']."')";
		mysql_query($sql_log);
	}
//==========================================================================================
		$to = 'info@issuenewyork.com';
		$subject = 'Special sale on Basix Black Label';
		$from ='info@issuenewyork.com';
		/*$message = '<html><body><p>Welcome '.$xfname.'</p>
			<br />
			<p>Instylenewyork.com is the authorized on line reseller for Basix Black Label </p>
			<p> </p>
			<p></p>
			<p>Please use the information below to validate your account for our special sales going on now</p>
			<p>------------------------------------------------------------ </p>
			<p><strong>YOUR LOGIN INFORMATION</strong></p>
			<p><strong>Username:'.$email.'<br />
			  Password:instyle2011</strong></p>
			<p></strong>Click on link to validate and login automatically:</strong></p>
			<p><a href="www.instylenewyork.com/validate.php?user_email='.$email.'">www.instylenewyork.com/validate.php</a>
			</p>
			<br />
			<p><strong>or copy and paste the following URL to the URL address box of your browser if the link above cannot link you automatically</strong></p>
			<p>www.instylenewyork.com/validate.php?user_email='.$email.'</p>
			<p>------------------------------------------------------------ </p>
			<br />
			<p>For more information or further assistance, please call us at 212.840.0846<br />
			  or email info@instylenewyork.com. You can also chat live with us by going to<br />
			</p>

			<p>www.instylenewyork.com between 9am and 6pm M-F EST</p>
			<br />
			<br />
			<br />
			<div align="left">In Style New York , 230 West 38th Street, New York, NY 10018<br />
			  Phone: 212-840-0846 Email: info@instylenewyork.com<br />
			  Copyright 2011 instylenewyork.com
			</div></body></html>
		';*/
	
		$headers = "From: info@issuenewyork.com\nReply-To: info@issuenewyork.com"; 
		//$headers .= 'MIME-Version: 1.0' . "\r\n"; 
		$headers .= "Content-Type: text/html; charset=us-ascii\r\n"; 	
		
		
			//sending email to info@issuenewyork.com
		      $email_message = '<table border="0" cellspacing="0" cellpadding="5">
								<tr><td>Name:</td><td>'.$xname.'</td></tr>
								<tr><td>E-mail Address:</td><td>'.$xemail.'</td></tr>
								<tr><td>Dress Size:</td><td>'.$xsize.'</td></tr>
								<tr><td>State/Province:</td><td>'.$xstate.'</td></tr>
								<tr><td>Recieve update</td><td>'.$recieve_update.'</td></tr>						
							</table>
							 ';		
		
		//$headers = "From: $from\r\n";
		//$headers .= "Reply-To: ". strip_tags($_POST['$from']) . "\r\n";
		//$headers .= "CC: info@instylenewyork.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to, $subject, $email_message, $headers);
	   
//==========================================================================================
   
		$message="";
		$message.="<TABLE border=0 cellSpacing=0 cellPadding=0 width=650 align=center><TBODY><TR><td bgColor=#efefef background=http://instylenewyork.com/images/newsletter/inlogobasix.jpg width=630 height=47></td></tr><tr><p><br><strong>Welcome ".$xfname.",</strong></p><div><br><p><font color='#FF0000'><strong>Instylenewyork.com is the on line store for Basix Black Label.</strong></font><br><br><p></p><p><strong>YOUR LOGIN INFORMATION</strong></p>Username: ".$email."<br>Password: instyle2011</p><p><br><a href='http://www.instylenewyork.com/validate.php?user_email=".$email."' target='_blank'>CLICK HERE TO VALIDATE ACCOUNT AND SHOP FOR LESS</a></p><div><div><p>or copy and paste the following URL to the URL address box of your browser if the link above cannot link you automatically</p><p>http://www.instylenewyork.com/validate.php?user_email='$email'</p><br /><p>For more information or further assistance, please call us at 212.840.0846<br />  or email info@instylenewyork.com. You can also chat live with us by going to<br /></p><p>www.instylenewyork.com between 9am and 6pm M-F EST</p><br /><p>Click the link below to remove your email address from our database<br><a href='http://www.instylenewyork.com/remove.php?user_email=".$email."' target='_blank'>Remove Account</a><br /><br />In Style New York , 230 West 38th Street, New York, NY 10018<br />  Phone: 212-840-0846 Email: info@instylenewyork.com<br />  Copyright 2011 instylenewyork.com</tr></TBODY></TABLE>";
	
		$to1 = $email;
		$subject1 = "ISSUE NEW YORK COCKTAIL AND EVENING DRESS ACCOUNT PASSWORD";
  
		$headers1 = 'From:info@issuenewyork.com'."\r\n".
		$headers1.= 'Reply-To:info@issuenewyork.com'."\r\n";
		$headers1.= 'CC: info@instylenewyork.com'."\r\n";
        $headers1.= "Content-Type: text/html; charset=us-ascii"."\r\n" ;

		// mail($to1, $subject1, $message, $headers1);
	   
		/*
		require_once 'lib/swift_required.php';
		$transport = Swift_MailTransport::newInstance('localhost', 25);
		$mailer = Swift_Mailer::newInstance($transport);
		
		$body = $message;
		$message = Swift_Message::newInstance('BASIX BLACK LABEL COCKTAIL AND EVENING DRESS ACCOUNT PASSWORD ')
				  ->setFrom(array('info@basixblacklabel.com' => 'Basix Black Label'))
				  ->addTo($to1,''.$xfname.'')
				  ->setBody($body, 'text/html');
		$mailer->send($message);
		*/
	   
//=========================================================================================		   

		header("Location: http://www.instylenewyork.com/issuenewyork.html");
}
	if($a['title']!=""){$mytitle = $a['title'];}else{$mytitle="Online Luxury Shopping Below Retail Pricing at Instylenewyork.com";}

	if($a['description']!=""){$mydesc = $a['description'];}else{$mydesc="Visit instylenewyork.com for Apparel for Her featuring new collections from top designers.  instylenewyork.com  has fashions top names in clothing, shoes, jewelries, bridal, collections and accessories for women, men, and kids.";}

	if($a['keyword']!=""){$mykey = $a['keyword'];}else{$mykey="InStyle New York,InCircle,prada,bcbg,marc jacobs,chloe,frye,juicy couture,manolo blahnik,isabella fiore,eileen fisher,kate spade,vera wang,stuart weitzman,catherine malandrino,rock and republic,burberry,Theory,seven jeans,trina turk,dior,dana buchman,lacoste,tory by trb,yves saint laurent, instylenewyork.com";}
	//===================================End Meta code area==============================================
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?=$mydesc;?>" />
<meta name="keywords" content="<?=$mykey;?>" />
<meta name="author" content="Pla" />
<meta name="subject" content="<?php echo SITE_NAME; ?>" />
<meta name="coverage" content="worldwide" />
<meta name="Content-Language" content="english" />
<meta name="resource-type" content="document" />
<meta name="robots" content="all,index,follow" />
<meta name="classification" content="<?php echo SITE_NAME; ?>" />
<meta name="rating" content="general" />
<meta name="revisit-after" content="10 days" />
		<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
		<link rel="stylesheet" href="js/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		
		
<link href="style/main.css" rel="stylesheet" type="text/css"/>
<link href="style/style_b.css" rel="stylesheet" type="text/css"/>
<link href="style/style.css" rel="stylesheet" type="text/css"/>
<link href="style/shippingcart.css" rel="stylesheet" type="text/css">
<title><?php //$mytitle; ?> Online Luxury Shopping Below Retail Pricing at <?php echo SITE_DOMAIN; ?></title>
</head>

<body>



	
</body>
</html>
