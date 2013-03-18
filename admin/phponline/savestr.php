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

$ADMIDF = DayanaDec($HTTP_POST_VARS['admidf']);
$ADMPUF = DayanaDec($HTTP_POST_VARS['admpuf']);

if(!IsLoginValid($ADMIDF,$ADMPUF))
{
	echo "pr_s=s&gm_sema=2001&gm_status=".$CONF['conf_Msg13']."&pr_e=e";
	return;
}

$CONFS = array();
foreach($HTTP_POST_VARS as $k=>$v)
{
	if(substr($k,0,strlen("conf_Msg")) == "conf_Msg")
	{
		$CONFS[$k] = DayanaDec($v);
	}
}

$CondStr = "";
$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true) or die ('res=0');
mysql_select_db($DBDatabase,$dbh);
foreach($CONFS as $k=>$v)
{
	$v = str_replace("[nl]","\n",$v);
	$rv = mysql_query("UPDATE bvars SET bvalue=\"$v\" WHERE bname=\"$k\"",$dbh);
	if(mysql_affected_rows($dbh)==0 || $rv===false)
	{
		mysql_query("INSERT INTO bvars VALUES(\"$k\",\"$v\")",$dbh);
	}
}
mysql_close($dbh);


echo "pr_s=s&gm_sema=1&gm_status=".$CONF['conf_Msg45']."&pr_e=e";
return;


?>