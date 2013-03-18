<?php
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/

	/*
	| ------------------------------------------------------------------------------
	| Shell command doesn't use the Global Variable like $_SERVER[]
	|
	| ----------------------------------
	| This serves as a class on its own
	| ----------------------------------
	*/
	
	ob_implicit_flush(); // ---> for debuggin purposes
	
	$host="localhost";
	$username="verjel";
	$password="icmstudio";
	$db="verjel_instyle";
	
	// ---> remote db
	// connect config to remote db
	$host_remote="64.207.150.168";
	$username_remote="joereyrusty_icm";
	$password_remote="!@R00+@dm!N";
	$db_remote="icmbasix_main";

	define('SITE_URL','https://www.instylenewyork.com/');
	define('IMG_REPO_URL', 'http://products.instylenewyork.com/');

	/*
	| ------------------------------------------------------------------------------
	| Connet to db
	*/
	$link = mysql_connect($host,$username,$password);
	mysql_select_db($db,$link);

	/*
	| ------------------------------------------------------------------------------
	| Global constants
	*/
	define('SITE_NAME','Instyle New York');
	define('SITE_DOMAIN','www.instylenewyork.com');
	define('INFO_EMAIL','info@instylenewyork.com');
	define('DEV1_EMAIL','rsbgm@innerconcept.com');
	define('DEV2_EMAIL','rusty@innerconcept.com');
	
	define('SINGLE_DESIGNER_SITE',FALSE); // ---> set TRUE for manufacturer sites
	define('DESIGNER',''); // ---> set designer name for url purposes when single_designer_site
	
	// smtp.com mailer info
	define('SMTP_HOST','instylenewyork.smtp.com');
	define('SMTP_UNAME','joe@innerconcept.com');
	define('SMTP_PWORD','inner@8775784000');
	
	define('MAIN_BODY_TITLE', 'NEW Items Sending');
	define('FILE_NAME_EXT', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('FILE_NAME', str_replace('.php', '', pathinfo(__FILE__, PATHINFO_BASENAME)));

	require_once("../phpscript/phpmailer/class.phpmailer.php");

/*
| ---------------------------------------------------------------
| Load models
*/

/*
| ---------------------------------------------------------------
| Load library
*/
	$send_count = 1;
	$err_email_count = 0;

	//$sel_emails = "SELECT email, firstname, lastname FROM tbluser_data_wholesale WHERE email = 'joe@innerconcept.com'"; // ---> dev purposes
	$sel_emails = "SELECT email, firstname, lastname FROM tbluser_data_wholesale WHERE is_active = '1'"; // --> production default
	$qry_emails = mysql_query($sel_emails) or die('Select Emails error:<br />'.mysql_error().'<br />'.$sel_emails);
	
	if (mysql_num_rows($qry_emails) > 0)
	{
		// for each user
		while ($row = mysql_fetch_array($qry_emails))
		{
			// trim possible whitespaces on email
			$email = trim($row['email']);
			
			// some defaults
			$subject = 'New Designs From Basix Black Label';
			
			// access default message content
			// included in the file is the query for the new items
			require ('sa_email_template.php');	//variable $email_content
			
			// -------------------------------
			// send sales package of new items
			// -------------------------------
			
			$mail = new PHPMailer();
			
			include("../phpscript/phpmailer/phpmailer_config.php");

			$mail->From = 'info@basixblacklabel.com';    //From Address -- CHANGE --
			$mail->FromName = 'BASIX BLACK LABEL';    //From Name -- CHANGE --
			$mail->AddAddress($email);    //To Address -- CHANGE --
			$mail->AddReplyTo('info@basixblacklabel.com', 'BASIX BLACK LABEL'); //Reply-To Address -- CHANGE --

			$mail->WordWrap = 80;    // set word wrap to 50 characters
			$mail->IsHTML(true);    // set email format to HTML

			while ($attach = current($attachment))
			{
				$mail->AddAttachment($attach);
				next($attachment);
			}
			
			$mail->Subject = $subject;
			$mail->Body    = $email_content;
			
			if ( ! $mail->Send())
			{
				// send email error to developers
				$error_msg = "
					Instylenewyork.com<br />
					<br />
					Messages could not be sent.<br />
					Sales Package Mailer Error: " . $mail->ErrorInfo . ".<br />
					Count sent out: " . $send_count . ".<br />
					Last email with error: " . $email . ". [*****]<br />
				";
				
				$mail = new PHPMailer();
				
				include("../phpscript/phpmailer/phpmailer_config.php");
				
				$mail->From = 'info@basixblacklabel.com';    //From Address -- CHANGE --
				$mail->FromName = FILE_NAME;    //From Name -- CHANGE --
				$mail->AddAddress('rsbgm@innerconcept.com');    //To Address -- CHANGE --
				$mail->AddAddress('rusty@innerconcept.com');    //To Address -- CHANGE --
				
				$mail->WordWrap = 80;    // set word wrap to 50 characters
				$mail->IsHTML(true);    // set email format to HTML

				$mail->Subject = 'New Items Sending - Sales Package Mailer Error';
				$mail->Body    = $error_msg;
				
				$mail->Send();
				
				$send_count--;
				$err_email_count++;
			}
			
			$send_count++;
		}
		
		// update new product items status to 4 for sent
		$upd_new_items_count_status_to_4 = "
			UPDATE new_items_count 
			SET
				status = '4',
				date_send = '".@date('Y-m-d',time())."'
			WHERE 
				status = '3' 
				AND des_id = '5'
		";
		$qry_new_items_count_status_to_4 = mysql_query($upd_new_items_count_status_to_4) or die('Select from new_items_count Error!<br />'.mysql_error().'<br />'.$upd_new_items_count_status_to_4);
		
		// send email notification to developers
		$success_msg = "
			Instylenewyork.com<br />
			<br />
			Sales Package of 10 new items sent.<br />
			Count sent out: ".($send_count - 1). ".<br />
		";
		
		$mail = new PHPMailer();
		
		include("../phpscript/phpmailer/phpmailer_config.php");
		
		$mail->From = 'info@basixblacklabel.com';    //From Address -- CHANGE --
		$mail->FromName = FILE_NAME_EXT;    //From Name -- CHANGE --
		$mail->AddAddress('rsbgm@innerconcept.com');    //To Address -- CHANGE --
		$mail->AddAddress('rusty@innerconcept.com');    //To Address -- CHANGE --
		$mail->AddBCC('info@instylenewyork.com');    //To Address -- CHANGE --
		
		$mail->WordWrap = 80;    // set word wrap to 50 characters
		$mail->IsHTML(true);    // set email format to HTML

		$mail->Subject = 'New Items Sending - Sales Package Mailer Success';
		$mail->Body    = $success_msg;
		
		$mail->Send();
	}
	
/*
| ---------------------------------------------------------------
| Load views
*/

	exit;