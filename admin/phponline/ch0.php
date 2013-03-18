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
$IP = $HTTP_SERVER_VARS["REMOTE_ADDR"];
$NickName = $HTTP_POST_VARS["nickname"];
$Email = $HTTP_POST_VARS["email"];
$LanguageSel = $HTTP_POST_VARS['language_sel'];


$TTime = gmdate("U");

if($NickName=='')
	$NickName = 'Guest';


if($CCode == "")
{
	$CCode = time() . rand(111111,999999);
	setcookie("ocode", $CCode, time()+31536000);
}

$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true) or die ('res=0');
mysql_select_db($DBDatabase,$dbh);

$IsFind = 0;
$res = mysql_query("SELECT * FROM cs WHERE ccode=$CCode",$dbh);
while ($row = mysql_fetch_array($res)) 
{
	$IsFind = 1;
}
mysql_free_result($res);

$CSCode1 = 0;
foreach($TransLangs as $TI=>$LG)
{
	if($LG[0]==$LanguageSel)
	{
		$CSCode1 = $TI;
		break;
	}
}


if($IsFind ==0)
{
	mysql_query("INSERT INTO cs VALUES('$CCode',0,0,'$IP',$CSCode1,0,$TTime,'$NickName','$Email','')",$dbh);
}
else
{
	mysql_query("UPDATE cs SET online=0,assign=0,ip='$IP',lastact=$TTime,code1=$CSCode1,name='$NickName',email='$Email' WHERE ccode=$CCode",$dbh);
}

mysql_close($dbh);
SetPStatus("1");

$GCN = urlencode(ucwords($CONF['conf_GCompanyName']));

echo "pr_s=s&ccode=$CCode&cass=0&compname=$GCN&pr_e=e";


?>