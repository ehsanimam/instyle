<?php

/*****************************************************************
phpOnline - Online customer support system
Copyright (C) 2003-2006 
Dayana Networks Ltd. <phponline@dayanahost.com>
Farhad Malekpour <fm@farhad.ca>
All rights reserved.

Official Website	http://phponline.dayanahost.com
Online Forums       http://www.dayanahost.com/forum
Powered by          http://www.dayanahost.com

Translation service provided by Google Inc.

THE USE OF THIS SOFTWARE IS COMPLETELY AT YOUR OWN RISK!

--------------------------- GNU License ---------------------------

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*****************************************************************/

include_once('noca.php');
include_once('rcq.php');

$PName = DayanaDec($HTTP_POST_VARS['pname']);
$PEmail = DayanaDec($HTTP_POST_VARS['pemail']);
$PMsg = DayanaDec($HTTP_POST_VARS['pmsg']);


$to  = $CONF['conf_GEmailAddress'];
$subject = $CONF['conf_GEmailSubject'];

if($CONF['conf_PlainTextEmail']==1)
{
	$PMsg = str_replace(array(chr(92).chr(39),chr(92).chr(34)),array(chr(39),chr(34)),$PMsg);
	$PMsg = htmlspecialchars($PMsg);
	$PMsg = str_replace("&amp;","&",$PMsg);
	$message  = "Name: $PName\n";
	$message .= "Email: $PEmail\n";
	$message .= "------------------------------------------------------------\n";
	$message .= "$PMsg\n";
	$message .= "------------------------------------------------------------\n";
	$message .= "Powered by phpOnline v".$phpOnlineVer."\n";
}
else
{
	$PName2 = utf8_encode($PName);
	$PMsg = str_replace(array(chr(92).chr(39),chr(92).chr(34)),array(chr(39),chr(34)),$PMsg);
	$PMsg = nl2br(htmlspecialchars($PMsg));
	$PMsg = str_replace("&amp;","&",$PMsg);
	$PMsg = utf8_encode($PMsg);
	$message = "<html><head><title>$subject</title></head><body><P>Name: $PName2<BR>Email: $PEmail<br>------------------------------------------------------------</p><P>$PMsg</p><p>------------------------------------------------------------<br>Powered by phpOnline v".$phpOnlineVer."</p></body></html>";

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
}

$PEmail = str_replace(array("\n","\r","\n\r",";","<",">"),"",$PEmail);
$PName = str_replace(array("\n","\r","\n\r",";","<",">"),"",$PName);

$headers .= "From: $PName<$PEmail>\r\n";

$PMailStatus = 0;
if(mail($to, $subject, $message, $headers))
{
	$PMailStatus = 1;
}
else
{
	$PMailStatus = 2;
}


echo "pr_s=s&pmailstatus=$PMailStatus&pr_e=e";


?>