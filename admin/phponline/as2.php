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

$CCode = FilterString($HTTP_GET_VARS['ccode'],'NUMBER');
$LanguageSel = FilterString($HTTP_GET_VARS['language_sel'],'WORD');
$AdmID = FilterString($HTTP_GET_VARS['admid'],'WORD');


$TTime = get_microtime();

$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true) or die ('res=0');
mysql_select_db($DBDatabase,$dbh);

$TTM = (1*time())-432000;
mysql_query("DELETE FROM msgdb WHERE ttime<$TTM",$dbh);
mysql_query("DELETE FROM cs WHERE lastact<$TTM",$dbh);
mysql_query("UPDATE cs SET assign=1 WHERE ccode=$CCode",$dbh);
mysql_close($dbh);


?>


<HTML>
<HEAD>
<meta http-equiv=Content-Type content="text/html;  charset=ISO-8859-1">
<TITLE>phpOnline - Admin side chat script</TITLE>
</HEAD>
<BODY bgcolor="#FFFFFF">
<?php
	echo phpOnlineGetFlashCode('asc','?ccode='.$CCode.'&language_sel='.$LanguageSel.'&admid='.$AdmID.'&ct='.$TTime);
?>
</BODY>
</HTML>