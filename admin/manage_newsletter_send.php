<?php
	ob_implicit_flush(); // --> for debugging purposes
	
	if ($_SERVER['SERVER_NAME'] === 'localhost')
	{
		include("../common.php");
		require_once("../phpscript/phpmailer/class.phpmailer.php"); // add this pages where email sending is used
	}
	else
	{
		include("/var/www/vhosts/instylenewyork.com/httpdocs/common.php");
		require_once("/var/www/vhosts/instylenewyork.com/httpdocs/phpscript/phpmailer/class.phpmailer.php"); // add this pages where email sending is used
		//include("../common.php");
		//require_once("../phpscript/phpmailer/class.phpmailer.php"); // add this pages where email sending is used
	}
	
	// The Query
	$q = mysql_query("
		SELECT 
			tn.*, tn.group_id as group_id,
			teg.*
		FROM 
			tbl_newsletter tn
		LEFT JOIN 
			tbl_email_group teg
			ON teg.group_id = tn.group_id
		WHERE
			status = '0'
	") or die('Query error: '.mysql_error());
	
	$exp_now = explode('/',@date('m/d/Y',@time()));
	$time_now = @mktime(0,0,0,$exp_now[0],$exp_now[1],$exp_now[2]);
	
	if (mysql_num_rows($q))
	{
		while ($r = mysql_fetch_array($q))
		{
			if ($r['datesend'] != '' && $r['datesend'] != NULL)
			$time_db = $r['datesend'];
			else $time_db = '';
			
			if ($time_db == $time_now)
			{
				$data = array(
					'emails' => $r['emails'],
					'newsletter_id' => $r['newsletter_id'],
					'title' => $r['title'],
					'subject' => $r['subject'],
					'message' => $r['message'],
					'group_name' => $r['group_name']
				);

				// send newsletter function
				$send = _send_newsletter($data);
			}
			else
			{
				$send = FALSE;
			}
		}
	}
	
	function _send_newsletter($r)
	{
		if ($r['emails'] == 'All' OR $r['emails'] == 'Wholesale' OR $r['emails'] == 'Consumer')
		{
			if ($r['emails'] == 'All')
			{
				$q_emails = "SELECT email FROM tbluser_data WHERE receive_productupd = '1' UNION SELECT email from tbluser_data_wholesale";
			}
			else if ($r['emails'] == 'Wholesale')
			{
				$q_emails = "SELECT email FROM tbluser_data_wholesale";
			}
			else if ($r['emails'] == 'Consumer')
			{
				$q_emails = "SELECT email FROM tbluser_data WHERE receive_productupd = '1' limit 20000, 15000";
			}
			
			$r_emails = mysql_query($q_emails) or die('Select union error: '.mysql_error());
			$emails = array();
			$i = 0;
			while ($email_row = mysql_fetch_array($r_emails))
			{
				$emails[$i] = $email_row['email'];
				$i++;
			}
			//$emails = array('rsbgm@innerconcept.com'); // ---> for debugging purposes
		}
		else
		{
			// explode comma sepaerate email addresses
			$emails = explode(',',$r['emails']);
		}
		
		// ----> debugging tools
		/*
		echo '<br />'.count($emails);
		echo '<br />';
		//print_r($emails);
		$send_count = 0;
		while ($email = current($emails))
		{
			echo $email.' - ';
			$send_count++;
			next($emails);
		}
		echo '<br />'.$send_count;
		die();
		*/
		
		$send_count = 1;
		$err_email_count = 0;
		while ($email = current($emails))
		{
			// trim possible whitespaces and hashing email for optout link
			$email = trim($email);
			$opt_out_email = md5(DEV1_EMAIL.'-'.$email);
			
			// append message with optout link
			$msg_content = '
			<table id="wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#333333;">
			<tr><td align="center">
			
				<table id="container" border="0" cellpadding="0" cellspacing="0" width="660" style="background:#efefef;">
					<tr>
						<td id="top_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px;">
							If you are unable to see this message, <a href="'.str_replace('https','http',SITE_URL).'newsletter/'.$r['newsletter_id'].'/'.$opt_out_email.'" style="color:white;">Click here</a> to view.<br />
							To ensure delivery to your inbox, please add info@instylenewyork.com to your address book. 
						</td>
					</tr>
			';
			$msg_content .= $r['message'];
			$msg_content .= '
					<tr>
						<td id="bottom_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px 20px 20px;">
							To adjust your email preferences or to unsubscribe from email advertisements from '.SITE_DOMAIN.', please <a href="'.SITE_URL.'register/opt_out/'.$opt_out_email.'" style="color:white;">Click here</a>.<br />
							'.SITE_NAME.', 230 West 38th Street, New York, NY 10018
						</td>
					</tr>
					
				</table> <!--#container-->
			
			</td></tr>
			</table> <!--#wrapper-->
			';
			
			if ($_SERVER['SERVER_NAME'] === 'localhost')
			{
				$mail = new PHPMailer();
				
				include("../phpscript/phpmailer/phpmailer_config.php");

				$mail->From = INFO_EMAIL;    //From Address -- CHANGE --
				$mail->FromName = SITE_NAME;    //From Name -- CHANGE --
				$mail->AddAddress($email);    //To Address -- CHANGE --
				$mail->AddReplyTo(INFO_EMAIL, SITE_NAME); //Reply-To Address -- CHANGE --

				$mail->WordWrap = 80;    // set word wrap to 50 characters
				$mail->IsHTML(true);    // set email format to HTML

				$mail->Subject = $r['subject'];
				$mail->Body    = $msg_content;

				if(!$mail->Send())
				{
				   echo "Message could not be sent. <p>";
				   echo "Mailer Error: " . $mail->ErrorInfo;
				   exit;
				}
			}
			else
			{
				$mail = new PHPMailer();
				
				include("/var/www/vhosts/instylenewyork.com/httpdocs/phpscript/phpmailer/phpmailer_config.php");
				//include("../phpscript/phpmailer/phpmailer_config.php");

				$mail->From = 'info@basixblacklabel.com';    //From Address -- CHANGE --
				$mail->FromName = 'BASIXBLACKLABEL.COM';    //From Name -- CHANGE --
				$mail->AddAddress($email);    //To Address -- CHANGE --
				$mail->AddReplyTo('info@basixblacklabel.com', 'BASIXBLACKLABEL.COM'); //Reply-To Address -- CHANGE --

				$mail->WordWrap = 80;    // set word wrap to 50 characters
				$mail->IsHTML(true);    // set email format to HTML

				$mail->Subject = $r['subject'];
				$mail->Body    = $msg_content;

				if(!$mail->Send())
				{
					echo "Message could not be sent. ";
					echo "Newsletter Mailer Error: " . $mail->ErrorInfo . ". ";
					echo "Count sent out: " . $send_count . ". ";
					echo "Last email with error: " . $email . ". [*****] ";
					
					$send_count--;
					$err_email_count++;
					
					$u_qry1 = "
						UPDATE tbluser_data 
						SET 
							is_active = '0', 
							receive_productupd = '0'
						WHERE
							email = '".$email."'
					";
					$u_run1 = mysql_query($u_qry1);
					
					$u_qry2 = "
						UPDATE tbluser 
						SET 
							received_produpdate = '0'
						WHERE
							e_mail = '".$email."'
					";
					$u_run2 = mysql_query($u_qry2);
					
					//exit;
				}
			}
			
			$send_count++;
			next($emails);
		}
		
		// Update status of newsletter to 1
		/*
		$update_table = mysql_query("
			UPDATE tbl_newsletter
			SET status = '1'
			WHERE newsletter_id = '".$r['newsletter_id']."'
		") or die('Update error: '.mysql_error());
		*/
		
		//echo 'Updated status of newsletter<br />';

		// notify admin of newsletter scheduled sending when done
		$subj = 'Scheduled Newsletter Sent';
		$msg = '<br />
			Newsletters were sent today as per schedule.
			<br />
			Details as follows:
			<br /><br />
			Title: '.$r['title'].'<br />
			Subject: '.$r['subject'].'<br />
			Send to Group: '.$r['group_name'].'
			<br /><br />
			Total sent out: '.$send_count.'
			<br /><br />
			Emails with errors: '.$err_email_count.'
		';
		
		$info_email = INFO_EMAIL;
		//$info_email = DEV1_EMAIL; // ---> for debugging purposes
		
		if ($_SERVER['SERVER_NAME'] === 'localhost')
		{
			$mail = new PHPMailer();
			
			include("../phpscript/phpmailer/phpmailer_config.php");
			
			$mail->From = INFO_EMAIL;    //From Address -- CHANGE --
			$mail->FromName = SITE_NAME;    //From Name -- CHANGE --
			$mail->AddAddress($info_email);    //To Address -- CHANGE --
			$mail->AddReplyTo(INFO_EMAIL, SITE_NAME); //Reply-To Address -- CHANGE --
			
			$mail->WordWrap = 80;    // set word wrap to 50 characters
			$mail->IsHTML(true);    // set email format to HTML

			$mail->Subject = $subj;
			$mail->Body    = $msg;

			if(!$mail->Send())
			{
				echo "Message could not be sent. <p>";
				echo "Mailer Error: " . $mail->ErrorInfo;
				exit;
			}
		}
		else
		{
			$mail = new PHPMailer();
			
			include("/var/www/vhosts/instylenewyork.com/httpdocs/phpscript/phpmailer/phpmailer_config.php");
			//include("../phpscript/phpmailer/phpmailer_config.php");
			
			$mail->From = INFO_EMAIL;    //From Address -- CHANGE --
			$mail->FromName = SITE_NAME;    //From Name -- CHANGE --
			$mail->AddAddress($info_email);    //To Address -- CHANGE --
			$mail->AddAddress(DEV1_EMAIL);    //To Address -- CHANGE --
			$mail->AddAddress(DEV2_EMAIL);    //To Address -- CHANGE --
			$mail->AddReplyTo(INFO_EMAIL, SITE_NAME); //Reply-To Address -- CHANGE --

			$mail->WordWrap = 80;    // set word wrap to 50 characters
			$mail->IsHTML(true);    // set email format to HTML

			$mail->Subject = $subj;
			$mail->Body    = $msg;

			if(!$mail->Send())
			{
				echo "Message could not be sent. <p>";
				echo "Mailer Error: " . $mail->ErrorInfo;
				exit;
			}
		}
		
		return TRUE;
	}
	
	if ($send) echo 'Newsletter Sent Today';
	else echo 'Nothing to send today';
