<?php
 	include("../common.php");
	require("../phpscript/phpmailer/class.phpmailer.php"); // add this pages where email sending is used

	$mail = new PHPMailer();
	
	include("../phpscript/phpmailer/phpmailer_config.php");

	$mail->From = INFO_EMAIL;    //From Address -- CHANGE --
	$mail->FromName = SITE_NAME;    //From Name -- CHANGE --
	$mail->AddAddress("joe@innerconcept.com", "Joe Taveras");    //To Address -- CHANGE --
	$mail->AddReplyTo(INFO_EMAIL, SITE_NAME); //Reply-To Address -- CHANGE --

	$mail->WordWrap = 80;    // set word wrap to 50 characters
	$mail->IsHTML(true);    // set email format to HTML

	$mail->Subject = "SMTP.com Test";
	$mail->Body    = "SMTP.com Test Message!";

	if(!$mail->Send())
	{
	   echo "Message could not be sent. <p>";
	   echo "Mailer Error: " . $mail->ErrorInfo;
	   exit;
	}

	echo "Message has been sent";
?>