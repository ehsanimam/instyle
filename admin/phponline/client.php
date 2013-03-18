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

$CCode = FilterString($HTTP_COOKIE_VARS['ocode'],'NUMBER');

if($CCode == "")
{
	$CCode = time() . rand(111111,999999);
	setcookie("ocode", $CCode, time()+31536000);
}

?>
<HTML>
<HEAD>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name="Description" content="Live Customer Support, Free live support, free 24x7 live customer support">
<TITLE>phpOnline - Live Customer Support</TITLE>
</HEAD>

<BODY bgcolor="#F8F8F8" topmargin="0" leftmargin="0">

<!-- URL's used in the movie-->
<!-- 
http://phponline.dayanahost.com/ 
-->
<!-- text used in the movie-->
<!-- 
phpOnline
Live Customer Support
Free Online Support 
-->
<!--Please wait while we redirect you to a costomer service representative-->

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber3" height="100%">
  <tr>
	<td width="100%" align="center">

<table border="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111" width="100" id="AutoNumber1">
  <tr>
	<td width="100%">
	<img border="0" src="images/cs2_r2_c2.gif" width="517" height="43"></td>
  </tr>
  <tr>
	<td width="100%">
	<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2">
	  <tr>
		<td width="11">
		<img border="0" src="images/cs2_r3_c2.gif" width="17" height="230"></td>
		<td align="center">
		<?php 
			echo phpOnlineGetFlashCode('cs'); 
		?>
		</td>
		<td width="15">
		<img border="0" src="images/cs2_r3_c4.gif" width="23" height="230"></td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr>
	<td width="100%">
	<img border="0" src="images/cs2_r4_c2.gif" width="517" height="26"></td>
  </tr>
</table>

<?php
if(IsLicensed()==false)
{
?>
	<p><font face="Verdana" size="1">phpOnline has designed and provided by <a href="http://www.dayanahost.com/" target="_blank">Dayana Host</a><br>If you are interested to have a customer support system like this,<br>Please visit <a target="_blank" href="http://phponline.dayanahost.com">
	http://phponline.dayanahost.com</a></font>
<?php
}
?>    
	
	</td>
  </tr>
</table>

</BODY>
</HTML>